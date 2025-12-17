<template>
  <div class="viewer-overlay" @click.self="$emit('close')">
    <div class="viewer-container">
      <!-- Header -->
      <div class="viewer-header">
        <div class="image-title">
          <h3>{{ image.title }}</h3>
          <p>{{ image.description }}</p>
        </div>
        <button class="close-btn" @click="$emit('close')">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Image Display -->
      <div class="viewer-body">
        <div
          class="image-wrapper"
          @wheel="handleZoom"
          @mousedown="startPan"
          @mousemove="handlePan"
          @mouseup="endPan"
          @mouseleave="endPan"
        >
          <img
            :src="image.fileUrl"
            :alt="image.title"
            :style="{
              transform: `rotate(${rotation}deg) scale(${zoom})`,
              cursor: isPanning ? 'grabbing' : 'grab'
            }"
          />
        </div>

        <!-- Navigation Arrows -->
        <button class="nav-btn prev" @click="$emit('prev')" title="Previous">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="nav-btn next" @click="$emit('next')" title="Next">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>

      <!-- Controls -->
      <div class="viewer-controls">
        <div class="controls-left">
          <button class="control-btn" @click="rotate(-90)" title="Rotate Left">
            <i class="fas fa-rotate-left"></i>
          </button>
          <button class="control-btn" @click="rotate(90)" title="Rotate Right">
            <i class="fas fa-rotate-right"></i>
          </button>
          <div class="zoom-controls">
            <button class="control-btn" @click="zoomOut" title="Zoom Out">
              <i class="fas fa-minus"></i>
            </button>
            <span class="zoom-level">{{ Math.round(zoom * 100) }}%</span>
            <button class="control-btn" @click="zoomIn" title="Zoom In">
              <i class="fas fa-plus"></i>
            </button>
          </div>
          <button class="control-btn" @click="resetView" title="Reset">
            <i class="fas fa-refresh"></i>
          </button>
        </div>

        <div class="controls-right">
          <button class="control-btn" @click="downloadImage" title="Download">
            <i class="fas fa-download"></i>
          </button>
          <button class="control-btn danger" @click="$emit('delete', image)" title="Delete">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>

      <!-- Image Info -->
      <div class="image-info-panel">
        <div class="info-row">
          <span class="info-label">Date Taken:</span>
          <span class="info-value">{{ formatDate(image.date) }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Type:</span>
          <span class="info-value">{{ getTypeLabel(image.type) }}</span>
        </div>
        <div v-if="image.toothNumbers.length > 0" class="info-row">
          <span class="info-label">Teeth:</span>
          <span class="info-value">{{ image.toothNumbers.join(', ') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Uploaded By:</span>
          <span class="info-value">{{ image.uploadedBy }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Dimensions:</span>
          <span class="info-value">{{ image.dimensions }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">File Size:</span>
          <span class="info-value">{{ image.fileSize }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  image: {
    type: Object,
    required: true
  },
  showAnnotation: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close', 'next', 'prev', 'rotate', 'zoom', 'delete']);

const zoom = ref(1);
const rotation = ref(0);
const isPanning = ref(false);
const panStart = ref({ x: 0, y: 0 });

watch(() => props.image, () => {
  resetView();
});

const zoomIn = () => {
  zoom.value = Math.min(zoom.value + 0.25, 5);
};

const zoomOut = () => {
  zoom.value = Math.max(zoom.value - 0.25, 0.25);
};

const rotate = (degrees) => {
  rotation.value = (rotation.value + degrees) % 360;
  emit('rotate', degrees);
};

const resetView = () => {
  zoom.value = 1;
  rotation.value = 0;
};

const handleZoom = (event) => {
  event.preventDefault();
  if (event.deltaY < 0) {
    zoomIn();
  } else {
    zoomOut();
  }
};

const startPan = () => {
  isPanning.value = true;
};

const handlePan = () => {
  // Pan functionality can be implemented here
};

const endPan = () => {
  isPanning.value = false;
};

const downloadImage = () => {
  const link = document.createElement('a');
  link.href = props.image.fileUrl;
  link.download = props.image.title;
  link.click();
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  });
};

const getTypeLabel = (type) => {
  const labels = {
    xray: 'X-Ray',
    photo: 'Photo',
    scan: 'Scan',
    cbct: 'CBCT',
    document: 'Document'
  };
  return labels[type] || type;
};
</script>

<style scoped>
.viewer-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.95);
  z-index: 10000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.viewer-container {
  width: 100%;
  max-width: 1400px;
  height: 90vh;
  background: #1f2937;
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.viewer-header {
  padding: 20px 24px;
  background: #111827;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #374151;
}

.image-title h3 {
  font-size: 18px;
  font-weight: 600;
  color: white;
  margin: 0 0 4px 0;
}

.image-title p {
  font-size: 13px;
  color: #9ca3af;
  margin: 0;
}

.close-btn {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  border: none;
  background: #374151;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.close-btn:hover {
  background: #4b5563;
}

.viewer-body {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #0f172a;
}

.image-wrapper {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: auto;
}

.image-wrapper img {
  max-width: 95%;
  max-height: 95%;
  object-fit: contain;
  transition: transform 0.3s ease;
  user-select: none;
}

.nav-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: none;
  background: rgba(255, 255, 255, 0.9);
  color: #111827;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  z-index: 10;
}

.nav-btn:hover {
  background: white;
  transform: translateY(-50%) scale(1.1);
}

.nav-btn.prev {
  left: 20px;
}

.nav-btn.next {
  right: 20px;
}

.viewer-controls {
  padding: 16px 24px;
  background: #111827;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 1px solid #374151;
}

.controls-left,
.controls-right {
  display: flex;
  gap: 8px;
  align-items: center;
}

.control-btn {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  border: 1px solid #374151;
  background: #1f2937;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.control-btn:hover {
  background: #374151;
  border-color: #4b5563;
}

.control-btn.danger:hover {
  background: #dc2626;
  border-color: #dc2626;
}

.zoom-controls {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 0 8px;
  border-left: 1px solid #374151;
  border-right: 1px solid #374151;
}

.zoom-level {
  min-width: 50px;
  text-align: center;
  font-size: 13px;
  font-weight: 600;
  color: white;
}

.image-info-panel {
  padding: 16px 24px;
  background: #111827;
  border-top: 1px solid #374151;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 12px;
}

.info-row {
  display: flex;
  gap: 8px;
}

.info-label {
  font-size: 12px;
  color: #9ca3af;
  font-weight: 500;
}

.info-value {
  font-size: 12px;
  color: white;
  font-weight: 600;
}

@media (max-width: 768px) {
  .viewer-container {
    height: 100vh;
    border-radius: 0;
  }

  .nav-btn {
    width: 40px;
    height: 40px;
  }

  .image-info-panel {
    grid-template-columns: 1fr;
  }
}
</style>
