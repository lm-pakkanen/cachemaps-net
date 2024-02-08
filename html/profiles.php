<?PHP
require '../php_includes/functions.php';
require 'php/userFileHandler.php';

secure_session_start();

// Production use
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (!isset($_GET['nickname'])) {
  die("No nickname was entered!");
}

// Get nickname whose profile to show
$nickname = htmlspecialchars($_GET['nickname']);

if (isset($_SESSION['nickname'], $_SESSION['logged_in'])) {
  $session_nickname = htmlspecialchars($_SESSION['nickname']);
  $logged_in = htmlspecialchars($_SESSION['logged_in']);
} else {
  $session_nickname = "";
}

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title & meta -->
  <title>CacheMaps - Profiles</title>
  <meta name="description" content="Cachemaps user profiles">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://cachemaps.net/user/profiles.php">
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="files/styles/common.css">
  <link rel="stylesheet" href="files/styles/profiles.css">
  <!-- Scripts -->
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script src="files/scripts/cookies.js"></script>
  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="files/scripts/get-file-information.js"></script>
  <script src="files/scripts/maps-profile.js"></script>
  <script src="files/scripts/loading-overlay.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <!-- Required to convert named colors to RGB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.4/rgbcolor.min.js"></script>
  <!-- Optional if you want blur -->
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/stackblur-canvas/1.4.1/stackblur.min.js"></script>
  <!-- Main canvg code -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/canvg/dist/browser/canvg.min.js"></script>

</head>

<body>

  <script>
    $(document).ready(function () {
      $("#save-page-as-img").click(function () {
        resetConsts();

        getMapsAndInit(
          "<?PHP echo $nickname; ?>",
          2,
          2,
          "<?PHP echo $session_nickname; ?>");

        convert();
      });

      function convert() {
        showLoading();

        setTimeout(function () {
          html2canvas(document.getElementById("maps-div-image")).then(canvas => {
            canvas.id = "pageAsCanvas";
            document.body.appendChild(canvas);
          });

          setTimeout(function () {
            let canvas = document.getElementById("pageAsCanvas");

            let image = new Image();
            image.src = canvas.toDataURL("image/png");
            image.id = "pageAsImage";
            image.className += "image";

            document.body.appendChild(image);

            let dataURL = canvas.toDataURL("image/png");
            let nickname = "<?PHP echo $nickname; ?>";

            $.ajax({
              type: "POST",
              url: "php/saveImage.php",
              data: {
                imgBase64: dataURL,
                nickname: nickname
              }
            }).done(function () {
              console.log("Image saved");
              hideLoading();

              let href = window.location.href;

              if (href.includes("&msg=")) {
                window.location.href = href.substr(0, href.indexOf("&msg="))
                  + "&msg=save_image-success";
              } else {
                window.location.href = href + "&msg=save_image-success";
              }
            }).fail(function () {
              console.log("failed");
              hideLoading();

              let href = window.location.href;

              if (href.includes("&msg=")) {
                window.location.href = href.substr(0, href.indexOf("&msg="))
                  + "&msg=save_image-fail";
              } else {
                window.location.href = href + "&msg=save_image-fail";
              }
            });
          }, 1000);
        }, 10000);
      }

      function getMapsAndInit(nickname, w_mod, h_mod, logged_in_nickname, isDrawImage) {
        <?PHP
        $maps = getAvailableMaps($nickname);

        foreach ($maps as $map) {
          echo "drawProfileMap(\"files/users/$nickname/$map\",\"$nickname\",\"$session_nickname\", true,
                \"maps-div-image\", \"-image\", w_mod, h_mod);";
        }
        ?>
      }
    });
  </script>

  <div id="page-wrapper">
    <div id="page-shader">
      <nav class="navbar-custom">
        <div class="navbar-links-left">
          <a href="/" class="navbar-link-brand"><span>CacheMaps.net</span></a>
          <a href="maps" class="navbar-link-left"><span>Maps</span></a>
        </div>
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right">
          <a href="search" class="navbar-link-right active"><span>Profiles</span></a>
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
          <a href="maps" class="navbar-link-right dropdown-child general"><span>Maps</span></a>
          <a href="search" class="navbar-link-right dropdown-child general active"><span>Profiles</span></a>
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

      <div class="container-custom-wrapper">
        <div class="container-custom">
          <div class="profile-title-wrapper">
            <p class="profile-title">
              <?PHP echo $nickname ?>'s profile
            </p>
            <span class="spacer"></span>
            <?PHP
            if (isset($session_nickname) && strcmp($session_nickname, $nickname) === 0) {
              echo "<button class=\"button-default\" id=\"save-page-as-img\">Generate image</button>";
            }
            ?>
          </div>
          <hr class="line">
          <div class="maps-container" id="maps-div">

          </div>
        </div>

        <div class="wrapper">
          <div class="image-big">
            <div id="maps-div-image">
              <div class="profile-title-wrapper">
                <div class="profile-title" id="image-profile-title">
                  <?PHP echo $nickname ?>'s profile
                </div>
              </div>
              <hr class="line">
            </div>
          </div>
        </div>

        <?PHP
        require_once("php/userFileHandler.php");

        foreach (getAvailableMaps("$nickname") as $map) {
          echo "<script>drawProfileMap(\"files/users/$nickname/$map\",\"$nickname\",\"$session_nickname\");</script>";
        }
        ?>
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

</body>

</html>