<template>
  <div class="flex flex-col h-[calc(100vh-80px)] bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 p-4 gap-4 font-[Poppins]">
    <!-- Top Toolbar -->
    <div class="flex items-center justify-between bg-white py-3 px-5 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] gap-4 flex-wrap relative border border-slate-100">
      <div class="flex items-center gap-4">
        <button 
          class="flex items-center gap-2 py-2.5 px-5 bg-gradient-to-r from-purple-accent to-secondary text-white border-none rounded-xl text-sm font-semibold cursor-pointer transition-all duration-300 hover:shadow-lg hover:shadow-purple-accent/30 hover:-translate-y-0.5 active:translate-y-0" 
          @click="openNewAppointment"
        >
          <i class="fas fa-plus text-xs"></i>
          <span>New Appointment</span>
        </button>
        <div class="flex bg-slate-100 rounded-xl p-1 shadow-inner">
          <button
            :class="['py-2 px-4 border-none text-sm cursor-pointer transition-all duration-200 rounded-lg font-medium', viewMode === 'day' ? 'bg-white text-purple-accent shadow-md' : 'bg-transparent text-slate-500 hover:text-purple-accent']"
            @click="viewMode = 'day'"
          >Day</button>
          <button
            :class="['py-2 px-4 border-none text-sm cursor-pointer transition-all duration-200 rounded-lg font-medium', viewMode === 'week' ? 'bg-white text-purple-accent shadow-md' : 'bg-transparent text-slate-500 hover:text-purple-accent']"
            @click="viewMode = 'week'"
          >Week</button>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <button @click="prevDay" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-200 rounded-xl cursor-pointer text-slate-500 transition-all duration-200 hover:bg-white hover:border-purple-accent hover:text-purple-accent hover:shadow-md">
          <i class="fas fa-chevron-left text-sm"></i>
        </button>
        <div 
          class="flex items-center gap-3 py-2.5 px-4 bg-gradient-to-r from-slate-50 to-white border border-slate-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-purple-accent hover:shadow-md group" 
          @click="toggleCalendarPopup"
        >
          <i class="fas fa-calendar-alt text-purple-accent text-sm group-hover:scale-110 transition-transform"></i>
          <span class="text-sm font-semibold text-slate-700">{{ formattedCurrentDate }}</span>
        </div>
        <button @click="nextDay" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-200 rounded-xl cursor-pointer text-slate-500 transition-all duration-200 hover:bg-white hover:border-purple-accent hover:text-purple-accent hover:shadow-md">
          <i class="fas fa-chevron-right text-sm"></i>
        </button>
        <div class="flex gap-1.5 ml-2">
          <button @click="prevWeek" :class="['py-2 px-3 border border-slate-200 rounded-lg text-xs cursor-pointer transition-all duration-200 font-medium', activeNav === 'prev-week' ? 'bg-purple-accent text-white border-purple-accent shadow-md' : 'bg-white text-slate-500 hover:border-purple-accent hover:text-purple-accent']">-1W</button>
          <button @click="goToToday" :class="['py-2 px-3 border border-slate-200 rounded-lg text-xs cursor-pointer transition-all duration-200 font-medium', activeNav === 'today' ? 'bg-purple-accent text-white border-purple-accent shadow-md' : 'bg-white text-slate-500 hover:border-purple-accent hover:text-purple-accent']">Today</button>
          <button @click="nextWeek" :class="['py-2 px-3 border border-slate-200 rounded-lg text-xs cursor-pointer transition-all duration-200 font-medium', activeNav === 'next-week' ? 'bg-purple-accent text-white border-purple-accent shadow-md' : 'bg-white text-slate-500 hover:border-purple-accent hover:text-purple-accent']">+1W</button>
          <button @click="nextMonth" :class="['py-2 px-3 border border-slate-200 rounded-lg text-xs cursor-pointer transition-all duration-200 font-medium', activeNav === 'next-month' ? 'bg-purple-accent text-white border-purple-accent shadow-md' : 'bg-white text-slate-500 hover:border-purple-accent hover:text-purple-accent']">+1M</button>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <div class="flex items-center gap-2 py-2.5 px-4 bg-slate-50 border border-slate-200 rounded-xl min-w-[200px] transition-all duration-200 focus-within:border-purple-accent focus-within:bg-white focus-within:shadow-md">
          <i class="fas fa-search text-slate-400 text-sm"></i>
          <input type="text" v-model="searchQuery" placeholder="Search patient..." class="border-none bg-transparent outline-none text-sm w-full text-slate-700 placeholder-slate-400 font-medium">
        </div>
      </div>

      <!-- Calendar Popup -->
      <div v-show="isCalendarPopupVisible" class="absolute top-full left-1/2 -translate-x-1/2 mt-3 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.12)] p-5 z-[100] w-[300px] border border-slate-100" @click.stop>
        <div class="flex justify-between items-center mb-4">
          <button @click="calendarPrevMonth" class="w-8 h-8 flex items-center justify-center bg-slate-50 border-none rounded-lg cursor-pointer text-slate-500 hover:bg-purple-accent hover:text-white transition-all duration-200">
            <i class="fas fa-chevron-left"></i>
          </button>
          <div class="font-semibold text-sm text-slate-800">{{ calendarMonthYear }}</div>
          <button @click="calendarNextMonth" class="w-8 h-8 flex items-center justify-center bg-slate-50 border-none rounded-lg cursor-pointer text-slate-500 hover:bg-purple-accent hover:text-white transition-all duration-200">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
        <div class="grid grid-cols-7 gap-1.5">
          <div v-for="dayName in ['S', 'M', 'T', 'W', 'T', 'F', 'S']" :key="dayName" class="text-xs font-semibold text-slate-400 text-center p-2">
            {{ dayName }}
          </div>
          <div v-for="(day, index) in calendarDays" :key="index">
            <button
              v-if="day.date"
              @click="selectDate(day.date)"
              :class="['w-9 h-9 border-none rounded-lg text-sm cursor-pointer transition-all duration-200', day.isCurrent ? 'bg-gradient-to-r from-purple-accent to-secondary text-white shadow-md' : 'bg-transparent text-slate-600 hover:bg-purple-accent/10 hover:text-purple-accent']"
            >
              {{ day.day }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Three-Zone Layout -->
    <div class="grid gap-4 flex-1 min-h-0 transition-all duration-300" :class="layoutClasses" :style="mainLayoutStyle">
      <!-- Left Filters Panel -->
      <div :class="['bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] flex flex-col overflow-hidden transition-all duration-300 border border-slate-100', { 'w-12': isFiltersCollapsed }]">
        <div :class="['flex items-center justify-between p-3.5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white', { 'justify-center px-2': isFiltersCollapsed }]">
          <span v-if="!isFiltersCollapsed" class="font-semibold text-sm text-slate-700 flex items-center gap-2">
            <i class="fas fa-filter text-purple-accent"></i>
            Filters
          </span>
          <button class="w-7 h-7 flex items-center justify-center bg-slate-100 border-none rounded-lg cursor-pointer text-slate-500 transition-all duration-200 hover:bg-purple-accent hover:text-white" @click="toggleFilters" :title="isFiltersCollapsed ? 'Expand filters' : 'Collapse filters'">
            <i class="fas text-xs" :class="isFiltersCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
          </button>
        </div>

        <div v-if="!isFiltersCollapsed" class="flex-1 overflow-y-auto p-4 scrollbar-thin">
          <!-- Practitioners Filter -->
          <div class="mb-5">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-600 mb-3 uppercase tracking-wider">
              <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-primary to-primary-dark flex items-center justify-center">
                <i class="fas fa-user-md text-white text-[10px]"></i>
              </div>
              <span>Practitioners</span>
            </div>
            <div class="flex gap-3 mb-3">
              <a href="#" @click.prevent="selectAllPractitioners" class="text-xs text-purple-accent no-underline hover:underline font-medium">Select All</a>
              <a href="#" @click.prevent="clearAllPractitioners" class="text-xs text-slate-400 no-underline hover:underline hover:text-slate-600 font-medium">Clear</a>
            </div>
            <div class="flex flex-col gap-1">
              <label v-for="prac in allPractitioners" :key="prac" class="flex items-center gap-3 text-sm text-slate-600 cursor-pointer py-2 px-2.5 rounded-lg transition-all duration-200 hover:bg-slate-50 group">
                <input type="checkbox" :value="prac" v-model="selectedPractitioners" class="w-4 h-4 accent-purple-accent cursor-pointer rounded">
                <span class="whitespace-nowrap overflow-hidden text-ellipsis group-hover:text-slate-800">{{ getShortName(prac) }}</span>
              </label>
            </div>
          </div>

          <!-- Appointment Types Filter -->
          <div class="mb-4">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-600 mb-3 uppercase tracking-wider">
              <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-revenue to-primary flex items-center justify-center">
                <i class="fas fa-palette text-white text-[10px]"></i>
              </div>
              <span>Appointment Types</span>
            </div>
            <div class="flex gap-3 mb-3">
              <a href="#" @click.prevent="selectAllTypes" class="text-xs text-purple-accent no-underline hover:underline font-medium">Select All</a>
              <a href="#" @click.prevent="clearAllTypes" class="text-xs text-slate-400 no-underline hover:underline hover:text-slate-600 font-medium">Clear</a>
            </div>
            <div class="flex flex-col gap-1">
              <label v-for="type in appointmentTypes" :key="type.id" class="flex items-center gap-3 text-sm text-slate-600 cursor-pointer py-2 px-2.5 rounded-lg transition-all duration-200 hover:bg-slate-50 group">
                <input type="checkbox" :value="type.id" v-model="selectedTypes" class="w-4 h-4 accent-purple-accent cursor-pointer rounded">
                <span class="w-3 h-3 rounded-full flex-shrink-0 shadow-sm" :style="{ background: type.color }"></span>
                <span class="whitespace-nowrap overflow-hidden text-ellipsis group-hover:text-slate-800">{{ type.name }}</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Collapsed Icons -->
        <div v-else class="flex flex-col items-center gap-3 p-3 pt-4">
          <button class="w-9 h-9 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-50 border-none rounded-xl cursor-pointer text-slate-500 transition-all duration-200 hover:bg-gradient-to-r hover:from-purple-accent hover:to-secondary hover:text-white hover:shadow-md" title="Practitioners" @click="toggleFilters">
            <i class="fas fa-user-md"></i>
          </button>
          <button class="w-9 h-9 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-50 border-none rounded-xl cursor-pointer text-slate-500 transition-all duration-200 hover:bg-gradient-to-r hover:from-purple-accent hover:to-secondary hover:text-white hover:shadow-md" title="Appointment Types" @click="toggleFilters">
            <i class="fas fa-palette"></i>
          </button>
        </div>
      </div>

      <!-- Calendar Grid -->
      <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] overflow-auto min-h-0 border border-slate-100">
        <div class="grid min-w-max" @dragover.prevent @drop="onDrop" :style="gridStyle">
          <div class="border-b border-slate-200 sticky top-0 bg-gradient-to-r from-slate-50 to-white z-[2]"></div>
          <div
            v-for="practitioner in filteredPractitioners"
            :key="practitioner"
            class="py-3 px-3 text-center font-semibold text-xs text-slate-700 border-b border-l border-slate-200 sticky top-0 bg-gradient-to-b from-white to-slate-50 z-[2] whitespace-nowrap"
          >
            <div class="flex flex-col items-center gap-1">
              <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-accent to-secondary flex items-center justify-center text-white text-xs font-bold shadow-sm">
                {{ practitioner.split(' ').map(n => n[0]).join('') }}
              </div>
              <span class="text-slate-600">{{ getShortName(practitioner) }}</span>
            </div>
          </div>

          <template v-for="timeSlot in timeSlots" :key="timeSlot.time">
            <div class="px-2 text-right text-xs text-slate-400 flex items-start justify-end pt-1 font-medium" :style="{ gridRow: timeSlot.gridRow }">
              {{ timeSlot.label }}
            </div>
            <div
              v-for="(practitioner, pIndex) in filteredPractitioners"
              :key="practitioner"
              :class="['h-7 border-b border-l cursor-pointer transition-all duration-150 hover:bg-purple-accent/5', timeSlot.isHalfHour ? 'border-dashed border-slate-100' : 'border-slate-200']"
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
            :class="['mx-1 my-0.5 p-2 px-2.5 rounded-xl text-xs cursor-grab overflow-hidden flex flex-col justify-between border-l-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200', typeClasses[appt.type], { 'opacity-50': draggedItemId === appt.id }]"
            :style="getAppointmentStyle(appt)"
            draggable="true"
            @dragstart="onDragStart(appt, $event)"
            @dragend="onDragEnd"
          >
            <div class="overflow-hidden">
              <div class="font-bold whitespace-nowrap overflow-hidden text-ellipsis">{{ appt.title }}</div>
              <div v-if="appt.subtitle" class="text-[11px] opacity-80 whitespace-nowrap overflow-hidden text-ellipsis mt-0.5">{{ appt.subtitle }}</div>
              <div v-if="appt.details" class="text-[11px] opacity-70 whitespace-nowrap overflow-hidden text-ellipsis mt-0.5">{{ appt.details }}</div>
            </div>
            <div class="flex gap-1.5 justify-end mt-auto pt-1">
              <i v-if="appt.type === 'private-only'" class="fas fa-heart text-[10px] text-red-400"></i>
              <i v-if="appt.type === 'private-only'" class="fas fa-dollar-sign text-[10px] text-green-500"></i>
              <i v-if="appt.confirmed" class="fas fa-check-circle text-[10px] text-blue-500"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Waiting Room Panel -->
      <div :class="['bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] overflow-hidden flex flex-col transition-all duration-300 border border-slate-100', { 'w-[52px]': isWaitingCollapsed }]">
        <div v-if="isWaitingCollapsed" class="flex flex-col items-center py-4 px-2 gap-4 h-full bg-gradient-to-b from-slate-50 to-white">
          <button class="w-8 h-8 flex items-center justify-center bg-slate-100 border-none rounded-lg cursor-pointer text-slate-500 transition-all duration-200 hover:bg-purple-accent hover:text-white" @click="toggleWaiting" title="Expand waiting room">
            <i class="fas fa-chevron-left text-xs"></i>
          </button>
          <div :class="['w-8 h-8 flex items-center justify-center rounded-full text-xs font-bold shadow-sm', hasOverduePatients ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white animate-pulse' : 'bg-gradient-to-r from-purple-accent to-secondary text-white']">
            {{ waitingCount }}
          </div>
          <span class="vertical-text text-xs font-semibold text-slate-500 tracking-widest uppercase">Waiting</span>
        </div>
        <div v-else class="flex-1 flex flex-col overflow-hidden">
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
  { id: 'private-only', name: 'Private', color: '#fbbf24' },
  { id: 'private-only-light', name: 'Private (Light)', color: '#c4b5fd' },
  { id: 'nhs', name: 'NHS', color: '#34d899' },
  { id: 'nhs-light', name: 'NHS (Light)', color: '#67e8f9' },
  { id: 'exam', name: 'Exam', color: '#60a5fa' },
  { id: 'zoom', name: 'Zoom', color: '#4ade80' },
  { id: 'blocked', name: 'Blocked', color: '#f87171' },
  { id: 'other', name: 'Other', color: '#94a3b8' },
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
  emergency: "bg-gradient-to-r from-red-50 to-red-100 text-red-800 border-red-500",
  "private-only": "bg-gradient-to-r from-amber-50 to-yellow-100 text-amber-800 border-amber-500",
  "private-only-light": "bg-gradient-to-r from-violet-50 to-purple-100 text-violet-800 border-violet-400",
  other: "bg-gradient-to-r from-slate-50 to-slate-100 text-slate-700 border-slate-400",
  exam: "bg-gradient-to-r from-blue-50 to-blue-100 text-blue-800 border-blue-500",
  nhs: "bg-gradient-to-r from-emerald-50 to-green-100 text-emerald-800 border-emerald-500",
  "nhs-light": "bg-gradient-to-r from-cyan-50 to-cyan-100 text-cyan-800 border-cyan-400",
  blocked: "bg-gradient-to-r from-red-50 to-red-100 text-red-700 border-red-400 opacity-70",
  zoom: "bg-gradient-to-r from-green-100 to-emerald-200 text-green-800 border-green-500",
};

