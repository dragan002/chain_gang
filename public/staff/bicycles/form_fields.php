<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($bicycle)) {
  redirect_to(url_for('/staff/bicycles/index.php'));
}
?>

<dl>
  <dt>Brand</dt>
  <dd><input type="text" name="brand" value="" /></dd>
</dl>

<dl>
  <dt>Model</dt>
  <dd><input type="text" name="model" value="" /></dd>
</dl>

<dl>
  <dt>Year</dt>
  <dd>
    <select name="year">
      <option value=""></option>
    <?php $this_year = idate('Y') ?>
    <?php for($year=$this_year-20; $year <= $this_year; $year++) { ?>
      <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php } ?>
    </select>
  </dd>
</dl>

<dl>
  <dt>Category</dt>
  <dd>
    <select name="category">
      <option value=""></option>
    <?php foreach(Bicycle::CATEGORIES as $category) { ?>
      <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
    <?php } ?>
    </select>
  </dd>
</dl>

<dl>
  <dt>Gender</dt>
  <dd>
    <select name="gender">
      <option value=""></option>
    <?php foreach(Bicycle::GENDERS as $gender) { ?>
      <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
    <?php } ?>
    </select>
  </dd>
</dl>

<dl>
  <dt>Color</dt>
  <dd><input type="text" name="color" value="" /></dd>
</dl>

<dl>
  <dt>Condition</dt>
  <dd>
    <select name="condition_id">
      <option value=""></option>
    <?php foreach(Bicycle::CONDITION_OPTIONS as $cond_id => $cond_name) { ?>
      <option value="<?php echo $cond_id; ?>"><?php echo $cond_name; ?></option>
    <?php } ?>
    </select>
  </dd>
</dl>

<dl>
  <dt>Weight (kg)</dt>
  <dd><input type="text" name="weight_kg" value="" /></dd>
</dl>

<dl>
  <dt>Price</dt>
  <dd>$ <input type="text" name="price" size="18" value="" /></dd>
</dl>

<dl>
  <dt>Description</dt>
  <dd><textarea name="description" rows="5" cols="50"></textarea></dd>
</dl>
