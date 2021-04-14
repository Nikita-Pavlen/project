let deleteBtns = document.querySelectorAll('.delete__one');
for (let i = 0; i < deleteBtns.length; i++) {
    deleteBtns[i].addEventListener('click', deleteElem);
}

let addOne = document.querySelectorAll('.add-in-cart');
for (let i = 0; i < addOne.length; i++) {
    addOne[i].addEventListener('click', addOneInCart);
    checkCart(addOne[i]);
}

let deleteAbs = document.querySelector('.delete__all');
deleteAbs.addEventListener('click', deleteAll);

let btnInCart = document.querySelector('.in-cart-all');
btnInCart.addEventListener('click', allInCart);

let message = document.querySelector('.message');

function addOneInCart() {
    let elems = document.querySelectorAll('.product');
    for (let i = 0; i < elems.length; i++) {
        if (elems[i].dataset.productname == this.dataset.productname) {
            elems[i].outerHTML = '';
            let arrProduct = getCookie('wishProduct').split(', ');
            let newCookie = [];
            for (let j = 0; j < arrProduct.length; j++) {
                if (arrProduct[j] != this.dataset.productname) {
                    newCookie.push(arrProduct[j]);
                }
            }
            if (newCookie.length == 0) {
                document.cookie = 'wishProduct=; path=/; max-age=0';
                document.cookie = 'wishProductIndex=; path=/; max-age=0';
                emptyWish();
            } else {
                document.cookie = 'wishProduct=' + newCookie.join(', ') + '; path=/; max-age=3600';
                document.cookie = 'wishProductIndex=' + newCookie.length + '; path=/; max-age=3600';
            }

            let addCookie;
            if (getCookie('cartProduct') != undefined) {
                addCookie = getCookie('cartProduct').split(', ');
            } else addCookie = [];

            addCookie.push(this.dataset.productname);

            document.cookie = 'cartProductIndex=' + addCookie.length + '; path=/; max-age=3600';
            document.cookie = 'cartProduct=' + addCookie.join(', ') + '; path=/; max-age=3600';

            checkCartWish();
        }
    }
}

function deleteElem() {
    let elems = document.querySelectorAll('.product');
    for (let i = 0; i < elems.length; i++) {
        if (elems[i].dataset.productname == this.dataset.productname) {
            elems[i].outerHTML = '';
            let index = parseInt(getCookie('wishProductIndex'));
            index--;
            document.cookie = 'wishProductIndex=' + index + '; path=/; max-age=3600';
            let arrProduct = getCookie('wishProduct').split(', ');
            let newCookie = [];
            for (let j = 0; j < arrProduct.length; j++) {
                if (arrProduct[j] != this.dataset.productname) {
                    newCookie.push(arrProduct[j]);
                }
            }
            if (newCookie.length == 0) {
                document.cookie = 'wishProduct=; path=/; max-age=0';
                document.cookie = 'wishProductIndex=; path=/; max-age=0';
                emptyWish();
            } else {
                document.cookie = 'wishProduct=' + newCookie.join(', ') + '; path=/; max-age=3600';
            }
            checkCartWish();
        }
    }
}

function allInCart() {
    let arrProduct = getCookie('wishProduct').split(', ');
    let addCookie;
    if (getCookie('cartProduct') != undefined) {
        addCookie = getCookie('cartProduct').split(', ');
    } else addCookie = [];

    for (let i = 0; i < arrProduct.length; i++) {
        if (checkFinal(addCookie, arrProduct[i])) {
            addCookie.push(arrProduct[i]);
        }
    }

    document.cookie = 'cartProductIndex=' + addCookie.length + '; path=/; max-age=3600';
    document.cookie = 'cartProduct=' + addCookie.join(', ') + '; path=/; max-age=3600';

    blackout.hidden = false;
    header.style.paddingRight = '17px';
    body.style.overflowY = 'hidden';
    body.style.marginRight = '17px';
    document.cookie = 'wishProduct=; path=/; max-age=0';
    document.cookie = 'wishProductIndex=; path=/; max-age=0';
    message.hidden = false;
    message.classList.add('openedElem');
    checkCartWish();
    emptyWish();
}

function deleteAll() {
    document.cookie = 'wishProduct=; path=/; max-age=0';
    document.cookie = 'wishProductIndex=; path=/; max-age=0';
    emptyWish();
    checkCartWish();
}

function emptyWish() {
    let main = document.querySelector('.main__container');
    main.innerHTML = '<div class="empty__cart">\n' +
        '<h3>Ваш список желаемого пуст.</h3>\n' +
        '<a href="/"><button class="btn on-main-page">Вернуться на главную</button></a>\n' +
        '</div>';
}

function checkCart(elem) {
    let arrCart;
    if (getCookie('cartProduct') != undefined) {
        arrCart = getCookie('cartProduct').split(', ');
        for (let i = 0; i < arrCart.length; i++) {
            if (elem.dataset.productname == arrCart[i]) {
                elem.disabled = true;
                elem.innerHTML = 'В корзине';
            }
        }
    }
}

function checkFinal(arrCookie, elem) {
    for (let i = 0; i < arrCookie.length; i++) {
        if (arrCookie[i] == elem) {
            return false;
        }
    }
    return true;
}