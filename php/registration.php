 <?php
/* Обрабатывает форму регистрации пользователя */
require_once "db_connect.php";
/* Регулярное выражение для проверки содержимого полей логин, имя, пароль и телефон*/
if (!preg_match("/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/", $_GET["username"]) 
|| preg_match("/[^a-zA-Zа-яА-Я]/g", $_GET["name"]) || preg_match("/\W/g", $_GET["password"]) || preg_match("/[^0-9\-\+\(\)]/", $_GET["phone"])) {
    return 0;
} else {
    $name  = ucfirst($_GET["name"]);
    $username = trim(htmlspecialchars($_GET["username"]));
    $password  = crypt($_GET["password"],"$1$saltpass$");
    $phone  = $_GET["phone"];
    $answer = 20;
    /* Если пользователь с введенной почтой не зарегистрирован, то в базу данных вводятся данные о новом пользователе */        
    if (mysqli_num_rows($link->query("SELECT name FROM `Users` WHERE `username` = '$username'")) == 0) {
        $result = $link->query("INSERT INTO `Users` (name, username, phone, password) VALUES ('".$name."', '".$username."', '".$phone."', '".$password."')");
        if ($result) {
            $answer = 21;
        }
        if(isset($_COOKIE["cookie_token"]) && !empty($_COOKIE["cookie_token"])) {
            setcookie("cookie_token", "", time() - 3600, '/');
        }
    }   
}     
echo $answer;
?>