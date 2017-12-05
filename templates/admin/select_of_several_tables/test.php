<?php
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
    <a href='./register.php'>Войдите на сайт</a>
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
 //вывод всех данных
//SELECT task.description, task.id, task.is_done, task.date_added, user.login FROM task JOIN user ON task.user_id=user.id OR user.login=task.user_id
     // SELECT task.description, task.is_done, task.date_added, user.login, FROM task JOIN user ON task.user_id=user.id
    //  id user_id assigned_user_id description is_done date_added id login password
       //$sql = "SELECT * FROM task";
     //  $sql = " SELECT * FROM user INNER JOIN task ON user.id = task.id";
        //SELECT * FROM user LEFT OUTER JOIN task ON user.id = task.id
       // $sql = "SELECT * FROM task JOIN user ON task.user_id=user.id";
        $sql = "SELECT * FROM task JOIN user ON task.user_id=user.id";//OR task.assigned_user_id=user.id
        //SELECT * FROM task JOIN user ON task.user_id=user.id OR task.assigned_user_id=user.id GROUP BY task.id, user.id
        $statement = $pdo->prepare($sql);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $result[] = $row;
        }




        foreach ($result as $key => $value) {
          $id = $value['id'];
          $id = intval($id);
          //array(8) { ["id"]=> string(1) "2" ["user_id"]=> string(1) "2" ["assigned_user_id"]=> string(1) "1" ["description"]=> string(1) "s" ["is_done"]=> string(1) "0" ["date_added"]=> string(19) "2017-11-30 00:00:00" ["login"]=> string(3) "log" ["password"]=> string(32) "202cb962ac59075b964b07152d234b70" }
//var_dump($value);
// foreach ($value as $keys => $values){
//   echo '<br>';
// }
          if($value['is_done'] == 0){
            $is_done = 'В процессе';
          } else{
            $is_done = 'Выполнено';
          }
           //echo count($value['login']);
         // $value['assigned_user_id']=["user_id"] =["login"]

            //
            $logins = $value['login'];       //foreach ($login as $keyLogin => $logins) {
            $log[] = $logins;
            //    // echo $logins;
            //   // }




      ?>

          <tr>
            <td><?=$value['description'];?></td>
            <td><?=$value['date_added'];?></td>
            <td><?=$is_done;?></td>
            <td><a href="?id=<?="$id";?>&action=done">Выполнить</a> <a href="?id=<?=$id;?>&action=delete">Удалить</a></td>
             <td><?=$value['login'];?></td>
             <td><?=$value['login'];?></td>
             <td><form method='POST'>  <select name='assigned_user_id'>
              <option value='user_5_task_423'><?=$value['login'];?> </option>

             </select>  <input type='submit' name='assign' value='Переложить ответственность' /></form></td>
            <!-- <a href="?id=<?=$id;?>&action=edit">Изменить</a> -->
          </tr>

      <?php

        }
          var_dump($log);

        if(count($_POST > 0)){
          $description = trim($_POST['description']);
          $description = htmlspecialchars($description);
          $is_done = 0;
          $is_done = intval($is_done);

          if($description != ''){
            $query = $pdo->prepare("INSERT INTO `task` (`id`,`user_id`,`assigned_user_id`, `description`, `is_done`, `date_added`) VALUES (NULL, 1, NULL,?, ?, CURRENT_TIMESTAMP)");
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

    <p><strong>Также, посмотрите, что от Вас требуют другие люди:</strong></p>


<table>
        <tr>
            <th>Описание задачи</th>
            <th>Дата добавления</th>

            <th>Статус</th>
            <th></th>
            <th>Ответственный</th>
            <th>Автор</th>
            </tr>
</table>
<p><a href="./logout.php">Выход</a></p>

  </body>
</html>


------------------------------------------------

<?php
// session_start();
//SELECT book.name, book.year,book.isbn, book_autor.name as `autor` FROM book JOIN book_author ON book_author.id=book.author_id

// SELECT task.id, task.user_id, task.assigned_user_id, task.description, user.id as `autor` FROM task JOIN user ON task.user_id=user.id

// SELECT task.id, task.user_id, task.assigned_user_id, task.description, user.id as `autor` FROM task JOIN user ON task.user_id=user.id
// SELECT * FROM task JOIN user ON task.user_id=user.id
// SELECT * FROM task JOIN user ON task.user_id=user.id
 // $_SESSION['user'] = $user;
 //  $_SESSION['password'] = $password;
// require_once __DIR__ . '/core/functions.php';
// $currentUser = getCurrentUser();
// if (!$currentUser && !$_POST['guest']) {
//     redirect('login');
// }
 //header("Location: ./list.php",TRUE,302);
// подключение к db
  include './config.php';

      try {
        $pdo = new PDO(
        "mysql:host=$host;dbname=$db",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
      catch (PDOException $e) {
        echo "Невозможно установить соединение с базой данных";
        exit();
      }

//регистрация
      if(@$_POST["register"]) {

      if(empty($_POST['login']))
      $err[] = 'Не введен Логин';

  if(empty($_POST['password']))
    $err[] = 'Не введен Пароль';
  if(count($err) > 0)
    echo $err[0].'<br>';

        if(count($err) === 0){
          $password = trim($_POST["password"]);
          $login = trim($_POST["login"]);
            $login = htmlspecialchars($login);
            $password = htmlspecialchars($password);
            $password = md5($password);
            $query = $pdo->prepare("INSERT INTO `user` (`id`, `login`, `password`) VALUES (NULL, ?, ?)");
            $params = [$login, $password];
             $query->execute($params);
            // $query->execute($params);
            $_SESSION['user'] = $login;
  // $_SESSION['password'] = $password;
          //  header("Location: ./index.php");
            // header("Location: ./index.php",TRUE,302);
            // exit();
         }//else {
        //  echo 'Введите логин и пароль для регистрации!';
        // }
}
// Вход

if(@$_POST["sign_in"]){
  if($_POST["password"] != '' and $_POST["login"] != ''){
    $password = trim($_POST["password"]);
          $login = trim($_POST["login"]);
            $login = htmlspecialchars($login);
            $password = htmlspecialchars($password);
            $password = md5($password);
            $query = $pdo->prepare("SELECT * FROM `user` WHERE login = ? AND password = ?");
            //AND `password` = ?
            //  $sql2 = "SELECT * FROM `books` WHERE `isbn` LIKE  ? AND `name` LIKE ? AND `author` LIKE ? ";
            // $query = $pdo->prepare("INSERT INTO `user` (`id`, `login`, `password`) VALUES (NULL, ?, ?)");
           $params = [$login, $password];
            $query->execute($params);
           //var_dump($query);
            // echo "привет $login";
            // echo "привет $password";
// $row = mysql_fetch_assoc($res);

            //Вы можете использовать (PDO::FETCH_ASSOC)постоянное
//использование будет
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $userId = $row['id'];
// while ($row = $query->fetch(PDO::FETCH_ASSOC)){
// //....
// $testLog = $row['login'];
// }
// if(md5(md5($_POST['password']).$row['salt']) == $row['password'])
//      {
              //$count = exec($query);
//echo $testLog;
              //var_dump($row['login']);
  if ($row !== false){
                $_SESSION['user'] = $login;
                 $_SESSION['id'] = $userId;
             header("Location: index.php",TRUE,302);
            exit();


    // header("Location: index.php");
            // exit();
    //echo "Привет $login";
  }else {
    echo "Не правельный логин или пароль!";
    // echo "<pre>";
    // print_r($pdo->errorInfo());
    // echo "</pre>";
      }
    }
  }

      //var_dump($_POST["sign_in"]);
      //array(3) { ["login"]=> string(3) "dbf" ["password"]=> string(3) "bdf" ["sign_in"]=> string(8) "Вход" }
      //array(3) { ["login"]=> string(3) "ggg" ["password"]=> string(3) "ggg" ["register"]=> string(22) "Регистрация" }
   // if(count($_POST > 0)){
   //        $description = trim($_POST['description']);
   //        $description = htmlspecialchars($description);
   //        $is_done = 0;
   //        $is_done = intval($is_done);

   //        if($description != ''){
   //          $query = $pdo->prepare("INSERT INTO `tasks` (`id`, `description`, `is_done`, `date_added`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP)");
   //          $params = [$description, $is_done];
   //          $query->execute($params);
   //          //header("Location: index.php");
   //          //exit();
   //        }
   //      }
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
  </head>
  <body>
    <p>Введите данные для регистрации или войдите, если уже регистрировались:</p>

<form method="POST">
    <input type="text" name="login" placeholder="Логин">
    <input type="password" name="password" placeholder="Пароль">
    <input type="submit" name="sign_in" value="Вход">
    <input type="submit" name="register" value="Регистрация">
</form>
