<template>
  <div class="dashboard-container">
    <main class="main">
      <div class="header-section">
        <div>
          <h1 class="page-title">Imaging & File Storage</h1>
          <p class="subtitle">
            Manage files for patient: <span class="patient-name">{{ patientName }}</span>
          </p>
        </div>
        <div class="header-buttons">
          <button class="btn btn-blue">
            <span class="material-symbols-outlined icon-small">upload</span>
            Upload File
          </button>
          <button class="btn btn-light">
            <span class="material-symbols-outlined icon-small">create_new_folder</span>
            New Folder
          </button>
        </div>
      </div>

      <div class="file-list-card">
        <div class="table-header-container">
          <div class="table-header-row">
            <div class="table-header-cell col-name">Name</div>
            <div class="table-header-cell col-type">Type</div>
            <div class="table-header-cell col-date">Date Modified</div>
            <div class="table-header-cell col-size">Size</div>
            <div class="table-header-cell col-actions">Actions</div>
          </div>
        </div>
        <div class="table-rows-container">
          <div v-for="file in files" :key="file.name" class="table-row-item">
            <div class="table-cell-content col-name">
              <span class="material-symbols-outlined icon-margin" :class="file.iconColor">
                {{ file.icon }}
              </span>
              <span class="file-name">{{ file.name }}</span>
            </div>
            <span class="table-cell-content col-type">{{ file.type }}</span>
            <span class="table-cell-content col-date">{{ file.dateModified }}</span>
            <span class="table-cell-content col-size">{{ file.size }}</span>
            <div class="table-cell-content col-actions actions">
              <button class="action-btn">
                <span class="material-symbols-outlined icon-action">edit</span>
              </button>
              <button v-if="file.type !== 'Folder'" class="action-btn action-draw">
                <span class="material-symbols-outlined icon-action">draw</span>
              </button>
              <button class="action-btn action-delete">
                <span class="material-symbols-outlined icon-action">delete</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="integrations-section">
        <h3 class="integrations-title">System Integrations</h3>
        <div class="integrations-grid">
          <div class="integration-card">
            <div class="icon-container-blue">
              <span class="material-symbols-outlined icon-large">dns</span>
            </div>
            <div class="integration-content">
              <p class="integration-heading">PACS Integration</p>
              <p class="integration-description">
                Connect to your Picture Archiving and Communication System for seamless
                data flow.
              </p>
              <a href="#" class="link-btn link-blue">
                Configure Now
                <span class="material-symbols-outlined icon-arrow">arrow_forward</span>
              </a>
            </div>
          </div>
          <div class="integration-card">
            <div class="icon-container-green">
              <span class="material-symbols-outlined icon-large">photo_camera</span>
            </div>
            <div class="integration-content">
              <p class="integration-heading">Auto-import from Imaging Hardware</p>
              <p class="integration-description">
                Automatically pull images directly from connected imaging devices.
              </p>
              <a href="#" class="link-btn link-green">
                Setup Device
                <span class="material-symbols-outlined icon-arrow">arrow_forward</span>
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
};
</script>

<style scoped>
.dashboard-container {
  display: flex;
  background: #ffffff;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.main {
  flex-grow: 1;
  padding: 20px 30px;
  background: #fff;
}

/* Header Section */
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 2rem;
}

.page-title {
  font-size: 28px;
  font-weight: 600;
  color: #303030;
  margin: 0;
  font-family: Poppins;
}

.subtitle {
  color: #34d8d1;
  font-size: 16px;
  font-weight: bold;
  margin-top: 0.25rem;
  font-family: Poppins;
}

.patient-name {
  font-weight: 600;
  color: #111827;
}

.header-buttons {
  display: flex;
  gap: 0.75rem;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  cursor: pointer;
  border: none;
  font-family: inherit;
}

.btn-blue {
  background-color: #2563eb;
  color: #fff;
}

.btn-blue:hover {
  background-color: #1d4ed8;
}

.btn-light {
  background-color: #fff;
  color: #111827;
  border: 1px solid #d1d5db;
}

.btn-light:hover {
  background-color: #f9fafb;
}

.icon-small {
  font-size: 1.25rem;
  margin-right: 0.5rem;
}

/* File List */
.file-list-card {
  background-color: #fff;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
}

.table-header-row,
.table-row-item {
  display: grid;
  grid-template-columns: 3.5fr 2fr 2fr 1.5fr 1.5fr;
  align-items: center;
  padding: 0.75rem 1rem;
  gap: 1rem;
  font-family: Poppins;
}

.table-header-row {
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  background-color: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  text-transform: uppercase;
}

.table-row-item {
  font-size: 0.875rem;
  color: #111827;
  border-bottom: 1px solid #e5e7eb;
  transition: background-color 0.2s;
}

.table-row-item:last-child {
  border-bottom: none;
}

.table-row-item:hover {
  background-color: #f9fafb;
}

.file-name {
  font-weight: 500;
  margin-left: 0.5rem;
  color: #374151;
}

.table-cell-content {
  display: flex;
  align-items: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.col-type,
.col-date {
  color: #6b7280;
}

.col-size {
  color: #6b7280;
}

.actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.25rem;
  opacity: 0;
  transition: opacity 0.2s;
}

.table-row-item:hover .actions {
  opacity: 1;
}

.action-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 9999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.action-btn:hover {
  background-color: #f3f4f6;
}

.icon-action {
  font-size: 1.125rem;
  color: #6b7280;
}

.action-btn:hover .icon-action {
  color: #2563eb;
}

.action-draw:hover .icon-action {
  color: #16a34a;
}

.action-delete:hover .icon-action {
  color: #ef4444;
}

/* Integrations Section */
.integrations-section {
  margin-top: 2.5rem;
}

.integrations-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  font-family: Poppins;
}

.integrations-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1.5rem;
}

.integration-card {
  display: flex;
  align-items: flex-start;
  background-color: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  padding: 1.25rem;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  transition: box-shadow 0.2s;
}

.integration-card:hover {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
}

.icon-container-blue,
.icon-container-green {
  padding: 0.75rem;
  border-radius: 0.5rem;
  flex-shrink: 0;
  margin-right: 1rem;
}

.icon-container-blue {
  background-color: #dbeafe;
  color: #2563eb;
}

.icon-container-green {
  background-color: #dcfce7;
  color: #16a34a;
}

.icon-large {
  font-size: 1.5rem;
}

.integration-heading {
  font-size: 1rem;
  font-weight: 600;
  margin: 0;
  color: #111827;
  font-family: Poppins;
}

.integration-description {
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0.25rem 0 0.75rem;
}

.link-btn {
  font-size: 0.875rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  background: none;
  border: none;
  padding: 0;
  color: inherit;
  font-family: Poppins;
  text-decoration: none;
}

.link-blue {
  color: #2563eb;
}

.link-blue:hover {
  color: #1d4ed8;
}

.link-green {
  color: #16a34a;
}

.link-green:hover {
  color: #15803d;
}

.icon-arrow {
  margin-left: 0.25rem;
  font-size: 1rem;
  transition: transform 0.2s;
}

.link-btn:hover .icon-arrow {
  transform: translateX(0.25rem);
}
</style>
