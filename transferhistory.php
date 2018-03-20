<?php
session_start();
if(!isset($_SESSION['user_session']))
{
    header("Location: index.php");
}
include_once 'dbconfig.php';
include_once 'scripts/functions.php';
$userId = $_SESSION['user_session'];
$transferHistorys = getTransferHistory($db_con, $userId);
$userDetails = getUserDetails($db_con, $userId);
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
        <h1 class="page-header">Transfer History</h1>
      </div>
      <!-- /.col-lg-12 -->
    </div>

    <div class="row">
      <div class="col-lg-8">

        <table id="customers">
          <tr>
            <th>Transaction Date</th>
            <th>Description</th>
            <th>Amount</th>
          </tr>
            <?php foreach ($transferHistorys as $statement) { ?>
          <tr>
            <td><?php echo  date("m/d/y g:i A",strtotime(str_replace('/','-',$statement['transactionDate']))); ?></td>
			  <td><?php echo $statement['narration']; ?></td>
            <td><?php echo number_format($statement['amount'],2) ?></td>
          
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
