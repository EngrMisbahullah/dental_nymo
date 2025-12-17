<template>
  <div class="imaging-container">
    <!-- Top Action Bar -->
    <div class="action-bar">
      <div class="left-actions">
        <div class="patient-selector">
          <i class="fas fa-user"></i>
          <select v-model="selectedPatient">
            <option value="">Select Patient</option>
            <option v-for="patient in patients" :key="patient.id" :value="patient.id">
              {{ patient.name }}
            </option>
          </select>
        </div>

        <div class="view-toggle">
          <button
            class="toggle-btn"
            :class="{ active: viewMode === 'grid' }"
            @click="viewMode = 'grid'"
            title="Grid View"
          >
            <i class="fas fa-th"></i>
          </button>
          <button
            class="toggle-btn"
            :class="{ active: viewMode === 'list' }"
            @click="viewMode = 'list'"
            title="List View"
          >
            <i class="fas fa-list"></i>
          </button>
        </div>
      </div>

      <ImageToolbar
        :selected-image="selectedImage"
        @upload="showUploadModal = true"
        @delete="deleteImage"
        @rotate="rotateImage"
        @flip="flipImage"
        @zoom="zoomImage"
        @annotate="showAnnotationMode = !showAnnotationMode"
        @export="exportImage"
        @print="printImage"
      />

      <div class="right-actions">
        <button class="btn-icon" @click="expandAll" title="Expand All">
          <i class="fas fa-expand-alt"></i>
        </button>
        <button class="btn-icon" @click="collapseAll" title="Collapse All">
          <i class="fas fa-compress-alt"></i>
        </button>
      </div>
    </div>

    <!-- Filters Bar -->
    <div class="filters-bar">
      <div class="filter-group">
        <label>Image Type</label>
        <select v-model="filters.type">
          <option value="">All Types</option>
          <option value="xray">X-Ray</option>
          <option value="photo">Photo</option>
          <option value="scan">Scan</option>
          <option value="cbct">CBCT</option>
          <option value="document">Document</option>
        </select>
      </div>

      <div class="filter-group">
        <label>Date Range</label>
        <input v-model="filters.dateFrom" type="date" placeholder="From" />
        <span class="date-separator">to</span>
        <input v-model="filters.dateTo" type="date" placeholder="To" />
      </div>

      <div class="filter-group">
        <label>Tooth Number</label>
        <input v-model="filters.tooth" type="text" placeholder="e.g., 14, 15" />
      </div>

      <button class="btn-filter-apply" @click="applyFilters">
        <i class="fas fa-filter"></i>
        Apply Filters
      </button>

      <button class="btn-filter-clear" @click="clearFilters">
        <i class="fas fa-times"></i>
        Clear
      </button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Empty State -->
      <div v-if="filteredImages.length === 0" class="empty-state">
        <i class="fas fa-images"></i>
        <h3>No Images Found</h3>
        <p v-if="!selectedPatient">Please select a patient to view their images</p>
        <p v-else>No images available for this patient</p>
        <button class="btn-primary" @click="showUploadModal = true">
          <i class="fas fa-upload"></i>
          Upload Images
        </button>
      </div>

      <!-- Image Gallery -->
      <ImageGallery
        v-else
        :images="filteredImages"
        :view-mode="viewMode"
        :selected-image="selectedImage"
        @select="selectImage"
        @view="viewImage"
        @delete="deleteImage"
      />
    </div>

    <!-- Image Viewer Modal -->
    <ImageViewer
      v-if="showViewer"
      :image="viewingImage"
      :show-annotation="showAnnotationMode"
      @close="closeViewer"
      @next="nextImage"
      @prev="prevImage"
      @rotate="rotateImage"
      @zoom="zoomImage"
      @delete="deleteImage"
    />

    <!-- Upload Modal -->
    <ImageUpload
      v-if="showUploadModal"
      :patient-id="selectedPatient"
      @close="showUploadModal = false"
      @upload="handleUpload"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ImageToolbar from './Components/ImageToolbar.vue';
import ImageGallery from './Components/ImageGallery.vue';
import ImageViewer from './Components/ImageViewer.vue';
import ImageUpload from './Components/ImageUpload.vue';

const selectedPatient = ref('');
const viewMode = ref('grid');
const selectedImage = ref(null);
const viewingImage = ref(null);
const showViewer = ref(false);
const showUploadModal = ref(false);
const showAnnotationMode = ref(false);

const filters = ref({
  type: '',
  dateFrom: '',
  dateTo: '',
  tooth: ''
});

// Mock patients data
const patients = ref([
  { id: 1, name: 'John Smith' },
  { id: 2, name: 'Jane Doe' },
  { id: 3, name: 'Alice Johnson' },
  { id: 4, name: 'Bob Wilson' }
]);

