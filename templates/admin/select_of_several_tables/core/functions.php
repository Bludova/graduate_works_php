<?php
session_start();
define('FILE_DATA_USERS', __DIR__ . '/../data/users.json');
/**
 * Реализует механизм авторизации
 * @param $login
 * @param $password
 * @return bool
 */
function login($login, $password)
{
    $user = getUser($login);
    if ($user !== null && $user['password'] == getHash($password)) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}
/**
 * Получает список пользователей
 * @return array|mixed
 */
function getUsers()
{
    $usersData = file_get_contents(FILE_DATA_USERS);
    $users = json_decode($usersData, true);
    if (!$users) {
        return [];
    }
    return $users;
}
function getUser($login)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['login'] == $login) {
            return $user;
        }
    }
    return null;
}
function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function getParam($name)
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
}
function getCurrentUser()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}
function redirect($action)
{
    header('Location: ' . $action . '.php');
    die;
}
function logout()
{
    session_destroy();
    redirect('index');
}
function getHash($password)
{
    return md5($password);
}
?>