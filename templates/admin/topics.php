<?php
require_once '../../framework/vendor/autoload.php';

// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem(__DIR__);

// Где будут хранится файлы кэша (php файлы)
 $twig = new Twig_Environment($loader);


$template = $twig->loadTemplate('topics.html');
//соединение с базой
include '../../includes/db.php';
//подключение к базе
try {

// Удаляем тему
  if (isset($_GET["act"]) and $_GET["act"] === "remove_topic" ) {

 if($_GET["id_categorie"] == ''){
        $errors[] = 'Вы не выбрали тему!';
    }
     if( empty($errors) ) {
             //Добавить вопрос
     $sql = " DELETE FROM `diploma`.`categories` WHERE `categories`.`id` = '".$_GET["id_categorie"]."';
     DELETE FROM `diploma`.`question` WHERE `question`.`categories_id` = '".$_GET["id_categorie"]."'; ";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $send = 'Тема и все вопросы были удалины!';
     } else {

       $send = $errors['0'];
       //Вывести ошибку на экран

     }
}





  //Создать новую тему
if (isset($_POST["create_topics"])) {

 if($_POST["new_topics"] == ''){
        $errors[] = 'Вы не ввели название темы!';
    }
     if( empty($errors) ) {
             //Добавить вопрос
      $sql = " INSERT INTO `diploma`.`categories` (`id`, `categorie`) VALUES (NULL, '".$_POST["new_topics"]."');";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $send = 'Новый тема '.$_POST["new_topics"] .' была успешно создана !';
     } else {

       $send = $errors['0'];
       //Вывести ошибку на экран

     }
}



 $sql = "SELECT categories.categorie, categories.id AS categories_id, question.question, question.id AS question_id, answer.answer, question.status FROM categories LEFT JOIN question ON question.categories_id = categories.id LEFT JOIN answer ON answer.id = question.id_answer ORDER BY categories.id ";

        $statement = $pdo->prepare($sql);
        $statement->execute();

 $categories = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $categories[] = $row;
        }

  // закрываем соединение
  unset($pdo);

} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}



$question = [];
$categorie =[];
$unanswered = [];
$published_questions = [];
foreach ($categories as $key => $info) {

   $categorie[$info['categories_id']]['categorie'] =  $info['categorie'];

if($info["question"] ===  NULL) {
  $question[$info['categories_id']]['categorie'] = [];
} else {
  $question[$info['categories_id']]['categorie'] [$info["question_id"]] =  $info["question"];
}

if($info["status"] !== '1' ){
  $published_questions[$info['categories_id']]['categorie'] = [];

} else {
  $published_questions[$info['categories_id']]['categorie'][$info["question_id"]]  =  $info["status"];

}
if($info["status"] === '0' ){
  $unanswered[$info['categories_id']]['categorie'][$info["question_id"]]  =  $info["status"];
} else {
  $unanswered[$info['categories_id']]['categorie'] = [];
}

 }


$unanswered_question = [];
foreach ($unanswered as $key => $infoUnanswered) {

  $unanswered_question[$key] = count($infoUnanswered["categorie"]);
}


$published_question = [];
foreach ($published_questions as $key => $infoQuestions) {

 $published_question[$key] = count($infoQuestions["categorie"]);
}


$questions_total = [];
foreach ($question as $key => $infoQuestion) {
$questions_total[$key] = count($infoQuestion["categorie"]);
}

$cat = $_GET["cat"];
$title ="Название страницы";
echo $template->render(array(
    'categorie' => $categorie,
    'categories' => $categories,
    'admins' => $admins,
    'cat' => $cat,
    'send' => $send,
    'questions_total' => $questions_total,
    'published_question' => $published_question,
    'unanswered_question' => $unanswered_question
    ));
