<div class="flex-center flex-column">
    <!-- Search form -->
    <form class="form-inline"  action="" method="get" >
        <section class="text-center w-100">

            <input style="width:85%!important;" class="form-control form-control-sm d-inline-block ml-1 <?php if(!isset($_GET['los'])){ ?>animated headShake <?php } ?>"
                   id="search" name="request" type="text" placeholder="Tytuł książki, Autor, ISBN ..." aria-label="Search" >
            <button style="background: transparent; border: 0; " id="search_b" class="d-none" type="submit">
                <i class="fa fa-search " aria-hidden="false"></i>
            </button>
            <button style="background: transparent; border: 0;" name="fast" aria-label="Szybkie wyszukiwanie bez rozróżniania wielkości znaków" class="hint--top" type="submit">
                <i class="fa fa-bolt " aria-hidden="false"></i>
            </button>

            <select class="mdb-select md-form w-75 browser-default custom-select" name="category_request">
                <option value="" disabled selected>lub wybierz kategorię...</option>
                <?php require("categories.php") ?>
                <!-- <option value="Beletrystyka">Beletrystyka</option>
                <option value="Lektury">Lektury</option>
                <option value="Podręczniki">Podręczniki</option>
                <option value="Naukowe i popularnonaukowe">Naukowe i popularnonaukowe</option>
                <option value="Dydaktyka i pedagogika">Dydaktyka i pedagogika</option>
                <option value="Wydawnictwa informacyjne">Wydawnictwa informacyjne</option>
                <option value="Inne">Inne</option> -->
            </select>
            <label></label>
                <!-- <input list="book-categories" name="category_request" style="margin-top:2rem!important;width:50%!important" placeholder="lub wybierz kategorię...">
                <datalist id="book-categories">
                    <option value="Beletrystyka">
                    <option value="Lektury">
                    <option value="Podręczniki">
                    <option value="Naukowe i popularnonaukowe">
                    <option value="Dydaktyka i pedagogika">
                    <option value="Wydawnictwa informacyjne">
                    <option value="Inne">
                </datalist>  -->



            <div  class="btn-group mt-4 p-auto w-75 d-inline-flex justify-content-sm-around " id="radio_buttons" >
                <button type="button" class="btn btn-primary " onClick="document.getElementById('search_b').click();">
                    <i class="fa fa-search mr-1"></i>
                    <span class="hidden-phone">Szukaj</span> </button>
                <a href="?los" role="button" class="btn btn-secondary" onclick="parent.window.location.reload(true)"><i class="fa fa-send-o mr-1"></i>
                    <span class="hidden-phone">Losuj książkę</span> </a>
            </div>

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