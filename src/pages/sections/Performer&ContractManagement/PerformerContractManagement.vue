<template>
  <div class="performer-system-container">
    <div class="content-container">
      <div class="tab-nav-container">
        <nav class="tab-nav">
          <a
            v-for="tab in tabs"
            :key="tab.id"
            :class="{
              'tab-link-active': activeTab === tab.id,
              'tab-link-inactive': activeTab !== tab.id,
            }"
            @click="activeTab = tab.id"
          >
            {{ tab.name }}
          </a>
        </nav>
        <div class="header-actions">
          <button
            v-if="activeTab === 'performer-registry'"
            @click="openModal(selectedPerformer, 'edit')"
            class="btn-nav"
          >
            <svg class="icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path
                fill-rule="evenodd"
                d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0l-1.5-1.5a2 2 0 112.828-2.828l1.5 1.5 3-3zM2 4a1 1 0 011-1h2a1 1 0 110 2H3a1 1 0 01-1-1zM2 9a1 1 0 011-1h2a1 1 0 110 2H3a1 1 0 01-1-1zM2 14a1 1 0 011-1h2a1 1 0 110 2H3a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
            Edit
          </button>
          <button
            v-if="activeTab === 'performer-registry'"
            @click="openModal(null, 'add')"
            class="btn-nav"
          >
            <svg class="icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path
                fill-rule="evenodd"
                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
            Add Performer
          </button>
          <button
            v-if="activeTab === 'performance-alerts'"
            @click="applyAdjustments"
            class="btn-primary"
          >
            <svg class="icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path
                d="M11 5.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9ZM2 10a8 8 0 1 1 16 0A8 8 0 0 1 2 10Z"
                clip-rule="evenodd"
                fill-rule="evenodd"
              />
            </svg>
            Apply Adjustments
          </button>
        </div>
      </div>

      <div class="tab-content">
        <div v-show="activeTab === 'performer-registry'" class="card">
          <div class="card-header">
            <div class="search-input-container">
              <div class="search-icon-container">
                <svg
                  class="search-icon"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </div>
              <input
                v-model="searchQuery"
                type="text"
                class="search-input"
                placeholder="Search by Performer ID, GDC Number, Name..."
              />
            </div>
          </div>
          <div class="table-container">
            <table class="data-table">
              <thead>
                <tr>
                  <th scope="col" class="table-cell-name">Name</th>
                  <th scope="col" class="table-cell">Performer ID</th>
                  <th scope="col" class="table-cell">GDC Number</th>
                  <th scope="col" class="table-cell">Role</th>
                  <th scope="col" class="table-cell">NHS Start Date</th>
                  <th scope="col" class="table-cell">Status</th>
                  <th scope="col" class="table-cell-actions">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="table-body">
                <tr v-for="performer in paginatedPerformers" :key="performer.id">
                  <td class="table-cell-name">{{ performer.name }}</td>
                  <td class="table-cell">{{ performer.performerId }}</td>
                  <td class="table-cell">{{ performer.gdcNumber }}</td>
                  <td class="table-cell">{{ performer.role }}</td>
                  <td class="table-cell">{{ performer.nhsStartDate }}</td>
                  <td class="table-cell-status">
                    <span
                      :class="{
                        'status-active': performer.status === 'Active',
                        'status-inactive': performer.status === 'Inactive',
                      }"
                      class="status-badge"
                    >
                      {{ performer.status }}
                    </span>
                  </td>
                  <td class="table-cell-actions-links">
                    <a @click="openModal(performer, 'edit')" class="link-edit">Edit</a>
                    <a
                      @click="toggleStatus(performer)"
                      :class="{
                        'link-deactivate': performer.status === 'Active',
                        'link-activate': performer.status === 'Inactive',
                      }"
                    >
                      {{ performer.status === "Active" ? "Deactivate" : "Activate" }}
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="pagination-container">
            <div class="pagination-mobile">
              <a
                @click="currentPage > 1 ? currentPage-- : null"
                class="pagination-btn-mobile"
                >Previous</a
              >
              <a
                @click="currentPage < totalPages ? currentPage++ : null"
                class="pagination-btn-mobile ml-3"
                >Next</a
              >
            </div>
            <div class="pagination-desktop">
              <p class="pagination-info">
                Showing
                <span class="font-medium">{{ (currentPage - 1) * pageSize + 1 }}</span>
                to
                <span class="font-medium">{{
                  Math.min(currentPage * pageSize, filteredPerformers.length)
                }}</span>
                of
                <span class="font-medium">{{ filteredPerformers.length }}</span>
                results
              </p>
              <nav class="pagination-nav">
                <a
                  @click="currentPage > 1 ? currentPage-- : null"
                  class="pagination-nav-link-prev"
                >
                  <span class="sr-only">Previous</span>
                  <svg
                    class="icon"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </a>
                <a
                  v-for="page in totalPages"
                  :key="page"
                  @click="currentPage = page"
                  :class="{
                    'pagination-page-active': currentPage === page,
                    'pagination-page-inactive': currentPage !== page,
                  }"
                >
                  {{ page }}
                </a>
                <a
                  @click="currentPage < totalPages ? currentPage++ : null"
                  class="pagination-nav-link-next"
                >
                  <span class="sr-only">Next</span>
                  <svg
                    class="icon"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </a>
              </nav>
            </div>
          </div>
        </div>

        <div v-show="activeTab === 'contract-management'" class="card card-padded">
          <div v-if="showMessage" :class="successAlertClass">{{ successMessage }}</div>

          <div class="contract-management-layout">
            <div class="performer-list-column">
              <h3 class="column-title">Performer List</h3>
              <p class="column-subtitle">Drag and drop performers onto a contract.</p>
              <div class="performer-list-search-container">
                <input
                  v-model="performerSearchQuery"
                  type="text"
                  class="performer-search-input"
                  placeholder="Search performers..."
                />
              </div>
              <div class="performer-list-scroll">
                <div
                  v-for="performer in filteredPerformersForMapping"
                  :key="performer.id"
                  class="performer-item"
                  :draggable="true"
                  @dragstart="onDragStart(performer.performerId)"
                >
                  <div>
                    <div class="performer-item-name">{{ performer.name }}</div>
                    <div class="performer-item-role">{{ performer.role }}</div>
                  </div>
                </div>
                <div
                  v-if="filteredPerformersForMapping.length === 0"
                  class="no-results-message"
                >
                  No performers found.
                </div>
              </div>
            </div>

            <div class="contract-column">
              <h3 class="column-title">Contract Mapping</h3>
              <div class="contract-search-container">
                <input
                  v-model="contractSearchQuery"
                  type="text"
                  class="contract-search-input"
                  placeholder="Search contracts..."
                />
              </div>
              <div class="contract-list-scroll">
                <div
                  v-for="contract in filteredContracts"
                  :key="contract.id"
                  class="contract-card"
                  @dragover.prevent
                  @drop="onDrop(contract.id)"
                >
                  <div class="contract-card-header">
                    <h4 class="contract-title">
                      {{ contract.name }}
                    </h4>
                    <span
                      :class="{
                        'contract-status-active': contract.status === 'Active',
                        'contract-status-expired': contract.status === 'Expired',
                      }"
                      class="contract-status-badge"
                    >
                      {{ contract.status }}
                    </span>
                  </div>
                  <div class="contract-card-body">
                    <div
                      v-if="getMappedPerformers(contract.id).length === 0"
                      class="empty-drop-zone"
                    >
                      Drag & drop performers here
                    </div>
                    <div v-else class="mapped-performer-list">
                      <div
                        v-for="performer in getMappedPerformers(contract.id)"
                        :key="performer.id"
                        class="mapped-performer-item"
                      >
                        <div class="mapped-performer-details">
                          <span class="mapped-performer-name">{{ performer.name }}</span>
                          <span class="mapped-performer-role">{{ performer.role }}</span>
                        </div>
                        <button
                          @click="
                            removePerformerFromContract(
                              contract.id,
                              performer.performerId
                            )
                          "
                          class="remove-performer-btn"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="w-5 h-5"
                          >
                            <path
                              d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"
                            />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="filteredContracts.length === 0" class="no-results-message">
                  No contracts found.
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          v-show="activeTab === 'performance-alerts'"
          class="performance-alerts-container"
        >
          <div class="performance-alerts-header">
            <h3>Performer Performance & Alerts</h3>
            <div class="date-filter">
              <span>Filter by: Last 30 days</span>
            </div>
          </div>

          <div class="kpi-container">
            <div class="kpi-card">
              <div class="kpi-header">
                <h4>Private vs. NHS Revenue Ratio</h4>
                <p class="kpi-value">1 : 4.5</p>
              </div>
              <p class="kpi-target">Target: 1 : 4.0</p>
              <div class="kpi-status-container">
                <div class="kpi-status-icon danger"></div>
                <p class="kpi-status-text danger">Slightly below target</p>
              </div>
            </div>
            <div class="kpi-card">
              <div class="kpi-header">
                <h4>Total NHS UDAs Delivered</h4>
                <p class="kpi-value">1,850</p>
              </div>
              <p class="kpi-target">Target: 2,000</p>
              <div class="kpi-status-container">
                <div class="kpi-status-icon warning"></div>
                <p class="kpi-status-text warning">On track</p>
              </div>
            </div>
            <div class="kpi-card">
              <div class="kpi-header">
                <h4>Total Private Revenue</h4>
                <p class="kpi-value">£41,625</p>
              </div>
              <p class="kpi-target">Target: £40,000</p>
              <div class="kpi-status-container">
                <div class="kpi-status-icon success"></div>
                <p class="kpi-status-text success">Exceeding target</p>
              </div>
            </div>
          </div>

          <div class="performance-breakdown-section">
            <div class="performance-breakdown-header">
              <h4 class="section-title">Performance Breakdown</h4>
              <div class="search-input-container-small">
                <input
                  type="text"
                  placeholder="Filter performers or contracts..."
                  class="search-input-small"
                />
              </div>
            </div>
            <div class="table-container">
              <table class="data-table">
                <thead>
                  <tr>
                    <th scope="col" class="table-cell">Performer / Contract</th>
                    <th scope="col" class="table-cell">UDAs Delivered</th>
                    <th scope="col" class="table-cell">NHS Revenue</th>
                    <th scope="col" class="table-cell">Private Revenue</th>
                    <th scope="col" class="table-cell">Variance from Target</th>
                    <th scope="col" class="table-cell">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Dr. Emily Carter</td>
                    <td>750 / 800</td>
                    <td>£18,750</td>
                    <td>£15,200</td>
                    <td>-6.25%</td>
                    <td class="status-cell-danger">Underperforming</td>
                  </tr>
                  <tr>
                    <td>Dr. David Lee</td>
                    <td>550 / 500</td>
                    <td>£13,750</td>
                    <td>£10,500</td>
                    <td>+10.00%</td>
                    <td class="status-cell-success">Exceeding</td>
                  </tr>
                  <tr>
                    <td>Dr. Sarah Jones</td>
                    <td>550 / 700</td>
                    <td>£13,750</td>
                    <td>£15,925</td>
                    <td>-21.43%</td>
                    <td class="status-cell-critical">Critical</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="charts-and-alerts-container">
            <div class="performance-trends-section">
              <h4 class="section-title">Performance Trends</h4>
              <div class="chart-container">
                <img
                  src="https://image.shutterstock.com/image-photo/upward-trending-line-graph-on-260nw-1050519185.jpg"
                  alt="Performance Trends Chart"
                />
              </div>
            </div>
            <div class="alerts-thresholds-section">
              <h4 class="section-title">Alerts & Thresholds</h4>
              <div class="alert-control">
                <label class="alert-label">UDA Threshold Alert</label>
                <input type="range" min="0" max="100" value="85" class="slider" />
                <p class="alert-description">
                  Trigger alert when UDA delivery drops below this percentage of target.
                </p>
              </div>
              <div class="alert-control">
                <label class="alert-label">Revenue Ratio Alert</label>
                <div class="input-ratio">
                  <span class="ratio-prefix">1:</span>
                  <input type="text" value="4.0" class="ratio-input" />
                </div>
                <p class="alert-description">
                  Trigger alert when Private:NHS ratio deviates from target.
                </p>
              </div>
              <div class="alert-control">
                <label class="alert-label">Alert Sensitivity</label>
                <select class="sensitivity-select">
                  <option>Medium</option>
                  <option>Low</option>
                  <option>High</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div v-show="activeTab === 'reporting'" class="reporting-container">
          <div class="reporting-header">
            <h3>Generate New Report</h3>
          </div>
          <div class="report-controls-grid">
            <div class="select-wrapper">
              <label for="report-type" class="form-label">Report Type</label>
              <select id="report-type" class="report-select">
                <option>Performance Summary</option>
              </select>
            </div>
            <div class="select-wrapper">
              <label for="date-range" class="form-label">Date Range</label>
              <select id="date-range" class="report-select">
                <option>Last 90 Days</option>
              </select>
            </div>
            <div class="select-wrapper">
              <label for="performers-filter" class="form-label">Performers</label>
              <select id="performers-filter" class="report-select">
                <option>All Performers</option>
              </select>
            </div>
            <div class="select-wrapper">
              <label for="contracts-filter" class="form-label">Contracts</label>
              <select id="contracts-filter" class="report-select">
                <option>All Contracts</option>
              </select>
            </div>
          </div>
          <p class="last-generated-info">
            Last Generated Report: Performance Summary for All Performers (Last 90 Days)
            on Oct 26, 2023
          </p>

          <div class="reports-and-summary-grid">
            <div class="previously-generated-section">
              <div class="section-header">
                <h4 class="section-title">Previously Generated Reports</h4>
                <div class="search-input-container-small">
                  <input
                    type="text"
                    placeholder="Search reports..."
                    class="search-input-small"
                  />
                </div>
              </div>
              <div class="table-container-reports">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th scope="col" class="table-cell-report">Report Name</th>
                      <th scope="col" class="table-cell-date">Date Generated</th>
                      <th scope="col" class="table-cell-actions-reports">
                        <span class="sr-only">Actions</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="report in reports" :key="report.id">
                      <td class="table-cell-report">{{ report.name }}</td>
                      <td class="table-cell-date">{{ report.date }}</td>
                      <td class="table-cell-actions-reports">
                        <a href="#" class="report-action-link">Preview</a>
                        <a href="#" class="report-action-link">Download</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="report-summary-panel">
              <h4 class="summary-panel-title">Report Summary: Performance Q3 2023</h4>
              <div class="summary-kpis">
                <div class="summary-kpi-item">
                  <p class="summary-kpi-label">Total NHS UDAs Delivered</p>
                  <p class="summary-kpi-value">
                    1,850 / <span class="kpi-target-inline">2,000 target</span>
                  </p>
                </div>
                <div class="summary-kpi-item">
                  <p class="summary-kpi-label">Total Private Revenue</p>
                  <p class="summary-kpi-value">
                    £41,625 / <span class="kpi-target-inline">£40,000 target</span>
                  </p>
                </div>
                <div class="summary-kpi-item">
                  <p class="summary-kpi-label">Private vs. NHS Revenue Ratio</p>
                  <p class="summary-kpi-value">
                    1 : 4.5 / <span class="kpi-target-inline">1 : 4.0 target</span>
                  </p>
                </div>
              </div>
              <div class="top-performers-list">
                <h5 class="top-performers-title">Top Performers</h5>
                <ul class="performer-variance-list">
                  <li>
                    <span class="performer-name-variance">Dr. David Lee</span>
                    <span class="variance-positive">+10.00%</span>
                  </li>
                  <li>
                    <span class="performer-name-variance">Dr. Emily Carter</span>
                    <span class="variance-negative">-6.25%</span>
                  </li>
                  <li>
                    <span class="performer-name-variance">Dr. Sarah Jones</span>
                    <span class="variance-negative">-21.43%</span>
                  </li>
                </ul>
              </div>
              <button @click="generateReport" class="btn-primary-full-width">
                View Full Report
              </button>
            </div>
          </div>
          <div v-if="showReport" class="report-container">
            <div class="report-header">
              <h4 class="report-title">
                Monthly NHS Contract Report -
                {{
                  new Date().toLocaleString("default", { month: "long", year: "numeric" })
                }}
              </h4>
              <p class="report-meta">
                Generated on: {{ new Date().toLocaleDateString() }} at
                {{ new Date().toLocaleTimeString() }}
              </p>
            </div>
            <pre class="report-content">
