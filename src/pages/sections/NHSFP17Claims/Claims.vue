<template>
  <!-- Main container with light gray background -->
  <div class="main-container">
    <!-- Card-like content container -->
    <div class="content-container">
      <!-- Combined buttons and tab navigation section -->
      <div class="header-section">
        <div class="flex-grow">
          <div class="tab-nav">
            <a
              v-for="tab in tabs"
              :key="tab.id"
              :class="['tab-item', { active: activeTab === tab.id }]"
              @click="selectTab(tab.id)"
            >
              <p>{{ tab.name }}</p>
            </a>
          </div>
        </div>
        <div class="flex-shrink-0 flex gap-4 mt-4 md:mt-0">
          <button class="action-btn new-claim-btn" @click="openModal('New Claim')">
            <span class="truncate">➕ New Claim</span>
          </button>
          <button class="action-btn submit-batch-btn" @click="openModal('Submit Batch')">
            <span class="truncate">📤 Submit Batch</span>
          </button>
          <button class="action-btn reports-btn" @click="downloadCSV('all')">
            <span class="truncate">📄 Reports</span>
          </button>
        </div>
      </div>

      <!-- Search Bar -->
      <div class="search-bar">
        <label class="search-input-wrapper">
          <div class="search-icon">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24px"
              height="24px"
              fill="currentColor"
              viewBox="0 0 256 256"
            >
              <path
                d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"
              ></path>
            </svg>
          </div>
          <input
            placeholder="Search by patient name, performer, claim ID, or band"
            class="search-input"
          />
        </label>
      </div>

      <!-- Claims Table -->
      <div class="table-container">
        <table class="claims-table">
          <thead>
            <tr>
              <th class="claim-id">Claim ID</th>
              <th class="patient">Patient</th>
              <th class="band">Band</th>
              <th class="performer">Performer</th>
              <th class="status">Status</th>
              <th class="submission-date">Submission Date</th>
              <th class="actions">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="claim in paginatedClaims" :key="claim.id">
              <td>{{ claim.id }}</td>
              <td>{{ claim.patient }}</td>
              <td>{{ claim.band }}</td>
              <td>{{ claim.performer }}</td>
              <td>
                <span :class="['status-badge', getStatusClass(claim.status)]">{{
                  claim.status
                }}</span>
              </td>
              <td>{{ claim.submissionDate }}</td>
              <td class="action-buttons">
                <button
                  v-if="claim.status === 'Error' || claim.status === 'Rejected'"
                  class="action-link"
                  @click="openModal('Fix & Resubmit', claim)"
                >
                  Fix & Resubmit
                </button>
                <button class="action-link" @click="openModal('View Claim', claim)">
                  View Claim
                </button>
                <button class="action-link" @click="openModal('View XML', claim)">
                  View XML
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="paginatedClaims.length === 0" class="no-data">
          No claims found for this status.
        </div>
      </div>

      <!-- Pagination Controls -->
      <div class="pagination-container">
        <button
          class="pagination-btn"
          :disabled="currentPage === 1"
          @click="selectPage(currentPage - 1)"
        >
          Previous
        </button>
        <span class="page-info">Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          class="pagination-btn"
          :disabled="currentPage === totalPages"
          @click="selectPage(currentPage + 1)"
        >
          Next
        </button>
      </div>

      <!-- Modal Popup -->
      <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content-wrapper">
          <div class="modal-header">
            <h2 class="modal-title">{{ modalTitle }}</h2>
            <button class="close-btn" @click="closeModal">&times;</button>
          </div>
          <div class="modal-body">
            <!-- New Claim Form -->
            <div v-if="modalType === 'New Claim' || modalType === 'Fix & Resubmit'">
              <h3 class="modal-subtitle">Claim Details</h3>
              <div class="form-grid">
                <div class="form-field">
                  <label for="patientName" class="label">Patient Name</label>
                  <input
                    type="text"
                    id="patientName"
                    v-model="form.patient"
                    class="input"
                  />
                </div>
                <div class="form-field">
                  <label for="claimId" class="label">Claim ID</label>
                  <input
                    type="text"
                    id="claimId"
                    v-model="form.id"
                    class="input"
                    :disabled="modalType === 'Fix & Resubmit'"
                  />
                </div>
                <div class="form-field">
                  <label for="band" class="label">Band</label>
                  <select id="band" v-model="form.band" class="input">
                    <option value="Band 1">Band 1</option>
                    <option value="Band 2">Band 2</option>
                    <option value="Band 3">Band 3</option>
                  </select>
                </div>
                <div class="form-field">
                  <label for="performer" class="label">Performer</label>
                  <input
                    type="text"
                    id="performer"
                    v-model="form.performer"
                    class="input"
                  />
                </div>
                <div class="form-field">
                  <label for="submissionDate" class="label">Submission Date</label>
                  <input
                    type="date"
                    id="submissionDate"
                    v-model="form.submissionDate"
                    class="input"
                  />
                </div>
                <div class="form-field">
                  <label for="status" class="label">Status</label>
                  <input type="text" id="status" v-model="form.status" class="input" />
                </div>
              </div>
              <div class="form-actions">
                <button class="submit-btn" @click="closeModal">
                  {{ modalType === "New Claim" ? "Create Claim" : "Save Changes" }}
                </button>
              </div>
            </div>

            <!-- View Claim Details -->
            <div v-else-if="modalType === 'View Claim'">
              <h3 class="modal-subtitle">Claim Details</h3>
              <div class="details-grid">
                <div class="detail-item">
                  <span class="label-text">Claim ID:</span>
                  <span class="detail-text">{{ selectedClaim.id }}</span>
                </div>
                <div class="detail-item">
                  <span class="label-text">Patient:</span>
                  <span class="detail-text">{{ selectedClaim.patient }}</span>
                </div>
                <div class="detail-item">
                  <span class="label-text">Band:</span>
                  <span class="detail-text">{{ selectedClaim.band }}</span>
                </div>
                <div class="detail-item">
                  <span class="label-text">Performer:</span>
                  <span class="detail-text">{{ selectedClaim.performer }}</span>
                </div>
                <div class="detail-item">
                  <span class="label-text">Status:</span>
                  <span class="detail-text"
                    ><span
                      :class="['status-badge', getStatusClass(selectedClaim.status)]"
                      >{{ selectedClaim.status }}</span
                    ></span
                  >
                </div>
                <div class="detail-item">
                  <span class="label-text">Submission Date:</span>
                  <span class="detail-text">{{ selectedClaim.submissionDate }}</span>
                </div>
              </div>
            </div>

            <!-- View XML Data -->
            <div v-else-if="modalType === 'View XML'">
              <h3 class="modal-subtitle">XML Data</h3>
              <pre class="xml-block">{{ generateXML(selectedClaim) }}</pre>
            </div>

            <!-- Submit Batch Confirmation -->
            <div v-else-if="modalType === 'Submit Batch'">
              <h3 class="modal-subtitle">Batch Submission</h3>
              <p class="modal-message">
                Are you sure you want to submit all pending claims as a batch?
                <br />This action will group all claims with the status "Pending" and send
                them to the NHS BSA EDI gateway.
              </p>
              <div class="form-actions">
                <button class="submit-btn" @click="performBatchSubmission">
                  Confirm Submission
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";

