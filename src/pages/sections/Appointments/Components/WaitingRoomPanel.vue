<template>
  <div class="waiting-room-panel">
    <div class="panel-header">
      <div class="header-left">
        <h3>
          <i class="fas fa-clock"></i>
          Waiting Room
        </h3>
      </div>
      <div class="header-right">
        <span class="patient-count" :class="{ 'has-overdue': hasOverduePatients }">
          {{ waitingPatients.length }} Patients
        </span>
        <button class="collapse-btn" @click="$emit('toggle-collapse')" title="Collapse panel">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="waitingPatients.length === 0" class="empty-state">
      <i class="fas fa-chair"></i>
      <p>No patients in waiting room</p>
    </div>

    <!-- Patients List -->
    <div v-else class="patients-list">
      <div
        v-for="patient in sortedPatients"
        :key="patient.appointmentId"
        class="patient-card"
        :class="{ overdue: patient.waitTime > 20 }"
        @click="selectPatient(patient)"
      >
        <div class="patient-header">
          <div class="patient-info">
            <h4>{{ patient.patientName }}</h4>
            <p class="practitioner">{{ patient.practitionerName }}</p>
          </div>
          <div class="wait-time" :class="{ alert: patient.waitTime > 20 }">
            <i class="fas fa-clock"></i>
            <span>{{ patient.waitTime }} min</span>
          </div>
        </div>

        <div class="patient-details">
          <div class="detail-item">
            <i class="fas fa-calendar-check"></i>
            <span>{{ patient.appointmentTime }}</span>
          </div>
          <div class="detail-item">
            <i class="fas fa-sign-in-alt"></i>
            <span>Check-in: {{ patient.checkInTime }}</span>
          </div>
        </div>

        <div class="status-section">
          <select
            v-model="patient.currentStatus"
            class="status-dropdown"
            :class="getStatusClass(patient.currentStatus)"
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
        <div class="quick-actions">
          <button
            v-if="patient.currentStatus === 'Arrived'"
            class="action-btn ready"
            @click.stop="markAsReady(patient)"
            title="Mark as Ready"
          >
            <i class="fas fa-check"></i>
          </button>
          <button
            v-if="patient.currentStatus === 'Ready'"
            class="action-btn in-room"
            @click.stop="markAsInRoom(patient)"
            title="Move to Room"
          >
            <i class="fas fa-door-open"></i>
          </button>
          <button
            v-if="patient.currentStatus === 'InRoom'"
            class="action-btn complete"
            @click.stop="markAsCompleted(patient)"
            title="Complete"
          >
            <i class="fas fa-check-double"></i>
          </button>
          <button
            class="action-btn info"
            @click.stop="viewDetails(patient)"
            title="View Details"
          >
            <i class="fas fa-info-circle"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sort & Filter Controls -->
    <div v-if="waitingPatients.length > 0" class="panel-footer">
      <div class="filter-controls">
        <label>
          <i class="fas fa-sort"></i>
          Sort:
        </label>
        <select v-model="sortBy" class="sort-select">
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
    'Unconfirmed': 'status-unconfirmed',
    'Confirmed': 'status-confirmed',
    'Arrived': 'status-arrived',
    'Ready': 'status-ready',
    'InRoom': 'status-inroom',
    'ChkOut': 'status-chkout',
    'Completed': 'status-completed'
  };
  return classes[status] || '';
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
.waiting-room-panel {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  height: 100%;
  max-height: calc(100vh - 200px);
}

.panel-header {
  padding: 10px 12px;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f9fafb;
}

.header-left {
  display: flex;
  align-items: center;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 8px;
}

.panel-header h3 {
  font-size: 13px;
  font-weight: 600;
  color: #111827;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 6px;
}

.panel-header h3 i {
  color: #4f46e5;
  font-size: 14px;
}

.patient-count {
  background: #eff6ff;
  color: #1e40af;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
}

.patient-count.has-overdue {
  background: #fef2f2;
  color: #991b1b;
}

