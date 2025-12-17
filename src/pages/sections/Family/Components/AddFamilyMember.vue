<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-container">
      <div class="modal-header">
        <h2>Add Family Member</h2>
        <button class="close-btn" @click="$emit('close')">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="modal-body">
        <div class="tabs">
          <button
            class="tab"
            :class="{ active: activeTab === 'existing' }"
            @click="activeTab = 'existing'"
          >
            <i class="fas fa-search"></i>
            Link Existing Patient
          </button>
          <button
            class="tab"
            :class="{ active: activeTab === 'new' }"
            @click="activeTab = 'new'"
          >
            <i class="fas fa-user-plus"></i>
            Create New Patient
          </button>
        </div>

        <!-- Link Existing Patient -->
        <div v-if="activeTab === 'existing'" class="tab-content">
          <div class="form-group">
            <label>Search Patient</label>
            <div class="search-input-wrapper">
              <i class="fas fa-search"></i>
              <input
                v-model="searchPatient"
                type="text"
                placeholder="Search by name, ID, phone..."
                @input="filterPatients"
              />
            </div>
          </div>

          <div class="patient-results">
            <div
              v-for="patient in filteredPatients"
              :key="patient.id"
              class="patient-result-item"
              :class="{ selected: selectedPatient?.id === patient.id }"
              @click="selectedPatient = patient"
            >
              <div class="patient-avatar">
                <i class="fas fa-user-circle"></i>
              </div>
              <div class="patient-details">
                <h4>{{ patient.name }}</h4>
                <p>ID: {{ patient.id }} | DOB: {{ patient.dob }} | Phone: {{ patient.phone }}</p>
              </div>
              <i v-if="selectedPatient?.id === patient.id" class="fas fa-check-circle selected-icon"></i>
            </div>
            <div v-if="filteredPatients.length === 0" class="no-results">
              <i class="fas fa-inbox"></i>
              <p>No patients found</p>
            </div>
          </div>

          <div v-if="selectedPatient" class="form-group">
            <label>Relationship to Family</label>
            <select v-model="newMember.relationship">
              <option value="">Select Relationship</option>
              <option value="Self">Self</option>
              <option value="Spouse">Spouse</option>
              <option value="Son">Son</option>
              <option value="Daughter">Daughter</option>
              <option value="Father">Father</option>
              <option value="Mother">Mother</option>
              <option value="Brother">Brother</option>
              <option value="Sister">Sister</option>
              <option value="Grandfather">Grandfather</option>
              <option value="Grandmother">Grandmother</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>

        <!-- Create New Patient -->
        <div v-else class="tab-content">
          <div class="form-row">
            <div class="form-group">
              <label>First Name *</label>
              <input v-model="newMember.firstName" type="text" placeholder="Enter first name" />
            </div>
            <div class="form-group">
              <label>Last Name *</label>
              <input v-model="newMember.lastName" type="text" placeholder="Enter last name" />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Date of Birth *</label>
              <input v-model="newMember.dob" type="date" />
            </div>
            <div class="form-group">
              <label>Gender *</label>
              <select v-model="newMember.gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Relationship to Family *</label>
            <select v-model="newMember.relationship">
              <option value="">Select Relationship</option>
              <option value="Self">Self</option>
              <option value="Spouse">Spouse</option>
              <option value="Son">Son</option>
              <option value="Daughter">Daughter</option>
              <option value="Father">Father</option>
              <option value="Mother">Mother</option>
              <option value="Brother">Brother</option>
              <option value="Sister">Sister</option>
              <option value="Grandfather">Grandfather</option>
              <option value="Grandmother">Grandmother</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Phone</label>
              <input v-model="newMember.phone" type="tel" placeholder="(123) 456-7890" />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input v-model="newMember.email" type="email" placeholder="email@example.com" />
            </div>
          </div>

          <div class="form-group">
            <label>Address</label>
            <textarea
              v-model="newMember.address"
              rows="2"
              placeholder="Enter address"
            ></textarea>
          </div>

          <div class="form-group">
            <label class="checkbox-label">
              <input v-model="newMember.isGuarantor" type="checkbox" />
              <span>Set as Guarantor (Account Holder)</span>
            </label>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn-secondary" @click="$emit('close')">Cancel</button>
        <button class="btn-primary" @click="addMember" :disabled="!isValid">
          <i class="fas fa-plus"></i>
          Add to Family
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  familyId: {
    type: Number,
    required: true
  }
});

const emit = defineEmits(['close', 'add']);

const activeTab = ref('existing');
const searchPatient = ref('');
const selectedPatient = ref(null);

const newMember = ref({
  firstName: '',
  lastName: '',
  dob: '',
  gender: '',
  relationship: '',
  phone: '',
  email: '',
  address: '',
  isGuarantor: false
});

// Mock existing patients (would come from API)
const allPatients = ref([
  { id: 201, name: 'Michael Johnson', dob: '1985-03-15', phone: '(555) 123-4567', email: 'mjohnson@email.com' },
  { id: 202, name: 'Sarah Williams', dob: '1990-07-22', phone: '(555) 234-5678', email: 'swilliams@email.com' },
  { id: 203, name: 'David Brown', dob: '1978-11-30', phone: '(555) 345-6789', email: 'dbrown@email.com' },
  { id: 204, name: 'Emily Davis', dob: '1995-05-18', phone: '(555) 456-7890', email: 'edavis@email.com' },
  { id: 205, name: 'Robert Wilson', dob: '1982-09-08', phone: '(555) 567-8901', email: 'rwilson@email.com' }
]);

