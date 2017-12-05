<?php
require_once '../../framework/vendor/autoload.php';
//require_once '../../framework/vendor/twig/twig/lib/Twig/Autoloader.php';
//require_once 'users/index.html';
//Twig_Autoloader::register();

// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem(__DIR__);

// Где будут хранится файлы кэша (php файлы)
 $twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('index.html');

//соединение с базой
include '../../includes/db.php';

try {
    //categories
   $sql = "SELECT categorie , id FROM `categories` ";
        $statement = $pdo->prepare($sql);
        $statement->execute();
 $allCategories = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $allCategories[] = $row;
        }

//categories AND question
$sql = "SELECT  categories.categorie, categories.id AS categories_id,question.question, answer.answer, question.status  FROM categories JOIN question ON categories.id = question.categories_id JOIN answer ON answer.id_question = question.id ";

        $statement = $pdo->prepare($sql);
        $statement->execute();
 $question = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $question[] = $row;
        }


          if( isset($_POST["send"]) )
          {
            $errors = array();
            if($_POST['nickname'] == '')
            {
              $errors[] = 'Введите Nickname!';
            }

            if($_POST['email'] == '')
            {
              $errors[] = 'Введите Email!';
            }


            if($_POST["question"] == '')
            {
              $errors[] = 'Вы не задали вопрос!';
            }

           if( empty($errors) )
           {
             //Добавить вопрос

        $sql = "INSERT INTO `diploma`.`question` (`id`, `question`, `data`, `status`, `categories_id`, `nickname`, `email`) VALUES (NULL, '".$_POST["question"]."', '2017-11-30 00:00:00', '0', '".$_POST["categorie"]."', '".$_POST['nickname']."', '".$_POST['email']."')";
        $statement = $pdo->prepare($sql);
        $statement->execute();
          $send = 'Вопрос успешно отправлен!';

           }else
           {

            $send = $errors['0'];
             //Вывести ошибку на экран

           }
          }

$cat = $_GET["cat"];

 $categorie =[];
foreach ($question as $key => $info) {
   $categorie[$info['categories_id']]['categorie'] =  $info['categorie'];

 }
echo $template->render(array(
    'allCategories' => $allCategories,
    'question' => $question,
    'send' => $send,
    'cat' => $cat,
    'categorie' => $categorie
    ));


  unset($pdo);

} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
