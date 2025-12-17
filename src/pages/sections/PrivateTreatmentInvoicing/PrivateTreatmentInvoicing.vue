<template>
  <div class="private-treatment-app">
    <div class="page-container">
      <header class="page-header">
        <div>
          <h1 class="patient-name">John Doe</h1>
          <p class="patient-id">Patient ID: 12345</p>
        </div>
        <div class="header-actions">
          <button class="action-button secondary">
            <span class="material-icons icon-left">history</span>
            Review History
          </button>
          <button class="action-button primary">
            <span class="material-icons icon-left">add</span>
            New Entry
          </button>
        </div>
      </header>

      <main class="content-card">
        <div class="nav-tabs">
          <button
            :class="{ active: activeTab === 'service-catalogue' }"
            @click="activeTab = 'service-catalogue'"
            class="nav-tab"
          >
            Service Catalogue
          </button>
          <button
            :class="{ active: activeTab === 'invoicing' }"
            @click="activeTab = 'invoicing'"
            class="nav-tab"
          >
            Invoicing
          </button>
          <button
            :class="{ active: activeTab === 'payment-tracking' }"
            @click="activeTab = 'payment-tracking'"
            class="nav-tab"
          >
            Payment Tracking
          </button>
          <button
            :class="{ active: activeTab === 'insurance-claims' }"
            @click="activeTab = 'insurance-claims'"
            class="nav-tab"
          >
            Insurance Claims
          </button>
          <button
            :class="{ active: activeTab === 'payment-integration' }"
            @click="activeTab = 'payment-integration'"
            class="nav-tab full-width-sm"
          >
            Payment Integration
          </button>
        </div>

        <div class="tab-content">
          <div v-if="activeTab === 'service-catalogue'">
            <div class="section-header">
              <h2 class="section-title">Service Catalogue</h2>
              <button class="add-button">
                <span class="material-icons icon-left">add</span>
                Add Service
              </button>
            </div>
            <div class="form-grid">
              <div>
                <label class="form-label">Service Name</label>
                <input
                  class="form-input"
                  placeholder="e.g., Teeth Whitening"
                  type="text"
                />
              </div>
              <div>
                <label class="form-label">Category</label>
                <select class="form-input">
                  <option>Select category</option>
                  <option>Cosmetic</option>
                </select>
              </div>
              <div>
                <label class="form-label">Price Band</label>
                <select class="form-input">
                  <option>Select band</option>
                  <option>Band A</option>
                </select>
              </div>
              <div>
                <label class="form-label">Assigned Clinician</label>
                <select class="form-input">
                  <option>Select clinician</option>
                  <option>Dr. Smith</option>
                </select>
              </div>
            </div>
            <div class="table-container">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Service Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Clinician</th>
                    <th>Price Band</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Teeth Whitening</td>
                    <td><span class="tag purple">Cosmetic</span></td>
                    <td class="price">£350.00</td>
                    <td>Dr. Smith</td>
                    <td><span class="tag blue">Band B</span></td>
                    <td>
                      <div class="action-buttons">
                        <button class="icon-button">
                          <span class="material-icons">edit</span>
                        </button>
                        <button class="icon-button">
                          <span class="material-icons">delete</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Check-up</td>
                    <td><span class="tag green">Preventive</span></td>
                    <td class="price">£150.00</td>
                    <td>Dr. Jones</td>
                    <td><span class="tag orange">Band A</span></td>
                    <td>
                      <div class="action-buttons">
                        <button class="icon-button">
                          <span class="material-icons">edit</span>
                        </button>
                        <button class="icon-button">
                          <span class="material-icons">delete</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div v-if="activeTab === 'invoicing'" class="section-content">
            <h2 class="section-title">Treatment-Based Invoicing</h2>
            <p>Dummy content for the Invoicing section.</p>
            <div class="button-group-row">
              <div class="button-group-left">
                <button class="button-group-item">At Treatment</button>
                <button class="button-group-item active">On Completion</button>
              </div>
              <div class="button-group-right">
                <button class="action-button secondary">
                  <span class="material-icons icon-left">print</span>Print Batch Invoices
                </button>
                <button class="action-button secondary">
                  <span class="material-icons icon-left">email</span>Email Receipts
                </button>
                <button class="action-button green">
                  <span class="material-icons icon-left">receipt_long</span>Generate
                  Invoice
                </button>
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'payment-tracking'" class="section-content">
            <h2 class="section-title">Payment Tracking</h2>
            <p>Dummy content for the Payment Tracking section.</p>
            <div class="form-grid">
              <div>
                <label class="form-label">Payment Status</label>
                <select class="form-input">
                  <option>Unpaid</option>
                </select>
              </div>
              <div>
                <label class="form-label">Amount Paid (£)</label>
                <input class="form-input" placeholder="e.g., 100.00" type="text" />
              </div>
              <div>
                <label class="form-label">Insurance Claim Status</label>
                <select class="form-input">
                  <option>Not Submitted</option>
                </select>
              </div>
              <div class="self-end-lg">
                <button class="add-button">
                  <span class="material-icons icon-left">track_changes</span>Update Status
                </button>
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'insurance-claims'" class="section-content">
            <div class="section-header">
              <h2 class="section-title">Insurance Claims</h2>
              <button class="action-button primary">
                <span class="material-icons icon-left">cloud_upload</span>Submit New Claim
              </button>
            </div>
            <div class="form-grid">
              <div>
                <label class="form-label">Claim Reference No.</label>
                <input class="form-input" placeholder="e.g., C-123456" type="text" />
              </div>
              <div>
                <label class="form-label">Insurance Provider</label>
                <select class="form-input">
                  <option>Select provider</option>
                  <option>Provider A</option>
                  <option>Provider B</option>
                </select>
              </div>
              <div>
                <label class="form-label">Claim Status</label>
                <select class="form-input">
                  <option>Submitted</option>
                  <option>In Review</option>
                  <option>Approved</option>
                  <option>Rejected</option>
                </select>
              </div>
              <div>
                <label class="form-label">Date Submitted</label>
                <input class="form-input" type="date" />
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'payment-integration'" class="section-content">
            <h2 class="section-title">Payment Integration</h2>
            <div class="payment-buttons">
              <button class="action-button secondary">
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZmuivvWbfE5N8ZOnXK68-JeUr-HWHsFcZ2krApxqK7FcD8_GgoCyRyn2riaKbEOGgiRMZti3TudgfCzktGuarSsotV3ycr7VGVdLl8rz4gFUx6p9oF14NIu-bbX2hX0GPoakMf7YWYpE7m8CadSBcrvkvv_rbk2KWBS1Lw9zbn-KtxpLwukP6CgEaJtH3SfSJ1CidKUN8WqYs1gFZkD3zEzAvNqU95NfIYd3FtCB3AR4b64RFkKwl0KxctVDItCf-ncMTa3mLFVY"
                  alt="Stripe"
                  class="payment-icon"
                />Pay with Stripe
              </button>
              <button class="action-button secondary">
                <span class="material-icons icon-left">credit_card</span>Card Terminal
              </button>
              <button class="action-button secondary">
                <span class="material-icons icon-left">account_balance</span>Bank Transfer
              </button>
            </div>
            <p class="integration-info">
              Dummy text about payment methods. This section allows the patient to pay via
              various integrated services.
            </p>
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

