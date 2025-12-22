<template>
  <div class="container">
    <header class="header">
      <div class="header-left">
        <button @click="prevDay" class="header-button">
          <span class="material-icons">chevron_left</span>
        </button>
        <div class="date-container">
          <h1 @click="toggleCalendarPopup" class="date-heading">
            {{ formattedCurrentDate }}
          </h1>
          <div v-show="isCalendarPopupVisible" class="calendar-popup" @click.stop>
            <div class="popup-header">
              <button @click="calendarPrevMonth" class="popup-nav-button">
                <span class="material-icons">chevron_left</span>
              </button>
              <div class="popup-month-year">{{ calendarMonthYear }}</div>
              <button @click="calendarNextMonth" class="popup-nav-button">
                <span class="material-icons">chevron_right</span>
              </button>
            </div>
            <div class="popup-days-grid">
              <div
                v-for="dayName in ['S', 'M', 'T', 'W', 'T', 'F', 'S']"
                :key="dayName"
                class="day-name"
              >
                {{ dayName }}
              </div>
              <div v-for="(day, index) in calendarDays" :key="index">
                <button
                  v-if="day.date"
                  @click="selectDate(day.date)"
                  class="day-button"
                  :class="{ 'selected-day': day.isCurrent }"
                >
                  {{ day.day }}
                </button>
              </div>
            </div>
          </div>
        </div>
        <button @click="nextDay" class="header-button">
          <span class="material-icons">chevron_right</span>
        </button>
        <div class="nav-buttons">
          <button
            @click="prevWeek"
            class="nav-btn"
            :class="{ active: activeNav === 'prev-week' }"
          >
            -1W
          </button>
          <button
            @click="goToToday"
            class="nav-btn"
            :class="{ active: activeNav === 'today' }"
          >
            Today
          </button>
          <button
            @click="nextWeek"
            class="nav-btn"
            :class="{ active: activeNav === 'next-week' }"
          >
            +1W
          </button>
          <button
            @click="nextMonth"
            class="nav-btn"
            :class="{ active: activeNav === 'next-month' }"
          >
            +1M
          </button>
        </div>
      </div>
    </header>

    <div class="calendar-wrapper">
      <div class="calendar-grid" @dragover.prevent @drop="onDrop">
        <div class="grid-header-placeholder"></div>
        <div
          v-for="practitioner in practitioners"
          :key="practitioner"
          class="grid-header"
        >
          {{ practitioner }}
        </div>

        <template v-for="timeSlot in timeSlots" :key="timeSlot.time">
          <div class="time-label" :style="{ gridRow: timeSlot.gridRow }">
            {{ timeSlot.label }}
          </div>
          <div
            v-for="practitioner in practitioners"
            :key="practitioner"
            class="time-slot"
            :class="{ 'dashed-border': timeSlot.isHalfHour }"
            :style="{
              gridRow: timeSlot.gridRow,
              gridColumn: getPractitionerColumn(practitioner),
            }"
            :data-time="timeSlot.time"
            :data-practitioner="practitioner"
          ></div>
        </template>

        <div
          v-for="appt in appointmentsForCurrentDate"
          :key="appt.id"
          class="appointment"
          :class="[typeClasses[appt.type], { 'is-dragging': draggedItemId === appt.id }]"
          :style="getAppointmentStyle(appt)"
          draggable="true"
          @dragstart="onDragStart(appt, $event)"
          @dragend="onDragEnd"
        >
          <div>
            <div class="font-bold">{{ appt.title }}</div>
            <div class="text-xs">{{ appt.subtitle }}</div>
            <div class="text-xs mt-1">{{ appt.details }}</div>
          </div>
          <div class="icon-footer">
            <span
              v-if="appt.type === 'private-only'"
              class="material-icons text-red-500 text-base"
              >favorite</span
            >
            <span
              v-if="appt.type === 'private-only'"
              class="material-icons text-green-500 text-base"
              >attach_money</span
            >
            <span
              v-if="appt.type === 'private-only-light'"
              class="material-icons text-purple-500 text-base"
              >check_box_outline_blank</span
            >
            <span
              v-if="appt.confirmed"
              class="material-icons text-base"
              :class="appt.type === 'zoom' ? 'text-white' : 'text-blue-600'"
              >check_circle</span
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";

