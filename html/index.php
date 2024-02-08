<?PHP
include_once '../php_includes/functions.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];

$session_nickname = $_SESSION['nickname'];
$logged_in = $_SESSION['logged_in'];
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
  <title>CacheMaps - Home</title>
  <meta name="description" content="CacheMaps is a site where geocachers can create and view custom statistics maps">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://CacheMaps.net/index.php">
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
  <link rel="stylesheet" href="files/styles/index.css">
  <!-- Scripts -->
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script src="files/scripts/cookies.js"></script>
</head>

<body>

  <div id="page-wrapper">
    <div id="page-shader">
      <div class="cookie-notification <?PHP if (isset($_SESSION['accepted_cookies'])) {
        echo "hide";
      } ?>">
        <p>
          This website uses cookies. It's not like it matters, but we're
          required to inform you.
        </p>
        <a href="privacy-policy.pdf" target="_blank">
          <button type="button" class="box-button" id="privacy-policy-link">
            Privacy policy
          </button>
        </a>
        <button type="button" class="box-button warning" id="cookies-reject" onclick="rejectCookies();">Reject
          cookies</button>
        <button type="button" class="box-button" id="cookies-accept" onclick="acceptCookies();">Accept</button>
      </div>
      <nav class="navbar-custom">
        <div class="navbar-links-left">
          <a href="/" class="navbar-link-brand active"><span>CacheMaps.net</span></a>
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

      <div class="welcome-message-wrapper">
        <div class="welcome-message">
          <h1 class="index-header mb-3">
            Welcome to CacheMaps.net!
          </h1>
          <p class="text">
            You can view other users' maps on the "Maps" -page.
          </p>
          <p class="text">
            If you're logged in, you will also be able to create, update
            & view your own maps!
          </p>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-version">
      Website version: 3.1
    </div>
    <div class="footer-copyright">
      &copy;
      <?PHP echo date('Y'); ?> CacheMaps.net
    </div>
  </footer>

  <!-- Bootstrap scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>

</body>

</html>