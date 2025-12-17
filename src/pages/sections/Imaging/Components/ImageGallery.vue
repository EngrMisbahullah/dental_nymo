<template>
  <div class="image-gallery" :class="viewMode">
    <!-- Grid View -->
    <div v-if="viewMode === 'grid'" class="grid-view">
      <div
        v-for="image in images"
        :key="image.id"
        class="image-card"
        :class="{ selected: selectedImage?.id === image.id }"
        @click="$emit('select', image)"
        @dblclick="$emit('view', image)"
      >
        <div class="image-thumbnail">
          <img :src="image.thumbnailUrl" :alt="image.title" />
          <div class="image-overlay">
            <button class="overlay-btn" @click.stop="$emit('view', image)" title="View">
              <i class="fas fa-eye"></i>
            </button>
            <button class="overlay-btn" @click.stop="$emit('delete', image)" title="Delete">
              <i class="fas fa-trash"></i>
            </button>
          </div>
          <div class="image-type-badge" :class="image.type">
            {{ getTypeLabel(image.type) }}
          </div>
        </div>
        <div class="image-info">
          <h4>{{ image.title }}</h4>
          <p class="image-date">
            <i class="fas fa-calendar"></i>
            {{ formatDate(image.date) }}
          </p>
          <p v-if="image.toothNumbers.length > 0" class="image-teeth">
            <i class="fas fa-tooth"></i>
            Teeth: {{ image.toothNumbers.join(', ') }}
          </p>
          <div class="image-meta">
            <span class="meta-item">
              <i class="fas fa-expand-arrows-alt"></i>
              {{ image.dimensions }}
            </span>
            <span class="meta-item">
              <i class="fas fa-file"></i>
              {{ image.fileSize }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- List View -->
    <div v-else class="list-view">
      <table class="images-table">
        <thead>
          <tr>
            <th></th>
            <th>Preview</th>
            <th>Title</th>
            <th>Type</th>
            <th>Date</th>
            <th>Teeth</th>
            <th>Uploaded By</th>
            <th>Size</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="image in images"
            :key="image.id"
            :class="{ selected: selectedImage?.id === image.id }"
            @click="$emit('select', image)"
          >
            <td class="checkbox-cell">
              <input
                type="checkbox"
                :checked="selectedImage?.id === image.id"
                @click.stop="$emit('select', image)"
              />
            </td>
            <td class="preview-cell">
              <img :src="image.thumbnailUrl" :alt="image.title" />
            </td>
            <td class="title-cell">
              <strong>{{ image.title }}</strong>
              <span class="description">{{ image.description }}</span>
            </td>
            <td>
              <span class="type-badge" :class="image.type">
                {{ getTypeLabel(image.type) }}
              </span>
            </td>
            <td>{{ formatDate(image.date) }}</td>
            <td>{{ image.toothNumbers.join(', ') || 'N/A' }}</td>
            <td>{{ image.uploadedBy }}</td>
            <td>{{ image.fileSize }}</td>
            <td class="actions-cell">
              <button class="action-btn" @click.stop="$emit('view', image)" title="View">
                <i class="fas fa-eye"></i>
              </button>
              <button class="action-btn delete" @click.stop="$emit('delete', image)" title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>

defineProps({
  images: {
    type: Array,
    required: true
  },
  viewMode: {
    type: String,
    default: 'grid'
  },
  selectedImage: {
    type: Object,
    default: null
  }
});

defineEmits(['select', 'view', 'delete']);

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

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};
</script>

<style scoped>
/* Grid View */
.grid-view {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
}

.image-card {
  background: white;
  border: 2px solid #e5e7eb;
  border-radius: 10px;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.2s ease;
}

.image-card:hover {
  border-color: #4f46e5;
  box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
  transform: translateY(-2px);
}

.image-card.selected {
  border-color: #4f46e5;
  background: #eff6ff;
}

