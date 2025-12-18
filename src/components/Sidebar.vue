<template>
  <!-- Mobile Header Bar -->
  <div class="md:hidden fixed top-0 left-0 right-0 h-16 bg-card flex items-center justify-between px-4 shadow-sm z-[1001]">
    <img src="/logo/logo.svg" alt="logo" class="w-8" />
    <button 
      @click="toggleMobileMenu"
      class="p-2 rounded-lg hover:bg-gray-200 transition-colors"
    >
      <i :class="mobileMenuOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-xl text-gray-600"></i>
    </button>
  </div>

  <!-- Mobile Slide-out Menu -->
  <div 
    v-if="mobileMenuOpen"
    class="md:hidden fixed inset-0 bg-black/50 z-[1000]"
    @click="closeMobileMenu"
  ></div>
  
  <div 
    :class="[
      'md:hidden fixed top-16 right-0 w-72 h-[calc(100vh-64px)] bg-white shadow-xl z-[1001] transform transition-transform duration-300 overflow-y-auto',
      mobileMenuOpen ? 'translate-x-0' : 'translate-x-full'
    ]"
  >
    <nav class="py-4">
      <div
        v-for="item in navItems"
        :key="item.key"
        :class="[
          'flex items-center gap-3 px-4 py-3 cursor-pointer transition-colors',
          active === item.key ? 'bg-purple-accent text-white' : 'text-gray-600 hover:bg-gray-100'
        ]"
        @click="handleNavigate(item.key)"
      >
        <i :class="item.icon" class="text-lg w-6"></i>
        <span class="text-sm font-medium">{{ item.label }}</span>
      </div>
      
      <!-- Logout in mobile menu -->
      <div class="border-t border-gray-200 mt-4 pt-4">
        <div
          class="flex items-center gap-3 px-4 py-3 cursor-pointer text-red-500 hover:bg-red-50 transition-colors"
          @click="handleLogout"
        >
          <i class="fas fa-sign-out-alt text-lg w-6"></i>
          <span class="text-sm font-medium">Logout</span>
        </div>
      </div>
    </nav>
  </div>

  <!-- Desktop Sidebar -->
  <div class="hidden md:flex fixed top-0 left-0 w-[90px] h-screen bg-card flex-col shadow-[2px_0_8px_rgba(0,0,0,0.05)] z-[1000]">
    <!-- Scrollable icons area -->
    <div class="flex-1 flex flex-col items-center pt-8 overflow-y-auto scrollbar-hide">
      <!-- Logo -->
      <div class="mb-10">
        <img src="/logo/logo.svg" alt="logo" class="w-9" />
      </div>

      <!-- Navigation Icons -->
      <i
        v-for="item in navItems"
        :key="item.key"
        :class="[
          item.icon,
          'text-lg cursor-pointer my-2.5 text-gray-500 p-3 w-11 h-11 flex items-center justify-center rounded-xl transition-all duration-300 hover:bg-gray-200',
          { 'bg-purple-accent !text-white': active === item.key }
        ]"
        @click="$emit('navigate', item.key)"
        :title="item.label"
      ></i>
    </div>

    <!-- Footer with logout -->
    <div class="flex flex-col items-center gap-8 py-5">
      <i 
        class="fas fa-sign-out-alt text-lg cursor-pointer my-2.5 text-gray-500 p-3 w-11 h-11 flex items-center justify-center rounded-xl transition-all duration-300 hover:bg-gray-200" 
        title="Logout" 
        @click="$emit('logout')"
      ></i>
    </div>
  </div>
</template>

<script>
export default {
  props: ["active"],
  emits: ["navigate", "logout"],
  data() {
    return {
      mobileMenuOpen: false,
      navItems: [
        { key: 'dashboard', icon: 'fas fa-table-columns', label: 'Dashboard' },
        { key: 'patients', icon: 'fas fa-user-friends', label: 'Patient Records' },
        { key: 'appointments', icon: 'fas fa-calendar-alt', label: 'Appointments' },
        { key: 'chart', icon: 'fas fa-chart-pie', label: 'Chart' },
        { key: 'notes', icon: 'fas fa-book', label: 'Clinical Notes' },
        { key: 'private-treatment-invoicing', icon: 'fas fa-credit-card', label: 'Private Treatment & Invoicing' },
        { key: 'claims', icon: 'fas fa-receipt', label: 'NHS FP17 Claims' },
        { key: 'uda', icon: 'fas fa-bullseye', label: 'UDA Management' },
        { key: 'pcm', icon: 'fas fa-file-contract', label: 'Performer & Contract' },
        { key: 'lab', icon: 'fas fa-vial', label: 'Lab & Referral' },
        { key: 'family', icon: 'fas fa-people-group', label: 'Family Management' },
        { key: 'imaging', icon: 'fas fa-camera', label: 'Imaging & X-Rays' },
        { key: 'files', icon: 'fas fa-folder-open', label: 'File Storage' },
        { key: 'staff', icon: 'fas fa-user-md', label: 'Staff Management' },
        { key: 'reports', icon: 'fas fa-boxes-stacked', label: 'Reports' },
      ]
    };
  },
  methods: {
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
    },
    closeMobileMenu() {
      this.mobileMenuOpen = false;
    },
    handleNavigate(key) {
      this.$emit('navigate', key);
      this.closeMobileMenu();
    },
    handleLogout() {
      this.$emit('logout');
      this.closeMobileMenu();
    }
  }
};
</script>

<style scoped>
/* Hide scrollbar */
.scrollbar-hide {
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