const filteredPatients = ref([...allPatients.value]);

const filterPatients = () => {
  const query = searchPatient.value.toLowerCase().trim();
  if (!query) {
    filteredPatients.value = [...allPatients.value];
    return;
  }

  filteredPatients.value = allPatients.value.filter(patient =>
    patient.name.toLowerCase().includes(query) ||
    patient.id.toString().includes(query) ||
    patient.phone.includes(query) ||
    patient.email.toLowerCase().includes(query)
  );
};

const isValid = computed(() => {
  if (activeTab.value === 'existing') {
    return selectedPatient.value && newMember.value.relationship;
  } else {
    return (
      newMember.value.firstName &&
      newMember.value.lastName &&
      newMember.value.dob &&
      newMember.value.gender &&
      newMember.value.relationship
    );
  }
});

const addMember = () => {
  if (!isValid.value) return;

  let memberData;

  if (activeTab.value === 'existing') {
    memberData = {
      patientId: selectedPatient.value.id,
      name: selectedPatient.value.name,
      relationship: newMember.value.relationship,
      gender: 'Male', // Would get from patient data
      status: 'Active',
      dob: selectedPatient.value.dob,
      role: 'Dependent',
      recallDue: null,
      picture: null
    };
  } else {
    memberData = {
      patientId: Date.now(), // Temporary ID, would come from API
      name: `${newMember.value.firstName} ${newMember.value.lastName}`,
      relationship: newMember.value.relationship,
      gender: newMember.value.gender,
      status: 'Active',
      dob: newMember.value.dob,
      role: newMember.value.isGuarantor ? 'Guarantor' : 'Dependent',
      recallDue: null,
      picture: null,
      phone: newMember.value.phone,
      email: newMember.value.email,
      address: newMember.value.address
    };
  }

  emit('add', memberData);
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
}

.modal-container {
  background: white;
  border-radius: 16px;
  width: 100%;
  max-width: 700px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
  padding: 24px;
  border-bottom: 1.5px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  font-size: 20px;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.close-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: none;
  background: #f3f4f6;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.close-btn:hover {
  background: #e5e7eb;
  color: #111827;
}

.modal-body {
  padding: 24px;
  overflow-y: auto;
  flex: 1;
}

.tabs {
  display: flex;
  gap: 8px;
  margin-bottom: 24px;
  background: #f9fafb;
  padding: 6px;
  border-radius: 10px;
}

.tab {
  flex: 1;
  padding: 10px 16px;
  border: none;
  background: transparent;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.tab:hover {
  color: #111827;
}

.tab.active {
  background: white;
  color: #4f46e5;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.tab i {
  font-size: 13px;
}

.tab-content {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-size: 13px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  color: #111827;
  transition: all 0.2s ease;
  font-family: inherit;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.search-input-wrapper {
  position: relative;
}

.search-input-wrapper i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  font-size: 14px;
}

.search-input-wrapper input {
  padding-left: 38px;
}

.patient-results {
  max-height: 300px;
  overflow-y: auto;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  margin-bottom: 20px;
}

.patient-result-item {
  padding: 14px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  transition: all 0.2s ease;
  border-bottom: 1px solid #f3f4f6;
}

.patient-result-item:last-child {
  border-bottom: none;
}

.patient-result-item:hover {
  background: #f9fafb;
}

.patient-result-item.selected {
  background: #eff6ff;
  border-left: 3px solid #4f46e5;
}

.patient-avatar {
  width: 40px;
  height: 40px;
  background: #f3f4f6;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.patient-avatar i {
  font-size: 24px;
  color: #9ca3af;
}

.patient-details {
  flex: 1;
}

.patient-details h4 {
  font-size: 14px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 4px 0;
}

.patient-details p {
  font-size: 12px;
  color: #6b7280;
  margin: 0;
}

.selected-icon {
  color: #4f46e5;
  font-size: 20px;
}

.no-results {
  padding: 40px;
  text-align: center;
  color: #9ca3af;
}

.no-results i {
  font-size: 48px;
  margin-bottom: 12px;
  display: block;
}

.no-results p {
  margin: 0;
  font-size: 14px;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  margin-bottom: 0;
}

.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
  accent-color: #4f46e5;
}

.checkbox-label span {
  font-size: 14px;
  color: #374151;
}

.modal-footer {
  padding: 20px 24px;
  border-top: 1.5px solid #e5e7eb;
  display: flex;
  gap: 12px;
  justify-content: flex-end;
}

.btn-primary,
.btn-secondary {
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  border: none;
}

.btn-primary {
  background: #4f46e5;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #4338ca;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-primary:disabled {
  background: #d1d5db;
  cursor: not-allowed;
  transform: none;
}

.btn-secondary {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
}

.btn-secondary:hover {
  background: #f9fafb;
  border-color: #d1d5db;
}

@media (max-width: 640px) {
  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>
