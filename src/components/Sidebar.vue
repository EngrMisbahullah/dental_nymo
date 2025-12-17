<template>
  <div class="sidebar">
    <div class="sidebar-scroll">
      <div class="sidebar-logo">
        <img src="/logo/logo.svg" alt="logo" />
      </div>

      <i
        class="fas fa-table-columns"
        :class="{ active: active === 'dashboard' }"
        @click="$emit('navigate', 'dashboard')"
        title="Dashboard"
      ></i>
      <i
        class="fas fa-user-friends"
        :class="{ active: active === 'patients' }"
        @click="$emit('navigate', 'patients')"
        title="Patient Records"
      ></i>
      <i
        class="fas fa-calendar-alt"
        :class="{ active: active === 'appointments' }"
        @click="$emit('navigate', 'appointments')"
        title="Appointments Calendar"
      ></i>
      <i
        class="fas fa-chart-pie"
        :class="{ active: active === 'chart' }"
        @click="$emit('navigate', 'chart')"
        title="Chart"
      ></i>
      <i
        class="fas fa-book"
        :class="{ active: active === 'notes' }"
        @click="$emit('navigate', 'notes')"
        title="Clinical Notes"
      ></i>
      <i
        class="fas fa-credit-card"
        :class="{ active: active === 'private-treatment-invoicing' }"
        @click="$emit('navigate', 'private-treatment-invoicing')"
        title="Private Treatment & Invoicing"
      ></i>
      <i
        class="fas fa-receipt"
        :class="{ active: active === 'claims' }"
        @click="$emit('navigate', 'claims')"
        title="NHS FP17 Claims (EDI Submission)"
      ></i>
      <i
        class="fas fa-bullseye"
        :class="{ active: active === 'uda' }"
        @click="$emit('navigate', 'uda')"
        title="UDA Management (Units of Dental Activity)"
      ></i>
      <i
        class="fas fa-file-contract"
        :class="{ active: active === 'pcm' }"
        @click="$emit('navigate', 'pcm')"
        title="Performer & Contract Management"
      ></i>
      <i
        class="fas fa-vial"
        :class="{ active: active === 'lab' }"
        @click="$emit('navigate', 'lab')"
        title="Lab & Referral Workflow"
      ></i>
      <i
        class="fas fa-people-group"
        :class="{ active: active === 'family' }"
        @click="$emit('navigate', 'family')"
        title="Family Management"
      ></i>
      <i
        class="fas fa-camera"
        :class="{ active: active === 'imaging' }"
        @click="$emit('navigate', 'imaging')"
        title="Imaging & X-Rays"
      ></i>
      <i
        class="fas fa-folder-open"
        :class="{ active: active === 'files' }"
        @click="$emit('navigate', 'files')"
        title="File Storage"
      ></i>
      <i
        class="fas fa-user-md"
        :class="{ active: active === 'staff' }"
        @click="$emit('navigate', 'staff')"
        title="Staff Management"
      ></i>
      <i
        class="fas fa-boxes-stacked"
        :class="{ active: active === 'reports' }"
        @click="$emit('navigate', 'reports')"
        title="Reports"
      ></i>
    </div>

    <div class="sidebar-footer">
      <i class="fas fa-sign-out-alt" title="Logout" @click="$emit('logout')"></i>
    </div>
  </div>
</template>

<script>
export default {
  props: ["active"],
  emits: ["navigate", "logout"],
};
</script>

<style scoped>
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 90px;
  height: 100vh;
  background: #f3f5f7;
  display: flex;
  flex-direction: column;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
  z-index: 1000;
}

/* Scrollable but hidden scrollbar */
.sidebar-scroll {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 30px;
  overflow-y: auto;

  /* Hide scrollbar in Firefox */
  scrollbar-width: none;
  /* Hide scrollbar in IE/Edge */
  -ms-overflow-style: none;
}

/* Hide scrollbar in Chrome/Safari/Edge */
.sidebar-scroll::-webkit-scrollbar {
  display: none;
}

.sidebar-logo img {
  width: 36px;
  margin-bottom: 40px;
}

.sidebar i {
  font-size: 18px;
  cursor: pointer;
  margin: 10px 0;
  color: #6a6969;
  padding: 12px;
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.sidebar i.active {
  background-color: #4b3c97;
  color: #fff;
}

.sidebar-footer {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 30px;
  padding: 20px 0;
}
</style>
