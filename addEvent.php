<?php
include_once "apps/plugins/quiz/config.php";
  global $db;
 
  $title_event=isset($_POST['title_event'])?$_POST['title_event']:null;
  $discript_event=isset($_POST['discript_event'])?$_POST['discript_event']:null;
  $archive_event=isset($_POST['archive_event'])?$_POST['archive_event']:null;
  $active_event=isset($_POST['active_event'])?$_POST['active_event']:null;


  
 function addNewEvent($title_event,$discript_event,$archive_event,$active_event){
  $res = db_query(" INSERT INTO `event` (`title_event`, `discript_event`,`archive_event`,`active_event`) VALUES ('$title_event','$discript_event','$archive_event','$active_event')");
  $_SESSION['message_add'] = 'добавленно новое мероприятие!';
  return$res;
 } 

 if($_POST && $_GET['add']){
   addNewEvent($title_event,$discript_event,$archive_event,$active_event);
   header('Location:/addEvent.php');
 }

?>

 <?require_once('head.php')?>
  <?require_once('header_nav.php')?>
  <h3 class=" p-5 text-center">Добавить мероприятие</h3>

<div class="cover-container  w-100 h-100 p-3 mx-auto ">

  <div class="h3 mt-5 text-secondary text-center" id="message">
    <?php
     echo isset($_SESSION['message_add']);
     unset( $_SESSION['message_add']);

    ?>
 
  </div>
  
      
<form action="addEvent.php?add=1" method="post" id="form-event" class="mt-5  p-5">
    <div class="container-sm rounded  " style="max-width: 900px;">
      <div  style="font-size: 1em; margin: 25px 15px;">
           <div class="title position-relative  row ">   
             
            <div class="border rounded border-light mt-2">   
                
                <div class="form-floating w-auto  mt-3 ">
                  <input type="text" class="form-control" name="title_event" id="title_event" placeholder="фио" required>
                  <label class="form-label" for="title_event">Наименованеи мероприятия </label>
                </div>
               
                <div class=" w-100 mb-3  mt-3 ">
                <label for="discript_event" class="mb-2 mt-3 p-2">Описание мероприятия</label>
                  <textarea style="min-height: 100px;" type="textaera" class="form-control" id="discript_event" name="discript_event" required></textarea>
                </div>

                <div class="mb-3 d-flex justify-content-around">
                   <button class="btn btn-primary" id="add_event" type="submit">Добавить</button>
                    <button class=" btn btn-transparent border" id="reset_form" type="button">Очистить форму</button>
                    <input type="text" name="archive_event" value="0" class="visually-hidden">
                    <input type="text" name="active_event" value="0" class="visually-hidden">
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


  //     setTimeout(() => {
  //   $('#message').toggleClass('visually-hidden');
  //  }, 2500);
  
  
  
     
 
  </script>

  </body>
</html>
