function init(nickname, logged_in_nickname) {
  $("#draw-maps-own").click(function () {
    let map = document.getElementById("map-div");

    map.querySelectorAll("svg").forEach(function (svg) {
      map.removeChild(svg);
    });

    map.querySelectorAll("canvas").forEach(function (canvas) {
      map.removeChild(canvas);
    });

    map.querySelectorAll("div").forEach(function (div) {
      map.removeChild(div);
    });

    map.style.opacity = "1";

    let mapfile = document.getElementById("map-name").value;

    getFileInformation(
      nickname,
      mapfile.substr(0, mapfile.indexOf(".")),
      ""
    ).then((data) => {
      $.get("files/users/" + nickname + "/" + mapfile)
        .done(function () {
          if (data["isDeleted"] === 0) {
            if (data["isPrivate"] === 0) {
              drawMap("#map-div", "files/users/" + nickname + "/" + mapfile);
              getNameAndTime(nickname, mapfile, data);
              showFindCounts("files/users/" + nickname + "/" + mapfile);
              setCopyright();
            } else {
              if (logged_in_nickname === data["nickname"]) {
                drawMap("#map-div", "files/users/" + nickname + "/" + mapfile);
                getNameAndTime(nickname, mapfile, data);
                showFindCounts("files/users/" + nickname + "/" + mapfile);
                setCopyright();
              } else {
                drawUnauthorized();
              }
            }
          } else {
            drawDeletedMap();
          }
        })
        .fail(function () {
          drawMap404();
        });
    });
  });

  $("#draw-maps-others-button").click(function () {
    let map = document.getElementById("map-div");
    map.querySelectorAll("svg").forEach(function (svg) {
      map.removeChild(svg);
    });

    map.querySelectorAll("canvas").forEach(function (canvas) {
      map.removeChild(canvas);
    });

    map.querySelectorAll("div").forEach(function (div) {
      map.removeChild(div);
    });

    map.style.opacity = "1";

    let nickname = document.getElementById("nickname").value;

    let maptype = document.getElementById("map-name-other").value;
    let mapfile = maptype + ".csv";

    getFileInformation(
      nickname,
      mapfile.substr(0, mapfile.indexOf(".")),
      ""
    ).then((data) => {
      $.get("files/users/" + nickname + "/" + mapfile)
        .done(function () {
          if (data["isDeleted"] === 0) {
            if (data["isPrivate"] === 0) {
              drawMap("#map-div", "files/users/" + nickname + "/" + mapfile);
              getNameAndTime(nickname, mapfile, data);
              showFindCounts("files/users/" + nickname + "/" + mapfile);
              setCopyright();
            } else {
              if (logged_in_nickname === data["nickname"]) {
                drawMap("#map-div", "files/users/" + nickname + "/" + mapfile);
                getNameAndTime(nickname, mapfile, data);
                showFindCounts("files/users/" + nickname + "/" + mapfile);
                setCopyright();
              } else {
                drawUnauthorized();
              }
            }
          } else {
            drawDeletedMap();
          }
        })
        .fail(function () {
          drawMap404();
        });
    });
  });
}

function drawPlaceholder() {
  let nickname = "placeholder";

  let mapfile = "placeholder.csv";

  getFileInformation(
    nickname,
    mapfile.substr(0, mapfile.indexOf(".")),
    ""
  ).then((data) => {
    $.get("files/users/" + nickname + "/" + mapfile)
      .done(function () {
        drawMap("#map-div", "files/users/" + nickname + "/" + mapfile);
        setCopyright();
      })
      .fail(function () {
        console.log("Couldn't find file: " + mapfile);
      });
  });
}

function drawUnauthorized() {
  let mapDiv = document.getElementById("map-div");

  let unauthorizedDiv = document.createElement("DIV");
  unauthorizedDiv.className = "unauthorized-div";

  let unauthorizedTextP = document.createElement("P");
  unauthorizedTextP.className = "unauthorized-text";

  let unauthorizedText = document.createTextNode("This map is private.");

  unauthorizedTextP.appendChild(unauthorizedText);
  unauthorizedDiv.appendChild(unauthorizedTextP);

  mapDiv.appendChild(unauthorizedDiv);
}

function drawDeletedMap() {
  let mapDiv = document.getElementById("map-div");

  let mapDeletedDiv = document.createElement("DIV");
  mapDeletedDiv.className = "deleted-map-div";

  let mapDeletedTextP = document.createElement("P");
  mapDeletedTextP.className = "deleted-map-text";

  let mapDeletedText = document.createTextNode("This map no longer exists.");

  mapDeletedTextP.appendChild(mapDeletedText);
  mapDeletedDiv.appendChild(mapDeletedTextP);

  mapDiv.appendChild(mapDeletedDiv);
}

