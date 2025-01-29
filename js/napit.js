// NAPPIEN TOIMINNALLISUUS ARVO_OSALLISTUJAT.PHP SIVULLE

document.getElementById('select-all').addEventListener('click', function() {
  const checkboxes = document.querySelectorAll('.joukkueet-lista input[type="checkbox"]');
  checkboxes.forEach(checkbox => checkbox.checked = true);
});

document.getElementById('clear-all').addEventListener('click', function() {
  const checkboxes = document.querySelectorAll('.joukkueet-lista input[type="checkbox"]');
  checkboxes.forEach(checkbox => checkbox.checked = false);
});
