<template>
  <div class="dashboard-container">
    <Sidebar :active="activeSection" @navigate="navigateTo" />
    <div class="main">
      <TopBar :title="getTitle" :subtitle="getSubtitle" />
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from "../components/Sidebar.vue";
import TopBar from "../components/TopBar.vue";

export default {
  components: {
    Sidebar,
    TopBar,
  },
  computed: {
    activeSection() {
      return this.$route.path.split("/")[2] || "dashboard";
    },
    getTitle() {
      switch (this.activeSection) {
        case "dashboard":
          return "Dashboard";
        case "patients":
          return "Patients";
        case "appointments":
          return "Appointments";
        case "chart":
          return "Chart";
        case "notes":
          return "Clinical Notes & Treatment Plan";
        case "private-treatment-invoicing":
          return "Private Treatment & Invoicing";
        case "claims":
          return "NHS FP17 Claims (EDI Submission)";
        case "uda":
          return " UDA Management (Units of Dental Activity)";
        case "pcm":
          return " Performer & Contract Management";
        case "lab":
          return "Lab & Referral Workflow";
        case "family":
          return "Family Management";
        case "imaging":
          return "Imaging & X-Rays";
        case "files":
          return "File Storage";
        case "staff":
          return "Staff Management";
        case "reports":
          return "Reports";
        default:
          return "";
      }
    },
    getSubtitle() {
      switch (this.activeSection) {
        case "dashboard":
          return "A quick data overview of the Dentistry .";
        case "patients":
          return "Patient Records";
        case "appointments":
          return "Appointments Calendar";
        case "chart":
          return "Analytics & Charts";
        case "notes":
          return "Clinical Notes & Treatment Plan";
        case "private-treatment-invoicing":
          return "Private Treatment & Invoicing";
        case "claims":
          return "NHS FP17 Claims (EDI Submission)";
        case "uda":
          return " UDA Management (Units of Dental Activity)";
        case "pcm":
          return " Performer & Contract Management";
        case "lab":
          return "Lab & Referral Workflow";
        case "family":
          return "Manage family relationships and shared accounts";
        case "imaging":
          return "Manage dental images, X-rays, and scans";
        case "files":
          return "Manage your files";
        case "staff":
          return "Staff Management";
        case "reports":
          return "Generate and view reports";
        default:
          return "";
      }
    },
  },
  methods: {
    navigateTo(section) {
      this.$router.push(`/dashboard/${section === "dashboard" ? "" : section}`);
    },
  },
};
</script>

<style scoped>
.dashboard-container {
  display: flex;
  background: white; /* Changed to match sidebar background */
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  min-height: 100vh; /* Ensure it takes at least the full viewport height */
}

.main {
  flex-grow: 1;
  padding: 20px 30px;
  background: white; /* Changed to match sidebar background */
  margin-left: 90px; /* This margin now handles the spacing for the fixed sidebar */
}
.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.title {
  font: 600 28px Poppins;
  color: #303030;
}
.subtitle {
  font: bold 16px Poppins;
  color: #34d8d1;
}
.user {
  display: flex;
  align-items: center;
  gap: 12px;
}
.user img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}
.search-row {
  display: flex;
  gap: 10px;
  margin: 20px 0;
}
.search-row input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
}
.search-row button {
  display: flex;
  align-items: center;
  gap: 6px;
  background-color: #fff;
  border: 1px solid #ddd;
  padding: 10px 16px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
  border-radius: 6px;
  cursor: pointer;
}
.cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin: 30px 0;
}
.card {
  padding: 20px;
  border-radius: 12px;
  color: #fff;
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.icon-wrapper i {
  font-size: 32px;
}
.card-content .value {
  font: bold 37px Poppins;
}
.card-content .label {
  font: 600 19px Poppins;
}
.card.good {
  background: #34d8d1;
}
.card.revenue {
  background: #34a7d8;
}
.card.available {
  background: #34d899;
}
.card.shortage {
  background: #d69759;
}
.grid-section {
  background: #f3f5f7;
  padding: 30px;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}
.sub-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}
.subcard-header {
  background: #fff;
  padding: 20px 24px;
  font-weight: 600;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #6a6969;
}
.config-link {
  font-size: 12px;
  color: #00a6a6;
  text-decoration: none;
  font-weight: 500;
}
.subcard-body {
  background: #f3f5f7;
  padding: 20px 24px;
  display: flex;
  align-items: center;
  gap: 24px;
}
.stat-icon i {
  font-size: 32px;
  color: #4b3c97;
}
.stat-info {
  display: flex;
  justify-content: space-between;
  flex: 1;
}
.stat-block {
  display: flex;
  flex-direction: column;
}
.stat-label {
  font-size: 14px;
  color: #666;
}
.stat-value {
  font-size: 18px;
  font-weight: 600;
  color: #333;
}
.tag {
  margin-top: 12px;
  color: #007bff;
  font-weight: 600;
}
</style>
