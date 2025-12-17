<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-container">
      <div class="modal-header">
        <h2>Upload Images</h2>
        <button class="close-btn" @click="$emit('close')">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="modal-body">
        <!-- Drop Zone -->
        <div
          class="drop-zone"
          :class="{ dragging: isDragging }"
          @drop.prevent="handleDrop"
          @dragover.prevent="isDragging = true"
          @dragleave="isDragging = false"
        >
          <i class="fas fa-cloud-upload-alt"></i>
          <h3>Drag & Drop Images Here</h3>
          <p>or</p>
          <button class="btn-browse" @click="$refs.fileInput.click()">
            <i class="fas fa-folder-open"></i>
            Browse Files
          </button>
          <input
            ref="fileInput"
            type="file"
            multiple
            accept="image/*,.pdf"
            @change="handleFileSelect"
            style="display: none"
          />
          <p class="file-info">Supported: JPEG, PNG, PDF, DICOM</p>
        </div>

        <!-- Selected Files -->
        <div v-if="selectedFiles.length > 0" class="selected-files">
          <h4>Selected Files ({{ selectedFiles.length }})</h4>
          <div class="files-list">
            <div v-for="(file, index) in selectedFiles" :key="index" class="file-item">
              <div class="file-preview">
                <img v-if="file.preview" :src="file.preview" alt="Preview" />
                <i v-else class="fas fa-file-image"></i>
              </div>
              <div class="file-info">
                <strong>{{ file.name }}</strong>
                <span>{{ formatFileSize(file.size) }}</span>
              </div>
              <button class="btn-remove" @click="removeFile(index)">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Metadata Form -->
        <div v-if="selectedFiles.length > 0" class="metadata-form">
          <h4>Image Details</h4>

          <div class="form-row">
            <div class="form-group">
              <label>Image Type *</label>
              <select v-model="metadata.type">
                <option value="">Select Type</option>
                <option value="xray">X-Ray</option>
                <option value="photo">Intraoral Photo</option>
                <option value="scan">Scan</option>
                <option value="cbct">CBCT</option>
                <option value="document">Document</option>
              </select>
            </div>

            <div class="form-group">
              <label>Date Taken</label>
              <input v-model="metadata.date" type="date" />
            </div>
          </div>

          <div class="form-group">
            <label>Title *</label>
            <input v-model="metadata.title" type="text" placeholder="e.g., Bitewing X-Ray" />
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea
              v-model="metadata.description"
              rows="2"
              placeholder="Add description..."
            ></textarea>
          </div>

          <div class="form-group">
            <label>Tooth Numbers (comma separated)</label>
            <input
              v-model="metadata.toothNumbers"
              type="text"
              placeholder="e.g., 14, 15, 16"
            />
          </div>

          <div v-if="uploadProgress > 0" class="upload-progress">
            <div class="progress-bar">
              <div class="progress-fill" :style="{ width: uploadProgress + '%' }"></div>
            </div>
            <span class="progress-text">{{ uploadProgress }}%</span>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn-secondary" @click="$emit('close')">Cancel</button>
        <button
          class="btn-primary"
          @click="uploadImages"
          :disabled="selectedFiles.length === 0 || !isValid || uploading"
        >
          <i class="fas fa-upload"></i>
          {{ uploading ? 'Uploading...' : `Upload ${selectedFiles.length} Image${selectedFiles.length > 1 ? 's' : ''}` }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  patientId: {
    type: [Number, String],
    required: true
  }
});

const emit = defineEmits(['close', 'upload']);

const isDragging = ref(false);
const selectedFiles = ref([]);
const uploading = ref(false);
const uploadProgress = ref(0);

const metadata = ref({
  type: '',
  title: '',
  description: '',
  date: new Date().toISOString().split('T')[0],
  toothNumbers: ''
});

const isValid = computed(() => {
  return metadata.value.type && metadata.value.title;
});

const handleDrop = (e) => {
  isDragging.value = false;
  const files = Array.from(e.dataTransfer.files);
  addFiles(files);
};

const handleFileSelect = (e) => {
  const files = Array.from(e.target.files);
  addFiles(files);
};

const addFiles = (files) => {
  files.forEach(file => {
    const fileData = {
      file,
      name: file.name,
      size: file.size,
      preview: null
    };

    // Generate preview for images
    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = (e) => {
        fileData.preview = e.target.result;
      };
      reader.readAsDataURL(file);
    }

    selectedFiles.value.push(fileData);
  });
};