// Define the available tabs
const tabs = ref([
  { id: "all", name: "All" },
  { id: "pending", name: "Pending" },
  { id: "submitted", name: "Submitted" },
  { id: "accepted", name: "Accepted" },
  { id: "rejected", name: "Rejected" },
  { id: "error", name: "Errors" },
]);

// Reactive state for the application
const activeTab = ref("all");
const currentPage = ref(1);
const itemsPerPage = 10;
const showModal = ref(false);
const modalTitle = ref("");
const modalType = ref("");
const selectedClaim = ref(null);
const form = ref({});

// Watch for changes to the selectedClaim and update the form
watch(selectedClaim, (newClaim) => {
  if (newClaim) {
    form.value = { ...newClaim };
  } else {
    form.value = {
      id: "",
      patient: "",
      band: "Band 1",
      performer: "",
      submissionDate: new Date().toISOString().split("T")[0],
      status: "Pending",
    };
  }
});

// Dummy data for each claim status
const allClaimsData = ref(generateDummyData("all", 50));
const pendingClaimsData = ref(generateDummyData("pending", 12));
const submittedClaimsData = ref(generateDummyData("submitted", 20));
const acceptedClaimsData = ref(generateDummyData("accepted", 15));
const rejectedClaimsData = ref(generateDummyData("rejected", 8));
const errorClaimsData = ref(generateDummyData("error", 5));

