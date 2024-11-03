let menu = document.querySelector('#menu-icon');
let barra = document.querySelector('.itemsBar');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    barra.classList.toggle('open');
}