const currentDate = ref(new Date(2020, 7, 27));
const calendarPopupDate = ref(new Date(2020, 7, 27));
const isCalendarPopupVisible = ref(false);
const activeNav = ref("");
const draggedItemId = ref(null);

const allAppointments = ref({
  "2020-08-27": [
    {
      id: 1,
      practitioner: "Rob Perkowski",
      start: 9,
      duration: 30,
      title: "Emergency",
      type: "emergency",
    },
    {
      id: 2,
      practitioner: "Sam Clarke",
      start: 9,
      duration: 60,
      title: "David Rutherford",
      subtitle: "Private Patients only",
      details: "Appointment - Crown Preparation",
      type: "private-only",
    },
    {
      id: 3,
      practitioner: "Carl Young",
      start: 9.5,
      duration: 60,
      title: "Helena Nichols",
      subtitle: "Private Patients only",
      details: "Check-up, Scale & Polish, White Filling (Composite) book asap A.C.D",
      type: "private-only-light",
    },
    {
      id: 4,
      practitioner: "David Rutherford",
      start: 12,
      duration: 60,
      title: "Other",
      subtitle: "Lunch",
      type: "other",
    },
    {
      id: 5,
      practitioner: "James Harker",
      start: 9,
      duration: 90,
      title: "Private Patients only",
      type: "private-only",
    },
    {
      id: 6,
      practitioner: "David Rutherford",
      start: 14,
      duration: 30,
      title: "James Darlings",
      details: "Exam",
      type: "exam",
      confirmed: true,
    },
    {
      id: 7,
      practitioner: "Sam Clarke",
      start: 12.5,
      duration: 90,
      title: "NHS Patients",
      type: "nhs",
    },
    {
      id: 8,
      practitioner: "Sam Clarke",
      start: 16.5,
      duration: 30,
      type: "blocked",
    },
    {
      id: 9,
      practitioner: "James Harker",
      start: 14,
      duration: 150,
      title: "NHS Patients only",
      type: "nhs-light",
    },
    {
      id: 10,
      practitioner: "David Rutherford",
      start: 13.5,
      duration: 30,
      title: "Rayne Carlsson",
      details: "Zoom",
      type: "zoom",
      confirmed: true,
    },
    {
      id: 11,
      practitioner: "David Rutherford",
      start: 12,
      duration: 30,
      title: "Blocked",
      type: "blocked",
    },
    {
      id: 12,
      practitioner: "James Harker",
      start: 12,
      duration: 30,
      title: "Blocked",
      type: "blocked",
    },
  ],
  "2020-08-20": [
    {
      id: 13,
      practitioner: "Rob Perkowski",
      start: 10,
      duration: 60,
      title: "New Patient Exam",
      type: "exam",
    },
    {
      id: 14,
      practitioner: "Carl Young",
      start: 11,
      duration: 30,
      title: "Follow-up",
      type: "private-only-light",
    },
  ],
  "2020-08-28": [
    {
      id: 15,
      practitioner: "Sam Clarke",
      start: 14,
      duration: 60,
      title: "Consultation",
      type: "private-only",
    },
    {
      id: 16,
      practitioner: "David Rutherford",
      start: 10,
      duration: 90,
      title: "Surgery",
      type: "emergency",
    },
  ],
  "2020-09-03": [
    {
      id: 17,
      practitioner: "Sam Clarke",
      start: 11.5,
      duration: 30,
      title: "Check-up",
      type: "exam",
    },
    {
      id: 18,
      practitioner: "James Harker",
      start: 15,
      duration: 60,
      title: "Cleaning",
      type: "nhs",
    },
  ],
  "2020-09-27": [
    {
      id: 19,
      practitioner: "Carl Young",
      start: 10,
      duration: 90,
      title: "Implant Consultation",
      type: "private-only",
    },
    {
      id: 20,
      practitioner: "David Rutherford",
      start: 14.5,
      duration: 30,
      title: "X-Ray",
      type: "exam",
    },
  ],
});

