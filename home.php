<?php
session_start();
if(!isset($_SESSION['user_session']))
{
    header("Location: index.php");
}
include_once 'dbconfig.php';
include_once 'scripts/functions.php';
$userId = $_SESSION['user_session'];
$userDetails = getUserDetails($db_con, $userId);
$getTotalWithDrawal = getTotalWithDrawal($db_con, $userId);
$getTotalCredit = getTotalCredit($db_con, $userId);
$getAvailableBalance = $getTotalCredit - $getTotalWithDrawal;
$miniStatements = getMiniStatement($db_con, $userId);
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
        <h1 class="page-header">Welcome <?php echo $userDetails['user_name']; ?></h1>
      </div>
      <!-- /.col-lg-12 -->
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge">&#8358;<?php echo number_format($getAvailableBalance) ?></div>
                    <div>ACCOUNT BALANCE</div>
                  </div>
                </div>
              </div>

              <div class="panel-footer">
                <div class="clearfix"></div>
              </div>

            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-support fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge">&#8358;<?php echo number_format($getTotalWithDrawal) ?></div>
                    <div>TOTAL WITHDRAWAL</div>
                  </div>
                </div>
              </div>
              <div class="panel-footer">
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-tasks fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge">&#8358;<?php echo number_format($getTotalCredit) ?></div>
                    <div>TOTAL CREDIT</div>
                  </div>
                </div>
              </div>
              <div class="panel-footer">
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

        </div>
        <table id="customers">
          <tr>
            <th>Transaction Date</th>
            <th>Description</th>
            <th>Deposit</th>
            <th>Withdrawal</th>
          </tr>
            <?php foreach ($miniStatements as $statement) { ?>
          <tr>
            <td><?php echo  date("m/d/y g:i A",strtotime(str_replace('/','-',$statement['transactionDate']))); ?></td>
            <td><?php echo $statement['narration']; ?></td>
            <td><?php if($statement['DRCR']=='CR'){	echo number_format($statement['amount'],2);} else {	echo "0.00";} ?></td>
            <td><?php if($statement['DRCR']=='DR'){	echo number_format($statement['amount'],2);} else {	echo "0.00";} ?></td>
          </tr>
            <?php } ?>
        </table>
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

</body>
</html>
