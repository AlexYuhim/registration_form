<?php
include_once "apps/plugins/quiz/config.php";
global $db;

  $id = isset($_POST['id'])? isset($_POST['id']):null;
  $full_name = isset($_POST['full_name'])? isset($_POST['full_name']):null;
  $email = isset($_POST['email'])? isset($_POST['email']):null;
  $age = isset($_POST['age'])? isset($_POST['age']):null;
  $city = isset($_POST['city'])? isset($_POST['city']):null;
  $type_event = isset($_POST['type_event'])? isset($_POST['type_event']):null;
  $id_event = isset($_POST['id_event'])? isset($_POST['id_event']):null;
 
  

// проверка на повторную регистрацию 

if($email){
  if(!getEmai($email)){
    $email = $db->real_escape_string($email);
    $res = db_query("INSERT INTO `users_in_event` (`id`, `full_name`, `email`, `age`, `city`, `type_event`,`id_event`) VALUES ('$id','$full_name', '$email', '$age', '$city', '$type_event','$id_event')");  
    
    $_SESSION['message']='Вы успешно зарегистрировались. Подробную информацию мы вышлем Вам на почту :' .$email;
    header('Location: ../../../reg_result.php');
  }else{
    $_SESSION['message']='Проверте Вашу электронную почту! </br> Электронный адрес '.$email.' уже зарегистрирован!';
    header('Location: ../../../reg_result.php');
  }
}

function getEmai($email){
  $result=[];
  global $db;
  $email = $db->real_escape_string($email);
  $res = db_query( "SELECT `email` FROM `users_in_event` WHERE `users_in_event`.`email` = '$email'");  
  while ($row = $res->fetch_assoc()) $result[] = $row['date'];
  return count($result);
}

function getEvent() {
  global $db;
  // $id = $db->real_escape_string($id);
  $res = db_query("SELECT `title_event`, `discript_event`,`id` FROM `event` WHERE `active_event`= '1'");
  while ($row = $res->fetch_assoc()) $result = $row;
  return $result;
}

$table_event = getEvent();


?>
<?require_once('head.php')?>
<?require_once('header_nav.php')?>
<h3 class="float-md-center text-center mt-5 ">Форма регистрации</h3>
<div class="container" style="min-width: 410px; max-width: 700px; ">
<form action="registration_form_for_event.php" method="post" id="form-event" class="mt-5  p-5 ">
      <div  style="font-size: 1em; margin: 25px 15px;">
          <div class="title position-relative  row ">   
             <!-- Шапка -->
              <div class=" bg-white rounded-bottom">

                  <div class="position-absolute bg-primary rounded-top" 
                  style=" 
                  height: 10px;
                  top: -10px;
                  left: 0;
                  width: 100%;
                " >
                </div>
                <div class="vrapper-title " >
                    <div class="title_event h2 p-2 text-left "> <?=$table_event["title_event"]?></div>
                    <div class="event h4 p-3 pb-2" ><?=$table_event["discript_event"]?></div>
                    <div class="event h4 p-3 pb-2" >Заполните, пожалуйста, форму, представленную ниже.</div>
                </div>
            </div>

            <div class="border rounded border-light mt-5">   
                
                <div class="form-floating w-auto  mt-5 ">
                  <input type="text" class="form-control" name="full_name" id="id_name" placeholder="фио" required>
                  <label class="form-label" for="id_name">Фамилия и Имя </label>
                </div>
                <div class="form-floating w-100  mt-3 ">
                  <input type="email" class="form-control" id="id_email" name="email" placeholder="info@gmail.com" required >
                  <label for="id_email">Электронная почта</label>
                                        
                </div>
                
                <div class="form-floating w-100  mt-3 ">
                  <input type="text" class="form-control" name="age" id="id_age" placeholder="age">
                  
                  <label class="form-label" for="id_age">Возраст </label>
                </div>
                <div class="form-floating w-100  mt-3  ">
                  <input type="text" class="form-control" id="id_city" name="city" placeholder="city" required >
                  <label for="id_city">Местность (город)</label>
                </div>

                <div class="form-floating p-3 w-100 ml-3 mt-3 mb-5 bg-white rounded ">
                    <div class="mb-3">В собраниях обучения планирую участвовать:</div>

                    <div class="form-check">
                      <label class="form-check-label">
                       Утром, очно
                       <input class="form-check-input" type="radio" name="type_event" value="уторм очно" checked required>
                      </label>
                    </div>

                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio"name="type_event"     value="вечером в зум"  required>
                        Вечером, в (ZOOM)
                      </label>
                    </div>
                </div>
                <div class="mb-5 d-flex justify-content-around">
                    <button class="btn btn-primary" id="send_form" type="submit">Отправить форму</button>
                    <button class=" btn btn-transparent border" id="reset_form" type="button">Очистить форму</button>
                    <input type="text" class="visually-hidden" name="id_event" value='<?=$table_event["id"]?>' >
                </div>
         </div>
    </div>
  </form>        
</div> 

<script>
  // Очистить форму
  $('#reset_form').click((evt)=>{
    evt.preventDefault();
     $('#form-event').trigger('reset');
  })

  
</script>
  
</html>
