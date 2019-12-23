<?php
    require_once "functions.php";

    $file = "db/03.2018.csv";
    $config = include "config.php";
    if ( isset( $config['csv']))
        $file = $config['csv'];

    define("file", $file);

    $request = "";
    if (isset($_GET['request']))
        $request = strip_tags($_GET['request']);

    if(isset($_GET['fast']))
//        setcookie("fast",1, date(time())+3600*24*356);
//    if(isset($_GET['fast']))
//        setcookie("fast",0, date(time())+3600*24*356);

//    if (isset($_COOKIE['fast']))
        $fast_search = true;
    else
        $fast_search = false;

    $headers = headers_get( $file );   // tutaj są nazwy kolumn z pliku CSV

//    echo $headers['OPIS_DANE'];

//    echo "<pre>";
//        print_r($headers);
//    echo "</pre>";

    $handle = fopen($file, "r");

    if ($fast_search)
        $many_of_arrays = search_fast( $handle, $request,$headers );
    else
        $many_of_arrays = search_case( $handle, $request,$headers );
//  [0] count of books
//  [1] duplicates
//  [2] book_data

    $counter = $many_of_arrays[0];

?>
<script>
document.getElementById("counter").innerHTML = <?php echo $counter; ?>;
</script>
<?php

if( $counter > 0 )
        print_books($many_of_arrays,$headers);
    else
        echo "<h1 class='text-center p-4'>Nie znaleziono książki</h1> 
              <p class='lead text-center animated fadeInDown' > pasującej do frazy <b>$_GET[request]</b></p>";

if ( isset($config["request_save_log"]) && $config["request_save_log"] ) {

    if (!file_exists($config["log_request_filename"]))
        file_put_contents($config["log_request_filename"], '<head> <meta charset="utf-8"> </head>'.PHP_EOL,FILE_APPEND);

    $log = date("Y.m.d\tH:i:s\t") . "<a href=\"https://geoiptool.com/en/?ip=" .
    getRealIpAddr() . "\">".getRealIpAddr()."</a>\t($counter)\t$request<br>".PHP_EOL;
    file_put_contents($config["log_request_filename"], $log,FILE_APPEND);

}
?>


