<?php
include_once 'config.php';


// удаляем данные
function delete_data($date='') {
  global $db;
  if($date){
    $id = $db->real_escape_string($date);
    $res = db_query( "DELETE FROM questionnaire_data WHERE `questionnaire_data`.`date`= $date");  
    return $res;
  }
    $res = db_query("DELETE FROM questionnaire_data");
    return $res;  
}

print_r($_REQUEST);

  if ($_GET['type']==='delete'){
    if($_GET['date']){
      echo'HI!!!';
        delete_data($_GET['date']);
      } else{
        delete_data();
      }
  exit();
  }

  
var_dump($_GET);
function delete_field($data) {
    global $db;
    $id = $db->real_escape_string($data);
    $res = db_query( "DELETE FROM questionnaire_data WHERE `questionnaire_data`.`date`= $data");  
    return $res;
    
}

  // if ($_GET['type']==='delete'){
    
  // delete_field($_GET['date']);
  // exit();
  // }


  // Обновления строки
function updateData($id, $value) {  
  global $db;
  $id = $db->real_escape_string($id);
  $value = $db->real_escape_string($value);
  $res = db_query("UPDATE questionnaire_data SET value='{$value}' WHERE id='{$id}'");  
  return $res;
}

// if ($_GET['type'] === 'update') {
//   updateData($_GET['id'], $_GET['value']);
//   exit();
// }
 ?>


