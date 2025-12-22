<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">New Appointment</h3>
        <button class="close-btn" @click="$emit('close')">
          <span class="material-icons">close</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="appointment-form">
          <div class="form-group">
            <label for="patient-name">Patient Name</label>
            <input
              type="text"
              id="patient-name"
              placeholder="Search or add new patient"
            />
          </div>
          <div class="form-group">
            <label for="practitioner">Practitioner</label>
            <select id="practitioner">
              <option value="">Select a practitioner</option>
              <option v-for="p in practitioners" :key="p" :value="p">{{ p }}</option>
            </select>
          </div>
          <div class="form-group-inline">
            <div class="form-group">
              <label for="start-date">Date</label>
              <input type="date" id="start-date" />
            </div>
            <div class="form-group">
              <label for="start-time">Start Time</label>
              <input type="time" id="start-time" />
            </div>
          </div>
          <div class="form-group">
            <label for="appointment-type">Appointment Type</label>
            <select id="appointment-type">
              <option value="">Select a type</option>
              <option value="exam">Exam</option>
              <option value="cleaning">Cleaning</option>
              <option value="emergency">Emergency</option>
              <option value="consultation">Consultation</option>
            </select>
          </div>
          <div class="form-group">
            <label for="notes">Notes</label>
            <textarea
              id="notes"
              rows="3"
              placeholder="Add appointment notes..."
            ></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="modal-cancel-btn" @click="$emit('close')">Cancel</button>
        <button class="modal-save-btn">Create Appointment</button>
      </div>
    </div>
  </div>
</template>

<script setup>

defineProps({
  practitioners: {
    type: Array,
    required: true,
  },
});

defineEmits(["close"]);
</script>

<style scoped>
/* All the CSS from your original code related to the modal goes here */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 50;
}

.modal-content {
  background-color: white;
  border-radius: 0.5rem;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin: 0;
}

.close-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 9999px;
  color: #6b7280;
  transition: background-color 0.2s;
}

.close-btn:hover {
  background-color: #f3f4f6;
}

.modal-body {
  padding: 1.5rem;
  overflow-y: auto;
}

.appointment-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.25rem;
}

.form-group input,
.form-group select,
.form-group textarea {
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  font-size: 1rem;
}

.form-group-inline {
  display: flex;
  gap: 1rem;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
  padding: 1rem 1.5rem;
  border-top: 1px solid #e5e7eb;
}

.modal-cancel-btn {
  background-color: transparent;
  border: 1px solid #d1d5db;
  color: #374151;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.modal-save-btn {
  background-color: #2563eb;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
}
</style>
