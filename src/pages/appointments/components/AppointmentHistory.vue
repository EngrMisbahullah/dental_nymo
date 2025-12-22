<template>
  <div class="appointment-history-container">
    <main class="main-content">
      <div class="header-section">
        <h2 class="title">Appointment History</h2>
        <div class="toolbar">
          <div class="search-container">
            <span class="search-icon material-icons">search</span>
            <input
              class="search-input"
              placeholder="Search patient name, notes..."
              type="text"
            />
          </div>
          <button class="filter-button">
            <span class="icon material-icons">filter_list</span>
            <span class="text">Filter</span>
          </button>
          <button class="date-range-button">
            <span class="icon material-icons">calendar_today</span>
            <span class="text">Date Range</span>
            <span class="icon material-icons expand-icon">expand_more</span>
          </button>
        </div>
      </div>

      <div class="table-container">
        <table class="appointment-table">
          <thead>
            <tr>
              <th scope="col">Patient</th>
              <th scope="col">Provider</th>
              <th scope="col">Appointment Type</th>
              <th scope="col">Date & Time</th>
              <th scope="col">Status</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(appointment, index) in appointments"
              :key="index"
              :class="{ 'last-row': index === appointments.length - 1 }"
            >
              <td class="font-medium text-gray-900">{{ appointment.patient }}</td>
              <td>{{ appointment.provider }}</td>
              <td>{{ appointment.appointmentType }}</td>
              <td>{{ appointment.dateTime }}</td>
              <td>
                <span :class="getStatusClass(appointment.status)">
                  {{ appointment.status }}
                </span>
              </td>
              <td class="action-cell">
                <button class="action-button">
                  <span class="material-icons">more_horiz</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="pagination-section">
        <span class="entry-info">
          Showing <span class="highlight">1</span> to <span class="highlight">7</span> of
          <span class="highlight">100</span> Entries
        </span>
        <div class="pagination-controls">
          <button class="pagination-button" disabled>Previous</button>
          <button class="pagination-button active">1</button>
          <button class="pagination-button">2</button>
          <button class="pagination-button">3</button>
          <span class="ellipsis">...</span>
          <button class="pagination-button">15</button>
          <button class="pagination-button">Next</button>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "AppointmentHistory",
  data() {
    return {
      appointments: [
        {
          patient: "David Rutherford",
          provider: "Sam Clarke",
          appointmentType: "Appointment - Crown Preparation",
          dateTime: "Thu 27 Aug 2020, 09:30 AM",
          status: "Completed",
        },
        {
          patient: "Helena Nichols",
          provider: "Carl Young",
          appointmentType: "Check-up, Scale & Polish, White Filling (Composite)",
          dateTime: "Thu 27 Aug 2020, 10:00 AM",
          status: "Completed",
        },
        {
          patient: "Rayne Carlsson",
          provider: "David Rutherford",
          appointmentType: "Zoom",
          dateTime: "Thu 27 Aug 2020, 01:30 PM",
          status: "Completed",
        },
        {
          patient: "James Darlings",
          provider: "David Rutherford",
          appointmentType: "NHS Patients only",
          dateTime: "Thu 27 Aug 2020, 02:00 PM",
          status: "Rescheduled",
        },
        {
          patient: "Anonymous",
          provider: "James Harker",
          appointmentType: "Private Patients only",
          dateTime: "Thu 27 Aug 2020, 09:00 AM",
          status: "Cancelled",
        },
        {
          patient: "Olivia Martinez",
          provider: "Sam Clarke",
          appointmentType: "NHS Patients",
          dateTime: "Wed 26 Aug 2020, 11:00 AM",
          status: "No Show",
        },
        {
          patient: "Liam Johnson",
          provider: "Carl Young",
          appointmentType: "Emergency",
          dateTime: "Wed 26 Aug 2020, 09:00 AM",
          status: "Completed",
        },
      ],
    };
  },
  methods: {
    getStatusClass(status) {
      switch (status) {
        case "Completed":
          return "status-badge status-completed";
        case "Rescheduled":
          return "status-badge status-rescheduled";
        case "Cancelled":
          return "status-badge status-cancelled";
        case "No Show":
          return "status-badge status-no-show";
        default:
          return "status-badge";
      }
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

.appointment-history-container {
  min-height: 100vh;
  background-color: #f9fafb;
  font-family: "Roboto", sans-serif;
}

.main-content {
  padding: 2rem;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
}

.toolbar {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.search-container {
  position: relative;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.search-input {
  padding: 0.5rem 1rem 0.5rem 2.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  width: 18rem;
  font-size: 0.875rem;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px #bfdbfe;
}

.filter-button,
.date-range-button {
  display: flex;
  align-items: center;
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  background-color: #ffffff;
  color: #374151;
  cursor: pointer;
  transition: background-color 0.2s;
}

.filter-button:hover,
.date-range-button:hover {
  background-color: #f9fafb;
}

.icon {
  font-size: 1.125rem;
}

.text {
  margin-left: 0.5rem;
}

.expand-icon {
  margin-left: 0.5rem;
}

.table-container {
  background-color: #ffffff;
  border-radius: 0.5rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  border: 1px solid #e5e7eb;
  overflow-x: auto;
}

.appointment-table {
  width: 100%;
  font-size: 0.875rem;
  text-align: left;
  color: #6b7280;
  border-collapse: collapse;
}

.appointment-table th {
  padding: 0.75rem 1.5rem;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  background-color: #f9fafb;
  color: #374151;
}

.appointment-table td {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.appointment-table tr:last-child td {
  border-bottom: none;
}

.appointment-table .last-row td {
  border-bottom: none;
}

.font-medium.text-gray-900 {
  font-weight: 500;
  color: #111827;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: 9999px;
}

.status-completed {
  color: #065f46;
  background-color: #d1fae5;
}

.status-rescheduled {
  color: #92400e;
  background-color: #fef3c7;
}

.status-cancelled {
  color: #991b1b;
  background-color: #fee2e2;
}

.status-no-show {
  color: #374151;
  background-color: #e5e7eb;
}

.action-cell {
  text-align: right;
  padding: 1rem 1.5rem;
}

.action-button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  color: #6b7280;
  transition: color 0.2s;
  padding: 0;
  margin: 0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.action-button:hover {
  color: #374151;
}

.pagination-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1.5rem;
}

.entry-info {
  font-size: 0.875rem;
  color: #374151;
}

.highlight {
  font-weight: 600;
  color: #111827;
}

.pagination-controls {
  display: flex;
  align-items: center;
}

.pagination-button {
  padding: 0.25rem 0.75rem;
  border: 1px solid #d1d5db;
  background-color: #ffffff;
  color: #374151;
  cursor: pointer;
  transition: background-color 0.2s;
  font-size: 0.875rem;
}

.pagination-button:first-child {
  border-top-left-radius: 0.5rem;
  border-bottom-left-radius: 0.5rem;
}

.pagination-button:last-child {
  border-top-right-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
}

.pagination-button:not(:first-child) {
  margin-left: -1px;
}

.pagination-button:hover:not(:disabled):not(.active) {
  background-color: #f3f4f6;
}

.pagination-button.active {
  background-color: #eff6ff;
  color: #2563eb;
  border-color: #dbeafe;
  z-index: 10;
}

.pagination-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.ellipsis {
  padding: 0.25rem 0.75rem;
  border: 1px solid #d1d5db;
  background-color: #ffffff;
  color: #6b7280;
  font-size: 0.875rem;
  margin-left: -1px;
}
</style>
