<template>
  <div class="appointments-container">
    <!-- Top Toolbar -->
    <div class="toolbar">
      <div class="toolbar-left">
        <button class="btn-primary" @click="openNewAppointment">
          <i class="fas fa-plus"></i>
          <span>New Appointment</span>
        </button>
        <div class="view-toggle">
          <button
            :class="{ active: viewMode === 'day' }"
            @click="viewMode = 'day'"
          >Day</button>
          <button
            :class="{ active: viewMode === 'week' }"
            @click="viewMode = 'week'"
          >Week</button>
        </div>
      </div>

      <div class="toolbar-center">
        <button @click="prevDay" class="nav-arrow">
          <i class="fas fa-chevron-left"></i>
        </button>
        <div class="date-picker" @click="toggleCalendarPopup">
          <span class="current-date">{{ formattedCurrentDate }}</span>
          <i class="fas fa-calendar-alt"></i>
        </div>
        <button @click="nextDay" class="nav-arrow">
          <i class="fas fa-chevron-right"></i>
        </button>
        <div class="quick-nav">
          <button @click="prevWeek" :class="{ active: activeNav === 'prev-week' }">-1W</button>
          <button @click="goToToday" :class="{ active: activeNav === 'today' }">Today</button>
          <button @click="nextWeek" :class="{ active: activeNav === 'next-week' }">+1W</button>
          <button @click="nextMonth" :class="{ active: activeNav === 'next-month' }">+1M</button>
        </div>
      </div>

      <div class="toolbar-right">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" v-model="searchQuery" placeholder="Search patient...">
        </div>
      </div>

      <!-- Calendar Popup -->
      <div v-show="isCalendarPopupVisible" class="calendar-popup" @click.stop>
        <div class="popup-header">
          <button @click="calendarPrevMonth" class="popup-nav-button">
            <i class="fas fa-chevron-left"></i>
          </button>
          <div class="popup-month-year">{{ calendarMonthYear }}</div>
          <button @click="calendarNextMonth" class="popup-nav-button">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
        <div class="popup-days-grid">
          <div v-for="dayName in ['S', 'M', 'T', 'W', 'T', 'F', 'S']" :key="dayName" class="day-name">
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

    <!-- Main Three-Zone Layout -->
    <div class="main-layout" :class="layoutClasses">
      <!-- Left Filters Panel -->
      <div class="filters-panel" :class="{ collapsed: isFiltersCollapsed }">
        <div class="panel-header">
          <span v-if="!isFiltersCollapsed">Filters</span>
          <button class="collapse-btn" @click="toggleFilters" :title="isFiltersCollapsed ? 'Expand filters' : 'Collapse filters'">
            <i class="fas" :class="isFiltersCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
          </button>
        </div>

        <div v-if="!isFiltersCollapsed" class="filters-content">
          <!-- Practitioners Filter -->
          <div class="filter-section">
            <div class="filter-title">
              <i class="fas fa-user-md"></i>
              <span>Practitioners</span>
            </div>
            <div class="filter-actions">
              <a href="#" @click.prevent="selectAllPractitioners">All</a>
              <a href="#" @click.prevent="clearAllPractitioners">None</a>
            </div>
            <div class="checkbox-list">
              <label v-for="prac in allPractitioners" :key="prac" class="checkbox-item">
                <input type="checkbox" :value="prac" v-model="selectedPractitioners">
                <span class="checkmark"></span>
                <span class="label-text">{{ getShortName(prac) }}</span>
              </label>
            </div>
          </div>

          <!-- Appointment Types Filter -->
          <div class="filter-section">
            <div class="filter-title">
              <i class="fas fa-palette"></i>
              <span>Appointment Types</span>
            </div>
            <div class="filter-actions">
              <a href="#" @click.prevent="selectAllTypes">All</a>
              <a href="#" @click.prevent="clearAllTypes">None</a>
            </div>
            <div class="checkbox-list">
              <label v-for="type in appointmentTypes" :key="type.id" class="checkbox-item">
                <input type="checkbox" :value="type.id" v-model="selectedTypes">
                <span class="checkmark"></span>
                <span class="color-dot" :style="{ background: type.color }"></span>
                <span class="label-text">{{ type.name }}</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Collapsed Icons -->
        <div v-else class="collapsed-icons">
          <button class="icon-btn" title="Practitioners" @click="toggleFilters">
            <i class="fas fa-user-md"></i>
          </button>
          <button class="icon-btn" title="Appointment Types" @click="toggleFilters">
            <i class="fas fa-palette"></i>
          </button>
        </div>
      </div>

      <!-- Calendar Grid -->
      <div class="calendar-wrapper">
        <div class="calendar-grid" @dragover.prevent @drop="onDrop" :style="gridStyle">
          <div class="grid-header-placeholder"></div>
          <div
            v-for="practitioner in filteredPractitioners"
            :key="practitioner"
            class="grid-header"
          >
            {{ getShortName(practitioner) }}
          </div>

          <template v-for="timeSlot in timeSlots" :key="timeSlot.time">
            <div class="time-label" :style="{ gridRow: timeSlot.gridRow }">
              {{ timeSlot.label }}
            </div>
            <div
              v-for="(practitioner, pIndex) in filteredPractitioners"
              :key="practitioner"
              class="time-slot"
              :class="{ 'dashed-border': timeSlot.isHalfHour }"
              :style="{
                gridRow: timeSlot.gridRow,
                gridColumn: pIndex + 2,
              }"
              :data-time="timeSlot.time"
              :data-practitioner="practitioner"
              @click="handleSlotClick(timeSlot.time, practitioner)"
            ></div>
          </template>

          <div
            v-for="appt in filteredAppointments"
            :key="appt.id"
            class="appointment"
            :class="[typeClasses[appt.type], { 'is-dragging': draggedItemId === appt.id }]"
            :style="getAppointmentStyle(appt)"
            draggable="true"
            @dragstart="onDragStart(appt, $event)"
            @dragend="onDragEnd"
          >
            <div class="appt-content">
              <div class="appt-title">{{ appt.title }}</div>
              <div v-if="appt.subtitle" class="appt-subtitle">{{ appt.subtitle }}</div>
              <div v-if="appt.details" class="appt-details">{{ appt.details }}</div>
            </div>
            <div class="appt-icons">
              <i v-if="appt.type === 'private-only'" class="fas fa-heart text-red"></i>
              <i v-if="appt.type === 'private-only'" class="fas fa-dollar-sign text-green"></i>
              <i v-if="appt.confirmed" class="fas fa-check-circle text-blue"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Waiting Room Panel -->
      <div class="waiting-panel" :class="{ collapsed: isWaitingCollapsed }">
        <div v-if="isWaitingCollapsed" class="collapsed-waiting">
          <button class="expand-btn" @click="toggleWaiting" title="Expand waiting room">
            <i class="fas fa-chevron-left"></i>
          </button>
          <div class="waiting-badge" :class="{ 'has-alert': hasOverduePatients }">
            {{ waitingCount }}
          </div>
          <span class="vertical-text">Waiting</span>
        </div>
        <div v-else class="waiting-content">
          <WaitingRoomPanel
            :is-collapsed="isWaitingCollapsed"
            @toggle-collapse="toggleWaiting"
            @update:waiting-count="updateWaitingCount"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from "vue";
