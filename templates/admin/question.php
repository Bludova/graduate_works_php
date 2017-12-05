<?php
require_once '../../framework/vendor/autoload.php';

// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem(__DIR__);

// Где будут хранится файлы кэша (php файлы)
 $twig = new Twig_Environment($loader);


$template = $twig->loadTemplate('question.html');
//соединение с базой
include '../../includes/db.php';
//подключение к базе
try {

if (isset($_GET["id_categorie"])) {


$sql = "SELECT categories.categorie, categories.id AS categories_id, question.question, question.id AS question_id, question.data, answer.answer, question.status FROM categories LEFT JOIN question ON question.categories_id = categories.id
 LEFT JOIN answer ON answer.id = question.id_answer WHERE categories.id = '".$_GET["id_categorie"]."' ORDER BY categories.id";


        $statement = $pdo->prepare($sql);
        $statement->execute();

 $categories = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $categories[] = $row;
        }
}
  // закрываем соединение
  unset($pdo);

} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}


if (isset($_GET["categorie"])) {
 $chooseCategorie = $_GET["categorie"];
}

$cat = $_GET["cat"];
$title ="Название страницы";
echo $template->render(array(
    'chooseCategorie' =>  $chooseCategorie,
    'categorie' => $categorie,
    'categories' => $categories,
    'admins' => $admins,
    'cat' => $cat,
    'send' => $send,
    'questions_total' => $questions_total,
    'published_question' => $published_question,
    'unanswered_question' => $unanswered_question
    ));


