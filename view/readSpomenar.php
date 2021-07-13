<?php
require_once __SITE_PATH . '/view/_header.php';
if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];
if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>";

// Ovo je stranica koja se otvara privim klikom na:
//       Upisi se u spomenar
//       Moji odgovori
//       Pogledaj spomenar

require_once __SITE_PATH . '/view/_pitanja.php';
require_once __SITE_PATH . '/view/_footer.php';
