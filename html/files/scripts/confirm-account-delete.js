function confirmAccountDelete(event) {
  if (
    !confirm(
      "Are you sure you want to delete your CacheMaps account permanently?"
    )
  ) {
    event.preventDefault();
    return;
  }

  if (!confirm("Are you really sure? You cannot reverse this action.")) {
    event.preventDefault();
  }
}
