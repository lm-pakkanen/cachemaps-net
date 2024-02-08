<?PHP
include_once '../php_includes/functions.php';

secure_session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];

$logged_in = $_SESSION['logged_in'];
$session_nickname = $_SESSION['nickname'];
$login_error = $_SESSION['error'];

unset($_SESSION['error']);
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
  <title>CacheMaps - Login</title>
  <meta name="description" content="Login to CacheMaps">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://CacheMaps.net/login.php">
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
  <link rel="stylesheet" href="files/styles/login.css">
  <!-- Scripts -->
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script src="files/scripts/cookies.js"></script>
  <script>
    function showRegisterForm() {
      $(".login-form-container").css('display', 'none');
      $(".register-form-container").css('display', 'flex');
    }
    function showLoginForm() {
      $(".reset-password-form-container").css('display', 'none');
      $(".register-form-container").css('display', 'none');
      $(".login-form-container").css('display', 'flex');
    }
    function showResetPasswordForm() {
      $(".login-form-container").css('display', 'none');
      $(".reset-password-form-container").css('display', 'flex');
    }
  </script>
</head>

<body>

  <div id="page-wrapper">
    <div id="page-shader">
      <div class="cookie-notification <?PHP if (!empty($_SESSION['accepted_cookies'])) {
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
      <!-- Navbar -->
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
          <a href="login" class="navbar-link-right active <?PHP if ($logged_in) {
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
          <a href="login" class="navbar-link-right dropdown-child general active <?PHP if ($logged_in) {
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
          <a href="login" class="navbar-link-right dropdown-child active"><span>Login</span></a>
          <a href="php/logout.php" class="navbar-link-right dropdown-child"><span>Log out</span></a>
        </div>
      </div>
      <div class="dropdown-menu-custom hide" id="account-dropdown-under-dropdown">
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right dropdown-child">
          <a href="profiles?nickname=<?PHP echo $session_nickname; ?>"
            class="navbar-link-right dropdown-child long-text"><span>Public profile</span></a>
          <a href="myaccount" class="navbar-link-right dropdown-child long-text"><span>Account settings</span></a>
          <a href="login" class="navbar-link-right dropdown-child active"><span>Login</span></a>
          <a href="php/logout" class="navbar-link-right dropdown-child"><span>Log out</span></a>
        </div>
      </div>

      <div class="login-form-wrapper-horizontal">
        <div class="login-form-wrapper-vertical">
          <div class="login-form-container">
            <form action="php/login.php" method="POST">
              <h2 class="login-form-title">
                Login here
              </h2>
              <div class="login-form-inputs">
                <p>Nickname</p>
                <input type="text" placeholder="Enter nickname" id="login-form-nickname" name="login_parameter">
                <p>Password</p>
                <input type="password" placeholder="Enter password" id="login-form-password" name="login_password">
                <div class="login-error <?PHP echo empty($login_error) ? "hide" : ""; ?>" id="specific">
                  <?PHP echo htmlspecialchars($login_error) ?>
                </div>
                <input type="submit" value="Login" name="submit_login">
                <button type="button" id="forgot-password-link" onclick="showResetPasswordForm();">
                  Forgot your password?
                </button>
                <button type="button" id="register-form-link" onclick="showRegisterForm();">
                  Don't have an account yet?<br />
                  Create one here!
                </button>
              </div>
            </form>
          </div>
          <div class="reset-password-form-container">
            <form action="php/reset_password.php" method="POST">
              <h2 class="reset-password-form-title">
                Reset password
              </h2>
              <div class="reset-password-form-inputs">
                <p>Enter your email</p>
                <input type="text" placeholder="Enter email" id="reset-password-form-email"
                  name="reset-password-form-email">
                <input type="submit" value="Reset password" name="reset-password-form-submit">
                <button type="button" id="login-form-link" onclick="showLoginForm();">
                  Back to login
                </button>
              </div>
            </form>
          </div>
          <div class="register-form-container">
            <form action="php/create-account.php" method="POST">
              <h2 class="register-form-title">
                Create account
              </h2>
              <div class="register-form-inputs">
                <p>Nickname</p>
                <input type="text" placeholder="Enter nickname" id="register-form-nickname" name="register_nickname">
                <p>Email</p>
                <input type="email" placeholder="Enter email" id="register-form-email" name="register_email">
                <p>Password</p>
                <input type="password" placeholder="Enter password" id="register-form-password"
                  name="register_password">
                <p>Password confirm</p>
                <input type="password" placeholder="Confirm password" id="register-form-password-confirm"
                  name="register_password_confirm">
                <input type="submit" name="register_submit" value="Create account">
                <button type="button" onclick="showLoginForm();">
                  Back to login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>

</body>

</html>