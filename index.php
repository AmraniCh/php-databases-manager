<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.semanticui.min.css">

    <link rel="stylesheet" href="css/normalize.css/normalize.css">
    <link rel="stylesheet" href="css/standard.css">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="fonts/mdi/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="css/jquery.dataTables.css">

    <link rel="stylesheet" href="css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vendor.bundle.addons.css">

    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/loaders.css">


    <title>Databases Manager</title>
  </head>
  <body>

    <div id="ajx-page">
      <div class="shape-bottom"></div>
      <!-- STRAT LOGIN FORM -->
        <div class="login-container text-color">
          <div class="form-header">
            <h2 class="heading text-center">databases manager</h2>
          </div>
          <div class="form-section">
            <div class="input-group">
              <label for="">Username :</label>
              <input type="text" class="input" id="username" placeholder="" value="root">
            </div>
            <div class="input-group">
              <label for="">Password :</label>
              <input type="text" class="input" id="pass" placeholder="">
            </div>
            <div class="input-group">
              <label for="">Server Choice :</label>
              <select id="" class="select" disabled>
                <option>MySQL</option>
              </select>
            </div>
            <div class="input-group text-center">
              <button id="connection-btn" type="button" class="btn green-btn">
                Connection
              </button>
            </div>
          </div>
        </div>
      <!-- END LOGIN FORM -->

      <div class="shape-top"></div>
    </div>

    <!-- START LOADER -->
    <div class="loader-rounded">
      <div class="loader-content"></div>
      <div class="loader-text text-color"></div>
    </div>
    <!-- END LOADER -->

    <!-- SCRIPTS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/utilities.js"></script>
    <script src="js/loaders.js"></script>
    <script src="js/main.js"></script>
    <script src="js/componenets.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
  </body>
</html>
