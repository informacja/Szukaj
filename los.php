<?php
/**
 * Created by PhpStorm.
 * User: Puler
 * Date: 04.03.2018
 * Time: 18:26
 */
    $config = include "config.php";
    require_once "functions.php";

    print_one_book( $config['csv'] );

    include "search_form.php";

// ---------------------------------------------------------------------------------------------------------------------

function print_one_book( $file )
{
    $config = include "config.php";
//    $file = basename($_SERVER['PHP_SELF']);

    $lines = file($file);//file in to an array
    $count_of_lines = count($lines);
//    echo "There are $count_of_lines lines in $file"."\n";
	$i = 0;
    do {
		$i++;
        if (!empty($_GET["los"]) && is_numeric($_GET["los"]))
            $random_book_line = $_GET["los"];
        else
        $random_book_line = rand(0, $count_of_lines);

//        echo $lines[$random_book_line]; //line

        $headers = headers_get($file);

//        $id = get_book_id($lines[$random_book_line],$headers);
//        if( !empty($id) )
//            $_GET['los'] = $id;


        $desc = get_book_info($lines[$random_book_line], $headers);

        if (empty($desc))
            file_put_contents("error.log",
                '[' . date('d-m-Y ') . date("H:i:s") . "] Error access random line nr: " . $random_book_line . " in $config[csv]\n", FILE_APPEND | LOCK_EX);
    }while ( empty($desc) && $i > 2 );


    // structure requaired by print_books()
    // count, dublicate, book_array
    $parm = array( 1, 1, array( $desc ));

    echo "<div class='animated fadeIn py-4' style='min-height: 30vh'>";
    print_books( $parm, $headers );
    echo "</div>";
}
// ---------------------------------------------------------------------------------------------------------------------

function  get_book_id($line,$headers)
{
//    var_dump($headers);
    if ( reset($headers) === 0 ) // jeżeli id_ksiązki jest pierwszym kluczem
    {
        $buff = (explode("|",$line));
        return $buff[0];
    }
    else if ( $headers["OPIS_ID"] ) ;
//    current(array_keys($array));
}

?>

