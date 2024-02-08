function confirmFileDelete(event, fileName) {
  if (fileName.indexOf(".csv") === -1) {
    event.preventDefault();
    return;
  }

  fileName = fileName.substring(
    fileName.lastIndexOf("=") + 1,
    fileName.indexOf(".csv")
  );

  if (!confirm("Are you sure you want to delete " + fileName + " ?")) {
    event.preventDefault();
    return;
  }

  if (
    !confirm(
      "Are you really sure you want to permanently " +
        "delete " +
        fileName +
        " ?"
    )
  ) {
    event.preventDefault();
  }
}
