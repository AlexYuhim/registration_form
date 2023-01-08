<?php
include_once "apps/plugins/quiz/config.php";
global $db;

  $id= isset($_POST['id_event'])? $_POST['id_event']:null;
  $active_event= isset($_POST['active_event'])? $_POST['active_event']:null;
  $from_archive_event= isset($_POST['from_archive_event'])? $_POST['from_archive_event']:null;
  $title_event= isset($_POST['title_event'])? $_POST['title_event']:null;
  $discript_event= isset($_POST['discript_event'])? $_POST['discript_event']:null;
  $action_botton= isset($_POST['action_botton'])? $_POST['action_botton']:null;



if($from_archive_event) $in_archive_event = 1;
// проверка чекбоксов
if($from_archive_event){
  $from_archive_event = false;
  checkArchivEvent($id, $from_archive_event);
} 

function checkArchivEvent($id, $from_archive_event){
  $res = db_query("UPDATE `event` SET `archive_event`='{$from_archive_event}' WHERE `id`='$id'");  
  return $res;
}

//---- Переназначение активного мероприятия -------

if($active_event) {
  $active_event = true;
  clearActivEvent();
  checkActivEvent($id, $active_event);
  }

function checkActivEvent($id, $active_event){

  $res = db_query("UPDATE `event` SET `active_event`='{$active_event}' WHERE `id`='$id'");  
  return $res;
}

function clearActivEvent(){
  $res = db_query("UPDATE `event` SET `active_event` = REPLACE(`active_event`, '1', '0');");  
  return $res;
}
//---- Переназначение активного мероприятия -------

// Вносим изменения в базу, редактирование данных
if($action_botton === "edit") {
  editEvent($id, $title_event, $discript_event);
}

function editEvent($id, $title_event, $discript_event){
  $res = db_query("UPDATE `event` SET `title_event`='{$title_event}',`discript_event`=' {$discript_event}' WHERE `id`='{$id}'");  
  return $res;
}

if($action_botton === "delete") {
  deleteEvent($id);
}

// удалить мероприятие
function deleteEvent($id){
  $res = db_query("DELETE FROM `event`  WHERE `id`='{$id}'");  
  return $res;
}

