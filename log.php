<?php
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
          "\r\nвход выполнен: " . date("Y-m-d H:i:s") .
          "\r\n\r\n";

  // array(14) { ["status"]=> string(7) "success" ["country"]=> string(12) "Канада" ["countryCode"]=> string(2) "CA" ["region"]=> string(2) "QC" ["regionName"]=> string(6) "Quebec" ["city"]=> string(16) "Монреаль" ["zip"]=> string(3) "H3A" ["lat"]=> float(45.5063) ["lon"]=> float(-73.5794) ["timezone"]=> string(15) "America/Toronto" ["isp"]=> string(7) "OVH SAS" ["org"]=> string(17) "OVH Hosting, Inc." ["as"]=> string(15) "AS16276 OVH SAS" ["query"]=> string(15) "167.114.203.199" }

  // file_put_contents($file, $data, FILE_APPEND);


  $token = "1995157538:AAGFeHeDBkuPC-ABz0qek7xqkcnua8mbwGM";
  $chatid = "317794726";

  function sendMessage($chatID, $messaggio, $token) {

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);


    $result = file_get_contents($url);
    // var_dump($result);
    return $result;
}

// sendMessage($chatid, "На сайт выполнен вход!\r\n" . $data, $token);