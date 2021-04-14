function checkCartWish() {
    let cart = document.querySelector('.cart span');
    let wish = document.querySelector('.wishlist span');
    if (getCookie('cartProductIndex') != undefined) {
        cart.innerHTML = '(' + getCookie('cartProductIndex') + ')';
    } else cart.innerHTML = '';
    if (getCookie('wishProductIndex') != undefined) {
        wish.innerHTML = '(' + getCookie('wishProductIndex') + ')';
    } else wish.innerHTML = '';
}

checkCartWish();