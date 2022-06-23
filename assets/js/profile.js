PROFILE_DATA;

const memberNameInput = document.getElementById("member-name");
const memberAddressInput = document.getElementById("member-address");
const memberPhoneInput = document.getElementById("member-phone");
const memberAvatarInput = document.getElementById("member-avatar");
const memberAvatarRemoveCheck = document.getElementById("avatar-removed");
const memberPasswordInput = document.getElementById("member-password");

const updateForm = document.getElementById("update-form");
const submitBtn = document.querySelector(".submit-btn");
const cancelBtn = document.querySelector(".cancel-btn");

submitBtn.onclick = submit;
updateForm.onsubmit = submit;

cancelBtn.onclick = function(e) {
	e.preventDefault();
	memberNameInput.value = PROFILE_DATA["name"];
	memberAddressInput.value = PROFILE_DATA["address"];
	memberPhoneInput.value = PROFILE_DATA["phone"];
	memberAvatarInput.value = "";
	memberAvatarRemoveCheck.checked = false;
	memberPasswordInput.value = PROFILE_DATA["pw"];
}

function submit(e) {
	let check = nameCheck(e) && phoneCheck(e) && passwordCheck(e);

	if(!check) e.preventDefault();
	else updateForm.classList.add("is--error");
}
memberNameInput.onblur = nameCheck;
memberPhoneInput.onblur = phoneCheck;
memberPasswordInput.onblur = passwordCheck;

function nameCheck(e) {
	return fieldCheck(memberNameInput, "Họ và tên chỉ chứa chữ cái", testFullName);
}
function phoneCheck(e) {
	return fieldCheck(memberPhoneInput, "Sai định dạng. Định dạng đúng: ???(-.)???(-.)????<br>Trong đó: ? là chữ số", testPhone);
}
function passwordCheck(e) {
	return fieldCheck(memberPasswordInput, "Mật khẩu tối thiểu 8 ký tự bao gồm chữ cái, chữ số và ký tự đặc biệt", testPassword);
}

function fieldCheck(field, errorMes, testFunc) {
	const check = testFunc(field.value);

	if(!check) {
		if(!field.nextElementSibling)
		field.insertAdjacentHTML("afterend", `<p class="error-mes">${errorMes}</p>`);
		updateForm.classList.add("is--error");
		return false;
	} 
	
	field.nextElementSibling?.remove();
	return true;
}

function testFullName(value) {
	// Họ và tên chỉ chứa chữ cái
    let regex = /^[\p{L} .'-]+$/u
    return regex.test(value);
}
function testEmail(value) {
	//email hợp lệ. abc@g.co
    let regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
    return regex.test(value);
}
function testPhone(value) {
	// ???(-.)???(-.)????
    let regex = /^\+?\d{1,3}?[- ]?\(?(?:\d{2,3})\)?[- ]?\d\d\d[- ]?\d\d\d\d$/
    return regex.test(value);
}
function testPassword(value) {
	//tối thiểu 8 ký tự bao gồm chữ cái, chữ số và ký tự đặc biệt
    let regex = /^(?=.*[a-z])(?=.*[@$!%*#?&])(?=.*[0-9])[A-Za-z0-9@$!%*#?&]{8,}$/
    return regex.test(value);
}
