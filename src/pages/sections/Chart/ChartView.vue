<template>
  <div class="chart-container">
    <!-- Main Chart Area -->
    <div class="chart-main">
      <!-- Patient Header -->
      <div class="patient-header-card">
        <div class="patient-info">
          <h2>{{ patient.name }}</h2>
          <p>DOB: {{ patient.dob }} | ID: {{ patient.id }} | Last Visit: {{ patient.lastVisit }}</p>
        </div>
        <div class="chart-mode-toggle">
          <button
            :class="['mode-btn', { active: chartMode === 'permanent' }]"
            @click="chartMode = 'permanent'"
          >
            Adult (1-32)
          </button>
          <button
            :class="['mode-btn', { active: chartMode === 'primary' }]"
            @click="chartMode = 'primary'"
          >
            Pediatric (A-T)
          </button>
        </div>
      </div>

      <!-- Dental Chart -->
      <div class="dental-chart-card">
        <h3 class="chart-title">Dental Chart - Universal Numbering System</h3>

        <!-- Upper Jaw -->
        <div class="jaw-section">
          <div class="jaw-label">Upper</div>
          <div class="teeth-row upper-row">
            <div
              v-for="tooth in upperTeeth"
              :key="tooth.number"
              :class="['tooth-wrapper', { selected: selectedTooth?.number === tooth.number }]"
              @click="selectTooth(tooth)"
            >
              <div class="tooth-number-label">{{ tooth.number }}</div>
              <div :class="['tooth-visual', getToothStatusClass(tooth)]">
                <svg viewBox="0 0 40 50" class="tooth-svg">
                  <!-- Tooth shape (molar/premolar/incisor) -->
                  <path
                    :d="getToothPath(tooth.type)"
                    :fill="getToothFill(tooth)"
                    stroke="#333"
                    stroke-width="1"
                  />
                  <!-- Surface indicators -->
                  <g v-if="tooth.surfaces">
                    <circle v-if="tooth.surfaces.occlusal" cx="20" cy="15" r="4" fill="#ef4444" opacity="0.8"/>
                    <circle v-if="tooth.surfaces.mesial" cx="10" cy="25" r="3" fill="#ef4444" opacity="0.8"/>
                    <circle v-if="tooth.surfaces.distal" cx="30" cy="25" r="3" fill="#ef4444" opacity="0.8"/>
                    <circle v-if="tooth.surfaces.buccal" cx="20" cy="35" r="3" fill="#ef4444" opacity="0.8"/>
                  </g>
                </svg>
                <!-- Status indicators -->
                <div v-if="tooth.hasNote" class="note-indicator"></div>
              </div>
              <div class="tooth-name">{{ tooth.name }}</div>
            </div>
          </div>
        </div>

        <!-- Lower Jaw -->
        <div class="jaw-section">
          <div class="teeth-row lower-row">
            <div
              v-for="tooth in lowerTeeth"
              :key="tooth.number"
              :class="['tooth-wrapper', { selected: selectedTooth?.number === tooth.number }]"
              @click="selectTooth(tooth)"
            >
              <div class="tooth-name">{{ tooth.name }}</div>
              <div :class="['tooth-visual', getToothStatusClass(tooth)]">
                <svg viewBox="0 0 40 50" class="tooth-svg">
                  <path
                    :d="getToothPath(tooth.type)"
                    :fill="getToothFill(tooth)"
                    stroke="#333"
                    stroke-width="1"
                  />
                  <g v-if="tooth.surfaces">
                    <circle v-if="tooth.surfaces.occlusal" cx="20" cy="35" r="4" fill="#ef4444" opacity="0.8"/>
                    <circle v-if="tooth.surfaces.mesial" cx="10" cy="25" r="3" fill="#ef4444" opacity="0.8"/>
                    <circle v-if="tooth.surfaces.distal" cx="30" cy="25" r="3" fill="#ef4444" opacity="0.8"/>
                    <circle v-if="tooth.surfaces.buccal" cx="20" cy="15" r="3" fill="#ef4444" opacity="0.8"/>
                  </g>
                </svg>
                <div v-if="tooth.hasNote" class="note-indicator"></div>
              </div>
              <div class="tooth-number-label">{{ tooth.number }}</div>
            </div>
          </div>
          <div class="jaw-label">Lower</div>
        </div>

        <!-- Legend -->
        <div class="legend-section">
          <h4>Legend:</h4>
          <div class="legend-items">
            <div class="legend-item"><span class="legend-color" style="background: #fff"></span> Healthy</div>
            <div class="legend-item"><span class="legend-color" style="background: #ef4444"></span> Decay</div>
            <div class="legend-item"><span class="legend-color" style="background: #3b82f6"></span> Filling</div>
            <div class="legend-item"><span class="legend-color" style="background: #fbbf24"></span> Crown</div>
            <div class="legend-item"><span class="legend-color" style="background: #10b981"></span> Implant</div>
            <div class="legend-item"><span class="legend-color" style="background: #6b7280"></span> Missing</div>
            <div class="legend-item"><span class="legend-color note" style="background: #f59e0b"></span> Has Note</div>
          </div>
        </div>
      </div>

      <!-- Action Tabs -->
      <div class="action-tabs-card">
        <div class="tab-buttons">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            :class="['tab-btn', { active: activeTab === tab.id }]"
            @click="activeTab = tab.id"
          >
            {{ tab.label }}
          </button>
        </div>

        <div class="tab-content">
          <div v-if="activeTab === 'treatment'" class="treatment-panel">
            <h4>Treatment for Tooth #{{ selectedTooth?.number || 'N/A' }}</h4>
            <div v-if="selectedTooth">
              <div class="treatment-form">
                <label>Procedure:</label>
                <select v-model="treatmentForm.procedure">
                  <option value="">Select procedure</option>
                  <option value="filling">Filling</option>
                  <option value="crown">Crown</option>
                  <option value="extraction">Extraction</option>
                  <option value="root-canal">Root Canal</option>
                  <option value="cleaning">Cleaning</option>
                </select>

                <label>Surface(s):</label>
                <div class="surface-checkboxes">
                  <label><input type="checkbox" v-model="treatmentForm.surfaces" value="occlusal"> Occlusal</label>
                  <label><input type="checkbox" v-model="treatmentForm.surfaces" value="mesial"> Mesial</label>
                  <label><input type="checkbox" v-model="treatmentForm.surfaces" value="distal"> Distal</label>
                  <label><input type="checkbox" v-model="treatmentForm.surfaces" value="buccal"> Buccal</label>
                  <label><input type="checkbox" v-model="treatmentForm.surfaces" value="lingual"> Lingual</label>
                </div>

                <label>Notes:</label>
                <textarea v-model="treatmentForm.notes" rows="4" placeholder="Enter treatment notes..."></textarea>

                <button @click="saveTreatment" class="save-btn">Save Treatment</button>
              </div>
            </div>
            <p v-else class="no-selection">Please select a tooth to add treatment</p>
          </div>

          <div v-if="activeTab === 'history'" class="history-panel">
            <h4>Treatment History</h4>
            <div class="history-list">
              <div v-for="entry in treatmentHistory" :key="entry.id" class="history-entry">
                <div class="entry-date">{{ entry.date }}</div>
                <div class="entry-tooth">Tooth #{{ entry.toothNumber }}</div>
                <div class="entry-procedure">{{ entry.procedure }}</div>
                <div class="entry-notes">{{ entry.notes }}</div>
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'imaging'" class="imaging-panel">
            <h4>X-Rays & Images - Tooth #{{ selectedTooth?.number || 'N/A' }}</h4>
            <div v-if="selectedTooth && selectedTooth.images?.length" class="image-gallery">
              <div v-for="(img, idx) in selectedTooth.images" :key="idx" class="image-item">
                <img :src="img.url" :alt="img.description" />
                <p>{{ img.description }}</p>
              </div>
            </div>
            <p v-else class="no-data">No images available</p>
          </div>

          <div v-if="activeTab === 'perio'" class="perio-panel">
            <h4>Periodontal Chart</h4>
            <div class="perio-grid">
              <div class="perio-info">
                <p>Probing depths, bleeding points, and mobility tracking</p>
                <button class="add-perio-btn">Add Periodontal Data</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Sidebar -->
    <div class="chart-sidebar">
      <div class="sidebar-card">
        <h3>Selected Tooth</h3>
        <div v-if="selectedTooth" class="tooth-details">
          <div class="detail-row">
            <span class="label">Number:</span>
            <span class="value">#{{ selectedTooth.number }}</span>
          </div>
          <div class="detail-row">
            <span class="label">Name:</span>
            <span class="value">{{ selectedTooth.name }}</span>
          </div>
          <div class="detail-row">
            <span class="label">Type:</span>
            <span class="value">{{ selectedTooth.type }}</span>
          </div>
          <div class="detail-row">
            <span class="label">Status:</span>
            <span class="value">{{ getToothStatus(selectedTooth) }}</span>
          </div>

          <div v-if="selectedTooth.conditions?.length" class="conditions-section">
            <h4>Conditions:</h4>
            <ul>
              <li v-for="condition in selectedTooth.conditions" :key="condition">
                {{ condition }}
              </li>
            </ul>
          </div>
        </div>
        <p v-else class="no-selection-text">Click on a tooth to view details</p>
      </div>

      <div class="sidebar-card">
        <h3>Quick Actions</h3>
        <button class="action-btn" @click="markAsDecay">Mark Decay</button>
        <button class="action-btn" @click="markAsFilling">Mark Filling</button>
        <button class="action-btn" @click="markAsCrown">Mark Crown</button>
        <button class="action-btn" @click="markAsMissing">Mark Missing</button>
        <button class="action-btn danger" @click="clearStatus">Clear Status</button>
      </div>

      <div class="sidebar-card">
        <h3>Patient Notes</h3>
        <textarea
          v-model="patientNotes"
          placeholder="Add general patient notes..."
          rows="6"
          class="notes-textarea"
        ></textarea>
        <button class="save-notes-btn">Save Notes</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const patient = ref({
  name: 'John Smith',
  dob: '03/15/1985',
  id: 'P-12345',
  lastVisit: '01/10/2025'
});

