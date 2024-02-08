let map_number = 1;
let map_id = "a";

function resetConsts() {
  map_number = 1;
  map_id = "a";
}
function drawProfileMap(
  csvFilePath,
  nickname,
  logged_in_nickname,
  isDrawImage = false,
  target = "maps-div",
  modification = "",
  w_mod = 2,
  h_mod = 2
) {
  let file = csvFilePath.substr(csvFilePath.lastIndexOf("/") + 1);
  let fileName = file.substr(0, file.indexOf("."));

  getFileInformation(nickname, fileName, "").then((data) => {
    $.get("files/users/" + nickname + "/" + file)
      .done(function () {
        if (data["isDeleted"] === 0) {
          if (data["isPrivate"] === 0) {
            createElement(target, modification);

            drawIfReady(
              csvFilePath,
              nickname,
              map_id + modification,
              w_mod,
              h_mod,
              data
            );

            drawToCanvas(
              map_id + modification + "-canvas",
              map_id + modification
            );
          } else {
            if (logged_in_nickname === data["nickname"] && !isDrawImage) {
              createElement(target, modification);

              drawIfReady(
                csvFilePath,
                nickname,
                map_id + modification,
                w_mod,
                h_mod,
                data
              );

              drawToCanvas(
                map_id + modification + "-canvas",
                map_id + modification
              );
            } else {
              console.log("Unauthorized"); // TODO: Handle unauthorized view of private map
              return;
            }
          }

          map_id = String.fromCharCode(map_id.charCodeAt(0) + 1);
          map_number += 1;
        } else {
          console.log("File '" + file + "' is deleted.");
        } // TODO: Handle deleted map file
      })
      .fail(function () {
        console.log("Couldn't find file: " + file); // TODO: Handle missing map file
      });
  });
}

function drawIfReady(csvFilePath, nickname, map_id_m, w_mod, h_mod, data) {
  if (!$(document).find("#" + map_id)[0]) {
    setTimeout(function () {
      drawIfReady(csvFilePath, nickname, map_id_m, w_mod, h_mod, data);
    }, 200);
  } else {
    setTimeout(function () {
      $.get(csvFilePath)
        .done(function () {
          drawMap(map_id_m, csvFilePath, nickname, w_mod, h_mod, data);
        })
        .fail(function () {
          console.log("Couldn't find file: " + csvFilePath);
        });
    }, 500);
  }
}
function createElement(target, modification) {
  if (map_number % 2 !== 0) {
    let maps_div = document.getElementById(target);

    let row_div = document.createElement("DIV");
    row_div.id = map_id + modification + "-row";
    row_div.className += "map-row";

    let row_wrapper = document.createElement("DIV");
    row_wrapper.classList.add("row-wrapper");
    row_wrapper.appendChild(row_div);

    maps_div.appendChild(row_wrapper);

    let canvas = document.createElement("CANVAS");
    canvas.id = map_id + modification + "-canvas";
    canvas.className += "map-canvas";
    canvas.height = 750;
    canvas.width = 630;

    let map_div = document.createElement("DIV");
    map_div.appendChild(canvas);
    map_div.id = map_id + modification;
    map_div.classList.add("box");
    map_div.classList.add("restricted");

    row_div.appendChild(map_div);
  } else {
    let map_id_local = String.fromCharCode(map_id.charCodeAt(0) - 1);
    let row_div = document.getElementById(map_id_local + modification + "-row");

    let canvas = document.createElement("CANVAS");
    canvas.id = map_id + modification + "-canvas";
    canvas.className += "map-canvas";
    canvas.height = 750;
    canvas.width = 630;

    let map_div = document.createElement("DIV");
    map_div.id = map_id + modification;
    map_div.classList.add("box");
    map_div.classList.add("restricted");
    map_div.appendChild(canvas);

    row_div.appendChild(map_div);
  }
}
function drawToCanvas(canvasID, targetID) {
  setTimeout(function () {
    let map = $("#" + targetID);
    let height = map.height();
    let width = map.width();

    let canvas = document.getElementById(canvasID);
    let ctx = canvas.getContext("2d");

    let svg = new XMLSerializer().serializeToString(
      document.getElementById(targetID + "-svg")
    );

    ctx.drawSvg(svg, 0, 0, width, height);

    setTimeout(() => {
      $(".restricted").removeClass("restricted");
    }, 500);
  }, 2000);
}

function getNameAndTime(nickname, csvFilePath, data, map_id) {
  let start = csvFilePath.lastIndexOf("/") + 1;

  let mapdiv = document.getElementById(map_id);
  let name = data["map_name"];

  if ((name + ".csv").match(csvFilePath.substr(start))) {
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

function setCopyright(targetID) {
  let mapdiv = document.getElementById(targetID);

  let copydiv = document.createElement("DIV");
  copydiv.className += "map-div-copyright";

  let copyright = document.createTextNode("\u00A9 CacheMaps.net");
  copydiv.appendChild(copyright);
  mapdiv.appendChild(copydiv);
}

function showFindCounts(mapfile, targetID) {
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

        draw(green_count, red_count - green_count, targetID);
      }
    }
  };

  function draw(green_count, red_count, targetID) {
    let mapdiv = document.getElementById(targetID);

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
    red_count_context.fillText(red_count, 42, 95);
  }
}

// Draw map
function drawMap(targetID, csvFilePath, nickname, w_mod, h_mod, data) {
  let map = $("#" + targetID);
  let height = map.height();
  let width = map.width();

  var color = d3.scale
    .quantize()
    .range(["rgb(8,209,61)"]) // Green, default red
    .domain([0, 100]);

  var svg = d3
    .select("#" + targetID)
    .append("svg")
    .attr("id", targetID + "-svg")
    .attr("width", width)
    .attr("height", height);

  var scale = 4200;

  var projection = d3.geo
    .transverseMercator()
    .rotate([-27, -65, 0])
    .translate([width / w_mod, height / h_mod])
    .scale(scale);

  var path = d3.geo.path().projection(projection);

  d3.json("files/json/finland.geojson", function (json) {
    d3.csv(csvFilePath, function (data) {
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
          coordinates = d3.mouse(document.getElementById(targetID));

          var target = d3
            .select("#tooltip")
            .style("left", coordinates[0] + "px")
            .style("top", coordinates[1] + 90 + "px");
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

  // Add a viewbox to map
  let SVG = map.find("svg");

  SVG.attr("viewBox", "0 0 " + width + " " + height);
  SVG.attr("preserveAspectRatio", "none");
  SVG.attr("width", "100%");
  SVG.attr("height", "100%");

  getNameAndTime(nickname, csvFilePath, data, targetID);
  showFindCounts(csvFilePath, targetID);
  setCopyright(targetID);
}
