<?php
session_start();
if(!isset($_SESSION['user_session']))
{
    header("Location: index.php");
}
include_once 'dbconfig.php';
include_once 'scripts/functions.php';
include_once 'scripts/accounts.php';

$userId = $_SESSION['user_session'];
$miniStatements = getFullStatement($db_con, $userId);
$customerAccountNumber = getCustomerAccountNumber($db_con, $userId);
$userDetails = getUserDetails($db_con, $userId);
$getTotalWithDrawal = getTotalWithDrawal($db_con, $userId);
$getTotalCredit = getTotalCredit($db_con, $userId);
$getAvailableBalance = $getTotalCredit - $getTotalWithDrawal;
$fromBankCode = getCustomerBankCode($db_con, $userId);
if(isset($_POST['submit'])){
    $error = false;
	
	$toAccountNumber = $_POST['accountNumber'];
	$toBankCode = $_POST['bankCode'];
	$amount = $_POST['amount'];
	$description = $_POST['description'];
	if ($amount > $getAvailableBalance){
	$message = "Insufficient Funds";
	$error = true;
	}
	if($error==false){
		//Submit Transfer Request
		$makeInterbankTransfer = makeInterbankTransfer($db_con, $customerAccountNumber, $fromBankCode, $toAccountNumber, $toBankCode, $amount, $description);
		$success="yyyy";
	}
}
$getTotalWithDrawal = getTotalWithDrawal($db_con, $userId);
$getTotalCredit = getTotalCredit($db_con, $userId);
$getAvailableBalance = $getTotalCredit - $getTotalWithDrawal;
$getBankList = getBankList($db_con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include  'partials/header.php'; ?>
</head>
<body>

<div id="wrapper">
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <?php include  'partials/header-nav.php'; ?>
  </nav>

  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Other Banks Transfer</h1>
      </div>
      <!-- /.col-lg-12 -->
    </div>

    <div class="row">
      <div class="col-lg-8">
<?php if (isset($success) && $error == false): ?>
<div class="alert alert-success">Transfer Successfull</div>
<?php elseif (isset($message) && $error == true): ?>
 <div class="alert alert-danger">Sorry there was an error. <?php echo $message ?></div>
<?php else: ?>

<?php endif; ?>

       <form role="form" method="POST" action="">
	   <div class="form-group">
                                            <label>From</label>
                                            <select class="form-control">
                                                <option><?php echo $userDetails['user_name'];  echo " " ; echo $customerAccountNumber; ?></option>
                                               
                                            </select>
											 <p class="help-block">Available Balance :NGN <?php echo number_format($getAvailableBalance) ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label>NGN Amount</label>
                                            <input type="text" class="form-control" required name="amount" id="amount">
                                            
                                        </div>
										 <div class="form-group">
                                            <label>Select Bank</label>
                                            <select name="bankCode" id="bankCode" class="form-control">
											 <?php foreach ($getBankList as $bank) { ?>
                                                <option value="<?php echo $bank['bankCode']; ?>"><?php echo $bank['bankName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
										<div class="form-group">
                                            <label>Account Number</label>
                                            <input type="text" maxlength="10" required class="form-control" name="accountNumber" id="accountNumber">
                                           <p class="help-block"><span id="submittername"></span></p>
                                        </div>
																				
										<div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="description" id="description">
                                           
                                        </div>
										 <input type="hidden" value="0" name="interbank" id="interbank" />
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
                                       
                                    </form>
      </div>
      <!-- /.col-lg-8 -->
      <div class="col-lg-4">
          <?php include  'partials/right-sidebar.php'; ?>
      </div>
      <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /#page-wrapper -->

</div>

<?php include  'partials/footer.php'; ?>
<script src="js/accountScript.js"></script>
</body>
</html>
