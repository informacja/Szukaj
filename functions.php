<?php
/**
 * Created by PhpStorm.
 * User: Puler
 * Date: 04.03.2018
 * Time: 18:59
 */

function headers_get( $CSV_filename )
{
    $handle = null;

    if (file_exists($CSV_filename))
        $handle = fopen($CSV_filename, "r");
    else {
        echo "<p class='alert alert-danger'>Database <b>$CSV_filename</b> not exist, change database name in cofig file</p>";
        exit;
    }

    $header_row = fgetcsv($handle);
    fclose($handle);

    $nr_headers = explode("|",$header_row[0]);

    // przesówamy wszystkie idexy o jeden, zapobiega to konfliktom z null
//    $nr_headers = array_combine(range(1, count($nr_headers)), array_values($nr_headers));

//    $new_files = array();
//    $new_files[""] = '0';

//    foreach($nr_headers as $k=>$v)
//    {
//        if( $k == 0 )
//            $new_files[$v] = '0';
//        else
//            $new_files[$v] = $k;
//    }

//echo "<pre>";
//    var_dump($new_files);
    $buff = array_flip($nr_headers);
//    var_dump($buff);
//echo $nr_headers[0];
//    $text = (string)$nr_headers[0];
//    $buff[(array_va/lues($nr_headers)[0])] = '0';

//    echo array_values($nr_headers)[0];

//    echo $buff['OPIS_DANE'];

    return $buff;
}

// ---------------------------------------------------------------------------------------------------------------------

function print_books($many_of_arrays,$headers)
{
    echo "<br>";        // odstęp od nav
//    echo "<pre>";
//        print_r($many_of_arrays);
//    echo "</pre>";

//    $counter = $many_of_arrays[0];
    $duplcate_coutner = $many_of_arrays[1];
    $books = $many_of_arrays[2];

//    $title_couunt = array_count_values($title_duplcate_coutner);
//    asort($title_couunt);

    $i = 0;

    foreach ($books as $book) { ?>

<!--        <ul class="list-group ">-->
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <dl class="row mb-0">
                    <dt class="col-sm-4 my-2 px-5 py-4 font-weight-normal text-center">
                        <div class="<?php if(isset($_GET['los'])){ ?>zoomInRight <?php } ?> ">
                            <span aria-label="Tytuł książki" class="hint--bottom" >
                        <?php
                            echo "<p class='my-1 lead animated font-weight-normal'>".$book[$headers['OPIS_TYTUL']]."</p>";
                            echo "</span> ";
                            if ($duplcate_coutner[$i] > 1)
                                echo "<span class='badge badge-primary badge-pill hint--bottom' aria-label='Egzemplarzy'>
                                 $duplcate_coutner[$i]</span>";
                        ?>
                        </div>
                    </dt>
                    <dd class="col-sm-8 mb-0">
                        <dl class="row mb-0">
                            <!--                            <dt class="col-sm-3">  </dt>-->
                            <!--                            <dd class="col-sm-9"><h5 class="h4-responsive">-->
                            <?php //echo $book[$headers['OPIS_TYTUL']];?><!--</h5></dd>-->

                            <dt class="col-sm-3">Autor</dt>
                            <dd class="col-sm-9"><?php echo $book[$headers['OPIS_AUTOR']]; ?>  </dd>

                            <dt class="col-sm-3">Sygnatura</dt>
                            <dd class="col-sm-9"><?php echo $book[$headers['ZKS_SYGNAT']]; ?>  </dd>

                        <?php
                            if( isset($_COOKIE['display_all']) )
                                $class = '';
                            else
                                $class = 'd-none d-sm-block';
                        ?>

                                <dt class="col-sm-3 <?php echo $class ?>">Wydawca</dt>
                                <dd class="col-sm-9 <?php echo $class ?>"><?php echo $book[$headers['OPIS_WYDAWCA']]; ?>  </dd>

                                <dt class="col-sm-3 <?php echo $class ?> ">Miejsce i rok wydania</dt>
                                <dd class="col-sm-9 <?php echo $class ?> "><?php echo $book[$headers['OPIS_MWYD']];
                                    echo ' ';
                                    echo $book[$headers['OPIS_RWYD']]; ?>  </dd>

                                <?php if (isset($book['ISBN'])) { ?>
                                    <dt class="col-sm-3 <?php echo $class ?> ">ISBN</dt>
                                    <dd class="col-sm-9 <?php echo $class ?> "><?php echo $book['ISBN']; ?>  </dd>
                                <?php } ?>
                        </dl>
                    </dd>
                </dl>
            </li>
<!--        </ul>-->
        <?php
        $i++;
    }
}