function drawMap404() {
  let mapDiv = document.getElementById("map-div");

  let map404Div = document.createElement("DIV");
  map404Div.className = "map404-div";

  let map404TextP = document.createElement("P");
  map404TextP.className = "map404-text";

  let map404Text = document.createTextNode("Map was not found.");

  map404TextP.appendChild(map404Text);
  map404Div.appendChild(map404TextP);

  mapDiv.appendChild(map404Div);
}

function getNameAndTime(nickname, mapfile, data) {
  let mapdiv = document.getElementById("map-div");
  let name = data["map_name"];

  if ((name + ".csv").match(mapfile)) {
    let datediv = document.createElement("DIV");
    datediv.className += "map-div-date";

    let unixMillTime = new Date(data["updated_at_date"] * 1000);
    let day = unixMillTime.getDate();
    let month = unixMillTime.getMonth() + 1;
    let year = unixMillTime.getFullYear();
    let hour = unixMillTime.getHours();
    let minutes = "0" + unixMillTime.getMinutes();
    let seconds = "0" + unixMillTime.getSeconds();

    let updateTime =
      day +
      "/" +
      month +
      "/" +
      year +
      " " +
      hour +
      ":" +
      minutes.substr(-2) +
      ":" +
      seconds.substr(-2);

    let date = document.createTextNode(updateTime);
    datediv.appendChild(date);
    mapdiv.appendChild(datediv);

    let namediv = document.createElement("DIV");
    namediv.className += "map-div-name";

    let mapname = document.createTextNode(name);
    namediv.appendChild(mapname);
    mapdiv.appendChild(namediv);
  }
}

function setCopyright() {
  let mapdiv = document.getElementById("map-div");

  let copydiv = document.createElement("DIV");
  copydiv.className += "map-div-copyright";

  let copyright = document.createTextNode("\u00A9 CacheMaps.net");
  copydiv.appendChild(copyright);
  mapdiv.appendChild(copydiv);
}

function showFindCounts(mapfile) {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", mapfile);
  xhr.send();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        let output = xhr.responseText.split(/\n/);

        let green_count = 0;
        let red_count = 311;

        output.forEach(function (line) {
          if (!line) {
            return;
          }

          let count = parseInt(line.split(",")[1]);
          if (/^[1-9]\d*$/.test(count)) {
            green_count += 1;
          }
        });

        draw(green_count, red_count - green_count);
      }
    }
  };

  function draw(green_count, red_count) {
    let mapdiv = document.getElementById("map-div");

    let countcanvas = document.createElement("CANVAS");
    countcanvas.className += "canvas";
    countcanvas.id += "canvas";

    mapdiv.appendChild(countcanvas);

    let green_box = countcanvas.getContext("2d");
    green_box.fillStyle = "rgb(0,0,0)";
    green_box.fillRect(0, 28, 34, 34);
    green_box.fillStyle = "rgb(8,209,61)";
    green_box.fillRect(2, 30, 30, 30);

    let red_box = countcanvas.getContext("2d");
    red_box.fillStyle = "rgb(0,0,0)";
    red_box.fillRect(0, 66, 34, 34);
    red_box.fillStyle = "red";
    red_box.fillRect(2, 68, 30, 30);

    let green_count_context = countcanvas.getContext("2d");
    green_count_context.fillStyle = "rgb(8,209,61)";
    green_count_context.font = "30px Arial";
    green_count_context.fillText(green_count, 42, 57);

    let red_count_context = countcanvas.getContext("2d");
    red_count_context.font = "30px Arial";
    red_count_context.fillStyle = "red";
    red_count_context.fillText(red_count, 42, 96);
  }
}

