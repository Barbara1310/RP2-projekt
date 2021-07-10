<?php
require_once __SITE_PATH . '/view/_header.php';
if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];
if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>";

?>
<br>
<br>
<h3>Trece pitanje</h3>
<?php
require_once __SITE_PATH . '/view/_pitanja.php';
require_once __SITE_PATH . '/view/_footer.php';
