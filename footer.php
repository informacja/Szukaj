<!--Footer style in mdb/_custom.scss-->
<footer class="page-footer font-small pt-4 mt-4 footer" >

    <!--Footer Links-->
    <div class="container-fluid text-center text-md-left">
<!--        <div class="row">-->

            <!--First column-->
<!--            <div class="col-md-6">-->
<div class="d-flex justify-content-between d-inline-block" style="transition: 1s all; color: white;">
                  <div id="info">
                        <h5 class="text-uppercase">Warto wiedzieć</h5>
                        <p>Ze wzgędów bezpieczeństwa logowanie się na konto jest dostępne tylko na terenie szkoły (WiFi)</p>
                  </div>
                  <div class="invisible d-none" id="opac">
                      <dl>
                          <dt class="d-inline">
                            <h5 class="text-uppercase ">Warto wiedzieć</h5>
                            <span>Jesteś w sieci szkolnej, możesz przejść do katalogu OPAC i się zalogować</span>
                          </dt>
                          <dd class="d-inline">
                            <a href="http://biblioteka/molwww" class="btn btn-deep-orange btn-sm waves-light d-inline">MOL Optivum</a>
                          </dd>
                      </dl>
                  </div>

                        <div class="d-flex justify-content-center">
                            <div class="d-flex">
                                <div class="collapse" id="colorSettings" data-placement="left" >
                                    <div class="pt-3 mt-1">
                                        <button class="btn btn-sm btn-red"      onclick="set_color('red-skin'); "></button>
                                        <button class="btn btn-sm btn-orange"   onclick="set_color('orange-skin'); "> </button>
                                        <button class="btn btn-sm success-color"onclick="set_color('green-skin'); "></button>
                                        <button class="btn btn-sm btn-blue"     onclick="set_color('blue-skin');" ></button>
                                        <button class="btn btn-sm btn-indigo"   onclick="set_color('indigo-skin');" ></button>
                                        <button class="btn btn-sm btn-purple"   onclick="set_color('purple-skin');" ></button>

<!--                                    <span class="text-muted">Toggleable via the navbar brand.</span>-->
                                    </div>

                                </div>
                                <button class="navbar-toggler float-left no-focus" type="button" data-toggle="collapse" data-target="#colorSettings" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <!--                <span class="navbar-toggler-icon"></span>-->
                                    <i class="fa fa-cog text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
</div>
<!--            </div>-->
<!--            /.First column-->

<!--            Second column-->
<!--            <div class="col-md-6">-->
<!--                <h5 class="text-uppercase">Polecane</h5>-->
<!--                <ul class="list-unstyled">-->
<!--                    <li><a href="#!">Link 1</a></li>-->
<!--                    <li><a href="#!">Link 2</a></li>-->
<!--                    <li><a href="#!">Link 3</a></li>-->
<!--                    <li><a href="#!">Link 4</a></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            /.Second column-->
        </div>

    </div>
    <!--/.Footer Links-->

    <!--Copyright-->
    <div class="footer-copyright py-3 text-center">
        <div class="d-flex justify-content-between px-2 ">
            <a id="day_count" class="disabled"></a>
            <a href="http://www.zst-tarnow.pl/kategorie/biblioteka"> ZST Tarnów</a>
            <a id="online_count" class="text-muted disabled" ></a>


        </div>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->

<!--Client in valid network script-->
<script>
    //    Sprawdzanie czy klient jest w właściwej sieci
    xmlhttp=false;
    //explorer
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        try {
            xmlhttp = new XMLHttpRequest();
        } catch (e) {
            xmlhttp=false;
        }
    }
    if (!xmlhttp && window.createRequest) {
        try {
            xmlhttp = window.createRequest();
        } catch (e) {
            xmlhttp=false;
        }
    }
    /* Uwaga żeby zapytanie do komputera w bibliotece działało, cała strona musi zostać załadowana jako HTTPS */
    if (location.protocol != 'https:') {
        xmlhttp.open("HEAD", "http://biblioteka/powered_on.php", true);
        // location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
    }
    else{
        xmlhttp.open("HEAD", "https://biblioteka/powered_on.php", true);
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4) {
            if (xmlhttp.status==200) {
                document.getElementById('opac').className = "";
                document.getElementById('info').className = "invisible d-none ";
            }
//			else if (xmlhttp.status==404) alert("URL doesn't exist!")
//			    else alert("Status is "+xmlhttp.status);
//				    alert(xmlhttp.getAllResponseHeaders());
            xmlhttp.send(null)
        }
    }
    xmlhttp.send(null)

</script>

<!--Skin color in cookie scrript-->
<script>
    function set_color( color ) {
        var element = document.getElementsByTagName("body");
//        alert(element[0]);
        element[0].className = ' ' + color;

        // Delete previous cookie
//        document.cookie = color + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';

        var date = new Date();
        // Default at 365 days.
        var days = date || 365;
        // Get unix milliseconds at current time plus number of days
        date.setTime(+ date + (days * 86400000)); //24 * 60 * 60 * 1000

        document.cookie = 'color=' + color + "; expires=" + date.toGMTString() + ";";
//        element[0].classList.remove('blue-skin');
    }
</script>