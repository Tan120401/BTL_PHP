import { handleRenderData, handleUserCaretIcon } from "./manager.js";

let tourName = document.getElementById('tour-name')
let tourDestination = document.getElementById('tour-destination')
let tourDesc = document.getElementById('tour-desc')
let tourStartDay = document.getElementById('tour-startDay')
let tourDay = document.getElementById('tour-day')

handleRenderData(tourName, tourDestination, tourDesc, tourStartDay, tourDay)

handleUserCaretIcon()