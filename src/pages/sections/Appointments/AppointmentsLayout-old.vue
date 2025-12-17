<template>
  <div class="app-wrapper">
    <AppointmentsNavigation
      @open-modal="showNewAppointmentModal = true"
      @logout="handleLogout"
    />
    <main class="main-content">
      <router-view></router-view>
    </main>

    <NewAppointment
      v-if="showNewAppointmentModal"
      :practitioners="practitioners"
      @close="showNewAppointmentModal = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import AppointmentsNavigation from "./Components/AppointmentsNavigation.vue";
import NewAppointment from "./Components/NewAppointment.vue";

const showNewAppointmentModal = ref(false);

const practitioners = ref([
  "Rob Perkowski",
  "Sam Clarke",
  "Carl Young",
  "David Rutherford",
  "James Harker",
]);

const router = useRouter();

// Programmatically navigate to the Scheduler route on component mount
onMounted(() => {
  router.push("/dashboard/appointments/scheduler");
});

const handleLogout = () => {
  // Add any necessary logout logic here (e.g., clearing a token)
  // localStorage.removeItem('authToken');

  // Redirect to the login page using the route name
  router.push({ name: "Login" });
};
</script>

<style scoped>
/*
 * Add the necessary CSS for the layout here. 
 * This CSS should be for the overall page structure, not the sidebar or modal.
 */
.app-wrapper {
  display: flex;
  height: 80vh;
  background-color: #f9fafb;
}

.main-content {
  flex: 1;
  overflow-y: auto;
  padding: 1.5rem;
}
</style>
