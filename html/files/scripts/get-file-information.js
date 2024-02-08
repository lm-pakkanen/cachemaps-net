function getFileInformation(nickname, map_name, filePrefix = "../") {
  return new Promise((resolve) => {
    let result = {};
    let xmlResult = "";

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.open(
      "GET",
      filePrefix +
        "php/getFileInformation.php?nickname=" +
        nickname +
        "&map_name=" +
        map_name,
      true
    );

    xmlhttp.send();

    xmlhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        xmlResult = this.responseText.replace(/\s/g, "");

        let xmlResultList = xmlResult.split(",");
        let nickname = xmlResultList[0];
        let map_name = xmlResultList[1];
        let updated_at_date = xmlResultList[2];
        let isDeleted = parseInt(xmlResultList[3]);
        let isPrivate = parseInt(xmlResultList[4]);

        result["nickname"] = nickname;
        result["map_name"] = map_name;
        result["updated_at_date"] = updated_at_date;
        result["isDeleted"] = isDeleted;
        result["isPrivate"] = isPrivate;

        resolve(result);
      }
    };
  });
}