// ---------------------------------------------------------------------------------------------------------------------

function search_case($handle,$request,$headers)
{
    $counter = 0;
    $books = array();
    $book_duplcate_coutners = array();
    $request_small = mb_strtolower($request);

    if ($handle) {
        while (($line = fgets($handle)) !== false) {

            $line_small = mb_strtolower($line);
            if (mb_strpos($line_small, $request_small) !== FALSE) {

                $buff = get_book_info($line, $headers);

//                echo "<p>";
//                var_dump($buff);      echo "<br>";
//                var_dump(end($books));
//                echo "</p>";
                if ($buff != null)
                    if ( empty($books) )   {    // for first book
                        $books[] = $buff;
                        $book_duplcate_coutners[] = 1;
                        $counter++;
                    }
                    else
                        if ( is_array($buff)) {
                            $counter++;
                            if (array_diff($buff, end($books))) {
                                $books[] = $buff;
                                $book_duplcate_coutners[] = 1;
                            } else {
                                $book_duplcate_coutners[count($books)-1]++; // ustawia index ilości książek na 1
                            }
                        }
            }
        }
        fclose($handle);
    } else {
        header("location:index.php?error=db");
    }
    return array($counter, $book_duplcate_coutners, $books);
}

// ---------------------------------------------------------------------------------------------------------------------

function search_fast($handle,$request,$headers)
{
    $counter = 0;
    $books = array();
    $book_duplcate_coutners = array();

    if ($handle) {
        while (($line = fgets($handle)) !== false) {

            if (mb_strpos($line, $request) !== FALSE) {

                $buff = get_book_info($line, $headers);

                if ($buff != null)
                    if ( empty($books) )   {    // for first book
                        $books[] = $buff;
                        $book_duplcate_coutners[] = 1;
                        $counter++;
                    }
                    else if ( is_array($buff)) {
                        $counter++;
                        if (array_diff($buff, end($books))) {
                            $books[] = $buff;
                            $book_duplcate_coutners[] = 1;
                        } else {
                            $book_duplcate_coutners[count($books)-1]++; // ustawia index ilości książek na 1
                        }
                    }
            }
        }
        fclose($handle);
    } else {
        header("location:index.php?error=db");
    }
    return array($counter, $book_duplcate_coutners, $books);
}

// ---------------------------------------------------------------------------------------------------------------------

function get_book_info($line,$n)
{
    $value = explode("|",$line);

    if( empty($value[$n['OPIS_AUTOR']]) ||  $value[$n['OPIS_AUTOR']] === "")
        return null;
    else
    {
        $value = regex_prepare($value,$n);
//        if (preg_match(preg_quote('/[0-9]*[-| ][0-9]*[-| ][0-9]*[-| ][0-9]*[-| ][0-9]*/', "*"), $value[$n['OPIS_DANE']], $isbn))
//    if ( preg_match(preg_quote (), $value[$n['OPIS_DANE']], $isbn) ) {
//            $isbn;
//        echo "<pre>";

//        print_r($value[col('OPIS_DANE')]);

//          preg_match('/920\s*a([0-9]{3}\-[0-9]{2}\-[0-9]{5}\-[0-9]{2}\-[0-9])\s*\(wersja druk\.\)/',$value[$n['OPIS_DANE']],$isbn);

//        print_r($isbn);
//        var_dump($isbn);

//        if( nullowanie )

        return array(
            $n['OPIS_AUTOR']    => $value[$n['OPIS_AUTOR']],
            $n['OPIS_TYTUL']    => $value[$n['OPIS_TYTUL']],
            $n['OPIS_WYDAWCA']  => $value[$n['OPIS_WYDAWCA']],
            $n['OPIS_MWYD']     => $value[$n['OPIS_MWYD']],
            $n['OPIS_RWYD']     => $value[$n['OPIS_RWYD']],
            $n['ZKS_SYGNAT']    => $value[$n['ZKS_SYGNAT']],
            'ISBN'              => $value[$n['OPIS_DANE']],
//            'ISBN'              => $isbn
        );
    }
}

// ---------------------------------------------------------------------------------------------------------------------