// Computed properties
const layoutClasses = computed(() => ({
  'grid-cols-[48px_1fr_280px]': !isFiltersCollapsed.value && !isWaitingCollapsed.value,
  'grid-cols-[48px_1fr_52px]': !isFiltersCollapsed.value && isWaitingCollapsed.value,
  'grid-cols-[220px_1fr_280px]': isFiltersCollapsed.value && !isWaitingCollapsed.value,
  'grid-cols-[220px_1fr_52px]': isFiltersCollapsed.value && isWaitingCollapsed.value,
}));

const mainLayoutStyle = computed(() => {
  const filtersWidth = isFiltersCollapsed.value ? '48px' : '220px';
  const waitingWidth = isWaitingCollapsed.value ? '52px' : '280px';
  return {
    gridTemplateColumns: `${filtersWidth} 1fr ${waitingWidth}`,
  };
});

const filteredPractitioners = computed(() => {
  return allPractitioners.value.filter(p => selectedPractitioners.value.includes(p));
});

const gridStyle = computed(() => {
  const cols = filteredPractitioners.value.length;
  return {
    gridTemplateColumns: `50px repeat(${cols}, minmax(130px, 1fr))`,
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
  const targetSlot = event.target.closest(".time-slot, [data-time]");

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
.vertical-text {
  writing-mode: vertical-rl;
  text-orientation: mixed;
}

.scrollbar-thin::-webkit-scrollbar {
  width: 5px;
}

.scrollbar-thin::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