Report Summary:

Contract: NHS Midlands Region A (Contract ID: NHS-M-01)

- UDA Target: 50,000
- UDA Achieved: 48,500 (97% of target)
- Private Revenue: £120,500
- Total Patients Seen: 3,500

Performer Performance Highlights:
--------------------------------
- Dr. Emily Carter: Achieved 105% of personal UDA target.
- Dr. David Lee: Requires review, at 85% of personal UDA target.

Financial Overview:
-------------------
- NHS Revenue: £250,000
- Private Revenue: £120,500
- Total Practice Revenue: £370,500

Alerts & Compliance:
--------------------
- No high-priority compliance alerts this period.
- Two performers flagged for low UDA output.
- UDA to private revenue ratio is stable.

Recommendations:
----------------
- Implement targeted support for performers with low UDA achievement.
- Monitor patient booking trends for the next quarter.
            </pre>
          </div>
        </div>
      </div>
    </div>

    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">{{ modalTitle }}</h3>
          <button @click="closeModal" class="modal-close-btn">
            <svg
              class="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
        </div>
        <form @submit.prevent="savePerformer">
          <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input
              type="text"
              id="name"
              v-model="performerForm.name"
              class="form-input"
              required
            />
          </div>
          <div class="form-group">
            <label for="performerId" class="form-label">Performer ID</label>
            <input
              type="text"
              id="performerId"
              v-model="performerForm.performerId"
              class="form-input"
              required
            />
          </div>
          <div class="form-group">
            <label for="gdcNumber" class="form-label">GDC Number</label>
            <input
              type="text"
              id="gdcNumber"
              v-model="performerForm.gdcNumber"
              class="form-input"
              required
            />
          </div>
          <div class="form-group">
            <label for="nhsStartDate" class="form-label">NHS Start Date</label>
            <input
              type="date"
              id="nhsStartDate"
              v-model="performerForm.nhsStartDate"
              class="form-input"
              required
            />
          </div>
          <div class="modal-footer">
            <button type="button" @click="closeModal" class="btn-cancel">Cancel</button>
            <button type="submit" class="btn-submit">{{ modalAction }} Performer</button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="isContractsModalOpen" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">
            Manage Contracts for {{ performerToManageContracts.name }}
          </h3>
          <button @click="closeContractsModal" class="modal-close-btn">
            <svg
              class="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <p class="modal-description">
            Select the contracts to which this performer is mapped.
          </p>
          <div class="contract-checkboxes">
            <div v-for="contract in contracts" :key="contract.id" class="checkbox-item">
              <input
                type="checkbox"
                :id="'contract-' + contract.id"
                :value="contract.id"
                v-model="selectedContractIds"
                class="form-checkbox"
              />
              <label :for="'contract-' + contract.id" class="checkbox-label">
                {{ contract.name }}
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeContractsModal" class="btn-cancel">Cancel</button>
          <button @click="saveContractsMapping" class="btn-submit">Save Mapping</button>
        </div>
      </div>
    </div>

    <div v-if="isSetTargetModalOpen" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Set Target for {{ performerToSetTarget.name }}</h3>
          <button @click="closeSetTargetModal" class="modal-close-btn">
            <svg
              class="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">New Target Ratio (Private)</label>
            <div class="input-with-suffix">
              <input type="number" v-model="newTargetRatio" class="form-input" />
              <span class="input-suffix">%</span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeSetTargetModal" class="btn-cancel">Cancel</button>
          <button @click="savePerformerTarget" class="btn-submit">Save Target</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, watch } from "vue";