function regex_prepare($value,$n)
{
//    var_dump($value);
    // nieudana próba wyciągania całego tytułu z surowaych danych
    /*
    if (preg_match('/245\s*a([\s\S]+[0-9])/', $value[$n['OPIS_DANE']], $tytuł))
    {
            var_dump($tytuł);
//        if (
                preg_match('/[\s\S]+/', $tytuł, $buff);
//        )
//        {
            var_dump($buff);
        // jeśli początek tekstów taki sam ...\
//        $value[$n['OPIS_TYTUL']] = $tytuł[2]." ".$autor[1];
    }
    */


    if(empty($value[$n['OPIS_AUTOR']]))
        $value[$n['OPIS_AUTOR']] = null;
    else
    {
        $data = null;
            // preg data

//        var_dump($value[$n['OPIS_AUTOR']]);
        if (preg_match('/([a-zA-ZżźćńółęąśŻŹĆĄŚĘŁÓŃ\s\S]+),{1}\s*([a-zA-Z\SżźćńółęąśŻŹĆĄŚĘŁÓŃ\(\)-]*).*/', $value[$n['OPIS_AUTOR']], $autor))
            $value[$n['OPIS_AUTOR']] = $autor[2]." ".$autor[1];
    }

    if(empty($value[$n['ZKS_SYGNAT']]))
        $value[$n['ZKS_SYGNAT']] = null;
    else
    {
        if(!empty($value[$n['RKS_TEKST']]))
            $value[$n['ZKS_SYGNAT']] = $value[$n['RKS_TEKST']];
//        if (preg_match('/([a-zA-ZżźćńółęąśŻŹĆĄŚĘŁÓŃ\s]+),{1}\s*([a-zA-ZżźćńółęąśŻŹĆĄŚĘŁÓŃ\(\)-]*).*/', $value[$n['OPIS_AUTOR']], $autor))
//            $value[$n['OPIS_AUTOR']] = $autor[2]." ".$autor[1];

    }

    if(empty($value[$n['OPIS_WYDAWCA']]))
        $value[$n['OPIS_WYDAWCA']] = null;
    else
    {
        if (preg_match('/^\"{1}([a-zA-ZżźćńółęąśŻŹĆĄŚĘŁÓŃ\s\S]+)\"{1}$/', $value[$n['OPIS_WYDAWCA']], $wydawca ))
            $value[$n['OPIS_WYDAWCA']] = $wydawca;

        if(is_array($wydawca) && !empty($wydawca[1]))
            $value[$n['OPIS_WYDAWCA']] = $wydawca[1];
        else if (!empty($wydawca[0]))
            $value[$n['OPIS_WYDAWCA']] = $wydawca[0];
//        else
//            $value[$n['OPIS_WYDAWCA']] = null;
    }

    if(empty($value[$n['OPIS_RWYD']]))
        $value[$n['OPIS_RWYD']] = null;

//        print_r($value);
//        print_r($n);
//        echo $n[0];
    $isbn = null;
//        echo "</pre>";

    if (!empty($value[$n['OPIS_DANE']])) {
        if (preg_match('/920\s*a([0-9]{1,5}\-[0-9]{1,7}[-\ ]{0,2}[0-9]{1,6}\-[0-9X]{1,6}-[0-9X]{1})[\s.]+/', $value[$n['OPIS_DANE']], $isbn))
            $isbn = $isbn[1];//99% centerly 10386/10480 books founded
        else if (preg_match('/920\s*a([0-9]{9,12}[0-9X]{1})[\s.]+/', $value[$n['OPIS_DANE']], $isbn))
            $isbn = $isbn[1];//,5%
        else if (preg_match('/920\s*a([0-9]{1,5}\-[0-9]{1,7}\-[0-9]{1,6})[\s.]+/', $value[$n['OPIS_DANE']], $isbn))
            $isbn = $isbn[1];//,2%
        else if (preg_match('/920\s*a([0-9]{2}\-[0-9]{5}\-[0-9]{2}\-[0-9X]{1})/', $value[$n['OPIS_DANE']], $isbn))
            $isbn = $isbn[1];//,05%
        else if (preg_match('/920\s*a([0-9]{2,3}\-[0-9]{2,7}\-[0-9]{1,5}\-[0-9X]{1,2})[\s.]+/', $value[$n['OPIS_DANE']], $isbn))
            $isbn = $isbn[1];// 1 book found
    }

    if (is_array($isbn))
        $isbn = null;

    $value[$n['OPIS_DANE']] = $isbn;

    return $value;
}

