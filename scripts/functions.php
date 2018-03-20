<?php

function getTotalCredit($db_con, $userId)
{
    $stmt = $db_con->prepare("SELECT amount FROM instanttransactiontlog i left join accounts a on i.toaccount = a.accountNumber WHERE a.userId=:uid");
    $stmt->execute(array(":uid" => $userId));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalAmount = 0;
    $sum = 0;
    foreach ($rows as $row)
        $amount = $row['amount'];
    $totalAmount =  $sum + (int)$amount;
    return  $totalAmount;

}

function getTotalWithDrawal($db_con, $userId){
    $stmt = $db_con->prepare("SELECT amount FROM instanttransactiontlog i left join accounts a on i.fromaccount = a.accountNumber WHERE a.userId=:uid");
    $stmt->execute(array(":uid" => $userId));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalAmount = 0;
    foreach ($rows as $row){
    $amount = $row['amount'];
    $totalAmount =  $totalAmount + (int)$amount;
	}
    return  $totalAmount;
}

function getMiniStatement($db_con, $userId){
    $accountNumber = getCustomerAccountNumber($db_con, $userId);
    $stmt = $db_con->prepare("SELECT amount, transactionDate, narration, DRCR FROM instanttransactiontlog i where i.toAccount=:accountNumber || i.fromAccount=:accountNumber order by transactionDate desc LIMIT 20");
    $stmt->execute(array(":accountNumber" => $accountNumber));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $rows;
}

function getFullStatement($db_con, $userId){
    $accountNumber = getCustomerAccountNumber($db_con, $userId);
    $stmt = $db_con->prepare("SELECT amount, transactionDate, narration, DRCR FROM instanttransactiontlog i where i.toAccount=:accountNumber || i.fromAccount=:accountNumber order by transactionDate desc");
    $stmt->execute(array(":accountNumber" => $accountNumber));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $rows;
}

function getCustomerAccountNumber($db_con, $userId){
    $stmt = $db_con->prepare("SELECT * FROM accounts WHERE userid=:uid");
    $stmt->execute(array(":uid"=>$userId));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $accountNumber = $row['accountNumber'];
    return $accountNumber;
}

function getCustomerBankCode($db_con, $userId){
    $stmt = $db_con->prepare("SELECT bankCode FROM accounts WHERE userid=:uid");
    $stmt->execute(array(":uid"=>$userId));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $bankCode = $row['bankCode'];
    return $bankCode;
}

function getUserDetails($db_con, $userId){
    $stmt = $db_con->prepare("SELECT * FROM users WHERE user_id=:uid");
    $stmt->execute(array(":uid"=>$userId));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function getTransferHistory($db_con, $userId){
    $accountNumber = getCustomerAccountNumber($db_con, $userId);
    $stmt = $db_con->prepare("SELECT amount, transactionDate, narration, bankName, DRCR FROM instanttransactiontlog i left join banks b on i.fromBank = b.bankCode where i.fromAccount=:accountNumber order by transactionDate desc");
    $stmt->execute(array(":accountNumber" => $accountNumber));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $rows;
}

function getBankList($db_con){
	$bankCode = "003";
    $stmt = $db_con->prepare("SELECT * from banks where bankCode <> :bankCode order by bankName ASC");
    $stmt->execute(array(":bankCode" => $bankCode));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $rows;
}
?>