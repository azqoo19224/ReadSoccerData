<?php
header("content-type: text/html; charset=utf-8");
header("Refresh: 60; url='https://azqoo-azqoo19224.c9users.io/Gambling/Gambling.php'");

require_once 'DB.php';

DB::pdoConnect();

deleteDate();

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, "http://www.228365365.com/sports.php");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_exec($ch);

$url = "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=";

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
$pageContent = curl_exec($ch);
curl_close($ch);

$test = fopen("test.txt", "w");
fwrite($test, $pageContent);
fclose($test);
$test = fopen("test.txt", "r");

while (!feof($test)) {
    $a = fgets($test);

    if (false == $a) {
        break;
    }

    if (preg_match_all("/parent.GameFT/", $a)) {
        $a = str_replace("new A", "A", $a);
        $a = str_replace("<font color=red>Running Ball</font>", " ", $a);
        $a = str_replace("<br>", " ", $a);
        $a = str_replace("'", "", $a);
        $result .= $a;
    }
}
// //切割字串
$arr = explode("parent.GameFT", $result);

$i = 0;
foreach ($arr as $key) {

    $brr = explode(",", $key);

    $data['id'] = $i;
    $data['day'] = $brr[1];
    $data['name'] = $brr[2];
    $data['name1'] = $brr[5];
    $data['name2'] = $brr[6];
    $data['overalHandicap1'] = $brr[9];
    $data['overalHandicap2'] = $brr[10];
    $data['overalSize1'] = $brr[13];
    $data['overalSize2'] = $brr[14];
    $data['overallWin1'] = $brr[15];
    $data['overallWin2'] = $brr[16];
    $data['overallWin3'] = $brr[17];
    $data['single'] = $brr[20];
    $data['double'] = $brr[21];
    $data['halfHandicap1'] = $brr[25];
    $data['halfHandicap2'] = $brr[26];
    $data['halfSize1'] = $brr[29];
    $data['halfSize2'] = $brr[30];
    $data['halfWin1'] = $brr[31];
    $data['halfWin2'] = $brr[32];
    $data['halfWin3'] = $brr[33];

    $sql = "INSERT INTO  `data`  (`id`, `day`, `name`, `name1`, `name2`, `overalHandicap1`, `overalHandicap2`,
    `overallWin1`, `overallWin2`, `overallWin3`, `single`, `double`, `halfHandicap1`, `halfHandicap2`, `halfSize1`,
     `halfSize2`, `halfWin1`, `halfWin2`, `halfWin3`) VALUES (:id, :day, :name, :name1, :name2, :overalHandicap1,
    :overalHandicap2, :overallWin1, :overallWin2, :overallWin3, :single, :double, :halfHandicap1,
    :halfHandicap2, :halfSize1, :halfSize2, :halfWin1, :halfWin2, :halfWin3)";
    $update = DB::$db->prepare($sql);
    $update->bindParam(':id', $data['id']);
    $update->bindParam(':day', $data['day']);
    $update->bindParam(':name', $data['name']);
    $update->bindParam(':name1', $data['name1']);
    $update->bindParam(':name2', $data['name2']);
    $update->bindParam(':overalHandicap1', $data['overalHandicap1']);
    $update->bindParam(':overalHandicap2', $data['overalHandicap2']);
    $update->bindParam(':overallWin1', $data['overallWin1']);
    $update->bindParam(':overallWin2', $data['overallWin2']);
    $update->bindParam(':overallWin3', $data['overallWin3']);
    $update->bindParam(':single', $data['single']);
    $update->bindParam(':double', $data['double']);
    $update->bindParam(':halfHandicap1', $data['halfHandicap1']);
    $update->bindParam(':halfHandicap2', $data['halfHandicap2']);
    $update->bindParam(':halfSize1', $data['halfSize1']);
    $update->bindParam(':halfSize2', $data['halfSize2']);
    $update->bindParam(':halfWin1',$data['halfWin1']);
    $update->bindParam(':halfWin2',$data['halfWin2']);
    $update->bindParam(':halfWin3',$data['halfWin3']);
    $update->execute();

    $i++;
}


function deleteDate() {
    $sql = 'DELETE FROM `data`';
    $delete = DB::$db->prepare($sql);
    $delete->execute();
}