export default {
  setup() {
    // === Data ===
    const tabs = ref([
      { id: "performer-registry", name: "NHS Performer Registry" },
      { id: "contract-management", name: "Contract Management & Mapping" },
      { id: "performance-alerts", name: "Performance & Alerts" },
      { id: "reporting", name: "Reporting" },
    ]);
    const activeTab = ref("performer-registry");
    const searchQuery = ref("");
    const isModalOpen = ref(false);
    const modalMode = ref("add");
    const selectedPerformer = ref(null);

    const performers = ref([
      {
        id: 1,
        name: "Dr. Emily Carter",
        performerId: "PERF001",
        gdcNumber: "123456",
        role: "Dentist",
        nhsStartDate: "2020-01-15",
        status: "Active",
      },
      {
        id: 2,
        name: "Dr. David Lee",
        performerId: "PERF002",
        gdcNumber: "654321",
        role: "Dentist",
        nhsStartDate: "2018-05-20",
        status: "Active",
      },
      {
        id: 3,
        name: "Dr. Sarah Jones",
        performerId: "PERF003",
        gdcNumber: "987654",
        role: "Hygienist",
        nhsStartDate: "2021-03-10",
        status: "Active",
      },
      {
        id: 4,
        name: "Dr. Michael Brown",
        performerId: "PERF004",
        gdcNumber: "456789",
        role: "Dentist",
        nhsStartDate: "2019-11-01",
        status: "Inactive",
      },
      {
        id: 5,
        name: "Dr. Olivia Wilson",
        performerId: "PERF005",
        gdcNumber: "789012",
        role: "Dentist",
        nhsStartDate: "2022-02-28",
        status: "Active",
      },
      {
        id: 6,
        name: "Dr. James Smith",
        performerId: "PERF006",
        gdcNumber: "321654",
        role: "Dentist",
        nhsStartDate: "2020-09-10",
        status: "Active",
      },
      {
        id: 7,
        name: "Dr. Jessica White",
        performerId: "PERF007",
        gdcNumber: "765432",
        role: "Hygienist",
        nhsStartDate: "2021-07-22",
        status: "Inactive",
      },
      {
        id: 8,
        name: "Dr. Ben Davis",
        performerId: "PERF008",
        gdcNumber: "876543",
        role: "Dentist",
        nhsStartDate: "2018-12-05",
        status: "Active",
      },
      {
        id: 9,
        name: "Dr. Chloe Taylor",
        performerId: "PERF009",
        gdcNumber: "234567",
        role: "Therapist",
        nhsStartDate: "2022-04-18",
        status: "Active",
      },
      {
        id: 10,
        name: "Dr. Ryan Hall",
        performerId: "PERF010",
        gdcNumber: "901234",
        role: "Dentist",
        nhsStartDate: "2019-06-30",
        status: "Inactive",
      },
    ]);

    const performerForm = ref({
      id: null,
      name: "",
      performerId: "",
      gdcNumber: "",
      role: "",
      nhsStartDate: "",
      status: "Active",
    });

    const contracts = ref([
      { id: 1, name: "NHS Midlands Region A" },
      { id: 2, name: "NHS North-West Region B" },
      { id: 3, name: "NHS Scotland Contract 05" },
    ]);

    const performerContractMap = ref({
      PERF001: [1, 2],
      PERF002: [1],
      PERF003: [3],
    });

    const selectedPerformers = ref([]);
    const isContractsModalOpen = ref(false);
    const performerToManageContracts = ref({});
    const selectedContractIds = ref([]);
    const showReport = ref(false);
    const draggedPerformerId = ref(null);
    const successMessage = ref("");
    const showMessage = ref(false);

    const performerSearchQuery = ref("");
    const contractSearchQuery = ref("");
    const contractsList = ref([
      {
        id: 1,
        name: "NHS001: General Dental Services",
        status: "Active",
        startDate: "2023-04-01",
        endDate: "2025-03-31",
      },
      {
        id: 2,
        name: "NHS002: Orthodontic Services",
        status: "Active",
        startDate: "2022-09-01",
        endDate: "2024-08-31",
      },
      {
        id: 3,
        name: "NHS003: Pediatric Dental Care",
        status: "Expired",
        startDate: "2023-01-01",
        endDate: "2023-12-31",
      },
      {
        id: 4,
        name: "NHS004: Emergency Services",
        status: "Active",
        startDate: "2024-01-01",
        endDate: "2026-12-31",
      },
    ]);
    const contractPerformerMap = ref({
      1: ["PERF001", "PERF002"],
      2: ["PERF001"],
      3: ["PERF003"],
      4: ["PERF006", "PERF009"],
    });

    const practiceWideRatio = ref(65);
    const privateRevenue = ref(130000);
    const nhsRevenue = ref(70000);

    const performerRevenueRatios = ref([
      { id: 1, name: "Dr. Emily Carter", currentRatio: 75, targetRatio: 70 },
      { id: 2, name: "Dr. David Lee", currentRatio: 60, targetRatio: 70 },
      { id: 3, name: "Dr. Sarah Jones", currentRatio: 80, targetRatio: 75 },
    ]);

    const isSetTargetModalOpen = ref(false);
    const performerToSetTarget = ref({});
    const newTargetRatio = ref(0);

    const ratioBarStyle = computed(() => {
      return {
        height: `${practiceWideRatio.value}%`,
      };
    });

    const successAlertClass = computed(() => {
      return {
        "success-alert": showMessage.value,
      };
    });

    // === Reporting data ===
    const reports = ref([
      { id: 1, name: "Performance Summary - Q3 2023", date: "Oct 26, 2023" },
      { id: 2, name: "UDA Delivery - Dr. Carter", date: "Oct 15, 2023" },
      { id: 3, name: "Revenue Breakdown - September 2023", date: "Oct 01, 2023" },
      { id: 4, name: "Contract Compliance Report - Q2 2023", date: "Jul 05, 2023" },
    ]);

    // === Pagination for Performer Registry ===
    const currentPage = ref(1);
    const pageSize = ref(5);

    const filteredPerformers = computed(() => {
      const query = searchQuery.value.toLowerCase();
      if (!query) {
        return performers.value;
      }
      return performers.value.filter(
        (performer) =>
          performer.name.toLowerCase().includes(query) ||
          performer.performerId.toLowerCase().includes(query) ||
          performer.gdcNumber.toLowerCase().includes(query)
      );
    });

    const paginatedPerformers = computed(() => {
      const start = (currentPage.value - 1) * pageSize.value;
      const end = start + pageSize.value;
      return filteredPerformers.value.slice(start, end);
    });

    const totalPages = computed(() => {
      return Math.ceil(filteredPerformers.value.length / pageSize.value);
    });

    // === Modal Logic (Add/Edit Performer) ===
    const modalTitle = computed(() =>
      modalMode.value === "add" ? "Add New Performer" : "Edit Performer"
    );
    const modalAction = computed(() => (modalMode.value === "add" ? "Add" : "Save"));

    const openModal = (performer, mode) => {
      modalMode.value = mode;
      isModalOpen.value = true;
      if (mode === "edit" && performer) {
        selectedPerformer.value = performer;
        performerForm.value = { ...performer };
      } else {
        selectedPerformer.value = null;
        performerForm.value = {
          id: null,
          name: "",
          performerId: "",
          gdcNumber: "",
          role: "Dentist",
          nhsStartDate: "",
          status: "Active",
        };
      }
    };

    const closeModal = () => {
      isModalOpen.value = false;
    };

    const savePerformer = () => {
      if (modalMode.value === "add") {
        const newId =
          performers.value.length > 0
            ? Math.max(...performers.value.map((p) => p.id)) + 1
            : 1;
        const newPerformer = {
          ...performerForm.value,
          id: newId,
          role: "Dentist",
          status: "Active",
        };
        performers.value.push(newPerformer);
      } else if (modalMode.value === "edit" && selectedPerformer.value) {
        const index = performers.value.findIndex(
          (p) => p.id === selectedPerformer.value.id
        );
        if (index !== -1) {
          performers.value[index] = { ...performerForm.value };
        }
      }
      closeModal();
    };

    const toggleStatus = (performer) => {
      performer.status = performer.status === "Active" ? "Inactive" : "Active";
    };

    // === Contract Mapping Modal Logic ===
    const openContractsModal = (performer) => {
      performerToManageContracts.value = performer;
      selectedContractIds.value = performerContractMap.value[performer.performerId]
        ? [...performerContractMap.value[performer.performerId]]
        : [];
      isContractsModalOpen.value = true;
    };

    const closeContractsModal = () => {
      isContractsModalOpen.value = false;
      performerToManageContracts.value = {};
      selectedContractIds.value = [];
    };

    const saveContractsMapping = () => {
      if (selectedContractIds.value.length > 0) {
        performerContractMap.value[performerToManageContracts.value.performerId] =
          selectedContractIds.value;
      } else {
        delete performerContractMap.value[performerToManageContracts.value.performerId];
      }
      closeContractsModal();
    };

    const getContractNames = (performerId) => {
      const contractIds = performerContractMap.value[performerId] || [];
      return contractIds.map((id) => {
        const contract = contracts.value.find((c) => c.id === id);
        return contract ? contract.name : "Unknown Contract";
      });
    };

    const filteredPerformersForMapping = computed(() => {
      const query = performerSearchQuery.value.toLowerCase();
      if (!query) {
        return performers.value.filter((p) => p.status === "Active");
      }
      return performers.value.filter(
        (performer) =>
          performer.status === "Active" &&
          (performer.name.toLowerCase().includes(query) ||
            performer.role.toLowerCase().includes(query))
      );
    });

    const filteredContracts = computed(() => {
      const query = contractSearchQuery.value.toLowerCase();
      if (!query) {
        return contractsList.value;
      }
      return contractsList.value.filter((contract) =>
        contract.name.toLowerCase().includes(query)
      );
    });

    const getMappedPerformers = (contractId) => {
      const performerIds = contractPerformerMap.value[contractId] || [];
      return performerIds
        .map((performerId) => performers.value.find((p) => p.performerId === performerId))
        .filter(Boolean);
    };

    const onDragStart = (performerId) => {
      draggedPerformerId.value = performerId;
    };

    const showAndHideMessage = (message) => {
      successMessage.value = message;
      showMessage.value = true;
      setTimeout(() => {
        showMessage.value = false;
        successMessage.value = "";
      }, 3000);
    };

    const onDrop = (contractId) => {
      if (draggedPerformerId.value) {
        const performerId = draggedPerformerId.value;
        const currentMappings = contractPerformerMap.value[contractId] || [];
        const performer = performers.value.find((p) => p.performerId === performerId);
        const contract = contractsList.value.find((c) => c.id === contractId);
        if (!currentMappings.includes(performerId)) {
          contractPerformerMap.value[contractId] = [...currentMappings, performerId];
          showAndHideMessage(`${performer.name} has been mapped to ${contract.name}.`);
        }
      }
      draggedPerformerId.value = null;
    };

    const removePerformerFromContract = (contractId, performerId) => {
      const currentMappings = contractPerformerMap.value[contractId] || [];
      const performer = performers.value.find((p) => p.performerId === performerId);
      const contract = contractsList.value.find((c) => c.id === contractId);
      contractPerformerMap.value[contractId] = currentMappings.filter(
        (id) => id !== performerId
      );
      showAndHideMessage(`${performer.name} has been removed from ${contract.name}.`);
    };

    const getPerformerStatus = (current, target) => {
      return current >= target ? "On Target" : "Off Target";
    };

    const getPerformerStatusClass = (current, target) => {
      return current >= target
        ? "bg-green-100 text-green-700"
        : "bg-red-100 text-red-700";
    };

    const applyAdjustments = () => {
      alert("Adjustments applied!");
    };

    const openSetTargetModal = (performer) => {
      performerToSetTarget.value = performer;
      newTargetRatio.value = performer ? performer.targetRatio : 0;
      isSetTargetModalOpen.value = true;
    };

    const closeSetTargetModal = () => {
      isSetTargetModalOpen.value = false;
    };

    const savePerformerTarget = () => {
      if (performerToSetTarget.value && newTargetRatio.value !== null) {
        const index = performerRevenueRatios.value.findIndex(
          (p) => p.id === performerToSetTarget.value.id
        );
        if (index !== -1) {
          performerRevenueRatios.value[index].targetRatio = newTargetRatio.value;
        }
      }
      closeSetTargetModal();
    };

    const generateReport = () => {
      showReport.value = !showReport.value;
    };

    watch(searchQuery, () => {
      currentPage.value = 1;
    });

    return {
      tabs,
      activeTab,
      searchQuery,
      performers,
      filteredPerformers,
      paginatedPerformers,
      currentPage,
      pageSize,
      totalPages,
      isModalOpen,
      performerForm,
      modalTitle,
      modalAction,
      openModal,
      closeModal,
      savePerformer,
      toggleStatus,
      selectedPerformer,
      contracts,
      performerContractMap,
      selectedPerformers,
      getContractNames,
      showReport,
      generateReport,
      isContractsModalOpen,
      performerToManageContracts,
      selectedContractIds,
      openContractsModal,
      closeContractsModal,
      saveContractsMapping,
      practiceWideRatio,
      privateRevenue,
      nhsRevenue,
      performerRevenueRatios,
      getPerformerStatus,
      getPerformerStatusClass,
      applyAdjustments,
      isSetTargetModalOpen,
      performerToSetTarget,
      newTargetRatio,
      openSetTargetModal,
      closeSetTargetModal,
      savePerformerTarget,
      ratioBarStyle,
      performerSearchQuery,
      contractSearchQuery,
      contractsList,
      contractPerformerMap,
      filteredPerformersForMapping,
      filteredContracts,
      getMappedPerformers,
      onDragStart,
      onDrop,
      removePerformerFromContract,
      successMessage,
      showMessage,
      successAlertClass,
      reports, // New data property
    };
  },
};
</script>
<style>
/* Base Styles */
body {
  font-family: "Inter", sans-serif;
  margin: 0;
  background-color: #f8fafc;
}
.performer-system-container {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue",
    Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
    "Segoe UI Symbol", "Noto Color Emoji";
  background-color: #f3f4f6;
  min-height: 100vh;
  padding: 1.5rem;
  color: #1f2937;
}
.content-container {
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  padding: 1.5rem;
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
/* --- Header & Tabs --- */
.tab-nav-container {
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}
.tab-nav {
  display: flex;
  margin-bottom: 1.5rem;
  border-bottom: 2px solid #e5e7eb;
}
.tab-link-active,
.tab-link-inactive {
  white-space: nowrap;
  padding: 1rem 0.25rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
}
.tab-link-active {
  color: #111418;
  border-bottom: 2px solid #111418;
  font-weight: 600;
  padding: 0.75rem 1rem;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
}
.tab-link-inactive {
  color: #6b7280;
  padding: 0.75rem 1rem;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
}
.tab-link-inactive:hover {
  color: #4b5563;
}
.header-actions {
  display: flex;
  gap: 1rem;
  align-items: center;
}
.btn-nav {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #334155;
  border: 1px solid #cbd5e1;
  background-color: #ffffff;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}
.btn-nav:hover {
  background-color: #f1f5f9;
}
.icon {
  height: 1.25rem;
  width: 1.25rem;
}
/* --- Content & Table --- */
.tab-content {
  margin-top: 1.5rem;
}
.card {
  border-radius: 0.5rem;
  background-color: #ffffff;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
}
.card-padded {
  padding: 1.5rem;
}
.card-header,
.card-header-simple {
  padding: 1rem;
}
.card-header-simple {
  margin-bottom: 1rem;
  padding: 0;
}
.search-input-container {
  position: relative;
}
.search-icon-container {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  display: flex;
  align-items: center;
  padding-left: 0.75rem;
  pointer-events: none;
}
.search-icon {
  height: 1.25rem;
  width: 1.25rem;
  color: #94a3b8;
}
.search-input {
  display: block;
  width: 100%;
  border-radius: 0.375rem;
  border: 1px solid #cbd5e1;
  padding: 0.5rem 0.75rem 0.5rem 2.5rem;
  font-size: 0.875rem;
  line-height: 1.5rem;
  color: #1f2937;
  transition: all 0.2s ease-in-out;
}
.search-input::placeholder {
  color: #94a3b8;
}
.search-input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 1px #2563eb;
}
.table-container {
  overflow-x: auto;
}
.data-table {
  min-width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}
.data-table thead {
  background-color: #f8fafc;
}
.data-table th {
  text-align: left;
  padding: 0.875rem 0.75rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: #1f2937;
}
.data-table th.table-cell-name {
  padding-left: 1.5rem;
}
.data-table td {
  padding: 1rem 0.75rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
  color: #4b5563;
  white-space: nowrap;
  border-bottom: 1px solid #e2e8f0;
}
.data-table td.table-cell-name {
  font-weight: 500;
  color: #1f2937;
  padding-left: 1.5rem;
}
.data-table tbody tr:last-child td {
  border-bottom: none;
}
.table-cell-status {
  text-align: center;
}
.status-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
}
.status-active {
  background-color: #d1fae5;
  color: #065f46;
}
.status-inactive {
  background-color: #fce7f3;
  color: #be185d;
}
.table-cell-actions {
  text-align: right;
  padding-right: 1.5rem;
}
.table-cell-actions-links {
  text-align: right;
  padding-right: 1.5rem;
}
.link-edit {
  color: #2563eb;
  font-weight: 500;
  cursor: pointer;
  margin-right: 1rem;
}
.link-deactivate {
  color: #dc2626;
  font-weight: 500;
  cursor: pointer;
}
.link-activate {
  color: #16a34a;
  font-weight: 500;
  cursor: pointer;
}
/* --- Pagination --- */
.pagination-container {
  padding: 1rem 0.75rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid #e2e8f0;
}
.pagination-mobile {
  display: none;
}
@media (max-width: 768px) {
  .pagination-desktop {
    display: none;
  }
  .pagination-mobile {
    display: flex;
    justify-content: space-between;
    width: 100%;
  }
}
.pagination-btn-mobile {
  position: relative;
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  background-color: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  cursor: pointer;
}
.pagination-info {
  font-size: 0.875rem;
  color: #4b5563;
}
.pagination-nav {
  display: flex;
  border-radius: 0.375rem;
}
.pagination-nav a {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #6b7280;
  border: 1px solid #e5e7eb;
  background-color: #fff;
  cursor: pointer;
  z-index: 10;
}
.pagination-nav-link-prev {
  border-top-left-radius: 0.375rem;
  border-bottom-left-radius: 0.375rem;
}
.pagination-nav-link-next {
  border-top-right-radius: 0.375rem;
  border-bottom-right-radius: 0.375rem;
}
.pagination-page-active {
  color: #111827;
  background-color: #f3f4f6;
  border-color: #e5e7eb;
}
/* --- Modals --- */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal-content {
  background-color: #ffffff;
  border-radius: 0.5rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  padding: 1.5rem;
  width: 100%;
  max-width: 28rem;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}
