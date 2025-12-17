<template>
  <div class="main-container">
    <header>
      <h1>Orders & Referrals</h1>
      <p>Manage lab orders and specialist referrals from one central place.</p>
      <div class="header-actions">
        <button
          class="add-button"
          v-if="activeTab === 'labOrders'"
          @click="showOrderForm = true"
        >
          <span class="material-symbols-outlined">add</span>
          <span>New Lab Order</span>
        </button>
        <button
          class="add-button"
          v-if="activeTab === 'specialistReferrals'"
          @click="showReferralForm = true"
        >
          <span class="material-symbols-outlined">add</span>
          <span>New Referral</span>
        </button>
      </div>
    </header>

    <div class="tabs-navigation">
      <button
        :class="{ 'active-tab': activeTab === 'labOrders' }"
        @click="activeTab = 'labOrders'"
      >
        <span class="material-symbols-outlined">science</span>
        Lab Orders
      </button>
      <button
        :class="{ 'active-tab': activeTab === 'specialistReferrals' }"
        @click="activeTab = 'specialistReferrals'"
      >
        <span class="material-symbols-outlined">send</span>
        Specialist Referrals
      </button>
    </div>

    <div class="content-area">
      <div v-if="activeTab === 'labOrders'" class="grid-container">
        <div class="main-form">
          <div class="card">
            <div class="card-header">
              <h2>Lab Order Form</h2>
              <p>Create a new lab order for prosthetics and other items.</p>
            </div>
            <form class="form-body">
              <div class="form-group-columns">
                <div class="form-group">
                  <label for="lo-patient">Patient</label>
                  <select id="lo-patient" name="lo-patient">
                    <option>Select a patient</option>
                    <option>John Doe</option>
                    <option>Jane Smith</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="lo-template">Template</label>
                  <select id="lo-template" name="lo-template">
                    <option>Select a template</option>
                    <option>Crown & Bridge</option>
                    <option>Denture</option>
                    <option>Implant</option>
                    <option>Orthodontic Appliance</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label>Tooth Selection & Instructions</label>
                <div class="dental-chart-container">
                  <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2eETlBbJgMEbjUF52y8N9SG6tfVM9OOsjtVqPQeyO5h8wuV8YW4LHaKUBpDw1IE546DscMq8csBKDZiVDmNXpCvpqkzeh81FEOtjlxwS2lO2Sb9LYBhOuiOdNvZtPXTEqxzmDBRiLha9EDi5ugLMnvcTnYB457-No9RSu3JuQ3Ulty1qK0qvFg9NLQHI-mS9-VQ9FH7KOgVtWKiBqpaccm8T5ciPcuGMkyGdvbDAzIpvuahzgX1RtNmlMuGFQppQYsN5ynGLR8nFE"
                    alt="Dental Chart"
                  />
                  <p>Click on a tooth to add specific instructions.</p>
                </div>
              </div>

              <div class="form-group">
                <label for="lo-instructions">General Instructions</label>
                <textarea
                  id="lo-instructions"
                  name="lo-instructions"
                  rows="4"
                  placeholder="Enter general instructions, material specifications, shade, etc."
                ></textarea>
              </div>

              <div class="form-group">
                <label>Attachments</label>
                <div class="file-upload-container">
                  <span class="material-symbols-outlined">cloud_upload</span>
                  <div class="file-upload-text">
                    <label for="lo-file-upload">
                      <span>Upload files</span>
                      <input id="lo-file-upload" type="file" multiple class="sr-only" />
                    </label>
                    <p>or drag and drop</p>
                  </div>
                  <p class="file-upload-note">Impressions, Photos, Scans up to 10MB</p>
                </div>
              </div>

              <div class="form-actions">
                <button type="button" class="action-button">
                  <span class="material-symbols-outlined">picture_as_pdf</span>
                  <span>Export PDF</span>
                </button>
                <button type="button" class="action-button">
                  <span class="material-symbols-outlined">mail</span>
                  <span>Email to Lab</span>
                </button>
                <button type="submit" class="submit-button">Submit Order</button>
              </div>
            </form>
          </div>
        </div>

        <div class="audit-trail-history">
          <div class="card">
            <div class="card-header">
              <h2>Order Tracking</h2>
              <p>Follow the status of the lab order.</p>
            </div>
            <div class="card-body">
              <ul class="tracking-list">
                <li class="tracking-item">
                  <div class="icon-wrapper complete">
                    <span class="material-symbols-outlined">check_circle</span>
                  </div>
                  <div class="tracking-details">
                    <p class="tracking-event">Order Sent</p>
                    <p class="tracking-timestamp">Oct 27, 2023, 09:15 AM</p>
                  </div>
                </li>
                <li class="tracking-item">
                  <div class="icon-wrapper pending">
                    <span class="material-symbols-outlined">hourglass_top</span>
                  </div>
                  <div class="tracking-details">
                    <p class="tracking-event">In-Process at Lab</p>
                    <p class="tracking-timestamp">Awaiting update</p>
                  </div>
                </li>
                <li class="tracking-item">
                  <div class="icon-wrapper pending">
                    <span class="material-symbols-outlined">local_shipping</span>
                  </div>
                  <div class="tracking-details">
                    <p class="tracking-event">Shipped</p>
                    <p class="tracking-timestamp">Awaiting update</p>
                  </div>
                </li>
                <li class="tracking-item">
                  <div class="icon-wrapper pending">
                    <span class="material-symbols-outlined">inventory_2</span>
                  </div>
                  <div class="tracking-details">
                    <p class="tracking-event">Received</p>
                    <p class="tracking-timestamp">Awaiting update</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="card mt-8">
            <div class="card-header">
              <h2>Lab Communication</h2>
              <p>Messages and updates from the lab.</p>
            </div>
            <div class="card-body">
              <div class="communication-log">
                <div class="message-item">
                  <div class="avatar">DL</div>
                  <div class="message-bubble">
                    <p class="message-sender">Dental Lab Inc.</p>
                    <p class="message-text">
                      We've received the case. The estimated completion date is Nov 5,
                      2023.
                    </p>
                    <p class="message-timestamp">Oct 27, 2023, 11:45 AM</p>
                  </div>
                </div>
              </div>
              <div class="message-input-area">
                <textarea placeholder="Type a message to the lab..." rows="2"></textarea>
                <button class="send-message-button">Send Message</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="activeTab === 'specialistReferrals'" class="referrals-container">
        <div class="sub-tabs-navigation">
          <button
            :class="{ 'active-sub-tab': activeSubTab === 'internal' }"
            @click="activeSubTab = 'internal'"
          >
            Internal Referrals
          </button>
          <button
            :class="{ 'active-sub-tab': activeSubTab === 'external' }"
            @click="activeSubTab = 'external'"
          >
            External Referrals
          </button>
        </div>
        <div class="sub-tab-content">
          <div v-if="activeSubTab === 'internal'" class="grid-container">
            <div class="main-form">
              <div class="card">
                <div class="card-header">
                  <h2>Internal Referral Form</h2>
                  <p>Create a new referral for a specialist within the practice.</p>
                </div>
                <form class="form-body">
                  <div class="form-group-columns">
                    <div class="form-group">
                      <label for="ref-patient">Patient</label>
                      <select id="ref-patient" name="ref-patient">
                        <option>Select a patient</option>
                        <option>John Doe</option>
                        <option>Jane Smith</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="ref-type">Referral Type</label>
                      <select id="ref-type" name="ref-type">
                        <option>Select referral type</option>
                        <option>Hygienist</option>
                        <option>Orthodontist</option>
                        <option>Implantologist</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="ref-doctor">Referring Doctor</label>
                      <select id="ref-doctor" name="ref-doctor">
                        <option>Dr. Emily Carter</option>
                        <option>Dr. Michael Chen</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="ref-specialist">Specialist</label>
                      <select id="ref-specialist" name="ref-specialist">
                        <option>Select a specialist</option>
                        <option>Dr. Sarah Lee (Orthodontist)</option>
                        <option>Mark Johnson (Hygienist)</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ref-notes">Clinical Notes</label>
                    <textarea
                      id="ref-notes"
                      name="ref-notes"
                      rows="4"
                      placeholder="Enter clinical notes..."
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label>Attachments</label>
                    <div class="file-upload-container">
                      <span class="material-symbols-outlined">cloud_upload</span>
                      <div class="file-upload-text">
                        <label for="ref-file-upload">
                          <span>Upload files</span>
                          <input
                            id="ref-file-upload"
                            type="file"
                            multiple
                            class="sr-only"
                          />
                        </label>
                        <p>or drag and drop</p>
                      </div>
                      <p class="file-upload-note">
                        Photos, Scans, Clinical Notes up to 10MB
                      </p>
                    </div>
                  </div>
                  <div class="form-actions-right">
                    <button type="submit" class="submit-button">Submit Referral</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="audit-trail-history">
              <div class="card">
                <div class="card-header">
                  <h2>Audit Trail</h2>
                  <p>Track all activities related to this referral for compliance.</p>
                </div>
                <div class="card-body">
                  <ul class="audit-trail-list">
                    <li class="audit-item">
                      <div class="icon-wrapper">
                        <span class="material-symbols-outlined">receipt_long</span>
                      </div>
                      <div class="audit-details">
                        <p class="audit-event">Referral Created</p>
                        <p class="audit-timestamp">
                          by Dr. Emily Carter - Oct 26, 2023, 10:30 AM
                        </p>
                      </div>
                    </li>
                    <li class="audit-item">
                      <div class="icon-wrapper">
                        <span class="material-symbols-outlined">attachment</span>
                      </div>
                      <div class="audit-details">
                        <p class="audit-event">Attachment Added</p>
                        <p class="audit-timestamp">
                          by Dr. Emily Carter - Oct 26, 2023, 10:32 AM
                        </p>
                        <a href="#">xray_scan.jpg</a>
                      </div>
                    </li>
                    <li class="audit-item">
                      <div class="icon-wrapper">
                        <span class="material-symbols-outlined">visibility</span>
                      </div>
                      <div class="audit-details">
                        <p class="audit-event">Referral Viewed</p>
                        <p class="audit-timestamp">
                          by Dr. Sarah Lee - Oct 26, 2023, 11:05 AM
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div v-if="activeSubTab === 'external'" class="list-card empty-state">
            <h3>External Referrals</h3>
            <p>This feature is coming soon.</p>
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

