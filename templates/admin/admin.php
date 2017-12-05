<?php
require_once '../../framework/vendor/autoload.php';

// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem(__DIR__);

// Где будут хранится файлы кэша (php файлы)
 $twig = new Twig_Environment($loader);


$template = $twig->loadTemplate('index.html');
//соединение с базой
include '../../includes/db.php';
//подключение к базе


try {
  // формируем SELECT запрос

//изменить пароль администратора
if (isset($_POST["save_password"])) {
    if($_POST["password"] == ''){
        $errors[] = 'Вы не ввели пароль!';
    }

     if( empty($errors) ) {
             //Добавить вопрос
         $sql = "UPDATE `diploma`.`admin` SET `password` = '".$_POST["password"]."' WHERE `admin`.`id` = '".$_POST["id"]."'";
         $statement = $pdo->prepare($sql);
         $statement->execute();
        $send = 'Пароль успешно изменен!';
     } else {

       $send = $errors['0'];
       //Вывести ошибку на экран

     }
}

//удалить администратора
if (isset($_POST["remove_admin"])) {
  //запрос на удаление  администратора
    $sql = "DELETE FROM `diploma`.`admin` WHERE `admin`.`id` = '".$_POST["id"]."'";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $send = 'Администратор '.$_POST["login"].' удалён!';
}


//Создать нового администратора
if (isset($_POST["create_admin"])) {

 if($_POST["login"] == ''){
        $errors[] = 'Вы не ввели логин!';
    }
    if($_POST["password"] == ''){
        $errors[] = 'Вы не ввели пароль!';
    }
     if( empty($errors) ) {
             //Добавить вопрос

      $sql = "INSERT INTO `diploma`.`admin` (`id`, `login`, `password`) VALUES (NULL, '".$_POST["login"]."', '".$_POST["password"]."')";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $send = 'Новый администратор был успешно создан !';
     } else {

       $send = $errors['0'];
       //Вывести ошибку на экран

     }
}

   $sql = "SELECT * FROM `admin`";
        $statement = $pdo->prepare($sql);
        $statement->execute();
$admins = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $admins[] = $row;
        }


  // закрываем соединение
  unset($pdo);

} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}


$cat = $_GET["cat"];
$title ="Название страницы";
echo $template->render(array(
    'title' => $title,
    'admins' => $admins,
    'cat' => $cat,
    'send' => $send
    ));