const chartMode = ref('permanent');
const selectedTooth = ref(null);
const activeTab = ref('treatment');
const patientNotes = ref('');

const tabs = [
  { id: 'treatment', label: 'Treatment' },
  { id: 'history', label: 'History' },
  { id: 'imaging', label: 'Imaging' },
  { id: 'perio', label: 'Periodontal' }
];

const treatmentForm = ref({
  procedure: '',
  surfaces: [],
  notes: ''
});

// Universal Numbering System: 1-32
const permanentTeeth = ref([
  // Upper Right Quadrant (1-8)
  { number: 1, name: 'UR 3rd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 2, name: 'UR 2nd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 3, name: 'UR 1st Molar', type: 'molar', status: 'filling', surfaces: { occlusal: true }, hasNote: true, conditions: ['Occlusal filling'] },
  { number: 4, name: 'UR 2nd Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 5, name: 'UR 1st Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 6, name: 'UR Canine', type: 'canine', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 7, name: 'UR Lateral Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 8, name: 'UR Central Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  // Upper Left Quadrant (9-16)
  { number: 9, name: 'UL Central Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 10, name: 'UL Lateral Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 11, name: 'UL Canine', type: 'canine', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 12, name: 'UL 1st Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 13, name: 'UL 2nd Premolar', type: 'premolar', status: 'decay', surfaces: { mesial: true }, hasNote: true, conditions: ['Mesial decay'] },
  { number: 14, name: 'UL 1st Molar', type: 'molar', status: 'crown', surfaces: null, hasNote: false, conditions: ['Crown'] },
  { number: 15, name: 'UL 2nd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 16, name: 'UL 3rd Molar', type: 'molar', status: 'missing', surfaces: null, hasNote: false, conditions: ['Extracted'] },
  // Lower Left Quadrant (17-24)
  { number: 17, name: 'LL 3rd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 18, name: 'LL 2nd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 19, name: 'LL 1st Molar', type: 'molar', status: 'implant', surfaces: null, hasNote: true, conditions: ['Implant'] },
  { number: 20, name: 'LL 2nd Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 21, name: 'LL 1st Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 22, name: 'LL Canine', type: 'canine', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 23, name: 'LL Lateral Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 24, name: 'LL Central Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  // Lower Right Quadrant (25-32)
  { number: 25, name: 'LR Central Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 26, name: 'LR Lateral Incisor', type: 'incisor', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 27, name: 'LR Canine', type: 'canine', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 28, name: 'LR 1st Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 29, name: 'LR 2nd Premolar', type: 'premolar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 30, name: 'LR 1st Molar', type: 'molar', status: 'filling', surfaces: { occlusal: true, distal: true }, hasNote: false, conditions: ['DO filling'] },
  { number: 31, name: 'LR 2nd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
  { number: 32, name: 'LR 3rd Molar', type: 'molar', status: 'healthy', surfaces: null, hasNote: false, conditions: [] },
]);

const treatmentHistory = ref([
  { id: 1, date: '2025-01-05', toothNumber: 3, procedure: 'Filling', notes: 'Occlusal composite filling' },
  { id: 2, date: '2024-12-10', toothNumber: 14, procedure: 'Crown', notes: 'PFM crown placement' },
  { id: 3, date: '2024-11-20', toothNumber: 19, procedure: 'Implant', notes: 'Implant placed, osseointegration in progress' },
]);

const upperTeeth = computed(() => permanentTeeth.value.slice(0, 16));
const lowerTeeth = computed(() => permanentTeeth.value.slice(16, 32));

function selectTooth(tooth) {
  selectedTooth.value = tooth;
  activeTab.value = 'treatment';
}

function getToothPath(type) {
  // SVG paths for different tooth types
  const paths = {
    molar: 'M 5 10 Q 5 5 10 5 L 30 5 Q 35 5 35 10 L 35 40 Q 35 45 30 45 L 10 45 Q 5 45 5 40 Z',
    premolar: 'M 8 10 Q 8 6 12 6 L 28 6 Q 32 6 32 10 L 32 42 Q 32 46 28 46 L 12 46 Q 8 46 8 42 Z',
    canine: 'M 10 8 Q 10 5 15 5 L 25 5 Q 30 5 30 8 L 28 44 Q 28 47 24 47 L 16 47 Q 12 47 12 44 Z',
    incisor: 'M 12 10 Q 12 6 16 6 L 24 6 Q 28 6 28 10 L 26 44 Q 26 47 22 47 L 18 47 Q 14 47 14 44 Z'
  };
  return paths[type] || paths.molar;
}

function getToothFill(tooth) {
  const colors = {
    healthy: '#fff',
    decay: '#ef4444',
    filling: '#3b82f6',
    crown: '#fbbf24',
    implant: '#10b981',
    missing: '#6b7280'
  };
  return colors[tooth.status] || '#fff';
}

function getToothStatusClass(tooth) {
  return `status-${tooth.status}`;
}

function getToothStatus(tooth) {
  return tooth.status.charAt(0).toUpperCase() + tooth.status.slice(1);
}

function markAsDecay() {
  if (selectedTooth.value) {
    selectedTooth.value.status = 'decay';
  }
}

function markAsFilling() {
  if (selectedTooth.value) {
    selectedTooth.value.status = 'filling';
  }
}

function markAsCrown() {
  if (selectedTooth.value) {
    selectedTooth.value.status = 'crown';
  }
}

function markAsMissing() {
  if (selectedTooth.value) {
    selectedTooth.value.status = 'missing';
  }
}

function clearStatus() {
  if (selectedTooth.value) {
    selectedTooth.value.status = 'healthy';
    selectedTooth.value.surfaces = null;
  }
}

function saveTreatment() {
  if (!selectedTooth.value) return;

  const newEntry = {
    id: Date.now(),
    date: new Date().toLocaleDateString(),
    toothNumber: selectedTooth.value.number,
    procedure: treatmentForm.value.procedure,
    notes: treatmentForm.value.notes
  };

  treatmentHistory.value.unshift(newEntry);

  // Update tooth status based on procedure
  if (treatmentForm.value.procedure === 'filling') {
    selectedTooth.value.status = 'filling';
  } else if (treatmentForm.value.procedure === 'crown') {
    selectedTooth.value.status = 'crown';
  }

  // Reset form
  treatmentForm.value = {
    procedure: '',
    surfaces: [],
    notes: ''
  };

  alert('Treatment saved successfully!');
}
</script>

<style scoped>
.chart-container {
  display: flex;
  gap: 24px;
  padding: 24px;
  background: #f5f5f5;
  min-height: 100vh;
}

.chart-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.patient-header-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.patient-info h2 {
  margin: 0 0 8px 0;
  font-size: 24px;
  color: #1a1a1a;
}

.patient-info p {
  margin: 0;
  color: #666;
  font-size: 14px;
}

.chart-mode-toggle {
  display: flex;
  gap: 8px;
}

.mode-btn {
  padding: 10px 20px;
  border: 2px solid #e0e0e0;
  background: white;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s;
}

.mode-btn.active {
  background: #4f46e5;
  color: white;
  border-color: #4f46e5;
}

.dental-chart-card {
  background: white;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.chart-title {
  margin: 0 0 30px 0;
  font-size: 20px;
  color: #1a1a1a;
  text-align: center;
}

.jaw-section {
  margin-bottom: 30px;
}

.jaw-label {
  font-weight: 700;
  font-size: 14px;
  color: #666;
  text-align: center;
  margin: 10px 0;
}

.teeth-row {
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}

.tooth-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  padding: 8px;
  border-radius: 8px;
  transition: all 0.3s;
}

.tooth-wrapper:hover {
  background: #f0f0f0;
  transform: translateY(-2px);
}

.tooth-wrapper.selected {
  background: #e0e7ff;
  border: 2px solid #4f46e5;
}

.tooth-number-label {
  font-size: 12px;
  font-weight: 700;
  color: #333;
  margin: 4px 0;
}

.tooth-name {
  font-size: 10px;
  color: #666;
  text-align: center;
  margin: 4px 0;
}

.tooth-visual {
  width: 50px;
  height: 60px;
  position: relative;
  border: 2px solid #ddd;
  border-radius: 8px;
  background: #fafafa;
  display: flex;
  align-items: center;
  justify-content: center;
}

.tooth-svg {
  width: 100%;
  height: 100%;
}

.note-indicator {
  position: absolute;
  top: 2px;
  right: 2px;
  width: 8px;
  height: 8px;
  background: #f59e0b;
  border-radius: 50%;
  border: 1px solid white;
}

.legend-section {
  margin-top: 30px;
  padding-top: 20px;
  border-top: 2px solid #e0e0e0;
}

.legend-section h4 {
  margin: 0 0 12px 0;
  font-size: 16px;
}

.legend-items {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
}

.legend-color {
  width: 24px;
  height: 24px;
  border-radius: 4px;
  border: 2px solid #333;
}

.legend-color.note {
  border-radius: 50%;
}

.action-tabs-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.tab-buttons {
  display: flex;
  gap: 8px;
  margin-bottom: 20px;
  border-bottom: 2px solid #e0e0e0;
  padding-bottom: 10px;
}

.tab-btn {
  padding: 10px 20px;
  border: none;
  background: transparent;
  cursor: pointer;
  font-weight: 600;
  color: #666;
  border-bottom: 3px solid transparent;
  transition: all 0.3s;
}

.tab-btn.active {
  color: #4f46e5;
  border-bottom-color: #4f46e5;
}

.tab-content {
  min-height: 300px;
}

.treatment-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.treatment-form label {
  font-weight: 600;
  color: #333;
  margin-bottom: 4px;
}

.treatment-form select,
.treatment-form textarea {
  padding: 10px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
}

.surface-checkboxes {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
}

.surface-checkboxes label {
  display: flex;
  align-items: center;
  gap: 6px;
  font-weight: 400;
}

.save-btn {
  padding: 12px 24px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.save-btn:hover {
  background: #4338ca;
}

.no-selection {
  color: #999;
  text-align: center;
  padding: 40px;
  font-style: italic;
}

.history-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.history-entry {
  padding: 16px;
  background: #f9fafb;
  border-left: 4px solid #4f46e5;
  border-radius: 8px;
}

.entry-date {
  font-size: 12px;
  color: #666;
  margin-bottom: 4px;
}

.entry-tooth {
  font-weight: 700;
  color: #333;
  margin-bottom: 4px;
}

.entry-procedure {
  color: #4f46e5;
  font-weight: 600;
  margin-bottom: 8px;
}

.entry-notes {
  font-size: 14px;
  color: #666;
}

.no-data {
  color: #999;
  text-align: center;
  padding: 40px;
  font-style: italic;
}

/* Sidebar */
.chart-sidebar {
  width: 350px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.sidebar-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.sidebar-card h3 {
  margin: 0 0 16px 0;
  font-size: 18px;
  color: #1a1a1a;
  border-bottom: 2px solid #e0e0e0;
  padding-bottom: 12px;
}

.tooth-details {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-bottom: 1px solid #f0f0f0;
}

.detail-row .label {
  font-weight: 600;
  color: #666;
}

.detail-row .value {
  color: #1a1a1a;
  font-weight: 500;
}

.conditions-section {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 2px solid #e0e0e0;
}

.conditions-section h4 {
  margin: 0 0 8px 0;
  font-size: 14px;
  color: #333;
}

.conditions-section ul {
  margin: 0;
  padding-left: 20px;
}

.conditions-section li {
  color: #666;
  font-size: 14px;
  margin-bottom: 4px;
}

.no-selection-text {
  color: #999;
  text-align: center;
  font-style: italic;
  padding: 20px 0;
}

.action-btn {
  width: 100%;
  padding: 12px;
  margin-bottom: 10px;
  border: 2px solid #e0e0e0;
  background: white;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s;
}

.action-btn:hover {
  background: #f0f0f0;
  border-color: #4f46e5;
  color: #4f46e5;
}

.action-btn.danger {
  color: #ef4444;
  border-color: #ef4444;
}

.action-btn.danger:hover {
  background: #fef2f2;
}

.notes-textarea {
  width: 100%;
  padding: 12px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  resize: vertical;
  margin-bottom: 12px;
}

.save-notes-btn {
  width: 100%;
  padding: 12px;
  background: #10b981;
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.save-notes-btn:hover {
  background: #059669;
}

.image-gallery {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.image-item img {
  width: 100%;
  border-radius: 8px;
  border: 2px solid #e0e0e0;
}

.image-item p {
  font-size: 12px;
  color: #666;
  margin-top: 8px;
  text-align: center;
}

.perio-info {
  text-align: center;
  padding: 40px;
}

.add-perio-btn {
  margin-top: 16px;
  padding: 12px 24px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
}
</style>