.modal-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
}
.modal-close-btn {
  background-color: transparent;
  border: none;
  cursor: pointer;
  color: #9ca3af;
}
.form-group {
  margin-bottom: 1rem;
}
.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.25rem;
}
.form-input {
  display: block;
  width: 100%;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  line-height: 1.5rem;
}
.form-input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 1px #2563eb;
}
.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  margin-top: 1.5rem;
}
.btn-cancel {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
  background-color: #f9fafb;
  border: 1px solid #d1d5db;
  cursor: pointer;
}
.btn-submit {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #ffffff;
  background-color: #2563eb;
  border: 1px solid #2563eb;
  cursor: pointer;
}
.modal-description {
  font-size: 0.875rem;
  color: #6b7280;
  margin-bottom: 1rem;
}
.contract-checkboxes {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.checkbox-item {
  display: flex;
  align-items: center;
}
.form-checkbox {
  margin-right: 0.5rem;
  height: 1rem;
  width: 1rem;
  color: #2563eb;
  background-color: #f9fafb;
  border-color: #d1d5db;
  border-radius: 0.25rem;
}
.checkbox-label {
  font-size: 0.875rem;
  color: #1f2937;
}
/* --- New Layout for Contract Management */
.contract-management-layout {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 1.5rem;
}
.column-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.25rem;
}
.column-subtitle {
  font-size: 0.875rem;
  color: #6b7280;
  margin-bottom: 1rem;
}
.performer-list-search-container,
.contract-search-container {
  margin-bottom: 1rem;
}
.performer-search-input,
.contract-search-input {
  width: 100%;
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  border-radius: 0.375rem;
  border: 1px solid #e5e7eb;
}
.performer-list-scroll,
.contract-list-scroll {
  max-height: 600px;
  overflow-y: auto;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  padding: 0.5rem;
  background-color: #f9fafb;
}
.performer-item {
  background-color: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 0.375rem;
  padding: 0.75rem 1rem;
  margin-bottom: 0.5rem;
  cursor: grab;
  transition: all 0.2s;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.performer-item:hover {
  background-color: #f1f5f9;
}
.performer-item-name {
  font-weight: 500;
  color: #1f2937;
  font-size: 0.875rem;
}
.performer-item-role {
  font-size: 0.75rem;
  color: #6b7280;
}
.contract-card {
  background-color: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 0.375rem;
  margin-bottom: 0.75rem;
}
.contract-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #e2e8f0;
}
.contract-title {
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
}
.contract-status-badge {
  font-size: 0.75rem;
  font-weight: 500;
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
}
.contract-status-active {
  background-color: #dbeafe;
  color: #1d4ed8;
}
.contract-status-expired {
  background-color: #fee2e2;
  color: #b91c1c;
}
.empty-drop-zone {
  display: flex;
  justify-content: center;
  align-items: center;
  color: #9ca3af;
  font-style: italic;
  font-size: 0.875rem;
  min-height: 4rem;
  border: 2px dashed #d1d5db;
  border-radius: 0.375rem;
  margin: 1rem;
}
.mapped-performer-list {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 1rem;
}
.mapped-performer-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f3f4f6;
  border: 1px solid #e2e8f0;
  border-radius: 0.375rem;
  padding: 0.5rem 0.75rem;
}
.mapped-performer-details {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}
.mapped-performer-name {
  font-weight: 500;
  font-size: 0.875rem;
}
.mapped-performer-role {
  font-size: 0.75rem;
  color: #6b7280;
}
.remove-performer-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: #dc2626;
}
.no-results-message {
  text-align: center;
  color: #9ca3af;
  font-style: italic;
  padding: 1rem;
}
.success-alert {
  background-color: #d1fae5;
  color: #065f46;
  border-radius: 0.375rem;
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 1rem;
}

