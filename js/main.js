document.addEventListener("DOMContentLoaded", function () {
    var header = document.querySelector(".navbar");

    function updateStyles() {
        var scrollPosition = window.pageXOffset || document.documentElement.scrollTop;
        var isWideScreen = (window.innerWidth || document.documentElement.clientWidth) > 768;
        var scrollThreshold = 100;

        header.classList.toggle("fixed", isWideScreen && scrollPosition > scrollThreshold);

        document.querySelectorAll(".menu-bar ul li a").forEach(item => {
            item.style.color = isWideScreen && scrollPosition > scrollThreshold ? "#154171" : "";
            item.style.fontWeight = isWideScreen && scrollPosition > scrollThreshold ? "500" : "";
        });

        document.querySelectorAll(".fa-solid.fa-caret-down").forEach(icon => {
            icon.style.color = isWideScreen && scrollPosition > scrollThreshold ? "#154171" : "";
        });

        document.querySelectorAll(".fa-solid.fa-magnifying-glass").forEach(icon => {
            icon.style.color = isWideScreen && scrollPosition > scrollThreshold ? "#fff" : "";
        });

        var logo = document.querySelector(".logo");
        if (logo) {
            logo.style.cssText = isWideScreen && scrollPosition > scrollThreshold ? "background: #154171; padding: 5px 10px; border-radius: 50px 0px 50px 50px;" : "";
        }
    }

    function handleDropdownHover() {
        document.querySelectorAll(".dropdown-menu ul li a").forEach(item => {
            item.addEventListener("mouseover", () => item.style.color = "#fff");
            item.addEventListener("mouseout", () => item.style.color = "");
        });
    }    

    updateStyles();
    window.addEventListener("resize", updateStyles);
    window.addEventListener("scroll", updateStyles);
    handleDropdownHover();
});



// Mobile Menu
console.clear();

const navExpand = document.querySelectorAll('.nav-expand');
const backLink = `<li class="nav-item"><a class="nav-link nav-back-link" href="javascript:;"><i class="fa-solid fa-caret-left"></i></a></li>`;

navExpand.forEach(item => {
  item.querySelector('.nav-expand-content').insertAdjacentHTML('afterbegin', backLink);
  item.querySelector('.nav-link').addEventListener('click', () => item.classList.toggle('active'));
  item.querySelector('.nav-back-link').addEventListener('click', () => item.classList.remove('active'));
});

document.getElementById('ham').addEventListener('click', () => document.body.classList.toggle('nav-is-toggled'));