.main-container {
  display: flex;
  flex-direction: column;
  background-color: #f3f4f6;
  min-height: 100vh;
  padding: 2rem;
  font-family: "Inter", sans-serif;
  color: #374151;
}

header {
  margin-bottom: 2rem;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.header-actions {
  margin-top: 1rem;
}

.add-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #2563eb;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
}

.add-button:hover {
  background-color: #1d4ed8;
}

h1 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  margin-bottom: 0.5rem;
}

p {
  font-size: 0.875rem;
  color: #4b5563;
}

.tabs-navigation {
  display: flex;
  gap: 1.5rem;
  border-bottom: 1px solid #d1d5db;
  margin-bottom: 2rem;
}

.tabs-navigation button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: none;
  border: none;
  border-bottom: 2px solid transparent;
  padding: 0.75rem 0.25rem;
  font-weight: 600;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 0.875rem;
}

.tabs-navigation .active-tab {
  color: #2563eb;
  border-color: #2563eb;
}

.tabs-navigation .active-tab:hover {
  color: #2563eb;
}

.content-area {
  flex: 1;
}

.grid-container {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 2rem;
}

.card {
  background-color: #ffffff;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.card-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.card-header h2 {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.form-body {
  padding: 1.5rem;
}

.form-group-columns {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.form-group input,
.form-group select,
.form-group textarea {
  padding: 0.75rem;
  font-size: 0.875rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  background-color: #f9fafb;
  color: #1f2937;
  transition: all 0.2s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.dental-chart-container {
  text-align: center;
  margin-top: 0.5rem;
}

.dental-chart-container img {
  width: 100%;
  max-width: 28rem;
  height: auto;
  margin: 0 auto;
}

.dental-chart-container p {
  font-size: 0.75rem;
  color: #6b7280;
  margin-top: 0.5rem;
}

.file-upload-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 2px dashed #d1d5db;
  border-radius: 0.375rem;
  padding: 1.5rem 0;
  margin-top: 0.5rem;
}

.file-upload-container .material-symbols-outlined {
  font-size: 2.5rem;
  color: #9ca3af;
}

.file-upload-text {
  display: flex;
  font-size: 0.875rem;
  line-height: 1.5rem;
  color: #4b5563;
  margin-top: 1rem;
}

.file-upload-text label {
  position: relative;
  cursor: pointer;
  background-color: #ffffff;
  font-weight: 600;
  color: #2563eb;
  transition: all 0.2s;
  padding: 0;
  margin: 0;
}

.file-upload-text label:hover {
  color: #1d4ed8;
}

.file-upload-text p {
  padding-left: 0.25rem;
  margin: 0;
}

.file-upload-note {
  font-size: 0.75rem;
  line-height: 1.25rem;
  color: #6b7280;
  margin-top: 0.25rem;
}

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

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  margin-top: 1.5rem;
}

