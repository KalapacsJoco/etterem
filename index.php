<?php
$title = 'Home Page';
ob_start();
?>
<h2>Welcome to the Home Page</h2>
<p>This is the content of the home page.</p>
<?php
$content = ob_get_clean();
include 'view/templates/layout.php';
?>