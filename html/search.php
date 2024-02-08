<?PHP
require_once '../php_includes/functions.php';

secure_session_start();

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
  <title>CacheMaps - User search</title>
  <meta name="description" content="Search for other users">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://CacheMaps.net/search.php">
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
  <link rel="stylesheet" href="files/styles/search.css">
  <!-- Scripts -->
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script>
    $(document).ready(() => {
      let resultDiv = document.getElementById("search-output");

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


      $("#search-input").keyup(delay(() => {
        // Only search every x ms
        let input = $("#search-input").val();

        clearSearchResult();

        getSearchResult(input).then((data) => {
          showSearchResult(data);
        });
      }, 500));


      $("#search-button").click(() => {
        let input = $("#search-input").val();

        clearSearchResult();

        getSearchResult(input).then((data) => {
          showSearchResult(data);
        });
      });

      // Clear the window of previous results
      function clearSearchResult() {
        resultDiv.innerHTML = "";
      }

      // Query for results (server-side)
      function getSearchResult(input) {
        return new Promise((resolve, reject) => {
          let http = new XMLHttpRequest();

          http.open("GET", "php/user_search.php?value=" + input, true);
          http.send();

          http.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              let result = this.responseText.replace(/\s/g, "");

              let resultList = result.split(",");
              resultList = resultList.filter(Boolean); // Filter empty values

              resolve(resultList);
            }
          };
        });
      }

      // Wrap results in links
      function formatSearchResult(input) {

        let outputAnchor = document.createElement("a");
        outputAnchor.className = "output-item";
        outputAnchor.href = "https://CacheMaps.net/profiles?nickname=" + input;

        let outputText = document.createElement("span");
        outputText.appendChild(document.createTextNode(input));

        outputAnchor.appendChild(outputText);

        return outputAnchor;
      }

      // Wrap empty result
      function formatEmptySearchResult(input) {
        let output = document.createElement("div");
        output.className = "output-item-empty";
        output.appendChild(document.createTextNode(input));
        return output;
      }

      // Append each result after formatting
      function showSearchResult(result) {

        // If result was empty or doesn't exist, show error
        if (result === undefined || result.length === 0) {
          resultDiv.appendChild(formatEmptySearchResult("Nothing found!"));
          return;
        }

        result.forEach((value) => {
          value = formatSearchResult(value);
          resultDiv.appendChild(value);
        })
      }
    });
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

      <div class="search-wrapper">
        <div class="search-container">
          <div class="search-input-container">
            <input type="search" class="search-input" id="search-input" placeholder="Enter a username..">
            <input type="button" class="button-default" id="search-button" value="Search">
          </div>
          <div class="search-output-container" id="search-output">

          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>