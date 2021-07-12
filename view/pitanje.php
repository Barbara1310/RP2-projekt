<?php
require_once __SITE_PATH . '/view/_header.php';
if (!isset($_SESSION["pitanje"])) return;
else $pitanje = $_SESSION["pitanje"];

if (!isset($_SESSION["odgovori"])) return;
else $odgovori = $_SESSION["odgovori"];

if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>"; ?>

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

        <?php if (isset($_SESSION['akcija']) && $_SESSION['akcija'] == 'fill' && $_SESSION['user']->odgovoreno[$pitanje->id - 1] == 0) { ?>
            <li>
                <form action="<?php echo __SITE_URL; ?>/index.php?rt=spomenar/<?php echo $_SESSION['akcija'] . '&pitanje=' . $pitanje->id ?>" method="POST">
                    <input type="text" name="odgovor">
                    <button class="btn btn-outline-success" type="submit">Spremi!</button>
                </form>
            </li>
        <?php
        }
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
