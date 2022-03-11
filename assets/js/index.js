const cookies = document.cookie.split(";");
let userId = "";
cookies.forEach((elem) => {
  if (elem.trim().split("=")[0] === "id") {
    userId = elem.trim().split("=")[1];
  }
});

if (
  localStorage.getItem("id") === null ||
  localStorage.getItem("id") !== userId
) {
  localStorage.setItem("id", userId);
  Swal.fire({
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
  });
}

$(document).on("input", function (ev) {
  if (!Swal.isVisible()) {
    $.ajax({
      type: "POST",
      url: "search.php",
      data: {
        question: $("#search").val(),
      },
      success: function (data) {
        $("#output").html(data);
      },
    });
  }
});
