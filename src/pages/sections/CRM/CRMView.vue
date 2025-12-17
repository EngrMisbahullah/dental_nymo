<template>
  <div class="container">
    <!-- Top Bar -->
    <div class="top-bar">
      <h1 class="page-title">Patients</h1>
      <div class="top-controls">
        <input
          v-model="searchQuery"
          type="text"
          class="search-input"
          placeholder="Search patients..."
        />
        <!-- <button class="add-btn" @click="showModal = true">+ Add Patient</button> -->
        <router-link to="/dashboard/crm/add-patient" class="add-btn"
          >+ Add Patient</router-link
        >
      </div>
    </div>

    <!-- Patient Table -->
    <div class="table-wrapper">
      <table class="patient-table">
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Skin Type</th>
            <th>Concerns</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(patient, index) in filteredPatients" :key="index">
            <td class="patient-info">
              <!-- <img :src="patient.avatar" /> -->
              <span>{{ patient.name }}</span>
            </td>
            <td>{{ patient.email }}</td>
            <td>{{ patient.phone }}</td>
            <td>{{ patient.skinType }}</td>
            <td>{{ patient.concerns }}</td>
            <td class="actions">
              <!-- <i class="fas fa-eye" @click="openViewModal(patient)"></i> -->
              <i class="fas fa-eye" @click="goToViewPatient(patient.id)"></i>

              <i class="fas fa-pen"></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modals -->
    <!-- <AddPatient v-if="showModal" @close="showModal = false" @add-patient="addPatient" /> -->
    <router-view />
    <!-- <ViewPatient
      v-if="showViewModal"
      :patient="selectedPatient"
      @close="showViewModal = false"
    /> -->
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import AddPatient from "./AddPatient.vue";
import ViewPatient from "./ViewPatient.vue";
import { useRouter } from "vue-router";

const showModal = ref(false);
const showViewModal = ref(false);
const selectedPatient = ref(null);
const router = useRouter();

const goToViewPatient = (id) => {
  router.push({ name: "ViewPatient", params: { id } });
};

const openViewModal = (patient) => {
  selectedPatient.value = patient;
  showViewModal.value = true;
};

const patients = ref([
  {
    id: 1,
    name: "Jane Doe",
    email: "jane.doe@example.com",
    phone: "(123) 456-7890",
    skinType: "Oily",
    concerns: "Acne, Scars",
    avatar: "https://randomuser.me/api/portraits/women/65.jpg",
    dob: "1990-05-15",
    address: "123 Main St, Anytown, USA",
    emergencyContact: "John Doe - (123) 555-7890",
    allergies: ["Penicillin", "Aspirin"],
    medications: [
      {
        name: "Isotretinoin",
        dosage: "20mg",
        frequency: "Once daily",
        startDate: "01/10/2023",
        endDate: "07/10/2023",
      },
      {
        name: "Clindamycin Phosphate",
        dosage: "1% Gel",
        frequency: "Twice daily",
        startDate: "01/10/2023",
        endDate: "Present",
      },
    ],
    medicalHistory: [
      {
        condition: "Rosacea",
        diagnosisDate: "2022-01-01",
        notes: "Patient reports redness and small bumps.",
      },
    ],
    treatmentHistory: [
      {
        treatment: "Laser Therapy",
        date: "2023-03-15",
        outcome: "Moderate improvement",
      },
    ],
  },
  {
    id: 2,
    name: "John Smith",
    email: "john.smith@example.com",
    phone: "(321) 654-0987",
    skinType: "Dry",
    concerns: "Eczema, Redness",
    avatar: "https://randomuser.me/api/portraits/men/44.jpg",
    dob: "1985-11-25",
    address: "456 Elm St, Springfield, USA",
    emergencyContact: "Jane Smith - (321) 888-1212",
    allergies: ["Latex"],
    medications: [
      {
        name: "Hydrocortisone Cream",
        dosage: "2.5%",
        frequency: "Twice daily",
        startDate: "05/01/2023",
        endDate: "06/01/2023",
      },
    ],
    medicalHistory: [
      {
        condition: "Eczema",
        diagnosisDate: "2020-08-10",
        notes: "Recurring flare-ups during dry weather.",
      },
    ],
    treatmentHistory: [
      {
        treatment: "Moisturizing Regimen",
        date: "2023-06-01",
        outcome: "Effective",
      },
    ],
  },
  {
    id: 3,
    name: "Alice Johnson",
    email: "alice.johnson@example.com",
    phone: "(555) 123-9876",
    skinType: "Combination",
    concerns: "Hyperpigmentation, Fine lines",
    avatar: "https://randomuser.me/api/portraits/women/72.jpg",
    dob: "1993-03-08",
    address: "789 Oak St, Cityville, USA",
    emergencyContact: "Bob Johnson - (555) 456-7890",
    allergies: ["None"],
    medications: [
      {
        name: "Tretinoin",
        dosage: "0.05%",
        frequency: "Nightly",
        startDate: "04/20/2023",
        endDate: "Present",
      },
    ],
    medicalHistory: [
      {
        condition: "Melasma",
        diagnosisDate: "2021-05-20",
        notes: "Triggered by sun exposure and hormones.",
      },
    ],
    treatmentHistory: [
      {
        treatment: "Chemical Peel",
        date: "2024-02-15",
        outcome: "Improved skin tone",
      },
    ],
  },
]);

const searchQuery = ref("");

const filteredPatients = computed(() => {
  if (!searchQuery.value.trim()) return patients.value;
  const query = searchQuery.value.toLowerCase();
  return patients.value.filter(
    (patient) =>
      patient.name.toLowerCase().includes(query) ||
      patient.email.toLowerCase().includes(query) ||
      patient.phone.toLowerCase().includes(query) ||
      patient.skinType.toLowerCase().includes(query) ||
      patient.concerns.toLowerCase().includes(query)
  );
});

const addPatient = (newPatient) => {
  patients.value.push(newPatient);
};
</script>

<style scoped>
.container {
  background-color: #f9fafb;
  min-height: 100vh;
  padding: 32px;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.page-title {
  font-size: 28px;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.add-btn {
  background-color: #4f46e5;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3);
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.add-btn:hover {
  background-color: #4338ca;
}

.table-wrapper {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.05);
  overflow-x: auto;
}

.patient-table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 8px;
  overflow: hidden;
}

.patient-table th {
  background-color: #f3f4f6;
  color: #6b7280;
  font-size: 13px;
  text-align: left;
  text-transform: uppercase;
  padding: 16px;
}

.patient-table td {
  padding: 16px;
  font-size: 14px;
  color: #111827;
  border-top: 1px solid #e5e7eb;
  vertical-align: middle;
}

.patient-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.patient-info img {
  width: 40px;
  height: 40px;
  border-radius: 9999px;
}

.actions i {
  color: #4f46e5;
  font-size: 15px;
  margin-right: 12px;
  cursor: pointer;
}

.top-controls {
  display: flex;
  align-items: center;
  gap: 12px;
}

.search-input {
  padding: 9px 14px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 14px;
  min-width: 220px;
  background-color: white;
  color: #111827;
}

.search-input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
}
</style>
