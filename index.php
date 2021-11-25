<!DOCTYPE html>
<html lang="en">

<head>
  <title>Экзамен ПТЭ БЧ</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Экзамен, тест, ПТЭ, правила технической эксплуатации, Белорусская железная дорога, вагонник, путеец, локомотив">
  <meta name="description" content="Ваш помощник в изучении ПТЭ ЖД БЧ">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="sweetalert2.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php
  date_default_timezone_set('Europe/Minsk');

  function getIp() {
    $keys = [
      'HTTP_CLIENT_IP',
      'HTTP_X_FORWARDED_FOR',
      'REMOTE_ADDR',
    ];

    foreach ($keys as $key) {
      if(!empty($_SERVER[$key])) {
        $ip = trim(end(explode(',', $_SERVER[$key])));
        if(filter_var($ip, FILTER_VALIDATE_IP)) {
          return $ip;
        }
      }
    }
  }

  $ip = getIp();
  $info = file_get_contents('http://ip-api.com/json/' . $ip . '?lang=ru');
  $message = json_decode($info, TRUE);

  $file = 'log.txt';
  $data = "IP - " . $message["query"] . 
          "\r\nстрана - " .$message["country"] . 
          "\r\nгород - " . $message["city"] . 
          "\r\nпровайдер - "  . $message["isp"] .  
          "\r\n\r\n";

  // array(14) { ["status"]=> string(7) "success" ["country"]=> string(12) "Канада" ["countryCode"]=> string(2) "CA" ["region"]=> string(2) "QC" ["regionName"]=> string(6) "Quebec" ["city"]=> string(16) "Монреаль" ["zip"]=> string(3) "H3A" ["lat"]=> float(45.5063) ["lon"]=> float(-73.5794) ["timezone"]=> string(15) "America/Toronto" ["isp"]=> string(7) "OVH SAS" ["org"]=> string(17) "OVH Hosting, Inc." ["as"]=> string(15) "AS16276 OVH SAS" ["query"]=> string(15) "167.114.203.199" }

  file_put_contents($file, $data, FILE_APPEND);

  $token = "1995157538:AAGFeHeDBkuPC-ABz0qek7xqkcnua8mbwGM";
  $chatid = "317794726";
  $message = json_decode($info, true);
  // var_dump($message);
  $message = $message["status"];

  function sendMessage($chatID, $messaggio, $token) {

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);


    $result = file_get_contents($url);
    var_dump($result);
    return $result;
}

// sendMessage($chatid, $message, $token);

?>

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
      text: в `Уважаемые друзья, проект поддерживается за счет неравнодушных работников магистрали.`,
      footer: '<a href="http://xpress.by/2016/06/15/pte-po-novomu-umnoe-reshenie-dlya-smartfonov/" target="_blank">узнать что-то новое</a>'
    })
  </script>

</body>

</html>