<div class="container-fluid p-4 tips" >
    <a href="#upload"><i class="fa fa-level-down position-relative fa-3x float-right animated fadeIn" aria-hidden="true"></i> </a>
    <h2 class="display-4">Jak dodać nową bazę książek</h2>

    <p class="lead">Do wyeksportowania aktualnej bazy danych kopiujemy poniższe zapytanie. Następnie otwieramy program
        Microsoft <b>SQL Managment Studio</b>. Łączymy się z bazą i postępując zgodnie z poniższą animacją. Wklejamy wcześniej skopiowane zapytanie SQL</p>
<blockquote class="blockquote bq-primary my-5">
    <p class="bq-title d-inline-flex">Zapytanie SQL</p> <a role="button" onclick="copy(this);" class="ml-4 btn btn-sm btn-deep-orange animated swing"> Kopiuj <i class="fa fa-hand-pointer-o"></i></a>
   <pre id="sql" style="overflow-x: hidden">SELECT      OPIS_ID, OPIS_DANE, OPIS_AUTOR, OPIS_TYTUL, OPIS_WYDAWCA, OPIS_MWYD, OPIS_RWYD, ZKS_SYGNAT, RKS_TEKST
FROM        dbo.ZASOB, dbo.KSIEGA_INW, dbo.OPIS, dbo.RODZ_KS
WHERE	    dbo.ZASOB.ZAS_KSINW_ID=dbo.KSIEGA_INW.KSINW_ID AND
            dbo.OPIS.OPIS_RKS_ID=dbo.RODZ_KS.RKS_ID AND
            dbo.ZASOB.ZAS_OPIS_ID=dbo.OPIS.OPIS_ID;</pre>
</blockquote>
    <img src="mdb/img/sql.gif" alt="sql_query_animation">

<hr class="my-5">
    <p class="lead "> Upewniamy się że w <i>Tools -> Options</i> następnie <i>Query Results -> SQL Server -> Results to Text</i><br>
        wartość <b>Custiom delimiter</b>: jest ustawiona na pionową kreskę: <b>|</b> (pipeline)</p>
    <img src="mdb/img/options.png" alt="screen">
    <hr class="my-5">

    <p class="lead"> Zapisujemy plik *.rpt <i>Ctrl + T</i> następnie <i>F5</i>. </p>
    <img src="mdb/img/export.gif" alt="screen">
    <hr class="my-5">

    <blockquote class="blockquote bq-title my-5 " id="upload">
        <p class="bq-title d-inline-flex">Plik przesyłamy na stronę i konwertujemy </p>

        <form id="upload" action="index.php?upload" method="post" enctype="multipart/form-data" name="sth">
            <div class="m-3 ml-4">
            <label >
                Wgraj plik *.rpt <input type="file" name="fileToUpload" id="fileToUpload" class="btn secondary-color-dark"
                                        accept=".rpt,.csv,.txt,.xls,.xlsx,.zip,7z"  required>
            </label>
            <input type="submit" value="Wyślij" formaction="index.php?upload&convert" class="btn primary-color-dark" ><br>
                 <div class="ml-2">
                    <label><input type="checkbox" name="rename" checked> Nazwij plik aktualną datą  </label><br>
                    <label><input type="checkbox" id="compress" checked> Kompresuj przed wysłaniem </label><br>
                    <label><input type="checkbox" name="convert" checked> Konwertuj do csv po przesłaniu </label><br>


                 </div>
<!--                <input type="submit" value="Tylko wyślij" class="btn btn-outline-blue-grey mb-3" ><br>-->
            </div>
        </form>

    </blockquote>
</div>


<script type="text/javascript" src="jszip/dist/jszip.js"></script>

<script type="text/javascript">

    function copy( btn ) {
        var sql = document.getElementById('sql').innerHTML;
        // Temporarily enable designMode so that
        // document.execCommand() will work
        document.designMode = "on";

        // Select the element's content
        sel = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(document.getElementById('sql'));
        sel.removeAllRanges();
        sel.addRange(range);

        document.execCommand("Copy",true,sql);
        // Disable designMode
        document.designMode = "off";
        btn.innerHTML = 'skopiowano';
    }

    window.onload = function() {
//
//        $('#login_form').on('submit', function(e) { //use on if jQuery 1.7+
//            e.preventDefault();  //prevent form from submitting
//            var data = $("#login_form :input").serializeArray();
//            console.log(data); //use the console for debugging, F12 in Chrome, not alerts
//        });

//            $('input[type="file"]').change(function(e){
//                var fileName = e.target.files[0].mozFullPath;
////                var fileName = e.target;
//                alert('The file "' + fileName +  '" has been selected.');
//            });

        return false;
        $('#upload').submit(function(e) {
            if ( document.getElementById('compress').checked )
            {

                e.preventDefault();


                alert($('input[type=file]').val());

                create_zip( $('input[type=file]').val() );
                alert("d");
                alert('Stworzono zip');
                return false;
            }
        });
    }

    function create_zip( filename ) {
        var zip = new JSZip();
        zip.add("hello1.txt", "Hello First World\n");
//        zip.add(filename, "zip file\n");
        content = zip.generate();
        location.href="data:application/zip;base64," + content;
    }

    function GetFileName(){
        // Get your file input (by it's id)
        var fileInput = document.getElementById('fileToUpload');
        // Use a regular expression to pull the file name only
        var fileName = fileInput.value.split(/(\\|\/)/g).pop();
        // Alert the file name (example)
        return fileName;
//        alert(fileName);
    }



</script>
<style>


</style>

