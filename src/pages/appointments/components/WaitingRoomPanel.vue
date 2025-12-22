<template>
  <div class="bg-white rounded-2xl flex flex-col h-full max-h-[calc(100vh-200px)] font-[Poppins]">
    <!-- Panel Header -->
    <div class="py-3 px-4 border-b border-slate-100 flex justify-between items-center bg-gradient-to-r from-slate-50 to-white rounded-t-2xl">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-purple-accent to-secondary flex items-center justify-center shadow-md">
          <i class="fas fa-clock  text-sm"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800 m-0">Waiting Room</h3>
      </div>
      <div class="flex items-center gap-2">
        <span :class="['px-3 py-1 rounded-full text-xs font-bold', hasOverduePatients ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white animate-pulse' : 'bg-gradient-to-r from-purple-accent/10 to-secondary/10 text-purple-accent']">
          {{ waitingPatients.length }} Patients
        </span>
        <button class="w-7 h-7 flex items-center justify-center bg-slate-100 border-none rounded-lg cursor-pointer text-slate-500 transition-all duration-200 hover:bg-purple-accent hover:text-white" @click="$emit('toggle-collapse')" title="Collapse panel">
          <i class="fas fa-chevron-right text-xs"></i>
        </button>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="waitingPatients.length === 0" class="flex-1 flex flex-col items-center justify-center py-16 px-5 text-slate-400">
      <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-4">
        <i class="fas fa-chair text-4xl text-slate-300"></i>
      </div>
      <p class="text-sm font-medium m-0">No patients in waiting room</p>
    </div>

    <!-- Patients List -->
    <div v-else class="flex-1 overflow-y-auto p-3 flex flex-col gap-2.5 scrollbar-thin">
      <div
        v-for="patient in sortedPatients"
        :key="patient.appointmentId"
        :class="['rounded-xl p-3.5 cursor-pointer transition-all duration-200 border-2', patient.waitTime > 20 ? 'bg-gradient-to-r from-red-50 to-orange-50 border-red-200 hover:border-red-400 hover:shadow-md hover:shadow-red-100' : 'bg-gradient-to-r from-slate-50 to-white border-slate-100 hover:border-purple-accent hover:shadow-md hover:shadow-purple-accent/10']"
        @click="selectPatient(patient)"
      >
        <!-- Patient Header -->
        <div class="flex justify-between items-start mb-2">
          <div>
            <h4 class="text-sm font-bold text-slate-800 m-0 mb-0.5">{{ patient.patientName }}</h4>
            <p class="text-xs text-slate-500 m-0">{{ patient.practitionerName }}</p>
          </div>
          <div :class="['flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold', patient.waitTime > 20 ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white animate-pulse' : 'bg-gradient-to-r from-purple-accent/10 to-secondary/10 text-purple-accent']">
            <i class="fas fa-clock text-[10px]"></i>
            <span>{{ patient.waitTime }} min</span>
          </div>
        </div>

        <!-- Patient Details -->
        <div class="flex flex-col gap-1.5 mb-3">
          <div class="flex items-center gap-2 text-xs text-slate-500">
            <i class="fas fa-calendar-check text-[10px] text-slate-400 w-3"></i>
            <span>{{ patient.appointmentTime }}</span>
          </div>
          <div class="flex items-center gap-2 text-xs text-slate-500">
            <i class="fas fa-sign-in-alt text-[10px] text-slate-400 w-3"></i>
            <span>Check-in: {{ patient.checkInTime }}</span>
          </div>
        </div>

        <!-- Status Section -->
        <div class="mb-3">
          <select
            v-model="patient.currentStatus"
            :class="['w-full py-2 px-3 border-2 rounded-xl text-xs font-bold cursor-pointer transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-accent/30', getStatusClass(patient.currentStatus)]"
            @click.stop
            @change="updateStatus(patient)"
          >
            <option value="Unconfirmed">Unconfirmed</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Arrived">Arrived</option>
            <option value="Ready">Ready</option>
            <option value="InRoom">In Room</option>
            <option value="ChkOut">Check Out</option>
            <option value="Completed">Completed</option>
          </select>
        </div>

        <!-- Quick Actions -->
        <div class="flex gap-2">
          <button
            v-if="patient.currentStatus === 'Arrived'"
            class="flex-1 py-2 px-3 border-none rounded-lg text-xs font-semibold cursor-pointer transition-all duration-200 flex items-center justify-center gap-1.5 bg-gradient-to-r from-emerald-400 to-green-500 text-white hover:shadow-md hover:-translate-y-0.5"
            @click.stop="markAsReady(patient)"
            title="Mark as Ready"
          >
            <i class="fas fa-check"></i>
            Ready
          </button>
          <button
            v-if="patient.currentStatus === 'Ready'"
            class="flex-1 py-2 px-3 border-none rounded-lg text-xs font-semibold cursor-pointer transition-all duration-200 flex items-center justify-center gap-1.5 bg-gradient-to-r from-violet-500 to-purple-600 text-white hover:shadow-md hover:-translate-y-0.5"
            @click.stop="markAsInRoom(patient)"
            title="Move to Room"
          >
            <i class="fas fa-door-open"></i>
            In Room
          </button>
          <button
            v-if="patient.currentStatus === 'InRoom'"
            class="flex-1 py-2 px-3 border-none rounded-lg text-xs font-semibold cursor-pointer transition-all duration-200 flex items-center justify-center gap-1.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white hover:shadow-md hover:-translate-y-0.5"
            @click.stop="markAsCompleted(patient)"
            title="Complete"
          >
            <i class="fas fa-check-double"></i>
            Done
          </button>
          <button
            class="w-9 h-9 flex-shrink-0 py-2 px-3 border-none rounded-lg text-xs font-semibold cursor-pointer transition-all duration-200 flex items-center justify-center bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700"
            @click.stop="viewDetails(patient)"
            title="View Details"
          >
            <i class="fas fa-info-circle"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sort & Filter Controls -->
    <div v-if="waitingPatients.length > 0" class="py-3 px-4 border-t border-slate-100 bg-gradient-to-r from-slate-50 to-white rounded-b-2xl">
      <div class="flex items-center gap-3">
        <label class="text-xs font-semibold text-slate-500 flex items-center gap-1.5">
          <i class="fas fa-sort text-purple-accent text-[10px]"></i>
          Sort:
        </label>
        <select v-model="sortBy" class="flex-1 py-2 px-3 border-2 border-slate-200 rounded-xl text-xs bg-white cursor-pointer transition-all duration-200 focus:outline-none focus:border-purple-accent focus:ring-2 focus:ring-purple-accent/20 font-medium">
          <option value="waitTime">Wait Time</option>
          <option value="appointmentTime">Appointment Time</option>
          <option value="checkInTime">Check-in Time</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
  isCollapsed: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['toggle-collapse', 'update:waiting-count']);

