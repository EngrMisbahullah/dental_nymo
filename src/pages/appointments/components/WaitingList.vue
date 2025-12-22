<template>
  <div class="waiting-list-container">
    <header class="page-header">
      <h1 class="page-title">Waiting List</h1>
      <div class="header-toolbar">
        <div class="search-container">
          <span class="material-icons search-icon">search</span>
          <input class="search-input" placeholder="Search" type="text" />
        </div>
        <button class="add-button">
          <span class="material-icons icon">add</span>
          <span>Add to waiting list</span>
        </button>
      </div>
    </header>
    <div class="table-card">
      <table class="waiting-list-table">
        <thead class="table-header">
          <tr>
            <th scope="col">Patient Name</th>
            <th scope="col">Treatment Plan</th>
            <th scope="col">Priority</th>
            <th scope="col">Practitioner</th>
            <th scope="col">Added to list</th>
            <!-- <th scope="col"></th> -->
          </tr>
        </thead>
        <tbody class="table-body">
          <tr v-for="(patient, index) in waitingList" :key="index">
            <td>
              <div class="patient-info">
                <div class="patient-avatar">
                  <img
                    :alt="patient.patientName + ' avatar'"
                    class="avatar-img"
                    :src="patient.avatar"
                  />
                </div>
                <div class="patient-details">
                  <div class="patient-name">{{ patient.patientName }}</div>
                  <div class="patient-email">{{ patient.email }}</div>
                </div>
              </div>
            </td>
            <td>{{ patient.treatmentPlan }}</td>
            <td>
              <span :class="getPriorityClass(patient.priority)">
                {{ patient.priority }}
              </span>
            </td>
            <td>{{ patient.practitioner }}</td>
            <td>{{ patient.addedToList }}</td>
            <!-- <td class="action-cell">
              <a class="action-link" href="#">Book Appointment</a>
            </td> -->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "WaitingList",
  data() {
    return {
      waitingList: [
        {
          patientName: "Jane Cooper",
          email: "jane.cooper@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuAO6JbidP2lZDEZWC6gocn83INlsoCTxB398FwGMm5orqJozUf4NXmIy8D29ckr_yE2QZ1AXXUqfirbg7WnlA_wXuH8op3dvLduHRS_osrPhx588o4yhBB3lWLpY23cRO_6aoE9rCG2wMNJBccTgYoOhQIIZ_qoDxLh3fKFprZa3px830FrpifLn1XdikvKpnc__bTxTlOkriwe3siBgoOLB0zBG7OXMlUUpASmlaEJWyzebSIf-8uVir-_G3e9c7eCYQlYIQIgnOwN",
          treatmentPlan: "Check-up",
          priority: "High",
          practitioner: "Dr. Rob Perkowski",
          addedToList: "28/08/2020",
        },
        {
          patientName: "Cody Fisher",
          email: "cody.fisher@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuAkbIZ_xE_W1--L4HACttq1O8NM41LDCWn4mX8eUFb49PnpbnpLDCZtQ2Wte6OwWlTeSEUx90E1hnqqKEOwlRsCZbbjHfCy-HRueRENpWN2pB-biQ4n_y22Ac3CauvShPA1CLjbPuZVJehdDNkQhvl_gVJlYOZpYay3nWNZLfMSaS_EK0VUt7M4C-u-pcxPlvjfLsFWZ9Bx-r_w3dWpH08fJ5Oiw0yovNg7Cgd7AqHerUyryqeGaIqTjmB6Zupbn_2ZEm7C-g60Neqc",
          treatmentPlan: "Crown Preparation",
          priority: "Medium",
          practitioner: "Dr. Sam Clarke",
          addedToList: "27/08/2020",
        },
        {
          patientName: "Esther Howard",
          email: "esther.howard@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuCXi6_-ywwqZXp2ENYJWI5tR44TuYhutoNrdwY-MV5qBmv4EfktWUTZJz3Px-s7jIZVtMcffF1QOjhg6SA-093wLyhRXwSYQKjO4OSsjePo2RL2dGMdyBOeKrFSoDh-Aa0ZPRsoH8Okevv3mLL_yw5Dbxmd9WLc9IR_vCw8cPeaRT2uwHoCXOax8h-M1FoxWTkxlMQOi6E1GFsD7rzpruUWtGUeKhQmsFX4CdGjDCgTCLWwKF_-l8_dj_hrTuOhWaFKxzC-CKASr5pB",
          treatmentPlan: "Scale & Polish",
          priority: "Low",
          practitioner: "Dr. Carl Young",
          addedToList: "27/08/2020",
        },
        {
          patientName: "Kristin Watson",
          email: "kristin.watson@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuDFkktpPOKFMueByGNaNxZvFlxweI-WLwuTFGOME7ry23T_NnGdcHHMXsy8YyC9YJUUXOqpag8-jvlUQ5y8Sj8pCmbQSWeKIJzGauZgoScmwfTP2UtQ8RL42b91r7cisL5vEIC7_I6hjBox_atdW60D3wW5D0Uv1ojCOOZJLkuUSnO_vh7kqX4NwEGKa836p05QlGmofCLb9GfgbEsfHeiBcRMlX-6KYRjRBW_jxTn2zDxgFntX6Knv2SQPwB1P61eT3m0CfMH1MAo3",
          treatmentPlan: "White Filling",
          priority: "Medium",
          practitioner: "Dr. David Rutherford",
          addedToList: "26/08/2020",
        },
        {
          patientName: "Cameron Williamson",
          email: "cameron.williamson@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuD-zHF6D1w0nxf4Lu29wPNALRnrHNTK25QKDyXlZ17PuKzPVa739CsZmcyTR5waDRWgHdS_ypcLeH7n67N84tePe6stXmP07rUDNvDAeTPh9gsMzIH4FgOlM9qZ1c_Gh8Stwm4tHKSHZxH8pLu__O3ONDrjL5J7mcjjxzckRe16FycbE9HNcI7vA-_BDRuI1hSUlAKU7uStXUYLl4Fq6qOKECfS4_yPAdvctGJ0PZ_E15OMLwjsaNibdk3i3Y5W2MDF6M5s6Uf1PF-F",
          treatmentPlan: "NHS Check-up",
          priority: "Low",
          practitioner: "Dr. James Harker",
          addedToList: "25/08/2020",
        },
      ],
    };
  },
  methods: {
    getPriorityClass(priority) {
      switch (priority) {
        case "High":
          return "priority-badge priority-high";
        case "Medium":
          return "priority-badge priority-medium";
        case "Low":
          return "priority-badge priority-low";
        default:
          return "priority-badge";
      }
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

.waiting-list-container {
  padding: 2rem;
  background-color: #f9fafb;
  min-height: 100vh;
  font-family: "Roboto", sans-serif;
  box-sizing: border-box; /* Ensures padding is included in the total width */
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  flex-wrap: wrap; /* Allows header items to wrap on smaller screens */
  gap: 1rem;
}

.page-title {
  font-size: 1.875rem;
  font-weight: 700;
  color: #1f2937;
}

.header-toolbar {
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
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.search-input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.add-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #2563eb;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}

.add-button:hover {
  background-color: #1d4ed8;
}

.icon {
  font-size: 1.25rem;
}

.table-card {
  background-color: #ffffff;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  overflow-x: auto; /* in case content overflows */
  width: 100%;
}

.waiting-list-table {
  width: 100%; /* full width of card */
  border-collapse: collapse;
  table-layout: fixed; /* This is the key change to control column width */
}

.table-header {
  background-color: #f3f4f6;
  border-bottom: 1px solid #e5e7eb;
}

.waiting-list-table th {
  padding: 0.75rem 1.5rem;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 500;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.table-body tr {
  border-bottom: 1px solid #e5e7eb;
}

.table-body tr:last-child {
  border-bottom: none;
}

.waiting-list-table td {
  padding: 1rem 1.5rem;
  font-size: 0.875rem;
  color: #6b7280;
  white-space: nowrap;
  overflow: hidden; /* Added to hide overflowing content */
  text-overflow: ellipsis; /* Added to show ellipsis for truncated text */
}

/* Adjusting column widths for better fit */
.waiting-list-table th:nth-child(1),
.waiting-list-table td:nth-child(1) {
  width: 25%;
}

.waiting-list-table th:nth-child(2),
.waiting-list-table td:nth-child(2) {
  width: 20%;
}

.waiting-list-table th:nth-child(3),
.waiting-list-table td:nth-child(3) {
  width: 10%;
}

.waiting-list-table th:nth-child(4),
.waiting-list-table td:nth-child(4) {
  width: 20%;
}

.waiting-list-table th:nth-child(5),
.waiting-list-table td:nth-child(5) {
  width: 15%;
}

.waiting-list-table th:nth-child(6),
.waiting-list-table td:nth-child(6) {
  width: 10%;
  text-align: right;
}

.patient-info {
  display: flex;
  align-items: center;
}

.patient-avatar {
  flex-shrink: 0;
  height: 2.5rem;
  width: 2.5rem;
  margin-right: 1rem;
}

.avatar-img {
  height: 100%;
  width: 100%;
  border-radius: 9999px;
  object-fit: cover;
}

.patient-name {
  font-weight: 500;
  color: #1f2937;
}

.patient-email {
  color: #6b7280;
}

.priority-badge {
  display: inline-flex;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: 9999px;
}

.priority-high {
  background-color: #fee2e2;
  color: #991b1b;
}

.priority-medium {
  background-color: #fef3c7;
  color: #92400e;
}

.priority-low {
  background-color: #d1fae5;
  color: #065f46;
}

.action-cell {
  text-align: right;
  min-width: 150px; /* Ensures link doesn't wrap */
}

.action-link {
  color: #2563eb;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s;
}

.action-link:hover {
  color: #1e40af;
}
</style>
