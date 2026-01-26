// Fetch occupied time slots for a given court and date
async function fetchOccupiedSlots(courtId, date) {
    const response = await fetch(
        `?controller=reservation&action=availability&court_id=${courtId}&date=${date}`
    );
    return await response.json();
}

document.addEventListener('DOMContentLoaded', () => {

    // DOM references
    const calendarContainer = document.getElementById('calendarContainer');
    const slotsContainer = document.getElementById('slotsContainer');
    const timeSlots = document.getElementById('timeSlots');
    const startInput = document.getElementById('startDatetime');
    const durationSelect = document.querySelector('select[name="duration_minutes"]');
    const calendarTitle = document.getElementById('calendarTitle');
    const prevBtn = document.getElementById('prevMonth');
    const nextBtn = document.getElementById('nextMonth');

    // Exit if calendar is not present
    if (!calendarContainer) return;

    // Month and week names
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    const weekNames = ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"];

    // Current date state
    const now = new Date();
    let currentYear = now.getFullYear();
    let currentMonth = now.getMonth();
    let selectedDate = null;

    // Returns last day of a month
    function getLastDayOfMonth(y, m) {
        return new Date(y, m + 1, 0).getDate();
    }

    // Converts JS Sunday-based index to Monday-based
    function mondayIndex(d) {
        return (d + 6) % 7;
    }

    // Converts minutes to HH:MM format
    function toTime(m) {
        return `${String(Math.floor(m / 60)).padStart(2, "0")}:${String(m % 60).padStart(2, "0")}`;
    }

    // Builds calendar table for given month/year
    function buildCalendar(year, month) {
        calendarTitle.textContent =
            `${monthNames[month]} ${year}`;

        calendarContainer.innerHTML = '';

        const table = document.createElement('table');
        table.className = 'table table-bordered text-center';

        const thead = document.createElement('thead');
        const trh = document.createElement('tr');

        // Week header
        weekNames.forEach(d => {
            const th = document.createElement('th');
            th.textContent = d;
            trh.appendChild(th);
        });

        thead.appendChild(trh);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');

        const firstDay = mondayIndex(new Date(year, month, 1).getDay());
        const daysInMonth = getLastDayOfMonth(year, month);

        let day = 1;

        // Reset selection and slots
        selectedDate = null;
        slotsContainer.innerHTML = '';
        timeSlots.style.display = 'none';
        startInput.value = '';

        // Build calendar rows
        for (let w = 0; w < 6; w++) {
            const tr = document.createElement('tr');

            for (let d = 0; d < 7; d++) {
                const td = document.createElement('td');
                const index = w * 7 + d;

                if (index < firstDay || day > daysInMonth) {
                    td.textContent = '';
                } else {
                    td.textContent = day;
                    td.classList.add('calendar-day');

                    const date = new Date(year, month, day);

                    // Disable past dates
                    if (date < new Date().setHours(0, 0, 0, 0)) {
                        td.classList.add('text-muted');
                    } else {
                        td.addEventListener('click', () => selectDay(date, td));
                    }

                    day++;
                }
                tr.appendChild(td);
            }

            tbody.appendChild(tr);
            if (day > daysInMonth) break;
        }

        table.appendChild(tbody);
        calendarContainer.appendChild(table);
    }

    // Month navigation buttons
    if (prevBtn && nextBtn) {

        prevBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            buildCalendar(currentYear, currentMonth);
        });

        nextBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            buildCalendar(currentYear, currentMonth);
        });
    }

    // Handles day selection
    function selectDay(date, td) {
        selectedDate = date;
        startInput.value = '';

        document.querySelectorAll('.calendar-day')
            .forEach(el => el.classList.remove('table-primary'));

        td.classList.add('table-primary');

        buildSlots();
    }

    // Builds available time slots for selected date
    async function buildSlots() {
        slotsContainer.innerHTML = '';
        timeSlots.style.display = 'block';
        startInput.value = '';

        const courtSelect = document.querySelector('select[name="court_id"]');
        const courtId = courtSelect.value;

        // Validate required data
        if (!courtId || !selectedDate) {
            slotsContainer.innerHTML =
                '<div class="text-muted">Selecciona una pista y un día</div>';
            return;
        }

        const duration = parseInt(durationSelect.value, 10);

        const y = selectedDate.getFullYear();
        const m = String(selectedDate.getMonth() + 1).padStart(2, '0');
        const d = String(selectedDate.getDate()).padStart(2, '0');
        const dateStr = `${y}-${m}-${d}`;

        // Fetch occupied slots from server
        const occupied = await fetchOccupiedSlots(courtId, dateStr);

        let minutes = 8 * 60; // Start time: 08:00
        const end = 23 * 60;  // End time: 23:00

        // Generate slots based on duration
        while (minutes + duration <= end) {
            const slotStart = minutes;
            const slotEnd = slotStart + duration;

            // Check overlapping reservations
            const isOccupied = occupied.some(r => {
                const start = new Date(r.start_datetime);
                const end = new Date(
                    start.getTime() + r.duration_minutes * 60 * 60 * 1000
                );

                const slotStartDate =
                    new Date(`${dateStr}T${toTime(slotStart)}:00`);
                const slotEndDate =
                    new Date(`${dateStr}T${toTime(slotEnd)}:00`);

                return slotStartDate < end && slotEndDate > start;
            });

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent =
                `${toTime(slotStart)} - ${toTime(slotEnd)}`;

            // Disable occupied slots
            btn.disabled = isOccupied;
            btn.className = isOccupied
                ? 'btn btn-sm btn-outline-secondary'
                : 'btn btn-sm btn-outline-success';

            if (isOccupied) {
                btn.title = 'Horario no disponible';
            } else {
                // Select slot and set hidden datetime value
                btn.addEventListener('click', () => {
                    document.querySelectorAll('#slotsContainer button')
                        .forEach(b => b.classList.remove('btn-success'));

                    btn.classList.add('btn-success');
                    startInput.value =
                        `${dateStr}T${toTime(slotStart)}:00`;
                });
            }

            slotsContainer.appendChild(btn);

            minutes += duration;
        }
    }

    // Rebuild slots when duration changes
    durationSelect.addEventListener('change', () => {
        if (selectedDate) buildSlots();
    });

    // Initial calendar render
    buildCalendar(currentYear, currentMonth);
});

