<?php 
require_once "php/db_connect.php";
include "php/include.php";

if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    $session_username=$_SESSION["username"];
    $session_password=$_SESSION["password"];
}
?> 
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>пример</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/style.css" type="text/css" rel="stylesheet" />  
    <link href="css/formhack.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript">
        function newValue() {
            document.getElementById('username_log').value = "<?php echo $session_username;?>";
            document.getElementById('password_log').value = "<?php echo $session_password;?>";
        }
        window.onload = newValue;
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="frame col-12 col-md-8 col-lg-4">
            <div class="nav">
                <ul class="links">
                    <li class="signin-active"><a class="btn">ВХОД</a></li>
                    <li class="signup-inactive"><a class="btn">РЕГИСТРАЦИЯ</a></li>
                </ul>
            </div>
            <div>
                <form class="form-signin" id="login" name="form">
                    <label for="username_log">
                        <span class="lab">EMAIL</span>
                        <input class="form-styling" type="text" name="username" id="username_log" value="" "maxlength="50" minlength="6" required  autocomplete="off">
                        <ul class="input-requirements">
                            <li>Укажите Ваш действительный адрес электронной почты</li>
                        </ul>
                    </label>
                    <label for="password_log">
                        <span class="lab">ПАРОЛЬ</span>
                        <input class="form-styling" name="password" type="password" id="password_log" value="" maxlength="12" minlength="8" required>
                        <ul class="input-requirements">
                        <li>Количество символов от 8 до 12</li>
                            <li>Должен содержать только латинские буквы и цифры</li>
                        </ul>
                    </label>
                    <input type="checkbox" id="remember_me" name="remember_me"/>
                    <label for="remember_me" >
                        <span class="ui"></span>ЗАПОМНИТЬ МЕНЯ
                    </label>
                    <div class="btn-animate btnn">
                        <button type="submit" class="btnn btn-signin">ВОЙТИ</button>
                    </div>

                    <div class="pad">
                        <div id="answer_signin"></div>
                        <div class="forgot">
                            Забыли пароль?
                        </div>
                    </div>
                </form>
                <form class="form-signup" id="registration" name="form">
                    <label for="name_reg">
                        <span class="lab">ИМЯ</span>
                        <input class="form-styling" type="text" name="name" id="name_reg" maxlength="20" minlength="2" required  autocomplete="off"/>
                        <ul class="input-requirements">
                            <li>Может содержать только буквы</li>
                        </ul>  
                    </label>
                    <label for="username_reg">
                        <span class="lab">EMAIL</span>
                        <input class="form-styling" type="email" name="username" id="username_reg" maxlength="50" minlength="6" required  autocomplete="off"/>
                        <ul class="input-requirements">
                            <li>Укажите Ваш действительный адрес электронной почты</li>
                        </ul>           
                    </label>
                    <label for="phone_reg">
                        <span class="lab">ТЕЛЕФОН</span>
                        <input class="form-styling" type="tel" name="phone" id="phone_reg" required minlength="80" autocomplete="off"/>     
                    </label>            
                    <label for="password_reg">
                        <span class="lab">ПАРОЛЬ</span>
                        <input class="form-styling" type="password" name="password" id="password_reg" maxlength="12" minlength="8" required/>
                        <ul class="input-requirements">
                        <li>Количество символов от 8 до 12</li>
                            <li>Должен содержать только латинские буквы и цифры</li>
                        </ul>
                    </label>
                    <label for="password_repeat">
                        <span class="lab">ПОВТОРИТЕ ПАРОЛЬ</span>
                        <input class="form-styling" type="password" name="password2" id="password_repeat" maxlength="12" minlength="8" required/>
                        <ul class="input-requirements">
                            <li>Этот пароль должен соответствовать первому</li>
                        </ul>
                    </label>
                    <button type="submit" class="btnn btn-signup">ЗАРЕГИСТРИРОВАТЬСЯ</button>
                    <div class="pad">
                        <div id="answer_signup"></div>
                    </div>
                </form>
            </div>
            <div class="welcome_login">
                <div class="cover">
                    <h1>Вы успешно зашли на сайт!</h1>
                </div>
                <p>Имя: <span id="name"></span></p>
                <p>Телефон: <span id="phone"></span></p>
                <p>Почта: <span id="username"></span></p>
                <a class="btnn btn-goback" value="Refresh" onClick="history.go()">назад</a>
            </div>
            <div class="welcome_forgot">
                <div class="cover">Для восстановления пароля введите вашу почту</div>
                <form class="form_forgot" id="forgot" name="form">
                    <label for="username_forgot">
                        <input class="form-styling" type="email" name="username" id="username_forgot" minlength="6" required  autocomplete="off" placeholder="EMAIL"/>
                        <ul class="input-requirements">
                            <li>Укажите Ваш действительный адрес электронной почты</li>
                        </ul>           
                    </label>
                    <button type="submit" class="btnn btn-signup">ОТПРАВИТЬ</button>
                    <div id="answer_forgot"></div>
                </form>
                <a class="btnn btn-goback" value="Refresh" onClick="history.go()">назад</a>
            </div>
            <div class="welcome_registration">
                <div class="cover">
                    <img src="images/checked.png" class="check" />
                </div>
                <h4>Вы успешно зарегистрированы на сайте!</h4>
                <a class="btnn btn-goback" value="Refresh" onClick="history.go()">назад</a>
            </div>
            <button type="button" class="mod btn-primary" data-toggle="modal" data-target="#modal_forgot">
                Запустить модальное окно
            </button>

            <div class="modal fade" id="modal_forgot">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            На Вашу почту отправлено письмо с новым паролем
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script> 
    jQuery(function($){
        $("#phone_reg").mask("+7(999)999-99-99");
    });
</script>
<script src="js/send.js"></script>
<script src="js/script.js"></script>
</body>
</html>