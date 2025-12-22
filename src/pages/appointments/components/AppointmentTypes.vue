<template>
  <div class="appointment-types-container">
    <header class="page-header">
      <h1 class="page-title">Appointment Types</h1>
      <button class="new-appointment-button">
        <span class="material-icons icon">add</span>
        New Appointment Type
      </button>
    </header>
    <div class="table-card">
      <table class="appointment-types-table">
        <thead class="table-header">
          <tr>
            <th scope="col">Type</th>
            <th scope="col">Duration</th>
            <th scope="col">Price</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody class="table-body">
          <tr v-for="(type, index) in appointmentTypes" :key="index">
            <td>
              <div class="type-info">
                <div :class="getTypeColorClass(type.type)"></div>
                <p class="type-name">{{ type.type }}</p>
              </div>
            </td>
            <td>
              <p>{{ type.duration }}</p>
            </td>
            <td>
              <p>{{ type.price }}</p>
            </td>
            <td class="action-cell">
              <button class="action-button">
                <span class="material-icons">more_vert</span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  name: "AppointmentTypes",
  data() {
    return {
      appointmentTypes: [
        { type: "Emergency", duration: "30 mins", price: "$150" },
        { type: "Private Patients only", duration: "1 hour", price: "$250" },
        { type: "Check-up & Polish", duration: "45 mins", price: "$180" },
        { type: "Blocked", duration: "Variable", price: "-" },
        { type: "NHS Patients", duration: "30 mins", price: "Covered" },
        { type: "Zoom", duration: "1 hour 30 mins", price: "$500" },
      ],
    };
  },
  methods: {
    getTypeColorClass(type) {
      const colorMap = {
        Emergency: "bg-red-500",
        "Private Patients only": "bg-yellow-400",
        "Check-up & Polish": "bg-purple-400",
        Blocked: "bg-gray-400",
        "NHS Patients": "bg-green-400",
        Zoom: "bg-green-500",
      };
      return `color-dot ${colorMap[type]}`;
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

.appointment-types-container {
  padding: 2rem;
  background-color: #f9fafb;
  min-height: 100vh;
  font-family: "Roboto", sans-serif;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.page-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
}

.new-appointment-button {
  display: flex;
  align-items: center;
  background-color: #2563eb;
  color: #ffffff;
  font-weight: 700;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}

.new-appointment-button:hover {
  background-color: #1d4ed8;
}

.icon {
  margin-right: 0.5rem;
}

.table-card {
  background-color: #ffffff;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border-radius: 0.5rem;
  overflow: hidden;
}

.appointment-types-table {
  width: 100%;
  border-collapse: collapse;
}

.table-header {
  background-color: #f3f4f6;
}

.appointment-types-table th {
  padding: 0.75rem 1.25rem;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 600;
  color: #4b5563;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 2px solid #e5e7eb;
}

.table-body tr {
  border-bottom: 1px solid #e5e7eb;
}

.table-body tr:last-child {
  border-bottom: none;
}

.appointment-types-table td {
  padding: 1.25rem;
  font-size: 0.875rem;
  color: #4b5563;
  white-space: nowrap;
}

.type-info {
  display: flex;
  align-items: center;
}

.color-dot {
  width: 1rem;
  height: 1rem;
  border-radius: 9999px;
  margin-right: 0.75rem;
}

.type-name {
  color: #1f2937;
  white-space: nowrap;
}

.action-cell {
  text-align: right;
}

.action-button {
  color: #6b7280;
  transition: color 0.2s;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
}

.action-button:hover {
  color: #4b5563;
}

/* Specific color classes from Tailwind */
.bg-red-500 {
  background-color: #ef4444;
}
.bg-yellow-400 {
  background-color: #facc15;
}
.bg-purple-400 {
  background-color: #a78bfa;
}
.bg-gray-400 {
  background-color: #9ca3af;
}
.bg-green-400 {
  background-color: #4ade80;
}
.bg-green-500 {
  background-color: #22c55e;
}
</style>
