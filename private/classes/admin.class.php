<?php

class Admin extends DatabaseObject {
    static protected $table_name = "admins";

    static protected $db_columns = ['id', 'first_name', 'last_name', 'email', 'username', 'hashed_password'];

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    protected $hashed_password;
    public $password;
    public $confirm_password;

    public function __construct($args = []) {
        $this->first_name = $args['first_name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->password = $args['password'] ??  '';
        $this->confirm_password = $args['confirm_password'] ??  '';
    }

    public function full_name() {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function set_hashed_password() {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    protected function create() {
        $this->set_hashed_password();
        return parent::create();
    }
    
    protected function update() {
        $this->set_hashed_password();
        return parent::update();
    }

    protected function validate() {
    
        $this->errors = [];
    
        if(is_blank($this->first_name)) {
          $this->errors[] = "First name cannot be blank";
        } elseif (!has_length($this->first_name, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "First name must be between 2 and 255 characters.";
        }
    
        if(is_blank($this->last_name)) {
          $this->errors[] = "Last name cannot be blank";
        } elseif (!has_length($this->first_name, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "First name must be between 2 and 255 characters.";
        }

        if(is_blank($this->email)) {
            $this->errors[] = "Email cannot be blank";
        } elseif (!has_length($this->email, array("max" => 255))) {
            $this->errors[] = "Email must be no more than 255 characters";
           // Check that the email is well-formed.
        } elseif(!has_valid_email_format($this->email)) {
            $this->errors[] = "That does not appear to be a valid email address.";
        }

        if(is_blank($this->username)) {
            $this->errors[] = "Username cannot be blank";
        } else if(!has_length($this->username, array('min' => 8, 'max' => 255))) {
            $this->errors[] = 'Username must be between 8 and 255 characters';
        }

        if (empty($password)) {
            $this->errors[] = "Password cannot be blank";
        } elseif (strlen($password) < 8) {
            $this->errors[] = "Password must be at least 8 characters long";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $this->password)) {
            $this->errors[] = "Password must contain at least one lowercase letter, one uppercase letter, and one digit";
        }
    
        return $this->errors;
      }
    
    }