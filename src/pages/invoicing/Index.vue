<template>
  <div class="font-[Inter,sans-serif] bg-gray-50">
    <div class="p-4 sm:p-8 m-0 w-full">
      <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">John Doe</h1>
          <p class="text-sm text-gray-500">Patient ID: 12345</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-4">
          <button class="flex items-center justify-center py-2 px-4 border border-gray-300 text-gray-600 bg-white rounded-lg text-sm transition-colors hover:bg-gray-100">
            <span class="material-icons text-base mr-2">history</span>
            Review History
          </button>
          <button class="flex items-center justify-center py-2 px-4 bg-blue-600 text-white border-none rounded-lg text-sm transition-colors hover:bg-blue-700">
            <span class="material-icons text-base mr-2">add</span>
            New Entry
          </button>
        </div>
      </header>

      <main class="bg-white rounded-xl shadow-lg">
        <div class="flex flex-wrap border-b border-gray-200">
          <button
            :class="['py-3 px-4 text-sm font-medium w-1/2 sm:w-auto text-center border-none bg-none cursor-pointer text-gray-500 border-b-2 border-transparent transition-all hover:text-gray-700', { '!text-gray-900 !border-gray-900': activeTab === 'service-catalogue' }]"
            @click="activeTab = 'service-catalogue'"
          >
            Service Catalogue
          </button>
          <button
            :class="['py-3 px-4 text-sm font-medium w-1/2 sm:w-auto text-center border-none bg-none cursor-pointer text-gray-500 border-b-2 border-transparent transition-all hover:text-gray-700', { '!text-gray-900 !border-gray-900': activeTab === 'invoicing' }]"
            @click="activeTab = 'invoicing'"
          >
            Invoicing
          </button>
          <button
            :class="['py-3 px-4 text-sm font-medium w-1/2 sm:w-auto text-center border-none bg-none cursor-pointer text-gray-500 border-b-2 border-transparent transition-all hover:text-gray-700', { '!text-gray-900 !border-gray-900': activeTab === 'payment-tracking' }]"
            @click="activeTab = 'payment-tracking'"
          >
            Payment Tracking
          </button>
          <button
            :class="['py-3 px-4 text-sm font-medium w-1/2 sm:w-auto text-center border-none bg-none cursor-pointer text-gray-500 border-b-2 border-transparent transition-all hover:text-gray-700', { '!text-gray-900 !border-gray-900': activeTab === 'insurance-claims' }]"
            @click="activeTab = 'insurance-claims'"
          >
            Insurance Claims
          </button>
          <button
            :class="['py-3 px-4 text-sm font-medium w-full sm:w-auto text-center border-none bg-none cursor-pointer text-gray-500 border-b-2 border-transparent transition-all hover:text-gray-700', { '!text-gray-900 !border-gray-900': activeTab === 'payment-integration' }]"
            @click="activeTab = 'payment-integration'"
          >
            Payment Integration
          </button>
        </div>

        <div class="p-6">
          <div v-if="activeTab === 'service-catalogue'">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
              <h2 class="text-xl font-semibold text-gray-800">Service Catalogue</h2>
              <button class="flex items-center justify-center py-2 px-4 bg-blue-600 text-white border-none rounded-lg transition-colors self-end sm:self-auto hover:bg-blue-700">
                <span class="material-icons text-base mr-2">add</span>
                Add Service
              </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end mb-8">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                <input class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="e.g., Teeth Whitening" type="text" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Select category</option>
                  <option>Cosmetic</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price Band</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Select band</option>
                  <option>Band A</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Assigned Clinician</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Select clinician</option>
                  <option>Dr. Smith</option>
                </select>
              </div>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="py-4 px-6 font-medium uppercase text-gray-600">Service Name</th>
                    <th class="py-4 px-6 font-medium uppercase text-gray-600">Category</th>
                    <th class="py-4 px-6 font-medium uppercase text-gray-600">Price</th>
                    <th class="py-4 px-6 font-medium uppercase text-gray-600">Clinician</th>
                    <th class="py-4 px-6 font-medium uppercase text-gray-600">Price Band</th>
                    <th class="py-4 px-6 font-medium uppercase text-gray-600 text-center">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-4 px-6">Teeth Whitening</td>
                    <td class="py-4 px-6"><span class="inline-block text-xs font-medium py-1 px-2.5 rounded-full bg-purple-100 text-purple-600">Cosmetic</span></td>
                    <td class="py-4 px-6 font-semibold text-green-500">£350.00</td>
                    <td class="py-4 px-6">Dr. Smith</td>
                    <td class="py-4 px-6"><span class="inline-block text-xs font-medium py-1 px-2.5 rounded-full bg-blue-100 text-blue-700">Band B</span></td>
                    <td class="py-4 px-6 text-center">
                      <div class="flex items-center justify-center gap-4">
                        <button class="bg-none border-none p-0 cursor-pointer text-gray-500 transition-colors hover:text-blue-600">
                          <span class="material-icons">edit</span>
                        </button>
                        <button class="bg-none border-none p-0 cursor-pointer text-gray-500 transition-colors hover:text-red-500">
                          <span class="material-icons">delete</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-4 px-6">Check-up</td>
                    <td class="py-4 px-6"><span class="inline-block text-xs font-medium py-1 px-2.5 rounded-full bg-green-100 text-green-800">Preventive</span></td>
                    <td class="py-4 px-6 font-semibold text-green-500">£150.00</td>
                    <td class="py-4 px-6">Dr. Jones</td>
                    <td class="py-4 px-6"><span class="inline-block text-xs font-medium py-1 px-2.5 rounded-full bg-orange-100 text-orange-600">Band A</span></td>
                    <td class="py-4 px-6 text-center">
                      <div class="flex items-center justify-center gap-4">
                        <button class="bg-none border-none p-0 cursor-pointer text-gray-500 transition-colors hover:text-blue-600">
                          <span class="material-icons">edit</span>
                        </button>
                        <button class="bg-none border-none p-0 cursor-pointer text-gray-500 transition-colors hover:text-red-500">
                          <span class="material-icons">delete</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div v-if="activeTab === 'invoicing'" class="pt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Treatment-Based Invoicing</h2>
            <p class="text-sm text-gray-600 mb-4">Dummy content for the Invoicing section.</p>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
              <div class="flex gap-2">
                <button class="py-2 px-4 border border-gray-300 rounded-lg text-sm bg-white cursor-pointer hover:bg-gray-100">At Treatment</button>
                <button class="py-2 px-4 border border-blue-300 rounded-lg text-sm bg-blue-50 text-blue-600 cursor-pointer">On Completion</button>
              </div>
              <div class="flex flex-wrap gap-4">
                <button class="flex items-center justify-center py-2 px-4 border border-gray-300 text-gray-600 bg-white rounded-lg text-sm transition-colors hover:bg-gray-100">
                  <span class="material-icons text-base mr-2">print</span>Print Batch Invoices
                </button>
                <button class="flex items-center justify-center py-2 px-4 border border-gray-300 text-gray-600 bg-white rounded-lg text-sm transition-colors hover:bg-gray-100">
                  <span class="material-icons text-base mr-2">email</span>Email Receipts
                </button>
                <button class="flex items-center justify-center py-2 px-4 bg-green-500 text-white border-none rounded-lg text-sm transition-colors hover:bg-green-600">
                  <span class="material-icons text-base mr-2">receipt_long</span>Generate Invoice
                </button>
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'payment-tracking'" class="pt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Tracking</h2>
            <p class="text-sm text-gray-600 mb-4">Dummy content for the Payment Tracking section.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end mb-8">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Unpaid</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount Paid (£)</label>
                <input class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="e.g., 100.00" type="text" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Insurance Claim Status</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Not Submitted</option>
                </select>
              </div>
              <div class="self-end lg:self-auto">
                <button class="flex items-center justify-center py-2 px-4 bg-blue-600 text-white border-none rounded-lg transition-colors w-full sm:w-auto hover:bg-blue-700">
                  <span class="material-icons text-base mr-2">track_changes</span>Update Status
                </button>
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'insurance-claims'" class="pt-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
              <h2 class="text-xl font-semibold text-gray-800">Insurance Claims</h2>
              <button class="flex items-center justify-center py-2 px-4 bg-blue-600 text-white border-none rounded-lg text-sm transition-colors hover:bg-blue-700">
                <span class="material-icons text-base mr-2">cloud_upload</span>Submit New Claim
              </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Claim Reference No.</label>
                <input class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="e.g., C-123456" type="text" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Insurance Provider</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Select provider</option>
                  <option>Provider A</option>
                  <option>Provider B</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Claim Status</label>
                <select class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                  <option>Submitted</option>
                  <option>In Review</option>
                  <option>Approved</option>
                  <option>Rejected</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Submitted</label>
                <input class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600" type="date" />
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'payment-integration'" class="pt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Integration</h2>
            <div class="flex flex-wrap gap-4 mb-4">
              <button class="flex items-center justify-center py-2 px-4 border border-gray-300 text-gray-600 bg-white rounded-lg text-sm transition-colors hover:bg-gray-100">
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZmuivvWbfE5N8ZOnXK68-JeUr-HWHsFcZ2krApxqK7FcD8_GgoCyRyn2riaKbEOGgiRMZti3TudgfCzktGuarSsotV3ycr7VGVdLl8rz4gFUx6p9oF14NIu-bbX2hX0GPoakMf7YWYpE7m8CadSBcrvkvv_rbk2KWBS1Lw9zbn-KtxpLwukP6CgEaJtH3SfSJ1CidKUN8WqYs1gFZkD3zEzAvNqU95NfIYd3FtCB3AR4b64RFkKwl0KxctVDItCf-ncMTa3mLFVY"
                  alt="Stripe"
                  class="h-6 w-auto mr-2"
                />Pay with Stripe
              </button>
              <button class="flex items-center justify-center py-2 px-4 border border-gray-300 text-gray-600 bg-white rounded-lg text-sm transition-colors hover:bg-gray-100">
                <span class="material-icons text-base mr-2">credit_card</span>Card Terminal
              </button>
              <button class="flex items-center justify-center py-2 px-4 border border-gray-300 text-gray-600 bg-white rounded-lg text-sm transition-colors hover:bg-gray-100">
                <span class="material-icons text-base mr-2">account_balance</span>Bank Transfer
              </button>
            </div>
            <p class="text-sm text-gray-500">Dummy text about payment methods. This section allows the patient to pay via various integrated services.</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: "PrivateTreatment",
  data() {
    return {
      activeTab: "service-catalogue",
    };
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");
</style>
