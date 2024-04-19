<?php

class DatabaseObject {
    static protected $database;
    static protected $table_name = '';
    static protected $columns = [];
    public $errors = [];

    static public function set_database($database) {
        self::$database = $database;
      }
    
      static public function find_by_sql($sql) {
        $result = self::$database->query($sql);
        if(!$result) {
          exit("Database query failed");
        } 
        //result in object
        $object_array = [];
    
        while($record = $result->fetch_assoc()) {
          $object_array[] = self::instantiate($record);
        }
        $result->free();
    
        return $object_array;
      }
    
      static public function find_all() {
        $sql = "SELECT * FROM bicycles";
        return self::find_by_sql($sql);
      }
    
      static public function find_by_id($id) {
        $sql = "SELECT * FROM bicycles WHERE id = " . self::$database->escape_string($id);
        $obj_array = self::find_by_sql($sql);
        
        if (!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }
      
      static protected function instantiate($record) {
        $object = new self;
    
        foreach($record as $property => $value) {
          if(property_exists($object, $property)) {
            $object->$property = $value;
          }
        }
        return $object;
      }
    
      protected function validate() {
    
        $this->errors = [];
    
        if(is_blank($this->brand)) {
          $this->errors[] = "Brand cannot be blank";
        }
    
        if(is_blank($this->model)) {
          $this->errors[] = "Model cannot be blank";
        }
    
        return $this->errors;
      }
    
      public function create() {
        $this->validate();
        if(!empty($this->errors)) { return false; }
        $this->validate();
        if(!empty($this->errors)) { return false; }
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO bicycles (" . join(', ', self::$db_columns) . ") VALUES ('" . join("', '", array_values($attributes)) . "')";
        echo $sql;
        $result = self::$database->query($sql);
        if ($result) {
            $this->id = self::$database->insert_id;
        }
        return $result;
    }
    
      protected function update() {
      $this->validate();
      if(!empty($this->errors)) { return false; }
      
      $attributes = $this->sanitized_attributes();
      $attribute_pairs = [];
      foreach($attributes as $key => $value) {
        $attribute_pairs[] = "{$key} = '{$value}'";
      }
      $sql = "UPDATE bicycles SET ";
      $sql .= join(", ", $attribute_pairs);
      $sql .= " WHERE id = " . self::$database->escape_string($this->id);
      $sql .= " LIMIT 1";
      $result = self::$database->query($sql);
      return $result;
    }
    
    public function save() {
      if(isset($this->id)) {
        return $this->update();
      } else {
        return $this->create();
      }
    }
    
    public function delete() {
      $sql = "DELETE FROM bicycles ";
      $sql .= "WHERE id = '". self::$database->escape_string( $this->id) ."'";
      $sql .= " LIMIT 1";
      $result = self::$database->query($sql);
      return $result;
    }
    
    public function merge_attributes($args = []) {
      foreach($args as $key => $value) {
        if(property_exists($this, $key) && !is_null($value)) {
          $this->$key = $value;
        }
      }
    }
    
    // Properties which have database columns excluding id
    public function attributes() {
        $attributes = [];
        foreach (self::$db_columns as $column) {
            if ($column == $attributes['id']) { continue; }
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }
    
    protected function sanitized_attributes(){
      $sanitized = [];
      foreach($this->attributes() as $key => $value) {
        $sanitized[$key] = self::$database->escape_string($value);
      }
      return $sanitized;
    }
}