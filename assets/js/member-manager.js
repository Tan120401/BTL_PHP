import { handleRenderData, handleUserCaretIcon } from "./manager.js";

let memberName = document.getElementById('member-name')
let memberAddress = document.getElementById('member-address')
let memberEmail = document.getElementById('member-email')
let memberPhone = document.getElementById('member-phone')
let memberUsername = document.getElementById('member-username')
let memberPassword = document.getElementById('member-password')
let memberRole = document.getElementById('member-role')


handleRenderData(memberName, memberAddress, memberEmail, memberPhone, memberUsername, memberPassword, memberRole)

handleUserCaretIcon()
