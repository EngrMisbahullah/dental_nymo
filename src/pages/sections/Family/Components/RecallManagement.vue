<template>
  <div class="recall-card">
    <div class="card-header">
      <h3>
        <i class="fas fa-calendar-check"></i>
        Recall Management
      </h3>
    </div>
    <div class="card-body">
      <div v-if="!member" class="empty-state">
        <i class="fas fa-user-clock"></i>
        <p>Select a family member to manage recalls</p>
      </div>

      <div v-else>
        <div class="patient-name">
          <strong>{{ member.name }}</strong>
        </div>

        <div class="recall-table">
          <table>
            <thead>
              <tr>
                <th>Type</th>
                <th>Interval</th>
                <th>Previous</th>
                <th>Due Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="recall in recalls" :key="recall.type">
                <td>{{ recall.type }}</td>
                <td>{{ recall.interval }}</td>
                <td>{{ recall.previous }}</td>
                <td :class="{ overdue: isOverdue(recall.dueDate) }">
                  {{ recall.dueDate }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="add-recall-section">
          <button class="btn-add-recall" @click="showAddRecall = !showAddRecall">
            <i class="fas fa-plus"></i>
            Add New Recall
          </button>

          <div v-if="showAddRecall" class="add-recall-form">
            <div class="form-group">
              <label>Recall Type</label>
              <select v-model="newRecall.type">
                <option value="">Select Type</option>
                <option value="Prophy">Prophy (Cleaning)</option>
                <option value="Perio">Perio (Periodontal)</option>
                <option value="Exam">Exam</option>
                <option value="Bitewing">Bitewing X-Ray</option>
                <option value="Pano">Panoramic X-Ray</option>
                <option value="Custom">Custom</option>
              </select>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Interval</label>
                <select v-model="newRecall.interval">
                  <option value="3 months">3 Months</option>
                  <option value="6 months">6 Months</option>
                  <option value="12 months">12 Months</option>
                  <option value="24 months">24 Months</option>
                </select>
              </div>

              <div class="form-group">
                <label>Due Date</label>
                <input v-model="newRecall.dueDate" type="date" />
              </div>
            </div>

            <div class="form-actions">
              <button class="btn-cancel" @click="cancelAddRecall">Cancel</button>
              <button class="btn-save" @click="saveRecall">
                <i class="fas fa-check"></i>
                Save Recall
              </button>
            </div>
          </div>
        </div>

        <div class="recall-notes">
          <label>Notes</label>
          <textarea
            v-model="recallNotes"
            rows="3"
            placeholder="Add recall notes..."
          ></textarea>
        </div>

        <button class="btn-schedule">
          <i class="fas fa-calendar-plus"></i>
          Schedule Recall Appointment
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  member: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['update']);

const showAddRecall = ref(false);
const recallNotes = ref('');

const newRecall = ref({
  type: '',
  interval: '6 months',
  dueDate: ''
});

const recalls = ref([
  {
    type: 'Prophy',
    interval: '6 months',
    previous: '2025-05-15',
    dueDate: '2025-11-15'
  },
  {
    type: 'Exam',
    interval: '12 months',
    previous: '2024-11-03',
    dueDate: '2025-11-03'
  }
]);

watch(() => props.member, (newMember) => {
  if (newMember) {
    // Load recalls for this member (would be from API)
    recallNotes.value = '';
  }
});

const isOverdue = (dueDate) => {
  if (!dueDate) return false;
  return new Date(dueDate) < new Date();
};

const saveRecall = () => {
  if (!newRecall.value.type || !newRecall.value.dueDate) {
    alert('Please fill in all required fields');
    return;
  }

  recalls.value.push({
    type: newRecall.value.type,
    interval: newRecall.value.interval,
    previous: 'N/A',
    dueDate: newRecall.value.dueDate
  });

  emit('update', { dueDate: newRecall.value.dueDate });
  cancelAddRecall();
};

const cancelAddRecall = () => {
  showAddRecall.value = false;
  newRecall.value = {
    type: '',
    interval: '6 months',
    dueDate: ''
  };
};
</script>

<style scoped>
.recall-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}

.card-header {
  padding: 20px;
  border-bottom: 1.5px solid #e5e7eb;
}

.card-header h3 {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.card-header i {
  color: #10b981;
}

.card-body {
  padding: 20px;
}

.empty-state {
  text-align: center;
  padding: 40px 20px;
  color: #9ca3af;
}

.empty-state i {
  font-size: 48px;
  margin-bottom: 12px;
  display: block;
}

.empty-state p {
  margin: 0;
  font-size: 14px;
}

.patient-name {
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid #f3f4f6;
}

.patient-name strong {
  font-size: 15px;
  color: #111827;
}

.recall-table {
  margin-bottom: 20px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  overflow: hidden;
}

.recall-table table {
  width: 100%;
  border-collapse: collapse;
}

.recall-table th {
  background: #f9fafb;
  padding: 10px 12px;
  text-align: left;
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
}

.recall-table td {
  padding: 12px;
  font-size: 13px;
  color: #374151;
  border-top: 1px solid #f3f4f6;
}

.recall-table td.overdue {
  color: #dc2626;
  font-weight: 600;
}

.add-recall-section {
  margin-bottom: 20px;
}

.btn-add-recall {
  width: 100%;
  padding: 10px;
  border: 1.5px dashed #d1d5db;
  background: white;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-add-recall:hover {
  border-color: #4f46e5;
  color: #4f46e5;
  background: #f9fafb;
}

.add-recall-form {
  margin-top: 16px;
  padding: 16px;
  background: #f9fafb;
  border-radius: 8px;
  border: 1.5px solid #e5e7eb;
}

.form-group {
  margin-bottom: 14px;
}

.form-group:last-child {
  margin-bottom: 0;
}

.form-group label {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 6px;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 8px 12px;
  border: 1.5px solid #e5e7eb;
  border-radius: 6px;
  font-size: 13px;
  background: white;
  color: #111827;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.form-actions {
  display: flex;
  gap: 10px;
  margin-top: 14px;
}

.btn-cancel,
.btn-save {
  flex: 1;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

.btn-cancel {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
}

.btn-cancel:hover {
  background: #f3f4f6;
}

.btn-save {
  background: #10b981;
  color: white;
}

.btn-save:hover {
  background: #059669;
}

.recall-notes {
  margin-bottom: 16px;
}

.recall-notes label {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.recall-notes textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 13px;
  font-family: inherit;
  resize: vertical;
}

.recall-notes textarea:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.btn-schedule {
  width: 100%;
  padding: 12px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-schedule:hover {
  background: #4338ca;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}
</style>
