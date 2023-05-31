var slider = document.querySelector('.slider');
var slides = document.querySelectorAll('.slide');
var slideWidth = slides[0].offsetWidth;
var currentIndex = Math.floor(slides.length / 2);


function slideTo(index) {

    if (index < -1 || index >= slides.length) return;

    var offset = -index * slideWidth;
    slider.style.left = offset + 'px';
    currentIndex = index;
}

function slideNext() {
    slideTo(currentIndex + 1);
}

function slidePrevious() {
    slideTo(currentIndex - 1);
}

document.getElementById('btn-next').addEventListener('click', (e) => {
    e.preventDefault()
    slideNext()
});
document.getElementById('btn-prev').addEventListener('click', (e) => {
    e.preventDefault()
    slidePrevious()
});
