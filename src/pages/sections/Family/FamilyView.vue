<template>
  <div class="family-container">
    <!-- Top Action Bar -->
    <div class="action-bar">
      <div class="search-section">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search family by name, ID..."
            @input="searchFamilies"
          />
        </div>
        <button class="btn-primary" @click="showSelectFamilyModal = true">
          <i class="fas fa-users"></i>
          Select Family
        </button>
      </div>

      <div class="quick-actions">
        <button class="btn-action" @click="showAddMemberModal = true">
          <i class="fas fa-user-plus"></i>
          Add Member
        </button>
        <button class="btn-action" @click="deleteMember" :disabled="!selectedMember">
          <i class="fas fa-user-minus"></i>
          Remove
        </button>
        <button class="btn-action" @click="setGuarantor" :disabled="!selectedMember">
          <i class="fas fa-star"></i>
          Set Guarantor
        </button>
        <button class="btn-action" @click="showInsuranceModal = true" :disabled="!selectedMember">
          <i class="fas fa-shield-alt"></i>
          Add Insurance
        </button>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
      <!-- Left Section: Patient Picture & Family Members -->
      <div class="left-section">
        <!-- Patient Picture Card -->
        <div class="patient-picture-card">
          <div class="picture-header">
            <h3>Patient Picture</h3>
            <button class="btn-icon" @click="uploadPicture">
              <i class="fas fa-camera"></i>
            </button>
          </div>
          <div class="picture-display">
            <img
              v-if="selectedMember?.picture"
              :src="selectedMember.picture"
              alt="Patient"
            />
            <div v-else class="picture-placeholder">
              <i class="fas fa-user-circle"></i>
              <span>No Photo</span>
            </div>
          </div>
          <div class="patient-quick-info" v-if="selectedMember">
            <h4>{{ selectedMember.name }}</h4>
            <p>{{ selectedMember.position }}</p>
            <span class="status-badge" :class="selectedMember.status.toLowerCase()">
              {{ selectedMember.status }}
            </span>
          </div>
        </div>

        <!-- Family Members Table -->
        <div class="members-card">
          <div class="card-header">
            <h3>Family Members</h3>
            <span class="member-count">{{ currentFamily.members?.length || 0 }} Members</span>
          </div>
          <div class="members-table-wrapper">
            <table class="members-table">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Age</th>
                  <th>Recall Due</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="member in currentFamily.members"
                  :key="member.patientId"
                  :class="{ selected: selectedMember?.patientId === member.patientId }"
                  @click="selectMember(member)"
                >
                  <td class="checkbox-cell">
                    <input
                      type="radio"
                      :checked="selectedMember?.patientId === member.patientId"
                      @click.stop="selectMember(member)"
                    />
                  </td>
                  <td class="name-cell">
                    <i v-if="member.role === 'Guarantor'" class="fas fa-star guarantor-icon"></i>
                    {{ member.name }}
                  </td>
                  <td>{{ member.relationship }}</td>
                  <td>
                    <span class="gender-badge">
                      <i :class="member.gender === 'Male' ? 'fas fa-mars' : 'fas fa-venus'"></i>
                      {{ member.gender }}
                    </span>
                  </td>
                  <td>
                    <span class="status-badge" :class="member.status.toLowerCase()">
                      {{ member.status }}
                    </span>
                  </td>
                  <td>{{ calculateAge(member.dob) }}</td>
                  <td :class="{ 'overdue': isRecallOverdue(member.recallDue) }">
                    {{ member.recallDue || 'N/A' }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Right Section: Recall, Patient Info, Insurance -->
      <div class="right-section">
        <!-- Recall Management -->
        <RecallManagement :member="selectedMember" @update="updateRecall" />

        <!-- Patient Information -->
        <PatientInformation :member="selectedMember" @update="updatePatientInfo" />

        <!-- Insurance Plans -->
        <InsurancePlans :member="selectedMember" @update="updateInsurance" />

        <!-- Account Overview -->
        <FamilyAccountOverview :family="currentFamily" />
      </div>
    </div>

    <!-- Modals -->
    <AddFamilyMember
      v-if="showAddMemberModal"
      :familyId="currentFamily.familyId"
      @close="showAddMemberModal = false"
      @add="addFamilyMember"
    />

    <AddInsuranceModal
      v-if="showInsuranceModal"
      :member="selectedMember"
      @close="showInsuranceModal = false"
      @save="addInsurancePlan"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import RecallManagement from './Components/RecallManagement.vue';
import PatientInformation from './Components/PatientInformation.vue';
import InsurancePlans from './Components/InsurancePlans.vue';
import FamilyAccountOverview from './Components/FamilyAccountOverview.vue';
import AddFamilyMember from './Components/AddFamilyMember.vue';
import AddInsuranceModal from './Components/AddInsuranceModal.vue';

const searchQuery = ref('');
const showAddMemberModal = ref(false);
const showSelectFamilyModal = ref(false);
const showInsuranceModal = ref(false);
const selectedMember = ref(null);

// Mock data - Replace with API calls
const currentFamily = ref({
  familyId: 1,
  familyName: "Smith Family",
  primaryAccountHolder: {
    patientId: 101,
    name: "John Smith",
    relationship: "Head of Household"
  },
  members: [
    {
      patientId: 101,
      name: "John Smith",
      relationship: "Self",
      gender: "Male",
      status: "Active",
      dob: "1980-05-15",
      role: "Guarantor",
      recallDue: "2025-12-15",
      picture: null
    },
    {
      patientId: 102,
      name: "Jane Smith",
      relationship: "Spouse",
      gender: "Female",
      status: "Active",
      dob: "1982-08-22",
      role: "Dependent",
      recallDue: "2025-11-20",
      picture: null
    },
    {
      patientId: 103,
      name: "Emma Smith",
      relationship: "Daughter",
      gender: "Female",
      status: "Active",
      dob: "2010-03-10",
      role: "Dependent",
      recallDue: "2025-10-30",
      picture: null
    },
    {
      patientId: 104,
      name: "James Smith",
      relationship: "Son",
      gender: "Male",
      status: "Active",
      dob: "2015-07-18",
      role: "Dependent",
      recallDue: "2025-11-05",
      picture: null
    }
  ],
  totalBalance: 1250.00,
  insuranceProvider: "Delta Dental"
});

// Select first member by default
if (currentFamily.value.members.length > 0) {
  selectedMember.value = currentFamily.value.members[0];
}

const selectMember = (member) => {
  selectedMember.value = member;
};

const calculateAge = (dob) => {
  const today = new Date();
  const birthDate = new Date(dob);
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDiff = today.getMonth() - birthDate.getMonth();
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
};

const isRecallOverdue = (recallDue) => {
  if (!recallDue) return false;
  const today = new Date();
  const dueDate = new Date(recallDue);
  return dueDate < today;
};

const searchFamilies = () => {
  // Implement search functionality
  console.log('Searching:', searchQuery.value);
};

const addFamilyMember = (newMember) => {
  currentFamily.value.members.push(newMember);
  showAddMemberModal.value = false;
};

const deleteMember = () => {
  if (!selectedMember.value) return;

  if (selectedMember.value.role === 'Guarantor') {
    alert('Cannot delete the guarantor. Please assign another guarantor first.');
    return;
  }

  if (confirm(`Are you sure you want to remove ${selectedMember.value.name} from the family?`)) {
    currentFamily.value.members = currentFamily.value.members.filter(
      m => m.patientId !== selectedMember.value.patientId
    );
    selectedMember.value = currentFamily.value.members[0] || null;
  }
};

const setGuarantor = () => {
  if (!selectedMember.value) return;

  // Remove guarantor role from all members
  currentFamily.value.members.forEach(m => {
    if (m.role === 'Guarantor') m.role = 'Dependent';
  });

  // Set selected member as guarantor
  selectedMember.value.role = 'Guarantor';
  currentFamily.value.primaryAccountHolder = {
    patientId: selectedMember.value.patientId,
    name: selectedMember.value.name,
    relationship: selectedMember.value.relationship
  };
};

const uploadPicture = () => {
  // Implement picture upload
  console.log('Upload picture');
};

const updateRecall = (data) => {
  if (selectedMember.value) {
    selectedMember.value.recallDue = data.dueDate;
  }
};

const updatePatientInfo = (data) => {
  console.log('Update patient info:', data);
};

const updateInsurance = (data) => {
  console.log('Update insurance:', data);
};

const addInsurancePlan = (plan) => {
  console.log('New insurance plan added:', plan);
  // Here you would typically call an API to save the insurance plan
  // For now, we'll just close the modal and log the data
  showInsuranceModal.value = false;
};
</script>

<style scoped>
.family-container {
  background-color: #f8f9fa;
  min-height: 100vh;
  padding: 24px;
}

/* Action Bar */
.action-bar {
  background: white;
  padding: 20px 24px;
  border-radius: 12px;
  margin-bottom: 24px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}

.search-section {
  display: flex;
  gap: 12px;
  align-items: center;
  flex: 1;
  min-width: 300px;
}

.search-box {
  flex: 1;
  max-width: 400px;
  position: relative;
  display: flex;
  align-items: center;
}

.search-box i {
  position: absolute;
  left: 14px;
  color: #9ca3af;
  font-size: 14px;
}

.search-box input {
  width: 100%;
  padding: 10px 14px 10px 38px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.2s ease;
}

.search-box input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.quick-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-primary {
  background: #4f46e5;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-primary:hover {
  background: #4338ca;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-action {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
  padding: 10px 16px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
}

.btn-action:hover:not(:disabled) {
  background: #f9fafb;
  border-color: #4f46e5;
  color: #4f46e5;
}

.btn-action:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-action i {
  font-size: 12px;
}

/* Content Grid */
.content-grid {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 24px;
}

/* Left Section */
.left-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* Patient Picture Card */
.patient-picture-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.picture-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.picture-header h3 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.btn-icon {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 1.5px solid #e5e7eb;
  background: white;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.btn-icon:hover {
  background: #f9fafb;
  border-color: #4f46e5;
  color: #4f46e5;
}

.picture-display {
  width: 100%;
  aspect-ratio: 1;
  max-width: 200px;
  margin: 0 auto 16px;
  border-radius: 12px;
  overflow: hidden;
  border: 2px solid #e5e7eb;
  background: #f9fafb;
}

.picture-display img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.picture-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #9ca3af;
}

.picture-placeholder i {
  font-size: 60px;
  margin-bottom: 8px;
}

.picture-placeholder span {
  font-size: 13px;
  font-weight: 500;
}

.patient-quick-info {
  text-align: center;
}

.patient-quick-info h4 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 4px 0;
}

