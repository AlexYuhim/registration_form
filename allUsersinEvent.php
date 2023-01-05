<?php

// var_dump($_POST);

include_once "apps/plugins/quiz/config.php";
global $db;
$id_ivent='';

function allUsers() {
  global $db;
  $result = []; 
  $res = db_query("SELECT * FROM `users_in_event`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function getEvent($id){
  $res = db_query("SELECT `title_event` FROM `event` WHERE `id`='$id'");
  while ($row = $res->fetch_assoc()) $result = $row;
  return $result;
}



$users = allUsers();

?>
<?require_once('head.php')?>
<?require_once('header_nav.php')?>
<h3 class=" p-5 text-center">Все зарегистрированные</h3>
<!-- Выводим все мероприятия -->
  <main class=" p-5 " >
    <table class="table table-bordered border-dark">
    
      <thead>
        <tr>
          <th scope='col'>№</th>
          <th scope='col'>ФИО</th>
          <th scope='col'>Почта</th>
          <th scope='col'>Возраст</th>
          <th scope='col'>Город</th>
          <th scope='col'>Тип участия</th>
          <th scope='col'>Мероприятие</th>
        </tr>
      </thead>
    <?php
      foreach($users as $number_event=>$event){
      
        $title_event= getEvent($event['id_event']);
    
        
        echo"
              <tbody class='table_event'>
                  <tr scope='row' id='id_edit_event'>
                    <td >{$event['id']} </td>
                    <td>{$event['full_name']}</td>
                    <td>{$event['email']}</td>
                    <td>{$event['age']}</td>
                    <td>{$event['city']}</td>
                    <td>{$event['type_event']}</td>
                    <td>{$title_event['title_event']}</td>
                  </tr>
              </tbody> 
        ";
      }
    ?>
    </table>
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
          console.log('evt.target',evt.target);
          if(evt.target.type === 'button'){
              $parent_value_event = $(evt.currentTarget).find('td');
                  $('.modal-body').append(`
                  <table class="table table-bordered border-dark">
                      <thead>
                        <tr>
                          <th scope='col'>№</th>
                          <th scope='col'>назначить мероприятие активным</th>
                          <th scope='col'>переместить мероприятие в архив</th>
                          <th scope='col'>Наименование мероприятия</th>
                          <th scope='col'>Описание мероприятия</th>
                        </tr>
                      </thead>
                      <tbody class='table_event'>
                        <tr  scope='row' id='id_edit_event'>
                        <td> <input type='text' name='id_event' size='1' class='border-0' value=' ${$parent_value_event[0].innerText}'  ></td>
                        <td class='text-center'> <input type='checkbox' size='1' name='active_event'></td>
                        <td class='text-center'> <input type='checkbox' size='1' name='in_archive_event'></td>
                        <td> <input type='text' name='title_event' value='${$parent_value_event[2].innerText}'></td>
                        <td> <textarea rows="5" cols="70" name="discript_event">${$parent_value_event[3].innerText}</textarea>
                        </td>
                        </tr>
                      </tbody> 
                  </table> 
                  `)
              }
          })

        $('.modal_close').click(()=>{
          $('.modal-body').text('');
        })
      </script>
   
</body>
                            
</html>