let menu = document.querySelector('#menu-icon');
let barra = document.querySelector('.itemsBar');

let iconoCarrito = document.querySelector('#cart-icon');
let carrito = document.querySelector('.itemsCart');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    barra.classList.toggle('open');
}

iconoCarrito.onclick = () => {
    carrito.classList.toggle('open');
} 

