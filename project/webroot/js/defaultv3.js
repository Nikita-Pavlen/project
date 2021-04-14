let incart = document.querySelectorAll('.incart__btn');
let inwish = document.querySelectorAll('.inwish__btn');

for (let i = 0; i < incart.length; i++) {
    if (incart[i].querySelector('.active__incart') == null) {
        incart[i].addEventListener('click', addProduct);
    } else incart[i].addEventListener('click', deleteProduct);
    if (inwish[i].querySelector('.active__inwish') == null) {
        inwish[i].addEventListener('click', addProduct);
    } else inwish[i].addEventListener('click', deleteProduct);
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
    this.firstChild.classList.add('active__in' + type);
    this.removeEventListener('click', addProduct);
    this.addEventListener('click', deleteProduct);
    if (type == 'cart') {
        this.firstChild.innerHTML = 'Убрать';
    } else this.firstChild.innerHTML = 'Отменить';
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
    this.firstChild.classList.remove('active__in' + type);
    this.removeEventListener('click', deleteProduct);
    this.addEventListener('click', addProduct);
    if (type == 'cart') {
        this.firstChild.innerHTML = 'В корзину';
    } else this.firstChild.innerHTML = 'В желаемое';
}