function archiveEvent() {
  $result = []; 
  $res = db_query("SELECT * FROM `event` WHERE `archive_event`='1'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  
  return $result;
}
$result = archiveEvent();

?>
  <?require_once('head.php')?>
  <?require_once('header_nav.php')?>

                 <!-- начало адаптивной сетки -->
                 <section class="all_event">
  <div class="container ">
    <div class="row">
      <div class="col-12 text-center">
      <h3 class="p-5">Архив мероприятий</h3>
      </div>
    </div>
    <div class="row text-center ">
      <?php
       $counter=1;
        if($result){
          foreach($result as $number_event=>$event){
            $checked = '';
            if($event['active_event'] === '1'){
              $checked = 'checked';
            }?>
               <!-- аккардион срат -->
        <div class="this_event  border p-4 ml-2 mt-4 col-md-6 col-sm-12">
          <div >Мероприятие № <span><?=$event['id']?> </span></div>
          <div class="event_id visually-hidden" ><span><?=$event['id']?> </span></div>
            <div class="accordion m-3" id="accordion<?=$event['id']?>">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="heading<?=$event['id']?>">
                    <button class="accordion-button collapsed modal_close" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$event['id']?>" aria-expanded="true" aria-controls="collapse<?=$event['id']?>">
                    <?=$event['title_event']?>
                    </button>
                  </h2>
                  <div id="collapse<?=$event['id']?>" class="accordion-collapse collapse " aria-labelledby="heading<?=$event['id']?>" data-bs-parent="#accordion<?=$event['id']?>">
                    <div class="accordion-body"><?=$event['discript_event']?></div>
                  </div>
                </div>
          </div>
          <!-- аккардион финиш -->
          <!-- чекбоксы старт -->
          <div class="p-3 d-flex  flex-column justify-content-center align-items-start">
            <form  action='archiveEvent.php' method='post'>
                <label class=''>
                  <input id="input_archive_event" type='radio' name='active_event' onchange='this.form.submit()' <?=$checked?>>
                  <input  type='hidden' name='id_event' value="<?=$event['id']?>"  onchange='this.form.submit()'>
                  Сделать мероприятие активным
                  </label>
                </form>   
                <form action='archiveEvent.php' method='post'>
                  <label>
                    <input  type='checkbox' name='from_archive_event' onchange='this.form.submit()'>
                    <input  type='hidden' name='id_event' value="<?=$event['id']?>" onchange='this.form.submit()'>
                    Перемесить из архива
                  </label>
                </form>   
          </div>
          <!-- чекбоксы финишь -->
          <!-- кнопки редактирования старт -->
              <div class="d-sm-flex justify-content-sm-around">
                <div class="d-flex">
                  <button type='button'id="edit_event" class='action_event btn' data-bs-toggle='modal'    data-bs-target='#staticBackdrop'>
                      <svg class=" bi bi-trash" width="32" height="32" fill="">
                      <use xlink:href="svg/bootstrap-icons.svg#pencil-square"/>
                    </svg> 
                      Редактировать
                    </button>
                </div> 
                <div class="d-flex"> 
                    <button type='button' id="delete_event" class='action_event btn ' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
                    <svg class=" bi bi-trash" width="32" height="32" fill="">
                      <use xlink:href="svg/bootstrap-icons.svg#bucket"/>
                    </svg> 
                      Удалить
                    </button> 
                  </div>
              </div>
          <!-- кнопки редактирования финиш -->
        </div>
      <?}?><!-- конец цикла -->
    </div>
  </div>
  </section> <!-- конец адаптивной сетки -->
  <?}?><!-- конец условия if -->
  </div>
  </main>

<section class='section_modal'>

<!-- Модальное окно для редактирования мероприятия -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-scrollable modal-xl">
      <form action="archiveEvent.php" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Редактируемое мероприяие</h5>
            <button type="button" class="btn-close modal_close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
          </div>
          <div class="modal-body">
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-primary accept_changes">Принять изминения</button>
          </div>
        </div>
        </form>
      </div>
    </div>

</section>
  
      <script>
      
        $('.this_event').click((evt)=>{
    console.log('evt.target.class',evt.target);
    $event_name = $(evt.currentTarget).find('.accordion-button')[0].innerText;
        $event_discription = $(evt.currentTarget).find('.accordion-body')[0].innerText;
        $event_id = $(evt.currentTarget).find('.event_id')[0].innerText;
      
        console.log('evt.currentTarget',$event_name);
        console.log('evt.currentTarget',$event_discription);
        console.log('evt.currentTarget',$event_id);
        $action="";
        $text_modal_body="";
    // Если кликнули на кнопку редактировать:
          if(evt.target.id === 'edit_event'){
            $action="edit";
            $text_modal_body= 'Следующее мероприятие будет изминено'
          }
    // Если кликнули на кнопку удалить
          if(evt.target.id === 'delete_event'){
            $action="delete";
            $text_modal_body= 'Следующее мероприятие будет удалено'
          }
            if(evt.target.id === 'edit_event' || evt.target.id === 'delete_event'){
          
            $('.modal-body').append(`
                <h3 class='text-center'>${$text_modal_body}</h3>
                <div class="container ">
                  <div class="row border mt-2">
                    <div class="col-12 text-center">
                    <input  type='hidden' name='id_event' value="${$event_id}">
                    <input  type='hidden' name='action_botton' value="${$action}">
                      <h4 class="mb-4 ">Наименование мероприятия</h4>
                      <div class='mb-2'><input type='text' name='title_event' value='${$event_name}'></div>
                    </div>
                  </div>
                  <div class="row text-center border mt-2">
                  <div class="col-12 text-center">
                      <h4 class="mb-4 ">Описание мероприятия</h4>
                      <div class=' overflow-auto border'><textarea  class="form-control" rows="5" name="discript_event">${$event_discription}</textarea></div>
                  </div>
                    </div>
                  
              </div>
                
            `)
          }
    })

  $('.modal_close').click(()=>{
    $('.modal-body').text('');
  })
      </script>
   
</body>
                            
</html>