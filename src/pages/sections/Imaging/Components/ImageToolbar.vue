<template>
  <div class="image-toolbar">
    <div class="toolbar-group">
      <button class="toolbar-btn" @click="$emit('upload')" title="Upload Images">
        <i class="fas fa-upload"></i>
        <span>Upload</span>
      </button>

      <button class="toolbar-btn" @click="$emit('scan')" title="Scan">
        <i class="fas fa-scanner"></i>
        <span>Scan</span>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('export')"
        title="Export"
      >
        <i class="fas fa-file-export"></i>
        <span>Export</span>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('print')"
        title="Print"
      >
        <i class="fas fa-print"></i>
        <span>Print</span>
      </button>
    </div>

    <div class="toolbar-divider"></div>

    <div class="toolbar-group">
      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('rotate', -90)"
        title="Rotate Left 90°"
      >
        <i class="fas fa-rotate-left"></i>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('rotate', 90)"
        title="Rotate Right 90°"
      >
        <i class="fas fa-rotate-right"></i>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('flip', 'horizontal')"
        title="Flip Horizontal"
      >
        <i class="fas fa-arrows-left-right"></i>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('flip', 'vertical')"
        title="Flip Vertical"
      >
        <i class="fas fa-arrows-up-down"></i>
      </button>
    </div>

    <div class="toolbar-divider"></div>

    <div class="toolbar-group">
      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('zoom', 'in')"
        title="Zoom In"
      >
        <i class="fas fa-magnifying-glass-plus"></i>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('zoom', 'out')"
        title="Zoom Out"
      >
        <i class="fas fa-magnifying-glass-minus"></i>
      </button>

      <button
        class="toolbar-btn"
        :disabled="!selectedImage"
        @click="$emit('annotate')"
        title="Annotate"
      >
        <i class="fas fa-pen"></i>
        <span>Annotate</span>
      </button>
    </div>

    <div class="toolbar-divider"></div>

    <div class="toolbar-group">
      <button
        class="toolbar-btn danger"
        :disabled="!selectedImage"
        @click="$emit('delete')"
        title="Delete"
      >
        <i class="fas fa-trash"></i>
        <span>Delete</span>
      </button>
    </div>
  </div>
</template>

<script setup>

defineProps({
  selectedImage: {
    type: Object,
    default: null
  }
});

defineEmits(['upload', 'scan', 'export', 'print', 'rotate', 'flip', 'zoom', 'annotate', 'delete']);
</script>

<style scoped>
.image-toolbar {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.toolbar-group {
  display: flex;
  gap: 4px;
}

.toolbar-btn {
  padding: 8px 12px;
  border: 1.5px solid #e5e7eb;
  background: white;
  border-radius: 6px;
  color: #374151;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
}

.toolbar-btn:hover:not(:disabled) {
  background: #f9fafb;
  border-color: #4f46e5;
  color: #4f46e5;
}

.toolbar-btn:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.toolbar-btn.danger:hover:not(:disabled) {
  background: #fee2e2;
  border-color: #dc2626;
  color: #dc2626;
}

.toolbar-btn i {
  font-size: 14px;
}

.toolbar-btn span {
  display: none;
}

.toolbar-btn:has(span) {
  padding: 8px 14px;
}

.toolbar-btn:has(span) span {
  display: inline;
}

.toolbar-divider {
  width: 1px;
  height: 24px;
  background: #e5e7eb;
}

@media (max-width: 768px) {
  .toolbar-btn span {
    display: none !important;
  }

  .toolbar-btn:has(span) {
    padding: 8px 12px;
  }
}
</style>
