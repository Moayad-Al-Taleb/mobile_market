// control navbar (show - hide ) 
let navbar = document.querySelector(".list");
let barClick = document.querySelector("#bars");
barClick.onclick = () => {
    navbar.classList.toggle("active")
}

let mainNav = document.querySelector('.main-nav');
window.onscroll = () => {
    if (document.documentElement.scrollTop > 50) {
        mainNav.classList.add("active")
        navbar.classList.add("list-active");
     } else {
         mainNav.classList.remove("active");
            navbar.classList.remove("list-active");
     }
}

let navbarItems = document.querySelectorAll(".navbar-link");
let href = location.href;

navbarItems.forEach(ele => {
    if(href.includes(ele.getAttribute("href"))) {
        ele.classList.add("active");
    } else {
        ele.classList.remove("active");
    }
});

let dottes = document.querySelectorAll(".dottes");
let controllers = document.querySelectorAll(".controllers");
dottes.forEach((e, index) => {
    e.onclick = () => {
        controllers.forEach((ele, index2) => {
            if(index == index2) {
                ele.classList.toggle("active")
            }
        })
    }
});




// carousel set
const carouselBtns = document.querySelectorAll("[data-carousel-button]"); //get the next and prev button
carouselBtns.forEach((carouselBtn) => {//for clicking the next or prev button
    carouselBtn.addEventListener("click", () => { // listen event for clicking the button
        const offset = carouselBtn.dataset.carouselButton === "next" ? 1 : -1; //to get the next img or prev img index
        const slides = carouselBtn.closest("[data-carousel]").querySelector("[data-slides]");// to get all images depending on the parent element
        const activeSlide = slides.querySelector("[data-active]"); //get the active slide (the shown img)
        let newIndex = [...slides.children].indexOf(activeSlide) + offset; //to get the next slide
        if(newIndex < 0) newIndex = slides.children.length - 1; // if the slides is 0
        if(newIndex >= slides.children.length) newIndex = 0;// if the slides is max length
        slides.children[newIndex].dataset.active = true; //add the active dataset for the slide to show
        delete activeSlide.dataset.active; // delete the active dataset 
    })
})
// carousel set