const sortBy = ref('waitTime');
const selectedPatientId = ref(null);

// Mock waiting room patients
const waitingPatients = ref([
  {
    appointmentId: 1,
    patientName: 'John Smith',
    practitionerName: 'Dr. Sarah Lexington',
    appointmentTime: '10:00 AM',
    checkInTime: '09:55 AM',
    currentStatus: 'Ready',
    waitTime: 5,
    statusHistory: [
      { status: 'Confirmed', timestamp: '2025-11-05 08:30:00' },
      { status: 'Arrived', timestamp: '2025-11-05 09:55:00' },
      { status: 'Ready', timestamp: '2025-11-05 10:00:00' }
    ]
  },
  {
    appointmentId: 2,
    patientName: 'Jane Doe',
    practitionerName: 'Dr. Rob Perkowski',
    appointmentTime: '10:30 AM',
    checkInTime: '10:18 AM',
    currentStatus: 'Arrived',
    waitTime: 12,
    statusHistory: [
      { status: 'Confirmed', timestamp: '2025-11-04 14:00:00' },
      { status: 'Arrived', timestamp: '2025-11-05 10:18:00' }
    ]
  },
  {
    appointmentId: 3,
    patientName: 'Michael Brown',
    practitionerName: 'Dr. Sam Clarke',
    appointmentTime: '09:00 AM',
    checkInTime: '08:38 AM',
    currentStatus: 'InRoom',
    waitTime: 22,
    statusHistory: [
      { status: 'Confirmed', timestamp: '2025-11-03 16:00:00' },
      { status: 'Arrived', timestamp: '2025-11-05 08:38:00' },
      { status: 'Ready', timestamp: '2025-11-05 08:55:00' },
      { status: 'InRoom', timestamp: '2025-11-05 09:00:00' }
    ]
  },
  {
    appointmentId: 4,
    patientName: 'Sarah Wilson',
    practitionerName: 'Dr. Carl Young',
    appointmentTime: '11:00 AM',
    checkInTime: '10:55 AM',
    currentStatus: 'Confirmed',
    waitTime: 5,
    statusHistory: [
      { status: 'Confirmed', timestamp: '2025-11-05 10:55:00' }
    ]
  }
]);

