<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/bicycles/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Save record using post parameters
  $args = [];
  $args['brand'] = $_POST['brand'] ?? NULL;
  $args['model'] = $_POST['model'] ?? NULL;
  $args['year'] = $_POST['year'] ?? NULL;
  $args['category'] = $_POST['category'] ?? NULL;
  $args['color'] = $_POST['color'] ?? NULL;
  $args['gender'] = $_POST['gender'] ?? NULL;
  $args['price'] = $_POST['price'] ?? NULL;
  $args['weight_kg'] = $_POST['weight_kg'] ?? NULL;
  $args['condition_id'] = $_POST['condition_id'] ?? NULL;
  $args['description'] = $_POST['description'] ?? NULL;

  $bicycle = [];

  $result = false;
  if($result === true) {
    $_SESSION['message'] = 'The bicycle was updated successfully.';
    redirect_to(url_for('/staff/bicycles/show.php?id=' . $id));
  } else {
    // show errors
  }

} else {

  // display the form
  $bicycle = [];
}

?>

<?php $page_title = 'Edit Bicycle'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/bicycles/index.php'); ?>">&laquo; Back to List</a>

  <div class="bicycle edit">
    <h1>Edit Bicycle</h1>

    <?php // echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/bicycles/edit.php?id=' . h(u($id))); ?>" method="post">

      <?php include('form_fields.php'); ?>
      
      <div id="operations">
        <input type="submit" value="Edit Bicycle" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
