<!DOCTYPE html>
<html>
<head>
  <title>Beautiful Bouquet</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</head>
<body>

  <!-- jQuery to open the modal automatically -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#exampleModal').modal('show');
    });
  </script>

  <!-- Hidden input is not needed anymore -->
  <!-- <input type="hidden" class="btn btn-primary" id="target" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap"> -->

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">LOGIN ADMIN</h4>
        </div>
        <div class="modal-body">
          <form action="proses/login.php" method="POST">
            <div class="form-group">
              <label for="recipient-name" class="control-label">Username</label>
              <input type="text" class="form-control" placeholder="Username" name="user" autofocus autocomplete="off">
            </div>
            <div class="form-group">
              <label for="message-text" class="control-label">Password</label>
              <input type="password" class="form-control" placeholder="Password" name="pass" autocomplete="off">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