.form-actions-right {
  display: flex;
  justify-content: flex-end;
  margin-top: 1.5rem;
}

.action-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
  background-color: #ffffff;
  border: 1px solid #d1d5db;
  cursor: pointer;
  transition: all 0.2s;
}

.action-button:hover {
  background-color: #f3f4f6;
}

.submit-button {
  padding: 0.75rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #ffffff;
  background-color: #2563eb;
  border: 1px solid #2563eb;
  cursor: pointer;
  transition: all 0.2s;
}

.submit-button:hover {
  background-color: #1d4ed8;
  border-color: #1d4ed8;
}

.card-body {
  padding: 1.5rem;
}

.tracking-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.tracking-item {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.icon-wrapper {
  display: flex;
  height: 2rem;
  width: 2rem;
  flex-shrink: 0;
  align-items: center;
  justify-content: center;
  border-radius: 9999px;
  background-color: #e5e7eb;
  color: #6b7280;
}

.icon-wrapper.complete {
  background-color: #dbeafe;
  color: #2563eb;
}

.tracking-details .tracking-event {
  font-size: 0.875rem;
  font-weight: 500;
  color: #1f2937;
  margin: 0;
}

.tracking-details .tracking-timestamp {
  font-size: 0.75rem;
  color: #6b7280;
  margin: 0;
}

.communication-log {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  font-size: 0.875rem;
}

.message-item {
  display: flex;
  gap: 0.625rem;
  align-items: flex-start;
}

.avatar {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 2rem;
  width: 2rem;
  border-radius: 9999px;
  background-color: #e5e7eb;
  color: #4b5563;
  font-size: 0.875rem;
  font-weight: 600;
  flex-shrink: 0;
}

.message-bubble {
  flex: 1;
  background-color: #f3f4f6;
  border-radius: 0.375rem;
  padding: 0.75rem;
}

.message-sender {
  font-weight: 500;
  color: #1f2937;
  margin: 0;
}

.message-text {
  margin: 0.25rem 0;
  color: #4b5563;
}

.message-timestamp {
  font-size: 0.75rem;
  color: #9ca3af;
  text-align: right;
  margin: 0.25rem 0 0;
}

.message-input-area {
  margin-top: 1rem;
}

.message-input-area textarea {
  width: 100%;
  padding: 0.5rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  background-color: #f9fafb;
  font-size: 0.875rem;
  color: #1f2937;
  resize: vertical;
}

.message-input-area button {
  width: 100%;
  margin-top: 0.5rem;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #ffffff;
  background-color: #4b5563;
  border: 1px solid #4b5563;
  cursor: pointer;
  transition: all 0.2s;
}

.message-input-area button:hover {
  background-color: #374151;
  border-color: #374151;
}

.sub-tabs-navigation {
  display: flex;
  gap: 1.5rem;
  border-bottom: 1px solid #d1d5db;
  margin-bottom: 2rem;
}

.sub-tabs-navigation button {
  background: none;
  border: none;
  border-bottom: 2px solid transparent;
  padding: 0.75rem 0.25rem;
  font-weight: 600;
  color: #6b7280;
  cursor: pointer;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.sub-tabs-navigation .active-sub-tab {
  color: #2563eb;
  border-color: #2563eb;
}

.sub-tabs-navigation button:hover {
  color: #1f2937;
}

.audit-trail-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.audit-item {
  display: flex;
  gap: 0.75rem;
  align-items: flex-start;
}

.audit-item .icon-wrapper {
  background-color: #e5e7eb;
  color: #6b7280;
}

.audit-details .audit-event {
  font-size: 0.875rem;
  font-weight: 500;
  color: #1f2937;
  margin: 0;
}

.audit-details .audit-timestamp {
  font-size: 0.75rem;
  color: #6b7280;
  margin: 0;
}

.audit-details a {
  font-size: 0.75rem;
  font-weight: 500;
  color: #2563eb;
  text-decoration: none;
  transition: all 0.2s;
}

.audit-details a:hover {
  text-decoration: underline;
}

.empty-state {
  text-align: center;
  padding: 2rem;
  background-color: #ffffff;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.empty-state h3 {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #6b7280;
}
</style>
