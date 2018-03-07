<?php
	session_start();
	require_once 'dbconfig.php';

	if(isset($_POST['btn-login']))
	{
		//$user_name = $_POST['user_name'];
        $account_number = trim($_POST['account_number']);
		$user_password = trim($_POST['password']);
		
		$password = md5($user_password);
		
		try
		{	
		
			$stmt = $db_con->prepare("SELECT * FROM users WHERE account_number=:account");
			$stmt->execute(array(":account"=>$account_number));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			
			if($row['user_password']==$password){
				
				echo "ok"; // log in
				$_SESSION['user_session'] = $row['user_id'];
			}
			else{
				
				echo "account number or password does not exist."; // wrong details
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>