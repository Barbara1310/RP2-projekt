<br><br>

<div id="stranice">
    <ul class="pagination justify-content-center" style="margin:20px 0">
        <?php
        for ($i = 1; $i <= count($_SESSION['pitanja']); $i++) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="' . __SITE_URL . '/index.php?rt=spomenar/' . $_SESSION['akcija'] . '&pitanje=' . $i . '">' . $i . '</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>

<script>
    $(document).ready(function() {
        params = {};
        location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) {
            params[k] = v
        });
        $("a").filter(function() {
            return $(this).attr('href').includes(params['pitanje']);
        }).parents('li').addClass("active");
    });
</script>