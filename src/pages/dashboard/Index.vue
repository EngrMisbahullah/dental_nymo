<template>
  <div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 my-6 md:my-8">
      <!-- Good Status Card -->
      <div class="p-4 md:p-5 rounded-xl text-white flex flex-col gap-3 md:gap-5 bg-primary">
        <div><i class="fas fa-shield-alt text-2xl md:text-3xl"></i></div>
        <div>
          <div class="font-bold text-2xl md:text-4xl font-[Poppins]">Good</div>
          <div class="font-semibold text-base md:text-lg font-[Poppins]">Inventory Status</div>
        </div>
      </div>
      
      <!-- Revenue Card -->
      <div class="p-4 md:p-5 rounded-xl text-white flex flex-col gap-3 md:gap-5 bg-revenue">
        <div><i class="fas fa-money-bill-wave text-2xl md:text-3xl"></i></div>
        <div>
          <div class="font-bold text-2xl md:text-4xl font-[Poppins]">£8,55,875</div>
          <div class="font-semibold text-base md:text-lg font-[Poppins]">Revenue: May</div>
        </div>
      </div>
      
      <!-- Available Card -->
      <div class="p-4 md:p-5 rounded-xl text-white flex flex-col gap-3 md:gap-5 bg-available">
        <div><i class="fas fa-capsules text-2xl md:text-3xl"></i></div>
        <div>
          <div class="font-bold text-2xl md:text-4xl font-[Poppins]">298</div>
          <div class="font-semibold text-base md:text-lg font-[Poppins]">Medicines Available</div>
        </div>
      </div>
      
      <!-- Shortage Card -->
      <div class="p-4 md:p-5 rounded-xl text-white flex flex-col gap-3 md:gap-5 bg-shortage">
        <div><i class="fas fa-exclamation-triangle text-2xl md:text-3xl"></i></div>
        <div>
          <div class="font-bold text-2xl md:text-4xl font-[Poppins]">01</div>
          <div class="font-semibold text-base md:text-lg font-[Poppins]">Medicine Shortage</div>
        </div>
      </div>
    </div>

    <!-- Grid Section -->
    <div class="bg-card p-4 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 rounded-xl">
      <!-- Inventory Sub-card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-white px-4 md:px-6 py-4 md:py-5 font-semibold flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-gray-500">
          <span>Inventory</span>
          <a class="text-xs text-primary-dark no-underline font-medium cursor-pointer hover:underline">Go to Configuration »</a>
        </div>
        <div class="bg-card px-4 md:px-6 py-4 md:py-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 md:gap-6">
          <div><i class="fas fa-pills text-2xl md:text-3xl text-revenue"></i></div>
          <div class="flex flex-col sm:flex-row justify-between flex-1 gap-4 w-full">
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">298</span>
              <span class="text-sm md:text-[15px] text-gray-800">Total no of Medicines</span>
            </div>
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">24</span>
              <span class="text-sm md:text-[15px] text-gray-800">Medicine Groups</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Report Sub-card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-white px-4 md:px-6 py-4 md:py-5 font-semibold flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-gray-500">
          <span>Quick Report</span>
          <a class="text-xs text-primary-dark no-underline font-medium cursor-pointer hover:underline">Go to Configuration »</a>
        </div>
        <div class="bg-card px-4 md:px-6 py-4 md:py-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 md:gap-6">
          <div><i class="fas fa-chart-line text-2xl md:text-3xl text-revenue"></i></div>
          <div class="flex flex-col sm:flex-row justify-between flex-1 gap-4 w-full">
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">70,856</span>
              <span class="text-sm md:text-[15px] text-gray-800">Qty of Medicines Sold</span>
            </div>
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">5,288</span>
              <span class="text-sm md:text-[15px] text-gray-800">Invoices Generated</span>
            </div>
          </div>
        </div>
      </div>

      <!-- My Pharmacy Sub-card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-white px-4 md:px-6 py-4 md:py-5 font-semibold flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-gray-500">
          <span>My Pharmacy</span>
          <a class="text-xs text-primary-dark no-underline font-medium cursor-pointer hover:underline">Go to Configuration »</a>
        </div>
        <div class="bg-card px-4 md:px-6 py-4 md:py-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 md:gap-6">
          <div><i class="fas fa-hospital-alt text-2xl md:text-3xl text-revenue"></i></div>
          <div class="flex flex-col sm:flex-row justify-between flex-1 gap-4 w-full">
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">04</span>
              <span class="text-sm md:text-[15px] text-gray-800">Total no of Suppliers</span>
            </div>
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">05</span>
              <span class="text-sm md:text-[15px] text-gray-800">Total no of Users</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Customers Sub-card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-white px-4 md:px-6 py-4 md:py-5 font-semibold flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-gray-500">
          <span>Customers</span>
          <a class="text-xs text-primary-dark no-underline font-medium cursor-pointer hover:underline">Go to Customers Page »</a>
        </div>
        <div class="bg-card px-4 md:px-6 py-4 md:py-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 md:gap-6">
          <div><i class="fas fa-users text-2xl md:text-3xl text-revenue"></i></div>
          <div class="flex flex-col sm:flex-row justify-between flex-1 gap-4 w-full">
            <div class="flex flex-col">
              <span class="font-bold text-xl md:text-[27px] font-[Poppins] text-revenue">845</span>
              <span class="text-sm md:text-[15px] text-gray-800">No of Customers</span>
            </div>
          </div>
          <div class="text-blue-500 font-semibold text-sm">Adalimumab</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DashboardView",
};
</script>
