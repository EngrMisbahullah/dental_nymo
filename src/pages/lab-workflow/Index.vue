<template>
  <div class="flex flex-col bg-gray-100 min-h-screen p-8 font-[Inter,sans-serif] text-gray-700">
    <header class="mb-8 flex flex-col items-start">
      <h1 class="text-2xl font-bold text-gray-900 mb-2">Orders & Referrals</h1>
      <p class="text-sm text-gray-600">Manage lab orders and specialist referrals from one central place.</p>
      <div class="mt-4">
        <button
          class="flex items-center gap-2 bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-semibold border-none cursor-pointer transition-all hover:bg-blue-700"
          v-if="activeTab === 'labOrders'"
          @click="showOrderForm = true"
        >
          <span class="material-symbols-outlined">add</span>
          <span>New Lab Order</span>
        </button>
        <button
          class="flex items-center gap-2 bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-semibold border-none cursor-pointer transition-all hover:bg-blue-700"
          v-if="activeTab === 'specialistReferrals'"
          @click="showReferralForm = true"
        >
          <span class="material-symbols-outlined">add</span>
          <span>New Referral</span>
        </button>
      </div>
    </header>

    <div class="flex gap-6 border-b border-gray-300 mb-8">
      <button
        :class="['flex items-center gap-2 bg-none border-none border-b-2 border-transparent py-3 px-1 font-semibold text-gray-500 cursor-pointer transition-all text-sm', { '!text-blue-600 !border-blue-600': activeTab === 'labOrders' }]"
        @click="activeTab = 'labOrders'"
      >
        <span class="material-symbols-outlined">science</span>
        Lab Orders
      </button>
      <button
        :class="['flex items-center gap-2 bg-none border-none border-b-2 border-transparent py-3 px-1 font-semibold text-gray-500 cursor-pointer transition-all text-sm', { '!text-blue-600 !border-blue-600': activeTab === 'specialistReferrals' }]"
        @click="activeTab = 'specialistReferrals'"
      >
        <span class="material-symbols-outlined">send</span>
        Specialist Referrals
      </button>
    </div>

    <div class="flex-1">
      <div v-if="activeTab === 'labOrders'" class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
        <div class="bg-white rounded-lg border border-gray-200 shadow-md">
          <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Lab Order Form</h2>
            <p class="text-sm text-gray-600">Create a new lab order for prosthetics and other items.</p>
          </div>
          <form class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
              <div class="flex flex-col">
                <label for="lo-patient" class="text-sm font-medium text-gray-700 mb-2">Patient</label>
                <select id="lo-patient" name="lo-patient" class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                  <option>Select a patient</option>
                  <option>John Doe</option>
                  <option>Jane Smith</option>
                </select>
              </div>
              <div class="flex flex-col">
                <label for="lo-template" class="text-sm font-medium text-gray-700 mb-2">Template</label>
                <select id="lo-template" name="lo-template" class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                  <option>Select a template</option>
                  <option>Crown & Bridge</option>
                  <option>Denture</option>
                  <option>Implant</option>
                  <option>Orthodontic Appliance</option>
                </select>
              </div>
            </div>

            <div class="flex flex-col mb-6">
              <label class="text-sm font-medium text-gray-700 mb-2">Tooth Selection & Instructions</label>
              <div class="text-center mt-2">
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2eETlBbJgMEbjUF52y8N9SG6tfVM9OOsjtVqPQeyO5h8wuV8YW4LHaKUBpDw1IE546DscMq8csBKDZiVDmNXpCvpqkzeh81FEOtjlxwS2lO2Sb9LYBhOuiOdNvZtPXTEqxzmDBRiLha9EDi5ugLMnvcTnYB457-No9RSu3JuQ3Ulty1qK0qvFg9NLQHI-mS9-VQ9FH7KOgVtWKiBqpaccm8T5ciPcuGMkyGdvbDAzIpvuahzgX1RtNmlMuGFQppQYsN5ynGLR8nFE"
                  alt="Dental Chart"
                  class="w-full max-w-md h-auto mx-auto"
                />
                <p class="text-xs text-gray-500 mt-2">Click on a tooth to add specific instructions.</p>
              </div>
            </div>

            <div class="flex flex-col mb-6">
              <label for="lo-instructions" class="text-sm font-medium text-gray-700 mb-2">General Instructions</label>
              <textarea
                id="lo-instructions"
                name="lo-instructions"
                rows="4"
                placeholder="Enter general instructions, material specifications, shade, etc."
                class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all resize-y focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10"
              ></textarea>
            </div>

            <div class="flex flex-col mb-6">
              <label class="text-sm font-medium text-gray-700 mb-2">Attachments</label>
              <div class="flex flex-col justify-center items-center border-2 border-dashed border-gray-300 rounded-md py-6 mt-2">
                <span class="material-symbols-outlined text-4xl text-gray-400">cloud_upload</span>
                <div class="flex text-sm leading-6 text-gray-600 mt-4">
                  <label for="lo-file-upload" class="relative cursor-pointer bg-white font-semibold text-blue-600 transition-all hover:text-blue-700 p-0 m-0">
                    <span>Upload files</span>
                    <input id="lo-file-upload" type="file" multiple class="sr-only" />
                  </label>
                  <p class="pl-1 m-0">or drag and drop</p>
                </div>
                <p class="text-xs leading-5 text-gray-500 mt-1">Impressions, Photos, Scans up to 10MB</p>
              </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
              <button type="button" class="flex items-center gap-2 py-2 px-3 rounded-md text-sm font-medium text-gray-600 bg-white border border-gray-300 cursor-pointer transition-all hover:bg-gray-100">
                <span class="material-symbols-outlined">picture_as_pdf</span>
                <span>Export PDF</span>
              </button>
              <button type="button" class="flex items-center gap-2 py-2 px-3 rounded-md text-sm font-medium text-gray-600 bg-white border border-gray-300 cursor-pointer transition-all hover:bg-gray-100">
                <span class="material-symbols-outlined">mail</span>
                <span>Email to Lab</span>
              </button>
              <button type="submit" class="py-3 px-4 rounded-md text-sm font-medium text-white bg-blue-600 border border-blue-600 cursor-pointer transition-all hover:bg-blue-700">Submit Order</button>
            </div>
          </form>
        </div>

        <div class="space-y-8">
          <div class="bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="p-6 border-b border-gray-200">
              <h2 class="text-lg font-semibold text-gray-800 mb-1">Order Tracking</h2>
              <p class="text-sm text-gray-600">Follow the status of the lab order.</p>
            </div>
            <div class="p-6">
              <ul class="list-none p-0 m-0 flex flex-col gap-4">
                <li class="flex gap-4 items-center">
                  <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                    <span class="material-symbols-outlined">check_circle</span>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800 m-0">Order Sent</p>
                    <p class="text-xs text-gray-500 m-0">Oct 27, 2023, 09:15 AM</p>
                  </div>
                </li>
                <li class="flex gap-4 items-center">
                  <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-500">
                    <span class="material-symbols-outlined">hourglass_top</span>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800 m-0">In-Process at Lab</p>
                    <p class="text-xs text-gray-500 m-0">Awaiting update</p>
                  </div>
                </li>
                <li class="flex gap-4 items-center">
                  <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-500">
                    <span class="material-symbols-outlined">local_shipping</span>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800 m-0">Shipped</p>
                    <p class="text-xs text-gray-500 m-0">Awaiting update</p>
                  </div>
                </li>
                <li class="flex gap-4 items-center">
                  <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-500">
                    <span class="material-symbols-outlined">inventory_2</span>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800 m-0">Received</p>
                    <p class="text-xs text-gray-500 m-0">Awaiting update</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="p-6 border-b border-gray-200">
              <h2 class="text-lg font-semibold text-gray-800 mb-1">Lab Communication</h2>
              <p class="text-sm text-gray-600">Messages and updates from the lab.</p>
            </div>
            <div class="p-6">
              <div class="flex flex-col gap-4 text-sm">
                <div class="flex gap-2.5 items-start">
                  <div class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-600 text-sm font-semibold flex-shrink-0">DL</div>
                  <div class="flex-1 bg-gray-100 rounded-md p-3">
                    <p class="font-medium text-gray-800 m-0">Dental Lab Inc.</p>
                    <p class="my-1 text-gray-600">We've received the case. The estimated completion date is Nov 5, 2023.</p>
                    <p class="text-xs text-gray-400 text-right m-0 mt-1">Oct 27, 2023, 11:45 AM</p>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <textarea placeholder="Type a message to the lab..." rows="2" class="w-full py-2 px-2 rounded-md border border-gray-300 bg-gray-50 text-sm text-gray-800 resize-y"></textarea>
                <button class="w-full mt-2 py-2 px-3 rounded-md text-sm font-medium text-white bg-gray-600 border border-gray-600 cursor-pointer transition-all hover:bg-gray-700">Send Message</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="activeTab === 'specialistReferrals'" class="referrals-container">
        <div class="flex gap-6 border-b border-gray-300 mb-8">
          <button
            :class="['bg-none border-none border-b-2 border-transparent py-3 px-1 font-semibold text-gray-500 cursor-pointer text-sm transition-all', { '!text-blue-600 !border-blue-600': activeSubTab === 'internal' }]"
            @click="activeSubTab = 'internal'"
          >
            Internal Referrals
          </button>
          <button
            :class="['bg-none border-none border-b-2 border-transparent py-3 px-1 font-semibold text-gray-500 cursor-pointer text-sm transition-all', { '!text-blue-600 !border-blue-600': activeSubTab === 'external' }]"
            @click="activeSubTab = 'external'"
          >
            External Referrals
          </button>
        </div>
        <div>
          <div v-if="activeSubTab === 'internal'" class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md">
              <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">Internal Referral Form</h2>
                <p class="text-sm text-gray-600">Create a new referral for a specialist within the practice.</p>
              </div>
              <form class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                  <div class="flex flex-col">
                    <label for="ref-patient" class="text-sm font-medium text-gray-700 mb-2">Patient</label>
                    <select id="ref-patient" name="ref-patient" class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                      <option>Select a patient</option>
                      <option>John Doe</option>
                      <option>Jane Smith</option>
                    </select>
                  </div>
                  <div class="flex flex-col">
                    <label for="ref-type" class="text-sm font-medium text-gray-700 mb-2">Referral Type</label>
                    <select id="ref-type" name="ref-type" class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                      <option>Select referral type</option>
                      <option>Hygienist</option>
                      <option>Orthodontist</option>
                      <option>Implantologist</option>
                    </select>
                  </div>
                  <div class="flex flex-col">
                    <label for="ref-doctor" class="text-sm font-medium text-gray-700 mb-2">Referring Doctor</label>
                    <select id="ref-doctor" name="ref-doctor" class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                      <option>Dr. Emily Carter</option>
                      <option>Dr. Michael Chen</option>
                    </select>
                  </div>
                  <div class="flex flex-col">
                    <label for="ref-specialist" class="text-sm font-medium text-gray-700 mb-2">Specialist</label>
                    <select id="ref-specialist" name="ref-specialist" class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                      <option>Select a specialist</option>
                      <option>Dr. Sarah Lee (Orthodontist)</option>
                      <option>Mark Johnson (Hygienist)</option>
                    </select>
                  </div>
                </div>
                <div class="flex flex-col mb-6">
                  <label for="ref-notes" class="text-sm font-medium text-gray-700 mb-2">Clinical Notes</label>
                  <textarea
                    id="ref-notes"
                    name="ref-notes"
                    rows="4"
                    placeholder="Enter clinical notes..."
                    class="py-3 px-3 text-sm rounded-md border border-gray-300 bg-gray-50 text-gray-800 transition-all resize-y focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10"
                  ></textarea>
                </div>
                <div class="flex flex-col mb-6">
                  <label class="text-sm font-medium text-gray-700 mb-2">Attachments</label>
                  <div class="flex flex-col justify-center items-center border-2 border-dashed border-gray-300 rounded-md py-6 mt-2">
                    <span class="material-symbols-outlined text-4xl text-gray-400">cloud_upload</span>
                    <div class="flex text-sm leading-6 text-gray-600 mt-4">
                      <label for="ref-file-upload" class="relative cursor-pointer bg-white font-semibold text-blue-600 transition-all hover:text-blue-700 p-0 m-0">
                        <span>Upload files</span>
                        <input id="ref-file-upload" type="file" multiple class="sr-only" />
                      </label>
                      <p class="pl-1 m-0">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-gray-500 mt-1">Photos, Scans, Clinical Notes up to 10MB</p>
                  </div>
                </div>
                <div class="flex justify-end mt-6">
                  <button type="submit" class="py-3 px-4 rounded-md text-sm font-medium text-white bg-blue-600 border border-blue-600 cursor-pointer transition-all hover:bg-blue-700">Submit Referral</button>
                </div>
              </form>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md">
              <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">Audit Trail</h2>
                <p class="text-sm text-gray-600">Track all activities related to this referral for compliance.</p>
              </div>
              <div class="p-6">
                <ul class="list-none p-0 m-0 flex flex-col gap-4">
                  <li class="flex gap-3 items-start">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-500">
                      <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div>
                      <p class="text-sm font-medium text-gray-800 m-0">Referral Created</p>
                      <p class="text-xs text-gray-500 m-0">by Dr. Emily Carter - Oct 26, 2023, 10:30 AM</p>
                    </div>
                  </li>
                  <li class="flex gap-3 items-start">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-500">
                      <span class="material-symbols-outlined">attachment</span>
                    </div>
                    <div>
                      <p class="text-sm font-medium text-gray-800 m-0">Attachment Added</p>
                      <p class="text-xs text-gray-500 m-0">by Dr. Emily Carter - Oct 26, 2023, 10:32 AM</p>
                      <a href="#" class="text-xs font-medium text-blue-600 hover:underline">xray_scan.jpg</a>
                    </div>
                  </li>
                  <li class="flex gap-3 items-start">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-500">
                      <span class="material-symbols-outlined">visibility</span>
                    </div>
                    <div>
                      <p class="text-sm font-medium text-gray-800 m-0">Referral Viewed</p>
                      <p class="text-xs text-gray-500 m-0">by Dr. Sarah Lee - Oct 26, 2023, 11:05 AM</p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div v-if="activeSubTab === 'external'" class="text-center p-8 bg-white rounded-lg border border-gray-200 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">External Referrals</h3>
            <p class="text-gray-500">This feature is coming soon.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeTab: "labOrders",
      activeSubTab: "internal",
    };
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined");

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
</style>
