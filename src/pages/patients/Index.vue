<template>
  <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-gray-50 to-teal-50/30">
    <!-- Patient Form Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-[1000] p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full md:w-4/5 max-w-[950px] max-h-[90vh] flex flex-col transform transition-all duration-300 scale-100">
        <!-- Modal Header -->
        <header class="flex justify-between items-center px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-t-2xl">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-sm">
              <i :class="isEditing ? 'fas fa-user-edit' : 'fas fa-user-plus'" class="text-xl"></i>
            </div>
            <div>
              <h3 class="m-0 text-xl font-bold">{{ isEditing ? "Edit Patient Details" : "Add New Patient" }}</h3>
              <p class="text-xs text-teal-50 mt-0.5">Complete patient registration form</p>
            </div>
          </div>
          <button @click="closeModal" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 border-none cursor-pointer transition-all duration-200">
            <i class="fas fa-times text-xl"></i>
          </button>
        </header>
        
        <!-- Modal Body -->
        <div class="p-8 overflow-y-auto flex-grow bg-slate-50">
          <form @submit.prevent="submitForm">
            <!-- Patient Details Section -->
            <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-id-badge text-white text-sm"></i>
                </div>
                <div>
                  <h4 class="text-sm font-semibold text-slate-800 m-0">Personal Information</h4>
                  <p class="text-xs text-slate-400 mt-0.5">Basic patient details</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">fingerprint</span>
                    Patient ID
                  </label>
                  <input type="text" v-model="form.id" disabled class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-500 cursor-not-allowed focus:outline-none" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Title</label>
                  <select v-model="form.title" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Mr</option>
                    <option>Ms</option>
                    <option>Mrs</option>
                    <option>Dr</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">First name <span class="text-red-500">*</span></label>
                  <input type="text" v-model="form.firstName" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Enter first name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Middle name</label>
                  <input type="text" v-model="form.middleName" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Enter middle name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Last name <span class="text-red-500">*</span></label>
                  <input type="text" v-model="form.lastName" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Enter last name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Preferred name</label>
                  <input type="text" v-model="form.preferredName" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Nickname" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Gender</label>
                  <select v-model="form.gender" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Date of birth <span class="text-red-500">*</span></label>
                  <input type="date" v-model="form.dob" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">NI number</label>
                  <input type="text" v-model="form.niNumber" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="AB123456C" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">NHS number</label>
                  <input type="text" v-model="form.nhsNumber" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="000 000 0000" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Insurance number</label>
                  <input type="text" v-model="form.insuranceNumber" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Insurance ID" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Legacy ID</label>
                  <input type="text" v-model="form.legacyId" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Old system ID" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Ethnicity</label>
                  <select v-model="form.ethnicity" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>British</option>
                    <option>Irish</option>
                    <option>Asian</option>
                    <option>African</option>
                    <option>Other</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">GP</label>
                  <input type="text" v-model="form.gp" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="General Practitioner" />
                </div>
              </div>
            </div>

            <!-- Contact Details Section -->
            <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-address-card text-white text-sm"></i>
                </div>
                <div>
                  <h4 class="text-sm font-semibold text-slate-800 m-0">Contact Details</h4>
                  <p class="text-xs text-slate-400 mt-0.5">Address and communication preferences</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="flex flex-col md:col-span-2">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">home</span>
                    Address line 1 <span class="text-red-500">*</span>
                  </label>
                  <input type="text" v-model="form.address1" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Street address" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Address line 2</label>
                  <input type="text" v-model="form.address2" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Apt, suite, etc." />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Town <span class="text-red-500">*</span></label>
                  <input type="text" v-model="form.town" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="City/Town" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">County <span class="text-red-500">*</span></label>
                  <input type="text" v-model="form.county" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="County/State" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Postcode <span class="text-red-500">*</span></label>
                  <input type="text" v-model="form.postcode" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="SW1A 1AA" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">phone</span>
                    Home phone
                  </label>
                  <input type="tel" v-model="form.homePhone" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="+44 20 1234 5678" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">work</span>
                    Work phone
                  </label>
                  <input type="tel" v-model="form.workPhone" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="+44 20 1234 5678" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">smartphone</span>
                    Mobile phone <span class="text-red-500">*</span>
                  </label>
                  <input type="tel" v-model="form.mobilePhone" required class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="+44 7700 900000" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Preferred phone</label>
                  <select v-model="form.preferredPhone" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Home</option>
                    <option>Work</option>
                    <option>Mobile</option>
                  </select>
                </div>
                <div class="flex flex-col md:col-span-2">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">email</span>
                    Email address
                  </label>
                  <input type="email" v-model="form.email" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="patient@example.com" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Doctor</label>
                  <input type="text" v-model="form.doctor" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Dr. Name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Occupation</label>
                  <input type="text" v-model="form.occupation" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Job title" />
                </div>
              </div>
            </div>

            <!-- Practice Details Section -->
            <div class="mb-0 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-tooth text-white text-sm"></i>
                </div>
                <div>
                  <h4 class="text-sm font-semibold text-slate-800 m-0">Practice & Treatment Details</h4>
                  <p class="text-xs text-slate-400 mt-0.5">Dental care preferences and assignments</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">location_on</span>
                    Practice Location
                  </label>
                  <input type="text" v-model="form.location" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Location name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">credit_card</span>
                    Payment plan
                  </label>
                  <select v-model="form.paymentPlan" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Private</option>
                    <option>NHS</option>
                    <option>Insurance</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Account</label>
                  <input type="text" v-model="form.account" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Account number" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">person</span>
                    Assigned Dentist
                  </label>
                  <input type="text" v-model="form.dentist" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Dentist name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">cleaning_services</span>
                    Assigned Hygienist
                  </label>
                  <input type="text" v-model="form.hygienist" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="Hygienist name" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Receive email notifications</label>
                  <select v-model="form.receiveEmail" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Receive SMS notifications</label>
                  <select v-model="form.receiveSms" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Marketing Consent</label>
                  <select v-model="form.marketingConsent" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Dentist recall interval (months)</label>
                  <input type="text" v-model="form.dentistRecallInterval" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="e.g., 6" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Next dentist recall</label>
                  <input type="date" v-model="form.nextDentistRecall" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Hygienist recall interval (months)</label>
                  <input type="text" v-model="form.hygienistRecallInterval" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="e.g., 3" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Next hygienist recall</label>
                  <input type="date" v-model="form.nextHygienistRecall" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" />
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2">Recall method</label>
                  <select v-model="form.recallMethod" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                    <option>SMS</option>
                    <option>Email</option>
                    <option>Phone</option>
                    <option>Post</option>
                  </select>
                </div>
                <div class="flex flex-col">
                  <label class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <span class="material-icons text-sm text-slate-400">source</span>
                    Acquisition source
                  </label>
                  <input type="text" v-model="form.acquisitionSource" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" placeholder="How they found us" />
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <!-- Modal Footer -->
        <footer class="px-8 py-5 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center rounded-b-2xl">
          <button @click="closeModal" class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 hover:border-slate-300">
            <i class="fas fa-times mr-2 text-slate-400"></i>
            Cancel
          </button>
          <button class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 hover:from-teal-600 hover:to-cyan-600 flex items-center gap-2" @click="submitForm">
            <i :class="isEditing ? 'fas fa-save' : 'fas fa-plus'"></i>
            <span>{{ isEditing ? "Save Changes" : "Create Patient" }}</span>
          </button>
        </footer>
      </div>
    </div>

    <!-- Main Content -->
    <div class="py-4 md:py-6 lg:py-8">
      <!-- Selected Patient Header Card -->
      <header v-if="selectedPatient" class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-200/60 mb-6">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-400"></div>
        
        <div class="p-5 md:p-6">
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <!-- Patient Avatar & Info -->
            <div class="flex items-center gap-4">
              <div class="relative">
                <img :src="selectedPatient.image" :alt="selectedPatient.name" class="w-14 h-14 rounded-full object-cover ring-2 ring-teal-100 shadow-md" />
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
              </div>
              <div>
                <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">{{ selectedPatient.name }}</h1>
                <div class="flex items-center gap-2 mt-1">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                    <i class="fas fa-id-card mr-1.5 text-slate-400"></i>
                    ID: {{ selectedPatient.id }}
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-50 text-teal-700">
                    <i class="fas fa-check-circle mr-1.5"></i>
                    Active Patient
                  </span>
                </div>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="sm:ml-auto flex flex-wrap gap-2.5">
              <button 
                @click="openModal(true)"
                class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl cursor-pointer transition-all duration-200 hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm"
              >
                <i class="fas fa-edit text-slate-400 group-hover:text-teal-500 transition-colors"></i>
                <span class="hidden sm:inline">Edit Patient</span>
                <span class="sm:hidden">Edit</span>
              </button>
              <button class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30">
                <i class="fas fa-calendar-plus"></i>
                <span class="hidden sm:inline">Book Appointment</span>
                <span class="sm:hidden">Book</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Navigation Tabs -->
      <nav class="flex gap-2 mb-6 p-1.5 bg-white/60 backdrop-blur-sm rounded-xl border border-slate-200/60 w-fit">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          :class="[
            'flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 outline-none',
            activeTab === tab.id
              ? 'bg-white text-slate-800 shadow-sm border border-slate-200/60'
              : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'
          ]"
          @click="activeTab = tab.id"
        >
          <i :class="[tab.icon, activeTab === tab.id ? 'text-teal-500' : 'text-slate-400']"></i>
          {{ tab.label }}
        </button>
      </nav>

      <!-- Content Grid -->
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Patient List (1 column on xl) -->
        <transition name="fade-slide" mode="out-in">
          <div v-if="activeTab === 'overview'" key="patient-overview" class="xl:col-span-2 space-y-6">
            
            <!-- Patient List Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <!-- Card Header -->
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-sm">
                    <i class="fas fa-users text-white text-sm"></i>
                  </div>
                  <div>
                    <h2 class="text-lg font-semibold text-slate-800">Patient Directory</h2>
                    <p class="text-xs text-slate-400 mt-0.5">All registered patients</p>
                  </div>
                </div>
                <div class="sm:ml-auto">
                  <button 
                    @click="openModal(false)"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25"
                  >
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">New Patient</span>
                    <span class="sm:hidden">New</span>
                  </button>
                </div>
              </div>
              
              <!-- Search & Filters -->
              <div class="p-5 space-y-4">
                <!-- Search Bar -->
                <div class="relative">
                  <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                  <input 
                    type="text" 
                    v-model="searchQuery"
                    placeholder="Search patients by name, email, phone..." 
                    class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                  />
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                  <button 
                    v-for="filter in patientFilters"
                    :key="filter"
                    :class="[
                      'px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200',
                      activeFilter === filter 
                        ? 'bg-teal-500 text-white shadow-md' 
                        : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                    ]"
                    @click="activeFilter = filter"
                  >
                    {{ filter }}
                  </button>
                </div>
              </div>
              
              <!-- Patient List -->
              <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                <div
                  v-for="patient in filteredPatients"
                  :key="patient.id"
                  :class="[
                    'p-4 hover:bg-slate-50/50 transition-colors cursor-pointer group',
                    selectedPatient && selectedPatient.id === patient.id ? 'bg-teal-50/50' : ''
                  ]"
                  @click="selectPatient(patient)"
                >
                  <div class="flex items-center gap-3">
                    <div class="relative">
                      <img :src="patient.image" :alt="patient.name" class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm" />
                      <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-semibold text-slate-700 truncate">{{ patient.name }}</p>
                      <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-slate-400">{{ patient.lastVisit }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-600">
                          {{ patient.appointments?.length || 0 }} visits
                        </span>
                      </div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-teal-500 group-hover:translate-x-1 transition-all text-xs"></i>
                  </div>
                </div>
              </div>
              
              <!-- Pagination -->
              <div class="flex justify-between items-center p-4 border-t border-slate-100 bg-slate-50/50">
                <button 
                  @click="prevPage" 
                  :disabled="currentPage === 1" 
                  class="flex items-center gap-1 px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-all duration-200 bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <i class="fas fa-chevron-left text-xs"></i>
                  Previous
                </button>
                <span class="text-xs text-slate-600 font-medium">Page {{ currentPage }} of {{ totalPages }}</span>
                <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="flex items-center gap-1 px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-all duration-200 bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  Next
                  <i class="fas fa-chevron-right text-xs"></i>
                </button>
              </div>
            </div>
          </div>
        </transition>

        <!-- Right Sidebar - Patient Quick Info -->
        <transition name="fade-slide" mode="out-in">
          <div v-if="activeTab === 'overview' && selectedPatient" key="patient-sidebar" class="space-y-6">
            
            <!-- Quick Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center gap-3 p-4 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center shadow-sm">
                  <i class="fas fa-info-circle text-white text-sm"></i>
                </div>
                <div>
                  <h3 class="text-sm font-semibold text-slate-800">Quick Info</h3>
                  <p class="text-xs text-slate-400">Patient summary</p>
                </div>
              </div>
              
              <div class="p-4 space-y-4">
                <div>
                  <label class="text-xs font-medium text-slate-500 mb-1 block">Date of Birth</label>
                  <p class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <i class="fas fa-birthday-cake text-slate-400"></i>
                    {{ selectedPatient.dob }}
                  </p>
                </div>
                <div>
                  <label class="text-xs font-medium text-slate-500 mb-1 block">Email</label>
                  <p class="text-sm font-semibold text-slate-700 flex items-center gap-2 truncate">
                    <i class="fas fa-envelope text-slate-400"></i>
                    {{ selectedPatient.email }}
                  </p>
                </div>
                <div>
                  <label class="text-xs font-medium text-slate-500 mb-1 block">Phone</label>
                  <p class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <i class="fas fa-phone text-slate-400"></i>
                    {{ selectedPatient.phone }}
                  </p>
                </div>
                <div>
                  <label class="text-xs font-medium text-slate-500 mb-1 block">Address</label>
                  <p class="text-sm font-semibold text-slate-700 flex items-start gap-2">
                    <i class="fas fa-map-marker-alt text-slate-400 mt-1"></i>
                    <span>{{ selectedPatient.address }}</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center gap-3 p-4 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-calendar-alt text-white text-sm"></i>
                </div>
                <h3 class="text-sm font-semibold text-slate-800">Recent Appointments</h3>
                <span class="ml-auto px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                  {{ selectedPatient.appointments?.length || 0 }}
                </span>
              </div>
              
              <div class="divide-y divide-slate-100 max-h-[300px] overflow-y-auto">
                <div 
                  v-for="(appointment, index) in selectedPatient.appointments" 
                  :key="index"
                  class="p-4 hover:bg-slate-50/50 transition-colors cursor-pointer group"
                >
                  <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-slate-400">{{ appointment.date }}</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-teal-100 text-teal-600">
                      {{ appointment.title }}
                    </span>
                  </div>
                  <div class="flex items-center gap-2">
                    <i class="fas fa-clock text-slate-400 text-xs"></i>
                    <p class="text-xs text-slate-500">{{ appointment.time }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Dental Concerns -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center gap-3 p-4 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-notes-medical text-white text-sm"></i>
                </div>
                <div>
                  <h3 class="text-sm font-semibold text-slate-800">Dental Concerns</h3>
                  <p class="text-xs text-slate-400">Primary issues</p>
                </div>
              </div>
              
              <div class="p-4">
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="concern in selectedPatient.concerns"
                    :key="concern"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200"
                  >
                    <i class="fas fa-tooth text-amber-500 text-[10px]"></i>
                    {{ concern }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50 rounded-2xl border border-teal-200/50 p-4 space-y-2">
              <h3 class="text-xs font-semibold text-slate-600 uppercase tracking-wide mb-3">Quick Actions</h3>
              <button class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-teal-700 bg-white/80 rounded-lg hover:bg-white transition-colors border border-teal-100 hover:border-teal-200">
                <i class="fas fa-calendar-plus text-teal-500"></i>
                <span>Schedule Appointment</span>
              </button>
              <button class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-cyan-700 bg-white/80 rounded-lg hover:bg-white transition-colors border border-cyan-100 hover:border-cyan-200">
                <i class="fas fa-file-medical text-cyan-500"></i>
                <span>View Clinical Notes</span>
              </button>
              <button class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-blue-700 bg-white/80 rounded-lg hover:bg-white transition-colors border border-blue-100 hover:border-blue-200">
                <i class="fas fa-receipt text-blue-500"></i>
                <span>View Invoices</span>
              </button>
            </div>
          </div>
        </transition>

        <!-- Appointments Tab -->
        <transition name="fade-slide" mode="out-in">
          <PatientAppointments 
            v-if="activeTab === 'appointments' && selectedPatient" 
            key="patient-appointments"
            :patient="selectedPatient"
            @book-appointment="openAppointmentModal"
          />
        </transition>

        <!-- Clinical Notes Tab -->
        <transition name="fade-slide" mode="out-in">
          <PatientClinicalNotes 
            v-if="activeTab === 'clinical' && selectedPatient" 
            key="patient-clinical"
            class="xl:col-span-2"
            :patient="selectedPatient"
            @add-note="openNoteModal"
          />
        </transition>

        <!-- Invoices Tab -->
        <transition name="fade-slide" mode="out-in">
          <PatientInvoices 
            v-if="activeTab === 'invoices' && selectedPatient" 
            key="patient-invoices"
            class="xl:col-span-3"
            :patient="selectedPatient"
            @create-invoice="openInvoiceModal"
          />
        </transition>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Fade slide transition */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Focus states for inputs */
input:focus,
select:focus {
  transform: translateY(-1px);
}

/* Button hover effects */
button:active:not(:disabled) {
  transform: scale(0.98);
}
</style>

<script>
import PatientAppointments from './components/PatientAppointments.vue';
import PatientClinicalNotes from './components/PatientClinicalNotes.vue';
import PatientInvoices from './components/PatientInvoices.vue';

export default {
  components: {
    PatientAppointments,
    PatientClinicalNotes,
    PatientInvoices
  },
  data() {
    return {
      showModal: false,
      isEditing: false,
      searchQuery: "",
      activeFilter: "All Patients",
      patientFilters: ["All Patients", "Recent", "VIP", "Active", "Inactive"],
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
      activeTab: "overview",
      tabs: [
        { id: 'overview', label: 'Patient Overview', icon: 'fas fa-user' },
        { id: 'appointments', label: 'Appointments', icon: 'fas fa-calendar-alt' },
        { id: 'clinical', label: 'Clinical Notes', icon: 'fas fa-notes-medical' },
        { id: 'invoices', label: 'Invoices', icon: 'fas fa-receipt' }
      ],
      currentPage: 1,
      patientsPerPage: 10,
    };
  },
  computed: {
    filteredPatients() {
      let filtered = this.patients;
      
      // Apply search filter
      if (this.searchQuery.trim()) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(patient => 
          patient.name.toLowerCase().includes(query) ||
          patient.email.toLowerCase().includes(query) ||
          patient.phone.toLowerCase().includes(query) ||
          patient.fullName.toLowerCase().includes(query)
        );
      }
      
      // Apply category filter
      if (this.activeFilter !== "All Patients") {
        // You can add more complex filtering logic here based on patient properties
        // For now, just showing all patients for demonstration
      }
      
      // Pagination
      const start = (this.currentPage - 1) * this.patientsPerPage;
      const end = start + this.patientsPerPage;
      return filtered.slice(start, end);
    },
    totalPages() {
      let filtered = this.patients;
      
      if (this.searchQuery.trim()) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(patient => 
          patient.name.toLowerCase().includes(query) ||
          patient.email.toLowerCase().includes(query) ||
          patient.phone.toLowerCase().includes(query) ||
          patient.fullName.toLowerCase().includes(query)
        );
      }
      
      return Math.ceil(filtered.length / this.patientsPerPage);
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
    openAppointmentModal() {
      // TODO: Implement appointment booking modal
      console.log('Opening appointment modal');
    },
    openNoteModal() {
      // TODO: Implement clinical note modal
      console.log('Opening clinical note modal');
    },
    openInvoiceModal() {
      // TODO: Implement invoice creation modal
      console.log('Opening invoice modal');
    }
  },
};
</script>

