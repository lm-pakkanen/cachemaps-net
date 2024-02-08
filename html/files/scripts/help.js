// Refresh page upon window resize to calculate new sizes for boxes

$(document).ready(() => {
  $(window).bind("resize", () => {
    if (window.RT) {
      clearTimeout(window.RT);
    }

    window.RT = setTimeout(function () {
      this.location.reload(false);
    }, 300);
  });

  let english_button = $(".language-english");
  let english_content = $(".eng");

  let finnish_button = $(".language-finnish");
  let finnish_content = $(".fi");

  english_button.click(() => {
    window.location.href = "https://CacheMaps.net/help?lang=en";
  });

  finnish_button.click(() => {
    window.location.href = "https://CacheMaps.net/help?lang=fi";
  });

  function showEnglish() {
    if (english_content.hasClass("hide")) {
      english_content.removeClass("hide");
    }

    if (!finnish_content.hasClass("hide")) {
      finnish_content.addClass("hide");
    }
  }

  function showFinnish() {
    if (finnish_content.hasClass("hide")) {
      finnish_content.removeClass("hide");
    }

    if (!english_content.hasClass("hide")) {
      english_content.addClass("hide");
    }
  }

  function getUrlVars() {
    let vars = {};

    window.location.href.replace(
      /[?&]+([^=&]+)=([^&]*)/gi,
      function (m, key, value) {
        vars[key] = value.substr(
          0,
          value.includes("#") ? value.indexOf("#") : value.length
        );
      }
    );

    return vars;
  }

  let urlParams = getUrlVars();

  if (urlParams["lang"] === "en" || !urlParams["lang"]) {
    showEnglish();
  } else if (urlParams["lang"] === "fi") {
    showFinnish();
  }

  let firstSection = $("#section-first");
  let firstSectionHeight = firstSection.height();
  firstSection.height(0);

  let firstSectionFi = $("#section-first-fi");
  let firstSectionHeightFi = firstSectionFi.height();
  firstSectionFi.height(0);

  let secondSection = $("#section-second");
  let secondSectionHeight = secondSection.height();
  secondSection.height(0);

  let secondSectionFi = $("#section-second-fi");
  let secondSectionHeightFi = secondSectionFi.height();
  secondSectionFi.height(0);

  let thirdSection = $("#section-third");
  let thirdSectionHeight = thirdSection.height();
  thirdSection.height(0);

  let thirdSectionFi = $("#section-third-fi");
  let thirdSectionHeightFi = thirdSectionFi.height();
  thirdSectionFi.height(0);

  let fourthSection = $("#section-fourth");
  let fourthSectionHeight = fourthSection.height();
  fourthSection.height(0);

  let fourthSectionFi = $("#section-fourth-fi");
  let fourthSectionHeightFi = fourthSectionFi.height();
  fourthSectionFi.height(0);

  let fifthSection = $("#section-fifth");
  let fifthSectionHeight = fifthSection.height();
  fifthSection.height(0);

  let fifthSectionFi = $("#section-fifth-fi");
  let fifthSectionHeightFi = fifthSectionFi.height();
  fifthSectionFi.height(0);

  let sixthSection = $("#section-sixth");
  let sixthSectionHeight = sixthSection.height();
  sixthSection.height(0);

  let sixthSectionFi = $("#section-sixth-fi");
  let sixthSectionHeightFi = sixthSectionFi.height();
  sixthSectionFi.height(0);

  let seventhSection = $("#section-seventh");
  let seventhSectionHeight = seventhSection.height();
  seventhSection.height(0);

  let seventhSectionFi = $("#section-seventh-fi");
  let seventhSectionHeightFi = seventhSectionFi.height();
  seventhSectionFi.height(0);

  let eighthSection = $("#section-eighth");
  let eighthSectionHeight = eighthSection.height();
  eighthSection.height(0);

  let eighthSectionFi = $("#section-eighth-fi");
  let eighthSectionHeightFi = eighthSectionFi.height();
  eighthSectionFi.height(0);

  let ninthSection = $("#section-ninth");
  let ninthSectionHeight = ninthSection.height();
  ninthSection.height(0);

  let ninthSectionFi = $("#section-ninth-fi");
  let ninthSectionHeightFi = ninthSectionFi.height();
  ninthSectionFi.height(0);

  let tenthSection = $("#section-tenth");
  let tenthSectionHeight = tenthSection.height();
  tenthSection.height(0);

  let tenthSectionFi = $("#section-tenth-fi");
  let tenthSectionHeightFi = tenthSectionFi.height();
  tenthSectionFi.height(0);

  $("#section-expand-first").click(() => {
    if ($("#section-first").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-first-anchor";
      }, 300);

      handleTextBoxAnimation("#section-first", firstSectionHeight);
    } else {
      handleTextBoxAnimation("#section-first", 0);
    }

    handleExpanderAnimation("#section-expand-first");
  });

  $("#section-expand-first-fi").click((e) => {
    if ($("#section-first-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-first-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-first-fi", firstSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-first-fi", 0);
    }

    handleExpanderAnimation("#section-expand-first-fi");
  });

  $("#section-expand-second").click(() => {
    if ($("#section-second").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-second-anchor";
      }, 300);

      handleTextBoxAnimation("#section-second", secondSectionHeight);
    } else {
      handleTextBoxAnimation("#section-second", 0);
    }

    handleExpanderAnimation("#section-expand-second");
  });

  $("#section-expand-second-fi").click(() => {
    if ($("#section-second-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-second-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-second-fi", secondSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-second-fi", 0);
    }

    handleExpanderAnimation("#section-expand-second-fi");
  });

  $("#section-expand-third").click(() => {
    if ($("#section-third").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-third-anchor";
      }, 300);

      handleTextBoxAnimation("#section-third", thirdSectionHeight);
    } else {
      handleTextBoxAnimation("#section-third", 0);
    }

    handleExpanderAnimation("#section-expand-third");
  });

  $("#section-expand-third-fi").click(() => {
    if ($("#section-third-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-third-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-third-fi", thirdSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-third-fi", 0);
    }

    handleExpanderAnimation("#section-expand-third-fi");
  });

  $("#section-expand-fourth").click(() => {
    if ($("#section-fourth").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-fourth-anchor";
      }, 300);

      handleTextBoxAnimation("#section-fourth", fourthSectionHeight);
    } else {
      handleTextBoxAnimation("#section-fourth", 0);
    }

    handleExpanderAnimation("#section-expand-fourth");
  });

  $("#section-expand-fourth-fi").click(() => {
    if ($("#section-fourth-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-fourth-anchor-fi";
      }, 300);
      handleTextBoxAn;
      imation("#section-fourth-fi", fourthSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-fourth-fi", 0);
    }

    handleExpanderAnimation("#section-expand-fourth-fi");
  });

  $("#section-expand-fifth").click(() => {
    if ($("#section-fifth").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-fifth-anchor";
      }, 300);

      handleTextBoxAnimation("#section-fifth", fifthSectionHeight);
    } else {
      handleTextBoxAnimation("#section-fifth", 0);
    }

    handleExpanderAnimation("#section-expand-fifth");
  });

  $("#section-expand-fifth-fi").click(() => {
    if ($("#section-fifth-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-fifth-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-fifth-fi", fifthSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-fifth-fi", 0);
    }

    handleExpanderAnimation("#section-expand-fifth-fi");
  });

  $("#section-expand-sixth").click(() => {
    if ($("#section-sixth").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-sixth-anchor";
      }, 300);

      handleTextBoxAnimation("#section-sixth", sixthSectionHeight);
    } else {
      handleTextBoxAnimation("#section-sixth", 0);
    }

    handleExpanderAnimation("#section-expand-sixth");
  });

  $("#section-expand-sixth-fi").click(() => {
    if ($("#section-sixth-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-sixth-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-sixth-fi", sixthSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-sixth-fi", 0);
    }

    handleExpanderAnimation("#section-expand-sixth-fi");
  });

  $("#section-expand-seventh").click(() => {
    if ($("#section-seventh").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-seventh-anchor";
      }, 300);

      handleTextBoxAnimation("#section-seventh", seventhSectionHeight);
    } else {
      handleTextBoxAnimation("#section-seventh", 0);
    }

    handleExpanderAnimation("#section-expand-seventh");
  });

  $("#section-expand-seventh-fi").click(() => {
    if ($("#section-seventh-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-seventh-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-seventh-fi", seventhSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-seventh-fi", 0);
    }

    handleExpanderAnimation("#section-expand-seventh-fi");
  });

  $("#section-expand-eighth").click(() => {
    if ($("#section-eighth").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-eighth-anchor";
      }, 300);

      handleTextBoxAnimation("#section-eighth", eighthSectionHeight);
    } else {
      handleTextBoxAnimation("#section-eighth", 0);
    }

    handleExpanderAnimation("#section-expand-eighth");
  });

  $("#section-expand-eighth-fi").click(() => {
    if ($("#section-eighth-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-eighth-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-eighth-fi", eighthSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-eighth-fi", 0);
    }

    handleExpanderAnimation("#section-expand-eighth-fi");
  });

  $("#section-expand-ninth").click(() => {
    if ($("#section-ninth").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-ninth-anchor";
      }, 300);

      handleTextBoxAnimation("#section-ninth", ninthSectionHeight);
    } else {
      handleTextBoxAnimation("#section-ninth", 0);
    }

    handleExpanderAnimation("#section-expand-ninth");
  });

  $("#section-expand-ninth-fi").click(() => {
    if ($("#section-ninth-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-ninth-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-ninth-fi", ninthSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-ninth-fi", 0);
    }

    handleExpanderAnimation("#section-expand-ninth-fi");
  });

  $("#section-expand-tenth").click(() => {
    if ($("#section-tenth").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-tenth-anchor";
      }, 300);

      handleTextBoxAnimation("#section-tenth", tenthSectionHeight);
    } else {
      handleTextBoxAnimation("#section-tenth", 0);
    }

    handleExpanderAnimation("#section-expand-tenth");
  });

  $("#section-expand-tenth-fi").click(() => {
    if ($("#section-tenth-fi").hasClass("hidden")) {
      setTimeout(() => {
        location.hash = "section-tenth-anchor-fi";
      }, 300);

      handleTextBoxAnimation("#section-tenth-fi", tenthSectionHeightFi);
    } else {
      handleTextBoxAnimation("#section-tenth-fi", 0);
    }

    handleExpanderAnimation("#section-expand-tenth-fi");
  });

  function handleTextBoxAnimation(element, height) {
    $(element).toggleClass("hidden");

    if (height > 0) {
      $(element).css("margin-top", "15px");
    } else {
      setTimeout(() => {
        $(element).css("margin-top", "0");
      }, 275);
    }

    $(element).animate(
      {
        height: height,
      },
      300
    );
  }

  function handleExpanderAnimation(element) {
    if (!$(element).hasClass("expanded")) {
      $(element).animate(
        {
          deg: 90,
        },
        {
          duration: 300,
          step: function (now) {
            $(this).css({ transform: "rotate(" + now + "deg)" });
          },
        }
      );
    } else {
      $(element).animate(
        {
          deg: 0,
        },
        {
          duration: 300,
          step: function (now) {
            $(this).css({ transform: "rotate(" + now + "deg)" });
          },
        }
      );
    }

    $(element).toggleClass("expanded");
  }
});
