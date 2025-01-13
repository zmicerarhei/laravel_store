document.addEventListener('DOMContentLoaded', function () {
    const priceContainer = document.querySelector('.details_price');
    const serviceContainer = document.querySelector('.details_services'); // Корневой элемент для чекбоксов
    const serviceCheckboxes = document.querySelectorAll('.service_checkbox');

    // Инициализируем базовую цену
    let basePrice = parseFloat(priceContainer.getAttribute('data-base-price'));
    priceContainer.textContent = basePrice.toFixed(2); // Устанавливаем базовое значение

    // Пересчитываем общую цену
    const updateTotalPrice = () => {
        const totalServicePrice = Array.from(serviceCheckboxes).reduce((total, checkbox) => {
            return checkbox.checked ? total + parseFloat(checkbox.getAttribute('data-price')) : total;
        }, 0);

        // Обновляем цену с добавленными услугами
        const totalPrice = basePrice + totalServicePrice;
        priceContainer.textContent = totalPrice.toFixed(2);
    };

    // Добавление одного обработчика событий на контейнер
    serviceContainer.addEventListener('change', updateTotalPrice);
});