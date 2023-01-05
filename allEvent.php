<?php
include_once "apps/plugins/quiz/config.php";
// var_dump($_POST);

global $db;
 
  $id= isset($_POST['id_event'])? $_POST['id_event']:null;
  $active_event= isset($_POST['active_event'])? $_POST['active_event']:null;
  $in_archive_event= isset($_POST['in_archive_event'])? $_POST['in_archive_event']:null;
  $title_event= isset($_POST['title_event'])? $_POST['title_event']:null;
  $discript_event= isset($_POST['discript_event'])? $_POST['discript_event']:null;
  


  //  Помещаем мероприятие в архив 
if($in_archive_event){
  $in_archive_event = true;
  checkArchivEvent($id, $in_archive_event);
} 

function checkArchivEvent($id, $in_archive_event){
  $res = db_query("UPDATE `event` SET `archive_event`='{$in_archive_event}' WHERE `id`='$id'");  
  return $res;
}

// Переназначение активного мероприятия 

if($active_event) {
  var_dump($_POST);
  $active_event = true;
  clearActivEvent();
  checkActivEvent($id, $active_event);
  }

function clearActivEvent(){
    $res = db_query("UPDATE `event` SET `active_event` = REPLACE(`active_event`, '1', '0');");  
    return $res;
  }

function checkActivEvent($id, $active_event){

  $res = db_query("UPDATE `event` SET `active_event`='{$active_event}' WHERE `id`='$id'");  
  return $res;
  }



// Вносим изменения в базу
function editEvent($id, $title_event, $discript_event){
    $res = db_query("UPDATE `event` SET `title_event`='{$title_event}',`discript_event`=' {$discript_event}' WHERE `id`='{$id}'");  
    return $res;
}

if($title_event && $discript_event) editEvent($id, $title_event, $discript_event);

// выводим все не архивные мероприятия
function allEvent() {
  global $db;
  $res = db_query("SELECT * FROM `event` WHERE `archive_event`='0'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  
  return $result;
}

  $result = allEvent();

?>
  <?require_once('head.php')?>
   <?require_once('header_nav.php')?> 
   <main class=" p-5  mx-auto" >
   <h3 class="p-5 ">Все мероприятия</h3>
  
   <div class="container-sm">
        <div class="row   ">
          <div class="col-1 overflow-auto border  ">№</div>
          <div class="col-1 overflow-auto   border">active</div>
          <div class="col-1 overflow-auto   border"> в архив</div>
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
                             <input  type='radio' name='active_event' onchange='this.form.submit()' $checked>
                             <input  type='hidden' name='id_event' value='{$event['id']}'  onchange='this.form.submit()'>
                             </form>  
                            </div>
                            <div class='col-1  overflow-auto  d-flex align-items-center border'>
                            <form action='allEvent.php' method='post'>
                             <input  type='checkbox' name='in_archive_event' onchange='this.form.submit()'>
                             <input  type='hidden' name='id_event' value='{$event['id']}'  onchange='this.form.submit()'>
                             </form>  
                            </div>
                          
                            <div class='col overflow-auto  d-flex align-items-center border'>{$event['title_event']}</div>
                            <div class='col  overflow-auto  d-flex align-items-center border'>{$event['discript_event']}</div>
                            <div class='col-1  overflow-auto  d-flex align-items-center border'><!-- Кнопка-триггер модального окна -->
                            <button type='button'class='edit_event btn btn-outline-dark w-100' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
                                +
                            </button></div>
                            <div class='col-1  overflow-auto  d-flex align-items-center border'><!-- Кнопка-триггер модального окна -->
                            <button type='button'class='delete_event btn btn-outline-dark w-100' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
                                +
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
  <form action="allEvent.php" method='post'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Редактируемое мероприяие</h5>
        <button type="button" class="btn-close modal_close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      

      <div class="modal-body">
        Следующее мероприятие будет изминено...
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
                  // получаем мероприятие при клике 
        $('.table_event').click((evt)=>{
          if(evt.target.type === 'button'){
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

        $('.modal_close').click(()=>{
          $('.modal-body').text('');
        })

        $('#archive_event').change((evt)=>{

        });
        
      </script>
</body>
</html>