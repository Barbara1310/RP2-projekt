<?php
require_once __SITE_PATH . '/view/_header.php';
if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];
?>
<?php if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>"; ?>
<br>
<br>
<div class="col-md-8">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Username</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <?php echo $user->username ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <?php echo $user->email ?>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>
<?php
require_once __SITE_PATH . '/view/_footer.php';
?>