const practitionerCols = {
  "Rob Perkowski": 2,
  "Sam Clarke": 3,
  "Carl Young": 4,
  "David Rutherford": 5,
  "James Harker": 6,
};
const practitioners = Object.keys(practitionerCols);

const startTime = 9;
const endTime = 17.5;

const typeClasses = {
  emergency: "bg-red-500 text-white",
  "private-only": "bg-yellow-200 border border-yellow-300 text-yellow-800",
  "private-only-light": "bg-purple-100 border border-purple-200 text-purple-800",
  other: "bg-gray-400 text-white",
  exam: "bg-blue-200 border border-blue-300 text-blue-800",
  nhs: "bg-green-200 border border-green-300 text-green-800",
  "nhs-light": "bg-cyan-200 border border-cyan-300 text-cyan-800",
  blocked: "bg-red-300 opacity-50",
  zoom: "bg-green-400 text-white",
};

const formatDate = (date) =>
  date
    .toLocaleDateString("en-GB", {
      weekday: "short",
      day: "2-digit",
      month: "short",
      year: "numeric",
    })
    .replace(/,/g, "");

const getDateKey = (date) =>
  `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(
    date.getDate()
  ).padStart(2, "0")}`;

const formattedCurrentDate = computed(() => formatDate(currentDate.value));
const appointmentsForCurrentDate = computed(
  () => allAppointments.value[getDateKey(currentDate.value)] || []
);

const updateDate = (newDate, nav) => {
  currentDate.value = newDate;
  activeNav.value = nav || "";
};

const prevDay = () =>
  updateDate(new Date(currentDate.value.setDate(currentDate.value.getDate() - 1)));
const nextDay = () =>
  updateDate(new Date(currentDate.value.setDate(currentDate.value.getDate() + 1)));
const goToToday = () => updateDate(new Date(), "today");
const prevWeek = () =>
  updateDate(
    new Date(currentDate.value.setDate(currentDate.value.getDate() - 7)),
    "prev-week"
  );
const nextWeek = () =>
  updateDate(
    new Date(currentDate.value.setDate(currentDate.value.getDate() + 7)),
    "next-week"
  );
const nextMonth = () =>
  updateDate(
    new Date(currentDate.value.setMonth(currentDate.value.getMonth() + 1)),
    "next-month"
  );

const toggleCalendarPopup = () => {
  isCalendarPopupVisible.value = !isCalendarPopupVisible.value;
  if (isCalendarPopupVisible.value) {
    calendarPopupDate.value = new Date(currentDate.value);
  }
};

const calendarMonthYear = computed(() =>
  calendarPopupDate.value.toLocaleString("default", {
    month: "long",
    year: "numeric",
  })
);

const calendarPrevMonth = () =>
  (calendarPopupDate.value = new Date(
    calendarPopupDate.value.setMonth(calendarPopupDate.value.getMonth() - 1)
  ));
const calendarNextMonth = () =>
  (calendarPopupDate.value = new Date(
    calendarPopupDate.value.setMonth(calendarPopupDate.value.getMonth() + 1)
  ));

const calendarDays = computed(() => {
  const date = calendarPopupDate.value;
  const year = date.getFullYear();
  const month = date.getMonth();
  const firstDayOfWeek = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const days = Array(firstDayOfWeek)
    .fill({})
    .concat(
      Array.from({ length: daysInMonth }, (_, i) => {
        const day = i + 1;
        const d = new Date(year, month, day);
        return {
          day,
          date: d,
          isCurrent: d.toDateString() === currentDate.value.toDateString(),
        };
      })
    );
  return days;
});

const selectDate = (date) => {
  updateDate(date);
  isCalendarPopupVisible.value = false;
};

