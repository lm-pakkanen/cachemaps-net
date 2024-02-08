function init(nickname, mapfile, scale, width_multiplier, height_multiplier) {
  let map = document.getElementById("map-div");
  map.innerText = "";

  getFileInformation(nickname, mapfile.substr(0, mapfile.indexOf("."))).then(
    (data) => {
      $.get("../files/users/" + nickname + "/" + mapfile)
        .done(function () {
          drawMap(
            "#map-div",
            "../files/users/" + nickname + "/" + mapfile,
            scale,
            width_multiplier,
            height_multiplier
          );

          getNameAndTime(nickname, mapfile, data);
          showFindCounts("../files/users/" + nickname + "/" + mapfile);
          setCopyright();
        })
        .fail(function () {
          console.log("Couldn't find file: " + mapfile);
        });
    }
  );
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
function drawMap(
  target_ID,
  source,
  scale,
  width_multiplier,
  height_multiplier
) {
  let map = $("#map-div");
  let height = map.height();
  let width = map.width();

  var color = d3.scale
    .quantize()
    .range(["rgb(8,209,61)"]) // Green, default red
    .domain([0, 100]);

  var svg = d3
    .select(target_ID)
    .append("svg")
    .attr("id", "svg-printer")
    .attr("width", width)
    .attr("height", height);

  var projection = d3.geo
    .transverseMercator()
    .rotate([-27, -65, 0])
    .translate([width / width_multiplier, height / height_multiplier])
    .scale(scale);

  var path = d3.geo.path().projection(projection);

  d3.json("../files/json/finland.geojson", function (json) {
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
        .style("stroke", "rgb(0,20,20)"); // Border color

      svg
        .selectAll("text")
        .data(json.features)
        .enter()
        .append("text")
        .attr("class", "printer-text")
        .text(function (d) {
          return d.properties.NAMEFIN;
        })
        .attr("transform", function (d) {
          return "translate(" + path.centroid(d) + ")";
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
}