import WaitingRoomPanel from './Components/WaitingRoomPanel.vue';

// Panel collapse states - load from localStorage
const isFiltersCollapsed = ref(localStorage.getItem('appt-filters-collapsed') === 'true');
const isWaitingCollapsed = ref(localStorage.getItem('appt-waiting-collapsed') === 'true');

// View mode
const viewMode = ref('day');
const searchQuery = ref('');

// Waiting room data
const waitingCount = ref(4);
const hasOverduePatients = ref(true);

// Calendar state
const currentDate = ref(new Date(2020, 7, 27));
const calendarPopupDate = ref(new Date(2020, 7, 27));
const isCalendarPopupVisible = ref(false);
const activeNav = ref("");
const draggedItemId = ref(null);

// All practitioners
const allPractitioners = ref([
  "Rob Perkowski",
  "Sam Clarke",
  "Carl Young",
  "David Rutherford",
  "James Harker",
]);

// Selected practitioners (all selected by default)
const selectedPractitioners = ref([...allPractitioners.value]);

// Appointment types with colors
const appointmentTypes = ref([
  { id: 'emergency', name: 'Emergency', color: '#ef4444' },
  { id: 'private-only', name: 'Private', color: '#fef08a' },
  { id: 'private-only-light', name: 'Private (Light)', color: '#f3e8ff' },
  { id: 'nhs', name: 'NHS', color: '#bbf7d0' },
  { id: 'nhs-light', name: 'NHS (Light)', color: '#a5f3fc' },
  { id: 'exam', name: 'Exam', color: '#bfdbfe' },
  { id: 'zoom', name: 'Zoom', color: '#4ade80' },
  { id: 'blocked', name: 'Blocked', color: '#fca5a5' },
  { id: 'other', name: 'Other', color: '#9ca3af' },
]);

