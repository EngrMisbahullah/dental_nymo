<template>
  <div class="bg-gray-50 min-h-screen p-5 font-[Poppins]">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-6">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 mr-3">
          <i class="fas fa-chart-line"></i>
        </span>
        <div>
          <h1 class="text-2xl font-bold text-gray-900 m-0">Charts</h1>
          <p class="text-sm text-gray-500 mt-0.5">View patient health data and analytics</p>
        </div>
      </div>
      <div class="flex flex-wrap gap-3">
        <select class="border border-gray-300 rounded-lg py-2 px-4 bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          <option>All Patients</option>
          <option>John Doe</option>
          <option>Jane Smith</option>
        </select>
        <select class="border border-gray-300 rounded-lg py-2 px-4 bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          <option>Last 30 Days</option>
          <option>Last 7 Days</option>
          <option>Last 6 Months</option>
          <option>Last Year</option>
        </select>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm mb-1">Total Visits</p>
            <h3 class="text-2xl font-bold text-gray-900 m-0">1,248</h3>
          </div>
          <span class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
            <i class="fas fa-users"></i>
          </span>
        </div>
        <p class="text-green-600 text-xs mt-2 flex items-center">
          <i class="fas fa-arrow-up mr-1"></i> 12% from last month
        </p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm mb-1">Treatments Done</p>
            <h3 class="text-2xl font-bold text-gray-900 m-0">856</h3>
          </div>
          <span class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
            <i class="fas fa-stethoscope"></i>
          </span>
        </div>
        <p class="text-green-600 text-xs mt-2 flex items-center">
          <i class="fas fa-arrow-up mr-1"></i> 8% from last month
        </p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm mb-1">Avg. Recovery Time</p>
            <h3 class="text-2xl font-bold text-gray-900 m-0">14 Days</h3>
          </div>
          <span class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
            <i class="fas fa-clock"></i>
          </span>
        </div>
        <p class="text-red-600 text-xs mt-2 flex items-center">
          <i class="fas fa-arrow-down mr-1"></i> 3% from last month
        </p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm mb-1">Satisfaction Rate</p>
            <h3 class="text-2xl font-bold text-gray-900 m-0">94%</h3>
          </div>
          <span class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
            <i class="fas fa-smile"></i>
          </span>
        </div>
        <p class="text-green-600 text-xs mt-2 flex items-center">
          <i class="fas fa-arrow-up mr-1"></i> 5% from last month
        </p>
      </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-base font-semibold text-gray-900 m-0">Patient Visits Over Time</h3>
          <button class="text-gray-400 hover:text-gray-600 text-lg">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
        <div class="h-[300px] flex items-center justify-center bg-gray-50 rounded-lg text-gray-400 text-sm">
          <i class="fas fa-chart-line text-3xl"></i>
          <span class="ml-2">Line Chart Placeholder</span>
        </div>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-base font-semibold text-gray-900 m-0">Treatment Distribution</h3>
          <button class="text-gray-400 hover:text-gray-600 text-lg">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
        <div class="h-[300px] flex items-center justify-center bg-gray-50 rounded-lg text-gray-400 text-sm">
          <i class="fas fa-chart-pie text-3xl"></i>
          <span class="ml-2">Pie Chart Placeholder</span>
        </div>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-base font-semibold text-gray-900 m-0">Revenue Breakdown</h3>
          <button class="text-gray-400 hover:text-gray-600 text-lg">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
        <div class="h-[300px] flex items-center justify-center bg-gray-50 rounded-lg text-gray-400 text-sm">
          <i class="fas fa-chart-bar text-3xl"></i>
          <span class="ml-2">Bar Chart Placeholder</span>
        </div>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-base font-semibold text-gray-900 m-0">Age Demographics</h3>
          <button class="text-gray-400 hover:text-gray-600 text-lg">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
        <div class="h-[300px] flex items-center justify-center bg-gray-50 rounded-lg text-gray-400 text-sm">
          <i class="fas fa-chart-area text-3xl"></i>
          <span class="ml-2">Area Chart Placeholder</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ChartView",
};
</script>