/* General Styles */
.private-treatment-app {
  font-family: "Inter", sans-serif;
  background-color: #f9fafb;
}

.page-container {
  padding: 1rem;
  margin: 0;
  width: 100%;
}

@media (min-width: 640px) {
  .page-container {
    padding: 2rem;
  }
}

/* Header */
.page-header {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 2rem;
  gap: 1rem;
}

@media (min-width: 640px) {
  .page-header {
    flex-direction: row;
    align-items: center;
  }
}

.patient-name {
  font-size: 1.875rem;
  font-weight: 700;
  color: #111827;
}

.patient-id {
  font-size: 0.875rem;
  color: #6b7280;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

@media (min-width: 640px) {
  .header-actions {
    gap: 1rem;
  }
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  border-width: 1px;
  border-style: solid;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  transition: background-color 0.15s ease-in-out;
}

.action-button.secondary {
  border-color: #d1d5db;
  color: #4b5563;
  background-color: #fff;
}

.action-button.secondary:hover {
  background-color: #f3f4f6;
}

.action-button.primary {
  background-color: #2563eb;
  color: #fff;
  border: none;
}

.action-button.primary:hover {
  background-color: #1d4ed8;
}

.action-button.green {
  background-color: #10b981;
  color: #fff;
  border: none;
}

.action-button.green:hover {
  background-color: #059669;
}

.icon-left {
  font-size: 1rem;
  margin-right: 0.5rem;
}

/* Main Content */
.content-card {
  background-color: #fff;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.nav-tabs {
  display: flex;
  flex-wrap: wrap;
  border-bottom: 1px solid #e5e7eb;
}

.nav-tab {
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  width: 50%;
  text-align: center;
  border: none;
  background: none;
  cursor: pointer;
  color: #6b7280;
  border-bottom: 2px solid transparent;
  transition: color 0.15s, border-color 0.15s;
}

.nav-tab:hover {
  color: #4b5563;
}

.nav-tab.active {
  color: #111418;
  border-bottom: 2px solid #111418;
}

@media (min-width: 640px) {
  .nav-tab {
    width: auto;
  }
}

.full-width-sm {
  width: 100%;
}

@media (min-width: 640px) {
  .full-width-sm {
    width: auto;
  }
}

.tab-content {
  padding: 1.5rem;
}

.section-content {
  padding-top: 1.5rem;
}

.section-header {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1.5rem;
  gap: 1rem;
}

@media (min-width: 640px) {
  .section-header {
    flex-direction: row;
    align-items: center;
  }
}

.section-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
}

