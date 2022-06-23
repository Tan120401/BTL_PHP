import Header from './header.js';
import TourPlace from './tourPlace.js';

Header();
TourPlace();

document.querySelector('.tour-square__place--details--btn').onclick = function() {
    window.location.assign('place.html')
}
var counter = 2;
var manualBtns = document.querySelectorAll('.manual-btn');

document.getElementById('slide_1').checked = true

for (let i = 0; i < manualBtns.length; i++) {
    let manualBtn = manualBtns[i]
    manualBtn.onclick = function() {
        counter = i+1
    }
}
setInterval(() => {
    document.getElementById('slide_' + counter).checked = true
    counter++
    if (counter > 4)
        counter = 1
}, 10000)