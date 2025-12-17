<template>
  <div class="patient-communication-container">
    <main class="main-content">
      <header class="page-header">
        <h1 class="page-title">Patient Communication</h1>
        <div class="header-buttons">
          <button class="filter-button">
            <span class="material-icons icon">filter_list</span>
            Filter
          </button>
          <button class="new-message-button">
            <span class="material-icons icon">add</span>
            New Message
          </button>
        </div>
      </header>
      <div class="card">
        <div class="card-header">
          <div class="search-section">
            <span class="material-icons search-icon">search</span>
            <input
              class="search-input"
              placeholder="Search by name or keyword..."
              type="text"
            />
          </div>
          <div class="tab-buttons">
            <button class="tab-button">All</button>
            <button class="tab-button active">Unread</button>
            <button class="tab-button">Sent</button>
            <button class="tab-button">Archived</button>
          </div>
        </div>
        <table class="messages-table">
          <thead>
            <tr>
              <th class="checkbox-cell">
                <input class="checkbox" type="checkbox" />
              </th>
              <th class="patient-header">Patient</th>
              <th class="subject-header">Subject</th>
              <th class="date-header">Date</th>
              <th class="status-header">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(message, index) in messages"
              :key="index"
              :class="{ 'selected-row': message.checked, 'hover-effect': true }"
            >
              <td class="p-4">
                <input class="checkbox" type="checkbox" v-model="message.checked" />
              </td>
              <td class="p-4 patient-info">
                <img
                  :alt="message.patientName"
                  class="profile-pic"
                  :src="message.profilePic"
                />
                <div>
                  <p class="patient-name">{{ message.patientName }}</p>
                  <p class="patient-phone">{{ message.phoneNumber }}</p>
                </div>
              </td>
              <td class="p-4 message-details">
                <p class="message-subject">{{ message.subject }}</p>
                <p class="message-preview">{{ message.preview }}</p>
              </td>
              <td class="p-4 message-date">{{ message.date }}</td>
              <td class="p-4">
                <span :class="getStatusClass(message.status)">
                  {{ message.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer">
          <p class="results-info">Showing 1-6 of 24 results</p>
          <div class="pagination">
            <button class="pagination-arrow-button" disabled>
              <span class="material-icons">chevron_left</span>
            </button>
            <button class="pagination-page-button current-page">1</button>
            <button class="pagination-page-button">2</button>
            <button class="pagination-page-button">3</button>
            <button class="pagination-page-button">...</button>
            <button class="pagination-page-button">8</button>
            <button class="pagination-arrow-button">
              <span class="material-icons">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
<script>
export default {
  name: "PatientCommunication",
  data() {
    return {
      messages: [
        {
          checked: true,
          patientName: "Rob Perkowski",
          phoneNumber: "+44 7...1234",
          profilePic:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuA91Xs_MohfDYoX7_Wy-xl1QS_Ii3Yb_ZUXWliAU_0BD5UKkGKJeO4HybmZGo4qFEz9E5BLxKGn-8A-FElQ3jQ_LD-GMxbLz2xx6g_G0nQ8PCJSkwT4UmEiNZOMBIssMw4lanjtIA__iOZRq_mLpUkrWhHUMxjXa0e_SO2IfP9nk06OCGx4stMsrbMLo5u3cwj9kPy5hVyexu4A9PPaREXwQBjnZaxpq3CdzwCUJlaAIm6XwOdnMGkRZ8qlDy9jOT_VWMmJydytGkQ",
          subject: "Appointment Reminder",
          preview: "Hi Rob, this is a reminder for your ap...",
          date: "27 Aug 2020, 09:00",
          status: "Delivered",
        },
        {
          checked: false,
          patientName: "Sam Clarke",
          phoneNumber: "+44 7...5678",
          profilePic:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuBBt9DuKSGBq2p6Yh4XfVVEb43Xt8Zv-f6fdjyCzcbhf_NDF9SbcA15_vVoilMpTwtStzTZH4jLIz040uuBsTRSFqz-KuRx54Wpqt-Mtn8zSnd54mPL8nnfz9Z4OktEGSc1O_mad6IGlwO5FzukZw4lYRSQ-M2mQ5r7ydQFZF14imDY5JR555awBpIFkvNOtfUKhl84pR9oIXIsCIf5NsujDcFylpjiDgN8bJ6wWe4h16tHB-CKJ5cLe7FWi_YcNJQh9nrHMLfm31c",
          subject: "Follow-up on your recent visit",
          preview: "Hi Sam, we hope you're recovering w...",
          date: "26 Aug 2020, 14:30",
          status: "Read",
        },
        {
          checked: true,
          patientName: "Helena Nichols",
          phoneNumber: "+44 7...9012",
          profilePic:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuCz4ZiMU6kz2E-q6BNg892W77EGPpCMw8bf1az7XM-yOhxIRLAtJR7_nJf4XWq9mYewLqCpxJnUnEpm0BLopmOeqsVwnaY5g4K_mGIUqJOkXlEfLX8fbXa8otUGHLQrcbQYOdxBgYWF_zRgJOwIALTP5nKJ3oZyKn_EoBa0n4VhTe1TRi8wfqcsRn1jujzBfUA1WJvyyYjh8hxfnCahbr1VVhdIhYytuhdMAZIt9VWolvSUsDqbyb7D2d96xd-MlRYAybtrDDK7ZeY",
          subject: "Important: Pre-appointment instructions",
          preview: "Dear Helena, please read the followin...",
          date: "25 Aug 2020, 11:00",
          status: "Delivered",
        },
        {
          checked: false,
          patientName: "David Rutherford",
          phoneNumber: "+44 7...3456",
          profilePic:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuDnClovhSIA8c9etiCJMeQKf2VMNdf7WwCZ1B4JMhWTBVqUtIMeUq19pnnK3IqbLz_XTacELeLbJzhKvzrBZ7sKJwqjVeu59lgQUEtYJb2s8nyrn2jl9kms-nLB5YOvclAXrj88wrQmJ-KNRK_B93jyX11ZQAGaG5QcqN1IsdSnf5ReeuKTc6KePNnzdAbugO2lDC4hre-oH6Hg9UyTY9vAbSmsVZz-Jt1U5MfnCc-b1sDeREZlZ7e0sQ5mTjzj7owPChXF74BJ_QY",
          subject: "Re: Your query about billing",
          preview: "Hi David, regarding your billing query, we've...",
          date: "24 Aug 2020, 17:15",
          status: "Failed",
        },
        {
          checked: false,
          patientName: "James Harker",
          phoneNumber: "+44 7...7890",
          profilePic:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuAfWRSC2VID1U_FHFvZum0puDvPwOTPOhGqdaOnES-_POfw4n41sEjvwBMwl4UIe2Z0r076KyFK7LOtxqmFi_Ib6yC1v1HuNVvQLCJOtUOdQ0RtmypdU0_sAN6kur4vUXqsEvH6BbCDkEyx_-BpY7utRCqibQwEs0hxncUYnHnuSLLNUfpkJ6dpCA7wiTpR4SZJ6GaAuMbvaYbPKyPdHTE-Kf1ENV9-sHFmke6yV2-t_Tja2l3UUt8ZlFHbNmFgXCA9lpG70BWY2AE",
          subject: "Your feedback is important to us",
          preview: "Hi James, we'd love to hear about your experience...",
          date: "23 Aug 2020, 10:00",
          status: "Read",
        },
        {
          checked: false,
          patientName: "Rayne Carlsson",
          phoneNumber: "+44 7...2345",
          profilePic:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuA1XALWWVlNLZW4SyFMd1EpqyKEVjVA3oQFWYKfPQt6lggqnqBrCh9W5UGfkXMzHItwtBLLOGOxD5EIanpsY4UvzLjICTEWNRkCgcBAhGmuvoAwZ33A2Ucrp8AnZZrBclikjGGrtxHI6pRrYRFH-cpuP4WPuiO9IlnccG93bzJ_6TXOx05_wvsTm81oDhnR5-mm3SzEIEI0q2SeFVtq-alZ5YzY6MyVU2w4btPFCRFldys2USirOApULRDVPv4V8bPCDxUPPbR54ak",
          subject: "Rescheduled Appointment",
          preview: "Hi Rayne, your appointment has been successfully...",
          date: "22 Aug 2020, 13:30",
          status: "Read",
        },
      ],
    };
  },
  methods: {
    getStatusClass(status) {
      switch (status) {
        case "Delivered":
          return "status-badge status-delivered";
        case "Read":
          return "status-badge status-read";
        case "Failed":
          return "status-badge status-failed";
        default:
          return "status-badge";
      }
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

.patient-communication-container {
  font-family: "Inter", sans-serif;
  background-color: #f9fafb;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 2rem;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.page-title {
  font-size: 1.875rem;
  font-weight: 700;
  color: #1f2937;
}

.header-buttons {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.filter-button {
  display: flex;
  align-items: center;
  background-color: #ffffff;
  border: 1px solid #d1d5db;
  color: #4b5563;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  transition: background-color 0.2s;
  cursor: pointer;
}

.filter-button:hover {
  background-color: #f9fafb;
}

.new-message-button {
  display: flex;
  align-items: center;
  background-color: #2563eb;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  transition: background-color 0.2s;
  cursor: pointer;
}

.new-message-button:hover {
  background-color: #1d4ed8;
}

.icon {
  margin-right: 0.5rem;
  font-size: 1.25rem;
}

.card {
  background-color: #ffffff;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  overflow: hidden;
}

.card-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.search-section {
  position: relative;
  width: 33.333333%;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.search-input {
  width: 100%;
  padding: 0.5rem 1rem 0.5rem 2.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  outline: none;
  font-size: 0.875rem;
}

.search-input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.tab-buttons {
  display: flex;
  gap: 0.5rem;
}

.tab-button {
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  border-radius: 0.5rem;
  cursor: pointer;
  border: none;
  background-color: #f3f4f6;
  color: #4b5563;
  transition: background-color 0.2s;
}

.tab-button:hover:not(.active) {
  background-color: #e5e7eb;
}

.tab-button.active {
  background-color: #dbeafe;
  color: #2563eb;
}

.messages-table {
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}

.messages-table thead {
  background-color: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
}

.messages-table th {
  padding: 1rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: #4b5563;
}

.checkbox-cell {
  width: 3rem;
}

.checkbox {
  height: 1rem;
  width: 1rem;
  color: #2563eb;
  border-color: #d1d5db;
  border-radius: 0.25rem;
  cursor: pointer;
}

.messages-table tbody tr {
  border-bottom: 1px solid #e5e7eb;
}

.messages-table tbody tr:last-child {
  border-bottom: none;
}

.messages-table tbody .hover-effect:hover {
  background-color: #f9fafb;
  cursor: pointer;
}

.messages-table tbody .selected-row {
  background-color: #eff6ff;
}

.patient-info {
  display: flex;
  align-items: center;
}

.profile-pic {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 9999px;
  margin-right: 1rem;
}

.patient-name {
  font-weight: 600;
  color: #1f2937;
}

.patient-phone {
  font-size: 0.875rem;
  color: #6b7280;
}

.message-details {
  max-width: 16rem;
}

.message-subject {
  font-weight: 600;
  color: #1f2937;
}

.message-preview {
  font-size: 0.875rem;
  color: #6b7280;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.message-date {
  color: #4b5563;
  white-space: nowrap;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: 9999px;
}

.status-delivered {
  background-color: #d1fae5;
  color: #065f46;
}

.status-read {
  background-color: #dbeafe;
  color: #1e40af;
}

.status-failed {
  background-color: #fee2e2;
  color: #991b1b;
}

.card-footer {
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.results-info {
  font-size: 0.875rem;
  color: #4b5563;
}

.pagination {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.pagination-arrow-button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  border: none;
  background-color: #ffffff;
  transition: background-color 0.2s;
  cursor: pointer;
}

.pagination-arrow-button:hover:not(:disabled) {
  background-color: #f3f4f6;
}

.pagination-arrow-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination-arrow-button .material-icons {
  color: #4b5563;
  font-size: 1.5rem;
}

.pagination-page-button {
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  border-radius: 0.5rem;
  border: none;
  background-color: #ffffff;
  color: #4b5563;
  cursor: pointer;
  transition: background-color 0.2s;
}

.pagination-page-button:hover:not(.current-page) {
  background-color: #f3f4f6;
}

.pagination-page-button.current-page {
  background-color: #2563eb;
  color: #ffffff;
}
</style>
