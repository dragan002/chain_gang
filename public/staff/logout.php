<?php
require_once('../../private/initialize.php');

// Log out the admin

$session->log_out();

redirect_to(url_for('/staff/login.php'));

?>
