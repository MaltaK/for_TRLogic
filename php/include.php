<?php
/* При наличии coockie находит в базе данных пользователя по токену и создает сессию с его логином и паролем для заполнения полей формы*/
require_once "db_connect.php";

if(isset($_COOKIE["cookie_token"]) && !empty($_COOKIE["cookie_token"])) {
    $s = $_COOKIE["cookie_token"];
    $result = $link->query("SELECT username, password FROM `Users` WHERE cookie_token = '$s'");
    if(!$result){
        return 0;
    }else{
        $row = mysqli_fetch_array($result); 
        session_start();
        $_SESSION['username'] = $row["username"];
        $_SESSION['password'] = $row["password"];
    } 
}
?>