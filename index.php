<!DOCTYPE html>
<html lang="en">

<head>
  <title>Live Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="sweetalert2.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="jumbotron text-center">
        <h1>Помощник настоящего железнодорожника</h1>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="search" placeholder="Начните вводить текст вопроса...">
        <div class="mt-3 answer d-flex flex-column justify-content-center" id="output"></div>
      </div>
      <div class="col-sm-3">
      </div>
    </div>
  </div>

  <script type="text/javascript">
    // $(document).ready(function(){
    //   $("#search").keypress(function(){
    $(document).on("input", function (ev) {
      // console.log($(ev.target).val());
      // $("#search").keyup(function () {
      //   if ($(this).val() == '«') {
      //     return '"';
      //   } 
      //   console.log($(this).val());
      // });

      $.ajax({
        type: 'POST',
        url: 'search.php',
        data: {
          name: $("#search").val(),
        },
        success: function (data) {
          $("#output").html(data);
        }
      });
    });
  </script>

  <script>
    Swal.fire({
      icon: 'warning',
      confirmButtonText: 'Вперед',
      text: `Уважаемый друг! 
          Вы используете данный сервис на свой страх и риск. Любые претезии - только к себе. 
          Если все равно хотите продолжить - жмите кнопку...`,
      footer: '<a href="http://xpress.by/2016/06/15/pte-po-novomu-umnoe-reshenie-dlya-smartfonov/" target="_blank">узнать что-то новое</a>'
    })
  </script>

</body>

</html>