/* --- New Styles for Performance & Alerts --- */
.performance-alerts-container {
  padding: 1.5rem;
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
}
.performance-alerts-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 1rem;
}
.performance-alerts-header h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
}
.date-filter span {
  font-size: 0.875rem;
  color: #6b7280;
  cursor: pointer;
}
.kpi-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-bottom: 1.5rem;
}
.kpi-card {
  background-color: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 0.375rem;
  padding: 1rem;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
}
.kpi-header {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  margin-bottom: 0.5rem;
}
.kpi-header h4 {
  font-size: 0.875rem;
  font-weight: 500;
  color: #6b7280;
}
.kpi-value {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
}
.kpi-target {
  font-size: 0.875rem;
  color: #94a3b8;
  margin-bottom: 0.75rem;
}
.kpi-status-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.kpi-status-icon {
  width: 0.5rem;
  height: 0.5rem;
  border-radius: 9999px;
}
.kpi-status-icon.danger {
  background-color: #ef4444;
}
.kpi-status-icon.warning {
  background-color: #f59e0b;
}
.kpi-status-icon.success {
  background-color: #22c55e;
}
.kpi-status-text {
  font-size: 0.75rem;
  font-weight: 500;
}
.kpi-status-text.danger {
  color: #ef4444;
}
.kpi-status-text.warning {
  color: #f59e0b;
}
.kpi-status-text.success {
  color: #22c55e;
}
.performance-breakdown-section {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  margin-bottom: 1.5rem;
  overflow: hidden;
}
.performance-breakdown-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #e2e8f0;
}
.section-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
}
.search-input-container-small {
  position: relative;
}
.search-input-small {
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  border-radius: 0.375rem;
  border: 1px solid #cbd5e1;
}
.status-cell-danger {
  color: #dc2626;
  font-weight: 500;
}
.status-cell-success {
  color: #16a34a;
  font-weight: 500;
}
.status-cell-critical {
  color: #9a3412;
  font-weight: 500;
}
.charts-and-alerts-container {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.5rem;
}
.performance-trends-section {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  padding: 1.5rem;
}
.alerts-thresholds-section {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  padding: 1.5rem;
}
.chart-container img {
  width: 100%;
  height: auto;
}
.alert-control {
  margin-bottom: 1.5rem;
}
.alert-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}
.slider {
  width: 100%;
}
.alert-description {
  font-size: 0.75rem;
  color: #6b7280;
  margin-top: 0.25rem;
}
.input-ratio {
  display: flex;
  align-items: center;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  padding: 0.5rem 0.75rem;
  background-color: #f9fafb;
}
.ratio-prefix {
  font-size: 0.875rem;
  color: #6b7280;
  margin-right: 0.25rem;
}
.ratio-input {
  flex-grow: 1;
  border: none;
  background: none;
  font-size: 0.875rem;
}
.sensitivity-select {
  width: 100%;
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  background-color: #fff;
}

