<template>
  <div class="bg-gray-50 min-h-screen p-5 font-[Poppins]">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 text-purple-600 mr-3">
          <i class="fas fa-people-group"></i>
        </span>
        <div>
          <h1 class="text-2xl font-bold text-gray-900 m-0">Family Management</h1>
          <p class="text-sm text-gray-500 mt-0.5">Manage family groups and linked accounts</p>
        </div>
      </div>
      <button class="bg-indigo-600 text-white py-2.5 px-4 rounded-lg text-sm font-medium shadow-md hover:bg-indigo-700 transition-colors flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Add Family Group
      </button>
    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
      <input
        type="text"
        placeholder="Search families..."
        class="flex-1 py-2.5 px-4 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
      />
      <select class="border border-gray-300 rounded-lg py-2.5 px-4 bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option>All Families</option>
        <option>Active</option>
        <option>Inactive</option>
      </select>
    </div>

    <!-- Family Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="family in families" :key="family.id" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900 m-0">{{ family.name }}</h3>
          <div class="flex items-center gap-2">
            <button class="text-gray-400 hover:text-indigo-600 transition-colors">
              <i class="fas fa-pen text-sm"></i>
            </button>
            <button class="text-gray-400 hover:text-red-600 transition-colors">
              <i class="fas fa-trash text-sm"></i>
            </button>
          </div>
        </div>
        <div class="flex items-center gap-2 mb-4">
          <span class="text-xs px-2.5 py-1 rounded-full" :class="family.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'">
            {{ family.status }}
          </span>
          <span class="text-xs text-gray-500">{{ family.members.length }} members</span>
        </div>
        <div class="border-t border-gray-100 pt-4">
          <p class="text-xs text-gray-500 mb-2">Family Members</p>
          <div class="flex flex-wrap gap-2">
            <div v-for="member in family.members" :key="member.id" class="flex items-center gap-2 bg-gray-50 px-2.5 py-1.5 rounded-lg">
              <img :src="member.avatar" class="w-6 h-6 rounded-full object-cover" />
              <span class="text-sm text-gray-700">{{ member.name }}</span>
              <span class="text-xs text-gray-400">({{ member.relation }})</span>
            </div>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
          <span class="text-xs text-gray-500">
            <i class="fas fa-calendar mr-1"></i> Created {{ family.createdAt }}
          </span>
          <button class="text-indigo-600 text-sm font-medium hover:text-indigo-700 transition-colors">
            View Details →
          </button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="families.length === 0" class="text-center py-12">
      <i class="fas fa-people-group text-gray-300 text-5xl mb-4"></i>
      <p class="text-gray-500 text-lg">No family groups found</p>
      <button class="mt-4 bg-indigo-600 text-white py-2.5 px-4 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
        Create Your First Family Group
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "FamilyView",
  data() {
    return {
      families: [
        {
          id: 1,
          name: "Smith Family",
          status: "Active",
          createdAt: "Oct 15, 2023",
          members: [
            { id: 1, name: "John Smith", relation: "Father", avatar: "https://randomuser.me/api/portraits/men/32.jpg" },
            { id: 2, name: "Jane Smith", relation: "Mother", avatar: "https://randomuser.me/api/portraits/women/44.jpg" },
            { id: 3, name: "Tim Smith", relation: "Son", avatar: "https://randomuser.me/api/portraits/men/45.jpg" },
          ],
        },
        {
          id: 2,
          name: "Johnson Family",
          status: "Active",
          createdAt: "Sep 20, 2023",
          members: [
            { id: 4, name: "Mike Johnson", relation: "Father", avatar: "https://randomuser.me/api/portraits/men/22.jpg" },
            { id: 5, name: "Sarah Johnson", relation: "Mother", avatar: "https://randomuser.me/api/portraits/women/25.jpg" },
          ],
        },
        {
          id: 3,
          name: "Williams Family",
          status: "Inactive",
          createdAt: "Aug 10, 2023",
          members: [
            { id: 6, name: "Bob Williams", relation: "Grandfather", avatar: "https://randomuser.me/api/portraits/men/60.jpg" },
            { id: 7, name: "Linda Williams", relation: "Grandmother", avatar: "https://randomuser.me/api/portraits/women/60.jpg" },
            { id: 8, name: "Tom Williams", relation: "Father", avatar: "https://randomuser.me/api/portraits/men/35.jpg" },
            { id: 9, name: "Amy Williams", relation: "Daughter", avatar: "https://randomuser.me/api/portraits/women/33.jpg" },
          ],
        },
      ],
    };
  },
};
</script>