// Selected types (all selected by default)
const selectedTypes = ref(appointmentTypes.value.map(t => t.id));

// Appointments data
const allAppointments = ref({
  "2020-08-27": [
    { id: 1, practitioner: "Rob Perkowski", start: 9, duration: 30, title: "Emergency", type: "emergency" },
    { id: 2, practitioner: "Sam Clarke", start: 9, duration: 60, title: "David Rutherford", subtitle: "Private Patients only", details: "Appointment - Crown Preparation", type: "private-only" },
    { id: 3, practitioner: "Carl Young", start: 9.5, duration: 60, title: "Helena Nichols", subtitle: "Private Patients only", details: "Check-up, Scale & Polish, White Filling", type: "private-only-light" },
    { id: 4, practitioner: "David Rutherford", start: 12, duration: 60, title: "Other", subtitle: "Lunch", type: "other" },
    { id: 5, practitioner: "James Harker", start: 9, duration: 90, title: "Private Patients only", type: "private-only" },
    { id: 6, practitioner: "David Rutherford", start: 14, duration: 30, title: "James Darlings", details: "Exam", type: "exam", confirmed: true },
    { id: 7, practitioner: "Sam Clarke", start: 12.5, duration: 90, title: "NHS Patients", type: "nhs" },
    { id: 8, practitioner: "Sam Clarke", start: 16.5, duration: 30, type: "blocked" },
    { id: 9, practitioner: "James Harker", start: 14, duration: 150, title: "NHS Patients only", type: "nhs-light" },
    { id: 10, practitioner: "David Rutherford", start: 13.5, duration: 30, title: "Rayne Carlsson", details: "Zoom", type: "zoom", confirmed: true },
    { id: 11, practitioner: "David Rutherford", start: 12, duration: 30, title: "Blocked", type: "blocked" },
    { id: 12, practitioner: "James Harker", start: 12, duration: 30, title: "Blocked", type: "blocked" },
  ],
  "2020-08-20": [
    { id: 13, practitioner: "Rob Perkowski", start: 10, duration: 60, title: "New Patient Exam", type: "exam" },
    { id: 14, practitioner: "Carl Young", start: 11, duration: 30, title: "Follow-up", type: "private-only-light" },
  ],
  "2020-08-28": [
    { id: 15, practitioner: "Sam Clarke", start: 14, duration: 60, title: "Consultation", type: "private-only" },
    { id: 16, practitioner: "David Rutherford", start: 10, duration: 90, title: "Surgery", type: "emergency" },
  ],
});

const startTime = 9;
const endTime = 17.5;

const typeClasses = {
  emergency: "type-emergency",
  "private-only": "type-private",
  "private-only-light": "type-private-light",
  other: "type-other",
  exam: "type-exam",
  nhs: "type-nhs",
  "nhs-light": "type-nhs-light",
  blocked: "type-blocked",
  zoom: "type-zoom",
};

