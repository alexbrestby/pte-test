<?php
  require_once('log.php');
  include('layout/header.php');
?>

<div class="container">
  <div class="row">
    <div class="main">
      <input type="text" class="form-control" id="search" placeholder="Начните вводить текст вопроса...">
      <div class="mt-3 answer d-flex flex-column justify-content-center" id="output"></div>
    </div>
  </div>
  <?php include('layout/footer.php');?>
</div>


