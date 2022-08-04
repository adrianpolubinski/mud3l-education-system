// Navigation
const menu = document.querySelector('.menu');
const btn = document.querySelector('.menu button');
const ul = document.querySelector('.menu ul');
btn.addEventListener('click', function () {
    ul.classList.toggle('active');
});



const $menu=$('.menu');

$(document).on('scroll', function () {

if ($(this).scrollTop() > 50)
    $menu.addClass('menu-fixed');
else
    $menu.removeClass('menu-fixed');

});
