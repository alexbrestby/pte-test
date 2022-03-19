const cookies = document.cookie.split(";");
let userId = "";
cookies.forEach((elem) => {
  if (elem.trim().split("=")[0] === "id") {
    userId = elem.trim().split("=")[1];
    localStorage.setItem("id", userId);
  }
});

const swalert = async () => {
  await Swal.fire({
    imageUrl: "assets/img/images/pte_image.jpg",
    imageHeight: 500,
    input: "email",
    inputPlaceholder: "Введите Ваш e-mail",
    confirmButtonText: "Вперед",
    allowOutsideClick: false,
    inputValidator: (email) => {
      return !email && "Введите правильный email";
    },
    footer:
      '<a href="http://xpress.by/2016/06/15/pte-po-novomu-umnoe-reshenie-dlya-smartfonov/" target="_blank">Учить ПТЭ</a>',
  }).then((result) => {
    if (result.value) {
      var form = document.createElement("form");
      form.style.cssText = "display: none";
      form.action = "index.php";
      form.method = "POST";

      let input = document.createElement("input");
      input.name = "email";
      input.value = result.value;
      form.append(input);
      document.body.append(form);
    }
    if (result.isConfirmed) {
      form.submit();
    }
  });
};

if (
  localStorage.getItem("id") === null ||
  localStorage.getItem("id") === "" ||
  localStorage.getItem("id") !== userId
) {
  swalert();
}

$(document).on("input", function (ev) {
  if (!Swal.isVisible()) {
    // if ($("#search").val().slice($("#search").val().length - 1) ===  " ") {
    if ($("#search").val().length >= 4) {
      $.ajax({
        type: "POST",
        url: "search.php",
        data: { question: $("#search").val() },
        success: function (data) {
          $("#output").html(data);
        },
      });
    }
  }
});