// Mock images data
const images = ref([
  {
    id: 1,
    patientId: 1,
    patientName: 'John Smith',
    type: 'xray',
    title: 'Bitewing X-Ray',
    description: 'Right side bitewing radiograph',
    date: '2025-11-01',
    toothNumbers: [14, 15, 16],
    uploadedBy: 'Dr. Sarah Lexington',
    fileUrl: 'https://via.placeholder.com/800x600/4f46e5/ffffff?text=X-Ray+14-16',
    thumbnailUrl: 'https://via.placeholder.com/200x150/4f46e5/ffffff?text=X-Ray',
    fileSize: '2.4 MB',
    dimensions: '1920x1080',
    rotation: 0,
    zoom: 1
  },
  {
    id: 2,
    patientId: 1,
    patientName: 'John Smith',
    type: 'photo',
    title: 'Intraoral Photo',
    description: 'Front view of upper teeth',
    date: '2025-10-28',
    toothNumbers: [11, 12, 21, 22],
    uploadedBy: 'Dr. Sarah Lexington',
    fileUrl: 'https://via.placeholder.com/800x600/10b981/ffffff?text=Intraoral+Photo',
    thumbnailUrl: 'https://via.placeholder.com/200x150/10b981/ffffff?text=Photo',
    fileSize: '1.8 MB',
    dimensions: '1600x1200',
    rotation: 0,
    zoom: 1
  },
  {
    id: 3,
    patientId: 1,
    patientName: 'John Smith',
    type: 'scan',
    title: 'Panoramic X-Ray',
    description: 'Full mouth panoramic radiograph',
    date: '2025-10-15',
    toothNumbers: [],
    uploadedBy: 'Dr. Sarah Lexington',
    fileUrl: 'https://via.placeholder.com/1200x400/8b5cf6/ffffff?text=Panoramic+X-Ray',
    thumbnailUrl: 'https://via.placeholder.com/200x150/8b5cf6/ffffff?text=Panoramic',
    fileSize: '3.2 MB',
    dimensions: '2400x800',
    rotation: 0,
    zoom: 1
  },
  {
    id: 4,
    patientId: 1,
    patientName: 'John Smith',
    type: 'xray',
    title: 'Periapical X-Ray',
    description: 'Tooth 36 periapical radiograph',
    date: '2025-09-20',
    toothNumbers: [36],
    uploadedBy: 'Dr. Sarah Lexington',
    fileUrl: 'https://via.placeholder.com/600x800/f59e0b/ffffff?text=Periapical+36',
    thumbnailUrl: 'https://via.placeholder.com/200x150/f59e0b/ffffff?text=Periapical',
    fileSize: '1.5 MB',
    dimensions: '1200x1600',
    rotation: 0,
    zoom: 1
  }
]);

const filteredImages = computed(() => {
  if (!selectedPatient.value) return [];

  let result = images.value.filter(img => img.patientId === selectedPatient.value);

  if (filters.value.type) {
    result = result.filter(img => img.type === filters.value.type);
  }

  if (filters.value.dateFrom) {
    result = result.filter(img => img.date >= filters.value.dateFrom);
  }

  if (filters.value.dateTo) {
    result = result.filter(img => img.date <= filters.value.dateTo);
  }

  if (filters.value.tooth) {
    const toothNumbers = filters.value.tooth.split(',').map(t => parseInt(t.trim()));
    result = result.filter(img =>
      img.toothNumbers.some(t => toothNumbers.includes(t))
    );
  }

  return result;
});

const selectImage = (image) => {
  selectedImage.value = image;
};

const viewImage = (image) => {
  viewingImage.value = image;
  showViewer.value = true;
};

const closeViewer = () => {
  showViewer.value = false;
  viewingImage.value = null;
};

const nextImage = () => {
  const currentIndex = filteredImages.value.findIndex(img => img.id === viewingImage.value.id);
  if (currentIndex < filteredImages.value.length - 1) {
    viewingImage.value = filteredImages.value[currentIndex + 1];
  }
};

const prevImage = () => {
  const currentIndex = filteredImages.value.findIndex(img => img.id === viewingImage.value.id);
  if (currentIndex > 0) {
    viewingImage.value = filteredImages.value[currentIndex - 1];
  }
};

const deleteImage = (image) => {
  if (confirm(`Are you sure you want to delete "${image.title}"?`)) {
    const index = images.value.findIndex(img => img.id === image.id);
    if (index > -1) {
      images.value.splice(index, 1);
      if (viewingImage.value?.id === image.id) {
        closeViewer();
      }
      if (selectedImage.value?.id === image.id) {
        selectedImage.value = null;
      }
    }
  }
};

