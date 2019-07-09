
    <nav class="navbar navbar-expand-lg navbar-dark  sticky-top ">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="./">Biblioteka </a>
        <a <?php if ( isset($_GET['request']) && $_GET['request'] == 'Durer' ) echo "href=?admin"; ?> >
        <span class="badge badge-success z-depth-1 mx-1 clearfix d-none d-sm-inline-block">Beta</span>
        </a>
		<?php if ( isset($_GET['check'])  )
		{
			?>
			 <a href="db/log_request.htm" >
			<span class="badge badge-info z-depth-1 mx-1 clearfix d-none d-sm-inline-block">Aktywność</span>
			</a>
		<?php } ?>
        <ul class="navbar-nav mr-auto">

<!--            <li class="nav-item active">-->
<!--                <a class="nav-link waves-effect waves-light" href="#">Home-->
<!--                    <span class="sr-only">(current)</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a class="nav-link waves-effect waves-light" href="#">Features</a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a class="nav-link waves-effect waves-light" href="#">Pricing</a>-->
<!--            </li>-->
<!--            <li class="nav-item dropdown">-->
<!--                <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown-->
<!--                </a>-->
<!--                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">-->
<!--                    <a class="dropdown-item waves-effect waves-light" href="#">Action</a>-->
<!--                    <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>-->
<!--                    <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>-->
<!--                </div>-->
<!--            </li>-->
        </ul>

        <?php if(!empty($_GET['request']) )
        {   $icon_displayed = true;
            ?>
            <div class="hint--bottom" aria-label="Znalezionych książek">
            <button id="circle" class="btn btn-circle default-color animated fadeIn "><p id="counter"  0</p></button>
            </div>
<!--            <a href="#!"> <i id="book_ico" class="fa fa-book fa-2x white-text mr-2 animated fadeIn" aria-hidden="false"></i></a>-->

			<!--            <i class="fa fa-bolt fa-2x --><?php //if($_COOKIE['fast']) echo "white-text"; else echo 'text-light'; ?><!-- aria-hidden="true"></i>-->
<!--            <button id="sth"-->
<!--                    aria-label="Szybkie wyszukiwanie bez rozróżniania wielkości znaków" class=" btn-circle default-color   hint--top" type="submit">-->
<!--                <i class="fa fa-bolt " aria-hidden="false"></i>-->
<!--            </button>-->


        <form class="form-inline" action="" method="get">
            <div class="md-form mt-0">
                <div class="waves-input-wrapper waves-effect waves-light d-inline-flex">
                    <input class="form-control mr-sm-2 " minlength="3" type="text" name="request" placeholder="Szukaj książki" aria-label="Search"
            <?php   if(isset($_GET['request']))
                        echo "value=\"$_GET[request]\""; ?>
                    >
                    <button  class="d-sm-inline-block d-md-none" style="background: transparent; border: 0; " type="submit">
                        <i class="fa fa-search fa-1x white-text" aria-hidden="false"></i>
                    </button>
                </div>
            </div>
        </form>
        <?php }
        if (!empty($_GET) && !isset($icon_displayed))
            echo "<a href=\"index.php\"> <i id=\"book_ico\" class=\"fa fa-book fa-2x white-text mx-1 animated fadeIn \" aria-hidden=\"false\"></i></a>";

        ?>



    </nav>
    <!--/.Navbar-->