/* --- New Reporting Styles --- */
.reporting-container {
  padding: 1.5rem;
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
}
.reporting-header h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1.5rem;
}
.report-controls-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
  margin-bottom: 1rem;
}
.select-wrapper {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}
.report-select {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  font-size: 0.875rem;
}
.last-generated-info {
  font-size: 0.875rem;
  color: #6b7280;
  margin-bottom: 1.5rem;
}
.reports-and-summary-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.5rem;
}
.previously-generated-section {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  overflow: hidden;
}
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #e2e8f0;
}
.table-container-reports {
  overflow-x: auto;
}
.table-cell-report {
  padding: 0.875rem 1rem;
  text-align: left;
}
.table-cell-date {
  padding: 0.875rem 1rem;
  text-align: left;
}
.table-cell-actions-reports {
  text-align: right;
  padding: 0.875rem 1rem;
  white-space: nowrap;
}
.report-action-link {
  color: #2563eb;
  font-weight: 500;
  cursor: pointer;
  margin-left: 1rem;
  text-decoration: underline;
}
.report-summary-panel {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  padding: 1.5rem;
}
.summary-panel-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1.5rem;
}
.summary-kpi-item {
  margin-bottom: 1rem;
}
.summary-kpi-label {
  font-size: 0.875rem;
  color: #6b7280;
  margin-bottom: 0.25rem;
}
.summary-kpi-value {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
}
.kpi-target-inline {
  font-size: 0.875rem;
  font-weight: 400;
  color: #94a3b8;
}
.top-performers-list {
  margin-top: 2rem;
}
.top-performers-title {
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1rem;
}
.performer-variance-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.performer-variance-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.performer-name-variance {
  font-size: 0.875rem;
  color: #4b5563;
}
.variance-positive {
  font-size: 0.875rem;
  font-weight: 500;
  color: #16a34a;
}
.variance-negative {
  font-size: 0.875rem;
  font-weight: 500;
  color: #dc2626;
}
.btn-primary-full-width {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #ffffff;
  background-color: #2563eb;
  border: 1px solid #2563eb;
  cursor: pointer;
  margin-top: 1.5rem;
  transition: all 0.2s ease-in-out;
}
.btn-primary-full-width:hover {
  background-color: #1d4ed8;
  border-color: #1d4ed8;
}
.report-container {
  margin-top: 1.5rem;
  background-color: #f9fafb;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  padding: 1.5rem;
}
.report-header {
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 1rem;
  margin-bottom: 1rem;
}
.report-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
}
.report-meta {
  font-size: 0.875rem;
  color: #6b7280;
}
.report-content {
  white-space: pre-wrap;
  font-family: monospace;
  font-size: 0.875rem;
  line-height: 1.5rem;
  color: #1f2937;
}
</style>
