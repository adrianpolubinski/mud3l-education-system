<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
require_once "connection.php";
try {
	$aid= $_GET['aid'];
$lid= $_GET['lid'];
$tol= $_GET['tol'];
    $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
    if ($polaczenie->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {


$wynik1 = $polaczenie->query("SELECT link from sluchowiec where id=$aid;");
            	while ($row = $wynik1->fetch_assoc()) {
    $link= $row['link'];
}






$file = 'public_html/moodleuwb/demo/audio/'.$link;
echo $file;
$ftp_server="messengeruwb.xaa.pl";
// set up basic connection
$conn_id = ftp_connect($ftp_server);
$ftp_user_name="p562436";
$ftp_user_pass="h2riOY8Kf";
// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// try to delete $file
if (ftp_delete($conn_id, $file)) {
echo "$file deleted successful\n";
} else {
echo "could not delete $file\n";
}

// close the connection
ftp_close($conn_id);





        if ($polaczenie->query("delete from sluchowiec where id=$aid")) {
            $link = 'Location: lesson.php?lid='.$lid.'&tol='.$tol;
            header($link);
        }


    }
} catch (Exception $e) {
    echo $e;
}

?>