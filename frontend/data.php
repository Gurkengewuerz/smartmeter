<?php

$scale = $_GET["scale"];
if (!(isset($scale) && !empty($scale))) {
    exit("No Scale set");
}

function sub_date($days) {
    $date = new DateTime;
    $interval = new DateInterval('P' . $days . 'D');
    $date->sub($interval);
    return $date;
}

require_once "lib/class.mysql.php";
$DB = new MySQL();

$req = $DB->query("SELECT * FROM settings;");
foreach ($req as $ent) {
    $val = $ent["value"];
    switch ($ent["settingname"]) {
        case "resolution":
            $resolution = intval($val);
            break;

        case "interval_min":
            $interval = 60 / intval($val);
            break;
    }
}

$reqp = NULL;
$data = array();
$data["data"] = array();
$data["label"] = array();
$data["sum"] = array();

setlocale(LC_ALL, "de_DE.utf8");

switch ($scale) {
    case "now":
        $reqp = $DB->query("SELECT * FROM data ORDER BY timestamp DESC LIMIT 1");
        foreach ($reqp as $ent) {
            $data["label"][] = strftime("%H:%M", $ent["timestamp"]);
            $data["data"][] = round((intval($ent["value"]) * $interval) / $resolution, 2);
        }
        break;

    case "d":
        $reqp = $DB->query("SELECT * FROM data WHERE timestamp > " . date_timestamp_get(sub_date(1)) . " ORDER BY timestamp ASC");
        foreach ($reqp as $ent) {
            $data["label"][] = strftime("%H:%M", $ent["timestamp"]);
            $data["data"][] = round((intval($ent["value"]) * $interval) / $resolution, 2);
        }
        break;

    case "w":
        $reqp = $DB->query("SELECT FLOOR(timestamp/86400)*86400 AS timestamp_zsm, AVG(value) as v_data FROM data WHERE timestamp > " . date_timestamp_get(sub_date(6)) . " GROUP BY timestamp_zsm");
        foreach ($reqp as $ent) {
            $data["label"][] = strftime("%A", $ent["timestamp_zsm"]);
            $data["data"][] = round((intval($ent["v_data"]) * $interval * 24) / $resolution, 2);
        }
        break;

    case "m":
        $reqp = $DB->query("SELECT FLOOR(timestamp/86400)*86400 AS timestamp_zsm, AVG(value) as v_data FROM data WHERE timestamp > " . date_timestamp_get(sub_date(30)) . " GROUP BY timestamp_zsm");
        foreach ($reqp as $ent) {
            $data["label"][] = strftime("%d.%m", $ent["timestamp_zsm"]);
            $data["data"][] = round((intval($ent["v_data"]) * $interval * 24) / $resolution, 2);
        }
        break;

    case "y":
        $reqp = $DB->query("SELECT FLOOR(timestamp/2629800)*2629800 AS timestamp_zsm, AVG(value) as v_data FROM data WHERE timestamp > " . date_timestamp_get(sub_date(365)) . " GROUP BY timestamp_zsm");
        foreach ($reqp as $ent) {
            $data["label"][] = strftime("%B", $ent["timestamp_zsm"]);
            $data["data"][] = round((intval($ent["v_data"]) * $interval * 24 * 30) / $resolution, 2);
        }
        break;
}

if ($reqp === NULL) {
    exit();
}

$tmp = 0;
foreach ($data["data"] as $ent) {
	$tmp += $ent;
}

switch ($scale) {
	case "now":
		$tmp = $tmp/$interval;
		break;

	case "d":
		$tmp = $tmp/$interval;
		break;
}
$data["sum"][] = round($tmp, 2);


header("Content-type: application/json; charset=utf-8");
echo json_encode($data, JSON_PRETTY_PRINT);
