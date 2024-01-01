for (const temp of document.querySelectorAll('.temperature_types')) {
    temp.addEventListener('click', function () {
        let type       = temp.getAttribute('data-type');
        let tempNumber = this.closest('.temperature_number').querySelector('.current_temperature');

        if (type === 'C') {
            this.classList.remove('text-white-50');
            this.nextElementSibling.classList.add('text-white-50');
            tempNumber.innerText = tempNumber.getAttribute('data-temp-celsius');
        } else {
            this.classList.remove('text-white-50');
            this.previousElementSibling.classList.add('text-white-50');
            tempNumber.innerText = tempNumber.getAttribute('data-temp-fahrenheit');
        }
    });
}
refreshTooltips();