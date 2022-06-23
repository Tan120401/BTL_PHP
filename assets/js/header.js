Header();

function Header() {
    document.querySelector('.header__login--btn').onclick = function() {
        window.location.assign('login.php')
    }
    document.querySelector('.header__user').onclick = function() {
        document.querySelector('.header__user--menu').classList.toggle('active')
    }

    const mobileNav = document.querySelector(".mobile-nav");
    const mask = document.querySelector(".mask");
    document.getElementById("hamburger").onclick = function() {
        mobileNav.classList.add("active");
        mask.classList.add("active");
    }
    mask.onclick = function() {
        mobileNav.classList.remove("active");
        this.classList.remove("active");
    }
    window.addEventListener("resize", function() {
        if(window.innerWidth >= 1024) {
            mobileNav.classList.remove("active");
            mask.classList.remove("active");
        }
    });

    if (document.querySelector('.header__user--menu--heading--name').innerText != '')
        document.querySelector('.header').classList.add('login')
}
export default Header;