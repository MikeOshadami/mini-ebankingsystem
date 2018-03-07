<?php

session_start();

if (isset($_SESSION['user_session']) != "") {
    header("Location: home.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials/header.php'; ?>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Please Sign In</h3>
        </div>
        <div class="panel-body">
          <form class="form-signin" method="post" id="login-form">

            <div id="error">
              <!-- error will be shown here ! -->
            </div>

            <div class="form-group">
              <input type="text" class="form-control" placeholder="Account Number" name="account_number"
                     id="account_number"/>
              <span id="check-e"></span>
            </div>

            <div class="form-group">
              <input type="password" class="form-control" placeholder="Password" name="password"
                     id="password"/>
            </div>

            <hr/>

            <div class="form-group">
              <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
                <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