.collapse-btn {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 4px;
  cursor: pointer;
  color: #6b7280;
  transition: all 0.2s;
}

.collapse-btn:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
}

.empty-state {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  color: #9ca3af;
}

.empty-state i {
  font-size: 64px;
  margin-bottom: 16px;
  color: #d1d5db;
}

.empty-state p {
  font-size: 14px;
  margin: 0;
}

.patients-list {
  flex: 1;
  overflow-y: auto;
  padding: 10px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

/* Custom scrollbar */
.patients-list::-webkit-scrollbar {
  width: 6px;
}

.patients-list::-webkit-scrollbar-track {
  background: #f3f4f6;
  border-radius: 10px;
}

.patients-list::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 10px;
}

.patients-list::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}

.patient-card {
  background: #f9fafb;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  padding: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.patient-card:hover {
  border-color: #4f46e5;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
  transform: translateY(-2px);
}

.patient-card.overdue {
  border-color: #fca5a5;
  background: #fef2f2;
}

.patient-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 6px;
}

.patient-info h4 {
  font-size: 12px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 2px 0;
}

.patient-info .practitioner {
  font-size: 10px;
  color: #6b7280;
  margin: 0;
}

.wait-time {
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 2px 8px;
  background: #e0e7ff;
  color: #3730a3;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
}

.wait-time.alert {
  background: #fee2e2;
  color: #991b1b;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

.wait-time i {
  font-size: 11px;
}

.patient-details {
  display: flex;
  flex-direction: column;
  gap: 4px;
  margin-bottom: 8px;
}

.detail-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  color: #6b7280;
}

.detail-item i {
  font-size: 9px;
  color: #9ca3af;
  width: 12px;
}

.status-section {
  margin-bottom: 8px;
}

.status-dropdown {
  width: 100%;
  padding: 6px 10px;
  border: 1.5px solid #e5e7eb;
  border-radius: 6px;
  font-size: 11px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.status-dropdown:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.status-unconfirmed {
  background: #f3f4f6;
  color: #6b7280;
}

.status-confirmed {
  background: #dbeafe;
  color: #1e40af;
}

.status-arrived {
  background: #fef3c7;
  color: #92400e;
}

.status-ready {
  background: #d1fae5;
  color: #065f46;
}

.status-inroom {
  background: #e9d5ff;
  color: #6b21a8;
}

.status-chkout {
  background: #ccfbf1;
  color: #134e4a;
}

.status-completed {
  background: #bbf7d0;
  color: #14532d;
}

.quick-actions {
  display: flex;
  gap: 4px;
}

.action-btn {
  flex: 1;
  padding: 6px;
  border: none;
  border-radius: 5px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.action-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.action-btn.ready {
  background: #d1fae5;
  color: #065f46;
}

.action-btn.ready:hover {
  background: #a7f3d0;
}

.action-btn.in-room {
  background: #e9d5ff;
  color: #6b21a8;
}

.action-btn.in-room:hover {
  background: #d8b4fe;
}

.action-btn.complete {
  background: #bfdbfe;
  color: #1e40af;
}

.action-btn.complete:hover {
  background: #93c5fd;
}

.action-btn.info {
  background: #f3f4f6;
  color: #6b7280;
}

.action-btn.info:hover {
  background: #e5e7eb;
}

.panel-footer {
  padding: 10px 12px;
  border-top: 1.5px solid #e5e7eb;
  background: #f9fafb;
}

.filter-controls {
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-controls label {
  font-size: 11px;
  font-weight: 500;
  color: #6b7280;
  display: flex;
  align-items: center;
  gap: 4px;
}

.filter-controls i {
  font-size: 10px;
}

.sort-select {
  flex: 1;
  padding: 4px 8px;
  border: 1.5px solid #e5e7eb;
  border-radius: 6px;
  font-size: 11px;
  background: white;
  cursor: pointer;
}

.sort-select:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}
</style>
