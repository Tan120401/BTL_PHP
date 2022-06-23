const carousel = document.querySelector(".carousel__items");
const leftBtn = document.querySelector(".carousel__left-btn button");
const rightBtn = document.querySelector(".carousel__right-btn button");

leftBtn.onclick = () => {
	carousel.scrollLeft -= carousel.children[0].offsetWidth;
}
rightBtn.onclick = () => {
	carousel.scrollLeft += carousel.children[0].offsetWidth;
}