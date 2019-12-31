<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <!-- Material Icons Library -->
    <link rel="stylesheet" href="fonts/mdi/css/materialdesignicons.min.css">
    <!-- animation CSS -->
    <link rel="stylesheet" href="css/animation.css">
    <!-- Loaders CSS -->
    <link rel="stylesheet" href="css/loaders.css">
    <!-- Datatable style -->
    <link rel="stylesheet" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vendor.bundle.addons.css">
    <!-- Normalize -->
    <link rel="stylesheet" href="css/normalize.css/normalize.css">
    <!-- Owns -->
    <link rel="stylesheet" href="css/standard.css">
    <link rel="stylesheet" href="css/app.css">

    <title>Databases Manager</title>

  </head>
  <body>

    <div id="ajx-page">

      <?php

        if( !isset($_SESSION['user']) ) include "views/login.html";
        else include "views/home.html";
      ?>

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
