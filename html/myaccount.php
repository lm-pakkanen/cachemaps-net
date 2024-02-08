<?PHP
include_once '../php_includes/functions.php';

secure_session_start();

// Redo user authentication to make sure
// page isn't accessed by someone else
if (verify_login() !== true) {
  header("Location: index.php?msg=noauth");
  exit();
}

// Production use
error_reporting(E_ALL);
ini_set('display_errors', 0);

$logged_in = $_SESSION['logged_in'];
$session_nickname = $_SESSION['nickname'];

if (empty($_SESSION['logged_in']) || empty($_SESSION['nickname'])) {
  redirect("msg=nologin");
}

function redirect($message)
{
  if (removeParams($_SERVER['REQUEST_URI']) !== removeParams($_SESSION['prev_page'])) {
    $header = $_SESSION['prev_page'];
    $header = removeParams($header);
    $header = $header . "?$message";
    header("Location: " . $header);
    exit();
  } else {
    header("Location: index.php?msg=noauth");
    exit();
  }
}

function removeParams($header)
{
  // Remove URL parameters
  if (strpos($header, "?") !== false) {
    return substr($header, 0, strpos($header, "?"));
  } else {
    return $header;
  }
}

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];

if (!verify_login()) {
  redirect("msg=noauth");
}

if (!empty($_SESSION['account_type'])) {
  if ($_SESSION['account_type'] === "restricted") {
    header("Location: index.php?msg=account_restricted");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title & meta -->
  <title>CacheMaps - My account</title>
  <meta name="description" content="My profile information">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://CacheMaps.net/myaccount.php">
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
  <link rel="stylesheet" href="files/styles/myaccount.css">
  <!-- Scripts -->
  <script src="https://CacheMaps.net/extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
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
          <a href="myaccount" class="navbar-link-right dropdown-child long-text active"><span>Account
              settings</span></a>
          <a href="login" class="navbar-link-right dropdown-child"><span>Login</span></a>
          <a href="php/logout.php" class="navbar-link-right dropdown-child"><span>Log out</span></a>
        </div>
      </div>
      <div class="dropdown-menu-custom hide" id="account-dropdown-under-dropdown">
        <div class="navbar-spacer"></div>
        <div class="navbar-links-right dropdown-child">
          <a href="profiles?nickname=<?PHP echo $session_nickname; ?>"
            class="navbar-link-right dropdown-child long-text"><span>Public profile</span></a>
          <a href="myaccount" class="navbar-link-right dropdown-child long-text active"><span>Account
              settings</span></a>
          <a href="login" class="navbar-link-right dropdown-child"><span>Login</span></a>
          <a href="php/logout" class="navbar-link-right dropdown-child"><span>Log out</span></a>
        </div>
      </div>

      <div class="main">
        <div class="container-custom">
          <div class="container-title">Your account at a glance:</div>
          <div class="user-info">
            <div class="table-holder">
              <table>
                <tr>
                  <th>Nickname:</th>
                  <td>
                    <?PHP echo htmlspecialchars($_SESSION['nickname']); ?>
                  </td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>
                    <?PHP echo htmlspecialchars($_SESSION['email']); ?>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="update-details-container">
            <p>Update your details with the form below.</p>
            <p>Only fill those fields you wish to change.</p>
            <form class="update-details-form" action="php/update-account.php" method="POST">
              <div>
                <input type="text" class="text-input" name="update-details-nickname" placeholder="new nickname...">
                <input type="email" class="text-input" name="update-details-email" placeholder="new email...">
                <input type="password" class="text-input" name="update-details-password" placeholder="new password...">
                <input type="password" class="text-input" name="update-details-password-confirm"
                  placeholder="confirm password...">
                <input type="submit" class="box-submit" id="update-details-button" name="update-details-button"
                  value="Update details">
              </div>
            </form>
          </div>
          <div class="delete-account-container">
            <p>You can delete your CacheMaps.net account with the button below.</p>
            <p><strong>Deleting your account is permanent.</strong></p>
            <form class="delete-account-form" action="php/delete-account.php" method="POST">
              <input type="submit" class="box-submit warning" id="delete-account-button" name="delete-account-button"
                onclick="confirmAccountDelete(event);" value="Delete my account">
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
  <!-- Other scripts -->
  <script src="files/scripts/confirm-account-delete.js"></script>

</body>

</html>