/* Обрабатывает отправку форм входа, регистрации и восстановления пароля. */
$(document).ready(function() {
    $(form).submit(function(event) {
        event.preventDefault();
        $url = "http://de-san.com/RES/php/" + $(this).attr('id') + ".php";
        var idd = $(this).attr('id');
        $.ajax({
            url: $url,
            type: "GET",
            data: $(this).serialize(),
            success: function(answer) { 
                if (answer != 0) {
                    if (idd == "registration") {
                        if (answer == 20) {
                            $("#answer_signup").html('<div class="alert alert-success alert-dismissible fade show">Пользователь с таким адресом уже зарегистрирован<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button></div>');
                            $("#answer_signup").show();
                        } else if (answer == 21) {
                            $(".form-signup").toggleClass("form-signup-left"); 
                            $(".welcome_registration").toggleClass("welcome-down");
                            $(".nav").toggleClass("nav-left");
                            $(".frame").toggleClass("frame-short"); 
                        } 
                    } else if (idd == "login") {
                        var data = jQuery.parseJSON( answer );
                        if (data.length == 0){
                            $("#answer_signin").html('<div class="alert alert-success alert-dismissible fade show">Неверный логин или пароль<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button></div>');
                            $("#answer_signin").show();
                        } else {
                            var data = jQuery.parseJSON( answer );
                            $(".btn-animate").toggleClass("btn-animate-grow");
                            $(".welcome_login").toggleClass("welcome-down");
                            $(".frame").toggleClass("frame-short-short");
                            $(".forgot").toggleClass("forgot-fade");
                            $("#name").html(data[0]);
                            $("#phone").html(data[1]);
                            $("#username").html(data[2]);
                        }                      
                    } else if (idd == "forgot") {
                        if (answer == 30) {
                            $("#answer_forgot").html('<div class="alert alert-success alert-dismissible fade show">Пользователь с таким адресом не зарегистрирован<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button></div>');
                            $("#answer_forgot").show();
                        } else {
                            $("#answer_forgot").hide();
                            $('.mod').click();
                            $('#forgot')[0].reset(); 
                        }                
                    }
                } else {
                alert('Возникла ошибка.');
                }
            },
            error:  function(xhr){
                alert('Возникла ошибка.');
            }	
        });	
    });
});
/* Обрабатывает переход между вкладками Вход и Регистрация */
$(function() {    
    $(".btn").click(function() {
        $(".frame").toggleClass("frame-long");
        $(".signup-inactive").toggleClass("signup-active");
        $(".signin-active").toggleClass("signin-inactive");
        $(".form-signin").toggleClass("form-signin-left");
        $(".form-signup").toggleClass("form-signup-left");
    });
});
/* Обрабатывает переходна страницу восстановления пароля */
$(function() {    
    $(".forgot").click(function() {
        $(".welcome_forgot").toggleClass("welcome-down");
        $(".form-signin").hide();
        $(".nav").hide();
        $(".frame").toggleClass("frame-short");
    });
});
