<template>
  <div class="bg-gray-50 min-h-screen p-5 font-[Poppins]">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 mr-3">
          <i class="fas fa-camera"></i>
        </span>
        <div>
          <h1 class="text-2xl font-bold text-gray-900 m-0">Imaging & X-Rays</h1>
          <p class="text-sm text-gray-500 mt-0.5">Manage patient imaging records and X-rays</p>
        </div>
      </div>
      <div class="flex gap-3">
        <button class="bg-white text-gray-700 py-2.5 px-4 rounded-lg text-sm font-medium border border-gray-300 hover:bg-gray-50 transition-colors flex items-center gap-2">
          <i class="fas fa-filter"></i>
          Filter
        </button>
        <button class="bg-indigo-600 text-white py-2.5 px-4 rounded-lg text-sm font-medium shadow-md hover:bg-indigo-700 transition-colors flex items-center gap-2">
          <i class="fas fa-upload"></i>
          Upload Image
        </button>
      </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
      <input
        type="text"
        placeholder="Search by patient name or image type..."
        class="w-full py-2.5 px-4 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
      <nav class="flex gap-6 overflow-x-auto">
        <button
          v-for="tab in tabs"
          :key="tab"
          :class="['py-3 px-1 text-sm font-medium border-b-2 transition-colors whitespace-nowrap', activeTab === tab ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700']"
          @click="activeTab = tab"
        >
          {{ tab }}
        </button>
      </nav>
    </div>

    <!-- Image Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
      <div v-for="image in filteredImages" :key="image.id" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
        <div class="relative aspect-square bg-gray-100 flex items-center justify-center">
          <img :src="image.thumbnail" :alt="image.name" class="w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
            <button class="w-10 h-10 rounded-full bg-white/90 text-gray-700 flex items-center justify-center hover:bg-white transition-colors">
              <i class="fas fa-eye"></i>
            </button>
            <button class="w-10 h-10 rounded-full bg-white/90 text-gray-700 flex items-center justify-center hover:bg-white transition-colors">
              <i class="fas fa-download"></i>
            </button>
            <button class="w-10 h-10 rounded-full bg-white/90 text-red-600 flex items-center justify-center hover:bg-white transition-colors">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
        <div class="p-4">
          <h4 class="text-sm font-semibold text-gray-900 mb-1 truncate">{{ image.name }}</h4>
          <p class="text-xs text-gray-500 mb-2">{{ image.patient }}</p>
          <div class="flex items-center justify-between">
            <span class="text-xs px-2 py-1 rounded-full" :class="getTypeBadgeClass(image.type)">
              {{ image.type }}
            </span>
            <span class="text-xs text-gray-400">{{ image.date }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="filteredImages.length === 0" class="text-center py-12">
      <i class="fas fa-images text-gray-300 text-5xl mb-4"></i>
      <p class="text-gray-500 text-lg">No images found</p>
      <button class="mt-4 bg-indigo-600 text-white py-2.5 px-4 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
        Upload Your First Image
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ImagingView",
  data() {
    return {
      activeTab: "All",
      tabs: ["All", "X-Rays", "Intraoral", "Panoramic", "CBCT"],
      images: [
        {
          id: 1,
          name: "Panoramic X-Ray",
          patient: "John Smith",
          type: "Panoramic",
          date: "Oct 25, 2023",
          thumbnail: "https://placehold.co/400x400/e2e8f0/64748b?text=Panoramic",
        },
        {
          id: 2,
          name: "Right Molar Scan",
          patient: "Jane Doe",
          type: "X-Rays",
          date: "Oct 24, 2023",
          thumbnail: "https://placehold.co/400x400/dbeafe/3b82f6?text=X-Ray",
        },
        {
          id: 3,
          name: "Intraoral Photo - Upper",
          patient: "Mike Johnson",
          type: "Intraoral",
          date: "Oct 23, 2023",
          thumbnail: "https://placehold.co/400x400/dcfce7/22c55e?text=Intraoral",
        },
        {
          id: 4,
          name: "CBCT Scan",
          patient: "Sarah Williams",
          type: "CBCT",
          date: "Oct 22, 2023",
          thumbnail: "https://placehold.co/400x400/fef3c7/f59e0b?text=CBCT",
        },
        {
          id: 5,
          name: "Full Mouth X-Ray",
          patient: "John Smith",
          type: "X-Rays",
          date: "Oct 21, 2023",
          thumbnail: "https://placehold.co/400x400/dbeafe/3b82f6?text=X-Ray",
        },
        {
          id: 6,
          name: "Intraoral Photo - Lower",
          patient: "Jane Doe",
          type: "Intraoral",
          date: "Oct 20, 2023",
          thumbnail: "https://placehold.co/400x400/dcfce7/22c55e?text=Intraoral",
        },
      ],
    };
  },
  computed: {
    filteredImages() {
      if (this.activeTab === "All") return this.images;
      return this.images.filter((img) => img.type === this.activeTab);
    },
  },
  methods: {
    getTypeBadgeClass(type) {
      const classes = {
        "X-Rays": "bg-blue-100 text-blue-700",
        Panoramic: "bg-gray-100 text-gray-700",
        Intraoral: "bg-green-100 text-green-700",
        CBCT: "bg-yellow-100 text-yellow-700",
      };
      return classes[type] || "bg-gray-100 text-gray-700";
    },
  },
};
</script>
