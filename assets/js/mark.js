const search = document.getElementById("search");

search.addEventListener("input", (event) => {
  const searchText = event.target.value;
  const regex = new RegExp(searchText, "gi");

  function mark() {
    let box = document.querySelectorAll(".quest");
    box.forEach((element) => {
      element.innerHTML.replace(/(<mark class="highlight">|<\/mark>)/gim, "");
      element.innerHTML = element.innerHTML.replace(
        regex,
        '<mark class="highlight">$&</mark>'
      );
    });
  }
  setTimeout(mark, 500);
});
