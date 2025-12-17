<template>
  <div id="app">
    <!-- Patient Form Modal -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal">
        <header class="modal-header">
          <h3>{{ isEditing ? "Edit Patient" : "Add New Patient" }}</h3>
          <button @click="closeModal" class="close-button">×</button>
        </header>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <!-- Patient Details Section -->
            <div class="form-section">
              <div class="form-grid">
                <div class="form-group">
                  <label>ID</label>
                  <input type="text" v-model="form.id" disabled />
                </div>
                <div class="form-group">
                  <label>Title</label>
                  <select v-model="form.title">
                    <option>Mr</option>
                    <option>Ms</option>
                    <option>Mrs</option>
                    <option>Dr</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>First name</label>
                  <input type="text" v-model="form.firstName" required />
                </div>
                <div class="form-group">
                  <label>Middle name</label>
                  <input type="text" v-model="form.middleName" />
                </div>
                <div class="form-group">
                  <label>Last name</label>
                  <input type="text" v-model="form.lastName" required />
                </div>
                <div class="form-group">
                  <label>Preferred name</label>
                  <input type="text" v-model="form.preferredName" />
                </div>
                <div class="form-group">
                  <label>Gender</label>
                  <select v-model="form.gender">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Date of birth</label>
                  <input type="date" v-model="form.dob" required />
                </div>
                <div class="form-group">
                  <label>NI number</label>
                  <input type="text" v-model="form.niNumber" />
                </div>
                <div class="form-group">
                  <label>NHS number</label>
                  <input type="text" v-model="form.nhsNumber" />
                </div>
                <div class="form-group">
                  <label>Insurance number</label>
                  <input type="text" v-model="form.insuranceNumber" />
                </div>
                <div class="form-group">
                  <label>Legacy ID</label>
                  <input type="text" v-model="form.legacyId" />
                </div>
                <div class="form-group">
                  <label>Ethnicity</label>
                  <select v-model="form.ethnicity">
                    <option>British</option>
                    <option>Irish</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>GP</label>
                  <input type="text" v-model="form.gp" />
                </div>
              </div>
            </div>

            <!-- Contact Details Section -->
            <div class="form-section">
              <h4>Contact Details</h4>
              <div class="form-grid">
                <div class="form-group">
                  <label>Address line 1</label>
                  <input type="text" v-model="form.address1" required />
                </div>
                <div class="form-group">
                  <label>Address line 2</label>
                  <input type="text" v-model="form.address2" />
                </div>
                <div class="form-group">
                  <label>Town</label>
                  <input type="text" v-model="form.town" required />
                </div>
                <div class="form-group">
                  <label>County</label>
                  <input type="text" v-model="form.county" required />
                </div>
                <div class="form-group">
                  <label>Postcode</label>
                  <input type="text" v-model="form.postcode" required />
                </div>
                <div class="form-group">
                  <label>Home phone</label>
                  <input type="tel" v-model="form.homePhone" />
                </div>
                <div class="form-group">
                  <label>Work phone</label>
                  <input type="tel" v-model="form.workPhone" />
                </div>
                <div class="form-group">
                  <label>Mobile phone</label>
                  <input type="tel" v-model="form.mobilePhone" required />
                </div>
                <div class="form-group">
                  <label>Preferred phone</label>
                  <select v-model="form.preferredPhone">
                    <option>Home</option>
                    <option>Work</option>
                    <option>Mobile</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" v-model="form.email" />
                </div>
                <div class="form-group">
                  <label>Doctor</label>
                  <input type="text" v-model="form.doctor" />
                </div>
                <div class="form-group">
                  <label>Occupation</label>
                  <input type="text" v-model="form.occupation" />
                </div>
              </div>
            </div>

            <!-- Practice Details Section -->
            <div class="form-section">
              <h4>Practice Details</h4>
              <div class="form-grid">
                <div class="form-group">
                  <label>Location</label>
                  <input type="text" v-model="form.location" />
                </div>
                <div class="form-group">
                  <label>Payment plan</label>
                  <select v-model="form.paymentPlan">
                    <option>Private</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Account</label>
                  <input type="text" v-model="form.account" />
                </div>
                <div class="form-group">
                  <label>Dentist</label>
                  <input type="text" v-model="form.dentist" />
                </div>
                <div class="form-group">
                  <label>Hygienist</label>
                  <input type="text" v-model="form.hygienist" />
                </div>
                <div class="form-group">
                  <label>Receive email</label>
                  <select v-model="form.receiveEmail">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Receive SMS</label>
                  <select v-model="form.receiveSms">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Marketing Consent</label>
                  <select v-model="form.marketingConsent">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Dentist recall interval</label>
                  <input type="text" v-model="form.dentistRecallInterval" />
                </div>
                <div class="form-group">
                  <label>Next dentist recall</label>
                  <input type="date" v-model="form.nextDentistRecall" />
                </div>
                <div class="form-group">
                  <label>Hygienist recall interval</label>
                  <input type="text" v-model="form.hygienistRecallInterval" />
                </div>
                <div class="form-group">
                  <label>Next hygienist recall</label>
                  <input type="date" v-model="form.nextHygienistRecall" />
                </div>
                <div class="form-group">
                  <label>Recall method</label>
                  <select v-model="form.recallMethod">
                    <option>SMS</option>
                    <option>Email</option>
                    <option>Phone</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Acquisition source</label>
                  <input type="text" v-model="form.acquisitionSource" />
                </div>
              </div>
            </div>
          </form>
        </div>
        <footer class="modal-footer">
          <button class="save-button" @click="submitForm">
            {{ isEditing ? "Save Changes" : "Save Patient" }}
          </button>
        </footer>
      </div>
    </div>

    <!-- Main Content for the Page -->
    <main class="main-content">
      <div class="content-wrapper">
        <!-- Patient List Panel -->
        <div class="patient-list-panel">
          <div class="panel-header">
            <h2 class="panel-title">All Patients</h2>
            <button class="add-button" @click="openModal(false)">
              <span class="material-icons">add</span>
              Add New Patient
            </button>
          </div>
          <div class="patient-list">
            <div
              v-for="patient in paginatedPatients"
              :key="patient.id"
              :class="[
                'patient-list-item',
                { active: selectedPatient && selectedPatient.id === patient.id },
              ]"
              @click="selectPatient(patient)"
            >
              <img :src="patient.image" :alt="patient.name" class="patient-avatar" />
              <div>
                <p class="patient-name">{{ patient.name }}</p>
                <p class="patient-last-visit">{{ patient.lastVisit }}</p>
              </div>
            </div>
          </div>
          <div class="pagination">
            <button @click="prevPage" :disabled="currentPage === 1" class="page-button">
              Previous
            </button>
            <span class="page-info">Page {{ currentPage }} of {{ totalPages }}</span>
            <button
              @click="nextPage"
              :disabled="currentPage === totalPages"
              class="page-button"
            >
              Next
            </button>
          </div>
        </div>

        <!-- Patient Details Panel -->
        <div class="patient-details-panel">
          <div v-if="selectedPatient">
            <div class="details-header">
              <div class="flex-center">
                <img
                  :src="selectedPatient.image"
                  :alt="selectedPatient.name"
                  class="details-avatar"
                />
                <div>
                  <h2 class="details-name">{{ selectedPatient.name }}</h2>
                  <p class="details-id">ID: {{ selectedPatient.id }}</p>
                  <div class="vip-status">
                    <span class="material-icons">star</span>
                    <span class="vip-text">VIP Patient</span>
                  </div>
                </div>
              </div>
              <div class="action-buttons">
                <button class="action-button" @click="openModal(true)">
                  <span class="material-icons">edit</span>
                </button>
                <button class="action-button">
                  <span class="material-icons">print</span>
                </button>
                <button class="action-button delete-button">
                  <span class="material-icons">delete</span>
                </button>
              </div>
            </div>

            <!-- Tabbed Details Content -->
            <div class="details-body">
              <div class="tabs-container">
                <nav class="tabs-nav">
                  <a
                    v-for="tab in tabs"
                    :key="tab"
                    :class="['tab-link', { 'tab-active': activeTab === tab }]"
                    @click="activeTab = tab"
                  >
                    {{ tab }}
                  </a>
                </nav>
              </div>

              <!-- Tab Content -->
              <div class="tab-content">
                <div v-if="activeTab === 'Patient Info'" class="grid-content">
                  <div class="info-item">
                    <h4 class="info-label">Full Name</h4>
                    <p class="info-text">{{ selectedPatient.fullName }}</p>
                  </div>
                  <div class="info-item">
                    <h4 class="info-label">Date of Birth</h4>
                    <p class="info-text">{{ selectedPatient.dob }}</p>
                  </div>
                  <div class="info-item">
                    <h4 class="info-label">Email Address</h4>
                    <p class="info-text">{{ selectedPatient.email }}</p>
                  </div>
                  <div class="info-item">
                    <h4 class="info-label">Phone Number</h4>
                    <p class="info-text">{{ selectedPatient.phone }}</p>
                  </div>
                  <div class="info-item-full">
                    <h4 class="info-label">Address</h4>
                    <p class="info-text">{{ selectedPatient.address }}</p>
                  </div>
                  <div class="info-item-full">
                    <h4 class="info-label">Primary Dental Concerns</h4>
                    <div class="concern-tags">
                      <span
                        v-for="concern in selectedPatient.concerns"
                        :key="concern"
                        class="concern-tag"
                      >
                        {{ concern }}
                      </span>
                    </div>
                  </div>
                </div>

                <div
                  v-else-if="activeTab === 'Appointments'"
                  class="tab-scroll-container"
                >
                  <div
                    v-for="appointment in selectedPatient.appointments"
                    :key="appointment.id"
                    class="appointment-item"
                  >
                    <div class="appointment-date">{{ appointment.date }}</div>
                    <div class="appointment-details">
                      <p class="appointment-title">{{ appointment.title }}</p>
                      <p class="appointment-time">{{ appointment.time }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="empty-state">
            <p>Select a patient to view details.</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showModal: false,
      isEditing: false,
      form: {
        id: "",
        title: "Mr",
        firstName: "",
        middleName: "",
        lastName: "",
        preferredName: "",
        gender: "Male",
        dob: "",
        niNumber: "",
        nhsNumber: "",
        insuranceNumber: "",
        legacyId: "",
        ethnicity: "British",
        gp: "",
        address1: "",
        address2: "",
        town: "",
        county: "",
        postcode: "",
        homePhone: "",
        workPhone: "",
        mobilePhone: "",
        preferredPhone: "Mobile",
        email: "",
        doctor: "",
        occupation: "",
        location: "",
        paymentPlan: "Private",
        account: "",
        dentist: "",
        hygienist: "",
        receiveEmail: "Yes",
        receiveSms: "Yes",
        marketingConsent: "Yes",
        dentistRecallInterval: "",
        nextDentistRecall: "",
        hygienistRecallInterval: "",
        nextHygienistRecall: "",
        recallMethod: "SMS",
        acquisitionSource: "",
      },
      patients: [
        {
          id: 1,
          name: "Dr. Alistair Finch",
          image: "https://randomuser.me/api/portraits/men/1.jpg",
          lastVisit: "Last Visit: 2 days ago",
          fullName: "Alistair Finch",
          dob: "1985-05-15",
          email: "alistair.finch@example.com",
          phone: "+44 7700 900001",
          address: "123 Elm Street, Manchester, M1 1AA",
          concerns: ["Toothache", "Cavity"],
          appointments: [
            { id: 1, date: "2023-04-20", title: "Dental Check-up", time: "10:30 AM" },
            { id: 2, date: "2023-03-10", title: "Scale and Polish", time: "02:00 PM" },
          ],
        },
        {
          id: 2,
          name: "Isabella Chen",
          image: "https://randomuser.me/api/portraits/women/2.jpg",
          lastVisit: "Last Visit: 5 days ago",
          fullName: "Isabella Chen",
          dob: "1992-11-23",
          email: "isabella.chen@example.com",
          phone: "+44 7700 900002",
          address: "456 Oak Avenue, London, E1 2BC",
          concerns: ["Wisdom Tooth Pain"],
          appointments: [
            {
              id: 3,
              date: "2023-04-18",
              title: "Wisdom Tooth Extraction",
              time: "09:00 AM",
            },
          ],
        },
        {
          id: 3,
          name: "Marcus Thorne",
          image: "https://randomuser.me/api/portraits/men/3.jpg",
          lastVisit: "Last Visit: 1 week ago",
          fullName: "Marcus Thorne",
          dob: "1978-08-01",
          email: "marcus.thorne@example.com",
          phone: "+44 7700 900003",
          address: "789 Pine Road, Birmingham, B2 3CD",
          concerns: ["Orthodontic Consultation"],
          appointments: [
            {
              id: 4,
              date: "2023-04-15",
              title: "Orthodontic Consultation",
              time: "01:00 PM",
            },
          ],
        },
        {
          id: 4,
          name: "Sophia Rodriguez",
          image: "https://randomuser.me/api/portraits/women/4.jpg",
          lastVisit: "Last Visit: 1 month ago",
          fullName: "Sophia Rodriguez",
          dob: "1998-02-14",
          email: "sophia.rodriguez@example.com",
          phone: "+44 7700 900004",
          address: "101 Maple Lane, Bristol, BS1 4DE",
          concerns: ["Teeth Whitening"],
          appointments: [
            { id: 5, date: "2023-03-20", title: "Teeth Whitening", time: "11:00 AM" },
          ],
        },
        {
          id: 5,
          name: "Leo Carter",
          image: "https://randomuser.me/api/portraits/men/5.jpg",
          lastVisit: "Last Visit: 2 months ago",
          fullName: "Leo Carter",
          dob: "1989-06-30",
          email: "leo.carter@example.com",
          phone: "+44 7700 900005",
          address: "202 Cedar Street, Leeds, LS2 5EF",
          concerns: ["Routine Check-up"],
          appointments: [
            { id: 6, date: "2023-02-15", title: "Routine Check-up", time: "03:00 PM" },
          ],
        },
        {
          id: 6,
          name: "Dr. Olivia Hayes",
          image: "https://randomuser.me/api/portraits/women/6.jpg",
          lastVisit: "Last Visit: 3 weeks ago",
          fullName: "Olivia Hayes",
          dob: "1975-09-09",
          email: "olivia.hayes@example.com",
          phone: "+44 7700 900006",
          address: "303 Birch Place, Glasgow, G1 5GH",
          concerns: ["Denture Fitting"],
          appointments: [
            { id: 7, date: "2023-04-01", title: "Denture Fitting", time: "04:00 PM" },
          ],
        },
      ],
      selectedPatient: null,
      activeTab: "Patient Info",
      tabs: ["Patient Info", "Appointments", "Family", "Invoices", "Documents"],
      currentPage: 1,
      patientsPerPage: 10,
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.patients.length / this.patientsPerPage);
    },
    paginatedPatients() {
      const start = (this.currentPage - 1) * this.patientsPerPage;
      const end = start + this.patientsPerPage;
      return this.patients.slice(start, end);
    },
  },
  created() {
    this.selectPatient(this.patients[0]);
  },
  methods: {
    openModal(isEditing) {
      this.isEditing = isEditing;
      this.showModal = true;
      if (isEditing && this.selectedPatient) {
        this.form = { ...this.selectedPatient };
      }
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    selectPatient(patient) {
      this.selectedPatient = patient;
    },
    submitForm() {
      if (this.isEditing) {
        const index = this.patients.findIndex((p) => p.id === this.form.id);
        if (index !== -1) {
          this.patients.splice(index, 1, { ...this.form });
        }
      } else {
        const newId =
          this.patients.length > 0 ? Math.max(...this.patients.map((p) => p.id)) + 1 : 1;
        this.patients.push({ ...this.form, id: newId });
      }
      this.closeModal();
    },
    resetForm() {
      this.form = {
        id: "",
        title: "Mr",
        firstName: "",
        middleName: "",
        lastName: "",
        preferredName: "",
        gender: "Male",
        dob: "",
        niNumber: "",
        nhsNumber: "",
        insuranceNumber: "",
        legacyId: "",
        ethnicity: "British",
        gp: "",
        address1: "",
        address2: "",
        town: "",
        county: "",
        postcode: "",
        homePhone: "",
        workPhone: "",
        mobilePhone: "",
        preferredPhone: "Mobile",
        email: "",
        doctor: "",
        occupation: "",
        location: "",
        paymentPlan: "Private",
        account: "",
        dentist: "",
        hygienist: "",
        receiveEmail: "Yes",
        receiveSms: "Yes",
        marketingConsent: "Yes",
        dentistRecallInterval: "",
        nextDentistRecall: "",
        hygienistRecallInterval: "",
        nextHygienistRecall: "",
        recallMethod: "SMS",
        acquisitionSource: "",
      };
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
};
</script>

<style scoped>
/* Main layout */
.main-content {
  padding: 20px 30px;
  background-color: #f3f5f7;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  background-color: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}
.page-title {
  font-size: 28px;
  font-weight: 600;
  color: #303030;
}
.header-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}
.search-container {
  position: relative;
  display: flex;
  align-items: center;
}
.search-input {
  padding: 10px 10px 10px 40px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
}
.search-icon {
  position: absolute;
  left: 10px;
  color: #888;
}
.add-button {
  display: flex;
  align-items: center;
  gap: 8px;
  background-color: #34a7d8;
  color: #fff;
  padding: 10px 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.3s;
}
.add-button:hover {
  background-color: #3491d8;
}
.content-wrapper {
  display: flex;
  gap: 20px;
  min-height: calc(100vh - 100px);
}
.patient-list-panel {
  flex-basis: 350px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  padding: 20px;
  display: flex;
  flex-direction: column;
}
.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}
.panel-title {
  font-size: 20px;
  font-weight: 600;
  color: #333;
  margin: 0;
}
.patient-list {
  flex-grow: 1;
  overflow-y: auto;
}
.patient-list-item {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s;
}
.patient-list-item:hover,
.patient-list-item.active {
  background-color: #f0f0f0;
}
.patient-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}
.patient-name {
  font-weight: 600;
  margin-bottom: 2px;
  font-size: 14px;
}
.patient-last-visit {
  font-size: 12px;
  color: #888;
}
.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 15px;
}
.page-button {
  background-color: #f0f0f0;
  border: none;
  padding: 8px 12px;
  border-radius: 8px;
  cursor: pointer;
}
.page-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.patient-details-panel {
  flex-grow: 1;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  padding: 20px;
  display: flex;
  flex-direction: column;
}
.empty-state {
  text-align: center;
  padding: 50px;
  color: #888;
}
.details-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 20px;
  border-bottom: 1px solid #eee;
}
.flex-center {
  display: flex;
  align-items: center;
  gap: 15px;
}
.details-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
}
.details-name {
  font-size: 24px;
  font-weight: 600;
  color: #333;
}
.details-id {
  font-size: 14px;
  color: #888;
}
.vip-status {
  display: flex;
  align-items: center;
  gap: 5px;
  color: gold;
  font-size: 14px;
}
.vip-text {
  font-weight: 600;
}
.action-buttons {
  display: flex;
  gap: 10px;
}
.action-button {
  background-color: #eee;
  border: none;
  padding: 8px;
  border-radius: 50%;
  cursor: pointer;
}
.action-button:hover {
  background-color: #ddd;
}
.delete-button {
  color: #ef4444;
}
.details-body {
  flex-grow: 1;
  padding-top: 20px;
  display: flex;
  flex-direction: column;
}
.tabs-container {
  margin-bottom: 15px;
}
.tabs-nav {
  display: flex;
  border-bottom: 2px solid #eee;
  margin-bottom: 20px;
}
.tab-link {
  padding: 10px 15px;
  text-decoration: none;
  color: #888;
  font-weight: 500;
  transition: all 0.2s;
}
.tab-active {
  color: #4b3c97;
  border-bottom: 2px solid #4b3c97;
}
.grid-content {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}
.info-item {
  display: flex;
  flex-direction: column;
}
.info-label {
  font-size: 14px;
  font-weight: 500;
  color: #888;
  margin-bottom: 4px;
}
.info-text {
  font-size: 16px;
  font-weight: 600;
  color: #333;
}
.info-item-full {
  grid-column: 1 / -1;
}
.concern-tags {
  display: flex;
  gap: 8px;
}
.concern-tag {
  background-color: #e6f7ff;
  color: #1890ff;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
}
.tab-scroll-container {
  flex-grow: 1;
  overflow-y: auto;
}
.appointment-item {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 12px;
  border-bottom: 1px solid #eee;
}
.appointment-date {
  font-size: 14px;
  font-weight: 600;
  color: #4b3c97;
}
.appointment-details {
  flex-grow: 1;
}
.appointment-title {
  font-weight: 600;
  margin-bottom: 2px;
}
.appointment-time {
  font-size: 14px;
  color: #888;
}

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  width: 80%;
  max-width: 900px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e0e0e0;
}
.modal-header h3 {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
  color: #333;
}
.close-button {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #888;
}
.modal-body {
  padding: 24px;
  overflow-y: auto;
  flex-grow: 1;
}
.form-section {
  margin-bottom: 20px;
}
.form-section h4 {
  font-size: 16px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 12px;
  border-bottom: 1px solid #e5e7eb;
  padding-bottom: 8px;
}
.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
}
.form-group {
  display: flex;
  flex-direction: column;
}
.form-group label {
  font-size: 12px;
  font-weight: 500;
  color: #4b5563;
  margin-bottom: 4px;
}
.form-group input,
.form-group select {
  padding: 8px 10px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
}
.modal-footer {
  padding: 16px 24px;
  border-top: 1px solid #e0e0e0;
  display: flex;
  justify-content: flex-end;
}
.save-button {
  background-color: #34a7d8;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
}
.save-button:hover {
  background-color: #3491d8;
}
</style>
