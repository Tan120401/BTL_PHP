import { handleRenderData, handleUserCaretIcon} from "./manager.js";

let placeName = document.getElementById('place-name')
let placeAddress = document.getElementById('place-address')
let placeProvince = document.getElementById('place-province')
let placePrice = document.getElementById('place-price')
let placeIntroduce = document.getElementById('place-introduce')
let placeHotelName = document.getElementById('place-hotelName')
let placeHotelAddress = document.getElementById('place-hotelAddress')


handleRenderData(placeName, placeAddress, placeProvince, placePrice, placeIntroduce, placeHotelName, placeHotelAddress)

handleUserCaretIcon()