$(document).ready(function () {
  function hideAccountUnderDropdown() {
    handleAnimation("account-dropdown-under-dropdown", 0, -200, 0, 0, "right");
  }

  function handleAnimation(
    element,
    animateStart,
    animateFinish,
    rotateStart,
    rotateFinish,
    direction = "top",
    callback = ""
  ) {
    let options = {};
    options["direction"] = direction;

    let dropdownMenu = $("#" + element);
    let dropdown_fa = $(".fa-caret-custom");

    /**
     * If hidden, toggle off class and animate element
     * If not hidden, give class and animate element back
     */
    if (dropdownMenu.hasClass("hide")) {
      options[direction] = animateFinish;

      dropdownMenu.toggleClass("hide");
      dropdownMenu.animate(options, 200);

      dropdown_fa.animate(
        {
          deg: rotateFinish,
        },
        {
          duration: 200,
          step: function (now) {
            $(this).css({ transform: "rotate(" + now + "deg)" });
          },
          complete: function () {
            if (callback) {
              callback();
            }
          },
        }
      );
    } else {
      options[direction] = animateStart;

      dropdownMenu.animate(options, 200, function () {
        dropdownMenu.addClass("hide");
      });

      dropdown_fa.animate(
        { deg: rotateStart },
        {
          duration: 200,
          step: function (now) {
            $(this).css({ transform: "rotate(" + now + "deg)" });
          },
          complete: function () {
            if (callback) {
              callback();
            }
          },
        }
      );
    }
  }

  let navBurger = $(".navbar-burger");

  // Animate dropdown menu upon burger click
  navBurger.click(function () {
    navBurger.toggleClass("change");

    let callback = "";

    if (
      !navBurger.hasClass("change") &&
      !$("#account-dropdown-under-dropdown").hasClass("hide")
    ) {
      callback = hideAccountUnderDropdown;
    }

    handleAnimation("general-dropdown", -200, -20, 0, -90, "top", callback);
  });

  // Animate dropdown menu upon account
  // Button click
  $("#account-dropdown-button").click(function () {
    handleAnimation("account-dropdown", -200, -20, 0, -90);
  });

  $("#under-dropdown-account-dropdown").click(function () {
    handleAnimation(
      "account-dropdown-under-dropdown",
      -200,
      160,
      -90,
      -180,
      "right"
    );
  });

  // Hide navbar elements on window resize
  $(window).on("resize", function () {
    let dropDown = $(".dropdown-menu-custom");

    if (!dropDown.hasClass("hide")) {
      dropDown.addClass("hide");
    }

    if (navBurger.hasClass("change")) {
      navBurger.toggleClass("change");
    }

    let general_dropdown = $("#general-dropdown");

    if (!general_dropdown.hasClass("hide")) {
      general_dropdown.addClass("hide");
    }
  });
});
