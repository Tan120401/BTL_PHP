const tabsBtn = document.querySelectorAll(".tour__tabs-titles button");
const currentTabContent = document.querySelector(".tour__tabs-content");

const activeBtnPos = tabsBtn.length - 1;
// date
// const startingDate = document.getElementById("date");

// initStartingDate();

// function initStartingDate() {
// 	const startingDateValue = startingDate.value;
// 	const current = new Date(Date.now()).toISOString().slice(0, 10);
	
// 	if(!startingDateValue) {
// 		startingDate.value = current;
// 		return;
// 	}

// 	console.log(startingDateValue);
// 	if(Date.parse(startingDateValue) < Date.parse(current)) {
// 		startingDate.value = current;
// 	}
// }

// days
const daysInput = document.querySelector("#days");

// quantity buttons
const decreaseBtn = document.querySelector(".quantity-btn.decrease");
const increaseBtn = document.querySelector(".quantity-btn.increase");
const quantityInput = document.querySelector("#quantity");

// original price
const tourPrice = document.querySelector(".tour__price");

const originalPrice = DATA['originalPrice'];

const originalDays = parseInt(daysInput.textContent);
let daysNum = originalDays;
let discount = 0;

// increase quantity

decreaseBtn.onclick = function() {
	let currentQnt = +quantityInput.value;

	--currentQnt;

	if(currentQnt < 1) return;

	if(currentQnt == 1) discount = 0;
	else if(currentQnt / 20 > 0.4) discount = 0.4;
	else discount = currentQnt / 20;
	
	quantityInput.value = currentQnt;

	tourPrice.innerHTML = (originalPrice * currentQnt * (1 - discount)).toLocaleString('en-US') + "<sup>₫</sup>";
}

increaseBtn.onclick = function() {
	let currentQnt = +quantityInput.value;

	++currentQnt;

	if(currentQnt / 20 > 0.4) discount = 0.4;
	else discount = currentQnt / 20;

	quantityInput.value = currentQnt;

	tourPrice.innerHTML = (originalPrice * currentQnt * (1 - discount)).toLocaleString('en-US') + "<sup>₫</sup>";
}

// init tab content
initTabContent(tabsBtn[activeBtnPos]);

tabsBtn[activeBtnPos].classList.add("active");

tabsBtn.forEach(btn => {
	btn.onclick = function() {
		tabsBtn.forEach(btn => {
			btn.classList.remove("active");
		})

		this.classList.add("active");
		
		initTabContent(this);
	}
});

function initTabContent(btn) {
	let content = DATA[btn.dataset.title];

	if(content === "") content = "...";

	if(btn.dataset.title === "desc") {
		content = content.split("\n").map(para => {
			if(para.trim().startsWith("<title>")) 
				return `<p class='tour__tabs-content--bold'>${para.replaceAll("<title>", "")}</p>`

			return `<p>${para}</p>`
		}).join("");
	}

	if(btn.dataset.title === "review") {
		content = `
			<div class="tour-details__form-container">
				${DATA["addReviewAlert"]}
				<form action="./review.php?tourId=${DATA["tourId"]}" method="post">
					<div style="flex: 1; display: flex; flex-direction: column; gap: 15px">
						<div class="tour-detail__favorite-check">
							<input type="checkbox" name="favorite" id="favorite-check">
							<label for="favorite-check">Lưu vào Yêu Thích</label>
						</div>
						<div class="tour-details__stars">
							<input type="radio" name="stars" value="5" ${DATA["addStarsText"] == "5"? "checked": ""} id="5-stars">
							<label for="5-stars">
								<svg xmlns="http://www.w3.org/2000/svg" class="star" fill="#e5e5e5" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
							</label>
							<input type="radio" name="stars" value="4" ${DATA["addStarsText"] == "4"? "checked": ""}  id="4-stars">
							<label for="4-stars">
								<svg xmlns="http://www.w3.org/2000/svg" class="star" fill="#e5e5e5" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
							</label>
							<input type="radio" name="stars" value="3" ${DATA["addStarsText"] == "3"? "checked": ""}  id="3-stars">
							<label for="3-stars">
								<svg xmlns="http://www.w3.org/2000/svg" class="star" fill="#e5e5e5" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
							</label>
							<input type="radio" name="stars" value="2" ${DATA["addStarsText"] == "2"? "checked": ""}  id="2-stars">
							<label for="2-stars">
								<svg xmlns="http://www.w3.org/2000/svg" class="star" fill="#e5e5e5" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
							</label>
							<input type="radio" name="stars" value="1" ${DATA["addStarsText"] == "1"? "checked": ""}  id="1-star">
							<label for="1-star">
								<svg xmlns="http://www.w3.org/2000/svg" class="star" fill="#e5e5e5" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
							</label>
						</div>
						<label for="review-input">Nhận xét: </label>
						<textarea name="review" id="review-input">${DATA["addReviewText"]}</textarea>
					</div>
					<button type="submit" class="tour-details__form-btn">Gửi</button>
				</form>
			</div>
		` + content;
	}

	currentTabContent.innerHTML = `${content}`;
}
