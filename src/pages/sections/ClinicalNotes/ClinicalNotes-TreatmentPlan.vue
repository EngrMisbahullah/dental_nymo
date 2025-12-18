<template>
  <div class="flex flex-col min-h-screen w-full p-4 md:p-6 bg-gray-100 font-[Poppins]">
    <!-- Header -->
    <header class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-0 p-4 md:px-10 md:py-5 border-b border-gray-300 bg-white rounded-t-lg">
      <h1 class="text-xl md:text-2xl font-bold text-gray-800 m-0">John Doe</h1>
      <span class="sm:ml-4 text-gray-500 text-sm">Patient ID: 12345</span>
      <div class="sm:ml-auto flex flex-wrap gap-2 mt-3 sm:mt-0">
        <button class="flex items-center gap-2 px-3 md:px-4 py-2 text-sm font-medium border border-gray-300 bg-white rounded-md cursor-pointer transition-colors hover:bg-gray-100">
          <i class="fas fa-history"></i> 
          <span class="hidden sm:inline">Review History</span>
          <span class="sm:hidden">History</span>
        </button>
        <button class="flex items-center gap-2 px-3 md:px-4 py-2 text-sm font-medium bg-indigo-600 text-white border border-indigo-600 rounded-md cursor-pointer transition-colors hover:bg-indigo-700">
          <i class="fas fa-plus"></i> 
          <span class="hidden sm:inline">New Entry</span>
          <span class="sm:hidden">New</span>
        </button>
      </div>
    </header>

    <!-- Tabs -->
    <div class="flex bg-gray-200 border-b border-gray-300 px-4 md:px-10 overflow-x-auto">
      <div
        :class="[
          'px-4 md:px-5 py-3 cursor-pointer font-medium border-b-[3px] transition-colors whitespace-nowrap text-sm md:text-base',
          activeTab === 'soap' 
            ? 'border-gray-900 text-gray-900' 
            : 'border-transparent text-gray-500 hover:text-gray-800'
        ]"
        @click="activeTab = 'soap'"
      >
        SOAP Notes
      </div>
      <div
        :class="[
          'px-4 md:px-5 py-3 cursor-pointer font-medium border-b-[3px] transition-colors whitespace-nowrap text-sm md:text-base',
          activeTab === 'treatment' 
            ? 'border-gray-900 text-gray-900' 
            : 'border-transparent text-gray-500 hover:text-gray-800'
        ]"
        @click="activeTab = 'treatment'"
      >
        Treatment Plans
      </div>
    </div>

    <!-- Content Container -->
    <div class="flex flex-col lg:flex-row p-4 md:px-10 md:py-5 gap-5">
      <!-- Left Panel - SOAP Form -->
      <div class="flex-1" v-show="activeTab === 'soap'">
        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden shadow-md">
          <!-- Card Header -->
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-4 md:px-5 md:py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold m-0 text-gray-800">New SOAP Note</h2>
            <div class="sm:ml-auto flex items-center gap-2">
              <label for="template-select" class="text-sm text-gray-600">Template:</label>
              <select id="template-select" class="px-2.5 py-1.5 rounded border border-gray-300 text-sm text-gray-700">
                <option>General Checkup</option>
              </select>
            </div>
          </div>
          
          <!-- Card Body -->
          <div class="p-4 md:p-5">
            <div class="mb-5">
              <label for="subjective" class="block font-medium mb-1.5 text-gray-700">Subjective</label>
              <textarea
                id="subjective"
                class="w-full p-2.5 border border-gray-300 rounded resize-y min-h-[80px] text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Patient's chief complaint, history..."
              ></textarea>
            </div>
            <div class="mb-5">
              <label for="objective" class="block font-medium mb-1.5 text-gray-700">Objective</label>
              <textarea
                id="objective"
                class="w-full p-2.5 border border-gray-300 rounded resize-y min-h-[80px] text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Clinical findings from examination..."
              ></textarea>
            </div>
            <div class="mb-5">
              <label for="assessment" class="block font-medium mb-1.5 text-gray-700">Assessment</label>
              <textarea
                id="assessment"
                class="w-full p-2.5 border border-gray-300 rounded resize-y min-h-[80px] text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Diagnosis or differential diagnosis..."
              ></textarea>
            </div>
            <div class="mb-5">
              <label for="plan" class="block font-medium mb-1.5 text-gray-700">Plan</label>
              <textarea
                id="plan"
                class="w-full p-2.5 border border-gray-300 rounded resize-y min-h-[80px] text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Treatment plan, medications, procedures..."
              ></textarea>
            </div>
            
            <!-- Footer Buttons -->
            <div class="flex justify-end gap-2.5 pt-2.5">
              <button class="px-4 py-2 text-sm rounded-md cursor-pointer transition-colors bg-gray-50 text-gray-700 border border-gray-300 hover:bg-gray-200">
                Save Draft
              </button>
              <button class="px-4 py-2 text-sm rounded-md cursor-pointer transition-colors bg-indigo-600 text-white border border-indigo-600 hover:bg-indigo-700">
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Panel -->
      <div class="flex-1">
        <!-- SOAP Notes History -->
        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden shadow-md" v-if="activeTab === 'soap'">
          <div class="flex items-center p-4 md:px-5 md:py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold m-0 text-gray-800">Sample SOAP Notes</h2>
          </div>
          <div class="p-4 md:p-5">
            <!-- Note Entry 1 -->
            <div class="p-4 border-b border-gray-200">
              <div class="flex justify-between mb-2.5 font-bold text-sm">
                <span class="text-gray-500">2024-05-15</span>
                <span class="text-indigo-600">General Checkup</span>
              </div>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600">
                <strong class="text-gray-800">S:</strong> Patient reports sensitivity in the upper right
                quadrant, especially to cold beverages. No pain upon biting. Has not seen
                a dentist in two years.
              </p>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600">
                <strong class="text-gray-800">O:</strong> Clinical examination reveals an old amalgam filling on
                tooth #3. Small recurrent decay is visible on the distal margin. No
                mobility or signs of infection.
              </p>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600"><strong class="text-gray-800">A:</strong> Recurrent decay, tooth #3.</p>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600">
                <strong class="text-gray-800">P:</strong> Discussed treatment options, including a new composite
                filling. Patient consented. Scheduled for next week.
              </p>
            </div>
            
            <!-- Note Entry 2 -->
            <div class="p-4">
              <div class="flex justify-between mb-2.5 font-bold text-sm">
                <span class="text-gray-500">2024-03-20</span>
                <span class="text-indigo-600">Emergency Visit</span>
              </div>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600">
                <strong class="text-gray-800">S:</strong> Patient presented with severe pain on the lower left
                side. The pain is sharp and constant.
              </p>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600">
                <strong class="text-gray-800">O:</strong> Examination shows a large carious lesion on tooth #19.
                Percussion and palpation tests were positive. X-ray confirms extensive
                decay into the pulp.
              </p>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600"><strong class="text-gray-800">A:</strong> Irreversible pulpitis, tooth #19.</p>
              <p class="my-1.5 text-sm leading-relaxed text-gray-600">
                <strong class="text-gray-800">P:</strong> Performed an emergency pulpectomy to alleviate pain.
                Prescribed antibiotics and anti-inflammatory medication. Recommended a
                root canal procedure with a crown.
              </p>
            </div>
          </div>
        </div>

        <!-- Treatment Plan -->
        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden shadow-md" v-if="activeTab === 'treatment'">
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-4 md:px-5 md:py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold m-0 text-gray-800">Current Treatment Plan</h2>
            <button class="sm:ml-auto px-4 py-2 text-sm rounded-md cursor-pointer transition-colors bg-gray-50 text-gray-700 border border-gray-300 hover:bg-gray-200">
              Edit Plan
            </button>
          </div>
          <div class="p-4 md:p-5">
            <!-- Treatment Table -->
            <div class="overflow-x-auto -mx-4 md:mx-0">
              <table class="w-full border-collapse mb-5 min-w-[500px]">
                <thead>
                  <tr>
                    <th class="p-3 text-left border-b border-gray-200 bg-gray-200 font-medium text-gray-500 uppercase text-xs">Procedure</th>
                    <th class="p-3 text-left border-b border-gray-200 bg-gray-200 font-medium text-gray-500 uppercase text-xs">Tooth</th>
                    <th class="p-3 text-left border-b border-gray-200 bg-gray-200 font-medium text-gray-500 uppercase text-xs">Cost</th>
                    <th class="p-3 text-left border-b border-gray-200 bg-gray-200 font-medium text-gray-500 uppercase text-xs">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">Examination</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">All</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">$50</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">
                      <span class="inline-block px-2 py-1 rounded-xl text-xs font-medium bg-green-100 text-green-800">Completed</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">Filling</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">18</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">$120</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">
                      <span class="inline-block px-2 py-1 rounded-xl text-xs font-medium bg-yellow-100 text-yellow-800">Scheduled</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">Extraction</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">21</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">$200</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">
                      <span class="inline-block px-2 py-1 rounded-xl text-xs font-medium bg-red-100 text-red-800">Pending</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">Crown</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">12</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">$800</td>
                    <td class="p-3 text-left border-b border-gray-200 text-sm">
                      <span class="inline-block px-2 py-1 rounded-xl text-xs font-medium bg-blue-100 text-blue-800">Proposed</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <!-- Additional Notes -->
            <div class="mt-5 border-t border-gray-200 pt-5">
              <h3 class="text-base font-semibold mb-2.5 text-gray-800">Additional Notes</h3>
              <p class="text-sm text-gray-600 leading-relaxed">
                Patient has expressed some anxiety about the upcoming extraction. Consider
                offering sedation options.
              </p>
            </div>
            
            <!-- Digital Signature -->
            <div class="mt-5">
              <h3 class="text-base font-semibold mb-2.5 text-gray-800">Digital Signature</h3>
              <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border border-gray-200 rounded p-4 bg-gray-50">
                <span class="italic text-gray-500 text-sm">Patient Signature Required</span>
                <button class="flex items-center gap-2 px-4 py-2 text-sm rounded-md cursor-pointer transition-colors bg-indigo-600 text-white border border-indigo-600 hover:bg-indigo-700">
                  <i class="fas fa-signature"></i> Capture Signature
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DentistApp",
  data() {
    return {
      activeTab: "soap",
    };
  },
};
</script>
