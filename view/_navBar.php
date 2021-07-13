<!-- Navigacija u Bootstrap stilu.
     Link 'Dodaj novo pitanje' vidljiv samo admin userima.
     JS funckija koja oboji trenutno aktivni link u sivo. Dodaje se klasa active za aktivni link. -->
<nav>
    <div class="nav nav-tabs nav justify-content-center" id="nav-tab" role="tablist">
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/fill" class="nav-link" type="button">Upiši se u spomenar</a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/my_answers" class="nav-link" type="button">Moji odgovori</a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/read" class="nav-link" type="button">Pogledaj spomenar</a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=users/index" class="nav-link" type="button">Moj Profil</a>
        <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->is_admin) { ?>
            <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/add_question" class="nav-link" type="button">Dodaj novo pitanje</a>
        <?php } ?>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=login/processLogout" class="btn btn-danger" type="button">Logout</a>
    </div>
</nav>

<!-- JS Funckija koja dodaje klasu active za aktivni link navigacije -->
<script>
    $(document).ready(function() {
        params = {};
        location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) {
            params[k] = v
        });
        $("a").filter(function() {
            return $(this).attr('href').includes(params["rt"]);
        }).addClass("active");
    });
</script>