// Draw map
function drawMap(target_ID, source) {
  let map_wrapper = $(".map-area-wrapper");
  let map = $("#map-div");
  let height = map.innerHeight();
  let height_m = 2;
  let width = map.innerWidth();
  let width_m = 2;
  let scale = 3800;

  if (width > 800 && width <= 1700) {
    height_m = 2.1;
  }

  if (width > 680 && width <= 800) {
    console.warn("Small window size");
    map.css("height", "800");
    map_wrapper.css("height", "820");
    height = 800;
    width_m = 2;
    height_m = 2.1;
    scale = 4100;
  } else if (width > 590 && width <= 680) {
    console.warn("Minimal window size");
    map.css("height", "800");
    map_wrapper.css("height", "820");
    height = 800;
    width_m = 1.9;
    height_m = 2.15;
    scale = 3900;
  }

  var color = d3.scale
    .quantize()
    .range(["rgb(8,209,61)"]) // Green, default red
    .domain([0, 100]);

  // Drag behaviour for map
  var drag = d3.behavior
    .drag()
    .on("dragstart", function () {
      var proj = projection.translate();
      m0 = [d3.event.sourceEvent.pageX, d3.event.sourceEvent.pageY];
      o0 = [-proj[0], -proj[1]];
    })
    .on("drag", function () {
      if (m0) {
        var m1 = [d3.event.sourceEvent.pageX, d3.event.sourceEvent.pageY],
          o1 = [o0[0] + (m0[0] - m1[0]) / 2, o0[1] + (m0[1] - m1[1]) / 2];
        projection.translate([-o1[0], -o1[1]]);
      }

      // Update the map
      path = d3.geo.path().projection(projection);
      d3.selectAll("path").attr("d", path);
    });

  var svg = d3
    .select(target_ID)
    .append("svg")
    .attr("width", width)
    .attr("height", height);

  // This event listener adds drag functionality to maps
  // ONLY if the device uses a mouse, IE isn't touch screen.
  // D3.js does not support touch screen devices.
  let mouseListener = function () {
    svg.call(drag);
    document.removeEventListener("mousemove", mouseListener, false);
  };

  document.addEventListener("mousemove", mouseListener, false);

  // Zoom behaviour for map
  svg.call(
    d3.behavior.zoom().on("zoom", function () {
      svg.attr("transform", "scale(" + d3.event.scale + ")");
      d3.select("#province_overlay").attr(
        "transform",
        "scale(" + d3.event.scale + ")"
      );
    })
  );

  var projection = d3.geo
    .transverseMercator()
    .rotate([-27, -65, 0])
    .translate([width / width_m, height / height_m])
    .scale([scale]);

  var path = d3.geo.path().projection(projection);

  d3.json("files/json/finland.geojson", function (json) {
    d3.csv(source, function (data) {
      color.domain([
        d3.min(data, function (d) {
          return d.Count;
        }),
        d3.max(data, function (d) {
          return d.Count;
        }),
      ]);

      for (var i = 0; i < data.length; i++) {
        var dataState = data[i].Municipality;
        var dataValue = parseInt(data[i].Count);

        //Find the corresponding state inside the GeoJSON
        for (var j = 0; j < json.features.length; j++) {
          var jsonState = json.features[j].properties.NAMEFIN;

          if (dataState === jsonState) {
            //Copy the data value into the JSON
            json.features[j].properties.value = dataValue;
            break;
          }
        }
      }

      svg
        .selectAll("path")
        .data(json.features)
        .enter()
        .append("path")
        .attr("d", path)
        .style("fill", setNormalColor)
        .style("stroke", "rgb(0,20,20)") // Border color
        .on("mouseover", function (d) {
          d3.select(this).style("fill", "orange");

          var coordinates;
          coordinates = d3.mouse(document.getElementById("map-div"));

          var target = d3
            .select("#tooltip")
            .style("left", coordinates[0] + 30 + "px")
            .style("top", coordinates[1] - 65 + "px");

          target.select("#municipality").text(d.properties.NAMEFIN);
          target.select("#property").text("Count: " + d.properties.value);

          d3.select("#tooltip").classed("hidden", false);
        })
        .on("mouseout", function (d) {
          d3.select(this).style("fill", setNormalColor(d));
          d3.select("#tooltip").classed("hidden", true);
        });
    });
  });

  d3.json("files/json/finland_provinces.geojson", function (json) {
    let svg2 = d3
      .select(target_ID)
      .append("svg")
      .attr("width", width)
      .attr("height", height)
      .attr("id", "province_overlay");

    svg2
      .selectAll("path")
      .data(json.features)
      .enter()
      .append("path")
      .attr("d", path)
      .style("fill", "transparent")
      .style("stroke", "hsla(0,0%,20%,1") // Border color
      .attr("stroke-width", "4");
  });

  // Sets color back to original
  var setNormalColor = function (d) {
    var value = d.properties.value;

    if (value) {
      return "rgb(8,209,61)";
    } else {
      d.properties.value = 0;
      return "red";
    }
  };
}
