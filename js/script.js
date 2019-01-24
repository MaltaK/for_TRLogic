/* Реализация проверки полей с помощью регулярных выражений и подсветку ошибок */
function CustomValidation(input) {
    /* Создается массив ошибок */
	this.invalidities = [];
	this.validityChecks = [];
	this.inputNode = input;

	this.registerListener();
}

CustomValidation.prototype = {
	addInvalidity: function(message) {
		this.invalidities.push(message);
	},
	getInvalidities: function() {
		return this.invalidities.join('. \n');
	},
	checkValidity: function(input) {
		for ( var i = 0; i < this.validityChecks.length; i++ ) {
			var isInvalid = this.validityChecks[i].isInvalid(input);
			if (isInvalid) {
				this.addInvalidity(this.validityChecks[i].invalidityMessage);
			}

			var requirementElement = this.validityChecks[i].element;

			if (requirementElement) {
				if (isInvalid) {
					requirementElement.classList.add('invalid');
					requirementElement.classList.remove('valid');
				} else {
					requirementElement.classList.remove('invalid');
					requirementElement.classList.add('valid');
				}
			} 
		}
	},
	checkInput: function() { 

		this.inputNode.CustomValidation.invalidities = [];
		this.checkValidity(this.inputNode);

		if ( this.inputNode.CustomValidation.invalidities.length === 0 && this.inputNode.value !== '' ) {
			this.inputNode.setCustomValidity('');
		} else {
			var message = this.inputNode.CustomValidation.getInvalidities();
			this.inputNode.setCustomValidity(message);
		}
	},
	registerListener: function() { 

		var CustomValidation = this;
		this.inputNode.addEventListener('keyup', function() {
			CustomValidation.checkInput();
		});
	}
};
/* Проверка поля почты, которое длжно содержать только один символ @ и '.' и буквы, цифры, +, -, _ */
var labels_user = ['username_reg', 'username_log', 'username_forgot'];
var labels_pass = ['password_reg', 'password_log'];
var usernames = [];
for (var i = 0; i < 3; i++) {
	usernames[i] = [];
	usernames[i][0] = {
		isInvalid: function(input) {
			return !input.value.match(/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/) || input.value.length < 1;
		},
		invalidityMessage: 'Укажите Ваш действительный адрес эл. почты',
		element: document.querySelector('label[for="' + labels_user[i] + '"] .input-requirements li:nth-child(1)')
	}  
}
/* Поле пароля должно содержать от 8 до 12 символов и может содержать только буквы и цифры */
var passwords = [];
for (var i = 0; i < 2; i++) {
	passwords[i] = [];
	passwords[i][0] = {
		isInvalid: function(input) {
			return input.value.length < 8 | input.value.length > 12;
		},
		invalidityMessage: 'Количество символов от 8 до 12',
		element: document.querySelector('label[for="' + labels_pass[i] + '"] .input-requirements li:nth-child(1)')
	};
	passwords[i][1] = {
		isInvalid: function(input) {
			return input.value.match(/\W/g) || input.value.length < 1;
		},
		invalidityMessage: 'Должен содержать только буквы и цифры',
		element: document.querySelector('label[for="' + labels_pass[i] + '"] .input-requirements li:nth-child(2)')
	};  
}
/* Поле имени может содержать только буквы */
var nameInputReg = document.getElementById('name_reg');
nameInputReg.CustomValidation = new CustomValidation(nameInputReg);
nameInputReg.CustomValidation.validityChecks = [
{
	isInvalid: function(input) {
		return input.value.match(/[^a-zA-Zа-яА-Я]/g) || input.value.length < 1;
	},
	invalidityMessage: 'Должно содержать только буквы',
	element: document.querySelector('label[for="name_reg"] .input-requirements li:nth-child(1)')
}
];
/* Проверка на совпадение паролей */
var passwordRepeatInput = document.getElementById('password_repeat');
passwordRepeatInput.CustomValidation = new CustomValidation(passwordRepeatInput);
passwordRepeatInput.CustomValidation.validityChecks = [
{
	isInvalid: function(input) {
		return passwordRepeatInput.value != passwordInputReg.value || input.value.length < 1;
	},
	invalidityMessage: 'Этот пароль должен соответствовать первому',
	element: document.querySelector('label[for="password_repeat"] .input-requirements li:nth-child(1)')
}
];
/* Вызов функции для каждого поля */
var usernameInputLog = document.getElementById('username_log');
var passwordInputLog = document.getElementById('password_log');
var usernameInputReg = document.getElementById('username_reg');
var passwordInputReg = document.getElementById('password_reg');
var usernameInputForgot = document.getElementById('username_forgot');

usernameInputLog.CustomValidation = new CustomValidation(usernameInputLog);
usernameInputLog.CustomValidation.validityChecks = usernames[1];

passwordInputLog.CustomValidation = new CustomValidation(passwordInputLog);
passwordInputLog.CustomValidation.validityChecks = passwords[1];

usernameInputReg.CustomValidation = new CustomValidation(usernameInputReg);
usernameInputReg.CustomValidation.validityChecks = usernames[0];

passwordInputReg.CustomValidation = new CustomValidation(passwordInputReg);
passwordInputReg.CustomValidation.validityChecks = passwords[0];

usernameInputForgot.CustomValidation = new CustomValidation(usernameInputForgot);
usernameInputForgot.CustomValidation.validityChecks = usernames[2];