// ---------------------------------------------------------------------------------------------------------------------

function check_database( $filename, $fraza = '|' )
{
    if (!file_exists($filename)){
        echo "<h2 class='alert-danger modal-header'>File not exist</h2>";
        return;
    }

    $handle = fopen( $filename, 'r');

    $counter = 0;
    $counter_diffrent_pipeline_count_per_line = 0;

    if ($handle) {
        $nr_line = 1;
        $line = fgets($handle);
        $ref_nuber_of_pipelie = substr_count($line,'|');
        $nr_line++;

        while (($line = fgets($handle)) !== false) {
//            echo $line;
            if (strpos( $line,$fraza) === FALSE)
                $counter++;
            if( $ref_nuber_of_pipelie != substr_count($line,'|') )
            {
                $counter_diffrent_pipeline_count_per_line++;
                if($counter_diffrent_pipeline_count_per_line == 1)
                    $diff_line_num = $nr_line;
            }

        }
        fclose($handle);
    }

    if ($counter > 0)
    {
        echo "<h2 class='alert-warning modal-header'>Database is corupted</h2>";
        echo "<p class=\"lead\"> Corupted records <span class='danger-ic'>$counter</span> of ".count(file($filename)).
             " <span class='danger-ic'>(".round($counter / (count(file($filename)) / 100),1)."%)</span></p>";

        $linie = file('error.log');
        echo "<p>";
        foreach($linie as $linia){
            echo $linia."<br>";
        }
        echo "</p>";

    }
    else {
        echo "<h2 class='alert-success modal-header'>No error in " . count(file($filename)) . " records</h2><hr>";
        echo "<p class=' alert-info modal-notify p-2'><b>Info:</b> Nazwę bazy danych <b>csv</b> należy ustawić ręcznie w pliku <i>config.php</i> </p>";

    }
    if($counter_diffrent_pipeline_count_per_line)
        echo "Prawdopodobnie uszkodzonych rekordów ".$counter_diffrent_pipeline_count_per_line." <i>
            (liczba krotek danej książki jest inna niż ilość kolumn)</i> Pierwszy wyjątek w lini ".$diff_line_num;
}

// ---------------------------------------------------------------------------------------------------------------------
function  list_databases($path = "db/")
{
    $config = include "config.php";
    echo "<div class='d-flex justify-content-between'><div class='mt-4'>";
    $thelist = "";

    echo "Dostępnne bazy: ";
    if ($handle = opendir($config['db_dir'].".")) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'csv') {
                $thelist .= "<a href=\"?check=$path$file\" class=\"m-1 badge badge-pill green\"> $file</a>";
            }
        }
        closedir($handle);
    }
    echo  $thelist;
?>      </div>
        <div>
            <a href="?convert_db" role='button' class="btn btn-outline-light-blue">Konwertuj</a>
            <a href="?add_db" role='button' class="btn btn-outline-cyan">Dodj nową bazę</a>
        </div>
    </div>
<?php
    echo  "<hr>";
}

// ---------------------------------------------------------------------------------------------------------------------

function col($column_name)
{
    $config = include "config.php";
    $array = headers_get($config['csv']);
    var_dump($array);
    $int = intval($array[$column_name]+0);
    return $int;
}
// ---------------------------------------------------------------------------------------------------------------------

function display_files_to_convert()
{
    $config = include "config.php";
    include_once "functions.php";
    $thelist = "";
    echo "<p class='lead'>Wybierz plik do konwersji na CSV</p>";
    if ($handle = opendir( $config['db_dir']) ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'rpt') {
                $thelist .= "<a href=\"?convert_db=$file\" class=\"m-1 badge badge-pill  hoverable btn-brown btn \" style='color: #0f478a; !important;'> $file</a>";
            }
        }
        closedir($handle);
    }

    if (empty($thelist))
        echo "<h5> Brak plików *.rpt do konwersji</h5>";
    else
        echo $thelist;

    if (!empty($_GET['convert_db'])) {
        convert_rpt2csv( $config['db_dir'].$_GET['convert_db'] );
    }

    ?>      </div>
    <div>
