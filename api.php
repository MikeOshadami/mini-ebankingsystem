<?php
include_once 'dbconfig.php';
include_once 'scripts/accounts.php';
$bankCode = $_GET["bankCode"];
$accountName = "";
$accountNumber = $_GET["accountNumber"];
$getAccountName = getAccountName($db_con, $bankCode, $accountNumber);
$accountName = $getAccountName['user_name'];
if(isset($accountName) === true && $accountName === '' || $accountName == NULL ){
	$responseCode = "99";
}
else {
	$responseCode = "00";
}
$data = [ 'name' => $accountName, 'accountNumber' => $accountNumber, 'responseCode' => $responseCode];
header('Content-Type: application/json');
echo json_encode($data);
?>