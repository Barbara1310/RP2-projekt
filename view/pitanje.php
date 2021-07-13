<?php
require_once __SITE_PATH . '/view/_header.php';

// prekini ako ne znamo o kojem se pitanju radi
if (!isset($_SESSION["pitanje"])) return;
else $pitanje = $_SESSION["pitanje"];

// prekini ako nemamo odgovore na pitanje
if (!isset($_SESSION["odgovori"])) return;
else $odgovori = $_SESSION["odgovori"];

// Ispis u slucaju greske
if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>"; ?>

<br>
<br>
<!-- Ispis pitanja i svih prijasnjih odogovora u nasem stilu definiranom u /view/style.css.
     Odgovori isprintani kao neuredjena lista na div-u koji ima izgled biljeznice.
     Svakom korisniku vidljivi su svi prijasnji odgovori na postavljeno pitanje, cime je postignut
     dojam pravog old school spomenara.
     Ovaj html se koristi i za popunjavanje i za pregled kao i za pregled vlastitih odgovora.
     Ukoliko se radi o upisivanju, a da trenutni user nije spremio svoj odogovor na pitanje, ispisuje mu se
     forma za unos odogovra na pitanje.
     Visina objekta na kojem se ispisuju odgovori ovisi o broju odogovra te se dinamicki mijenja sa js funkcijom. -->
<div class='pitanje_div'>
    <h3 class='h_pitanje'><?php echo $pitanje->pitanje; ?></h3>
    <div class="lines"></div>
    <ul class='odgovori'>
        <?php
        foreach ($odgovori as $odgovor) {
            echo '<li>' . $odgovor . '</li>';
        }
        ?>

        <!-- Forma za unos odgovora na postavljeno pitanje. Pitanje na koje se odgovora prenosi se preko GET['pitanje'] parametra. -->
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

<!-- Funckija za dinamicku promjenu visine objekta lines (crvena linija).
     Nova visina je (broj odgovora u listi) * 55 -->
<script>
    $(document).ready(function() {
        $(".lines").height($(".odgovori li").length * 55);

    });
</script>

<?php
// Resetiraj pitanje i odogovore kako bi bili spremni za iduce pitanje
unset($_SESSION['pitanje']);
unset($_SESSION['odgovori']);
require_once __SITE_PATH . '/view/_pitanja.php';
require_once __SITE_PATH . '/view/_footer.php';
