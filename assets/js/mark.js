const $box = document.querySelector(".box");
const $search = document.getElementById("search");

$search.addEventListener("input", (event) => {
  const searchText = event.target.value;
  const regex = new RegExp(searchText, "gi");
  function mark() {
    let text = $box.innerHTML;
    text = text.replace(/(<mark class="highlight">|<\/mark>)/gim, "");

    const newText = text.replace(regex, '<mark class="highlight">$&</mark>');
    if (searchText.length >= 5) {
      $box.innerHTML = newText;
    }
  }
  setTimeout(mark, 1000);
});
