<?php

function getAccountName($db_con, $bankCode, $accountNumber){
    $stmt = $db_con->prepare("SELECT user_name from accounts a left join users u on a.userId=u.user_id where a.bankCode=:bankCode and a.accountnumber=:accountnumber");
    $stmt->bindValue(':bankCode', $bankCode);
    $stmt->bindValue(':accountnumber', $accountNumber);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    return  $rows;
}

function makeInterbankTransfer($pdo, $fromAccount, $fromBank, $toAccountNumber, $toBankCode, $amount, $description){
  //We start our transaction.
    $pdo->beginTransaction();
 try{
	 $transactionRef = mt_rand();
	 $transitAccount =  getBankTransitAccount($pdo, $fromBank);
	 $toBankTransitAccount =  getBankTransitAccount($pdo, $toBankCode);
    //Query 1: 
    $sql = "INSERT INTO instanttransactiontlog (transactionRef, toAccount, toBank, amount, fromAccount, fromBank, responseCode, transactionDate, DRCR, narration) VALUES (?, ?, ?, ?, ?, ?, ?, Now(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            $transactionRef, 
            $transitAccount,
			$fromBank,
			$amount,
			$fromAccount,
			$fromBank,
			"00",	
			"DR",
			$description
        )
    );
    
    //Query 2: 
    $sql = "INSERT INTO instanttransactiontlog (transactionRef, toAccount, toBank, amount, fromAccount, fromBank, responseCode, transactionDate, DRCR, narration) VALUES (?, ?, ?, ?, ?, ?, ?, Now(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            $transactionRef, 
            $toAccountNumber,
			$toBankCode,
			$amount,
			$toBankTransitAccount,
			$toBankCode,
			"00",	
			"CR",
			$description
        )
    );
    
    //We've got this far without an exception, so commit the changes.
    $pdo->commit();
    
} 
//Our catch block will handle any exceptions that are thrown.
catch(Exception $e){
    //An exception has occured, which means that one of our database queries
    //failed.
    //Print out the error message.
    echo $e->getMessage();
    //Rollback the transaction.
    $pdo->rollBack();
}
	
}
function getBankTransitAccount($db_con, $bankCode){
    $stmt = $db_con->prepare("SELECT * FROM bankftpsettings WHERE bankCode=:bankId");
    $stmt->execute(array(":bankId"=>$bankCode));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $transitAccount = $row['transitAccount'];
    return $transitAccount;
}
?>