const timeSlots = computed(() => {
  const slots = [];
  for (let i = startTime; i <= endTime; i += 0.5) {
    const hour = Math.floor(i);
    const minutes = (i % 1) * 60;
    slots.push({
      time: i,
      label:
        i % 1 === 0
          ? `${String(hour).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`
          : "",
      gridRow: `${Math.round((i - startTime) * 2) + 2} / span 2`,
      isHalfHour: i % 1 !== 0,
    });
  }
  return slots;
});

const getPractitionerColumn = (practitioner) => practitionerCols[practitioner];

const getAppointmentStyle = (appt) => {
  const startRow = (appt.start - startTime) * 2 + 2;
  const durationRows = (appt.duration / 60) * 2;
  return {
    gridColumn: practitionerCols[appt.practitioner],
    gridRow: `${startRow} / span ${durationRows}`,
    margin: "2px 4px",
  };
};

const onDragStart = (item, event) => {
  draggedItemId.value = item.id;
  event.dataTransfer.effectAllowed = "move";
  event.dataTransfer.setData("text/plain", item.id.toString());
};

const onDragEnd = () => {
  draggedItemId.value = null;
};

const onDrop = (event) => {
  event.preventDefault();
  const apptId = parseInt(event.dataTransfer.getData("text/plain"));
  const targetSlot = event.target.closest(".time-slot");

  if (apptId && targetSlot) {
    const newTime = parseFloat(targetSlot.dataset.time);
    const newPractitioner = targetSlot.dataset.practitioner;
    const currentKey = getDateKey(currentDate.value);

    let appointment = null;
    let originalDateKey = null;
    for (const key in allAppointments.value) {
      const foundAppt = allAppointments.value[key].find((a) => a.id === apptId);
      if (foundAppt) {
        appointment = foundAppt;
        originalDateKey = key;
        break;
      }
    }

    if (appointment) {
      if (originalDateKey !== currentKey) {
        const originalAppointments = allAppointments.value[originalDateKey];
        const apptIndex = originalAppointments.findIndex((a) => a.id === apptId);
        if (apptIndex > -1) {
          originalAppointments.splice(apptIndex, 1);
        }
        if (!allAppointments.value[currentKey]) {
          allAppointments.value[currentKey] = [];
        }
        allAppointments.value[currentKey].push(appointment);
      }
      appointment.start = newTime;
      appointment.practitioner = newPractitioner;
    }
  }
};

const handleClickOutside = (event) => {
  const popup = document.querySelector(".calendar-popup");
  const dateHeading = document.querySelector(".date-heading");
  if (
    isCalendarPopupVisible.value &&
    popup &&
    !popup.contains(event.target) &&
    dateHeading &&
    !dateHeading.contains(event.target)
  ) {
    isCalendarPopupVisible.value = false;
  }
};

onMounted(() => {
  const todayKey = getDateKey(new Date());
  const currentKey = getDateKey(currentDate.value);
  if (todayKey === currentKey) {
    activeNav.value = "today";
  }

  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});

defineExpose({
  practitioners,
});
</script>

<style scoped>
/* All the CSS from your original code related to the scheduler goes here */
/* Base & Font Styles */
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

:root {
  --blue-500: #3b82f6;
}

/* Main Content Area */
.container {
  padding: 1rem;
}

@media (min-width: 768px) {
  .container {
    padding: 2rem;
  }
}

/* Header */
.header {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
  position: relative;
}

@media (min-width: 768px) {
  .header-left {
    margin-bottom: 0;
  }
}

.header-button {
  padding: 0.5rem;
  border-radius: 0.25rem;
  background: none;
  border: none;
  cursor: pointer;
}

.header-button:hover {
  background-color: #e5e7eb;
}

.header-button .material-icons {
  color: #4b5563;
}

.date-container {
  position: relative;
}

.date-heading {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1f2937;
  cursor: pointer;
}

.nav-buttons {
  display: flex;
  gap: 0.25rem;
  margin-left: 1rem;
}

.nav-btn {
  padding: 0.25rem 0.75rem;
  font-size: 0.875rem;
  color: #4b5563;
  background-color: white;
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
  cursor: pointer;
}

.nav-btn:hover {
  background-color: #f9fafb;
}