.add-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  background-color: #2563eb;
  color: #fff;
  border: none;
  border-radius: 0.5rem;
  transition: background-color 0.15s;
  align-self: flex-end;
}

.add-button:hover {
  background-color: #1d4ed8;
}

@media (min-width: 640px) {
  .add-button {
    align-self: auto;
  }
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  align-items: flex-end;
  margin-bottom: 2rem;
}

@media (min-width: 768px) {
  .form-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .form-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.25rem;
}

.form-input {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  box-sizing: border-box;
}

.form-input:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
  box-shadow: 0 0 0 2px #2563eb;
  border-color: #2563eb;
}

.table-container {
  overflow-x: auto;
}

.data-table {
  width: 100%;
  text-align: left;
  font-size: 0.875rem;
  color: #6b7280;
}

.data-table th,
.data-table td {
  padding: 1rem 1.5rem;
}

.data-table th {
  font-weight: 500;
  text-transform: uppercase;
  color: #4b5563;
  background-color: #f9fafb;
}

.data-table tbody tr {
  background-color: #fff;
  border-bottom: 1px solid #e5e7eb;
}

.data-table tbody tr:hover {
  background-color: #f9fafb;
}

.data-table td:last-child {
  text-align: center;
}

.price {
  font-weight: 600;
  color: #10b981;
}

.action-buttons {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
}

.icon-button {
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
  color: #6b7280;
  transition: color 0.15s;
}

.icon-button:hover {
  color: #2563eb;
}

.icon-button:hover .material-icons {
  color: #2563eb;
}

.icon-button:last-child:hover {
  color: #ef4444;
}

.icon-button:last-child:hover .material-icons {
  color: #ef4444;
}

.tag {
  display: inline-block;
  font-size: 0.75rem;
  font-weight: 500;
  padding: 0.25rem 0.625rem;
  border-radius: 9999px;
}

.tag.purple {
  background-color: #f3e8ff;
  color: #9333ea;
}

.tag.blue {
  background-color: #dbeafe;
  color: #1d4ed8;
}

.tag.green {
  background-color: #d1fae5;
  color: #065f46;
}

.tag.orange {
  background-color: #fff7ed;
  color: #ea580c;
}

/* Invoicing section styles */
.button-group-row {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
}

@media (min-width: 768px) {
  .button-group-row {
    flex-direction: row;
    align-items: center;
  }
}

.button-group-left {
  display: flex;
  gap: 0.5rem;
}

.button-group-right {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.button-group-item {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  background-color: #fff;
  cursor: pointer;
}

.button-group-item.active {
  background-color: #eff6ff;
  border-color: #93c5fd;
  color: #2563eb;
}

.button-group-item:hover {
  background-color: #f3f4f6;
}

.self-end-lg {
  align-self: flex-end;
  width: 100%;
}

@media (min-width: 1024px) {
  .self-end-lg {
    width: auto;
  }
}

.payment-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1rem;
}

.payment-icon {
  height: 1.5rem;
  width: auto;
  margin-right: 0.5rem;
}

.integration-info {
  font-size: 0.875rem;
  color: #6b7280;
}
</style>
