let imgFull = document.querySelector('.full__img');
let imgSmall = document.querySelector('.img__container');
let inCartBtn = document.querySelector('.main__btn');
let inWishBtn = document.querySelector('.side__btn');
let text = document.querySelector('textarea');

imgSmall.addEventListener('click', openImg);

imgFull.addEventListener('click', closeWindow);

if (document.querySelector('.active__incart') == null) {
    inCartBtn.addEventListener('click', addProduct);
} else inCartBtn.addEventListener('click', deleteProduct);

if (document.querySelector('.active__inwish') == null) {
    inWishBtn.addEventListener('click', addProduct);
} else inWishBtn.addEventListener('click', deleteProduct);

text.addEventListener('keyup', checkText);

function checkText() {
    let submit = document.querySelector('#send-comment');
    if (this.value != '') {
        submit.hidden = false;
    } else submit.hidden = true;
}

function openImg() {
    header.style.paddingRight = '17px';
    body.style.overflowY = 'hidden';
    body.style.marginRight = '17px';
    blackout.hidden = false;
    imgFull.hidden = false;
    imgFull.classList.add('openedElem');
}

function addProduct() {
    let value = 0;
    let type = this.dataset.btntype;
    if (getCookie(type + 'ProductIndex') != undefined) {
        value = getCookie(type + 'ProductIndex');
    }
    if (getCookie(type + 'Product') == undefined) {
        document.cookie = type + 'Product=' + this.dataset.productname + '; path=/; max-age=3600';
    } else {
        document.cookie = type + 'Product=' + getCookie(type + 'Product') + ', ' + this.dataset.productname + '; path=/; max-age=3600';
    }
    value++;
    document.cookie = type + 'ProductIndex=' + value + '; path=/; max-age=3600';
    checkCartWish();
    this.parentElement.classList.add('active__in' + type);
    this.removeEventListener('click', addProduct);
    this.addEventListener('click', deleteProduct);
    if (type == 'cart') {
        this.innerHTML = 'Убрать';
    } else this.innerHTML = 'Отменить';
}

function deleteProduct() {
    let type = this.dataset.btntype;
    let arrProduct = getCookie(type + 'Product').split(', ');
    for (let i = 0; i < arrProduct.length; i++) {
        if (this.dataset.productname == arrProduct[i]) {
            arrProduct.splice(i, 1);
        }
    }
    if (arrProduct.length == 0) {
        document.cookie = type + 'Product=; path=/; max-age=0';
        document.cookie = type + 'ProductIndex=; path=/; max-age=0';
    } else {
        document.cookie = type + 'ProductIndex=' + arrProduct.length + '; path=/; max-age=3600';
        document.cookie = type + 'Product=' + arrProduct.join(', ') + '; path=/; max-age=3600';
    }
    checkCartWish();
    this.parentElement.classList.remove('active__in' + type);
    this.removeEventListener('click', deleteProduct);
    this.addEventListener('click', addProduct);
    if (type == 'cart') {
        this.innerHTML = 'В корзину';
    } else this.innerHTML = 'В желаемое';
}