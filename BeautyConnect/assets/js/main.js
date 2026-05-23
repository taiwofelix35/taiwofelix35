document.addEventListener('DOMContentLoaded', function () {
    const salonSelect = document.getElementById('salon_id');
    const serviceSelect = document.getElementById('service_id');
    const dateInput = document.getElementById('appointment_date');
    const services = Array.isArray(window.beautyConnectServices) ? window.beautyConnectServices : [];

    if (!salonSelect || !serviceSelect) {
        return;
    }

    function renderServicesBySalon(salonId) {
        serviceSelect.innerHTML = '<option value="">Select service</option>';
        if (!salonId) {
            return;
        }

        const filtered = services.filter((service) => Number(service.salon_id) === Number(salonId));
        filtered.forEach((service) => {
            const option = document.createElement('option');
            option.value = service.id;
            option.textContent = `${service.name} - $${Number(service.price).toFixed(2)} (${service.duration_minutes} min)`;
            serviceSelect.appendChild(option);
        });
    }

    const preselectedSalon = salonSelect.dataset.selectedSalon || '';
    if (preselectedSalon) {
        salonSelect.value = preselectedSalon;
        renderServicesBySalon(preselectedSalon);
    }

    salonSelect.addEventListener('change', function () {
        renderServicesBySalon(this.value);
    });

    if (dateInput) {
        const today = new Date();
        const minDate = today.toISOString().split('T')[0];
        dateInput.min = minDate;
    }
});
