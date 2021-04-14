if (document.getElementById('add-new-product-form')) {
    let form = document.getElementById('add-new-product-form');

    for (let i = 0; i < form.elements.length - 1; i++) {
        form.elements[i].addEventListener('blur', checkArea);
    }

    let locker = [false,];

    function checkArea() {
        checkForm();
        if (this.value) {
            this.style.borderColor = 'green';
        } else this.style.borderColor = 'red';
    }

    function checkForm() {
        for (let i = 0; i < form.elements.length - 1; i++) {
            if (form.elements[i].value) {
                continue;
            } else {
                document.querySelector('.submit__btn').disabled = true;
                return;
            }
        }
        document.querySelector('.submit__btn').disabled = false;
    }
}