// Client-side form validation
document.addEventListener('DOMContentLoaded', () => {

    // Select reservation form
    const reservationForm = document.querySelector('form');

    if (reservationForm) {
        reservationForm.addEventListener('submit', (e) => {

            // Get hidden start datetime input
            const dateInput = reservationForm.querySelector(
                'input[name="start_datetime"]'
            );

            if (dateInput) {
                const selectedDate = new Date(dateInput.value);
                const now = new Date();

                // Prevent submitting past or current dates
                if (selectedDate <= now) {
                    alert('La fecha debe ser futura');
                    e.preventDefault();
                }
            }
        });
    }

});

