<?PHP
include_once '../php_includes/functions.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
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
  <title>CacheMaps - Help</title>
  <meta name="description" content="Quick instructions for CacheMaps.net">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SEO -->
  <link rel="canonical" href="https://CacheMaps.net/help.php">
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
  <link rel="stylesheet" href="files/styles/help.css">
  <!-- Scripts -->
  <script src="extlibs/node_modules/jquery/dist/jquery.js"></script>
  <script src="files/scripts/notifications.js"></script>
  <script src="files/scripts/event-handler.js"></script>
  <script src="files/scripts/navbar-event-handlers.js"></script>
  <script src="files/scripts/help.js"></script>
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
          <a href="help" class="navbar-link-right active" target="_blank"><span>Help</span></a>
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
          <a href="help" class="navbar-link-right dropdown-child general active" target="_blank"><span>Help</span></a>
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
        <div class="eng">
          <div class="language-selectors">
            <button type="button" class="btn btn-primary btn-lg btn-green language-finnish">
              Suomeksi
            </button>
            <button type="button" class="btn btn-primary btn-lg btn-green disabled language-english">
              In English
            </button>
          </div>
          <div class="container-custom">
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-first-anchor"></a>
              <div class="section-title">
                1. Creating an account
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-first">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-first">
                <ul>
                  <li>
                    You can create a new account on the "Login" -page, which can be found
                    under the 'Account' menu.
                    <ul>
                      <li>
                        You can't create an account if an account with the same nickname or email
                        already exists.
                      </li>
                      <li>
                        All fields must be filled.
                      </li>
                      <li>
                        The email must be a valid email address.
                      </li>
                      <li>
                        The nickname can only contain alphanumerical characters and underscores.
                      </li>
                      <li>
                        The password and password confirmation must match. Please notice case sensitivity.
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-second-anchor"></a>
              <div class="section-title">
                2. Logging in
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-second">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-second">
                <ul>
                  <li>
                    You can log in to your account on the "Log in" -page,
                    which can be found under the 'Account' menu.
                  </li>
                  <li>
                    Please note that the nickname & password are case sensitive.
                  </li>
                  <li>
                    If you're already logged in, you must log out before trying to log in.
                  </li>
                  <li>
                    All fields must be filled.
                  </li>
                  <li>
                    Should you forget your password, click the "Forgot your password?" -link on the
                    login page. You can set a new password by entering your email address in the
                    new window and clicking the "Reset password" -button. You will be sent a new
                    password via email which you can use to log in to the website.
                    <strong>
                      We highly recommend changing the sent password to a new one
                      immediately after logging in for security reasons.
                    </strong>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-third-anchor"></a>
              <div class="section-title">
                3. Changing account details
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-third">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-third">
                <ul>
                  <li>
                    To change your account's details, you need to log in first.
                  </li>
                  <li>
                    Once logged in, you can change your details on the 'Account settings' -page
                    found in the 'Account' drop down menu in the navigation bar.
                  </li>
                  <li>
                    You don't have to update all of your details at once. Simply fill in only
                    the fields you want to change, the empty fields will be ignored.
                  </li>
                  <li>
                    Notice that if you want to change your password, you will also need to enter
                    the confirmation password.
                  </li>
                  <li>
                    After changing your details you will be logged out.
                    In order to continue using the website, you must log in again.
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-fourth-anchor"></a>
              <div class="section-title">
                4. Deleting an account
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-fourth">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-fourth">
                <ul>
                  <li>
                    To delete your account, you need to log in first.
                  </li>
                  <li>
                    Once logged in, you can delete your account on the 'Account settings' -page
                    found in the 'Account' drop down menu in the navigation bar.
                  </li>
                  <li>
                    Notice that once your account is deleted, the <b>only way</b> to recover
                    your account is by contacting the admin.
                    Your nickname & email will stay reserved.
                  </li>
                  <li>
                    You can contact the admin by email:
                    <a href="mailto:admin@cachemaps.net" class="link-green">
                      admin@cachemaps.net
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-fifth-anchor"></a>
              <div class="section-title">
                5. Public profiles
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-fifth">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-fifth">
                <ul>
                  <li>
                    You can view the public profile of anyone who has created an account
                    on the CacheMaps.net website. You can find the profile by navigating
                    to 'https://CacheMaps.net/users/nickname', where you should replace the word
                    "nickname" with the nickname of the user whose profile you wish to see.
                  </li>
                  <li>
                    You can also view your own profile by using the 'public profile'
                    button found in the 'Account' drop down menu in the navigation bar,
                    if you're logged in.
                  </li>
                  <li>
                    If you're viewing someone else's profile, you won't be able to see those maps which
                    they've marked as private.
                  </li>
                  <li>
                    If you're viewing your own profile and are logged in,
                    you can save your profile page as an image.
                    The image will be saved in 'https://CacheMaps.net/files/users/nickname/nickname.png',
                    where 'nickname' is your nickname.<br />
                    This is the address to use if you want to view the saved picture, or link to it.
                    <ul>
                      <li>
                        This functionality is for those who wish to link the maps of their CacheMaps.net
                        profile as an image, e.g to their
                        <a href="https://www.geocaching.com" class="link-green">geocaching.com</a> profile page.
                        For example, you can link to the image by using an
                        <span class="code-inline">&lt;img&gt;</span> - html tag, and by setting
                        it's <span class="code-inline">source</span>
                        to the address specified above.
                      </li>
                      <li>
                        Example:
                        <span class="code-inline">
                          &lt;img src="https://CacheMaps.net/files/users/example/example.png"&gt;
                        </span>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-sixth-anchor"></a>
              <div class="section-title">
                6. Creating a new map
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-sixth">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-sixth">
                <ul>
                  <li>
                    In order to create a map, you must be logged in.
                  </li>
                  <li>
                    You can create new maps of different kinds of finds you have and which you want to
                    track on the municipality level. Examples of these maps include FTF, island cache,
                    oldest caches of municipalities, triplet and climbing cache maps.. Or anything you
                    can come up with!
                  </li>
                  <li>
                    The CacheMaps -website has no affiliation with (for example) geocaching.com or geocache.fi,
                    and it cannot obtain statistics directly from them. The CacheMaps -website's statistics
                    are maintained by users themselves.
                  </li>
                  <li>
                    To create a new map, navigate to the "Maps" -page ja click the
                    "Create a new map" -button.
                  </li>
                  <li>
                    There are two ways to create a new map:
                    <div>
                      <ol>
                        <li>
                          You can create a new map by using a form, on which you simply
                          select those municipalities from which you have finds.
                          If you want to use this method, select the "Use a form" -button.
                          <div>
                            <ul>
                              <li>
                                You must give the map a name which consists of only
                                alphanumerical characters and underscores.
                              </li>
                              <li>
                                If you don't want other users to be able to see your map,
                                you can select the "Private map" -checkbox.
                              </li>
                              <li>
                                Select those municipalities from which you have finds, by checking
                                the box next to the name. If you also want to track how many finds
                                you have from each municipality, you can enter a number into the
                                text box after the name. If you don't write anything here,
                                the default value will be set to 1.
                              </li>
                              <li>
                                The count only accepts whole numbers.
                              </li>
                              <li>
                                After naming the map and selecting the municipalities you want,
                                save the map by clicking the "Save file" -button.
                              </li>
                            </ul>
                          </div>
                        </li>
                        <li>
                          You can also create a new map by uploading a pre-filled .csv file
                          (a file format used by Excel).
                          If you want to use this method, select the "Use a .csv file" -button.
                          <div>
                            <ul>
                              <li>
                                This method is useful if you already have a file (for example, one
                                downloaded from Geocache.fi). If you don't have a file already,
                                it is recommended to make a new map by using the form.
                              </li>
                              <li>
                                <div class="text">
                                  If you choose to use a .csv file, the first row should be
                                  <b>Municipality,Count</b>, written exactly like this.
                                  The rows following the first row should be in the form
                                  <b>Municipality,Number</b>.
                                </div>
                              </li>
                              <li>
                                <div class="text">
                                  Your file can't contain any spaces or quotations. The names
                                  of municipalities and the numbers of finds should be separated
                                  by a comma. (Some operating systems use semicolon by default,
                                  which doesn't work). Make sure you use <b>,</b> instead of <b>;</b>
                                </div>
                              </li>
                              <li>
                                <div class="text">
                                  For example, if you want to create an FTF -map and you have 2 FTF
                                  finds from Oulu and 5 from Tampere, your .csv file should
                                  look like this:
                                </div>
                                <div class="code-title text">
                                  File: FTF.csv
                                </div>
                                <div class="code">
                                  Municipality,Count<br />
                                  Oulu,2<br />
                                  Tampere,5<br />
                                </div>
                              </li>
                              <li>
                                <div class="text">
                                  Make sure your file is encoded in UTF-8. By default the files are
                                  encoded in a different standard. Without UTF-8 the maps
                                  won't show data correctly. In order to change the encoding, open
                                  your file with Notepad. Navigate to "File" and select "Save as".
                                  At the bottom of the screen you'll see a selection for
                                  "Encoding". Change the value to UTF-8 and save the file.
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                      </ol>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-seventh-anchor"></a>
              <div class="section-title">
                7. Drawing your own maps
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-seventh">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-seventh">
                <ul>
                  <li>
                    To draw your own maps, you must be logged in.
                  </li>
                  <li>
                    You can draw maps which you have previously created. (see 6th step)
                  </li>
                  <li>
                    Start by navigating to "Draw your maps!" on the "Maps" -page.
                  </li>
                  <li>
                    From the dropdown menu, select the map which you want to draw, and click the "Draw map"
                    -button.
                  </li>
                  <li>
                    Alternatively, if you want to print the map, click the "Draw as printer friendly" -button.
                    <div>
                      <ul>
                        <li>
                          Click the paper size which you want the map to be printed in.
                          The printing dialogue will be automatically shown.
                        </li>
                        <li>
                          For now, only the A4 paper size is supported.
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-eighth-anchor"></a>
              <div class="section-title">
                8. Drawing other users' maps
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-eighth">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-eighth">
                <ul>
                  <li>
                    Start by navigating to "Draw someone else's maps!" on the "Maps" -page.
                  </li>
                  <li>
                    To draw other users' maps, enter a nickname and the name of a map belonging to this user.
                  </li>
                  <li>
                    You won't be able to draw any maps which other users have marked as private.
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-ninth-anchor"></a>
              <div class="section-title">
                9. Updating maps
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-ninth">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-ninth">
                <ul>
                  <li>
                    To update your maps, you must be logged in.
                  </li>
                  <li>
                    You can update maps you've created whenever your statistics change.
                    You can follow the same guide for updating a map regardless if it was made the form
                    or .csv method.
                  </li>
                  <li>
                    Start by navigating to "Update & delete maps" on the "Maps" -page.
                    Select a map you want to update from the dropdown menu and click on "Update map".
                    This pre-fills the form with the
                    information from the existing file.
                  </li>
                  <li>
                    If you don't want other users to be able to see your map, you can select the
                    "Private map" -checkbox.
                  </li>
                  <li>
                    Once you've done your changes, save the file by clicking on "Save file" found
                    at the bottom of the page.
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-tenth-anchor"></a>
              <div class="section-title">
                10. Deleting maps
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-tenth">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-tenth">
                <ul>
                  <li>
                    To delete maps, you must be logged in.
                  </li>
                  <li>
                    Start by navigating to "Update & delete maps" on the "Maps" -page. Select a map you want to
                    delete from the dropdown menu and click on "Delete map". Confirm that you want to delete the
                    map.
                  </li>
                  <li>
                    Please notice that the map you've selected will be permanently deleted from
                    the system, and isn't recoverable.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="fi">
          <div class="language-selectors">
            <button type="button" class="btn btn-primary btn-lg btn-green disabled language-finnish">
              Suomeksi
            </button>
            <button type="button" class="btn btn-primary btn-lg btn-green language-english">
              In English
            </button>
          </div>
          <div class="container-custom">
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-first-anchor-fi"></a>
              <div class="section-title">
                1. Käyttäjätilin luominen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-first-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-first-fi">
                <ul>
                  <li>
                    Voit luoda uuden käyttäjätilin "Log in" -sivulla, joka löytyy "Account" -valikosta.
                    <ul>
                      <li>
                        Et voi luoda käyttäjätiliä, jos saman niminen käyttäjänimi tai sähköposti on jo
                        rekisteröity sivustolle.
                      </li>
                      <li>
                        Kaikki kohdat tulee täyttää.
                      </li>
                      <li>
                        Sähköpostiosoitteen tulee olla olemassa oleva osoite.
                      </li>
                      <li>
                        Nimimerkki voi koostua vain alfanumeerisista merkeistä sekä alaviivoista.
                        Isoilla ja pienillä kirjaimilla on väliä.
                      </li>
                      <li>
                        Salasanan sekä salasanan vahvistuksen tulee täsmätä.
                        Isoilla ja pienillä kirjaimilla on väliä.
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-second-anchor-fi"></a>
              <div class="section-title">
                2. Sisäänkirjautuminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-second-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-second-fi">
                <ul>
                  <li>
                    Voit kirjautua käyttäjätilillesi "Log in" -sivulla, joka löytyy "Account" -valikosta.
                  </li>
                  <li>
                    Huomaathan, että isoilla ja pienillä kirjaimilla on merkitystä
                    nimimerkissä sekä salasanassa.
                  </li>
                  <li>
                    Jos olet jo kirjautunut sisään, sinun tulee kirjautua ulos ennen sisäänkirjautumista.
                  </li>
                  <li>
                    Kaikki kohdat tulee täyttää.
                  </li>
                  <li>
                    Jos unohdat salasanasi, klikkaa "Forgot your password?" -linkkiä
                    kirjautumissivulla. Voit asettaa uuden salasanan antamalla sähköpostiosoitteesi
                    avautuvaan ikkunaan ja painamalla "Reset password" -nappia. Sinulle lähetetään
                    sähköpostitse uusi salasana, jolla voit kirjautua sisään
                    nettisivustolle.
                    <strong>
                      Suosittelemme vahvasti, että vaihdat salasanasi uuteen heti kirjautumisen
                      jälkeen turvallisuussyistä.
                    </strong>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-third-anchor-fi"></a>
              <div class="section-title">
                3. Käyttäjätilin tietojen muuttaminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-third-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-third-fi">
                <ul>
                  <li>
                    Muuttaaksesi käyttäjätilisi tietoja, sinun tulee kirjautua sisään.
                  </li>
                  <li>
                    Kun olet kirjautuneena sisään, voit muuttaa tietojasi 'Account settings' -sivulla,
                    joka löytyy 'Account' -valikosta.
                  </li>
                  <li>
                    Sinun ei tarvitse päivittää kaikkia tietojasi kerralla. Täytä vain ne kohdat
                    jotka haluat muuttaa. Tyhjät kentät jätetään huomiotta.
                  </li>
                  <li>
                    Huomaathan, että salasanaasi vaihtaessa tulee myös antaa salasanan varmennus.
                  </li>
                  <li>
                    Tietojen muokkaamisen jälkeen sinut kirjataan automaattisesti ulos.
                    Jatkaaksesi sivuston käyttöä, sinun tulee kirjautua uudelleen sisään.
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-fourth-anchor-fi"></a>
              <div class="section-title">
                4. Käyttäjätilin poistaminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-fourth-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-fourth-fi">
                <ul>
                  <li>
                    Poistaaksesi käyttäjän, sinun tulee kirjautua sisään.
                  </li>
                  <li>
                    Kun olet kirjautuneena sisään, voit poistaa käyttäjäsi 'Account settings'
                    -sivulla, joka löytyy 'Account' -valikosta.
                  </li>
                  <li>
                    Huomaathan, että poistettuasi käyttäjäsi <b>ainoa tapa</b> palauttaa
                    käyttäjätilisi on ottaa yhteyttä sivuston ylläpitäjään.
                    Nimimerkkisi ja emailisi tulevat pysymään varattuina.
                  </li>
                  <li>
                    Ylläpitäjään saa yhteyden sähköpostilla:
                    <a href="mailto:admin@cachemaps.net" class="link-green">admin@cachemaps.net</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-fifth-anchor-fi"></a>
              <div class="section-title">
                5. Julkiset profiilit
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-fifth-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-fifth-fi">
                <ul>
                  <li>
                    Voit katsoa kenen tahansa CacheMaps.net -sivustolle käyttäjätunnuksen tehneen
                    käyttäjän julkista profiilia. Profiilin löydät menemällä osoitteeseen
                    'https://CacheMaps.net/users/nimimerkki', jossa sanan "nimimerkki" tilalle
                    kirjoitat sen käyttäjänimen, jonka profiilin haluat nähdä.
                  </li>
                  <li>
                    Voit mennä omaan profiiliisi käyttämällä 'public profile' -nappia, joka löytyy
                    'Account' -valikosta, jos olet kirjautuneena sisään.
                  </li>
                  <li>
                    Katsoessasi muiden käyttäjien profiileita, et näe sellaisia karttoja, jotka he ovat
                    merkinneet yksityisiksi.
                  </li>
                  <li>
                    Jos katsot omaa profiilisivuasi kun olet kirjautuneena sisään, voit tallentaa sen kuvana.
                    Tämä kuva tallennetaan osoitteeseen 'https://CacheMaps.net/files/users/nimimerkki/nimimerkki.png',
                    jossa 'nimimerkki' on sinun nimimerkkisi. Tästä osoitteesta pääset siis katsomaan
                    tallennettua kuvaa, ja voit käyttää sitä linkkinä.
                    <ul>
                      <li>
                        Tämä toiminnallisuus on tarkoitettu niille, jotka haluavat linkittää
                        CacheMaps -profiilinsa kartat esimerkiksi geocaching.com -profiilisivulleen
                        kuvana. Voit esimerkiksi linkata tähän kuvaan käyttämällä
                        <span class="code-inline">&lt;img&gt;</span> -html tägiä, ja asettamalla
                        sen lähteeksi (<span class="code-inline">source</span>) ylempänä määritellyn
                        osoitteen.
                      </li>
                      <li>
                        Esimerkiksi:
                        <span class="code-inline">
                          &lt;img src="https://CacheMaps.net/files/users/nimimerkki/nimimerkki.png"&gt;
                        </span>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-sixth-anchor-fi"></a>
              <div class="section-title">
                6. Kartan luominen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-sixth-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-sixth-fi">
                <ul>
                  <li>
                    Luodaksesi kartan, sinun tulee olla kirjautuneena sisään.
                  </li>
                  <li>
                    Voit luoda karttoja erilaisista löytämistäsi kätköistä, joita haluat seurata
                    kuntatasolla. Esimerkkejä tällaisista kuntakartoista ovat esimerkiksi FTF-kartta,
                    saarikätkökartta, kuntien vanhimpien kätköjen kartta, triplettikuntakartta,
                    kiipeilykätkökartta.. Tai ihan mitä itse keksit!
                  </li>
                  <li>
                    CacheMaps -sivustolla ei ole liityntää esim. geocaching.com tai geocache.fi -sivustoille
                    eikä se pysty hakemaan tilastoja suoraan niiltä. CacheMaps -sivuston tilastoja
                    ylläpitävät käyttäjät itse.
                  </li>
                  <li>
                    Luodaksesi uuden kartan, siirry "Maps" -sivulle ja siellä kohtaan
                    "Create a new map".
                  </li>
                  <li>
                    Kartan luomiseen on kaksi eri tapaa:
                    <div>
                      <ol>
                        <li>
                          Voit luoda kartan käyttämällä valmista lomaketta, johon vain valitset
                          ne kunnat joista sinulla on löytöjä. Valitse tällöin "Use a form" -painike.
                          <div>
                            <ul>
                              <li>
                                Anna kartalle nimi, joka koostuu vain alfanumeerisista
                                merkeistä sekä alaviivoista.
                              </li>
                              <li>
                                Mikäli et halua sivuston muiden käyttäjien näkevän karttaasi,
                                voit ruksia kohdan "Private map".
                              </li>
                              <li>
                                Valitse kunnat, joista sinulla on löytöjä, rastittamalla laatikko
                                kunnan nimen vieressä. Mikäli haluat seurata myös sitä, kuinka monta
                                löytöä sinulla on mistäkin kunnasta, voit kirjoittaa lukumäärän
                                kunnan nimen perässä olevaan tekstilaatikkoon. Mikäli et kirjoita
                                tähän mitään, oletuslukumääräksi asettuu 1.
                              </li>
                              <li>
                                Lukumäärään kelpaa vain kokonaisnumerot.
                              </li>
                              <li>
                                Nimettyäsi kartan ja valittuasi haluamasi kunnat, tallenna kartta
                                klikkaamalla "Save file" -painiketta.
                              </li>
                            </ul>
                          </div>
                        </li>
                        <li>
                          Voit luoda kartan myös lataamalla sivustolle valmiin .csv -tiedoston (Excelin
                          käyttämä .csv -tiedostotyyppi).
                          Valitse tällöin "Use a .csv file" -painike.
                          <div>
                            <ul>
                              <li>
                                Huom! Tämä menetelmä on kätevä, mikäli sinulla on jo olemassa
                                oleva tiedosto (esimerkiksi Geocache.fi -tilastoista ladattu).
                                Muussa tapauksessa on suositeltavaa tehdä kartta
                                lomaketta käyttämällä.
                              </li>
                              <li>
                                Mikäli käytät .csv tiedostoa, ensimmäisen rivin tulee olla
                                <b>Municipality,Count</b>, täsmälleen näin kirjoitettuna.
                                Ensimmäistä riviä seuraavat rivit tulevat olla muodossa
                                <b>Kunta,Numero</b>.
                              </li>
                              <li>
                                Tiedostossa ei saa olla välilyöntejä eikä sitaatteja. Kuntien
                                nimet ja löytöjen määrät tulee olla eroteltuna pilkulla.
                                (Joillakin käyttöjärjestelmillä oletus on puolipilkku, joka ei
                                kelpaa). Käytä siis <b>,</b> eikä <b>;</b>
                              </li>
                              <li>
                                Mikäli luot esimerkiksi FTF karttaa ja sinulla on 2 FTF-löytöä Oulusta
                                ja 5 Tampereelta, .csv tiedostosi tulisi näyttää tältä:
                                <div class="code-title text">
                                  Tiedosto: example.csv
                                </div>
                                <div class="code">
                                  Municipality,Count<br />
                                  Oulu,2<br />
                                  Tampere,5<br />
                                </div>
                              </li>
                              <li>
                                Varmista, että tiedosto on koodattu UTF-8 muotoon. Oletusarvoisesti
                                tiedostot on koodattu eri muotoon. Ilman UTF-8 koodausta kartat
                                eivät toimi oikein.
                                Vaihtaaksesi koodauksen, avaa tiedostosi Notepadillä.
                                Siirry kohtaan "File" (tai "Tiedosto") ja valitse "Save as" (tai
                                "Tallenna nimellä"). Ikkunan alareunassa näet kohdat
                                "Encoding" (tai "Koodaus"). Valitse muodoksi UTF-8 ja
                                tallenna tiedosto.
                              </li>
                            </ul>
                          </div>
                        </li>
                      </ol>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-seventh-anchor-fi"></a>
              <div class="section-title">
                7. Omien karttojen piirtäminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-seventh-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-seventh-fi">
                <ul>
                  <li>
                    Piirtääksesi omat karttasi, sinun tulee olla kirjautuneena sisään.
                  </li>
                  <li>
                    Voit piirtää niitä karttoja, jotka olet aiemmin luonut (ks. kohta 6)
                  </li>
                  <li>
                    Aloita siirtymällä "Maps" -sivulle kohtaan "Draw your maps!".
                  </li>
                  <li>
                    Valitse alasvetovalikosta kartta, jonka haluat piirtää, ja klikkaa "Draw map" -nappia.
                  </li>
                  <li>
                    Vaihtoehtoisesti, jos haluat tulostaa kartan, klikkaa "Draw as printer friendly" -nappia.
                    <div>
                      <ul>
                        <li>
                          Klikkaa sitä paperikokoa, jonka kokoisena haluat tulostaa kartan.
                          Printtaussivu tulee automaattisesti näkyviin.
                        </li>
                        <li>
                          Toistaiseksi vain A4 paperikoko on tuettu.
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-eighth-anchor-fi"></a>
              <div class="section-title">
                8. Muiden käyttäjien karttojen piirtäminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-eighth-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-eighth-fi">
                <ul>
                  <li>
                    Aloita siirtymällä "Maps" -sivulle kohtaan "Draw someone else's maps!".
                  </li>
                  <li>
                    Piirtääksesi muiden käyttäjien karttoja, syötä nimimerkki sekä tälle nimimerkille
                    kuuluvan kartan nimi.
                  </li>
                  <li>
                    Et voi piirtää sellaisia muiden käyttäjien karttoja,
                    jotka nämä ovat merkinneet yksityisiksi.
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-ninth-anchor-fi"></a>
              <div class="section-title">
                9. Karttojen päivittäminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-ninth-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-ninth-fi">
                <ul>
                  <li>
                    Päivittääksesi karttoja, sinun tulee olla kirjautuneena sisään.
                  </li>
                  <li>
                    Voit päivittää luomaasi karttaa sitä mukaan kun tilastosi muuttuvat. Kartan
                    päivittäminen toimii alla olevalla ohjeella riippumatta siitä, oletko luonut kartan
                    käyttämällä lomaketta vai .csv tiedostoa.
                  </li>
                  <li>
                    Aloita siirtymällä "Maps" -sivulle kohtaan "Update & delete maps". Valitse alasvetovalikosta
                    kartta, jota haluat päivittää, ja klikkaa "Update map". Tällöin saat näkyviin kunnat ja
                    löytömäärät, jotka olet syöttänyt sivustolle, ja voit päivittää ne ajantasaisiksi.
                  </li>
                  <li>
                    Mikäli et halua sivuston muiden käyttäjien näkevän karttaasi, voit ruksia kohdan
                    "Private map".
                  </li>
                  <li>
                    Lopuksi, tallenna tiedosto valitsemalla "Save file".
                  </li>
                </ul>
              </div>
            </div>
            <div class="section-box">
              <a href="#" class="section-anchor" id="section-tenth-anchor-fi"></a>
              <div class="section-title">
                10. Karttojen poistaminen
                <span class="spacer"></span>
                <span class="section-expand" id="section-expand-tenth-fi">
                  <i class="fas fa-angle-double-down fa-lg"></i>
                </span>
              </div>
              <div class="section-content hidden" id="section-tenth-fi">
                <ul>
                  <li>
                    Poistaaksesi karttoja, sinun tulee olla kirjautuneena sisään.
                  </li>
                  <li>
                    Aloita siirtymällä "Maps" -sivulle kohtaan "Update & delete maps". Valitse alasvetovalikosta
                    kartta, jonka haluat poistaa, ja klikkaa "Delete map". Vahvista, että haluat
                    varmasti poistaa kartan.
                  </li>
                  <li>
                    Huomioithan, että kyseinen kartta poistuu järjestelmästä
                    pysyvästi, eikä sitä voi palauttaa mitenkään.
                  </li>
                </ul>
              </div>
            </div>
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

</body>

</html>