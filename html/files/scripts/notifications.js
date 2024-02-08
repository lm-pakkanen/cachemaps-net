$(document).ready(function () {
  // Predefined constants for notifications
  let constants = {
    messages: {
      generic: {
        no_cookies: "Accepting cookies required.",
        generic: "Oops! Something went wrong.",
        nologin: "You have to be logged in to do that!",
        noauth: "You aren't allowed to do that!",
        txt_failed: "Oops! Something went wrong while reading a file.",
        invalid_nick: "The nickname you chose is invalid!",
        invalid_email: "The email you chose is invalid!",
        account_restricted: "Your account is restricted from doing that.",
      },
      create_account: {
        empty: "At least one input was empty",
        nomatch: "Your passwords don't match!",
        ill_nick: "The nickname you chose includes prohibited characters.",
        ill_email: "The email you chose includes prohibited characters.",
        nick_taken: "The nickname you chose is already taken!",
        email_taken: "The email you chose is already taken!",
        success: "Successfully created your account!",
      },
      update_account: {
        failed: "Oops! Something went wrong while updating your account",
        empty: "All fields were empty!",
        success: "Successfully updated your account.",
      },
      delete_account: {
        success: "Successfully deleted your account.",
      },
      login: {
        sess_exists: "You're already logged in!",
        empty: "At least one input was empty!",
        inc_login: "Incorrect login details!",
        success: "Successfully logged in!",
      },
      logout: {
        success: "Successfully logged out.",
      },
      upload_csv: {
        file_invalid: "The file you uploaded is invalid!",
        failed: "Oops! Couldn't upload your file.",
        success: "Successfully uploaded your .csv file!",
      },
      create_map: {
        noname: "You need to set a name for the map!",
        ill_nick: "The nickname you entered includes prohibited characters.",
        nan_input: "One of the count fields contains prohibited characters.",
        success: "Successfully created map!",
      },
      update_map: {
        name_empty: "No map was selected to update.",
        noname: "You need to set a name for the map!",
        ill_nick: "The nickname you entered includes prohibited characters.",
        nan_input: "One of the count fields contains prohibited characters.",
        success: "Successfully updated map!",
      },
      delete_map: {
        empty: "No map was selected to delete!",
        success: "Successfully deleted your map.",
      },
      send_mail: {
        empty: "The message body is empty!",
        success: "Message successfully sent!",
      },
      printer: {
        noname: "No map was selected to print.",
      },
      save_image: {
        fail: "Failed to upload your image!",
        success: "Successfully updated image.",
      },
      create_user_page: {
        file_exists: "This users' profile page already exists!",
        success: "",
      },
      password_reset: {
        success: "Password successfully reset!",
      },
    },
    colors: {
      default: {
        body: "orange",
        button: {
          color: "rgb(25,136,6)",
          background: "orange",
        },
      },
      green: {
        body: "rgb(25,136,6)",
        button: {
          color: "rgb(255,255,255)",
          background: "rgb(25,136,6)",
        },
      },
    },
  };

  let message = getParameter();

  if (!message) {
    return;
  } // If there isn't a parameter, return

  let _class = message.length >= 2 ? message[0] : "generic"; // If class not given, default to generic
  let _property = message.length >= 2 ? message[1] : message[0]; // If class not given, use first value of message

  /* ------------ Get colors for notification and button from json ------------ */
  let body_back =
    constants["colors"][_property === "success" ? "green" : "default"]["body"];

  let button_fore =
    constants["colors"][_property === "success" ? "green" : "default"][
      "button"
    ]["color"];

  let button_back =
    constants["colors"][_property === "success" ? "green" : "default"][
      "button"
    ]["background"];

  if (!constants["messages"][_class][_property]) {
    // If message doesn't exist, return
    return;
  }

  // Creates notification with predefined message and color
  createAlert(
    constants["messages"][_class][_property],
    body_back,
    button_fore,
    button_back
  );

  // Returns parameter from URL
  function getParameter() {
    let url = window.location.href;
    let param = "msg=";

    if (url.includes(param)) {
      let param_value = url.substring(url.indexOf(param) + 4);
      return param_value.split("-");
    }
  }

  // Creates alert div (params are color values)
  function createAlert(message, b1, b2, b3) {
    let notification_div = document.createElement("DIV");
    notification_div.className += "notification";
    notification_div.style.background = b1;

    let paragraph = document.createElement("P");
    paragraph.className += "notification-text";

    let messageNode = document.createTextNode(message);
    paragraph.appendChild(messageNode);

    let button = document.createElement("BUTTON");
    button.className += "button-exit-parent";
    button.style.background = b3;

    let icon = document.createElement("I");
    icon.className += "fa fa-window-close";
    icon.style.color = b2;

    button.appendChild(icon);
    notification_div.appendChild(paragraph);
    notification_div.appendChild(button);
    document.body.appendChild(notification_div);
  }
});
