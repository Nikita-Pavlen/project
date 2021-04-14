let deleteBtns = document.querySelectorAll('.delete__one');
for (let i = 0; i < deleteBtns.length; i++) {
    deleteBtns[i].addEventListener('click', deleteElem);
}

let deleteAbs = document.querySelector('.delete__all');
deleteAbs.addEventListener('click', deleteAll);

let buyAll = document.querySelector('.buy');
buyAll.addEventListener('click', buying);

let message = document.querySelector('.message');

let countProducts = document.querySelectorAll('.count__products input');
for (let i = 0; i < countProducts.length; i++) {
    countProducts[i].addEventListener('change', checkCount);
}

function deleteElem() {
    let elems = document.querySelectorAll('.product');
    for (let i = 0; i < elems.length; i++) {
        if (elems[i].dataset.productname == this.dataset.productname) {
            elems[i].outerHTML = '';
            let index = parseInt(getCookie('cartProductIndex'));
            index--;
            document.cookie = 'cartProductIndex=' + index + '; path=/; max-age=3600';
            let arrProduct = getCookie('cartProduct').split(', ');
            let newCookie = [];
            for (let j = 0; j < arrProduct.length; j++) {
                if (arrProduct[j] != this.dataset.productname) {
                    newCookie.push(arrProduct[j]);
                }
            }
            if (newCookie.length == 0) {
                document.cookie = 'cartProduct=; path=/; max-age=0';
                document.cookie = 'cartProductIndex=; path=/; max-age=0';
                emptyCart();
            } else {
                document.cookie = 'cartProduct=' + newCookie.join(', ') + '; path=/; max-age=3600';
            }
            checkCartWish();
            changeTotalPrice();
        }
    }
}

function buying() {
    blackout.hidden = false;
    header.style.paddingRight = '17px';
    body.style.overflowY = 'hidden';
    body.style.marginRight = '17px';
    document.cookie = 'cartProduct=; path=/; max-age=0';
    document.cookie = 'cartProductIndex=; path=/; max-age=0';
    message.hidden = false;
    message.classList.add('openedElem');
    checkCartWish();
    emptyCart();
}

function deleteAll() {
    document.cookie = 'cartProduct=; path=/; max-age=0';
    document.cookie = 'cartProductIndex=; path=/; max-age=0';
    emptyCart();
    checkCartWish();
}

function emptyCart() {
    let main = document.querySelector('.main__container');
    main.innerHTML = '<div class="empty__cart">\n' +
        '<h3>Ваша корзина пуста</h3>\n' +
        '<a href="/"><button class="btn on-main-page">Вернуться на главную</button></a>\n' +
        '</div>';
}

function checkCount() {
    if (parseInt(this.value) < 1 || this.value == '') {
        this.value = 1;
        this.parentElement.parentElement.querySelector('.price__value').innerHTML = this.dataset.productprice;
        document.cookie = this.dataset.productname + '=; path=/; max-age=0';
    } else {
        this.parentElement.parentElement.querySelector('.price__value').innerHTML = parseInt(this.dataset.productprice) * parseInt(this.value);
        document.cookie = this.dataset.productname + '=' + this.value + '; path=/; max-age=3600';
    }
    changeTotalPrice();
}

function changeTotalPrice() {
    let total = document.querySelector('.total');
    let prices = document.querySelectorAll('.price__value');
    let value = 0;
    for (let i = 0; i < prices.length; i++) {
        value += parseInt(prices[i].innerHTML);
    }
    total.innerHTML = value;
}