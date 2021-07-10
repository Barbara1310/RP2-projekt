<br><br>

<div id="stranice">
    <ul class="pagination justify-content-center" style="margin:20px 0">
        <li class="page-item">
            <a class="page-link" href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=1">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=2">2</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=3">3</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=4">4</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=5">5</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=6">6</a>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        params = {};
        location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) {
            params[k] = v
            console.log(params);
        });
        $("a").filter(function() {
            console.log($(this).attr('href').includes(params['pitanje']));
            return $(this).attr('href').includes(params['pitanje']);
        }).parents('li').addClass("active");
    });
</script>