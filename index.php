<?php
require_once 'log.php';
include 'layout/header.php';
?>

<div class="container">
  <div class="row">
    <div class="main">
      <div class="search-area">
        <input type="text" class="form-control" id="search" placeholder="Начните вводить текст вопроса...">
      </div>
      <div class=" answer d-flex flex-column justify-content-center"
      id="output">
      </div>
    </div>
  </div>
  <?php include 'layout/footer.php';?>
</div>