.nav-btn.active {
  background-color: #3b82f6;
  color: white;
  border-color: #3b82f6;
}

/* Calendar Popup */
.calendar-popup {
  position: absolute;
  top: 100%;
  margin-top: 0.5rem;
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  padding: 1rem;
  z-index: 10;
  width: 20rem;
}

.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.popup-nav-button {
  padding: 0.25rem;
  border-radius: 0.25rem;
  background: none;
  border: none;
  cursor: pointer;
}

.popup-nav-button:hover {
  background-color: #e5e7eb;
}

.popup-month-year {
  font-weight: 700;
}

.popup-days-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 0.25rem;
  text-align: center;
  justify-items: center;
}

.day-name {
  font-weight: 700;
  color: #6b7280;
  font-size: 0.75rem;
  width: 2rem;
  height: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.day-button {
  width: 2rem;
  height: 2rem;
  border-radius: 9999px;
  font-size: 0.875rem;
  background: none;
  border: none;
  cursor: pointer;
}

.day-button:hover {
  background-color: #e5e7eb;
}

.day-button.selected-day {
  background-color: #3b82f6;
  color: white;
}

/* Calendar Grid */
.calendar-wrapper {
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.calendar-grid {
  display: grid;
  grid-template-columns: 50px repeat(5, 1fr);
  grid-template-rows: auto;
  border-top: 1px solid #e5e7eb;
}

.grid-header {
  text-align: center;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #e5e7eb;
  border-left: 1px solid #e5e7eb;
  font-weight: 600;
}

.grid-header-placeholder {
  border-bottom: 1px solid #e5e7eb;
}

.time-label {
  text-align: right;
  padding-right: 0.5rem;
  font-size: 0.75rem;
  color: #6b7280;
  grid-column: 1;
}

.time-slot {
  height: 30px;
  border-bottom: 1px solid #e5e7eb;
  border-left: 1px solid #e5e7eb;
}

.dashed-border {
  border-bottom-style: dashed;
}

/* Appointment Styling */
.appointment {
  padding: 0.5rem;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  cursor: grab;
  transition: background-color 0.2s;
  color: #1f2937;
}

.appointment:active {
  cursor: grabbing;
  opacity: 0.8;
}

.is-dragging {
  opacity: 0.5;
  border: 2px dashed #4a90e2;
}

.font-bold {
  font-weight: 700;
}

.text-xs {
  font-size: 0.75rem;
  line-height: 1rem;
}

.mt-1 {
  margin-top: 0.25rem;
}

.icon-footer {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 0.25rem;
  margin-top: auto;
}

.text-base {
  font-size: 1rem;
}

.text-red-500 {
  color: #ef4444;
}

.text-green-500 {
  color: #22c55e;
}

.text-purple-500 {
  color: #a855f7;
}

.text-blue-600 {
  color: #2563eb;
}

.text-white {
  color: white;
}

.bg-red-500 {
  background-color: #ef4444;
}

.bg-yellow-200 {
  background-color: #fef08a;
}

.border-yellow-300 {
  border-color: #fde047;
}

.text-yellow-800 {
  color: #92400e;
}

.bg-purple-100 {
  background-color: #f3e8ff;
}

.border-purple-200 {
  border-color: #e9d5ff;
}

.text-purple-800 {
  color: #581c87;
}

.bg-gray-400 {
  background-color: #9ca3af;
}

.bg-blue-200 {
  background-color: #bfdbfe;
}

.border-blue-300 {
  border-color: #93c5fd;
}

.text-blue-800 {
  color: #1e40af;
}

.bg-green-200 {
  background-color: #bbf7d0;
}

.border-green-300 {
  border-color: #86efac;
}

.text-green-800 {
  color: #166534;
}

.bg-cyan-200 {
  background-color: #a5f3fc;
}

.border-cyan-300 {
  border-color: #67e8f9;
}

.text-cyan-800 {
  color: #155e75;
}

.bg-red-300 {
  background-color: #fca5a5;
}

.opacity-50 {
  opacity: 0.5;
}

.bg-green-400 {
  background-color: #4ade80;
}
</style>
