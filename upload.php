<?php
$config = include "config.php";
include_once "functions.php";


$target_dir = "";
if( !empty($config["db_dir"])) {
    $target_dir = $config["db_dir"];
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0644, false);
    }
}

//var_dump($_FILES);
//var_dump($_POST['rename']);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if ( isset($_POST['rename']) )
{
    $array = explode('.', $_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir.date("m.Y").".".end($array);
}

// Check if file already exists
if( file_exists($target_file) ) {

    echo "<p>File $target_file file already exists.</p>";

    $target_file = prevent_file_overwrite($target_file);

    echo "<p>Renamed to<b> $target_file</b></p>";
}
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
    {
        echo "The file <i>". basename( $_FILES["fileToUpload"]["name"]). "</i> has been uploaded as <i>$target_file</i>";
        echo "<a href=\"$target_file\" class='btn btn-outline-cyan'>Zobacz plik</a>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $filename = explode('.',$target_file);
    if ( mb_strtolower(end($filename)) == "zip" || mb_strtolower(end($filename) ) == "7z" )
        $target_file = unzip( $target_file, $target_dir );

if (isset($_POST['convert']) && $_POST['convert'] == true )
{
    if (file_exists($target_file)) {
        $array = explode('.', $target_file);
        array_pop($array);
        convert_rpt2csv($target_file, prevent_file_overwrite(implode('.', $array) . ".csv"));
    }
    else echo "<p>File <b>$target_file</b> not exist, converting stopped</p>";
}


function unzip( $filename, $target_dir = "" )
{
    $array = explode('.', $filename);
    $extension = array_pop($array);

    if ( mb_strtolower($extension) == "zip" || mb_strtolower($extension) == "7z" )
    {
        chmod($filename, 755);
        $zip = new ZipArchive;
        $res = $zip->open($filename);
        if ($res === TRUE) {

            $file= $zip->getNameIndex(0);
            $fileinfo = pathinfo($file);
            $new_file = prevent_file_overwrite($target_dir.$fileinfo['basename'] );
//            $zip->extractTo("tmp");
            if(copy("zip://".$filename."#".$file, $new_file))
                echo '<tt class="success-ic">Unzip '.$new_file.' success </tt>';
            else
                echo '<tt class="danger-ic">Unzip '.$new_file.' error </tt>';
            $zip->close();

            return $new_file;
        } else {
            echo '<tt class="danger-ic">Failed Unzip';
            return "error in UNZIP";
        }
    }
}

