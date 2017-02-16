<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

date_default_timezone_set('Europe/Berlin');
session_start();
if (!filter_has_var(INPUT_GET, 'page')) {
    $page = "home";
} else {
    $page = filter_input(INPUT_GET, 'page');
    if (!file_exists("server/pages/" . $page . ".php") || strpos($page, "..") !== false || substr($page, 0, 1) === "/") {
        $page = "404";
    }
}
require_once 'checkLogin.php';
if ($page !== "login") {
    if ($username === NULL) {
        header('Location: index.php?page=login');
    }
}

require_once "lib/class.mysql.php";
$DB = new MySQL();
?>

<!DOCTYPE html>
<html lang="de">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Data Site for Ferraris Panel">
        <meta name="author" content="Gurkengewuerz">
        
        <link rel="apple-touch-icon" sizes="57x57" href="images/manifest/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/manifest/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/manifest/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/manifest/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/manifest/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/manifest/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/manifest/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/manifest/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/manifest/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="images/manifest/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="images/manifest/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="images/manifest/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="manifest.json">

        <title>Data Panel</title>
        <link href="css/bootstrap.css" rel="stylesheet">

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/highcharts-more.js"></script>

        <?php
        if (file_exists("styles/" . $page . ".css")) {
            echo '<link rel="stylesheet" type="text/css" href="/css/' . $page . '.css" />';
        }
        ?>
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <?php
                require_once "server/nav.php";
                ?>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container">
            <?php
            require_once "server/pages/" . $page . ".php";
            ?>
        </div>

        <div class="container">

            <hr>
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; Gurkengewuerz 2016</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
    <script>
        $("#btn-logout").click(function () {
            $.ajax({
                url: 'api.php',
                type: "POST",
                async: true,
                data: {
                    'action': 'logout'
                },
                success: function (data) {
                    document.location.href = "index.php";
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    </script>
</html>