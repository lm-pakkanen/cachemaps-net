<?PHP
require_once '../php_includes/functions.php';
require_once 'php/municipalities.php';

secure_session_start();

// Production use
error_reporting(E_ALL);
ini_set('display_errors', 0);

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
$session_nickname = $_SESSION['nickname'];
$logged_in = $_SESSION['logged_in'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title & meta -->
  <title>CacheMaps - Create a map</title>
  <meta name="description" content="Create a map">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://www.CacheMaps.net/create_map.php">
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
  <link rel="stylesheet" href="files/styles/create_map.css">
  <!-- Scripts -->
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script>
    // Delay .keyup() triggering
    function delay(callback, delayMs) {
      let timer = 0;

      return function () {
        let context = this;
        let args = arguments;

        clearTimeout(timer);

        timer = setTimeout(function () {
          callback.apply(context, args);
        }, delayMs || 0);
      };
    }

    function findDivs(input) {
      let output = [];

      if (input.length === 0) {
        return false;
      }

      input = input.charAt(0).toUpperCase() + input.slice(1);
      let queryResult = document.querySelectorAll("div.municipality[id^=" + input + "]");

      queryResult.forEach((div) => {
        output.push(div.id);
      });

      output.sort((a, b) => a - b);
      return output;
    }

    function highlightDivs(div_list) {
      div_list.forEach((div) => {
        $("#" + div).addClass("highlighted");
      });
    }

    function unhighlightDivs() {
      $(".highlighted").removeClass("highlighted");
    }

    $(document).ready(() => {
      let searchInput = $("#search");
      searchInput.focus();

      $(window).on("hashchange", () => {
        searchInput.focus();
      });

      // Only search every x ms
      searchInput.keyup(delay(() => {
        unhighlightDivs();

        let input = searchInput.val();
        let result = findDivs(input);

        if (result) {
          window.location.hash = result[0];
          highlightDivs(result);
        }
      }, 500));
    })
  </script>
</head>

<body>

  <div id="page-wrapper">
    <div id="page-shader">
      <nav class="navbar-custom">
        <div class="navbar-links-left">
          <a href="/" class="navbar-link-brand"><span>CacheMaps.net</span></a>
          <a href="maps" class="navbar-link-left"><span>Maps</span></a>
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
          <a href="maps" class="navbar-link-right dropdown-child general"><span>Maps</span></a>
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
        <div class="container-custom">
          <form action="php/create-map.php" method="POST">
            <div class="title">
              Create a new map!
            </div>
            <hr class="line">
            <div class="map-options">
              <input class="map-name" name="create-map-name" type="text" placeholder="enter a map name...">
              <input class="button-default" name="create-map-button" type="submit" value="Create map">
            </div>
            <input class="municipality-search" id="search" type="search" placeholder="find by name...">
            <div class="municipalities-holder">
              <?PHP
              foreach ($municipalities as $municipality) {
                echo '<div class="municipality" id="' . $municipality . '">';
                echo '    <div class="checkbox-holder">';
                echo '        <input class="municipality-checkbox" type="checkbox" id="' . $municipality . '-checkbox" name="' . $municipality . '-checkbox">';
                echo '        <label class="municipality-label" for="' . $municipality . '-checkbox">' . $municipality . '</label>';
                echo '    </div>';
                echo '    <input class="municipality-count" type="number" placeholder="count (optional)" name="' . $municipality . '-count">';
                echo '</div>';
              }
              ?>
            </div>
          </form>
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

</body>

</html>