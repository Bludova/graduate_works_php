﻿<?php
session_start();

//var_dump($_SESSION["user"]);
// $code = $_SESSION['user'];
//echo $code ;

// SELECT * FROM user LEFT JOIN task ON user.id=task.assigned_user_id WHERE task.user_id = 10
// SELECT * FROM user LEFT JOIN task ON user.id=task.assigned_user_id WHERE user.id = 10
// SELECT * FROM user LEFT JOIN task ON user.id=task.user_id WHERE user.id = 10
// SELECT * FROM user LEFT JOIN task ON user.id = 10 AND user.id=task.user_id;

// SELECT user.login, task.description, task.date_added, task.is_done FROM user LEFT JOIN task ON user.id=task.assigned_user_id WHERE task.user_id = 10
  include './config.php';
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Запросы SELECT, INSERT, UPDATE и DELETE</title>
    <style>
      table {
        border-spacing: 0;
        border-collapse: collapse;
      }

      table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
      }

      table th {
        background: #eee;
      }
    </style>
  </head>
  <body>
   <!--  <a href='./register.php'>Войдите на сайт</a> -->
    <?php
// подключение к db
      try {
        $pdo = new PDO(
        'mysql:host=localhost;dbname=global',
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
      catch (PDOException $e) {
        echo "Невозможно установить соединение с базой данных";
        exit();
      }


        // $sql3 = "SELECT login, id FROM user ";
        // $statement3 = $pdo->prepare($sql3);
        // $statement3->execute();
$userId = $_SESSION['id'];
// var_dump($userId);(int)
$userId = (integer)$userId;
// var_dump($userId);
        $sql2 = 'SELECT login, id FROM user';
        $statements = $pdo->prepare($sql2);
        $statements->execute();

        while ($rows = $statements->fetch(PDO::FETCH_ASSOC)) {
          $results[] = $rows;
        }

//SELECT * FROM task JOIN user WHERE user.id=task.assigned_user_id and user.id=task.user_id
//'SELECT login, id FROM task JOIN user ON user.id=task.assigned_user_id  WHERE user.id="'.$userId.'"';
        // $sql3 = 'SELECT login, id FROM user';
        // $statement3 = $pdo->prepare($sql3);
        // $statement3->execute();

        // while ($row3 = $statement3->fetch(PDO::FETCH_ASSOC)) {
        //   $result3[] = $row3;
        // }


       // var_dump($results);
       // var_dump($_SESSION["user"]);
        if($_SESSION["user"] === NULL){
          ?>
          <a href='./register.php'>Войдите на сайт</a>
          <?php
          exit();
        }
        $user = $_SESSION["user"];
        echo "<h1>Здравствуйте, $user! Вот ваш список дел:</h1>";
       //  foreach ($results as $keys => $values) {
       // //var_dump($values['login']);
       //   $loginUser[] = $values['login'];
       //  }
       // var_dump($loginUser);
            //         echo $loginUser;
            // foreach ($loginUser as $keyloginUser => $valueloginUser) {
            // $valueloginUser;  # code...
            // }
    ?>
    <form method="POST">
      <input type="text" name="description" placeholder="Описание задачи" value="">
      <input type="submit" name="save" value="Добавить">
    </form>

    <table>
      <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th>Изменить</th>
        <th>Ответственный</th>
        <th>Автор</th>
        <th>Закрепить задачу за пользователем</th>
      </tr>
      <?php

       // var_dump($value['login']);
         // var_dump($value['login']);
   $sql4='SELECT * FROM task JOIN user WHERE task.user_id="'.$userId.'" AND user.id=task.assigned_user_id';
          //SELECT * FROM task JOIN user WHERE task.user_id=10 AND user.id=task.assigned_user_id
//$assigned_user_id[] =intval($value['assigned_user_id']);
 // $assigned_user_id =  ($assigned_user_id);
// var_dump($assigned_user_id);
 $statement4 = $pdo->prepare($sql4);
        $statement4->execute();

        while ($row4 = $statement4->fetch(PDO::FETCH_ASSOC)) {
          $result4[] = $row4;
        }
//echo $result["assigned_user_id"];

        foreach ($result4 as $key4 => $value4) {
          $assigned_user_idLogin []= $value4['login'];
        }
       // echo $assigned_user_idLogin.'<hr>';
       // var_dump($assigned_user_idLogin);
//var_dump($assigned_user_idLogin);




 //вывод всех данных
      //SELECT * FROM task JOIN user ON user.login="log"
// SELECT * FROM `user` WHERE login ="log"
    //  "'. escape_str($_POST['email']) .'"
      //--------
      //$sql = 'SELECT * FROM task JOIN user ON user.id=task.user_id WHERE user.id="'.$userId.'"';
      //---------
$sql = 'SELECT * FROM task JOIN user WHERE task.user_id="'.$userId.'" AND user.id="'.$userId.'"';
      //SELECT * FROM task JOIN user ON user.id=task.assigned_user_id WHERE user.id=10
      //$sql = 'SELECT * FROM task JOIN user WHERE user.id="'.$userId.'" OR user.id=task.assigned_user_id  ';
       // $sql = 'SELECT * FROM task JOIN user  WHERE user.id="'.$userId.'"';// WHERE task.user_id=user.id";
     // $sql = 'SELECT * FROM task JOIN user ON user.logo= "'. $user .'" ';
     // $sql = "SELECT * FROM task JOIN user  WHERE user.logo=$user";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $result[] = $row;
        }
//echo $result["assigned_user_id"];

        foreach ($result as $key => $value) {
          $id = $value['id'];
          $id = intval($id);
          if($value['is_done'] == 0){
            $is_done = 'В процессе';
          } else{
            $is_done = 'Выполнено';
          }
 ?>
          <tr>
            <td><?=$value['description'];?></td>
            <td><?=$value['date_added'];?></td>
            <td><?=$is_done;?></td>
            <td><a href="?id=<?="$id";?>&action=done">Выполнить</a> <a href="?id=<?=$id;?>&action=delete">Удалить</a></td>
            <td><?php
            // while ( count($assigned_user_idLogin) <= 3) {
             //  echo '1';}
           //   }($assigned_user_idLogin as $keys => $valuesUser) {
           //  // echo $assigned_user_idLogin[0]
           //   //echo $valuesUser;
           //    //$value['login'];
           // }
          //echo $valuesUser;
             ?></td>
             <td><?=$value['login'];?></td>
             <td><form method='POST'>  <select name='assigned_user_id'>
       <?php
                foreach ($results as $keys => $values) {

                  ?>
        <option value="<?=$values['id'];?>"><?=$values['login'].$values['id'];?></option>
  <?php


}
//
//?assigned_user_id=user_5_task_423&assign=Переложить+ответственность
 ?>

             </select>  <input type='submit' name='assign' value='Переложить ответственность' /></form></td>
            <!-- <a href="?id=<?=$id;?>&action=edit">Изменить</a> -->
          </tr>

      <?php
   // var_dump($values['login']);
        }
    //  var_dump($_POST);
         // var_dump($log);

        if(count($_POST > 0)){
          $description = trim($_POST['description']);
          $description = htmlspecialchars($description);
          $is_done = 0;
          $is_done = intval($is_done);

          if($description != ''){
            $query = $pdo->prepare('INSERT INTO `task` (`id`,`user_id`,`assigned_user_id`, `description`, `is_done`, `date_added`) VALUES (NULL,"'.$userId.'", "'.$userId.'",?, ?, CURRENT_TIMESTAMP)');
            $params = [$description, $is_done];
            $query->execute($params);
            //header("Location: index.php");
            //exit();
          }
        }

        $idEdit = $_GET["id"];
        //$idEdit = trim($idEdit);
        $idEdit = intval($idEdit);
// Удалить
        if($_GET["action"] ==='delete'){
          $queryEdit = $pdo->prepare("DELETE FROM `task` WHERE `id` = ? ");
          $paramsEdit = [$idEdit];
          $queryEdit->execute($paramsEdit);
        }
// Выполнить
        if($_GET["action"] ==='done'){
          $queryEdit = $pdo->prepare("UPDATE `task`SET `is_done`='1' WHERE `id` = ?" );
          $paramsEdit = [$idEdit];
          $queryEdit->execute($paramsEdit);
        }

      ?>

    </table>

   <!--  <p><strong>Также, посмотрите, что от Вас требуют другие люди:</strong></p> -->


<!-- <table>
        <tr>
            <th>Описание задачи</th>
            <th>Дата добавления</th>

            <th>Статус</th>
            <th></th>
            <th>Ответственный</th>
            <th>Автор</th>
            </tr>
</table> -->
<p><a href="./logout.php">Выход</a></p>

  </body>
</html>

<?php

// array(8) { ["user_id"]=> string(2) "10" ["user_login"]=> string(5) "Tania" ["task_id"]=> string(1) "7" ["task_user_id"]=> string(1) "4" ["task_assigned_user_id"]=> string(2) "10" ["description"]=> string(5) "yyyyy" ["is_done"]=> string(1) "0" ["date_added"]=> string(19) "2017-11-09 02:51:57" }



// SELECT user.id AS user_id, user.login AS user_login, task.id AS task_id, task.user_id AS task_user_id, task.assigned_user_id AS task_assigned_user_id, task.description, task.is_done, task.date_added FROM user LEFT JOIN task ON user.id = task.assigned_user_id WHERE task.assigned_user_id= 10 AND task.user_id<>10

// SELECT user.id AS user_id, user.login AS user_login, task.id AS task_id, task.user_id AS task_user_id, task.assigned_user_id AS task_assigned_user_id, task.description, task.is_done, task.date_added FROM user LEFT JOIN task ON user.id=task.assigned_user_id WHERE task.assigned_user_id= 10
// task.assigned_user_id=10 WHERE task.assigned_user_id=10
