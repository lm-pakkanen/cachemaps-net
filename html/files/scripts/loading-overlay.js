function showLoading() {
  let loadingDivText = document.createTextNode("Loading, please wait...");

  let loadingIcon = document.createElement("I");
  loadingIcon.className += "fa fa-gear slow-spin";

  let loadingDiv = document.createElement("DIV");
  loadingDiv.className += "loading-div";
  loadingDiv.id = "loading-div";

  let loadingP = document.createElement("P");
  loadingP.className += "loading-div-text";
  loadingP.appendChild(loadingDivText);
  loadingP.appendChild(loadingIcon);

  loadingDiv.appendChild(loadingP);
  document.body.appendChild(loadingDiv);
}

function hideLoading() {
  document.getElementById("loading-div").remove();
}