// Function to generate dummy data
function generateDummyData(status, count) {
  const claims = [];
  const patients = [
    "Olivia Bennett",
    "Ethan Thompson",
    "Sophia Hayes",
    "Noah Foster",
    "Isabella Mitchell",
    "Lucas Reed",
    "Mia Coleman",
    "Alexander Ward",
    "Amelia Powell",
    "Henry Hughes",
  ];
  const bands = ["Band 1", "Band 2", "Band 3"];
  const performers = ["Dr. Emily Carter", "Dr. Jacob Turner", "Dr. Sarah Lee"];

  for (let i = 1; i <= count; i++) {
    const randomPatient = patients[Math.floor(Math.random() * patients.length)];
    const randomBand = bands[Math.floor(Math.random() * bands.length)];
    const randomPerformer = performers[Math.floor(Math.random() * performers.length)];

    let claimStatus = status;
    if (status === "all") {
      const allStatuses = ["Pending", "Submitted", "Accepted", "Rejected", "Error"];
      claimStatus = allStatuses[Math.floor(Math.random() * allStatuses.length)];
    }

    claims.push({
      id: `#${Math.floor(10000 + Math.random() * 90000)}`,
      patient: randomPatient,
      band: randomBand,
      performer: randomPerformer,
      status: claimStatus,
      submissionDate: new Date(
        Date.now() - Math.floor(Math.random() * 30) * 24 * 60 * 60 * 1000
      )
        .toISOString()
        .split("T")[0],
    });
  }
  return claims;
}

// Computed property to get the claims for the active tab
const filteredClaims = computed(() => {
  switch (activeTab.value) {
    case "pending":
      return pendingClaimsData.value;
    case "submitted":
      return submittedClaimsData.value;
    case "accepted":
      return acceptedClaimsData.value;
    case "rejected":
      return rejectedClaimsData.value;
    case "error":
      return errorClaimsData.value;
    case "all":
    default:
      return allClaimsData.value;
  }
});

// Computed property for pagination
const paginatedClaims = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredClaims.value.slice(start, end);
});

// Computed property to calculate total pages
const totalPages = computed(() => {
  return Math.ceil(filteredClaims.value.length / itemsPerPage);
});

// Function to handle tab selection
const selectTab = (tab) => {
  activeTab.value = tab;
  currentPage.value = 1; // Reset page to 1 when tab changes
};

// Function to handle page change
const selectPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

// Function to get the status color class
const getStatusClass = (status) => {
  switch (status) {
    case "Accepted":
      return "status-accepted";
    case "Submitted":
      return "status-submitted";
    case "Pending":
      return "status-pending";
    case "Rejected":
      return "status-rejected";
    case "Error":
      return "status-error";
    default:
      return "";
  }
};

