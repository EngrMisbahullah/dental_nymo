<template>
  <div class="p-8 font-[Inter,sans-serif]" v-if="patient">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center gap-5">
        <img :src="patient.avatar" class="w-[70px] h-[70px] rounded-full object-cover" />
        <div class="flex-1">
          <div class="flex items-center gap-2">
            <h2 class="text-xl font-semibold text-gray-900 m-0">{{ patient.name }}</h2>
            <i class="fas fa-pen text-purple-600 cursor-pointer"></i>
          </div>
          <p class="text-gray-500 text-sm m-0">{{ patient.email }}</p>
          <p class="text-gray-500 text-sm m-0">{{ patient.phone }}</p>
        </div>
      </div>
    </div>

    <!-- Bio Data + Allergies -->
    <div class="flex flex-col lg:flex-row justify-between gap-10 mt-8">
      <div class="flex-1 mt-8">
        <div class="flex justify-between items-center mb-3">
          <h3 class="text-base font-semibold text-gray-900 m-0">Bio Data</h3>
          <i class="fas fa-pen text-purple-600 cursor-pointer"></i>
        </div>
        <ul class="list-none p-0 text-sm text-gray-700">
          <li class="mb-1.5"><strong>Skin Type:</strong> {{ patient.skinType }}</li>
          <li class="mb-1.5"><strong>Concerns:</strong> {{ patient.concerns }}</li>
          <li class="mb-1.5"><strong>Date of Birth:</strong> {{ patient.dob }}</li>
          <li class="mb-1.5"><strong>Address:</strong> {{ patient.address }}</li>
          <li class="mb-1.5"><strong>Emergency Contact:</strong> {{ patient.emergencyContact }}</li>
        </ul>
      </div>
      <div class="flex-1 mt-8">
        <div class="flex justify-between items-center mb-3">
          <h3 class="text-base font-semibold text-gray-900 m-0">Allergies</h3>
          <i class="fas fa-pen text-purple-600 cursor-pointer"></i>
        </div>
        <ul class="list-none p-0 text-sm text-gray-700">
          <li v-for="(item, index) in patient.allergies" :key="index" class="mb-1.5">{{ item }}</li>
        </ul>
      </div>
    </div>

    <!-- Medical History -->
    <div class="flex-1 mt-8">
      <div class="flex justify-between items-center mb-3">
        <h3 class="text-base font-semibold text-gray-900 m-0">Medical History</h3>
        <i class="fas fa-pen text-purple-600 cursor-pointer"></i>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full border-collapse mb-2.5">
          <thead>
            <tr>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Medication</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Dosage</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Frequency</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Start Date</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">End Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(med, index) in patient.medications" :key="index">
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">
                <strong>{{ med.name }}</strong>
              </td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ med.dosage }}</td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ med.frequency }}</td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ med.startDate }}</td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ med.endDate }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <button class="bg-purple-50 text-purple-600 border border-dashed border-purple-300 text-sm py-2 px-3.5 rounded-lg cursor-pointer mt-3 hover:bg-purple-100 transition-colors" @click="openAddModal('medical')">
        <i class="fas fa-plus mr-1.5"></i> Add Medication
      </button>
    </div>

    <!-- Treatment History -->
    <div class="flex-1 mt-8">
      <div class="flex justify-between items-center mb-3">
        <h3 class="text-base font-semibold text-gray-900 m-0">Treatment History</h3>
        <i class="fas fa-pen text-purple-600 cursor-pointer"></i>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full border-collapse mb-2.5">
          <thead>
            <tr>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Treatment</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Date</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Provider</th>
              <th class="bg-gray-100 text-gray-500 text-left text-xs uppercase p-3">Notes</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(treat, index) in patient.treatments" :key="index">
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ treat.name }}</td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ treat.date }}</td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ treat.provider }}</td>
              <td class="py-3.5 px-3 border-t border-gray-200 text-sm text-gray-900">{{ treat.notes }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <button class="bg-purple-50 text-purple-600 border border-dashed border-purple-300 text-sm py-2 px-3.5 rounded-lg cursor-pointer mt-3 hover:bg-purple-100 transition-colors" @click="openAddModal('treatment')">
        <i class="fas fa-plus mr-1.5"></i> Add Treatment
      </button>
    </div>

    <!-- Modal -->
    <div v-if="addModalType" class="fixed inset-0 bg-black/50 flex justify-center items-center z-[1100]">
      <div class="bg-white p-6 rounded-xl w-[400px] max-w-[90%] shadow-xl">
        <h3 class="mb-4 text-lg font-semibold">Add {{ addModalType === "medical" ? "Medication" : "Treatment" }}</h3>
        <p class="text-sm text-gray-500 mb-5">Form fields go here...</p>
        <div class="flex justify-end gap-3">
          <button @click="addModalType = ''" class="bg-gray-200 border-none py-2 px-3.5 rounded-md cursor-pointer hover:bg-gray-300 transition-colors">Cancel</button>
          <button class="bg-purple-600 text-white border-none py-2 px-3.5 rounded-md cursor-pointer hover:bg-purple-700 transition-colors">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const patient = ref(null);
const addModalType = ref("");

const openAddModal = (type) => {
  addModalType.value = type;
};

const fetchPatient = async (id) => {
  // Dummy example data
  const dummyPatients = [
    {
      id: "1",
      name: "John Doe",
      email: "john@example.com",
      phone: "+1234567890",
      avatar: "https://i.pravatar.cc/150?img=1",
      skinType: "Oily",
      concerns: "Acne, Pigmentation",
      dob: "1990-05-10",
      address: "123 Elm Street, NY",
      emergencyContact: "Jane Doe - +1234567891",
      allergies: ["Penicillin", "Peanuts"],
      medications: [
        {
          name: "Aspirin",
          dosage: "100mg",
          frequency: "Daily",
          startDate: "2023-01-01",
          endDate: "2023-03-01",
        },
      ],
      treatments: [
        {
          name: "Facial",
          date: "2024-02-15",
          provider: "Dr. Smith",
          notes: "Improved skin tone",
        },
      ],
    },
    {
      id: "2",
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
      id: "3",
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
  ];

  const found = dummyPatients.find((p) => p.id === id);
  if (found) {
    patient.value = found;
  } else {
    console.error("Patient not found for ID:", id);
  }
};

onMounted(() => {
  const id = route.params.id;
  if (id) {
    fetchPatient(id);
  } else {
    console.error("No patient ID found in route");
  }
});
</script>
