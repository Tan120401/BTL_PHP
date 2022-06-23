import { handleRenderData, handleUserCaretIcon } from "./manager.js"

let newsPlaceName = document.getElementById('news-placeName')
let newsTitle = document.getElementById('news-title')
let newsDesc = document.getElementById('news-desc')

handleRenderData(newsPlaceName, newsTitle, newsDesc)

handleUserCaretIcon()