// Functions to control the modal popup
const openModal = (type, claim = null) => {
  modalType.value = type;
  selectedClaim.value = claim;

  switch (type) {
    case "New Claim":
      modalTitle.value = "New Claim Form";
      break;
    case "Fix & Resubmit":
      modalTitle.value = `Fix & Resubmit Claim: ${claim.id}`;
      break;
    case "View Claim":
      modalTitle.value = `View Claim Details: ${claim.id}`;
      break;
    case "View XML":
      modalTitle.value = `View XML Data for: ${claim.id}`;
      break;
    case "Submit Batch":
      modalTitle.value = "Batch Submission";
      break;
  }

  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedClaim.value = null;
  form.value = {};
};

// Function to handle the batch submission
const performBatchSubmission = () => {
  // Find all pending claims
  const claimsToSubmit = pendingClaimsData.value;

  // Simulate updating the status of claims
  claimsToSubmit.forEach((claim) => {
    claim.status = "Submitted";
  });

  // Clear the pending claims data and update other lists
  allClaimsData.value = allClaimsData.value.filter((c) => c.status !== "Pending");
  submittedClaimsData.value.push(...claimsToSubmit);
  pendingClaimsData.value = [];

  // Update the UI to reflect the changes
  closeModal();
  selectTab("submitted");
};

// Function to generate dummy XML data
const generateXML = (claim) => {
  return `<Claim id="${claim.id}">
  <Patient>
    <Name>${claim.patient}</Name>
  </Patient>
  <Performer>
    <Name>${claim.performer}</Name>
  </Performer>
  <Details>
    <Band>${claim.band}</Band>
    <Status>${claim.status}</Status>
    <SubmissionDate>${claim.submissionDate}</SubmissionDate>
  </Details>
  <Services>
    <Service name="Exam" code="01" />
    <Service name="Filling" code="02" />
  </Services>
</Claim>`;
};

// Function to download data as a CSV file
const downloadCSV = (tab) => {
  const dataToDownload = filteredClaims.value;
  if (dataToDownload.length === 0) {
    // A simple alert-like message in the console, as per instructions
    console.warn("There is no data to download for this category.");
    closeModal();
    return;
  }

  const header = Object.keys(dataToDownload[0]).join(",");
  const rows = dataToDownload.map((claim) => Object.values(claim).join(",")).join("\n");
  const csvContent = `${header}\n${rows}`;
  const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = `${tab}_claims_data.csv`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};
</script>

<style scoped>
/* Reset and global styles for this component */
.main-container {
  font-family: "Public Sans", "Noto Sans", sans-serif;
  background-color: #f3f4f6;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  padding: 24px;
}

/* Card-like content container from ChartView */
.content-container {
  width: 100%;
  max-width: 1400px; /* Increased max-width for a more spacious feel */
  display: flex;
  flex-direction: column;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  gap: 20px;
  padding: 32px;
}

/* Header with buttons and tabs */
.header-section {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-end; /* Align tabs to the bottom */
  gap: 24px;
  padding: 0 16px;
  border-bottom: 1px solid #dbe0e6;
  padding-bottom: 0;
}

.tab-nav {
  display: flex;
  gap: 32px;
}

.tab-item {
  text-decoration: none;
  color: #60758a;
  padding: 16px 0 12px;
  border-bottom: 3px solid transparent;
  transition: border-color 0.3s, color 0.3s;
  cursor: pointer;
}

.tab-item p {
  font-size: 14px;
  font-weight: 700;
  margin: 0;
}

.tab-item:hover,
.tab-item.active {
  color: #111418;
}

.tab-item.active {
  border-bottom: 3px solid #111418;
}

.action-btn {
  height: 40px;
  padding: 0 20px;
  background-color: #f0f2f5;
  color: #111418;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s, transform 0.2s;
}

.action-btn:hover {
  background-color: #e2e4e8;
  transform: translateY(-2px);
}

.new-claim-btn,
.submit-batch-btn,
.reports-btn {
  font-weight: 700;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.submit-batch-btn {
  background-color: #0d80f2;
  color: white;
}

.submit-batch-btn:hover {
  background-color: #0c72d9;
}

.search-bar {
  padding: 12px 16px;
}

.search-input-wrapper {
  display: flex;
  align-items: center;
  height: 48px;
  width: 100%;
  background-color: #f0f2f5;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
}

.search-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-left: 16px;
  color: #60758a;
}

