<template>
  <div class="page-wrapper" v-if="patient">
    <!-- Header -->
    <div class="header">
      <div class="profile">
        <img :src="patient.avatar" class="avatar" />
        <div class="info">
          <div class="info-head">
            <h2>{{ patient.name }}</h2>
            <i class="fas fa-pen edit-icon"></i>
          </div>
          <p class="email">{{ patient.email }}</p>
          <p class="phone">{{ patient.phone }}</p>
        </div>
      </div>
    </div>

    <!-- Bio Data + Allergies -->
    <div class="section-row">
      <div class="section">
        <div class="section-header">
          <h3>Bio Data</h3>
          <i class="fas fa-pen edit-icon"></i>
        </div>
        <ul class="info-list">
          <li><strong>Skin Type:</strong> {{ patient.skinType }}</li>
          <li><strong>Concerns:</strong> {{ patient.concerns }}</li>
          <li><strong>Date of Birth:</strong> {{ patient.dob }}</li>
          <li><strong>Address:</strong> {{ patient.address }}</li>
          <li><strong>Emergency Contact:</strong> {{ patient.emergencyContact }}</li>
        </ul>
      </div>
      <div class="section">
        <div class="section-header">
          <h3>Allergies</h3>
          <i class="fas fa-pen edit-icon"></i>
        </div>
        <ul class="info-list">
          <li v-for="(item, index) in patient.allergies" :key="index">{{ item }}</li>
        </ul>
      </div>
    </div>

    <!-- Medical History -->
    <div class="section">
      <div class="section-header">
        <h3>Medical History</h3>
        <i class="fas fa-pen edit-icon"></i>
      </div>
      <table class="history-table">
        <thead>
          <tr>
            <th>Medication</th>
            <th>Dosage</th>
            <th>Frequency</th>
            <th>Start Date</th>
            <th>End Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(med, index) in patient.medications" :key="index">
            <td>
              <strong>{{ med.name }}</strong>
            </td>
            <td>{{ med.dosage }}</td>
            <td>{{ med.frequency }}</td>
            <td>{{ med.startDate }}</td>
            <td>{{ med.endDate }}</td>
          </tr>
        </tbody>
      </table>
      <button class="add-btn" @click="openAddModal('medical')">
        <i class="fas fa-plus"></i> Add Medication
      </button>
    </div>

    <!-- Treatment History -->
    <div class="section">
      <div class="section-header">
        <h3>Treatment History</h3>
        <i class="fas fa-pen edit-icon"></i>
      </div>
      <table class="history-table">
        <thead>
          <tr>
            <th>Treatment</th>
            <th>Date</th>
            <th>Provider</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(treat, index) in patient.treatments" :key="index">
            <td>{{ treat.name }}</td>
            <td>{{ treat.date }}</td>
            <td>{{ treat.provider }}</td>
            <td>{{ treat.notes }}</td>
          </tr>
        </tbody>
      </table>
      <button class="add-btn" @click="openAddModal('treatment')">
        <i class="fas fa-plus"></i> Add Treatment
      </button>
    </div>

    <!-- Modal -->
    <div class="submodal-overlay" v-if="addModalType">
      <div class="submodal">
        <h3>Add {{ addModalType === "medical" ? "Medication" : "Treatment" }}</h3>
        <p class="placeholder">Form fields go here...</p>
        <div class="actions">
          <button @click="addModalType = ''">Cancel</button>
          <button class="save">Save</button>
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

<style scoped>
.page-wrapper {
  padding: 32px;
  font-family: "Inter", sans-serif;
}
.header .profile {
  display: flex;
  align-items: center;
  gap: 20px;
}
.avatar {
  width: 70px;
  height: 70px;
  border-radius: 50%;
}
.info {
  flex: 1;
}
.info-head {
  display: flex;
  align-items: center;
  gap: 8px;
}
.info h2 {
  font-size: 20px;
  font-weight: 600;
  color: #111827;
}
.email,
.phone {
  color: #6b7280;
  font-size: 14px;
}
.section-row {
  display: flex;
  justify-content: space-between;
  gap: 40px;
  margin-top: 30px;
}
.section {
  flex: 1;
  margin-top: 32px;
}
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}
.section-header h3 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
}
.edit-icon {
  color: #7c3aed;
  cursor: pointer;
}
.info-list {
  list-style: none;
  padding-left: 0;
  font-size: 14px;
  color: #374151;
}
.info-list li {
  margin-bottom: 6px;
}
.history-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 10px;
}
.history-table th {
  background-color: #f3f4f6;
  color: #6b7280;
  text-align: left;
  font-size: 13px;
  text-transform: uppercase;
  padding: 12px;
}
.history-table td {
  padding: 14px 12px;
  border-top: 1px solid #e5e7eb;
  font-size: 14px;
  color: #111827;
}
.add-btn {
  background-color: #f9f5ff;
  color: #7c3aed;
  border: 1px dashed #c4b5fd;
  font-size: 14px;
  padding: 8px 14px;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 12px;
}
.add-btn i {
  margin-right: 6px;
}
.submodal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1100;
}
.submodal {
  background: #fff;
  padding: 24px;
  border-radius: 12px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}
.submodal h3 {
  margin-bottom: 16px;
  font-size: 18px;
}
.placeholder {
  font-size: 14px;
  color: #6b7280;
  margin-bottom: 20px;
}
.actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}
.actions button {
  background: #e5e7eb;
  border: none;
  padding: 8px 14px;
  border-radius: 6px;
  cursor: pointer;
}
.actions .save {
  background: #7c3aed;
  color: white;
}
</style>
