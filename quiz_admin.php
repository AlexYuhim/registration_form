<?php
header("Cache-Control:no-store, must-revalidate");

include_once "config.php";

// получаем количество ответов
function checkLimits($id) {
    global $db;
    $id = $db->real_escape_string($id);
    $result = [];
    $res = db_query("SELECT COUNT(`id_list`) AS count_id FROM questionnaire_data WHERE `id_list`='$id'");
    while ($row = $res->fetch_assoc()) $result = $row['count_id'];
    return $result;
    
}

function idQuestionnaire_data($id) {
  global $db;
  // $id = $db->real_escape_array($id);
  $result = [];
  $res = db_query("SELECT `id` FROM questionnaire_data WHERE `date`='$id'");
  
  while ($row = $res->fetch_assoc())$result[$row['id']] = $row['id'];
    return $result;

  
}



// получаем анкету
function getQuestionnaire() {
    $result = [];
    $res = db_query("SELECT q.id, q.name, q.header, q.comment,
      ql.id AS ql_id, ql.id_blank, ql.name AS ql_name, ql.type, ql.sort, ql.limits, ql.required
      FROM questionnaire AS q
      INNER JOIN questionnaire_list ql ON ql.id_blank = q.id
      WHERE 1 ORDER BY ql.sort");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
}

// получаем ответы из текстовых полей
function getIdTextField($id, $group=false) {
  global $db;
  $id = $db->real_escape_string($id);
  $result = []; 
  $result2 = [];
  $values = [];
  $res = db_query("SELECT `id`, `id_blank`, `name` FROM questionnaire_list WHERE `id_blank` = '$id' AND `type` = 'in' ORDER BY `id`");
    
  while ($row = $res->fetch_assoc()) $result[$row['id']] = $row['name'];

  

  if ($group) {
   $res3 = db_query("SELECT `id`, `id_blank`, `name` FROM questionnaire_list WHERE `id_blank` = '$id' AND `type` = 'ch' ORDER BY `id`");
  while ($row = $res3->fetch_assoc()) $result2[$row['id']] = $row['name'];
  }  

  if (count($result) > 0) {
    foreach ($result as $key => $value) {
      if ($group) {
        $res2 = db_query("SELECT  qd.id_list, qd.value, qd.date FROM questionnaire_data AS qd WHERE qd.id_list = '$key'");
        while ($row = $res2->fetch_assoc()) $values[$row['date']][$value] = $row['value'];

      } else {
        $res2 = db_query("SELECT `id`, `id_list`, `value`, `date`  FROM questionnaire_data WHERE `id_list` = '$key'");
        while ($row = $res2->fetch_assoc()) $values[] = [  $row['id_list'], $row['value'], $row['date'], $value, $row['id']];
      }      
    }
  }



  if ($group) {
    if (count($result2) > 0) {
      foreach ($result2 as $key => $value) {
        $res4 = db_query("SELECT qd.id, qd.id_list, qd.value, qd.date FROM questionnaire_data AS qd WHERE qd.id_list = '$key'");
        while ($row = $res4->fetch_assoc()) $values[$row['date']][$value] = $row['value'];
       
      }
       
    }
  }
  return $values;
}

$questionnaire = getQuestionnaire();
$questionnaire_name = $questionnaire[0]['name'];
$questionnaire_id = $questionnaire[0]['id'];
$header_text = $questionnaire[0]['header'];
$comment = $questionnaire[0]['comment'];
$value_text = getIdTextField($questionnaire_id);
$value_group = getIdTextField($questionnaire_id, true);
$id
?>
   


<!DOCTYPE html>
<html>
  <head>
    <title>Опрос админ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--<link href="extensions/bootstrap_5.1.3/bootstrap.min.css" rel="stylesheet">
    <script src="extensions/bootstrap_5.1.3/bootstrap.bundle.min.js"></script>
    <script src="extensions/jquery_3.6.0/jquery.min.js"></script>-->
  </head>
  <body>
  <form action="quiz_ajax.php" class="was-validated" method="get">
    <div class="container-sm" style="max-width: 500px;">
      <div class="row" style="font-size: 1.3em; margin: 25px 15px;">
        <h1 class="mb-3 text-center"><?php echo $questionnaire_name; ?></h1>
        <h3>По списку</h3>

        <table class='table border'> 
        <?php foreach ($questionnaire as $key => $value):
          $point = $value['ql_name'];
          $limits = $value['limits'];
          $value['limits'] ? $limits = $value['limits'] : $limits = '';
          $total = checkLimits($value['ql_id']);
     
        

      

          if ($point === 'Ваши фамилия и имя') {
           $point = 'Всего';
          }
          if ($point === 'ЕДА' || $point === 'СЛУЖЕНИЕ'  ) {
            echo" <thead>
                    <tr class='table-info'>
                        <th scope='col'>{$point}</th>
                        <th scope='col'>чел</th>
                        <th scope='col'>из</th>
                    </tr>
                  </thead>";
          } else {
            echo " <tbody> 
                        <tr>
                           <td scope ='row' >{$point}:</td>
                           <td>{$total}</td>
                           <td class='last'>{$limits}</td>
                        </tr>
                     </tbody>
                          ";
          }         
            endforeach; 
        ?>
      </table>
 
      <table class='table border' id='table-who-what'>            
        <?php
          $prev_field = '';
          foreach ($value_text as $key => $value):
                        
          $field = $value[3];
          $value_text = $value[1];
            if ($prev_field !== $field && $field !== 'Ваши фамилия и имя') {
              echo  "<thead>
                      <tr class='table-info'>
                        <th class='mw-50'>{$field}</th>
                      </tr>
                    </thead>";
          }
          if ($field !== 'Ваши фамилия и имя') {
              echo "<tbody> 
                      <tr>
                        <td scope ='row'>{$value_text}</td>
                        
                      </tr>
                   </tbody>";
          }          
          $prev_field = $field;
          endforeach;

          echo"<thead >
                <tr class='table-info'>
                  <th>Кто? Что?</th>
                </tr>
              </thead>";


          
          
           foreach ($value_group as $key => $value) {
            
            echo "<tbody> 
                      <tr class='table-warning'>
                        <td scope ='row'>{$value['Ваши фамилия и имя']}:</td>
                      </tr>
                  </tbody>";
             
            foreach ($value as $key2 => $value2) {
             
              if ($key2 !== 'Ваши фамилия и имя') {
                
             
                
                echo "<tbody> 

                        <tr  class='text-break table-date'>
                        
                          <td  class=''
                          style='display: flex; 
                          justify-content: 
                          space-between; 
                          align-items: center;' 
                          scope ='row' > $key2 : $value2  <p  class='visually-hidden'>$key</p>  
                          <!--<button  type='button' class='btn-close delete_field'></button>-->
                          
                          </td>
                          
                        </tr>
                        
                     </tbody>";
                  
            
              

              }              
            }
          }   
        ?>
         </table>        
      </div>

      <div style="display: flex; justify-content: space-around; align-items: center;">
        <!-- <button type='button' class='btn btn-primary mb-4'data-bs-toggle="modal" data-bs-target="#exampleModal">Редактировать</button> -->
        <button type='button' class='btn btn-primary mb-4'id='updateDate'>Обновить данные</button>

        <button  type="button" class="btn btn-danger mb-4" name="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
         Очистить форму
        </button>
      </div>
    </div>


      <!-- Modal Редактировать-->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
              <table class='table border'>            
              <?php
                foreach ($value_group as $key => $value) {
                  echo"<thead >
                        <tr class='table-info'>
                          <th>Кто? Что?</th>
                        </tr>
                      </thead>";
                  echo "<tbody> 
                            <tr class='table-warning'>
                              <td scope ='row'>{$value['Ваши фамилия и имя']}:</td>
                            </tr>
                        </tbody>";
                  
                  foreach ($value as $key2 => $value2) {
                    if ($key2 !== 'Ваши фамилия и имя') {
                      echo "<tbody> 
                                <tr class='text-break'>
                                  <td scope ='row'>
                                    <form metod='POST'action='#'>
                                    <input type='text' name='value_input' style='width: 300px;' value=' $key2 - $value2'>
                                    
                                    </form> 
                                  </td>
                                </tr>
                                
                            </tbody>";
                    }
                  }
                   echo "<tbody> 
                      <tr>
                        <td><button type='submit' class='btn btn-primary'>Изминить</button></td>
                      </tr>
                  </tbody>";
                }   
              ?>
              </table>     
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
          </div>
        </div>
      </div>

     
        <!-- Modal Очистить форму-->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">УДАЛЕНИЕ ДАННЫХ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Удалить содержимое формы? 

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">НЕТ</button>
                <button id="clear_data" type="button" class="btn btn-primary">ДА</button>
              </div>
            </div>
          </div>
        </div>
        </form>
</body>
<?php
$forIdBlank='';

?>

<script>
    
  $("#clear_data").click(function (evt) {
    if (evt) {
      fetch("quiz_ajax.php?type=delete")
      .then(response => response.text())
      .then(commits => {
		  location.reload();
        /*if (commits) {			
          
        }*/
      });
    }
  });

  $('#updateDate').click((evt)=>{
    if(evt)location.reload()
  })
  
  // $(".delete_field").click(function (evt) {
  //   const getParentButton = $(evt.currentTarget).parent();
  //   const getText = getParentButton[0].innerText;
  //    $forIdBlank = getText.split(':').splice(0,1).join('');
  //   const forDate = getText.split('\n\n').splice(-1).join('').trim();
     
  //   // console.log('botton',$forIdBlank);
  //   // console.log('botton',forDate);
    
  //   if (evt) {
  //     fetch(`quiz_ajax.php?type=delete&date=${forDate}`).then(
  //       response => response.text())
  //     .then(commits => {
  //       console.log('forDate',forDate);
        
	// 	  // location.reload();
  //       /*if (commits) {			
          
  //       }*/
  //     });
  //        }
  //     });
  </script>
 

  <style>
  .grey_text {
    font-size: 14px;
    color: gray;
    display: block;
  }
    </style>
</html>