.search-input {
  flex: 1;
  background: transparent;
  border: none;
  height: 100%;
  padding: 0 16px 0 8px;
  font-size: 16px;
  color: #111418;
}

.search-input::placeholder {
  color: #60758a;
}

.search-input:focus {
  outline: none;
}

/* Beautiful Table Styles */
.table-container {
  padding: 16px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border-radius: 8px;
  overflow-x: auto;
}

.claims-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 8px;
}

.claims-table thead {
  background-color: #f9fafb;
}

.claims-table th,
.claims-table td {
  padding: 16px 20px;
  text-align: left;
  font-size: 14px;
  line-height: 1.5;
  white-space: nowrap;
}

.claims-table th {
  color: #1f2937;
  font-weight: 600;
  border-bottom: 2px solid #e5e7eb;
}

.claims-table td {
  color: #4b5563;
  font-weight: 400;
  border-bottom: 1px solid #e5e7eb;
  background-color: #fff;
}

.claims-table tbody tr:hover td {
  background-color: #f5f7f9;
}

.status-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 9999px;
  font-weight: 600;
  font-size: 12px;
  text-transform: capitalize;
}

.status-accepted {
  background-color: #d1fae5;
  color: #065f46;
}

.status-submitted {
  background-color: #d1e5fa;
  color: #065f8a;
}

.status-pending {
  background-color: #fde68a;
  color: #92400e;
}

.status-rejected {
  background-color: #fee2e2;
  color: #991b1b;
}

.status-error {
  background-color: #fecaca;
  color: #b91c1c;
}

.action-buttons {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.action-link {
  background: none;
  border: none;
  padding: 0;
  margin: 0;
  font-size: 14px;
  color: #4f46e5;
  cursor: pointer;
  text-decoration: underline;
  white-space: nowrap;
}

.no-data {
  text-align: center;
  padding: 24px;
  color: #6b7280;
  font-style: italic;
}

/* Pagination Styles */
.pagination-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 16px;
  padding: 16px;
}

.pagination-btn {
  background-color: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.pagination-btn:hover:not(:disabled) {
  background-color: #4338ca;
}

.pagination-btn:disabled {
  background-color: #a5b4fc;
  cursor: not-allowed;
}

.page-info {
  font-size: 14px;
  color: #4b5563;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content-wrapper {
  background-color: white;
  border-radius: 12px;
  padding: 32px;
  max-width: 600px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e5e7eb;
  padding-bottom: 12px;
  margin-bottom: 20px;
}

.modal-title {
  font-size: 24px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.close-btn {
  background: none;
  border: none;
  font-size: 28px;
  cursor: pointer;
  color: #6b7280;
  padding: 0;
}

.modal-body {
  padding-top: 12px;
}

.modal-subtitle {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 16px;
}

.modal-message {
  font-size: 16px;
  color: #374151;
  line-height: 1.6;
  margin-bottom: 24px;
}

/* Form Styles */
.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.form-field {
  display: flex;
  flex-direction: column;
}

.label {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 6px;
}

.input,
.input select {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 16px;
  color: #1f2937;
  background-color: #f9fafb;
}

.input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 24px;
}

.submit-btn {
  background-color: #4f46e5;
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
}

.submit-btn:hover {
  background-color: #4338ca;
}

/* Detail View Styles */
.details-grid {
  display: grid;
  gap: 16px;
  grid-template-columns: 1fr;
}

.detail-item {
  display: flex;
  flex-direction: column;
}

.label-text {
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
  margin-bottom: 4px;
}

.detail-text {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
}

.xml-block {
  background-color: #2d3748;
  color: #e2e8f0;
  padding: 16px;
  border-radius: 8px;
  overflow-x: auto;
  font-family: monospace;
}
</style>
