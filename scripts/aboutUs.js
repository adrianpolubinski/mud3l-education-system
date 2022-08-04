//Members
let activeElement = 0;
const timeChange = 4000;

const colorImgHtml = document.querySelector('.color');
const grayImgHtml = document.querySelector('.gray');
const h1Html = document.querySelector('.member h1');
const h2Html = document.querySelector('.member h2');

const colorImages = ['img/nataliaColor.png', 'img/rafalColor.png', 'img/adiColor.png'];
const grayImages = ['img/nataliaGray.png', 'img/rafalGray.png', 'img/adiGray.png'];
const names = ['Natalia Radomska', 'Rafał Rak', 'Adrian Połubiński'];
const professions = ['Programistka JS', 'Back-End Developer', 'Front-End Developer'];

function changeElement() {
    activeElement++;
    if (activeElement == colorImages.length) {
        activeElement = 0;
    }
    colorImgHtml.src = colorImages[activeElement];
    grayImgHtml.src = grayImages[activeElement];
    h1Html.textContent = names[activeElement];
    h2Html.textContent = professions[activeElement];

}
setInterval(changeElement, timeChange)


// articles in aboutUs
$(document).on('scroll', function () {

    const windowHeight = $(window).height();
    const scrollValue = $(this).scrollTop();

    const $art1 = $('.art1');
    const art1FromTop = $art1.offset().top;
    const art1Height = $art1.outerHeight();

    const $art2 = $('.art2');
    const art2FromTop = $art2.offset().top;
    const art2Height = $art2.outerHeight();

    const $art3 = $('.art3');
    const art3FromTop = $art3.offset().top;
    const art3Height = $art3.outerHeight();

    const $art4 = $('.art4');
    const art4FromTop = $art4.offset().top;
    const art4Height = $art4.outerHeight();

    if (scrollValue > art1FromTop + art1Height - windowHeight)
        $art1.addClass('active');
    // else if (scrollValue < art1FromTop + art1Height - windowHeight)
    //     $art1.removeClass("active");

    if (scrollValue > art2FromTop + art2Height - windowHeight)
        $art2.addClass('active');
    // else if (scrollValue < art2FromTop + art2Height - windowHeight)
    //     $art2.removeClass("active");

    if (scrollValue > art3FromTop + art3Height - windowHeight)
        $art3.addClass('active');
    // else if (scrollValue < art3FromTop + art3Height - windowHeight)
    //     $art3.removeClass("active");

    if (scrollValue > art4FromTop + art4Height - windowHeight)
        $art4.addClass('active');
    // else if (scrollValue < art4FromTop + art4Height - windowHeight)
    //     $art4.removeClass('active');

    if(scrollValue < 50){
        $art1.removeClass('active');
        $art2.removeClass('active');
        $art3.removeClass('active');
        $art4.removeClass('active');
    }
});