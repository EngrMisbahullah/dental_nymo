<template>
  <div class="info-card">
    <div class="card-header">
      <h3>
        <i class="fas fa-user-circle"></i>
        Patient Information
      </h3>
      <button v-if="member" class="btn-edit" @click="isEditing = !isEditing">
        <i :class="isEditing ? 'fas fa-times' : 'fas fa-pen'"></i>
      </button>
    </div>
    <div class="card-body">
      <div v-if="!member" class="empty-state">
        <i class="fas fa-user-slash"></i>
        <p>Select a family member to view information</p>
      </div>

      <div v-else-if="!isEditing" class="info-view">
        <div class="info-item">
          <span class="info-label">Full Name</span>
          <span class="info-value">{{ member.name }}</span>
        </div>

        <div class="info-item">
          <span class="info-label">Date of Birth</span>
          <span class="info-value">{{ formatDate(member.dob) }}</span>
        </div>

        <div class="info-item">
          <span class="info-label">Age</span>
          <span class="info-value">{{ calculateAge(member.dob) }} years</span>
        </div>

        <div class="info-item">
          <span class="info-label">Gender</span>
          <span class="info-value">
            <i :class="member.gender === 'Male' ? 'fas fa-mars' : 'fas fa-venus'"></i>
            {{ member.gender }}
          </span>
        </div>

        <div class="info-item">
          <span class="info-label">Relationship</span>
          <span class="info-value">{{ member.relationship }}</span>
        </div>

        <div class="info-item">
          <span class="info-label">Role</span>
          <span class="info-value">
            <span class="role-badge" :class="member.role.toLowerCase()">
              <i v-if="member.role === 'Guarantor'" class="fas fa-star"></i>
              {{ member.role }}
            </span>
          </span>
        </div>

        <div class="info-item">
          <span class="info-label">Status</span>
          <span class="info-value">
            <span class="status-badge" :class="member.status.toLowerCase()">
              {{ member.status }}
            </span>
          </span>
        </div>

        <div v-if="member.phone" class="info-item">
          <span class="info-label">Phone</span>
          <span class="info-value">
            <i class="fas fa-phone"></i>
            {{ member.phone }}
          </span>
        </div>

        <div v-if="member.email" class="info-item">
          <span class="info-label">Email</span>
          <span class="info-value">
            <i class="fas fa-envelope"></i>
            {{ member.email }}
          </span>
        </div>

        <div v-if="member.address" class="info-item full-width">
          <span class="info-label">Address</span>
          <span class="info-value">{{ member.address }}</span>
        </div>
      </div>

      <div v-else class="info-edit">
        <div class="form-group">
          <label>Phone</label>
          <input v-model="editData.phone" type="tel" placeholder="(123) 456-7890" />
        </div>

        <div class="form-group">
          <label>Email</label>
          <input v-model="editData.email" type="email" placeholder="email@example.com" />
        </div>

        <div class="form-group">
          <label>Address</label>
          <textarea v-model="editData.address" rows="3" placeholder="Enter address"></textarea>
        </div>

        <div class="form-group">
          <label>Status</label>
          <select v-model="editData.status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Pending">Pending</option>
          </select>
        </div>

        <div class="edit-actions">
          <button class="btn-cancel" @click="cancelEdit">Cancel</button>
          <button class="btn-save" @click="saveEdit">
            <i class="fas fa-check"></i>
            Save Changes
          </button>
        </div>
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

const isEditing = ref(false);
const editData = ref({
  phone: '',
  email: '',
  address: '',
  status: ''
});

watch(() => props.member, (newMember) => {
  if (newMember) {
    editData.value = {
      phone: newMember.phone || '',
      email: newMember.email || '',
      address: newMember.address || '',
      status: newMember.status || 'Active'
    };
    isEditing.value = false;
  }
}, { immediate: true });

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};

const calculateAge = (dob) => {
  if (!dob) return 0;
  const today = new Date();
  const birthDate = new Date(dob);
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDiff = today.getMonth() - birthDate.getMonth();
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
};

const saveEdit = () => {
  emit('update', editData.value);
  isEditing.value = false;
};

const cancelEdit = () => {
  editData.value = {
    phone: props.member.phone || '',
    email: props.member.email || '',
    address: props.member.address || '',
    status: props.member.status || 'Active'
  };
  isEditing.value = false;
};
</script>

<style scoped>
.info-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}

.card-header {
  padding: 20px;
  border-bottom: 1.5px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
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
  color: #3b82f6;
}

.btn-edit {
  width: 32px;
  height: 32px;
  border-radius: 6px;
  border: 1.5px solid #e5e7eb;
  background: white;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.btn-edit:hover {
  background: #f9fafb;
  border-color: #3b82f6;
  color: #3b82f6;
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

.info-view {
  display: grid;
  gap: 16px;
}

.info-item {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding-bottom: 12px;
  border-bottom: 1px solid #f3f4f6;
}

.info-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.info-item.full-width {
  flex-direction: column;
  gap: 8px;
}

.info-label {
  font-size: 12px;
  font-weight: 500;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-value {
  font-size: 14px;
  font-weight: 500;
  color: #111827;
  text-align: right;
  display: flex;
  align-items: center;
  gap: 6px;
}

.info-value i {
  font-size: 12px;
  color: #9ca3af;
}

.info-value .fa-mars {
  color: #3b82f6;
}

.info-value .fa-venus {
  color: #ec4899;
}

.role-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 500;
}

.role-badge.guarantor {
  background: #fef3c7;
  color: #92400e;
}

.role-badge.dependent {
  background: #e0e7ff;
  color: #3730a3;
}

.role-badge i {
  color: #f59e0b;
}

.status-badge {
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 500;
}

.status-badge.active {
  background: #d1fae5;
  color: #065f46;
}

.status-badge.inactive {
  background: #fee2e2;
  color: #991b1b;
}

.status-badge.pending {
  background: #fef3c7;
  color: #92400e;
}

.info-edit {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 13px;
  color: #111827;
  font-family: inherit;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-group textarea {
  resize: vertical;
}

.edit-actions {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}

.btn-cancel,
.btn-save {
  flex: 1;
  padding: 10px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s ease;
}

.btn-cancel {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
}

.btn-cancel:hover {
  background: #f9fafb;
}

.btn-save {
  background: #3b82f6;
  color: white;
}

.btn-save:hover {
  background: #2563eb;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
</style>