const sortedPatients = computed(() => {
  const patients = [...waitingPatients.value];

  if (sortBy.value === 'waitTime') {
    return patients.sort((a, b) => b.waitTime - a.waitTime);
  } else if (sortBy.value === 'appointmentTime') {
    return patients.sort((a, b) => {
      const timeA = convertTo24Hour(a.appointmentTime);
      const timeB = convertTo24Hour(b.appointmentTime);
      return timeA - timeB;
    });
  } else if (sortBy.value === 'checkInTime') {
    return patients.sort((a, b) => {
      const timeA = convertTo24Hour(a.checkInTime);
      const timeB = convertTo24Hour(b.checkInTime);
      return timeA - timeB;
    });
  }

  return patients;
});

const convertTo24Hour = (time) => {
  const [timePart, meridiem] = time.split(' ');
  let [hours, minutes] = timePart.split(':').map(Number);

  if (meridiem === 'PM' && hours !== 12) {
    hours += 12;
  } else if (meridiem === 'AM' && hours === 12) {
    hours = 0;
  }

  return hours * 60 + minutes;
};

const getStatusClass = (status) => {
  const classes = {
    'Unconfirmed': 'bg-slate-100 border-slate-200 text-slate-600',
    'Confirmed': 'bg-blue-50 border-blue-200 text-blue-700',
    'Arrived': 'bg-amber-50 border-amber-200 text-amber-700',
    'Ready': 'bg-emerald-50 border-emerald-200 text-emerald-700',
    'InRoom': 'bg-violet-50 border-violet-200 text-violet-700',
    'ChkOut': 'bg-cyan-50 border-cyan-200 text-cyan-700',
    'Completed': 'bg-green-50 border-green-300 text-green-700'
  };
  return classes[status] || 'bg-slate-100 border-slate-200 text-slate-600';
};

const selectPatient = (patient) => {
  selectedPatientId.value = patient.appointmentId;
  console.log('Selected patient:', patient);
};

const updateStatus = (patient) => {
  console.log('Status updated:', patient.patientName, patient.currentStatus);
  // Update status history
  patient.statusHistory.push({
    status: patient.currentStatus,
    timestamp: new Date().toISOString()
  });
};

const markAsReady = (patient) => {
  patient.currentStatus = 'Ready';
  updateStatus(patient);
};

const markAsInRoom = (patient) => {
  patient.currentStatus = 'InRoom';
  updateStatus(patient);
};

const markAsCompleted = (patient) => {
  patient.currentStatus = 'Completed';
  updateStatus(patient);

  // Remove from waiting room after 2 seconds
  setTimeout(() => {
    const index = waitingPatients.value.findIndex(p => p.appointmentId === patient.appointmentId);
    if (index > -1) {
      waitingPatients.value.splice(index, 1);
    }
  }, 2000);
};

const viewDetails = (patient) => {
  console.log('View details for:', patient);
  alert(`Patient: ${patient.patientName}\nStatus: ${patient.currentStatus}\nWait Time: ${patient.waitTime} minutes`);
};

// Check for overdue patients (waiting > 20 min)
const hasOverduePatients = computed(() => {
  return waitingPatients.value.some(p => p.waitTime > 20);
});

// Emit waiting count changes
watch(() => waitingPatients.value.length, (newCount) => {
  emit('update:waiting-count', newCount);
}, { immediate: true });

// Auto-update wait times every minute
let updateInterval = null;

onMounted(() => {
  emit('update:waiting-count', waitingPatients.value.length);

  updateInterval = setInterval(() => {
    waitingPatients.value.forEach(patient => {
      if (patient.currentStatus !== 'Completed') {
        patient.waitTime += 1;
      }
    });
  }, 60000); // Update every minute
});

onBeforeUnmount(() => {
  if (updateInterval) {
    clearInterval(updateInterval);
  }
});
</script>

<style scoped>
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

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.8;
  }
}
</style>