const removeFile = (index) => {
  selectedFiles.value.splice(index, 1);
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
};

const uploadImages = async () => {
  if (!isValid.value) return;

  uploading.value = true;
  uploadProgress.value = 0;

  // Simulate upload progress
  const interval = setInterval(() => {
    uploadProgress.value += 10;
    if (uploadProgress.value >= 100) {
      clearInterval(interval);
      completeUpload();
    }
  }, 300);
};

const completeUpload = () => {
  const toothNumbersArray = metadata.value.toothNumbers
    ? metadata.value.toothNumbers.split(',').map(n => parseInt(n.trim())).filter(n => !isNaN(n))
    : [];

  const uploadedImages = selectedFiles.value.map((fileData, index) => ({
    id: Date.now() + index,
    patientId: props.patientId,
    patientName: 'Selected Patient',
    type: metadata.value.type,
    title: selectedFiles.value.length > 1
      ? `${metadata.value.title} (${index + 1})`
      : metadata.value.title,
    description: metadata.value.description,
    date: metadata.value.date,
    toothNumbers: toothNumbersArray,
    uploadedBy: 'Current User',
    fileUrl: fileData.preview || 'https://via.placeholder.com/800x600',
    thumbnailUrl: fileData.preview || 'https://via.placeholder.com/200x150',
    fileSize: formatFileSize(fileData.size),
    dimensions: '1920x1080',
    rotation: 0,
    zoom: 1
  }));

  emit('upload', uploadedImages);
  uploading.value = false;
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
}

.modal-container {
  background: white;
  border-radius: 16px;
  width: 100%;
  max-width: 800px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
  padding: 24px;
  border-bottom: 1.5px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  font-size: 20px;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.close-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: none;
  background: #f3f4f6;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.close-btn:hover {
  background: #e5e7eb;
}

.modal-body {
  padding: 24px;
  overflow-y: auto;
  flex: 1;
}

.drop-zone {
  border: 2px dashed #d1d5db;
  border-radius: 12px;
  padding: 60px 20px;
  text-align: center;
  background: #f9fafb;
  transition: all 0.3s ease;
  cursor: pointer;
}

.drop-zone.dragging {
  border-color: #4f46e5;
  background: #eff6ff;
}

.drop-zone i {
  font-size: 64px;
  color: #9ca3af;
  margin-bottom: 16px;
}

.drop-zone h3 {
  font-size: 18px;
  font-weight: 600;
  color: #374151;
  margin: 0 0 8px 0;
}

.drop-zone p {
  font-size: 14px;
  color: #6b7280;
  margin: 8px 0;
}

.btn-browse {
  padding: 12px 24px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin: 16px 0;
  transition: all 0.2s ease;
}

.btn-browse:hover {
  background: #4338ca;
}

.file-info {
  font-size: 12px;
  color: #9ca3af;
}

.selected-files {
  margin-top: 24px;
}

.selected-files h4 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 16px 0;
}

.files-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.file-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
}

.file-preview {
  width: 60px;
  height: 60px;
  border-radius: 6px;
  overflow: hidden;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.file-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.file-preview i {
  font-size: 32px;
  color: #9ca3af;
}

.file-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.file-info strong {
  font-size: 14px;
  color: #111827;
}

.file-info span {
  font-size: 12px;
  color: #6b7280;
}

.btn-remove {
  width: 32px;
  height: 32px;
  border-radius: 6px;
  border: none;
  background: #fee2e2;
  color: #dc2626;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.btn-remove:hover {
  background: #fecaca;
}

.metadata-form {
  margin-top: 24px;
  padding-top: 24px;
  border-top: 1.5px solid #e5e7eb;
}

.metadata-form h4 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 16px 0;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  font-size: 13px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  color: #111827;
  transition: all 0.2s ease;
  font-family: inherit;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.upload-progress {
  margin-top: 20px;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e5e7eb;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 8px;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 13px;
  font-weight: 600;
  color: #4f46e5;
}

.modal-footer {
  padding: 20px 24px;
  border-top: 1.5px solid #e5e7eb;
  display: flex;
  gap: 12px;
  justify-content: flex-end;
}

.btn-primary,
.btn-secondary {
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  border: none;
}

.btn-primary {
  background: #4f46e5;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #4338ca;
}

.btn-primary:disabled {
  background: #d1d5db;
  cursor: not-allowed;
}

.btn-secondary {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
}

.btn-secondary:hover {
  background: #f9fafb;
}

@media (max-width: 640px) {
  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>
