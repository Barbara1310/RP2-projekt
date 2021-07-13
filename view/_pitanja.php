<br><br>

<!-- Ovo je prikaz stranica pomocu kojih user prebacuje view s pitanja na pitanje.
     Koristi se Bootstrap stil.
     Dinamicki se stvori stranica koliko ima postavljenih pitanja kako bi bilo moguce dodavati nova pitanja u spomenar.
     Svaki clan neuredjene liste predstavlja link na jedno od pitanja. Klikom na link poziva se jedna od funckija
            fill() -> za popunjavanje spomenara
            read() -> za pregled spomenara
            my_answers() -> za pregled vlastitih odgovora
     iz SpomenarController.php, te mu se takodjer broj pitanja prosljedjuje kroz GET['pitanje'].

     Aktivni link (stranica) budu plavi kako bi user znao na kojem je pitanju. To je implementirano pomocu js funkcije na nacin
     da se aktivnom pitanju pridjeljuje klasa class=active.
    -->
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

<!-- JS za dodavanje klase active aktivnom pitanju.
     BUG: kad je aktivno pitanje br2 svi linkovi su plavi. -->
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