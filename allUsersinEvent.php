<?php
include_once "apps/plugins/quiz/config.php";
global $db;
$id_ivent='';

function allUsers() {
  $result = []; 
  $res = db_query("SELECT * FROM `users_in_event`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function getEvent($id){
  $result=''; 
  $res = db_query("SELECT `title_event` FROM `event` WHERE `id`='$id'");
  while ($row = $res->fetch_assoc()) $result = $row;
  return $result;
}



$users = allUsers();

?>
<?require_once('head.php')?>
<?require_once('header_nav.php')?>
<!-- начало адаптивной сетки -->
<section class="all_users">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h3 class="p-5">Все зарегистрированные</h3>
      </div>
    </div>
    <div class="row">
    <?php
      foreach($users as $number_event=>$event){

        $title_event= getEvent($event['id_event']);
        $title_event=$title_event?implode($title_event):'мероприятие видимо было удалено';
        // serialize($title_event);
        // var_dump($title_event);
        $title_event=$title_event?$title_event:'';
        ?>
   
      <div class="col-md-6 col-sm-12 border">
          <div class="full_name ">
            <p><?=$event['id']?></p>
            <p><?=$event['full_name']?></p>
            <p><?=$event['email']?></p>
            <p><?=$event['age']?></p>
            <p><?=$event['city']?></p>
            <p><?=$event['type_event']?></p>
            <p><?=$title_event?></p>
          </div>

      </div>  
   
    <?}?>
    </div>
  </div>
</section>



</body>
                            
</html>