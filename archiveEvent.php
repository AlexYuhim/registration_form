<?php
include_once "apps/plugins/quiz/config.php";
global $db;

  $id= isset($_POST['id_event'])? $_POST['id_event']:null;
  $active_event= isset($_POST['active_event'])? $_POST['active_event']:null;
  $from_archive_event= isset($_POST['from_archive_event'])? $_POST['from_archive_event']:null;
  $title_event= isset($_POST['title_event'])? $_POST['title_event']:null;
  $discript_event= isset($_POST['discript_event'])? $_POST['discript_event']:null;
  



if($from_archive_event) $in_archive_event = 1;
// проверка чекбоксов
if($from_archive_event){
  $from_archive_event = false;
  checkArchivEvent($id, $from_archive_event);
} 

function checkArchivEvent($id, $in_archive_event){
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

// Вносим изменения в базу при редактировании
function editEvent($id, $title_event, $discript_event){
    $res = db_query("UPDATE `event` SET `title_event`='{$title_event}',`discript_event`=' {$discript_event}' WHERE `id`='{$id}'");  
    return $res;
}

//удалить мероприятие
function deleteEvent($id){
  $res = db_query(" DELETE FROM `event`  WHERE `id`='{$id}'");  
  return $res;
}
if(isset($_POST['id_delete_event'])){
  deleteEvent($_POST['id_delete_event']);
}

if($_POST){
  editEvent($id, $title_event, $discript_event);
}

function archiveEvent() {
  global $db;
  $result = []; 
  $res = db_query("SELECT * FROM `event` WHERE `archive_event`='1'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  
  return $result;
}
$result = archiveEvent();

?>
  <?require_once('head.php')?>
  <?require_once('header_nav.php')?>
  <h3 class="p-5 text-center">Архив мероприятий</h3>

<!-- Выводим все мероприятия -->
  <main class=" p-5 " >


  <div class="container-sm">
        <div class="row   ">
          <div class="col-1 overflow-auto border  ">№</div>
          <div class="col-1 overflow-auto   border">из архива</div>
          <div class="col   overflow-auto  border">Описание мероприятия</div>
          <div class="col   overflow-auto   border">Наименование мероприятия</div>
          <div class="col-1 overflow-auto   border">редактировать</div>
          <div class="col-1 overflow-auto   border">удалить</div>
        </div>
            <?php
            if($result){
              foreach($result as $number_event=>$event){
              
                $checked = '';
                if($event['active_event'] === '1'){
                  $checked = 'checked';
                }
                echo" 
                        <div class='row  table_event' text-center id='id_edit_event'>
                            <div class='col-1  overflow-auto  d-flex align-items-center  border'>{$event['id']}</div>
                            
                            
                            <div class='col-1  overflow-auto  d-flex align-items-center border'>
                            <form action='allEvent.php' method='post'>
                             <input  type='checkbox' name='from_archive_event' onchange='this.form.submit()'>
                             <input  type='hidden' name='id_event' value='{$event['id']}>
                             </form>  
                            </div>
                          
                            <div class='col overflow-auto  d-flex align-items-center border'>{$event['title_event']}</div>
                            <div class='col  overflow-auto  d-flex align-items-center border'>{$event['discript_event']}</div>
                            <div class='col-1  overflow-auto  d-flex align-items-center border'><!-- Кнопка-триггер модального окна -->
                            <button type='button' id='edit_event' class='edit_event btn btn-outline-dark w-100' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
                                +
                            </button></div>
                            <div class='col-1  overflow-auto  d-flex align-items-center border'>  <!-- Button trigger modal -->
                            <button id='delete_event' type='button' class='btn btn-outline-danger w-100 ' data-bs-toggle='modal' data-bs-target='#delet_event_modal'>
                             -
                            </button></div>
                        </div>
                      
                ";
              }
            }
            ?>
  </div>
  
  </main>

  <section class='section_modal'>
<!-- Модальное окно для редактирования мероприятия -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-scrollable modal-xl">
  <form action="archiveEvent.php" method='post'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Редактируемое мероприятие</h5>
        <button type="button" class="btn-close modal_close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
       Переместить мероприятия из архива
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Закрыть</button>
        <button id="delete_event" type="submit" class="btn btn-primary accept_changes">Принять изминения</button>
      </div>
    </div>
    </form>
  </div>
</div>


<!-- Modal для удаления мероприяия-->
<div class="modal fade" id="delet_event_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form action="archiveEvent.php" method='post'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Удаление</h5>
        <button type="button" class="btn-close modal_close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Да, Удалить!</button>
      </div>
    </div>
  </div>
    </form>
</div>


  </section>
  


  
      <script>
        //удаляем мероприятие 
        $('.table_event').click((evt)=>{
         if($(evt.target).attr("id")==='delete_event'){
          
         $parent_value_event = $(evt.currentTarget).find('td');
          console.log('$parent_value_event',$parent_value_event);
          
         $('.modal-body').append(`
            Мероприятие: ${$parent_value_event[1].innerText} - 
            будет удалено
             <input type='text' name='id_delete_event' size='1' class='border-0 visually-hidden' value=' ${$parent_value_event[0].innerText}'  >
         `)
         }
        })
         // получаем мероприятие при клике и помещаем в модалочку
        $('.table_event').click((evt)=>{
          // console.log('evt.target',evt.target);
          if($(evt.target).attr("id") === 'edit_event'){
              $parent_value_event = $(evt.currentTarget).find('div');
                  $('.modal-body').append(`
                     <div class="row   ">
                            <div class="col-1  border  ">№</div>
                            <div class="col overflow-auto border  ">Наименование мероприятия</div>
                            <div class="col overflow-auto border  ">Описание мероприятия</div>
                      </div>
                      <div class='row  table_event' text-center id='id_edit_event'>
                            <div class='col-1   d-flex align-items-center  border'><input type='text' name='id_event' size='1' class='border-0' value=' ${$parent_value_event[0].innerText}'> </div>
                          
                            <div class='col  overflow-auto  d-flex align-items-center border'><input type='text' name='title_event' value='${$parent_value_event[3].innerText}'></div>
                            <div class='col overflow-auto  d-flex align-items-center border'><textarea rows="5" cols="70" name="discript_event">${$parent_value_event[4].innerText}</textarea></div>
                      </div>
                  `)
              }
          })
// 
          $('.edit_event').click((evt)=>{
            setTimeout(() => {
              $('#input_active_event').prop('disabled',true)  
            }, 0);
            
          })
//  Обработка checkbox-ов при возращении мероприятия из архива
          $('.modal-body').click((evt)=>{
            if(($('#input_archive_event').prop('checked'))){
              setTimeout(() => {
              $('#input_active_event').prop('disabled',false)
            }, 0)
            }else{
              setTimeout(() => {
              $('#input_active_event').prop('disabled',true),
              $('#input_active_event').prop('checked',false)    
            }, 0);
            }
          })
// очистка модального окна при отмене редактирования
        $('.modal_close').click(()=>{
          $('.modal-body').text('');
        })
      </script>
   
</body>
                            
</html>