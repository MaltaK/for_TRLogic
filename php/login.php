<?php

/* Обрабатывает форму авторизации. */
require_once "db_connect.php";
/* Регулярное выражение для проверки содержимого полей логин и пароль  */
if (!preg_match("/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/", $_GET["username"])
 || preg_match("/\W/g", $_GET["password"])) {
    return 0;
}
else {
    $username = trim(htmlspecialchars($_GET["username"]));
    $password  = crypt($_GET["password"],"$1$saltpass$");
    
    $answer = [];
    $name = "";
    
    if (mysqli_num_rows($link->query("SELECT name FROM `Users` WHERE `username` = '$username' and `password` = '$password'")) != 0) {
        $result = $link->query("SELECT name, phone FROM `Users` WHERE `username` = '$username' and `password` = '$password'");
        $row = mysqli_fetch_array($result); 
        $answer = [$row['name'], $row['phone'], $username];
        /* Если была нажата кнопка "Запомнить меня", то создается токен и cookie с его значением */        
        if(isset($_GET["remember_me"])) {
            define('TOKEN', md5(uniqid(rand(9999,getrandmax()), TRUE)));
            setcookie("cookie_token", TOKEN, time() + (1000 * 60 * 60), '/');
            $s = TOKEN;
            $update_token = $link->query("UPDATE `Users` SET cookie_token='$s' WHERE `username` = '$username'");
            if(!$update_token){
                return 0;
            }
        }else{
            /* Если кнопка "Запомнить меня" не была нажата, то cookie удаляется */
            if(isset($_COOKIE["cookie_token"])) {
                $update_token = $link->query("UPDATE `Users` SET cookie_token = '' WHERE `username` = '$username'");
                setcookie("cookie_token", "", time() - 3600, '/');
            }
        }
        /* Осуществление входа на сайт (заполнения полей формы), если есть cookie */
    }  else if(isset($_COOKIE["cookie_token"]) && !empty($_COOKIE["cookie_token"])) {
        $s = $_COOKIE["cookie_token"];
        $result = $link->query("SELECT name, phone, username FROM `Users` WHERE cookie_token = '$s'");
        $row = mysqli_fetch_array($result); 
        if ($row["username"] == $username) {
            $answer = [$row['name'], $row['phone'], $username];
        }
        if(!isset($_GET["remember_me"])){
            setcookie("cookie_token", "", time() - 3600, '/');
        }
    }  
}

echo json_encode($answer);
        
?>
