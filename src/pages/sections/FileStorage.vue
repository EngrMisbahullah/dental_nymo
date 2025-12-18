<template>
  <div class="flex bg-white font-[Segoe_UI,Tahoma,Geneva,Verdana,sans-serif]">
    <main class="flex-grow py-5 px-4 md:px-8 bg-white">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center flex-wrap mb-8 gap-4">
        <div>
          <h1 class="text-[28px] font-semibold text-[#303030] m-0 font-[Poppins]">Imaging & File Storage</h1>
          <p class="text-primary text-base font-bold mt-1 font-[Poppins]">
            Manage files for patient: <span class="font-semibold text-gray-900">{{ patientName }}</span>
          </p>
        </div>
        <div class="flex gap-3">
          <button class="px-4 py-2 rounded-md text-sm font-medium flex items-center cursor-pointer border-none bg-blue-600 text-white hover:bg-blue-700 transition-colors">
            <span class="material-symbols-outlined text-xl mr-2">upload</span>
            Upload File
          </button>
          <button class="px-4 py-2 rounded-md text-sm font-medium flex items-center cursor-pointer bg-white text-gray-900 border border-gray-300 hover:bg-gray-50 transition-colors">
            <span class="material-symbols-outlined text-xl mr-2">create_new_folder</span>
            New Folder
          </button>
        </div>
      </div>

      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gray-50 border-b border-gray-200">
          <div class="grid grid-cols-[3.5fr_2fr_2fr_1.5fr_1.5fr] items-center py-3 px-4 gap-4 font-[Poppins] text-xs font-semibold text-gray-500 uppercase">
            <div>Name</div>
            <div>Type</div>
            <div>Date Modified</div>
            <div>Size</div>
            <div>Actions</div>
          </div>
        </div>
        <div>
          <div v-for="file in files" :key="file.name" class="grid grid-cols-[3.5fr_2fr_2fr_1.5fr_1.5fr] items-center py-3 px-4 gap-4 font-[Poppins] text-sm text-gray-900 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors group">
            <div class="flex items-center whitespace-nowrap overflow-hidden text-ellipsis">
              <span class="material-symbols-outlined mr-2" :class="getIconColor(file.iconColor)">
                {{ file.icon }}
              </span>
              <span class="font-medium text-gray-700">{{ file.name }}</span>
            </div>
            <span class="flex items-center whitespace-nowrap overflow-hidden text-ellipsis text-gray-500">{{ file.type }}</span>
            <span class="flex items-center whitespace-nowrap overflow-hidden text-ellipsis text-gray-500">{{ file.dateModified }}</span>
            <span class="flex items-center whitespace-nowrap overflow-hidden text-ellipsis text-gray-500">{{ file.size }}</span>
            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="bg-transparent border-none cursor-pointer p-1 rounded-full inline-flex items-center justify-center hover:bg-gray-100 action-btn">
                <span class="material-symbols-outlined text-lg text-gray-500">edit</span>
              </button>
              <button v-if="file.type !== 'Folder'" class="bg-transparent border-none cursor-pointer p-1 rounded-full inline-flex items-center justify-center hover:bg-gray-100 action-draw">
                <span class="material-symbols-outlined text-lg text-gray-500">draw</span>
              </button>
              <button class="bg-transparent border-none cursor-pointer p-1 rounded-full inline-flex items-center justify-center hover:bg-gray-100 action-delete">
                <span class="material-symbols-outlined text-lg text-gray-500">delete</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-10">
        <h3 class="text-xl font-semibold mb-6 font-[Poppins]">System Integrations</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="flex items-start bg-white border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 rounded-lg flex-shrink-0 mr-4 bg-blue-100 text-blue-600">
              <span class="material-symbols-outlined text-2xl">dns</span>
            </div>
            <div>
              <p class="text-base font-semibold m-0 text-gray-900 font-[Poppins]">PACS Integration</p>
              <p class="text-sm text-gray-500 mt-1 mb-3">
                Connect to your Picture Archiving and Communication System for seamless
                data flow.
              </p>
              <a href="#" class="text-sm font-semibold inline-flex items-center cursor-pointer font-[Poppins] text-blue-600 hover:text-blue-700 group/link">
                Configure Now
                <span class="material-symbols-outlined text-base ml-1 transition-transform group-hover/link:translate-x-1">arrow_forward</span>
              </a>
            </div>
          </div>
          <div class="flex items-start bg-white border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 rounded-lg flex-shrink-0 mr-4 bg-green-100 text-green-600">
              <span class="material-symbols-outlined text-2xl">photo_camera</span>
            </div>
            <div>
              <p class="text-base font-semibold m-0 text-gray-900 font-[Poppins]">Auto-import from Imaging Hardware</p>
              <p class="text-sm text-gray-500 mt-1 mb-3">
                Automatically pull images directly from connected imaging devices.
              </p>
              <a href="#" class="text-sm font-semibold inline-flex items-center cursor-pointer font-[Poppins] text-green-600 hover:text-green-700 group/link">
                Setup Device
                <span class="material-symbols-outlined text-base ml-1 transition-transform group-hover/link:translate-x-1">arrow_forward</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "FileStorage",
  data() {
    return {
      patientName: "Jane Doe",
      files: [
        {
          name: "X-Rays",
          type: "Folder",
          dateModified: "2023-10-27",
          size: "--",
          icon: "folder",
          iconColor: "text-gray",
        },
        {
          name: "Intraoral Scans",
          type: "Folder",
          dateModified: "2023-10-26",
          size: "--",
          icon: "folder",
          iconColor: "text-gray",
        },
        {
          name: "upper-right-molar.jpg",
          type: "JPG Image",
          dateModified: "2023-10-25",
          size: "2.3 MB",
          icon: "image",
          iconColor: "text-blue",
        },
        {
          name: "panoramic-xray.dcm",
          type: "DICOM File",
          dateModified: "2023-10-24",
          size: "15.8 MB",
          icon: "description",
          iconColor: "text-red",
        },
      ],
    };
  },
  methods: {
    getIconColor(color) {
      const colors = {
        'text-gray': 'text-gray-500',
        'text-blue': 'text-blue-500',
        'text-red': 'text-red-500',
      };
      return colors[color] || 'text-gray-500';
    },
  },
};
</script>

<style scoped>
.action-btn:hover .material-symbols-outlined {
  color: #2563eb;
}

.action-draw:hover .material-symbols-outlined {
  color: #16a34a;
}

.action-delete:hover .material-symbols-outlined {
  color: #ef4444;
}
</style>
