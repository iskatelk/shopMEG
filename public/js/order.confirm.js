const getButton = document.querySelector('[name="btn-check"]');
getButton.addEventListener('click', confirmOder);

    function confirmOder() {
    const fio = document.getElementById('name');
    let el = document.getElementById('check-name');
        if (typeof el.innerText !== 'undefined') {
            // IE8-
            el.innerText = fio.value;
        } else {
            // Нормальные браузеры
            el.textContent = fio.value;
        }

    const city = document.getElementById('city');
    let elcity = document.getElementById('check-city');
        if (typeof elcity.innerText !== 'undefined') {
            // IE8-
            elcity.innerText = city.value;
        } else {
            // Нормальные браузеры
            elcity.textContent = city.value;
        }

    const phone = document.getElementById('phone');
    let elphone = document.getElementById('check-phone');
        if (typeof elcity.innerText !== 'undefined') {
            // IE8-
            elphone.innerText = phone.value;
        } else {
            // Нормальные браузеры
            elphone.textContent = phone.value;
        }

    const address = document.getElementById('address');
    let eladdress = document.getElementById('check-address');
        if (typeof elcity.innerText !== 'undefined') {
            // IE8-
            eladdress.innerText = address.value;
        } else {
            // Нормальные браузеры
            eladdress.textContent = address.value;
        }

    const mail = document.getElementById('mail');
    let elmail = document.getElementById('check-mail');
    if (typeof elcity.innerText !== 'undefined') {
            // IE8-
            elmail.innerText = mail.value;
            } else {
                // Нормальные браузеры
                elmail.textContent = mail.value;
            }

        var deliveryType;
        if (document.getElementById('delivery').value === 'ordinary') {
            deliveryType = 'Обычная доставка';
        } else {
            deliveryType = 'Экспресс доставка ($500.00)';
        }
        document.getElementById('check-delivery').textContent = deliveryType;

        var paymentType;
        if (document.getElementById('pay').value() === 'online') {
            paymentType = 'Онлайн картой';
        } else {
            paymentType = 'Онлайн со случайного чужого счета';
        }
        document.getElementById('check-pay').textContent = paymentType;
    }