const rotateImage = (degrees) => {
  if (viewingImage.value) {
    viewingImage.value.rotation = (viewingImage.value.rotation + degrees) % 360;
  }
};

const flipImage = (direction) => {
  console.log('Flip image:', direction);
};

const zoomImage = (level) => {
  if (viewingImage.value) {
    viewingImage.value.zoom = level;
  }
};

const exportImage = () => {
  if (selectedImage.value) {
    console.log('Export image:', selectedImage.value);
    alert('Export functionality coming soon!');
  }
};

const printImage = () => {
  if (selectedImage.value) {
    console.log('Print image:', selectedImage.value);
    alert('Print functionality coming soon!');
  }
};

const handleUpload = (uploadedImages) => {
  images.value.push(...uploadedImages);
  showUploadModal.value = false;
};

const applyFilters = () => {
  console.log('Filters applied:', filters.value);
};

const clearFilters = () => {
  filters.value = {
    type: '',
    dateFrom: '',
    dateTo: '',
    tooth: ''
  };
};

const expandAll = () => {
  console.log('Expand all');
};

const collapseAll = () => {
  console.log('Collapse all');
};
</script>

<style scoped>
.imaging-container {
  background: #f8f9fa;
  min-height: 100vh;
  padding: 24px;
}

/* Action Bar */
.action-bar {
  background: white;
  padding: 16px 20px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}

.left-actions {
  display: flex;
  gap: 16px;
  align-items: center;
}

.patient-selector {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  background: #f9fafb;
  border-radius: 8px;
  border: 1.5px solid #e5e7eb;
}

.patient-selector i {
  color: #6b7280;
  font-size: 14px;
}

.patient-selector select {
  border: none;
  background: transparent;
  font-size: 14px;
  font-weight: 500;
  color: #111827;
  cursor: pointer;
  outline: none;
  min-width: 180px;
}

.view-toggle {
  display: flex;
  gap: 4px;
  background: #f9fafb;
  padding: 4px;
  border-radius: 8px;
}

.toggle-btn {
  width: 36px;
  height: 36px;
  border: none;
  background: transparent;
  border-radius: 6px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.toggle-btn:hover {
  background: #e5e7eb;
}

.toggle-btn.active {
  background: #4f46e5;
  color: white;
}

.right-actions {
  display: flex;
  gap: 8px;
}

.btn-icon {
  width: 40px;
  height: 40px;
  border: 1.5px solid #e5e7eb;
  background: white;
  border-radius: 8px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-icon:hover {
  background: #f9fafb;
  border-color: #4f46e5;
  color: #4f46e5;
}

/* Filters Bar */
.filters-bar {
  background: white;
  padding: 16px 20px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  display: flex;
  gap: 16px;
  align-items: flex-end;
  flex-wrap: wrap;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.filter-group label {
  font-size: 12px;
  font-weight: 500;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.filter-group select,
.filter-group input {
  padding: 8px 12px;
  border: 1.5px solid #e5e7eb;
  border-radius: 6px;
  font-size: 14px;
  color: #111827;
  background: white;
  min-width: 140px;
}

.filter-group input[type="date"] {
  min-width: 150px;
}

.filter-group select:focus,
.filter-group input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.date-separator {
  font-size: 13px;
  color: #9ca3af;
  padding: 0 4px;
  align-self: center;
  margin-top: 20px;
}

.btn-filter-apply,
.btn-filter-clear {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
}

.btn-filter-apply {
  background: #4f46e5;
  color: white;
}

.btn-filter-apply:hover {
  background: #4338ca;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-filter-clear {
  background: white;
  color: #6b7280;
  border: 1.5px solid #e5e7eb;
}

.btn-filter-clear:hover {
  background: #f9fafb;
}

/* Main Content */
.main-content {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  min-height: 500px;
  padding: 24px;
}

/* Empty State */
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 20px;
  color: #9ca3af;
  text-align: center;
}

.empty-state i {
  font-size: 80px;
  margin-bottom: 20px;
  color: #d1d5db;
}

.empty-state h3 {
  font-size: 20px;
  font-weight: 600;
  color: #6b7280;
  margin: 0 0 8px 0;
}

.empty-state p {
  font-size: 14px;
  color: #9ca3af;
  margin: 0 0 24px 0;
}

.btn-primary {
  padding: 12px 24px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-primary:hover {
  background: #4338ca;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
  .imaging-container {
    padding: 16px;
  }

  .action-bar {
    flex-direction: column;
    align-items: stretch;
  }

  .left-actions {
    flex-direction: column;
    width: 100%;
  }

  .patient-selector select {
    width: 100%;
  }

  .filters-bar {
    flex-direction: column;
  }

  .filter-group {
    width: 100%;
  }

  .filter-group select,
  .filter-group input {
    width: 100%;
  }
}
</style>
