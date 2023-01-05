<?php
include_once "apps/plugins/quiz/config.php";
global $db;
$id=$_POST['id'];
$email=$_POST['email'];
$password=$_POST['password'];
$full_name=$_POST['full_name'];

if(isset($_POST['email'])){
  $res = db_query( "INSERT INTO `users` ( `email`, `password`, `full_name`) VALUES ( '$email', '$password', '$full_name')");  
  return $res;
}
require_once('head.php');
require_once('header_nav.php')?>

<h3 class=" mt-5 text-center"> Вход</h3>

      <form action="formAuthorization.php" method="post" class="mt-5   w-50 h-50 p-3 mx-auto" >
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Введите адрес элекронной почты</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Введите пароль</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
          </div>
          <!-- <div class="mb-3 form-check">
            <input type="checkbox" name="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
          </div> -->
          <button type="submit" class="btn btn-primary">Войти</button>
          <p class="mt-3"> Еще не зарегистрированны? <a href="formRegistration.html">Зарегистрироваться</a></p>
        </form>
      </div>
  </body>
</html>
