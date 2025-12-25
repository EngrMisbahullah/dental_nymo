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
  <div 
    :class="[
      'hidden md:flex fixed top-0 left-0 h-screen bg-card flex-col shadow-[2px_0_8px_rgba(0,0,0,0.05)] z-[1000] transition-all duration-300',
      expanded ? 'w-[240px]' : 'w-[90px]'
    ]"
  >
    <!-- Toggle Button -->
    <button 
      @click="toggleSidebar"
      class="absolute -right-3 top-20 w-6 h-6 bg-purple-accent text-white rounded-full flex items-center justify-center shadow-md hover:bg-purple-700 transition-colors z-10 cursor-pointer"
    >
      <i :class="expanded ? 'fas fa-chevron-left' : 'fas fa-chevron-right'" class="text-xs"></i>
    </button>

    <!-- Scrollable icons area -->
    <div class="flex-1 flex flex-col pt-8 overflow-y-auto scrollbar-hide" :class="expanded ? 'items-start px-4' : 'items-center'">
      <!-- Logo -->
      <div class="mb-10" :class="expanded ? 'px-2' : ''">
        <img src="/logo/logo.svg" alt="logo" class="w-9" />
      </div>

      <!-- Navigation Icons -->
      <div
        v-for="item in navItems"
        :key="item.key"
        :class="[
          'cursor-pointer my-1 flex items-center rounded-xl transition-all duration-300 hover:bg-gray-200',
          expanded ? 'w-full px-3 py-2.5 gap-3' : 'p-3 w-11 h-11 justify-center',
          active === item.key ? 'bg-purple-accent !text-white hover:!bg-purple-700' : 'text-gray-500'
        ]"
        @click="$emit('navigate', item.key)"
        :title="!expanded ? item.label : ''"
      >
        <i :class="[item.icon, expanded ? 'w-5' : '']" class="text-lg"></i>
        <span 
          v-if="expanded" 
          class="text-sm font-medium whitespace-nowrap overflow-hidden"
        >
          {{ item.label }}
        </span>
      </div>
    </div>

    <!-- Footer with logout -->
    <div class="flex flex-col py-5" :class="expanded ? 'items-start px-4' : 'items-center'">
      <div
        :class="[
          'cursor-pointer flex items-center rounded-xl transition-all duration-300 hover:bg-gray-200 text-gray-500',
          expanded ? 'w-full px-3 py-2.5 gap-3' : 'p-3 w-11 h-11 justify-center'
        ]"
        @click="$emit('logout')"
        :title="!expanded ? 'Logout' : ''"
      >
        <i class="fas fa-sign-out-alt text-lg" :class="expanded ? 'w-5' : ''"></i>
        <span v-if="expanded" class="text-sm font-medium">Logout</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["active"],
  emits: ["navigate", "logout", "toggle"],
  data() {
    return {
      mobileMenuOpen: false,
      expanded: false,
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
    },
    toggleSidebar() {
      this.expanded = !this.expanded;
      this.$emit('toggle', this.expanded);
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





