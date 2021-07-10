<?php
require_once __SITE_PATH . '/view/_header.php';
if (!isset($_SESSION["pitanje"])) return;
else $pitanje = $_SESSION["pitanje"];

if (!isset($_SESSION["odgovori"])) return;
else $odgovori = $_SESSION["odgovori"];

if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>";

?>
<br>
<br>
<div class='pitanje_div'>
    <h3 class='h_pitanje'><?php echo $pitanje->pitanje; ?></h3>
    <div class="lines"></div>
    <ul class='odgovori'>
        <?php
        foreach ($odgovori as $odgovor) {
            echo '<li>' . $odgovor . '</li>';
        }
        ?>

        <?php if (isset($_SESSION['akcija']) && $_SESSION['akcija'] == 'popuni') { ?>
            <li>
                <form action="<?php echo __SITE_URL; ?>/index.php?rt=spomenar&pitanje=<?php echo $pitanje->id ?>" method="POST">
                    <input type="text" name="odgovor">
                    <button type="submit">Spremi!</button>
                </form>
            </li>
        <?php }
        unset($_SESSION['akcija']);
        ?>
    </ul>
</div>

<script>
    $(document).ready(function() {
        $(".lines").height($(".odgovori li").length * 55);

    });
</script>

<?php
unset($_SESSION['pitanje']);
unset($_SESSION['odgovori']);
require_once __SITE_PATH . '/view/_pitanja.php';
require_once __SITE_PATH . '/view/_footer.php';
