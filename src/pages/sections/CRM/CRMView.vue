<template>
  <div class="bg-gray-50 min-h-screen p-8">
    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
      <h1 class="text-[28px] font-bold text-gray-900 m-0">Patients</h1>
      <div class="flex items-center gap-3">
        <input
          v-model="searchQuery"
          type="text"
          class="py-2.5 px-3.5 border border-gray-300 rounded-lg text-sm min-w-[220px] bg-white text-gray-900 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20"
          placeholder="Search patients..."
        />
        <router-link to="/dashboard/crm/add-patient" class="bg-indigo-600 text-white py-2.5 px-4 border-none rounded-lg text-sm font-medium shadow-md hover:bg-indigo-700 transition-colors no-underline">
          + Add Patient
        </router-link>
      </div>
    </div>

    <!-- Patient Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
      <table class="w-full border-collapse rounded-lg overflow-hidden">
        <thead>
          <tr>
            <th class="bg-gray-100 text-gray-500 text-xs text-left uppercase p-4">Patient Name</th>
            <th class="bg-gray-100 text-gray-500 text-xs text-left uppercase p-4">Email</th>
            <th class="bg-gray-100 text-gray-500 text-xs text-left uppercase p-4">Phone</th>
            <th class="bg-gray-100 text-gray-500 text-xs text-left uppercase p-4">Skin Type</th>
            <th class="bg-gray-100 text-gray-500 text-xs text-left uppercase p-4">Concerns</th>
            <th class="bg-gray-100 text-gray-500 text-xs text-left uppercase p-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(patient, index) in filteredPatients" :key="index" class="hover:bg-gray-50">
            <td class="p-4 text-sm text-gray-900 border-t border-gray-200 align-middle">
              <div class="flex items-center gap-3">
                <span>{{ patient.name }}</span>
              </div>
            </td>
            <td class="p-4 text-sm text-gray-900 border-t border-gray-200 align-middle">{{ patient.email }}</td>
            <td class="p-4 text-sm text-gray-900 border-t border-gray-200 align-middle">{{ patient.phone }}</td>
            <td class="p-4 text-sm text-gray-900 border-t border-gray-200 align-middle">{{ patient.skinType }}</td>
            <td class="p-4 text-sm text-gray-900 border-t border-gray-200 align-middle">{{ patient.concerns }}</td>
            <td class="p-4 text-sm text-gray-900 border-t border-gray-200 align-middle">
              <div class="flex gap-3">
                <i class="fas fa-eye text-indigo-600 text-base cursor-pointer hover:text-indigo-700" @click="goToViewPatient(patient.id)"></i>
                <i class="fas fa-pen text-indigo-600 text-base cursor-pointer hover:text-indigo-700"></i>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modals -->
    <router-view />
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
