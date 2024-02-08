/*
 * Sets session variable upon accept button press
 */
function acceptCookies() {
  let cookie_notification = $(".cookie-notification");

  if (!cookie_notification.hasClass("hide")) {
    cookie_notification.addClass("hide");
  }

  let http = new XMLHttpRequest();

  http.open("GET", "php/set-cookies.php?value=true", true);
  http.send();
}

/**
 * Sets session variable upon accept button press
 */
function rejectCookies() {
  let cookie_notification = $(".cookie-notification");

  if (!cookie_notification.hasClass("hide")) {
    cookie_notification.addClass("hide");
  }

  let http = new XMLHttpRequest();

  http.open("GET", "php/set-cookies.php?value=false", true);
  http.send();
}
