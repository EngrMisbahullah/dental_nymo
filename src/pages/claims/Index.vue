<template>
  <!-- Main container with gradient background -->
  <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-gray-50 to-teal-50/30 font-[Poppins]">
    <div class="mx-auto py-4 md:py-6 lg:py-8">
      <!-- Header Section -->
      <header class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-200/60 mb-6">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-400"></div>

        <div class="p-5 md:p-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">NHS Claims Management</h1>
              <p class="text-sm text-slate-500 mt-1">Manage FP17, FP17O, and FP17PR claims</p>
            </div>
            <div class="flex flex-wrap gap-2.5">
              <button
                class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl cursor-pointer transition-all duration-200 hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm"
                @click="openModal('Performers')">
                <i class="fas fa-user-md text-slate-400 group-hover:text-teal-500 transition-colors"></i>
                <span class="hidden sm:inline">Performers</span>
                <span class="sm:hidden">Performers</span>
              </button>
              <button
                class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-emerald-600 hover:to-green-600 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:shadow-emerald-500/30"
                @click="openModal('New Claim')">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">New Claim</span>
                <span class="sm:hidden">New</span>
              </button>
              <button
                class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30"
                @click="openModal('Submit Batch')">
                <i class="fas fa-cloud-upload-alt"></i>
                <span class="hidden sm:inline">Submit Batch</span>
                <span class="sm:hidden">Submit</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 p-5 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Total Claims</p>
              <p class="text-2xl font-bold text-slate-800">{{ allClaimsData.length }}</p>
            </div>
            <div
              class="w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl flex items-center justify-center">
              <i class="fas fa-file-medical text-slate-600 text-lg"></i>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 p-5 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Pending</p>
              <p class="text-2xl font-bold text-amber-600">{{ pendingClaimsData.length }}</p>
            </div>
            <div
              class="w-12 h-12 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center">
              <i class="fas fa-clock text-amber-600 text-lg"></i>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 p-5 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Submitted</p>
              <p class="text-2xl font-bold text-cyan-600">{{ submittedClaimsData.length }}</p>
            </div>
            <div
              class="w-12 h-12 bg-gradient-to-br from-cyan-100 to-cyan-200 rounded-xl flex items-center justify-center">
              <i class="fas fa-paper-plane text-cyan-600 text-lg"></i>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 p-5 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Accepted</p>
              <p class="text-2xl font-bold text-emerald-600">{{ acceptedClaimsData.length }}</p>
            </div>
            <div
              class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center">
              <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 p-5 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Rejected/Errors</p>
              <p class="text-2xl font-bold text-rose-600">{{ rejectedClaimsData.length + errorClaimsData.length }}</p>
            </div>
            <div
              class="w-12 h-12 bg-gradient-to-br from-rose-100 to-rose-200 rounded-xl flex items-center justify-center">
              <i class="fas fa-exclamation-circle text-rose-600 text-lg"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <nav class="flex gap-2 mb-6 p-1.5 bg-white/60 backdrop-blur-sm rounded-xl border border-slate-200/60 w-fit">
      <button v-for="tab in tabs" :key="tab.id" :class="[
        'flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 outline-none',
        activeTab === tab.id
          ? 'bg-white text-slate-800 shadow-sm border border-slate-200/60'
          : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'
      ]" @click="selectTab(tab.id)">
        <i :class="[activeTab === tab.id ? 'text-teal-500' : 'text-slate-400', 'fas', 'fa-' + tab.icon]"></i>
        {{ tab.name }}
        <span v-if="tab.count" :class="[
          'px-2 py-0.5 rounded-full text-xs font-bold',
          activeTab === tab.id ? 'bg-teal-100 text-teal-700' : 'bg-slate-100 text-slate-500'
        ]">
          {{ tab.count }}
        </span>
      </button>
    </nav>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <!-- Card Header -->
      <div
        class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-sm">
            <i class="fas fa-clipboard-list text-white text-sm"></i>
          </div>
          <div>
            <h2 class="text-lg font-semibold text-slate-800">Claims List</h2>
            <p class="text-xs text-slate-400 mt-0.5">View and manage all claims</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <button
            class="group flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300"
            @click="downloadCSV('all')">
            <i class="fas fa-download text-slate-400 group-hover:text-teal-500"></i>
            Export
          </button>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="p-5 border-b border-slate-100">
        <div class="flex flex-col lg:flex-row gap-3">
          <div class="flex-1">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-400"></i>
              </div>
              <input v-model="searchQuery" type="text"
                placeholder="Search by patient name, performer, claim ID, or band"
                class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all" />
            </div>
          </div>
          <select v-model="filterFormType"
            class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
            <option value="">All Form Types</option>
            <option value="FP17">FP17</option>
            <option value="FP17O">FP17O</option>
            <option value="FP17PR">FP17PR</option>
          </select>
          <select v-model="filterPerformer"
            class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
            <option value="">All Performers</option>
            <option value="Dr. Emily Carter">Dr. Emily Carter</option>
            <option value="Dr. Jacob Turner">Dr. Jacob Turner</option>
            <option value="Dr. Sarah Lee">Dr. Sarah Lee</option>
          </select>
        </div>
      </div>

      <!-- Claims Table -->
      <div class="p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
          <table class="w-full min-w-[900px]">
            <thead>
              <tr class="bg-slate-50">
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Claim ID
                </th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Form
                  Type</th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient
                </th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Band
                </th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                  Performer</th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contract
                </th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status
                </th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date
                </th>
                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="claim in paginatedClaims" :key="claim.id" class="hover:bg-slate-50/50 transition-colors">
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <div class="text-sm font-semibold text-slate-700">{{ claim.id }}</div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-violet-50 text-violet-700 border border-violet-200">
                    {{ claim.formType }}
                  </span>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <div class="flex items-center">
                    <div
                      class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white font-semibold text-sm mr-3 shadow-sm">
                      {{ claim.patient.charAt(0) }}
                    </div>
                    <div class="text-sm font-medium text-slate-700">{{ claim.patient }}</div>
                  </div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <div class="text-sm text-slate-600">{{ claim.band }}</div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <div class="text-sm text-slate-700">{{ claim.performer }}</div>
                  <div class="text-xs text-slate-400">{{ claim.performerNumber }}</div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <div class="text-sm text-slate-600">{{ claim.contractNumber }}</div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <span
                    :class="['inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium border', getStatusClass(claim.status)]">
                    <span :class="['w-1.5 h-1.5 rounded-full', getStatusDotClass(claim.status)]"></span>
                    {{ claim.status }}
                  </span>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-slate-500">
                  {{ claim.submissionDate }}
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-1">
                    <button
                      class="p-1.5 rounded-lg text-slate-400 hover:text-teal-500 hover:bg-teal-50 transition-colors"
                      @click="openModal('View Claim', claim)" title="View Details">
                      <i class="fas fa-eye text-xs"></i>
                    </button>
                    <button v-if="claim.status === 'Error' || claim.status === 'Rejected'"
                      class="p-1.5 rounded-lg text-slate-400 hover:text-amber-500 hover:bg-amber-50 transition-colors"
                      @click="openModal('Amendment', claim)" title="Amend & Resubmit">
                      <i class="fas fa-edit text-xs"></i>
                    </button>
                    <button
                      class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                      @click="openModal('History', claim)" title="View History">
                      <i class="fas fa-history text-xs"></i>
                    </button>
                    <button
                      class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                      @click="openModal('View XML', claim)" title="View XML">
                      <i class="fas fa-code text-xs"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="paginatedClaims.length === 0" class="text-center py-12">
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-inbox text-slate-400 text-2xl"></i>
            </div>
            <p class="text-slate-600 font-medium">No claims found</p>
            <p class="text-slate-400 text-sm mt-1">Try adjusting your filters or search terms</p>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="px-5 py-4 border-t border-slate-100">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="text-sm text-slate-600">
            Showing <span class="font-semibold text-slate-700">{{ (currentPage - 1) * itemsPerPage + 1 }}</span> to
            <span class="font-semibold text-slate-700">{{ Math.min(currentPage * itemsPerPage, filteredClaims.length)
              }}</span> of
            <span class="font-semibold text-slate-700">{{ filteredClaims.length }}</span> results
          </div>
          <div class="flex items-center gap-2">
            <button :disabled="currentPage === 1" @click="selectPage(currentPage - 1)"
              class="px-4 py-2 text-sm font-medium rounded-lg cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300 disabled:opacity-50 disabled:cursor-not-allowed">
              Previous
            </button>
            <div class="flex gap-1">
              <button v-for="page in displayedPages" :key="page" @click="selectPage(page)" :class="[
                'px-4 py-2 text-sm font-medium rounded-lg transition-all',
                currentPage === page
                  ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25'
                  : 'bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100'
              ]">
                {{ page }}
              </button>
            </div>
            <button :disabled="currentPage === totalPages" @click="selectPage(currentPage + 1)"
              class="px-4 py-2 text-sm font-medium rounded-lg cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300 disabled:opacity-50 disabled:cursor-not-allowed">
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Enhanced Modal -->
    <transition name="modal">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="closeModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
          <!-- Modal Header -->
          <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-800">{{ modalTitle }}</h3>
            <button
              @click="closeModal"
              class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>

          <!-- Modal Content -->
          <div class="p-5 overflow-y-auto max-h-[calc(90vh-100px)]">
              <!-- New Claim Form -->
              <div v-if="modalType === 'New Claim'">
                <div class="mb-5">
                  <label class="block text-sm font-semibold text-slate-700 mb-3">Form Type</label>
                  <div class="grid grid-cols-3 gap-3">
                    <button
                      v-for="type in formTypes"
                      :key="type"
                      @click="form.formType = type"
                      :class="[
                        'px-4 py-3 rounded-xl border-2 font-semibold transition-all',
                        form.formType === type
                          ? 'border-teal-500 bg-teal-50 text-teal-700'
                          : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300'
                      ]"
                    >
                      {{ type }}
                    </button>
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient Name</label>
                    <input
                      v-model="form.patient"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="Enter patient name"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NHS Number</label>
                    <input
                      v-model="form.nhsNumber"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="000 000 0000"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Treatment Band</label>
                    <select v-model="form.band" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                      <option value="Band 1">Band 1 - Examination, diagnosis & preventative care</option>
                      <option value="Band 2">Band 2 - Band 1 + additional treatment</option>
                      <option value="Band 3">Band 3 - Band 1 & 2 + complex procedures</option>
                      <option value="Urgent">Urgent Treatment</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Performer</label>
                    <select v-model="form.performer" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                      <option value="">Select performer</option>
                      <option value="Dr. Emily Carter">Dr. Emily Carter (5678123)</option>
                      <option value="Dr. Jacob Turner">Dr. Jacob Turner (5678124)</option>
                      <option value="Dr. Sarah Lee">Dr. Sarah Lee (5678125)</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contract Number</label>
                    <input
                      v-model="form.contractNumber"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="Contract number"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Completion Date</label>
                    <input
                      v-model="form.submissionDate"
                      type="date"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                    />
                  </div>
                </div>

                <div class="mt-5">
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Treatment Details</label>
                  <textarea
                    v-model="form.treatmentDetails"
                    rows="4"
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all resize-none"
                    placeholder="Enter treatment details..."
                  ></textarea>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                  <button
                    @click="closeModal"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300"
                  >
                    Cancel
                  </button>
                  <button
                    @click="saveClaim"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 hover:from-teal-600 hover:to-cyan-600"
                  >
                    Create Claim
                  </button>
                </div>
              </div>

              <!-- Amendment Modal -->
              <div v-else-if="modalType === 'Amendment'">
                <div class="bg-amber-50/50 border border-amber-200/50 rounded-xl p-4 mb-5">
                  <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5"></i>
                    <div>
                      <h4 class="font-semibold text-amber-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-sticky-note text-amber-500"></i>
                        Rejection Reason
                      </h4>
                      <p class="text-sm text-amber-700/80">{{ selectedClaim?.rejectionReason || 'Invalid performer number. Please verify and update.' }}</p>
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Claim ID</label>
                    <input
                      v-model="form.id"
                      type="text"
                      disabled
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 cursor-not-allowed"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient</label>
                    <input
                      v-model="form.patient"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Performer</label>
                    <select v-model="form.performer" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                      <option value="Dr. Emily Carter">Dr. Emily Carter (5678123)</option>
                      <option value="Dr. Jacob Turner">Dr. Jacob Turner (5678124)</option>
                      <option value="Dr. Sarah Lee">Dr. Sarah Lee (5678125)</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Band</label>
                    <select v-model="form.band" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer">
                      <option value="Band 1">Band 1</option>
                      <option value="Band 2">Band 2</option>
                      <option value="Band 3">Band 3</option>
                    </select>
                  </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                  <button
                    @click="closeModal"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300"
                  >
                    Cancel
                  </button>
                  <button
                    @click="resubmitClaim"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 hover:from-teal-600 hover:to-cyan-600"
                  >
                    Resubmit Claim
                  </button>
                </div>
              </div>

              <!-- View Claim Details -->
              <div v-else-if="modalType === 'View Claim'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                  <div class="space-y-4">
                    <div>
                      <label class="text-sm font-medium text-slate-500">Claim ID</label>
                      <p class="mt-1 text-base font-semibold text-slate-800">{{ selectedClaim.id }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-slate-500">Form Type</label>
                      <p class="mt-1"><span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-medium bg-violet-50 text-violet-700 border border-violet-200">{{ selectedClaim.formType }}</span></p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-slate-500">Patient</label>
                      <p class="mt-1 text-base font-semibold text-slate-800">{{ selectedClaim.patient }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-slate-500">Treatment Band</label>
                      <p class="mt-1 text-base font-semibold text-slate-800">{{ selectedClaim.band }}</p>
                    </div>
                  </div>
                  <div class="space-y-4">
                    <div>
                      <label class="text-sm font-medium text-slate-500">Performer</label>
                      <p class="mt-1 text-base font-semibold text-slate-800">{{ selectedClaim.performer }}</p>
                      <p class="text-sm text-slate-500">{{ selectedClaim.performerNumber }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-slate-500">Contract Number</label>
                      <p class="mt-1 text-base font-semibold text-slate-800">{{ selectedClaim.contractNumber }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-slate-500">Status</label>
                      <p class="mt-1">
                        <span :class="['inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-sm font-medium border', getStatusClass(selectedClaim.status)]">
                          <span :class="['w-2 h-2 rounded-full', getStatusDotClass(selectedClaim.status)]"></span>
                          {{ selectedClaim.status }}
                        </span>
                      </p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-slate-500">Submission Date</label>
                      <p class="mt-1 text-base font-semibold text-slate-800">{{ selectedClaim.submissionDate }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Claim History -->
              <div v-else-if="modalType === 'History'">
                <div class="relative">
                  <!-- Timeline line -->
                  <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-slate-200"></div>
                  
                  <div class="space-y-4">
                    <div 
                      v-for="(event, index) in claimHistory" 
                      :key="index"
                      class="relative flex gap-3 group"
                    >
                      <div :class="[
                        'w-6 h-6 rounded-full flex items-center justify-center z-10 transition-all',
                        index === 0 ? 'bg-teal-500 ring-4 ring-teal-100' : event.color.replace('bg-', 'bg-') + ' ring-2 ring-white'
                      ]">
                        <i :class="[
                          'fas text-[10px]',
                          index === 0 ? 'fa-clock text-white' : 'fa-circle text-white'
                        ]"></i>
                      </div>
                      <div class="flex-1 pb-4">
                        <p class="text-sm font-medium text-slate-700">{{ event.title }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ event.user }} · {{ event.date }}</p>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ event.description }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- View XML -->
              <div v-else-if="modalType === 'View XML'">
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto">
                  <pre class="text-slate-100 text-sm font-mono">{{ generateXML(selectedClaim) }}</pre>
                </div>
                <div class="mt-4 flex justify-end">
                  <button
                    @click="copyXML"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300"
                  >
                    <i class="fas fa-copy text-slate-400"></i>
                    Copy to Clipboard
                  </button>
                </div>
              </div>

              <!-- Submit Batch -->
              <div v-else-if="modalType === 'Submit Batch'">
                <div class="text-center py-6">
                  <div class="w-16 h-16 rounded-full bg-gradient-to-br from-teal-100 to-cyan-200 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cloud-upload-alt text-teal-600 text-2xl"></i>
                  </div>
                  <h3 class="text-lg font-bold text-slate-800 mb-2">Submit Claims Batch</h3>
                  <p class="text-slate-600 mb-6">
                    You are about to submit <span class="font-bold text-teal-600">{{ pendingClaimsData.length }} pending claims</span> to the NHS BSA EDI gateway.
                  </p>
                  <div class="bg-teal-50/50 border border-teal-200/50 rounded-xl p-4 text-left mb-6">
                    <h4 class="font-semibold text-teal-800 mb-2 flex items-center gap-2">
                      <i class="fas fa-info-circle text-teal-600"></i>
                      Batch includes:
                    </h4>
                    <ul class="text-sm text-teal-700/80 space-y-1">
                      <li>• FP17 Forms: {{ pendingClaimsData.filter(c => c.formType === 'FP17').length }}</li>
                      <li>• FP17O Forms: {{ pendingClaimsData.filter(c => c.formType === 'FP17O').length }}</li>
                      <li>• FP17PR Forms: {{ pendingClaimsData.filter(c => c.formType === 'FP17PR').length }}</li>
                    </ul>
                  </div>
                  <div class="flex justify-center gap-3">
                    <button
                      @click="closeModal"
                      class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300"
                    >
                      Cancel
                    </button>
                    <button
                      @click="performBatchSubmission"
                      class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 hover:from-teal-600 hover:to-cyan-600"
                    >
                      Confirm Submission
                    </button>
                  </div>
                </div>
              </div>

              <!-- Performers Management -->
              <div v-else-if="modalType === 'Performers'">
                <div class="mb-5">
                  <button
                    @click="openModal('Add Performer')"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30"
                  >
                    <i class="fas fa-plus"></i>
                    Add Performer
                  </button>
                </div>
                <div class="space-y-3">
                  <div v-for="performer in performers" :key="performer.id" class="border border-slate-200 rounded-xl p-4 hover:shadow-sm transition-shadow">
                    <div class="flex items-start justify-between">
                      <div class="flex-1">
                        <h4 class="font-semibold text-slate-800 mb-2">{{ performer.name }}</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                          <div>
                            <span class="text-slate-500">Performer Number:</span>
                            <span class="ml-2 font-medium text-slate-700">{{ performer.number }}</span>
                          </div>
                          <div>
                            <span class="text-slate-500">Contract:</span>
                            <span class="ml-2 font-medium text-slate-700">{{ performer.contract }}</span>
                          </div>
                          <div>
                            <span class="text-slate-500">UDA Target:</span>
                            <span class="ml-2 font-medium text-slate-700">{{ performer.udaTarget }}</span>
                          </div>
                          <div>
                            <span class="text-slate-500">UDA Achieved:</span>
                            <span class="ml-2 font-medium text-slate-700">{{ performer.udaAchieved }}</span>
                          </div>
                        </div>
                        <div class="mt-3">
                          <div class="w-full bg-slate-200 rounded-full h-2">
                            <div 
                              class="bg-gradient-to-r from-teal-500 to-cyan-500 h-2 rounded-full transition-all" 
                              :style="{ width: `${(performer.udaAchieved / performer.udaTarget) * 100}%` }"
                            ></div>
                          </div>
                          <p class="text-xs text-slate-500 mt-1">
                            {{ Math.round((performer.udaAchieved / performer.udaTarget) * 100) }}% of target achieved
                          </p>
                        </div>
                      </div>
                      <button class="ml-4 p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Add Performer -->
              <div v-else-if="modalType === 'Add Performer'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Performer Name</label>
                    <input
                      v-model="performerForm.name"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="Dr. John Smith"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Performer Number</label>
                    <input
                      v-model="performerForm.number"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="5678123"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contract Number</label>
                    <input
                      v-model="performerForm.contract"
                      type="text"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="NHS-001234"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">UDA Target</label>
                    <input
                      v-model="performerForm.udaTarget"
                      type="number"
                      class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                      placeholder="5000"
                    />
                  </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                  <button
                    @click="openModal('Performers')"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300"
                  >
                    Cancel
                  </button>
                  <button
                    @click="savePerformer"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 hover:from-teal-600 hover:to-cyan-600"
                  >
                    Add Performer
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </transition>
</template>

<script setup>
import { ref, computed, watch } from "vue";

// Define the available tabs
const tabs = ref([
  { id: "all", name: "All", icon: "list" },
  { id: "pending", name: "Pending", icon: "clock" },
  { id: "submitted", name: "Submitted", icon: "paper-plane" },
  { id: "accepted", name: "Accepted", icon: "check-circle" },
  { id: "rejected", name: "Rejected", icon: "times-circle" },
  { id: "error", name: "Errors", icon: "exclamation-circle" },
]);

// Reactive state for the application
const activeTab = ref("all");
const currentPage = ref(1);
const itemsPerPage = 10;
const showModal = ref(false);
const modalTitle = ref("");
const modalType = ref("");
const selectedClaim = ref(null);
const form = ref({
  formType: "FP17",
  patient: "",
  nhsNumber: "",
  band: "Band 1",
  performer: "",
  contractNumber: "",
  submissionDate: new Date().toISOString().split("T")[0],
  treatmentDetails: "",
  status: "Pending",
});

// Form types for claim creation
const formTypes = ref(["FP17", "FP17O", "FP17PR"]);

// Search and filter state
const searchQuery = ref("");
const filterFormType = ref("");
const filterPerformer = ref("");

// Performers data
const performers = ref([
  {
    id: 1,
    name: "Dr. Emily Carter",
    number: "5678123",
    contract: "NHS-001234",
    udaTarget: 5000,
    udaAchieved: 3200,
  },
  {
    id: 2,
    name: "Dr. Jacob Turner",
    number: "5678124",
    contract: "NHS-001235",
    udaTarget: 4500,
    udaAchieved: 4100,
  },
  {
    id: 3,
    name: "Dr. Sarah Lee",
    number: "5678125",
    contract: "NHS-001236",
    udaTarget: 4000,
    udaAchieved: 2800,
  },
]);

// Performer form for adding new performers
const performerForm = ref({
  name: "",
  number: "",
  contract: "",
  udaTarget: 0,
  udaAchieved: 0,
});

// Watch for changes to the selectedClaim and update the form
watch(selectedClaim, (newClaim) => {
  if (newClaim) {
    form.value = { ...newClaim };
  } else {
    form.value = {
      formType: "FP17",
      patient: "",
      nhsNumber: "",
      band: "Band 1",
      performer: "",
      contractNumber: "",
      submissionDate: new Date().toISOString().split("T")[0],
      treatmentDetails: "",
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
  const performersList = [
    { name: "Dr. Emily Carter", number: "5678123", contract: "NHS-001234" },
    { name: "Dr. Jacob Turner", number: "5678124", contract: "NHS-001235" },
    { name: "Dr. Sarah Lee", number: "5678125", contract: "NHS-001236" },
  ];
  const formTypes = ["FP17", "FP17O", "FP17PR"];

  for (let i = 1; i <= count; i++) {
    const randomPatient = patients[Math.floor(Math.random() * patients.length)];
    const randomBand = bands[Math.floor(Math.random() * bands.length)];
    const randomPerformer = performersList[Math.floor(Math.random() * performersList.length)];
    const randomFormType = formTypes[Math.floor(Math.random() * formTypes.length)];

    let claimStatus = status;
    if (status === "all") {
      const allStatuses = ["Pending", "Submitted", "Accepted", "Rejected", "Error"];
      claimStatus = allStatuses[Math.floor(Math.random() * allStatuses.length)];
    } else if (status === "pending") {
      claimStatus = "Pending";
    } else if (status === "submitted") {
      claimStatus = "Submitted";
    } else if (status === "accepted") {
      claimStatus = "Accepted";
    } else if (status === "rejected") {
      claimStatus = "Rejected";
    } else if (status === "error") {
      claimStatus = "Error";
    }

    claims.push({
      id: `#${Math.floor(10000 + Math.random() * 90000)}`,
      formType: randomFormType,
      patient: randomPatient,
      band: randomBand,
      performer: randomPerformer.name,
      performerNumber: randomPerformer.number,
      contractNumber: randomPerformer.contract,
      status: claimStatus,
      submissionDate: new Date(
        Date.now() - Math.floor(Math.random() * 30) * 24 * 60 * 60 * 1000
      )
        .toISOString()
        .split("T")[0],
      rejectionReason: claimStatus === "Rejected" || claimStatus === "Error" ? "Invalid performer number. Please verify and update." : null,
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
      return "bg-emerald-50 text-emerald-700 border-emerald-200";
    case "Submitted":
      return "bg-cyan-50 text-cyan-700 border-cyan-200";
    case "Pending":
      return "bg-amber-50 text-amber-700 border-amber-200";
    case "Rejected":
      return "bg-rose-50 text-rose-700 border-rose-200";
    case "Error":
      return "bg-red-50 text-red-700 border-red-200";
    default:
      return "bg-slate-50 text-slate-700 border-slate-200";
  }
};

// Function to get status dot color
const getStatusDotClass = (status) => {
  switch (status) {
    case "Accepted":
      return "bg-emerald-500";
    case "Submitted":
      return "bg-cyan-500";
    case "Pending":
      return "bg-amber-500";
    case "Rejected":
      return "bg-rose-500";
    case "Error":
      return "bg-red-500";
    default:
      return "bg-slate-500";
  }
};

// Computed property for displayed pages in pagination
const displayedPages = computed(() => {
  const pages = [];
  const maxPages = 5;
  let startPage = Math.max(1, currentPage.value - Math.floor(maxPages / 2));
  let endPage = Math.min(totalPages.value, startPage + maxPages - 1);

  if (endPage - startPage < maxPages - 1) {
    startPage = Math.max(1, endPage - maxPages + 1);
  }

  for (let i = startPage; i <= endPage; i++) {
    pages.push(i);
  }

  return pages;
});

// Claim history for the timeline
const claimHistory = computed(() => {
  if (!selectedClaim.value) return [];

  const history = [
    {
      title: "Claim Created",
      description: "Initial claim created and saved as draft",
      date: selectedClaim.value.submissionDate,
      user: "Admin User",
      color: "bg-blue-500",
    },
  ];

  if (selectedClaim.value.status === "Submitted" || selectedClaim.value.status === "Accepted" || selectedClaim.value.status === "Rejected") {
    history.push({
      title: "Claim Submitted",
      description: "Claim submitted to NHS BSA EDI gateway",
      date: selectedClaim.value.submissionDate,
      user: "System",
      color: "bg-indigo-500",
    });
  }

  if (selectedClaim.value.status === "Accepted") {
    history.push({
      title: "Claim Accepted",
      description: "Claim has been accepted and processed successfully",
      date: selectedClaim.value.submissionDate,
      user: "NHS BSA",
      color: "bg-green-500",
    });
  }

  if (selectedClaim.value.status === "Rejected" || selectedClaim.value.status === "Error") {
    history.push({
      title: selectedClaim.value.status === "Rejected" ? "Claim Rejected" : "Claim Error",
      description: selectedClaim.value.rejectionReason || "An error occurred during processing",
      date: selectedClaim.value.submissionDate,
      user: "NHS BSA",
      color: "bg-red-500",
    });
  }

  return history;
});

// Functions to control the modal popup
const openModal = (type, claim = null) => {
  modalType.value = type;
  selectedClaim.value = claim;

  switch (type) {
    case "New Claim":
      modalTitle.value = "New Claim Form";
      form.value = {
        formType: "FP17",
        patient: "",
        nhsNumber: "",
        band: "Band 1",
        performer: "",
        contractNumber: "",
        submissionDate: new Date().toISOString().split("T")[0],
        treatmentDetails: "",
        status: "Pending",
      };
      break;
    case "Amendment":
      modalTitle.value = `Amend & Resubmit Claim: ${claim.id}`;
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
    case "Performers":
      modalTitle.value = "Manage Performers";
      break;
    case "Add Performer":
      modalTitle.value = "Add New Performer";
      performerForm.value = {
        name: "",
        number: "",
        contract: "",
        udaTarget: 0,
        udaAchieved: 0,
      };
      break;
    case "History":
      modalTitle.value = `Claim History: ${claim.id}`;
      break;
  }

  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedClaim.value = null;
};

// Function to save a new claim
const saveClaim = () => {
  const newClaim = {
    id: `#${Math.floor(10000 + Math.random() * 90000)}`,
    ...form.value,
    status: "Pending",
  };

  allClaimsData.value.unshift(newClaim);
  pendingClaimsData.value.unshift(newClaim);

  closeModal();
  selectTab("pending");
};

// Function to resubmit a claim after amendment
const resubmitClaim = () => {
  const claimIndex = allClaimsData.value.findIndex(c => c.id === form.value.id);
  if (claimIndex !== -1) {
    allClaimsData.value[claimIndex] = { ...form.value, status: "Pending" };
  }

  // Remove from rejected/error and add to pending
  rejectedClaimsData.value = rejectedClaimsData.value.filter(c => c.id !== form.value.id);
  errorClaimsData.value = errorClaimsData.value.filter(c => c.id !== form.value.id);
  pendingClaimsData.value.unshift({ ...form.value, status: "Pending" });

  closeModal();
  selectTab("pending");
};

// Function to save a new performer
const savePerformer = () => {
  const newPerformer = {
    id: performers.value.length + 1,
    ...performerForm.value,
  };

  performers.value.push(newPerformer);
  openModal("Performers");
};

// Function to copy XML to clipboard
const copyXML = () => {
  const xmlText = generateXML(selectedClaim.value);
  navigator.clipboard.writeText(xmlText).then(() => {
    alert("XML copied to clipboard!");
  });
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
/* Modal transition */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-from>div,
.modal-leave-to>div {
  transform: scale(0.95);
}

/* Custom scrollbar styling */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Table hover effect enhancement */
tbody tr {
  transition: all 0.2s ease;
}

/* Input focus effects - matching clinical notes */
input:focus,
select:focus,
textarea:focus {
  outline: none;
}

/* Smooth transitions for all interactive elements */
button,
input,
select,
textarea {
  transition: all 0.2s ease;
}
</style>
