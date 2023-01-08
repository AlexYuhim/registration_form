<?php
include_once "apps/plugins/quiz/config.php";

global $db;
$id=isset($_POST['id'])?$_POST['id']:null;
$email=isset($_POST['email'])?$_POST['email']:null;
$full_name=isset($_POST['full_name'])?$_POST['full_name']:null;


function addUser($email, $password, $full_name){
  $res = db_query( "INSERT INTO `users` ( `email`, `password`, `full_name`) VALUES ( '$email', '$password', '$full_name')");  
  return $res;
}



function getEmai($email){
  $result=[];
  global $db;
  $email = $db->real_escape_string($email);
  $res = db_query( "SELECT `email` FROM `users` WHERE `users`.`email` = '$email'");  
  while ($row = $res->fetch_assoc()) $result[] = $row['date'];
  return count($result);
}



if($email && $_GET['type']){
  //проверка пароля
  
if(strlen($_POST['password'])< 5)
{
    $errmsg='слищком короткий пароль';
} 
else
    {
      $password= MD5($_POST['password']);
       if(getEmai($email)){
        $errmsg='Данный электронный адрес уже зарегистрирован.';
          }else{
            $_SESSION['email']=$_POST['email'];
            addUser($email, $password, $full_name);
            $okmsg='Поздравляем вы успешно зарегистрировались! <a href="formRegistration.php"> Перейти на главную!! </a>';
            // header('Location:/formRegistration.php');
          }
       }
}
?>
<?
if(isset($_GET['exit'])==1)
    {
      unset($_SESSION['email']);
    }
?>
<?require_once('head.php')?>
<?require_once('header_nav.php')?>

<h3 class=" mt-5 text-center">Регистрация</h3>

        <form action="formRegistration.php?type=reg" method="post" class="mt-5   w-50 h-50 p-3 mx-auto" >
          <div class="mb-3">
        
            <?
              if(isset($errmsg))
              {
                ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                <span class='alert-danger'><?=$errmsg?></span>
                </div>
                <?
              }
              if(isset($okmsg))
              {
                ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                <span><?=$okmsg?></span>
                </div>
                <?
              }
            ?>
              
           
            <label for="exampleInputEmail1" class="form-label">Введите Ваши ФИО</label>
            <input type="text" name="full_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Введите адрес электронной почты</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Введите пароль</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" name="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
          </div>
          <button type="submit" class="btn btn-primary">Войти</button>

          <p class="mt-3"> Уже зарегистрированны? <a href="formAuthorization.html">Авторизируйтесь</a></p>
        </form>

      </div>


    
  </body>
</html>
