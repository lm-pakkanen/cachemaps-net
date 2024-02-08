<?php
include_once '../../php_includes/functions.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

if (!isset($_POST['draw-maps-own-printer'])) {
  header("Location: ../maps.php?msg=noauth");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title & meta -->
  <title>CacheMaps - Printer map</title>
  <meta name="description" content="Printer friendly version of a chosen map">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="../php/printer.php">
  <!-- Icons -->
  <link rel="apple-touch-icon" sizes="144x144" href="https://CacheMaps.net/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://CacheMaps.net/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://CacheMaps.net/favicon-16x16.png">
  <link rel="manifest" href="https://CacheMaps.net/site.webmanifest">
  <link rel="mask-icon" href="https://CacheMaps.net/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../files/styles/common.css">
  <link rel="stylesheet" href="../files/styles/printer.css">
  <link rel="stylesheet" href="../files/styles/printer-a4.css">
  <!-- Scripts -->
  <script src="../files/scripts/get-file-information.js"></script>
  <script src="../files/scripts/maps-printer.js"></script>
  <script src="../extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="../files/scripts/notifications.js"></script>
  <script src="../files/scripts/event-handler.js"></script>
  <script> // Initialize maps.js script with logged in users' name and map file
    function getInit(scale = 7450, width_multiplier = 1.4, height_multiplier = 1.58) {
      let nickname = <?PHP echo "'" . htmlspecialchars($_SESSION['nickname']) . "'"; ?>;

      let mapfile = <?PHP
      if (isset($_POST['map-name'])) {
        echo "'" . htmlspecialchars($_POST['map-name']) . "'";
      } else {
        header("Location: ../maps.php?msg=printer-noname");
      }
      ?>;

      if (nickname && mapfile) {
        init(nickname, mapfile, scale, width_multiplier, height_multiplier);
      }
    }

    function checkReady() {
      if (!$('#map-div').find('svg')[0]) {
        setTimeout(function () {
          checkReady();
        }, 200);
      } else {
        setTimeout(function () {
          window.print();
        }, 2000);
      }
    }

    function a4() {
      let link = document.createElement('link');
      link.type = 'text/css';
      link.href = '../files/styles/printer-a4.css';
      link.rel = 'stylesheet';

      document.getElementsByTagName('head')[0].appendChild(link);

      setTimeout(function () {
        $('link[rel=stylesheet][href="../files/styles/printer-a3.css"]').remove();
      }, 100);

      $("#map-div").innerHTML = "";

      getInit();
      checkReady();
    }

    function a3() {
      var link = document.createElement('link');
      link.type = 'text/css';
      link.href = '../files/styles/printer-a3.css';
      link.rel = 'stylesheet';

      document.getElementsByTagName('head')[0].appendChild(link);

      setTimeout(function () {
        $('link[rel=stylesheet][href="../files/styles/printer-a4.css"]').remove();
      }, 100);

      $("#map-div").innerHTML = "";

      getInit(8500, 1.8, 2);
      checkReady();
    }
  </script>
</head>

<body>

  <div class="col-lg-12 text-printer">
    <p>
      To print your map, click the size you want.
    </p>
    <p>
      The browser will automatically open a printer window for you.
    </p>
    <button class="btn btn-lg btn-primary btn-green" type="button" onclick="a4();">Print as A4</button>
    <button class="btn btn-lg btn-primary btn-green" type="button" onclick="a3();">Print as A3</button>
  </div>

  <div class="page" id="map-div"></div>

  <!-- Bootstrap scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <script src="https://d3js.org/d3.v3.min.js"></script>

</body>

</html>