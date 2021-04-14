let register = document.querySelector('.header__btn-account');
let blackout = document.querySelector('.black_out');
let registerForm = document.querySelector('.register__form');
let body = document.querySelector('body');
let header = document.querySelector('header');
let changeBtn = document.querySelector('.change__form__btn');

register.addEventListener('click', openForm);
blackout.addEventListener('click', closeWindow);
changeBtn.addEventListener('click', changingForm);
document.addEventListener('keydown', function (event) {
    if (event.key == 'Escape') {
        closeWindow();
    }
});

function closeWindow() {
    let elem = document.querySelector('.openedElem');
    header.style.paddingRight = '0';
    body.style.overflowY = 'scroll';
    body.style.marginRight = '0';
    blackout.hidden = true;
    elem.hidden = true;
    elem.classList.remove('openedElem');
}

function openForm() {
    header.style.paddingRight = '17px';
    body.style.overflowY = 'hidden';
    body.style.marginRight = '17px';
    blackout.hidden = false;
    registerForm.hidden = false;
    registerForm.classList.add('openedElem');
}

function changingForm() {
    registerForm.hidden = true;
    registerForm.classList.remove('openedElem');

    let registration = document.querySelector('.registration');
    let login = document.getElementById('reg_login');
    let password = document.getElementById('reg_password');
    let subPassword = document.getElementById('reg_sub_password');
    let message = document.querySelectorAll('.info__message');
    let mistake = document.querySelectorAll('.mistake__message');
    let locker = [false, false, false];

    registration.hidden = false;
    registration.classList.add('openedElem');

    login.addEventListener('mousemove', helpMessage);
    login.addEventListener('mouseout', closeHelpMessage);
    login.addEventListener('keyup', loginCorrectnessCheck);
    login.addEventListener('blur', endCorrectnessCheck);
    password.addEventListener('mousemove', helpMessage);
    password.addEventListener('mouseout', closeHelpMessage);
    password.addEventListener('keyup', passwordCorrectnessCheck);
    password.addEventListener('blur', endCorrectnessCheck);
    subPassword.addEventListener('keyup', matchCheck);
    subPassword.addEventListener('blur', endMatchCheck);

    function helpMessage() {
        message[this.dataset.helptext].style.display = 'block';
    }

    function closeHelpMessage() {
        message[this.dataset.helptext].style.display = 'none';
    }

    function endMatchCheck() {
        mistake[this.dataset.helptext].style.display = 'none';
    }

    function matchCheck() {
        mistake[this.dataset.helptext].style.display = 'block';

        if (this.value != password.value) {
            this.style.outlineColor = 'red';
            mistake[this.dataset.helptext].innerHTML = 'Пароли не совпадают';
            locker[2] = false;
        } else {
            this.style.outlineColor = 'green';
            mistake[this.dataset.helptext].innerHTML = 'Пароли совпадают';
            locker[2] = true;
        }

        isSend();
    }

    function passwordCorrectnessCheck() {
        supCorrectnessCheck(this);

        if (/[^\w\{\}\(\)\[\]_-]/.test(this.value)) {
            mistake[this.dataset.helptext].innerHTML = 'Недопустимый символ';
            locker[1] = false;
        } else if (this.value.length < 8) {
            mistake[this.dataset.helptext].innerHTML = 'Пароль слишком короткий';
            locker[1] = false;
        } else {
            this.style.outlineColor = 'green';
            mistake[this.dataset.helptext].innerHTML = 'Корректный пароль';
            locker[1] = true;
        }

        isSend();
    }

    function loginCorrectnessCheck() {
        supCorrectnessCheck(this);

        if (/\W/.test(this.value)) {
            mistake[this.dataset.helptext].innerHTML = 'Недопустимый символ';
            locker[0] = false;
        } else if (this.value.length < 6) {
            mistake[this.dataset.helptext].innerHTML = 'Логин слишком короткий';
            locker[0] = false;
        } else if (this.value.length > 16) {
            mistake[this.dataset.helptext].innerHTML = 'Логин слишком длинный';
            locker[0] = false;
        } else {
            this.style.outlineColor = 'green';
            mistake[this.dataset.helptext].innerHTML = 'Корректный логин';
            locker[0] = true;
        }

        isSend();
    }

    function supCorrectnessCheck(elem) {
        elem.removeEventListener('mousemove', helpMessage);
        elem.removeEventListener('mouseout', closeHelpMessage);
        message[elem.dataset.helptext].style.display = 'none';
        mistake[elem.dataset.helptext].style.display = 'block';
        elem.style.outlineColor = 'red';
    }

    function endCorrectnessCheck() {
        this.addEventListener('mousemove', helpMessage);
        this.addEventListener('mouseout', closeHelpMessage);
        mistake[this.dataset.helptext].style.display = 'none';
    }

    function isSend() {
        if (locker[0] && locker[1] && locker[2]) {
            document.getElementById('register-form-send-btn').disabled = false;
        } else {
            document.getElementById('register-form-send-btn').disabled = true;
        }
    }
}

function checkOpenedElem() {
    if (document.querySelector('.openedElem') != null) {
        header.style.paddingRight = '17px';
        body.style.overflowY = 'hidden';
        body.style.marginRight = '17px';
        blackout.hidden = false;
        document.querySelector('.openedElem').hidden = false;
    }
}

checkOpenedElem();