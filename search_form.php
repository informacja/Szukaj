<div class="flex-center flex-column">
    <!-- Search form -->
    <form class="form-inline"  action="" method="get" >
        <section class="text-center w-100">

            <input class="form-control form-control-sm d-inline-block w-75 ml-1 <?php if(!isset($_GET['los'])){ ?>animated headShake <?php } ?>"
                   id="search" name="request" type="text" placeholder="Tytuł książki, Autor, ISBN ..." aria-label="Search" required>
            <button style="background: transparent; border: 0; " id="search_b" class="d-none" type="submit">
                <i class="fa fa-search " aria-hidden="false"></i>
            </button>
            <button style="background: transparent; border: 0;" name="fast" aria-label="Szybkie wyszukiwanie bez rozróżniania wielkości znaków" class="hint--top" type="submit">
                <i class="fa fa-bolt " aria-hidden="false"></i>
            </button>

            <div  class="btn-group mt-4 p-auto w-75 d-inline-flex justify-content-sm-around " id="radio_buttons" >
                <button type="button" class="btn btn-primary " onClick="document.getElementById('search_b').click();">
                    <i class="fa fa-search mr-1"></i>
                    <span class="hidden-phone">Szukaj</span> </button>
                <a href="?los" role="button" class="btn btn-secondary" onclick="parent.window.location.reload(true)"><i class="fa fa-send-o mr-1"></i>
                    <span class="hidden-phone">Losuj książkę</span> </a>
            </div>
            <?php if (empty($_GET) ){ ?>
            <div class="text-center mt-1 d-sm-inline-block d-md-none">
                <br>
                <label>
                    <input type="checkbox" onclick="set_display_settings(this);"
                        <?php if(isset($_COOKIE['display_all']) && $_COOKIE['display_all'] == true ) echo 'checked'; ?>
                    > &nbsp; Wyświetl pełne opisy</label>
            </div>
            <?php } ?>

            <!--            <div class="btn-group mr-1 pt-3 d-block" data-toggle="buttons">-->
            <!--                <label class="btn btn-primary  form-check-label">-->
            <!--                    <label class="switch">-->
            <!--                                            <input type="checkbox">-->
            <!--                                            <span class="slider round " style="padding-left:60px;white-space: nowrap;">  </span>-->
            <!--                                        </label>-->
            <!--                    <input type="checkbox" class="form-check-input" autocomplete="off"> Szybkie wyszukiwanie-->
            <!--                </label>-->
            <!--            </div>-->
        </section>
    </form>
</div>
<script>
function set_display_settings( chbox ){

    var exdate = new Date();

    if ( chbox.checked ) {
         exdate.setDate(exdate.getDate() + 3600 * 24 * 356);
         document.cookie = "display_all=" + chbox.checked + "; expires=" + exdate.toUTCString();
    }
    else
    {
        exdate.setDate(exdate.getDate() -100);
        document.cookie = "display_all=" + chbox.checked +"; Max-Age=-99999999; expires=" + exdate.toUTCString(); // usuwanie ciasteczka
    }
}
</script>