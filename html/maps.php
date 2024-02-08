<?PHP
require_once 'php/userFileHandler.php';
require_once '../php_includes/functions.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

secure_session_start();

if (!empty($_SESSION['isMapUpdated'])) {
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  unset($_SESSION['isMapUpdated']);
}

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
$logged_in = $_SESSION['logged_in'];
$session_nickname = $_SESSION['nickname'];
$available_maps = array();

if (!empty($logged_in) && !empty($session_nickname)) {
  $available_maps = getAvailableMaps($session_nickname);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $gaId; ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', '<?php echo $gaId; ?>');
  </script>
  <!-- Title & meta -->
  <title>CacheMaps - Maps</title>
  <meta name="description" content="Create, update and view custom geocaching maps">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://CacheMaps.net/maps.php">
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="files/styles/common.css">
  <link rel="stylesheet" href="files/styles/maps.css">
  <!-- Scripts -->
  <script src="files/scripts/get-file-information.js"></script>
  <script src="files/scripts/maps.js"></script>
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/confirm-file-delete.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script>
    // Initialize maps.js script with logged in users' name
    $(document).ready(function () {
      let nickname = "<?PHP echo $session_nickname; ?>";
      let logged_in_nickname = "<?PHP echo $_SESSION['nickname']; ?>";
      init(nickname, logged_in_nickname);
    });
  </script>
</head>

<body>

  <script>
    $(document).ready(function () {
      let logged_in = "<?PHP echo $_SESSION['logged_in']; ?>";

      if (!logged_in) {
        let elementsToDelete = ["own-maps-box", "update-maps-box", "create-map-box"];

        elementsToDelete.forEach(function (element) {
          let disabledOverlay = document.createElement("DIV");
          disabledOverlay.className += "disabled-overlay";

          document.getElementById(element).classList.add("disabled-div");
          document.getElementById(element).appendChild(disabledOverlay);
        });
      }

      drawPlaceholder();

      let disabledOverlay = document.createElement("DIV");
      disabledOverlay.classList.add("disabled-overlay");

      document.getElementById("map-div").appendChild(disabledOverlay);

      let checkBox = $(".province-checkbox");

      checkBox.change(function () {
        let provinceOverlay = $("#province_overlay");

        if (checkBox.is(":checked")) {
          provinceOverlay.css('display', 'block');
        } else {
          provinceOverlay.css('display', 'none');
        }
      });
    });
  </script>

  <div id="page-wrapper">
    <div id="page-shader">
      <nav class="navbar-custom">
        <div class="navbar-links-left">
          <a href="/" class="navbar-link-brand"><span>CacheMaps.net</span></a>
          <a href="maps" class="navbar-link-left active"><span>Maps</span></a>
        </div>
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right">
          <a href="search" class="navbar-link-right"><span>Profiles</span></a>
          <a href="help" class="navbar-link-right" target="_blank"><span>Help</span></a>
          <a href="contact" class="navbar-link-right"><span>Contact</span></a>
          <a href="login" class="navbar-link-right <?PHP if ($logged_in) {
            echo "d-none";
          } ?>"><span>Login</span></a>
          <div class="account-dropdown <?PHP if (!$logged_in) {
            echo "d-none";
          } ?>" id="account-dropdown-button">
            <div class="navbar-link-right">
              <span>Account <i class="fas fa-caret-left fa-lg fa-caret-custom"></i></span>
            </div>
          </div>
          <div class="navbar-burger hide">
            <div id="burger-first"></div>
            <div id="burger-second"></div>
            <div id="burger-third"></div>
          </div>
        </div>
      </nav>
      <div class="dropdown-menu-custom hide" id="general-dropdown">
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right dropdown-child">
          <a href="maps" class="navbar-link-right dropdown-child general active"><span>Maps</span></a>
          <a href="search" class="navbar-link-right dropdown-child general"><span>Profiles</span></a>
          <a href="help" class="navbar-link-right dropdown-child general" target="_blank"><span>Help</span></a>
          <a href="contact" class="navbar-link-right dropdown-child general"><span>Contact</span></a>
          <a href="login" class="navbar-link-right dropdown-child general <?PHP if ($logged_in) {
            echo "d-none";
          } ?>"><span>Login</span></a>
          <div class="navbar-link-right dropdown-child account-dropdown general <?PHP if (!$logged_in) {
            echo "d-none";
          } ?>" id="under-dropdown-account-dropdown">
            <span>Account <i class="fas fa-caret-down fa-lg fa-caret-custom"></i></span>
          </div>
        </div>
      </div>
      <div class="dropdown-menu-custom hide" id="account-dropdown">
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right dropdown-child">
          <a href="profiles?nickname=<?PHP echo $session_nickname; ?>"
            class="navbar-link-right dropdown-child long-text"><span>Public profile</span></a>
          <a href="myaccount" class="navbar-link-right dropdown-child long-text"><span>Account settings</span></a>
          <a href="login" class="navbar-link-right dropdown-child"><span>Login</span></a>
          <a href="php/logout.php" class="navbar-link-right dropdown-child"><span>Log out</span></a>
        </div>
      </div>
      <div class="dropdown-menu-custom hide" id="account-dropdown-under-dropdown">
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right dropdown-child">
          <a href="profiles?nickname=<?PHP echo $session_nickname; ?>"
            class="navbar-link-right dropdown-child long-text"><span>Public profile</span></a>
          <a href="myaccount" class="navbar-link-right dropdown-child long-text"><span>Account settings</span></a>
          <a href="login" class="navbar-link-right dropdown-child"><span>Login</span></a>
          <a href="php/logout" class="navbar-link-right dropdown-child"><span>Log out</span></a>
        </div>
      </div>


      <div class="main">
        <div class="device-size-error">
          Device is too narrow to draw maps!
        </div>
        <div class="map-area-wrapper">
          <a href="#" class="fake-anchor" id="map-div-anchor"></a>
          <div class="map-area" id="map-div">
            <span class="province-label">
              <span>View provinces</span>
              <input type="checkbox" class="province-checkbox" onclick="" title="" />
            </span>
          </div>
        </div>
        <div id="tooltip" class="hidden">
          <p><strong><span id="municipality"></span></strong></p>
          <p id="property"></p>
        </div>
        <div class="csv-upload-div" id="csv-upload-div">
          <div class="csv-upload-title">
            Choose a .csv file
            <span class="spacer"></span>
            <button class="csv-upload-exit"><i class="fa fa-window-close"></i></button>
          </div>
          <span class="spacer"></span>
          <div class="csv-buttons">
            <form action="php/upload-csv.php" method="POST" enctype="multipart/form-data">
              <label class="box-button" for="csv-upload-choose-default">
                Choose file
              </label>
              <input type="file" class="csv-upload-choose-default" name="csv-upload-choose-default"
                id="csv-upload-choose-default">
              <input type="submit" class="box-button" value="Upload" onclick="hideCsv();">
            </form>
          </div>
        </div>
        <div class="box-area">
          <div class="large-login-link <?PHP if (!empty($_SESSION['logged_in'])) {
            echo "d-none";
          } ?>" onclick="window.location.href = 'https\:\/\/CacheMaps.net/login';">
            Access more features by logging in.<i class="fas fa-external-link-alt"></i>
          </div>
          <div class="container-custom" id="own-maps-box">
            <form action="php/printer.php" method="POST">
              <span class="box-title">Draw your maps!</span>
              <div class="box-contents">
                <label>
                  <span>Select map:</span>
                  <select class="select-input" id="map-name" name="map-name">
                    <option value="" selected> </option>
                    <?PHP
                    if (!empty($available_maps)) {
                      $isFirst = true;

                      foreach ($available_maps as $map) {
                        $mapName = explode("-", $map)[0];

                        if (!empty($mapName)) {
                          if ($isFirst) {
                            $isFirst = false;
                            echo "<option value=\"$mapName\" selected>$mapName</option>";
                          } else {
                            echo "<option value=\"$mapName\">$mapName</option>";
                          }
                        }
                      }
                    }
                    ?>
                  </select>
                </label>
                <div class="box-contents-sub" id="own-maps-contents-sub">
                  <input type="button" class="box-button" id="draw-maps-own" value="Draw map"
                    onclick="location.hash = 'map-div-anchor'" ;>
                  <input type="submit" class="box-submit" id="draw-maps-own-printer" name="draw-maps-own-printer"
                    value="Printer version" />
                </div>
              </div>
            </form>
          </div>
          <div class="container-custom">
            <form id="draw-others-form">
              <span class="box-title">Draw other users' maps!</span>
              <div class="box-contents">
                <label>
                  <input type="text" class="text-input" id="nickname" name="nickname" placeholder="nickname..." />
                </label>
                <label>
                  <input type="text" class="text-input" id="map-name-other" name="map-name-other"
                    placeholder="map name..." />
                </label>
                <div class="box-contents-sub" id="draw-others-contents-sub">
                  <button type="button" class="box-submit" id="draw-maps-others-button"
                    onclick="location.hash = 'map-div-anchor';">Draw map</button>
                </div>
              </div>
            </form>
          </div>
          <div class="container-custom" id="create-map-box">
            <span class="box-title">Create a new map!</span>
            <div class="box-contents">
              <form action="create_map.php" method="POST">
                <input type="submit" class="box-submit" name="goto-create-map" value="Use a form">
              </form>
              <input type="submit" class="box-submit" name="goto-create-map" onclick="showCsv();"
                value="Use a .csv file" />
            </div>
          </div>
          <div class="container-custom" id="update-maps-box">
            <form enctype="multipart/form-data" method="POST" name="update-delete-form">
              <span class="box-title">Manage your maps!</span>
              <div class="box-contents">
                <label>
                  <span>Select map:</span>
                  <select class="select-input" id="map-name-update" name="map-name-update">
                    <?PHP
                    if (!empty($available_maps)) {
                      foreach ($available_maps as $map) {
                        $mapName = explode("-", $map)[0];
                        echo "<option value=\"$mapName\">$mapName</option>";
                      }
                    }
                    ?>
                  </select>
                </label>
                <div class="box-contents-sub" id="manage-maps-contents-sub">
                  <input type="submit" class="box-submit" id="update-map" name="update-map"
                    formaction="php/set-old-map.php" formtarget="_self" value="Update map" />
                  <input type="submit" id="delete-map" name="delete-map" formaction="php/delete-map.php"
                    formtarget="_self"
                    onclick="confirmFileDelete(event, $('form[name=update-delete-form]').serialize());"
                    class="box-submit warning" value="Delete map" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

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

<!-- Bind Enter to clicking button -->
<script>
  $(document).ready(function () {
    $("#draw-others-form").bind("keypress", function (e) {
      if (e.keyCode === 13) {
        $("#draw-maps-others-button").click();
        return false;
      }
    })
  });
</script>
<script>
  function hideCsv() {
    $("#csv-upload-div").hide();
  }

  function showCsv() {
    $("#csv-upload-div").css('display', 'flex');
  }

  $('.csv-upload-exit').click(function () {
    $(this).parent().parent().hide();
  });
</script>