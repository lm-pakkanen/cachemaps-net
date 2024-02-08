$(document).ready(function () {
  // Exit animation
  $(".button-exit-parent").click(function () {
    if ($(this).attr("id") === "footer-exit") {
      $(this.parentElement).animate({ bottom: "-200", opacity: "0" }, 600);
    } else {
      $(this.parentElement).animate({ top: "-200", opacity: "0" }, 200);
    }
  });

  // On click of header image, redirect to index
  $(".header-image").click(function () {
    window.location.href = "https://CacheMaps.net";
  });

  //<editor-fold desc="Input validators">
  $("#draw-maps-own").click(function () {
    if (
      $("#map-name")
        .children("option:selected")
        .val()
        .replace(/\s/g, "")
        .replace(/\n/g, "")
    ) {
      return;
    }

    handleInvalidInput(errorMessages["map-select"].empty);
  });

  $("#draw-maps-own-printer").click(function () {
    if (
      $("#map-name")
        .children("option:selected")
        .val()
        .replace(/\s/g, "")
        .replace(/\n/g, "")
    ) {
      return;
    }

    handleInvalidInput(errorMessages["map-select"].empty);
  });

  $("#draw-maps-others-button").click(function () {
    if (!$("#nickname").val().replace(/\s/g, "").replace(/\n/g, "")) {
      handleInvalidInput(errorMessages["field"]["nickname"].empty);
    }

    if (!$("#map-name-other").val().replace(/\s/g, "").replace(/\n/g, "")) {
      handleInvalidInput(errorMessages["field"]["mapname"].empty);
    }
  });

  $("#update-map").click(function () {
    if (
      $("#map-name-update")
        .children("option:selected")
        .val()
        .replace(/\s/g, "")
        .replace(/\n/g, "")
    ) {
      return;
    }

    handleInvalidInput(errorMessages["map-select"].empty);
  });

  $("#delete-map").click(function () {
    if (
      $("#map-name-update")
        .children("option:selected")
        .val()
        .replace(/\s/g, "")
        .replace(/\n/g, "")
    ) {
      return;
    }

    handleInvalidInput(errorMessages["map-select"].empty);
  });
});

let errorMessages = {
  "map-select": {
    empty: "No map was selected!",
  },
  field: {
    nickname: {
      empty: "No nickname was entered!",
    },
    mapname: {
      empty: "No map was entered!",
    },
  },
  email: {
    nologin: "You must be logged in!",
  },
};

function handleInvalidInput(message) {
  alert(message);
  event.preventDefault();
}
