<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="/library/bootstrap/css/bootstrap.min.css" >
    <!-- Bootstrap JS + Popper JS -->
  <title>Подтверждение регистрации</title>
</head>
<body class="d-flex h-50   text-secondary bg-info">
<div class="mt-5 mb-5 container d-flex flex-column justify-content-center align-items-center  rounded" >
  <h2>
    <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']);
        ?>
      </h2>
  <a href="registration_form_for_event.php">вернуться на страницу регистрации</a>
</div>
</body>
</html>