.patient-quick-info p {
  font-size: 13px;
  color: #6b7280;
  margin: 0 0 8px 0;
}

/* Members Card */
.members-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}

.card-header {
  padding: 20px 24px;
  border-bottom: 1.5px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-header h3 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.member-count {
  background: #eff6ff;
  color: #1e40af;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}

.members-table-wrapper {
  overflow-x: auto;
}

.members-table {
  width: 100%;
  border-collapse: collapse;
}

.members-table th {
  background: #f9fafb;
  padding: 12px 16px;
  text-align: left;
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-bottom: 1.5px solid #e5e7eb;
}

.members-table td {
  padding: 16px;
  font-size: 14px;
  color: #374151;
  border-bottom: 1px solid #f3f4f6;
}

.members-table tbody tr {
  cursor: pointer;
  transition: background 0.15s ease;
}

.members-table tbody tr:hover {
  background: #f9fafb;
}

.members-table tbody tr.selected {
  background: #eff6ff;
}

.checkbox-cell {
  width: 40px;
  padding-left: 24px !important;
}

.checkbox-cell input[type="radio"] {
  width: 16px;
  height: 16px;
  cursor: pointer;
  accent-color: #4f46e5;
}

.name-cell {
  font-weight: 500;
  color: #111827;
}

.guarantor-icon {
  color: #f59e0b;
  margin-right: 6px;
}

.gender-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
}

.gender-badge i {
  font-size: 12px;
}

.fa-mars {
  color: #3b82f6;
}

.fa-venus {
  color: #ec4899;
}

.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 500;
}

.status-badge.active {
  background: #d1fae5;
  color: #065f46;
}

.status-badge.inactive {
  background: #fee2e2;
  color: #991b1b;
}

.status-badge.pending {
  background: #fef3c7;
  color: #92400e;
}

.overdue {
  color: #dc2626;
  font-weight: 500;
}

/* Right Section */
.right-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* Responsive */
@media (max-width: 1400px) {
  .content-grid {
    grid-template-columns: 1fr 350px;
  }
}

@media (max-width: 1200px) {
  .content-grid {
    grid-template-columns: 1fr;
  }

  .right-section {
    grid-column: 1;
  }
}

@media (max-width: 768px) {
  .family-container {
    padding: 16px;
  }

  .action-bar {
    flex-direction: column;
    align-items: stretch;
  }

  .search-section {
    flex-direction: column;
  }

  .quick-actions {
    justify-content: stretch;
  }

  .btn-action {
    flex: 1;
    justify-content: center;
  }
}
</style>