.image-thumbnail {
  position: relative;
  width: 100%;
  height: 200px;
  background: #f3f4f6;
  overflow: hidden;
}

.image-thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.image-card:hover .image-overlay {
  opacity: 1;
}

.overlay-btn {
  width: 44px;
  height: 44px;
  background: white;
  border: none;
  border-radius: 50%;
  color: #4f46e5;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  font-size: 16px;
}

.overlay-btn:hover {
  transform: scale(1.1);
  background: #4f46e5;
  color: white;
}

.image-type-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.image-type-badge.xray {
  background: #dbeafe;
  color: #1e40af;
}

.image-type-badge.photo {
  background: #d1fae5;
  color: #065f46;
}

.image-type-badge.scan {
  background: #e9d5ff;
  color: #6b21a8;
}

.image-type-badge.cbct {
  background: #fef3c7;
  color: #92400e;
}

.image-type-badge.document {
  background: #f3f4f6;
  color: #374151;
}

.image-info {
  padding: 16px;
}

.image-info h4 {
  font-size: 15px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 8px 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.image-date,
.image-teeth {
  font-size: 13px;
  color: #6b7280;
  margin: 4px 0;
  display: flex;
  align-items: center;
  gap: 6px;
}

.image-date i,
.image-teeth i {
  font-size: 11px;
  color: #9ca3af;
}

.image-meta {
  display: flex;
  gap: 12px;
  margin-top: 12px;
  padding-top: 12px;
  border-top: 1px solid #f3f4f6;
}

.meta-item {
  font-size: 11px;
  color: #9ca3af;
  display: flex;
  align-items: center;
  gap: 4px;
}

.meta-item i {
  font-size: 10px;
}

/* List View */
.list-view {
  overflow-x: auto;
}

.images-table {
  width: 100%;
  border-collapse: collapse;
}

.images-table th {
  background: #f9fafb;
  padding: 12px 16px;
  text-align: left;
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-bottom: 2px solid #e5e7eb;
}

.images-table td {
  padding: 12px 16px;
  font-size: 14px;
  color: #374151;
  border-bottom: 1px solid #f3f4f6;
}

.images-table tbody tr {
  cursor: pointer;
  transition: background 0.15s ease;
}

.images-table tbody tr:hover {
  background: #f9fafb;
}

.images-table tbody tr.selected {
  background: #eff6ff;
}

.checkbox-cell {
  width: 40px;
}

.checkbox-cell input[type="checkbox"] {
  width: 16px;
  height: 16px;
  cursor: pointer;
  accent-color: #4f46e5;
}

.preview-cell {
  width: 80px;
}

.preview-cell img {
  width: 60px;
  height: 45px;
  border-radius: 6px;
  object-fit: cover;
  border: 1px solid #e5e7eb;
}

.title-cell {
  min-width: 200px;
}

.title-cell strong {
  display: block;
  margin-bottom: 4px;
  color: #111827;
}

.title-cell .description {
  font-size: 12px;
  color: #9ca3af;
}

.type-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
}

.type-badge.xray {
  background: #dbeafe;
  color: #1e40af;
}

.type-badge.photo {
  background: #d1fae5;
  color: #065f46;
}

.type-badge.scan {
  background: #e9d5ff;
  color: #6b21a8;
}

.type-badge.cbct {
  background: #fef3c7;
  color: #92400e;
}

.type-badge.document {
  background: #f3f4f6;
  color: #374151;
}

.actions-cell {
  width: 100px;
}

.action-btn {
  width: 32px;
  height: 32px;
  border: none;
  background: transparent;
  color: #6b7280;
  cursor: pointer;
  border-radius: 6px;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-right: 4px;
}

.action-btn:hover {
  background: #f3f4f6;
  color: #4f46e5;
}

.action-btn.delete:hover {
  background: #fee2e2;
  color: #dc2626;
}

/* Responsive */
@media (max-width: 768px) {
  .grid-view {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
  }

  .image-thumbnail {
    height: 150px;
  }
}
</style>