<!--        <a href="?convert_db" role='button' class="btn btn-outline-light-blue">Konwertuj</a>-->
<!--        <a href="?add_db" role='button' class="btn btn-outline-cyan">Dodj nową bazę</a>-->
    </div>
    </div>
    <?php
    echo  "<hr>";
}

// ---------------------------------------------------------------------------------------------------------------------

function convert_rpt2csv( $filename, $outfile = "")
{
    if (empty($outfile))
    {
        $buff = explode( '.',$filename);
        array_pop($buff);
        $outfile = implode(".",$buff).".csv";
        $outfile = prevent_file_overwrite($outfile);
    }

// file conversion to csv
    $lines = null;
    $handle = fopen($filename, "r");
    if ($handle) {

        $lines[] = fgets($handle);  // pierwsza linia zawiera nagłówki

        while (($line = fgets($handle)) !== false) {

            // linia nie zawiera "|", usuń znak nowej lini
            if ($line[0] != "|" && strpos($line,"|") == 0)
                $line = str_replace(array("\n", "\r"), '', $line);

            // jeżeli linia w formacie "id|001 amol2000"
            if (preg_match('/[0-9]{1,}\|{1}001\s*amol2000/', $line, $isbn))
                $line = str_replace(array("\n", "\r"), '', $line);

                $lines[] = $line;
            // process the line read.
        }

        fclose($handle);
    } else {
        echo "error file not open in rpt2csv()";
    }

    while ( empty(end($lines)) )
    {
        array_pop($lines);
        // pomija (usuwa) linie z tekstem w nawiasach (komentarze dodawane przy eksporcie)
        if ( preg_match( "/^\({1}[\s\S]*\){1}$/", end($lines)) )
            array_pop($lines);
    }

    $buff = array_pop($lines);
    $buff = str_replace(array("\n", "\r"), '', $buff);
    array_push($lines,$buff);

//file_put_contents('ids.txt', implode("\n", $gemList) . "\n", FILE_APPEND);
    $file = fopen($outfile, "w");
    fwrite($file, implode('', $lines));
    fclose($file);

    echo "<br>No error converting ".count($lines)." records to ".count(file($outfile))." records ";
    echo "<a href=\"$outfile\" class='btn btn-outline-green'>$outfile</a>";
    echo "<br><br>Początek wgrywanego pliku<hr class='mt-1'>";

    echo "<pre>";
    for( $i = 0; $i<13; $i++)
        echo $lines[$i]."\n";
    echo "</pre>";
    echo "</pre><a role='button' class='btn primary-color-dark' href=\"index.php?check=$outfile\">Sprawdź integralność skonwertowanej bazy</a>";
}

// --------------------------------------------------------------------------------------------------------------------

function prevent_file_overwrite($filename)
{
    if( file_exists($filename)){
        $increment = 0;
        $name = explode('.', $filename);
        $ext = array_pop($name);
        $name = implode('.',$name);

        while(file_exists($filename)) {
            $increment++;
            // $loc is now "userpics/example1.jpg"
            $filename = $name." (".$increment.")".'.'.$ext;
        }
    }
    return $filename;
}

// ---------------------------------------------------------------------------------------------------------------------

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// ---------------------------------------------------------------------------------------------------------------------

function send_contact_mail($from, $to , $message, $title )
{
    echo "<p>Wysyłanie wiadomości ... </p>";

    if (empty($message))
        echo "<P class='text-danger'>Brak treści wiadomości</P>";

    if (empty($title))
        $title = 'Wiadomość od gościa Biblioteki ZST';

    $headers = "From: $from"."\r\n".
        "Reply-To: $from"."\r\n".
        'X-Mailer: PHP/'.phpversion();
    var_dump($headers);

    //$naglowki = "From: moj@mail.pl".PHP_EOL."Reply-To: moj@mail.pl".PHP_EOL."Content-type: text/plain; charset=iso-8859-2";
    $message = mb_convert_encoding($message, "iso-8859-2", "auto");

//                if (mail('piotrwzst@gmail.com', 'Bibliteka ZST - Statystyka', $message)) {
    if (mail($to, $title, $message, $headers)) {
        echo "<p class='text-success'>Wiadomość została wysłana</p>";
    } else {
        echo "<p class='text-warning'>Wiadomość <span class='text-danger'><b>nie</b></span> została wysłana</p>";
    }
    echo "<a href='./' class='btn btn-green' role='button'> Powrót do strony głównej</a>";
}