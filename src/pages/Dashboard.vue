<template>
  <div class="flex bg-white font-[Poppins] min-h-screen">
    <Sidebar :active="activeSection" @navigate="navigateTo" @logout="handleLogout" />
    <!-- Main content: pt-20 on mobile for header, ml-[90px] on desktop for sidebar -->
    <div class="flex-grow pt-20 md:pt-5 px-4 md:px-8 pb-5 bg-white ml-0 md:ml-[90px]">
      <TopBar :title="getTitle" :subtitle="getSubtitle" />
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from "../components/Sidebar.vue";
import TopBar from "../components/TopBar.vue";
import { useAuthStore } from "../stores/auth";

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
    async handleLogout() {
      const authStore = useAuthStore();
      await authStore.logout();
      this.$router.push('/');
    }
  },
};
</script>
