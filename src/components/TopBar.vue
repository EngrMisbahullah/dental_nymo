<template>
  <div class="flex justify-between items-center flex-wrap gap-4">
    <!-- Title Section -->
    <div class="min-w-0 flex-1">
      <div class="font-semibold text-xl md:text-[28px] font-[Poppins] text-[#303030] truncate">{{ title }}</div>
      <div class="font-bold text-sm md:text-base font-[Poppins] text-primary hidden sm:block">{{ subtitle }}</div>
    </div>
    
    <!-- User Section -->
    <div class="flex items-center gap-2 md:gap-3">
      <div class="text-right hidden sm:block">
        <div class="font-medium text-gray-800 text-sm md:text-base">Dr Joseph Smith</div>
        <div class="text-xs md:text-sm text-gray-500">Super Admin</div>
      </div>
      <img 
        src="https://randomuser.me/api/portraits/men/75.jpg" 
        class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "TopBar",
  props: {
    title: String,
    subtitle: String,
  },
};
</script>
