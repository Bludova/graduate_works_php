<?php
 include 'config.php';

//mysql:dbname=$db;charset=utf8;host=$host", $user, $password
 try {
        $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
      catch (PDOException $e) {
        echo "Невозможно установить соединение с базой данных";
        exit();
      }


// $connection = mysqli_connect(
//       $config['db']['server'],
//       $config['db']['username'],
//       $config['db']['passwotd'],
//       $config['db']['name']

// );

// if( $connection == false)
// {
//     echo 'Нет подключения к базе данных! <br>';
//     echo mysqli_connect_error();
//     exit();

// }
