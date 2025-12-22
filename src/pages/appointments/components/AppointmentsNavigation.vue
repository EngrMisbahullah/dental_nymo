<template>
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2 class="sidebar-title">Appointments</h2>
    </div>
    <nav class="sidebar-nav">
      <router-link
        to="/dashboard/appointments/scheduler"
        class="nav-item"
        active-class="active"
      >
        <span class="material-icons">schedule</span>
        <span>Scheduler</span>
      </router-link>
      <router-link
        to="/dashboard/appointments/history"
        class="nav-item"
        active-class="active"
      >
        <span class="material-icons">history</span>
        <span>Appointment History</span>
      </router-link>
      <router-link
        to="/dashboard/appointments/communication"
        class="nav-item"
        active-class="active"
      >
        <span class="material-icons">chat_bubble_outline</span>
        <span>Patient Communication</span>
      </router-link>
      <router-link
        to="/dashboard/appointments/billing"
        class="nav-item"
        active-class="active"
      >
        <span class="material-icons">receipt_long</span>
        <span>Billing Information</span>
      </router-link>
      <router-link
        to="/dashboard/appointments/waiting-list"
        class="nav-item"
        active-class="active"
      >
        <span class="material-icons">people_alt</span>
        <span>Waiting List</span>
      </router-link>
      <router-link
        to="/dashboard/appointments/types"
        class="nav-item"
        active-class="active"
      >
        <span class="material-icons">palette</span>
        <span>Appointment Types</span>
      </router-link>
    </nav>
    <div class="sidebar-footer">
      <button class="new-appointment-btn" @click="$emit('open-modal')">
        <span class="material-icons">add</span> New Appointment
      </button>
    </div>
  </aside>
</template>

<script setup>

const emits = defineEmits(["open-modal"]);
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

.sidebar {
  width: 256px;
  background-color: #ffffff;
  border-right: 1px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.sidebar-header {
  padding: 1rem;
  border-bottom: 1px solid #e5e7eb;
}

.sidebar-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #2563eb;
  margin: 0;
}

.sidebar-nav {
  flex-grow: 1;
  padding: 1rem 0;
}

.nav-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  color: #4b5563;
  text-decoration: none;
  transition: background-color 0.2s;
  border-left: 4px solid transparent;
}

.nav-item:hover {
  background-color: #f3f4f6;
}

.nav-item.active {
  background-color: #e2e8f0;
  border-left-color: #3b82f6;
  font-weight: 600;
  color: #1f2937;
}

.nav-item .material-icons {
  margin-right: 0.75rem;
}

.sidebar-footer {
  padding: 1rem;
  border-top: 1px solid #e5e7eb;
}

.new-appointment-btn {
  width: 100%;
  background-color: #2563eb;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  font-weight: 500;
  transition: background-color 0.2s;
}

.new-appointment-btn:hover {
  background-color: #1d4ed8;
}

.new-appointment-btn .material-icons {
  margin-right: 0.5rem;
}
</style>
