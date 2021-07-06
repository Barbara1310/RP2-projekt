<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/fill" class="nav-link" type="button">Upisi se u spomenar</a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/my_answers" class="nav-link" type="button">Moji odgovori</a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/read" class="nav-link" type="button">Pogledaj spomenar</a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=users/index" class="nav-link" type="button">Moj Profil</a>
        <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->is_admin) { ?>
            <a href="<?php echo __SITE_URL; ?>/index.php?rt=questions/add_question" class="nav-link" type="button">Dodaj novo pitanje</a>
        <?php } ?>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=login/processLogout" class="btn btn-danger" type="button">Logout</a>
    </div>
</nav>
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