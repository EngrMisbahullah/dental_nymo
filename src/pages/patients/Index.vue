<template>
  <div id="app">
    <!-- Patient Form Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 flex justify-center items-center z-[1000] p-4">
      <div class="bg-white rounded-xl shadow-lg w-full md:w-4/5 max-w-[900px] max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <header class="flex justify-between items-center px-6 py-5 border-b border-gray-200">
          <h3 class="m-0 text-xl font-semibold text-gray-800">{{ isEditing ? "Edit Patient" : "Add New Patient" }}</h3>
          <button @click="closeModal" class="bg-transparent border-none text-2xl cursor-pointer text-gray-500 hover:text-gray-700">×</button>
        </header>
        
        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto flex-grow">
          <form @submit.prevent="submitForm">
            <!-- Patient Details Section -->
            <div class="mb-5">
              <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-4">
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">ID</label>
                  <input type="text" v-model="form.id" disabled class="px-2.5 py-2 border border-gray-300 rounded-md text-sm bg-gray-100" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Title</label>
                  <select v-model="form.title" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Mr</option>
                    <option>Ms</option>
                    <option>Mrs</option>
                    <option>Dr</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">First name</label>
                  <input type="text" v-model="form.firstName" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Middle name</label>
                  <input type="text" v-model="form.middleName" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Last name</label>
                  <input type="text" v-model="form.lastName" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Preferred name</label>
                  <input type="text" v-model="form.preferredName" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Gender</label>
                  <select v-model="form.gender" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Date of birth</label>
                  <input type="date" v-model="form.dob" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">NI number</label>
                  <input type="text" v-model="form.niNumber" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">NHS number</label>
                  <input type="text" v-model="form.nhsNumber" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Insurance number</label>
                  <input type="text" v-model="form.insuranceNumber" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Legacy ID</label>
                  <input type="text" v-model="form.legacyId" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Ethnicity</label>
                  <select v-model="form.ethnicity" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>British</option>
                    <option>Irish</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">GP</label>
                  <input type="text" v-model="form.gp" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
              </div>
            </div>

            <!-- Contact Details Section -->
            <div class="mb-5">
              <h4 class="text-base font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Contact Details</h4>
              <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-4">
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Address line 1</label>
                  <input type="text" v-model="form.address1" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Address line 2</label>
                  <input type="text" v-model="form.address2" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Town</label>
                  <input type="text" v-model="form.town" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">County</label>
                  <input type="text" v-model="form.county" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Postcode</label>
                  <input type="text" v-model="form.postcode" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Home phone</label>
                  <input type="tel" v-model="form.homePhone" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Work phone</label>
                  <input type="tel" v-model="form.workPhone" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Mobile phone</label>
                  <input type="tel" v-model="form.mobilePhone" required class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Preferred phone</label>
                  <select v-model="form.preferredPhone" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Home</option>
                    <option>Work</option>
                    <option>Mobile</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Email</label>
                  <input type="email" v-model="form.email" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Doctor</label>
                  <input type="text" v-model="form.doctor" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Occupation</label>
                  <input type="text" v-model="form.occupation" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
              </div>
            </div>

            <!-- Practice Details Section -->
            <div class="mb-5">
              <h4 class="text-base font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Practice Details</h4>
              <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-4">
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Location</label>
                  <input type="text" v-model="form.location" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Payment plan</label>
                  <select v-model="form.paymentPlan" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Private</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Account</label>
                  <input type="text" v-model="form.account" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Dentist</label>
                  <input type="text" v-model="form.dentist" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Hygienist</label>
                  <input type="text" v-model="form.hygienist" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Receive email</label>
                  <select v-model="form.receiveEmail" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Receive SMS</label>
                  <select v-model="form.receiveSms" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Marketing Consent</label>
                  <select v-model="form.marketingConsent" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Dentist recall interval</label>
                  <input type="text" v-model="form.dentistRecallInterval" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Next dentist recall</label>
                  <input type="date" v-model="form.nextDentistRecall" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Hygienist recall interval</label>
                  <input type="text" v-model="form.hygienistRecallInterval" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Next hygienist recall</label>
                  <input type="date" v-model="form.nextHygienistRecall" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Recall method</label>
                  <select v-model="form.recallMethod" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm">
                    <option>SMS</option>
                    <option>Email</option>
                    <option>Phone</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-medium text-gray-600 mb-1">Acquisition source</label>
                  <input type="text" v-model="form.acquisitionSource" class="px-2.5 py-2 border border-gray-300 rounded-md text-sm" />
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <!-- Modal Footer -->
        <footer class="px-6 py-4 border-t border-gray-200 flex justify-end">
          <button class="bg-revenue text-white py-2.5 px-5 border-none rounded-lg cursor-pointer font-medium hover:bg-blue-600 transition-colors" @click="submitForm">
            {{ isEditing ? "Save Changes" : "Save Patient" }}
          </button>
        </footer>
      </div>
    </div>

    <!-- Main Content for the Page -->
    <main class="p-3 md:p-5 bg-card font-[Poppins]">
      <div class="flex flex-col lg:flex-row gap-4 md:gap-5 min-h-[calc(100vh-100px)]">
        <!-- Patient List Panel -->
        <div class="w-full lg:w-[350px] lg:flex-shrink-0 bg-white rounded-xl shadow-sm p-4 md:p-5 flex flex-col">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 m-0">All Patients</h2>
            <button 
              @click="openModal(false)"
              class="flex items-center gap-2 bg-revenue text-white py-2 md:py-2.5 px-3 md:px-4 border-none rounded-lg cursor-pointer font-medium hover:bg-blue-600 transition-colors text-sm md:text-base"
            >
              <span class="material-icons text-base md:text-lg">add</span>
              <span class="hidden sm:inline">Add New Patient</span>
              <span class="sm:hidden">Add</span>
            </button>
          </div>
          
          <!-- Patient List -->
          <div class="flex-grow overflow-y-auto">
            <div
              v-for="patient in paginatedPatients"
              :key="patient.id"
              :class="[
                'flex items-center gap-4 p-2.5 rounded-lg cursor-pointer transition-colors',
                selectedPatient && selectedPatient.id === patient.id ? 'bg-gray-100' : 'hover:bg-gray-50'
              ]"
              @click="selectPatient(patient)"
            >
              <img :src="patient.image" :alt="patient.name" class="w-10 h-10 rounded-full object-cover" />
              <div>
                <p class="font-semibold mb-0.5 text-sm text-gray-800">{{ patient.name }}</p>
                <p class="text-xs text-gray-500">{{ patient.lastVisit }}</p>
              </div>
            </div>
          </div>
          
          <!-- Pagination -->
          <div class="flex justify-between items-center mt-4">
            <button 
              @click="prevPage" 
              :disabled="currentPage === 1" 
              class="bg-gray-100 border-none py-2 px-3 rounded-lg cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-200 transition-colors"
            >
              Previous
            </button>
            <span class="text-sm text-gray-600">Page {{ currentPage }} of {{ totalPages }}</span>
            <button
              @click="nextPage"
              :disabled="currentPage === totalPages"
              class="bg-gray-100 border-none py-2 px-3 rounded-lg cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-200 transition-colors"
            >
              Next
            </button>
          </div>
        </div>

        <!-- Patient Details Panel -->
        <div class="flex-grow bg-white rounded-xl shadow-sm p-4 md:p-5 flex flex-col">
          <div v-if="selectedPatient">
            <!-- Details Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-5 border-b border-gray-200">
              <div class="flex items-center gap-3 md:gap-4">
                <img
                  :src="selectedPatient.image"
                  :alt="selectedPatient.name"
                  class="w-12 h-12 md:w-16 md:h-16 rounded-full object-cover"
                />
                <div>
                  <h2 class="text-xl md:text-2xl font-semibold text-gray-800">{{ selectedPatient.name }}</h2>
                  <p class="text-sm text-gray-500">ID: {{ selectedPatient.id }}</p>
                  <div class="flex items-center gap-1 text-yellow-500 text-sm">
                    <span class="material-icons text-base">star</span>
                    <span class="font-semibold">VIP Patient</span>
                  </div>
                </div>
              </div>
              <div class="flex gap-2">
                <button @click="openModal(true)" class="bg-gray-200 border-none p-2 rounded-full cursor-pointer hover:bg-gray-300 transition-colors">
                  <span class="material-icons">edit</span>
                </button>
                <button class="bg-gray-200 border-none p-2 rounded-full cursor-pointer hover:bg-gray-300 transition-colors">
                  <span class="material-icons">print</span>
                </button>
                <button class="bg-gray-200 border-none p-2 rounded-full cursor-pointer hover:bg-gray-300 transition-colors text-red-500">
                  <span class="material-icons">delete</span>
                </button>
              </div>
            </div>

            <!-- Tabbed Details Content -->
            <div class="pt-5 flex flex-col">
              <!-- Tabs Navigation -->
              <div class="mb-4 -mx-4 md:mx-0">
                <nav class="flex border-b-2 border-gray-200 mb-5  px-4 md:px-0">
                  <a
                    v-for="tab in tabs"
                    :key="tab"
                    :class="[
                      'py-2.5 px-3 md:px-4 no-underline font-medium transition-all cursor-pointer whitespace-nowrap text-sm md:text-base',
                      activeTab === tab 
                        ? 'text-purple-accent border-b-2 border-purple-accent -mb-0.5' 
                        : 'text-gray-500 hover:text-gray-700'
                    ]"
                    @click="activeTab = tab"
                  >
                    {{ tab }}
                  </a>
                </nav>
              </div>

              <!-- Tab Content -->
              <div class="flex-grow">
                <!-- Patient Info Tab -->
                <div v-if="activeTab === 'Patient Info'" class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5">
                  <div class="flex flex-col">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Full Name</h4>
                    <p class="text-base font-semibold text-gray-800">{{ selectedPatient.fullName }}</p>
                  </div>
                  <div class="flex flex-col">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Date of Birth</h4>
                    <p class="text-base font-semibold text-gray-800">{{ selectedPatient.dob }}</p>
                  </div>
                  <div class="flex flex-col">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Email Address</h4>
                    <p class="text-base font-semibold text-gray-800">{{ selectedPatient.email }}</p>
                  </div>
                  <div class="flex flex-col">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Phone Number</h4>
                    <p class="text-base font-semibold text-gray-800">{{ selectedPatient.phone }}</p>
                  </div>
                  <div class="flex flex-col sm:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Address</h4>
                    <p class="text-base font-semibold text-gray-800">{{ selectedPatient.address }}</p>
                  </div>
                  <div class="flex flex-col sm:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Primary Dental Concerns</h4>
                    <div class="flex gap-2">
                      <span
                        v-for="concern in selectedPatient.concerns"
                        :key="concern"
                        class="bg-blue-100 text-blue-500 py-1 px-2.5 rounded-xl text-xs"
                      >
                        {{ concern }}
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Appointments Tab -->
                <div v-else-if="activeTab === 'Appointments'" class="flex-grow overflow-y-auto">
                  <div
                    v-for="appointment in selectedPatient.appointments"
                    :key="appointment.id"
                    class="flex items-center gap-4 p-3 border-b border-gray-200"
                  >
                    <div class="text-sm font-semibold text-purple-accent">{{ appointment.date }}</div>
                    <div class="flex-grow">
                      <p class="font-semibold mb-0.5">{{ appointment.title }}</p>
                      <p class="text-sm text-gray-500">{{ appointment.time }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Empty State -->
          <div v-else class="text-center py-12 text-gray-500">
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

