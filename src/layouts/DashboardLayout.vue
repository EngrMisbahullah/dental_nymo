<template>
  <div class="flex bg-white font-[Poppins] min-h-screen">
    <Sidebar :active="activeSection" @navigate="navigateTo" @logout="handleLogout" @toggle="handleSidebarToggle" />
    <!-- Main content: pt-20 on mobile for header, dynamic margin on desktop for sidebar -->
    <div class="flex-grow pt-20 md:pt-5 px-4 md:px-8 pb-5 bg-white ml-0 transition-all duration-300"
      :style="{ marginLeft: isMobile ? '0' : sidebarExpanded ? '240px' : '90px' }">
      <TopBar :title="getTitle" :subtitle="getSubtitle" :user="authStore?.user" />
      <router-view />
    </div>
  </div>
</template>

<script setup>

import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useRoute, useRouter } from "vue-router";
import Sidebar from "@/components/common/Sidebar.vue";
import TopBar from "@/components/common/TopBar.vue";
import { useAuthStore } from "@/stores/auth"; const sidebarExpanded = ref(false);
const isMobile = ref(false);

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const checkMobile = () => {
  isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
  checkMobile();
  window.addEventListener("resize", checkMobile);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", checkMobile);
});

const activeSection = computed(() => {
  return route.path.split("/")[2] || "dashboard";
});

const getTitle = computed(() => {
  switch (activeSection.value) {
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
      return "UDA Management (Units of Dental Activity)";
    case "pcm":
      return "Performer & Contract Management";
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
});

const getSubtitle = computed(() => {
  switch (activeSection.value) {
    case "dashboard":
      return "A quick data overview of the Dentistry.";
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
      return "UDA Management (Units of Dental Activity)";
    case "pcm":
      return "Performer & Contract Management";
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
});

const navigateTo = (section) => {
  router.push(`/dashboard/${section === "dashboard" ? "" : section}`);
};

const handleLogout = async () => {
  await authStore.logout();
  window.location.href = "/";
};

const handleSidebarToggle = (expanded) => {
  sidebarExpanded.value = expanded;
};

</script>