// Computed properties
const layoutClasses = computed(() => ({
  'filters-collapsed': isFiltersCollapsed.value,
  'waiting-collapsed': isWaitingCollapsed.value,
}));

const filteredPractitioners = computed(() => {
  return allPractitioners.value.filter(p => selectedPractitioners.value.includes(p));
});

const gridStyle = computed(() => {
  const cols = filteredPractitioners.value.length;
  return {
    gridTemplateColumns: `45px repeat(${cols}, minmax(120px, 1fr))`,
  };
});

const formatDate = (date) =>
  date.toLocaleDateString("en-GB", {
    weekday: "short",
    day: "2-digit",
    month: "short",
    year: "numeric",
  }).replace(/,/g, "");

const getDateKey = (date) =>
  `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;

const formattedCurrentDate = computed(() => formatDate(currentDate.value));

const appointmentsForCurrentDate = computed(
  () => allAppointments.value[getDateKey(currentDate.value)] || []
);

const filteredAppointments = computed(() => {
  return appointmentsForCurrentDate.value.filter(appt => {
    const practitionerMatch = selectedPractitioners.value.includes(appt.practitioner);
    const typeMatch = selectedTypes.value.includes(appt.type);
    const searchMatch = !searchQuery.value ||
      (appt.title && appt.title.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
      (appt.details && appt.details.toLowerCase().includes(searchQuery.value.toLowerCase()));
    return practitionerMatch && typeMatch && searchMatch;
  });
});

const timeSlots = computed(() => {
  const slots = [];
  for (let i = startTime; i <= endTime; i += 0.5) {
    const hour = Math.floor(i);
    const minutes = (i % 1) * 60;
    slots.push({
      time: i,
      label: i % 1 === 0 ? `${String(hour).padStart(2, "0")}:${String(minutes).padStart(2, "0")}` : "",
      gridRow: `${Math.round((i - startTime) * 2) + 2} / span 2`,
      isHalfHour: i % 1 !== 0,
    });
  }
  return slots;
});

const calendarMonthYear = computed(() =>
  calendarPopupDate.value.toLocaleString("default", { month: "long", year: "numeric" })
);

const calendarDays = computed(() => {
  const date = calendarPopupDate.value;
  const year = date.getFullYear();
  const month = date.getMonth();
  const firstDayOfWeek = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const days = Array(firstDayOfWeek).fill({}).concat(
    Array.from({ length: daysInMonth }, (_, i) => {
      const day = i + 1;
      const d = new Date(year, month, day);
      return { day, date: d, isCurrent: d.toDateString() === currentDate.value.toDateString() };
    })
  );
  return days;
});

// Methods
const getShortName = (name) => {
  const parts = name.split(' ');
  if (parts.length >= 2) {
    return `${parts[0][0]}. ${parts[1]}`;
  }
  return name;
};

const toggleFilters = () => {
  isFiltersCollapsed.value = !isFiltersCollapsed.value;
  localStorage.setItem('appt-filters-collapsed', isFiltersCollapsed.value);
};

const toggleWaiting = () => {
  isWaitingCollapsed.value = !isWaitingCollapsed.value;
  localStorage.setItem('appt-waiting-collapsed', isWaitingCollapsed.value);
};

const selectAllPractitioners = () => {
  selectedPractitioners.value = [...allPractitioners.value];
};

const clearAllPractitioners = () => {
  selectedPractitioners.value = [];
};

const selectAllTypes = () => {
  selectedTypes.value = appointmentTypes.value.map(t => t.id);
};

const clearAllTypes = () => {
  selectedTypes.value = [];
};

const openNewAppointment = () => {
  // Emit event or open modal
  console.log('Open new appointment modal');
};

const handleSlotClick = (time, practitioner) => {
  console.log('Create appointment at', time, 'with', practitioner);
};

const updateWaitingCount = (count) => {
  waitingCount.value = count;
};

// Date navigation
const updateDate = (newDate, nav) => {
  currentDate.value = newDate;
  activeNav.value = nav || "";
};

const prevDay = () => updateDate(new Date(currentDate.value.setDate(currentDate.value.getDate() - 1)));
const nextDay = () => updateDate(new Date(currentDate.value.setDate(currentDate.value.getDate() + 1)));
const goToToday = () => updateDate(new Date(), "today");
const prevWeek = () => updateDate(new Date(currentDate.value.setDate(currentDate.value.getDate() - 7)), "prev-week");
const nextWeek = () => updateDate(new Date(currentDate.value.setDate(currentDate.value.getDate() + 7)), "next-week");
const nextMonth = () => updateDate(new Date(currentDate.value.setMonth(currentDate.value.getMonth() + 1)), "next-month");

const toggleCalendarPopup = () => {
  isCalendarPopupVisible.value = !isCalendarPopupVisible.value;
  if (isCalendarPopupVisible.value) {
    calendarPopupDate.value = new Date(currentDate.value);
  }
};

const calendarPrevMonth = () => {
  calendarPopupDate.value = new Date(calendarPopupDate.value.setMonth(calendarPopupDate.value.getMonth() - 1));
};

const calendarNextMonth = () => {
  calendarPopupDate.value = new Date(calendarPopupDate.value.setMonth(calendarPopupDate.value.getMonth() + 1));
};

const selectDate = (date) => {
  updateDate(date);
  isCalendarPopupVisible.value = false;
};

// Appointment positioning
const getAppointmentStyle = (appt) => {
  const practitionerIndex = filteredPractitioners.value.indexOf(appt.practitioner);
  if (practitionerIndex === -1) return { display: 'none' };

  const startRow = (appt.start - startTime) * 2 + 2;
  const durationRows = (appt.duration / 60) * 2;
  return {
    gridColumn: practitionerIndex + 2,
    gridRow: `${startRow} / span ${durationRows}`,
  };
};

// Drag and drop
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
  const datePicker = document.querySelector(".date-picker");
  if (isCalendarPopupVisible.value && popup && !popup.contains(event.target) && datePicker && !datePicker.contains(event.target)) {
    isCalendarPopupVisible.value = false;
  }
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});

defineExpose({
  practitioners: allPractitioners,
});
</script>

<style scoped>
/* CSS Variables */
:root {
  --filters-width: 200px;
  --filters-collapsed: 44px;
  --waiting-width: 280px;
  --waiting-collapsed: 50px;
  --toolbar-height: 52px;
  --slot-height: 28px;
}

/* Container */
.appointments-container {
  display: flex;
  flex-direction: column;
  height: calc(100vh - 80px);
  background: #f3f5f7;
  padding: 12px;
  gap: 12px;
}

/* Toolbar */
.toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: white;
  padding: 10px 16px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  gap: 16px;
  flex-wrap: wrap;
  position: relative;
}

.toolbar-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.toolbar-center {
  display: flex;
  align-items: center;
  gap: 8px;
}

.toolbar-right {
  display: flex;
  align-items: center;
  gap: 12px;
}

.btn-primary {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-primary:hover {
  background: #4338ca;
}

.btn-primary i {
  font-size: 12px;
}

.view-toggle {
  display: flex;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  overflow: hidden;
}

.view-toggle button {
  padding: 6px 12px;
  background: white;
  border: none;
  font-size: 12px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s;
}

.view-toggle button:not(:last-child) {
  border-right: 1px solid #e5e7eb;
}

.view-toggle button.active {
  background: #4f46e5;
  color: white;
}

.nav-arrow {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  cursor: pointer;
  color: #6b7280;
  transition: all 0.2s;
}

.nav-arrow:hover {
  background: #f9fafb;
  border-color: #d1d5db;
}

.date-picker {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 12px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
}

.date-picker:hover {
  border-color: #4f46e5;
}

.current-date {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
}

.date-picker i {
  color: #6b7280;
  font-size: 12px;
}

.quick-nav {
  display: flex;
  gap: 4px;
}

.quick-nav button {
  padding: 6px 10px;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 4px;
  font-size: 11px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s;
}

.quick-nav button:hover {
  background: #f9fafb;
}

.quick-nav button.active {
  background: #4f46e5;
  color: white;
  border-color: #4f46e5;
}

.search-box {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 12px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  min-width: 180px;
}

.search-box i {
  color: #9ca3af;
  font-size: 12px;
}

.search-box input {
  border: none;
  background: none;
  outline: none;
  font-size: 13px;
  width: 100%;
  color: #1f2937;
}

.search-box input::placeholder {
  color: #9ca3af;
}

/* Calendar Popup */
.calendar-popup {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 8px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  padding: 16px;
  z-index: 100;
  width: 280px;
}

.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.popup-nav-button {
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: none;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: #6b7280;
}

.popup-nav-button:hover {
  background: #f3f4f6;
}

.popup-month-year {
  font-weight: 600;
  font-size: 14px;
  color: #1f2937;
}

.popup-days-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 4px;
}

.day-name {
  font-size: 11px;
  font-weight: 600;
  color: #9ca3af;
  text-align: center;
  padding: 4px;
}

.day-button {
  width: 32px;
  height: 32px;
  border: none;
  background: none;
  border-radius: 50%;
  font-size: 12px;
  cursor: pointer;
  color: #374151;
  transition: all 0.2s;
}

.day-button:hover {
  background: #f3f4f6;
}

.day-button.selected-day {
  background: #4f46e5;
  color: white;
}

/* Main Layout */
.main-layout {
  display: grid;
  grid-template-columns: 200px 1fr 280px;
  gap: 12px;
  flex: 1;
  min-height: 0;
  transition: grid-template-columns 0.3s ease;
}

.main-layout.filters-collapsed {
  grid-template-columns: 44px 1fr 280px;
}

.main-layout.waiting-collapsed {
  grid-template-columns: 200px 1fr 50px;
}

.main-layout.filters-collapsed.waiting-collapsed {
  grid-template-columns: 44px 1fr 50px;
}

/* Filters Panel */
.filters-panel {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  transition: width 0.3s ease;
}

.filters-panel .panel-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px;
  border-bottom: 1px solid #e5e7eb;
  font-weight: 600;
  font-size: 13px;
  color: #374151;
}

.filters-panel.collapsed .panel-header {
  justify-content: center;
  padding: 12px 8px;
}

.collapse-btn {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: #6b7280;
  transition: all 0.2s;
}

.collapse-btn:hover {
  background: #e5e7eb;
}

.filters-content {
  flex: 1;
  overflow-y: auto;
  padding: 12px;
}

.filter-section {
  margin-bottom: 16px;
}

.filter-section:last-child {
  margin-bottom: 0;
}

.filter-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
}

.filter-title i {
  color: #6b7280;
  font-size: 11px;
}

.filter-actions {
  display: flex;
  gap: 8px;
  margin-bottom: 8px;
}

.filter-actions a {
  font-size: 11px;
  color: #4f46e5;
  text-decoration: none;
}

.filter-actions a:hover {
  text-decoration: underline;
}

.checkbox-list {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  color: #374151;
  cursor: pointer;
  padding: 4px 0;
}

.checkbox-item input[type="checkbox"] {
  width: 14px;
  height: 14px;
  accent-color: #4f46e5;
  cursor: pointer;
}

.color-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  flex-shrink: 0;
}

.label-text {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.collapsed-icons {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 12px 8px;
}

.icon-btn {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  color: #6b7280;
  transition: all 0.2s;
}

.icon-btn:hover {
  background: #e5e7eb;
  color: #4f46e5;
}

/* Calendar Grid */
.calendar-wrapper {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  overflow: auto;
  min-height: 0;
}

.calendar-grid {
  display: grid;
  min-width: max-content;
}

.grid-header-placeholder {
  border-bottom: 1px solid #e5e7eb;
  position: sticky;
  top: 0;
  background: white;
  z-index: 2;
}

.grid-header {
  padding: 10px 8px;
  text-align: center;
  font-weight: 600;
  font-size: 12px;
  color: #374151;
  border-bottom: 1px solid #e5e7eb;
  border-left: 1px solid #e5e7eb;
  position: sticky;
  top: 0;
  background: white;
  z-index: 2;
  white-space: nowrap;
}

.time-label {
  padding: 0 8px;
  text-align: right;
  font-size: 11px;
  color: #9ca3af;
  display: flex;
  align-items: flex-start;
  justify-content: flex-end;
  padding-top: 2px;
}

.time-slot {
  height: 28px;
  border-bottom: 1px solid #e5e7eb;
  border-left: 1px solid #e5e7eb;
  cursor: pointer;
  transition: background 0.15s;
}

.time-slot:hover {
  background: #f0f9ff;
}

.time-slot.dashed-border {
  border-bottom-style: dashed;
  border-bottom-color: #e5e7eb;
}

/* Appointments */
.appointment {
  margin: 2px 4px;
  padding: 4px 6px;
  border-radius: 4px;
  font-size: 11px;
  cursor: grab;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.appointment:active {
  cursor: grabbing;
}

.appointment.is-dragging {
  opacity: 0.5;
}

.appt-content {
  overflow: hidden;
}

.appt-title {
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.appt-subtitle {
  font-size: 10px;
  opacity: 0.8;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.appt-details {
  font-size: 10px;
  opacity: 0.7;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-top: 2px;
}

.appt-icons {
  display: flex;
  gap: 4px;
  justify-content: flex-end;
  margin-top: auto;
}

.appt-icons i {
  font-size: 10px;
}

.text-red { color: #ef4444; }
.text-green { color: #22c55e; }
.text-blue { color: #3b82f6; }

/* Appointment Type Colors */
.type-emergency { background: #fecaca; color: #991b1b; border: 1px solid #fca5a5; }
.type-private { background: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
.type-private-light { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
.type-nhs { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.type-nhs-light { background: #cffafe; color: #155e75; border: 1px solid #a5f3fc; }
.type-exam { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
.type-zoom { background: #86efac; color: #14532d; border: 1px solid #4ade80; }
.type-blocked { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; opacity: 0.7; }
.type-other { background: #e5e7eb; color: #374151; border: 1px solid #d1d5db; }

/* Waiting Panel */
.waiting-panel {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: width 0.3s ease;
}

.waiting-panel.collapsed {
  width: 50px;
}

.collapsed-waiting {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 12px 8px;
  gap: 12px;
  height: 100%;
}

.expand-btn {
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: #6b7280;
  transition: all 0.2s;
}

.expand-btn:hover {
  background: #e5e7eb;
}

.waiting-badge {
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eff6ff;
  color: #1e40af;
  border-radius: 50%;
  font-size: 12px;
  font-weight: 600;
}

.waiting-badge.has-alert {
  background: #fef2f2;
  color: #991b1b;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}

.vertical-text {
  writing-mode: vertical-rl;
  text-orientation: mixed;
  font-size: 11px;
  font-weight: 500;
  color: #6b7280;
  letter-spacing: 1px;
}

.waiting-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* Responsive */
@media (max-width: 1200px) {
  .main-layout {
    grid-template-columns: 44px 1fr 50px;
  }

  .main-layout.filters-collapsed {
    grid-template-columns: 44px 1fr 50px;
  }

  .main-layout.waiting-collapsed {
    grid-template-columns: 44px 1fr 50px;
  }
}

@media (max-width: 768px) {
  .toolbar {
    flex-direction: column;
    align-items: stretch;
  }

  .toolbar-left,
  .toolbar-center,
  .toolbar-right {
    justify-content: center;
  }

  .main-layout {
    grid-template-columns: 1fr;
    grid-template-rows: auto 1fr auto;
  }

  .filters-panel,
  .waiting-panel {
    max-height: 200px;
  }
}
</style>
