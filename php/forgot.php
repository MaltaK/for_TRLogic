<?php

/* Обрабатывает запрос восстановления пароля */

require_once "db_connect.php";
  
if (!preg_match("/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/", $_GET["username"])) {
    return 0;
}
else {  
    $username = trim(htmlspecialchars($_GET["username"]));
    /* Функция генерации пароля */
    function generatePassword($length){
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
    $answer = 30;
    define('PASSWORD', generatePassword(8));
    $s = crypt(PASSWORD,"$1$saltpass$");
    if (mysqli_num_rows($result = $link->query("SELECT name, username FROM `Users` WHERE `username` = '$username'")) != 0) {
    
        $result = $link->query("UPDATE `Users` SET password = '$s' WHERE `username` = '$username'");
        $row = mysqli_fetch_array($result);
        if ($result) {
            $answer = 31;
            /* Отправка письма с новым паролем на почту пользователя */
            $to = $username; 
            $from = 'mariakolobaeva0369@gmail.com'; 
            $subject = "Восстановление пароля"; 
            $message = "Здравствуйте, ".$row['name']."<br>Это письмо для восстановления пароля с сайта: http://de-san.com/RES/index.php <br>Ваш новый пароль: ".PASSWORD;
            $headers = "Content-type: text/html; charset=UTF-8 \r\n";
            $headers .= "From: <mariakolobaeva0369@gmail.com>\r\n";
            mail('mariakolobaeva0369@gmail.com', $subject, $message, $headers); /*$row['username'];*/
        } else {
            return 0;
        }    
    } 
}
echo $answer;
?>