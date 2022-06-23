// transform login-register
const formContainer = document.querySelector('.container')
let transformBtns = document.querySelectorAll('.form-heading__item')

transformBtns.forEach(btn => {
    btn.onclick = () => {
        transformBtns.forEach(btn => btn.classList.remove('active'))
        btn.classList.add('active')
        if (btn.innerText === "Đăng nhập") {   
            formContainer.classList.add('login')
            formContainer.classList.remove('register')
        }
        else {
            formContainer.classList.remove('login')
            formContainer.classList.add('register')
        }
    }
})
// display-hidden password
let inputPass = document.querySelector('.form-login .form-input[name="password"]')
let hiddenPass = document.querySelector('img[name="eye"]')
let displayPass = document.querySelector('img[name="eye-slash"]')

hiddenPass.onclick = () => {
    hiddenPass.classList.remove('active')
    displayPass.classList.add('active')
    inputPass.type = 'text'
}
displayPass.onclick = () => {
    displayPass.classList.remove('active')
    hiddenPass.classList.add('active')
    inputPass.type = 'password'
}
// control data

let fullName = document.querySelector('.form-input[name="fullname"]')
let email = document.querySelector('.form-input[name="email"]')
let phone = document.querySelector('.form-input[name="phone"]')
let user = document.querySelector('.form-input[name="user"]')
let password = document.querySelector('.form-input[name="create-password"]')

const fieldsCheck = {
    fullName: false,
    email: false,
    phone: false,
    user: false,
    password: false
}

fullName.onblur = function() {    
    if (this.value == '') {
        this.nextElementSibling.innerText = 'Vui lòng điền trường này'
        this.style.borderColor = '#f33a58'
        return;
    }
    fieldsCheck.fullName = testFullName(this.value);
    if (!fieldsCheck.fullName) {
        this.nextElementSibling.innerText = 'Họ và tên chỉ chứa chữ cái'
        this.style.borderColor = '#f33a58'
    }
    else {
        this.nextElementSibling.innerText = ''
        this.style.borderColor = '#ccc'
    }
}
email.onblur = function() {
    
    if (this.value == '') {
        this.nextElementSibling.innerText = 'Vui lòng điền trường này'
        this.style.borderColor = '#f33a58'
        return;
    }
    fieldsCheck.email = testEmail(this.value);
    if (!fieldsCheck.email) {
        this.nextElementSibling.innerText = 'Vui lòng nhập vào một email hợp lệ'
        this.style.borderColor = '#f33a58'
    }
    else {
        this.nextElementSibling.innerText = ''
        this.style.borderColor = '#ccc'
    }
}
phone.onblur = function() {
    
    if (this.value == '') {
        this.nextElementSibling.innerText = 'Vui lòng điền trường này'
        this.style.borderColor = '#f33a58'
        return;
    }

    fieldsCheck.phone = testPhone(this.value);
    if (!fieldsCheck.phone) {
        this.nextElementSibling.innerText = 'Vui lòng nhập theo định dạng ???(-.)???(-.)????'
        this.style.borderColor = '#f33a58'
    }
    else {
        this.nextElementSibling.innerText = ''
        this.style.borderColor = '#ccc'
    }
}
user.onblur= function () {
    if (this.value == '') {
        this.nextElementSibling.innerText = 'Vui lòng điền trường này'
        this.style.borderColor = '#f33a58'
        return;
    }
    fieldsCheck.user = testUser(this.value);
    if (!fieldsCheck.user) {
        this.nextElementSibling.innerText = 'Vui lòng điền trường này'
        this.style.borderColor = '#f33a58'
    }
    else {
        this.nextElementSibling.innerText = ''
        this.style.borderColor = '#ccc'
    }
}
password.onblur = function() {
    
    if (this.value == '') {
        this.nextElementSibling.innerText = 'Vui lòng điền trường này'
        this.style.borderColor = '#f33a58'
        return;
    }
    fieldsCheck.password = testPassword(this.value);
    if (!fieldsCheck.password) {
        this.nextElementSibling.innerText = 'Mật khẩu tối thiểu 8 ký tự bao gồm chữ cái, chữ số và ký tự đặc biệt'
        this.style.borderColor = '#f33a58'
    }
    else {
        this.nextElementSibling.innerText = ''
        this.style.borderColor = '#ccc'
    }
}

const btnRegister = document.querySelector('.form-btn[name="register"]')
btnRegister.onclick = function(e) {
    let check = true;
    if (fullName.value == '') {
        fullName.nextElementSibling.innerText = 'Vui lòng điền trường này'
        fullName.style.borderColor = '#f33a58'
        check = false
    }
    if (email.value == '') {
        email.nextElementSibling.innerText = 'Vui lòng điền trường này'
        email.style.borderColor = '#f33a58'
        check = false
    }
    if (phone.value == '') {
        phone.nextElementSibling.innerText = 'Vui lòng điền trường này'
        phone.style.borderColor = '#f33a58'
        check = false
    }
    if (user.value == '') {
        user.nextElementSibling.innerText = 'Vui lòng điền trường này'
        user.style.borderColor = '#f33a58'
        check = false
    }
    if (password.value == '') {
        password.nextElementSibling.innerText = 'Vui lòng điền trường này'
        password.style.borderColor = '#f33a58'
        check = false
    }
    
    fieldsCheck.fullName = testFullName(fullName.value);
    fieldsCheck.email = testEmail(email.value);
    fieldsCheck.phone = testPhone(phone.value);
    fieldsCheck.user = testUser(user.value);
    fieldsCheck.password = testPassword(password.value);

    // console.log(Object.values(fieldsCheck));
    // console.log(Object.values(fieldsCheck).some(fieldCheck => !fieldCheck));
    if (!check || Object.values(fieldsCheck).some(fieldCheck => !fieldCheck)) e.preventDefault();
    else window.location.assign(window.location.pathname);
}


function testFullName(value) {
    let regex = /^[\p{L} .'-]+$/u
    return regex.test(value);
}
function testEmail(value) {
    let regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
    return regex.test(value);
}
function testPhone(value) {
    let regex = /^\+?\d{1,3}?[- ]?\(?(?:\d{2,3})\)?[- ]?\d\d\d[- ]?\d\d\d\d$/
    return regex.test(value);
}
function testUser(value) {
    let regex = /.+/;
    return regex.test(value);
}
function testPassword(value) {
    let regex = /^(?=.*[a-z])(?=.*[@$!%*#?&])(?=.*[0-9])[A-Za-z0-9@$!%*#?&]{8,}$/
    return regex.test(value);
}
