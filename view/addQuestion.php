<?php
require_once __SITE_PATH . '/view/_header.php';
?>
<br>
<br>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=spomenar/add_question' ?>">
    <div class="form-group">
        <h4 class="h_pitanje">Dodajte novo pitanje u spomenar</h4>
        <input class="form-control" id="question" name="question" type="text">
    </div>
    <br>
    <div class="float-end">
        <button class="btn btn-primary" type="submit">Dodaj</button>
    </div>
</form>

<?php
require_once __SITE_PATH . '/view/_footer.php';
