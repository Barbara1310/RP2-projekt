<!DOCTYPE html>
<html lang="en">

<!-- Header - ukljucuje Bootstrap, vlastiti style.css te jquery.
     Ispisuje poruku login poruku ili poruku dobrodoslice ukoliko je user ulogiran. -->

<head>
    <meta charset="utf8">
    <title><?php if (isset($title)) echo $title;
            else echo "E-spomenar"; ?></title>
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/view/style.css">
    <script type="text/javascript" src="<?php echo __SITE_URL; ?>/static/jquery-min.js"></script>
</head>

<body class="container-fluid ">
    <br>
    <h1><?php if (isset($_SESSION["user"])) echo $_SESSION["user"]->username . ", dobrodošli u e-spomenar!";
        else echo " please login or register!"; ?></h1>

    <?php
    if (isset($_SESSION["user"])) require_once "_navBar.php";
