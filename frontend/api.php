<?php

// TODO: CHECK USER PERMISSIONS
session_start();
require_once "lib/class.mysql.php";
$DB = new MySQL();

$reqU = $_POST["action"];
if (!(isset($reqU) && !empty($reqU))) {
    exit("Action not set!");
}

$req = $DB->query("SELECT * FROM settings;");
foreach ($req as $ent) {
    $val = $ent["value"];
    switch ($ent["settingname"]){
        case "log_path":
            $log_path = $val;
            break;
        
        case "log_rows":
            $log_rows = $val;
            break;
    }
}

function tailCustom($filepath, $lines = 1, $adaptive = true) {
    $f = @fopen($filepath, "rb");
    if ($f === false)
        return false;
    if (!$adaptive)
        $buffer = 4096;
    else
        $buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
    fseek($f, -1, SEEK_END);
    if (fread($f, 1) != "\n")
        $lines -= 1;

    $output = '';
    $chunk = '';
    while (ftell($f) > 0 && $lines >= 0) {
        $seek = min(ftell($f), $buffer);
        fseek($f, -$seek, SEEK_CUR);
        $output = ($chunk = fread($f, $seek)) . $output;
        fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);
        $lines -= substr_count($chunk, "\n");
    }
    while ($lines++ < 0) {
        $output = substr($output, strpos($output, "\n") + 1);
    }
    fclose($f);
    return trim($output);
}

switch ($reqU) {
    case "add_user":
        if ($_SESSION['rank'] !== "admin") {
            exit("No Permission! (Needed admin+)");
        }
        $name = $_POST["name"];
        if (!(isset($name) && !empty($name))) {
            exit("Name not set!");
        }

        $pw = $_POST["password"];
        if (!(isset($pw) && !empty($pw))) {
            exit("Password not set!");
        }

        $req = $DB->query("INSERT INTO `users` (`name`, `password`, `rank`) VALUES ('" . $DB->escapeString($name) . "', '" . hash("sha256", $DB->escapeString($pw)) . "', 'user');");
        if ($req !== NULL) {
            echo 'OK';
        } else {
            exit("MySQL ERROR");
        }
        break;

    case "change_rank":
        if ($_SESSION['rank'] !== "admin") {
            exit("No Permission! (Needed admin+)");
        }
        $name = $_POST["name"];
        if (!(isset($name) && !empty($name))) {
            exit("Name not set!");
        }

        $newRank = $_POST["new_rank"];
        if (!(isset($newRank) && !empty($newRank))) {
            exit("New Rank not set!");
        }

        $req = $DB->query("UPDATE `users` SET `rank` = '" . $DB->escapeString($newRank) . "' WHERE `name` = '" . $DB->escapeString($name) . "';");
        if ($req !== NULL) {
            echo 'OK';
        } else {
            exit("MySQL ERROR");
        }
        break;

    case "change_password_seassion":
        if ($_SESSION['rank'] !== "user" || $_SESSION['rank'] !== "admin") {
            exit("No Permission! (Needed user+)");
        }
        $name = $_SESSION['username'];
        if (!(isset($name) && !empty($name))) {
            exit("Name not set!");
        }

        $newpw = $_POST["new_pw"];
        if (!(isset($newpw) && !empty($newpw))) {
            exit("New Password not set!");
        }

        $req = $DB->query("UPDATE `users` SET `password` = '" . hash("sha256", $DB->escapeString($newpw)) . "' WHERE `name` = '" . $DB->escapeString($name) . "';");
        if ($req !== NULL) {
            echo 'OK';
        } else {
            exit("MySQL ERROR");
        }
        break;

    case "remove_user":
        if ($_SESSION['rank'] !== "admin") {
            exit("No Permission! (Needed admin+)");
        }
        $name = $_POST["name"];
        if (!(isset($name) && !empty($name))) {
            exit("Name not set!");
        }

        $req = $DB->query("DELETE FROM `users` WHERE `name` = '" . $DB->escapeString($name) . "'");
        if ($req !== NULL) {
            echo 'OK';
        } else {
            exit("MySQL ERROR");
        }
        break;

    case "check_login":
        $name = $_POST["name"];
        if (!(isset($name) && !empty($name))) {
            exit("Name not set!");
        }

        $pw = $_POST["password"];
        if (!(isset($pw) && !empty($pw))) {
            exit("Password not set!");
        }

        $req = $DB->query("SELECT * FROM `users` WHERE `name` = '" . $DB->escapeString($name) . "' and `password` = '" . hash("sha256", $DB->escapeString($pw)) . "' LIMIT 1;");
        if ($req !== NULL) {
            if ($req[0]["name"] == $name) {
                echo 'OK';
                $_SESSION['username'] = $req[0]["name"];
                $_SESSION['rank'] = $req[0]["rank"];
            } else {
                exit("Invalid Login");
            }
        } else {
            exit("MySQL ERROR");
        }
        break;

    case "logout":
        session_destroy();
        break;

    case "logs":
        if ($_SESSION['rank'] !== "admin") {
            exit("No Permission! (Needed admin+)");
        }
        echo tailCustom($log_path, $log_rows);
        break;

    case "changeSettings":
        if ($_SESSION['rank'] !== "admin") {
            exit("No Permission! (Needed admin+)");
        }

        // Dynamisches Settings Updaten
        $sql_query = "";
        foreach ($_POST as $key => $value) {
            if ($key !== "action") {
                $sql_query = $sql_query . "UPDATE `settings` SET `value` = '" . $DB->escapeString($value) . "' WHERE `settingname` = '" . $DB->escapeString($key) . "';";
            }
        }

        $req = $DB->multi_query($sql_query);
        if ($req) {
            echo 'OK';
        } else {
            exit("MySQL ERROR");
        }
        break;
}