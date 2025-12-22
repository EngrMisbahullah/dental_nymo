<template>
  <!-- Main container with light gray background -->
  <div class="font-[Public_Sans,Noto_Sans,sans-serif] bg-gray-100 min-h-screen flex justify-center p-6">
    <!-- Card-like content container -->
    <div class="w-full max-w-[1400px] flex flex-col bg-white rounded-xl shadow-md gap-5 p-8">
      <!-- Combined buttons and tab navigation section -->
      <div class="flex flex-wrap justify-between items-end gap-6 px-4 pb-0 border-b border-gray-200">
        <div class="flex-grow">
          <div class="flex gap-8">
            <a
              v-for="tab in tabs"
              :key="tab.id"
              :class="['no-underline text-gray-500 py-4 pb-3 border-b-[3px] border-transparent cursor-pointer transition-all duration-300 hover:text-gray-900', { 'text-gray-900 !border-gray-900': activeTab === tab.id }]"
              @click="selectTab(tab.id)"
            >
              <p class="text-sm font-bold m-0">{{ tab.name }}</p>
            </a>
          </div>
        </div>
        <div class="flex-shrink-0 flex gap-4 mt-4 md:mt-0">
          <button class="h-10 px-5 bg-gray-100 text-gray-900 border-none rounded-lg text-sm font-bold cursor-pointer transition-all duration-200 shadow-sm hover:bg-gray-200 hover:-translate-y-0.5" @click="openModal('New Claim')">
            <span class="truncate">➕ New Claim</span>
          </button>
          <button class="h-10 px-5 bg-blue-500 text-white border-none rounded-lg text-sm font-bold cursor-pointer transition-all duration-200 shadow-sm hover:bg-blue-600 hover:-translate-y-0.5" @click="openModal('Submit Batch')">
            <span class="truncate">📤 Submit Batch</span>
          </button>
          <button class="h-10 px-5 bg-gray-100 text-gray-900 border-none rounded-lg text-sm font-bold cursor-pointer transition-all duration-200 shadow-sm hover:bg-gray-200 hover:-translate-y-0.5" @click="downloadCSV('all')">
            <span class="truncate">📄 Reports</span>
          </button>
        </div>
      </div>

      <!-- Search Bar -->
      <div class="py-3 px-4">
        <label class="flex items-center h-12 w-full bg-gray-100 rounded-lg overflow-hidden shadow-inner">
          <div class="flex items-center justify-center pl-4 text-gray-500">
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
            class="flex-1 bg-transparent border-none h-full py-0 px-4 pl-2 text-base text-gray-900 outline-none placeholder-gray-500"
          />
        </label>
      </div>

      <!-- Claims Table -->
      <div class="p-4 shadow-md rounded-lg overflow-x-auto">
        <table class="w-full border-separate border-spacing-y-2">
          <thead class="bg-gray-50">
            <tr>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Claim ID</th>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Patient</th>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Band</th>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Performer</th>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Status</th>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Submission Date</th>
              <th class="py-4 px-5 text-left text-sm leading-normal text-gray-800 font-semibold border-b-2 border-gray-200 whitespace-nowrap">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="claim in paginatedClaims" :key="claim.id" class="hover:bg-gray-50">
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">{{ claim.id }}</td>
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">{{ claim.patient }}</td>
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">{{ claim.band }}</td>
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">{{ claim.performer }}</td>
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">
                <span :class="['inline-block py-1 px-3 rounded-full font-semibold text-xs capitalize', getStatusClass(claim.status)]">{{
                  claim.status
                }}</span>
              </td>
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">{{ claim.submissionDate }}</td>
              <td class="py-4 px-5 text-sm text-gray-600 border-b border-gray-200 bg-white whitespace-nowrap">
                <div class="flex gap-3 flex-wrap">
                  <button
                    v-if="claim.status === 'Error' || claim.status === 'Rejected'"
                    class="bg-none border-none p-0 m-0 text-sm text-indigo-600 cursor-pointer underline whitespace-nowrap"
                    @click="openModal('Fix & Resubmit', claim)"
                  >
                    Fix & Resubmit
                  </button>
                  <button class="bg-none border-none p-0 m-0 text-sm text-indigo-600 cursor-pointer underline whitespace-nowrap" @click="openModal('View Claim', claim)">
                    View Claim
                  </button>
                  <button class="bg-none border-none p-0 m-0 text-sm text-indigo-600 cursor-pointer underline whitespace-nowrap" @click="openModal('View XML', claim)">
                    View XML
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="paginatedClaims.length === 0" class="text-center py-6 text-gray-500 italic">
          No claims found for this status.
        </div>
      </div>

      <!-- Pagination Controls -->
      <div class="flex justify-center items-center gap-4 py-4">
        <button
          class="bg-indigo-600 text-white border-none rounded-lg py-2 px-4 cursor-pointer transition-colors hover:bg-indigo-700 disabled:bg-indigo-300 disabled:cursor-not-allowed"
          :disabled="currentPage === 1"
          @click="selectPage(currentPage - 1)"
        >
          Previous
        </button>
        <span class="text-sm text-gray-600">Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          class="bg-indigo-600 text-white border-none rounded-lg py-2 px-4 cursor-pointer transition-colors hover:bg-indigo-700 disabled:bg-indigo-300 disabled:cursor-not-allowed"
          :disabled="currentPage === totalPages"
          @click="selectPage(currentPage + 1)"
        >
          Next
        </button>
      </div>

      <!-- Modal Popup -->
      <div v-if="showModal" class="fixed inset-0 bg-black/50 flex justify-center items-center z-[1000]" @click.self="closeModal">
        <div class="bg-white rounded-xl p-8 max-w-[600px] w-[90%] max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col">
          <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-5">
            <h2 class="text-2xl font-bold text-gray-800 m-0">{{ modalTitle }}</h2>
            <button class="bg-none border-none text-3xl cursor-pointer text-gray-500 p-0" @click="closeModal">&times;</button>
          </div>
          <div class="pt-3">
            <!-- New Claim Form -->
            <div v-if="modalType === 'New Claim' || modalType === 'Fix & Resubmit'">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Claim Details</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="flex flex-col">
                  <label for="patientName" class="text-sm font-medium text-gray-700 mb-1.5">Patient Name</label>
                  <input
                    type="text"
                    id="patientName"
                    v-model="form.patient"
                    class="py-2.5 px-3 border border-gray-300 rounded-md text-base text-gray-800 bg-gray-50 focus:outline-none focus:border-indigo-600 focus:ring-[3px] focus:ring-indigo-600/20"
                  />
                </div>
                <div class="flex flex-col">
                  <label for="claimId" class="text-sm font-medium text-gray-700 mb-1.5">Claim ID</label>
                  <input
                    type="text"
                    id="claimId"
                    v-model="form.id"
                    class="py-2.5 px-3 border border-gray-300 rounded-md text-base text-gray-800 bg-gray-50 focus:outline-none focus:border-indigo-600 focus:ring-[3px] focus:ring-indigo-600/20 disabled:opacity-50"
                    :disabled="modalType === 'Fix & Resubmit'"
                  />
                </div>
                <div class="flex flex-col">
                  <label for="band" class="text-sm font-medium text-gray-700 mb-1.5">Band</label>
                  <select id="band" v-model="form.band" class="py-2.5 px-3 border border-gray-300 rounded-md text-base text-gray-800 bg-gray-50 focus:outline-none focus:border-indigo-600 focus:ring-[3px] focus:ring-indigo-600/20">
                    <option value="Band 1">Band 1</option>
                    <option value="Band 2">Band 2</option>
                    <option value="Band 3">Band 3</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label for="performer" class="text-sm font-medium text-gray-700 mb-1.5">Performer</label>
                  <input
                    type="text"
                    id="performer"
                    v-model="form.performer"
                    class="py-2.5 px-3 border border-gray-300 rounded-md text-base text-gray-800 bg-gray-50 focus:outline-none focus:border-indigo-600 focus:ring-[3px] focus:ring-indigo-600/20"
                  />
                </div>
                <div class="flex flex-col">
                  <label for="submissionDate" class="text-sm font-medium text-gray-700 mb-1.5">Submission Date</label>
                  <input
                    type="date"
                    id="submissionDate"
                    v-model="form.submissionDate"
                    class="py-2.5 px-3 border border-gray-300 rounded-md text-base text-gray-800 bg-gray-50 focus:outline-none focus:border-indigo-600 focus:ring-[3px] focus:ring-indigo-600/20"
                  />
                </div>
                <div class="flex flex-col">
                  <label for="status" class="text-sm font-medium text-gray-700 mb-1.5">Status</label>
                  <input type="text" id="status" v-model="form.status" class="py-2.5 px-3 border border-gray-300 rounded-md text-base text-gray-800 bg-gray-50 focus:outline-none focus:border-indigo-600 focus:ring-[3px] focus:ring-indigo-600/20" />
                </div>
              </div>
              <div class="flex justify-end mt-6">
                <button class="bg-indigo-600 text-white py-3 px-6 rounded-lg border-none font-semibold cursor-pointer transition-colors hover:bg-indigo-700" @click="closeModal">
                  {{ modalType === "New Claim" ? "Create Claim" : "Save Changes" }}
                </button>
              </div>
            </div>

            <!-- View Claim Details -->
            <div v-else-if="modalType === 'View Claim'">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Claim Details</h3>
              <div class="grid gap-4">
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-gray-500 mb-1">Claim ID:</span>
                  <span class="text-base font-semibold text-gray-800">{{ selectedClaim.id }}</span>
                </div>
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-gray-500 mb-1">Patient:</span>
                  <span class="text-base font-semibold text-gray-800">{{ selectedClaim.patient }}</span>
                </div>
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-gray-500 mb-1">Band:</span>
                  <span class="text-base font-semibold text-gray-800">{{ selectedClaim.band }}</span>
                </div>
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-gray-500 mb-1">Performer:</span>
                  <span class="text-base font-semibold text-gray-800">{{ selectedClaim.performer }}</span>
                </div>
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-gray-500 mb-1">Status:</span>
                  <span class="text-base font-semibold text-gray-800">
                    <span :class="['inline-block py-1 px-3 rounded-full font-semibold text-xs capitalize', getStatusClass(selectedClaim.status)]">{{ selectedClaim.status }}</span>
                  </span>
                </div>
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-gray-500 mb-1">Submission Date:</span>
                  <span class="text-base font-semibold text-gray-800">{{ selectedClaim.submissionDate }}</span>
                </div>
              </div>
            </div>

            <!-- View XML Data -->
            <div v-else-if="modalType === 'View XML'">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">XML Data</h3>
              <pre class="bg-gray-800 text-gray-200 p-4 rounded-lg overflow-x-auto font-mono">{{ generateXML(selectedClaim) }}</pre>
            </div>

            <!-- Submit Batch Confirmation -->
            <div v-else-if="modalType === 'Submit Batch'">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch Submission</h3>
              <p class="text-base text-gray-700 leading-relaxed mb-6">
                Are you sure you want to submit all pending claims as a batch?
                <br />This action will group all claims with the status "Pending" and send
                them to the NHS BSA EDI gateway.
              </p>
              <div class="flex justify-end">
                <button class="bg-indigo-600 text-white py-3 px-6 rounded-lg border-none font-semibold cursor-pointer transition-colors hover:bg-indigo-700" @click="performBatchSubmission">
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
      return "bg-green-100 text-green-800";
    case "Submitted":
      return "bg-blue-100 text-blue-800";
    case "Pending":
      return "bg-yellow-200 text-yellow-800";
    case "Rejected":
      return "bg-red-100 text-red-700";
    case "Error":
      return "bg-red-200 text-red-700";
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
