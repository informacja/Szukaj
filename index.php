<!DOCTYPE html>
<html lang="pl">

<?php   $config = include "config.php"; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Wyszukiwarka książek biblioteki szkolnej ZST Tarnów">
    <meta name="keywords" content="OPAC, Katalog online, ZST, tarnów, mościce, biblioteka szkolna, znajdź książkę, szukaj książek">
    <title>Biblioteka ZST - Zbiory</title>
    <link rel="icon" type="image/png" sizes="32x32" href="mdb/favicon32x32.png">
    <!-- Font Awesome -->
    <?php //echo "<link href='$config[path]css/font-awesome.min.css' rel='stylesheet'>"; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <?php echo "<link href='$config[path]css/bootstrap.min.css' rel='stylesheet'>"; ?>
    <!-- Material Design Bootstrap -->
    <?php echo "<link href='$config[path]css/mdb.min.css' rel='stylesheet'>"; ?>
    <!-- Your custom styles (optional) -->
    <?php echo "<link href='$config[path]css/style.css' rel='stylesheet'>"; ?>
    <!-- Skins -->
    <?php echo "<link href='$config[path]css/skins.css' rel='stylesheet'>"; ?>
    <!-- Hint on hover library-->
    <?php echo "<link href='$config[path]css/hint.min.css' rel='stylesheet'>"; ?>
</head>
<body  class=" <?php
                    if (isset($_COOKIE['color']))
                         echo "$_COOKIE[color]";
                    else echo "indigo-skin";
                ?>
             ">
<?php

    include "menu.php";

    echo '<main class="p-1 px-5">';

    handle_request();   // obsługa poleceń z teblicy $_GET

    echo "</main>";

    include "footer.php";

    //if ( empty($_GET))
    //    include "contact_form.php";

?>
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <?php echo "<script type='text/javascript' src='$config[path]js/jquery-3.2.1.min.js'></script>" ?>
    <!-- Bootstrap tooltips -->
    <?php echo "<script type='text/javascript' src='$config[path]js/popper.min.js'></script>" ?>
    <!-- Bootstrap core JavaScript -->
    <?php echo "<script type='text/javascript' src='$config[path]js/bootstrap.min.js'></script>" ?>
    <!-- MDB core JavaScript -->
    <?php echo "<script type='text/javascript' src='$config[path]js/mdb.min.js'></script>" ?>

    <?php  include "guest_counter.php"; ?>

<script>
    if ( $('#radio_buttons').length ) // jeśli istnieje
    {
        $('input[type=radio]').on('change', function () {
            $(this).closest("form").submit();
        });
        $("#search").focus();
    }

    $('.text-truncate').on('click', function() {
//    $('.text-truncate').each(function() {
        $(this).removeClass("text-truncate");
    });

</script>
</body>

</html>


<?php

function handle_request()
{
    include_once "functions.php";
    $config = include "config.php";

    if(!empty($_GET['category_request'])) {
        $a = $_GET['category_request'];
        header('Location: index.php?request='.$a.'');
    }

    if(!empty( $_GET['request'] ))
        include "reaction.php";
    else if ( isset($_GET['error']) && $_GET['error'] == "db" )
    {
        echo "<h2 class='mt-5'>Błąd połączenia z bazą danych</h2><p>Proszę spróbować ponownie, póżniej</p>";
        echo "<a href='index.php' <button class='btn primary-color'> Spróbuj ponownie </button> </a>";
    }
    else if(isset($_GET['los']))
    {
        include "los.php";
    }
    else if(isset($_GET['check']) || isset($_GET['admin']) )
    {
        $filename = $config['csv'];

        if (!empty($_GET['check']))
            $filename = $_GET['check'];
        list_databases($config['db_dir']);
        echo "<p> Nazwa bazy danych: <b>$filename</b></p>";
        check_database($filename);
    }
    else if( isset($_GET['add_db']) )
    {
        include "how_to_update_db.php";
    }
    else if( isset($_GET['upload']) )
    {
        include "upload.php";
    }
    else if( isset($_GET['convert_db']) )
    {
        display_files_to_convert();
    }
    else if( isset($_GET['send_mail'] ) )
    {
        send_contact_mail( $_POST["mail"], $config['admin_mail'], $_POST['message'], $_POST['title']);
    }
    else
        include "search.php";
}

?>