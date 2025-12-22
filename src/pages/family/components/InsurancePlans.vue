<template>
  <div class="insurance-card">
    <div class="card-header">
      <h3>
        <i class="fas fa-shield-alt"></i>
        Insurance Plans
      </h3>
      <button v-if="member" class="btn-add" @click="showAddInsurance = true">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body">
      <div v-if="!member" class="empty-state">
        <i class="fas fa-shield-alt"></i>
        <p>Select a family member to view insurance</p>
      </div>

      <div v-else>
        <div v-if="insurancePlans.length === 0" class="no-insurance">
          <i class="fas fa-shield"></i>
          <p>No insurance plans added</p>
          <button class="btn-add-first" @click="showAddInsurance = true">
            <i class="fas fa-plus"></i>
            Add Insurance Plan
          </button>
        </div>

        <div v-else class="insurance-list">
          <div
            v-for="(plan, index) in insurancePlans"
            :key="index"
            class="insurance-item"
          >
            <div class="insurance-header">
              <div class="plan-type">
                <i class="fas fa-shield-alt"></i>
                <span>{{ plan.type }}</span>
              </div>
              <button class="btn-remove" @click="removePlan(index)">
                <i class="fas fa-times"></i>
              </button>
            </div>

            <div class="insurance-details">
              <div class="detail-row">
                <span class="detail-label">Provider</span>
                <span class="detail-value">{{ plan.provider }}</span>
              </div>

              <div class="detail-row">
                <span class="detail-label">Policy Number</span>
                <span class="detail-value">{{ plan.policyNumber }}</span>
              </div>

              <div class="detail-row">
                <span class="detail-label">Group Number</span>
                <span class="detail-value">{{ plan.groupNumber || 'N/A' }}</span>
              </div>

              <div class="detail-row">
                <span class="detail-label">Coverage</span>
                <span class="detail-value coverage">{{ plan.coverage }}%</span>
              </div>

              <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="status-badge" :class="plan.status.toLowerCase()">
                  {{ plan.status }}
                </span>
              </div>

              <div v-if="plan.expiryDate" class="detail-row">
                <span class="detail-label">Expires</span>
                <span class="detail-value" :class="{ expiring: isExpiringSoon(plan.expiryDate) }">
                  {{ formatDate(plan.expiryDate) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Insurance Modal -->
    <div v-if="showAddInsurance" class="modal-overlay" @click.self="showAddInsurance = false">
      <div class="modal-container insurance-modal">
        <div class="modal-header">
          <div class="modal-title">
            <i class="fas fa-shield-alt"></i>
            <h3>Add Insurance Plan</h3>
          </div>
          <button class="close-btn" @click="showAddInsurance = false">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <!-- Step Tabs -->
        <div class="step-tabs">
          <button
            class="step-tab"
            :class="{ active: activeStep === 1, completed: activeStep > 1 }"
            @click="activeStep = 1"
          >
            <span class="step-number">1</span>
            <span class="step-label">Plan Details</span>
          </button>
          <div class="step-divider"></div>
          <button
            class="step-tab"
            :class="{ active: activeStep === 2, completed: activeStep > 2 }"
            @click="activeStep = 2"
          >
            <span class="step-number">2</span>
            <span class="step-label">Subscriber Info</span>
          </button>
          <div class="step-divider"></div>
          <button
            class="step-tab"
            :class="{ active: activeStep === 3 }"
            @click="activeStep = 3"
          >
            <span class="step-number">3</span>
            <span class="step-label">Coverage</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Step 1: Plan Details -->
          <div v-if="activeStep === 1" class="step-content">
            <div class="section-header">
              <i class="fas fa-file-contract"></i>
              <span>Insurance Plan Information</span>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Insurance Type <span class="required">*</span></label>
                <select v-model="newPlan.type" class="form-select">
                  <option value="">Select Type</option>
                  <option value="Primary">Primary Insurance</option>
                  <option value="Secondary">Secondary Insurance</option>
                  <option value="Tertiary">Tertiary Insurance</option>
                </select>
              </div>

              <div class="form-group">
                <label>Plan Status</label>
                <select v-model="newPlan.status" class="form-select">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Pending">Pending Verification</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Insurance Provider <span class="required">*</span></label>
              <div class="input-with-icon">
                <i class="fas fa-building"></i>
                <input
                  v-model="newPlan.provider"
                  type="text"
                  placeholder="e.g., Delta Dental, Cigna, MetLife"
                  class="form-input"
                />
              </div>
            </div>

            <div class="form-group">
              <label>Insurance Company Phone</label>
              <div class="input-with-icon">
                <i class="fas fa-phone"></i>
                <input
                  v-model="newPlan.insurancePhone"
                  type="tel"
                  placeholder="(800) 555-0123"
                  class="form-input"
                />
              </div>
            </div>

            <div class="form-group">
              <label>Insurance Company Address</label>
              <div class="input-with-icon">
                <i class="fas fa-map-marker-alt"></i>
                <input
                  v-model="newPlan.insuranceAddress"
                  type="text"
                  placeholder="123 Insurance Blvd, City, State ZIP"
                  class="form-input"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Policy/Member ID <span class="required">*</span></label>
                <input
                  v-model="newPlan.policyNumber"
                  type="text"
                  placeholder="ABC123456789"
                  class="form-input"
                />
              </div>

              <div class="form-group">
                <label>Group Number</label>
                <input
                  v-model="newPlan.groupNumber"
                  type="text"
                  placeholder="GRP-12345"
                  class="form-input"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Effective Date</label>
                <input
                  v-model="newPlan.effectiveDate"
                  type="date"
                  class="form-input"
                />
              </div>

              <div class="form-group">
                <label>Expiry/Renewal Date</label>
                <input
                  v-model="newPlan.expiryDate"
                  type="date"
                  class="form-input"
                />
              </div>
            </div>
          </div>

          <!-- Step 2: Subscriber Information -->
          <div v-if="activeStep === 2" class="step-content">
            <div class="section-header">
              <i class="fas fa-user-shield"></i>
              <span>Subscriber / Policy Holder Information</span>
            </div>

            <div class="subscriber-toggle">
              <label class="toggle-label">
                <input
                  type="checkbox"
                  v-model="newPlan.patientIsSubscriber"
                  class="toggle-checkbox"
                />
                <span class="toggle-switch"></span>
                <span class="toggle-text">Patient is the subscriber/policy holder</span>
              </label>
            </div>

            <div v-if="!newPlan.patientIsSubscriber" class="subscriber-fields">
              <div class="form-row">
                <div class="form-group">
                  <label>Subscriber First Name <span class="required">*</span></label>
                  <input
                    v-model="newPlan.subscriberFirstName"
                    type="text"
                    placeholder="John"
                    class="form-input"
                  />
                </div>

                <div class="form-group">
                  <label>Subscriber Last Name <span class="required">*</span></label>
                  <input
                    v-model="newPlan.subscriberLastName"
                    type="text"
                    placeholder="Smith"
                    class="form-input"
                  />
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label>Subscriber Date of Birth</label>
                  <input
                    v-model="newPlan.subscriberDob"
                    type="date"
                    class="form-input"
                  />
                </div>

                <div class="form-group">
                  <label>Relationship to Patient <span class="required">*</span></label>
                  <select v-model="newPlan.subscriberRelationship" class="form-select">
                    <option value="">Select Relationship</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Parent">Parent</option>
                    <option value="Guardian">Guardian</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label>Subscriber SSN (Last 4 digits)</label>
                <div class="ssn-input">
                  <span class="ssn-prefix">XXX-XX-</span>
                  <input
                    v-model="newPlan.subscriberSsnLast4"
                    type="text"
                    maxlength="4"
                    placeholder="1234"
                    class="form-input ssn-field"
                  />
                </div>
              </div>

              <div class="form-group">
                <label>Subscriber Member ID (if different)</label>
                <input
                  v-model="newPlan.subscriberMemberId"
                  type="text"
                  placeholder="Leave blank if same as patient's policy number"
                  class="form-input"
                />
              </div>
            </div>

            <div class="section-header employer-section">
              <i class="fas fa-briefcase"></i>
              <span>Employer Information (Optional)</span>
            </div>

            <div class="form-group">
              <label>Employer Name</label>
              <div class="input-with-icon">
                <i class="fas fa-building"></i>
                <input
                  v-model="newPlan.employerName"
                  type="text"
                  placeholder="Company Name"
                  class="form-input"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Employer Phone</label>
                <input
                  v-model="newPlan.employerPhone"
                  type="tel"
                  placeholder="(555) 123-4567"
                  class="form-input"
                />
              </div>

              <div class="form-group">
                <label>Employer Group Name</label>
                <input
                  v-model="newPlan.employerGroupName"
                  type="text"
                  placeholder="Group/Division Name"
                  class="form-input"
                />
              </div>
            </div>
          </div>

          <!-- Step 3: Coverage Details -->
          <div v-if="activeStep === 3" class="step-content">
            <div class="section-header">
              <i class="fas fa-percentage"></i>
              <span>Coverage & Benefits</span>
            </div>

            <div class="coverage-grid">
              <div class="coverage-card">
                <div class="coverage-header">
                  <i class="fas fa-tooth"></i>
                  <span>Preventive</span>
                </div>
                <div class="coverage-input">
                  <input
                    v-model="newPlan.coveragePreventive"
                    type="number"
                    min="0"
                    max="100"
                    placeholder="100"
                    class="form-input"
                  />
                  <span class="percent-symbol">%</span>
                </div>
                <p class="coverage-desc">Exams, cleanings, x-rays</p>
              </div>

              <div class="coverage-card">
                <div class="coverage-header">
                  <i class="fas fa-fill-drip"></i>
                  <span>Basic</span>
                </div>
                <div class="coverage-input">
                  <input
                    v-model="newPlan.coverageBasic"
                    type="number"
                    min="0"
                    max="100"
                    placeholder="80"
                    class="form-input"
                  />
                  <span class="percent-symbol">%</span>
                </div>
                <p class="coverage-desc">Fillings, extractions</p>
              </div>

              <div class="coverage-card">
                <div class="coverage-header">
                  <i class="fas fa-crown"></i>
                  <span>Major</span>
                </div>
                <div class="coverage-input">
                  <input
                    v-model="newPlan.coverageMajor"
                    type="number"
                    min="0"
                    max="100"
                    placeholder="50"
                    class="form-input"
                  />
                  <span class="percent-symbol">%</span>
                </div>
                <p class="coverage-desc">Crowns, bridges, dentures</p>
              </div>

              <div class="coverage-card">
                <div class="coverage-header">
                  <i class="fas fa-teeth"></i>
                  <span>Orthodontic</span>
                </div>
                <div class="coverage-input">
                  <input
                    v-model="newPlan.coverageOrtho"
                    type="number"
                    min="0"
                    max="100"
                    placeholder="50"
                    class="form-input"
                  />
                  <span class="percent-symbol">%</span>
                </div>
                <p class="coverage-desc">Braces, aligners</p>
              </div>
            </div>

            <div class="section-header benefits-section">
              <i class="fas fa-dollar-sign"></i>
              <span>Benefit Limits</span>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Annual Maximum</label>
                <div class="input-with-prefix">
                  <span class="input-prefix">£</span>
                  <input
                    v-model="newPlan.annualMaximum"
                    type="number"
                    min="0"
                    placeholder="1500"
                    class="form-input with-prefix"
                  />
                </div>
              </div>

              <div class="form-group">
                <label>Annual Deductible</label>
                <div class="input-with-prefix">
                  <span class="input-prefix">£</span>
                  <input
                    v-model="newPlan.annualDeductible"
                    type="number"
                    min="0"
                    placeholder="50"
                    class="form-input with-prefix"
                  />
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Orthodontic Lifetime Maximum</label>
                <div class="input-with-prefix">
                  <span class="input-prefix">£</span>
                  <input
                    v-model="newPlan.orthoLifetimeMax"
                    type="number"
                    min="0"
                    placeholder="1500"
                    class="form-input with-prefix"
                  />
                </div>
              </div>

              <div class="form-group">
                <label>Remaining Benefits</label>
                <div class="input-with-prefix">
                  <span class="input-prefix">£</span>
                  <input
                    v-model="newPlan.remainingBenefits"
                    type="number"
                    min="0"
                    placeholder="1500"
                    class="form-input with-prefix"
                  />
                </div>
              </div>
            </div>

            <div class="section-header">
              <i class="fas fa-calendar-check"></i>
              <span>Waiting Periods</span>
            </div>

            <div class="form-row three-col">
              <div class="form-group">
                <label>Preventive</label>
                <select v-model="newPlan.waitingPreventive" class="form-select">
                  <option value="none">No Waiting</option>
                  <option value="3">3 Months</option>
                  <option value="6">6 Months</option>
                  <option value="12">12 Months</option>
                </select>
              </div>

              <div class="form-group">
                <label>Basic</label>
                <select v-model="newPlan.waitingBasic" class="form-select">
                  <option value="none">No Waiting</option>
                  <option value="3">3 Months</option>
                  <option value="6">6 Months</option>
                  <option value="12">12 Months</option>
                </select>
              </div>

              <div class="form-group">
                <label>Major</label>
                <select v-model="newPlan.waitingMajor" class="form-select">
                  <option value="none">No Waiting</option>
                  <option value="6">6 Months</option>
                  <option value="12">12 Months</option>
                  <option value="24">24 Months</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Notes</label>
              <textarea
                v-model="newPlan.notes"
                rows="3"
                placeholder="Additional notes about this insurance plan..."
                class="form-textarea"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn-cancel" @click="cancelAddInsurance">Cancel</button>

          <div class="footer-actions">
            <button
              v-if="activeStep > 1"
              class="btn-secondary"
              @click="activeStep--"
            >
              <i class="fas fa-arrow-left"></i>
              Previous
            </button>

            <button
              v-if="activeStep < 3"
              class="btn-primary"
              @click="activeStep++"
              :disabled="!isStepValid"
            >
              Next
              <i class="fas fa-arrow-right"></i>
            </button>

            <button
              v-else
              class="btn-save"
              @click="saveInsurance"
              :disabled="!isFormValid"
            >
              <i class="fas fa-check"></i>
              Add Insurance Plan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
  member: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['update']);

const showAddInsurance = ref(false);
const activeStep = ref(1);

const getDefaultPlan = () => ({
  // Step 1: Plan Details
  type: '',
  status: 'Active',
  provider: '',
  insurancePhone: '',
  insuranceAddress: '',
  policyNumber: '',
  groupNumber: '',
  effectiveDate: '',
  expiryDate: '',

  // Step 2: Subscriber Info
  patientIsSubscriber: true,
  subscriberFirstName: '',
  subscriberLastName: '',
  subscriberDob: '',
  subscriberRelationship: '',
  subscriberSsnLast4: '',
  subscriberMemberId: '',
  employerName: '',
  employerPhone: '',
  employerGroupName: '',

  // Step 3: Coverage
  coveragePreventive: 100,
  coverageBasic: 80,
  coverageMajor: 50,
  coverageOrtho: 50,
  annualMaximum: 1500,
  annualDeductible: 50,
  orthoLifetimeMax: 1500,
  remainingBenefits: 1500,
  waitingPreventive: 'none',
  waitingBasic: 'none',
  waitingMajor: 'none',
  notes: '',

  // Legacy field for display compatibility
  coverage: 80
});

const newPlan = ref(getDefaultPlan());

// Validation for each step
const isStepValid = computed(() => {
  if (activeStep.value === 1) {
    return newPlan.value.type && newPlan.value.provider && newPlan.value.policyNumber;
  }
  if (activeStep.value === 2) {
    if (newPlan.value.patientIsSubscriber) {
      return true;
    }
    return newPlan.value.subscriberFirstName &&
           newPlan.value.subscriberLastName &&
           newPlan.value.subscriberRelationship;
  }
  return true;
});

const isFormValid = computed(() => {
  // Basic required fields
  const hasBasicInfo = newPlan.value.type && newPlan.value.provider && newPlan.value.policyNumber;

  // Subscriber info validation
  const hasSubscriberInfo = newPlan.value.patientIsSubscriber || (
    newPlan.value.subscriberFirstName &&
    newPlan.value.subscriberLastName &&
    newPlan.value.subscriberRelationship
  );

  return hasBasicInfo && hasSubscriberInfo;
});

// Mock insurance plans
const insurancePlans = ref([
  {
    type: 'Primary',
    provider: 'Delta Dental',
    policyNumber: 'DD-12345678',
    groupNumber: 'GRP-456',
    coverage: 80,
    status: 'Active',
    expiryDate: '2026-12-31'
  }
]);

watch(() => props.member, (newMember) => {
  if (newMember) {
    // Load insurance plans for this member (would be from API)
  }
});

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};

const isExpiringSoon = (expiryDate) => {
  if (!expiryDate) return false;
  const today = new Date();
  const expiry = new Date(expiryDate);
  const daysUntilExpiry = Math.ceil((expiry - today) / (1000 * 60 * 60 * 24));
  return daysUntilExpiry <= 90 && daysUntilExpiry > 0;
};

const removePlan = (index) => {
  if (confirm('Are you sure you want to remove this insurance plan?')) {
    insurancePlans.value.splice(index, 1);
    emit('update', { insurancePlans: insurancePlans.value });
  }
};

const saveInsurance = () => {
  if (!isFormValid.value) {
    alert('Please fill in all required fields');
    return;
  }

  // Calculate average coverage for legacy display
  const avgCoverage = Math.round(
    (Number(newPlan.value.coveragePreventive || 0) +
     Number(newPlan.value.coverageBasic || 0) +
     Number(newPlan.value.coverageMajor || 0)) / 3
  );

  const planToSave = {
    ...newPlan.value,
    coverage: avgCoverage
  };

  insurancePlans.value.push(planToSave);
  emit('update', { insurancePlans: insurancePlans.value });
  cancelAddInsurance();
};

const cancelAddInsurance = () => {
  showAddInsurance.value = false;
  activeStep.value = 1;
  newPlan.value = getDefaultPlan();
};
</script>

<style scoped>
.insurance-card {
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

.card-header h3 i {
  color: #8b5cf6;
}

.btn-add {
  width: 32px;
  height: 32px;
  border-radius: 6px;
  border: none;
  background: #8b5cf6;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.btn-add:hover {
  background: #7c3aed;
  transform: scale(1.05);
}

.card-body {
  padding: 20px;
}

.empty-state,
.no-insurance {
  text-align: center;
  padding: 40px 20px;
  color: #9ca3af;
}

.empty-state i,
.no-insurance i {
  font-size: 48px;
  margin-bottom: 12px;
  display: block;
}

.empty-state p,
.no-insurance p {
  margin: 0 0 16px 0;
  font-size: 14px;
}

.btn-add-first {
  padding: 10px 20px;
  background: #8b5cf6;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-add-first:hover {
  background: #7c3aed;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.insurance-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.insurance-item {
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.2s ease;
}

.insurance-item:hover {
  border-color: #8b5cf6;
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
}

.insurance-header {
  background: #f9fafb;
  padding: 12px 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e5e7eb;
}

.plan-type {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 600;
  color: #111827;
}

.plan-type i {
  color: #8b5cf6;
  font-size: 16px;
}

.btn-remove {
  width: 28px;
  height: 28px;
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

.insurance-details {
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
}

.detail-label {
  color: #6b7280;
  font-weight: 500;
}

.detail-value {
  color: #111827;
  font-weight: 500;
}

.detail-value.coverage {
  color: #10b981;
  font-weight: 600;
}

.detail-value.expiring {
  color: #f59e0b;
  font-weight: 600;
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

/* Modal Styles */
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
  backdrop-filter: blur(4px);
}

.modal-container {
  background: white;
  border-radius: 16px;
  width: 100%;
  max-width: 550px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-container.insurance-modal {
  max-width: 720px;
}

.modal-header {
  padding: 20px 24px;
  border-bottom: 1.5px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.modal-title {
  display: flex;
  align-items: center;
  gap: 12px;
}

.modal-title i {
  font-size: 24px;
  color: #8b5cf6;
}

.modal-header h3 {
  font-size: 18px;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.close-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: none;
  background: white;
  color: #6b7280;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.close-btn:hover {
  background: #fee2e2;
  color: #dc2626;
}

/* Step Tabs */
.step-tabs {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px 24px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  gap: 8px;
}

.step-tab {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  background: white;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.step-tab:hover {
  border-color: #8b5cf6;
}

.step-tab.active {
  background: #8b5cf6;
  border-color: #8b5cf6;
  color: white;
}

.step-tab.active .step-number {
  background: white;
  color: #8b5cf6;
}

.step-tab.completed {
  background: #d1fae5;
  border-color: #10b981;
}

.step-tab.completed .step-number {
  background: #10b981;
  color: white;
}

.step-number {
  width: 24px;
  height: 24px;
  background: #e5e7eb;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
}

.step-label {
  font-size: 13px;
  font-weight: 500;
}

.step-divider {
  width: 40px;
  height: 2px;
  background: #e5e7eb;
}

.modal-body {
  padding: 24px;
  overflow-y: auto;
  flex: 1;
  max-height: 60vh;
}

.step-content {
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

.section-header {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
  border-radius: 10px;
  margin-bottom: 20px;
  font-size: 14px;
  font-weight: 600;
  color: #4338ca;
}

.section-header i {
  font-size: 16px;
  color: #6366f1;
}

.section-header.employer-section,
.section-header.benefits-section {
  margin-top: 24px;
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

.required {
  color: #dc2626;
}

.form-input,
.form-select,
.form-textarea {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  color: #111827;
  transition: all 0.2s ease;
  font-family: inherit;
  background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: #8b5cf6;
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.form-textarea {
  resize: vertical;
  min-height: 80px;
}

.input-with-icon {
  position: relative;
}

.input-with-icon i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  font-size: 14px;
}

.input-with-icon .form-input {
  padding-left: 40px;
}

.input-with-prefix {
  position: relative;
  display: flex;
  align-items: stretch;
}

.input-prefix {
  display: flex;
  align-items: center;
  padding: 0 12px;
  background: #f3f4f6;
  border: 1.5px solid #e5e7eb;
  border-right: none;
  border-radius: 8px 0 0 8px;
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
}

.form-input.with-prefix {
  border-radius: 0 8px 8px 0;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-row.three-col {
  grid-template-columns: 1fr 1fr 1fr;
}

/* Subscriber Toggle */
.subscriber-toggle {
  margin-bottom: 20px;
}

.toggle-label {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  padding: 14px 16px;
  background: #f9fafb;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  transition: all 0.2s ease;
}

.toggle-label:hover {
  border-color: #8b5cf6;
}

.toggle-checkbox {
  display: none;
}

.toggle-switch {
  width: 44px;
  height: 24px;
  background: #d1d5db;
  border-radius: 12px;
  position: relative;
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.toggle-switch::after {
  content: '';
  position: absolute;
  width: 20px;
  height: 20px;
  background: white;
  border-radius: 50%;
  top: 2px;
  left: 2px;
  transition: all 0.2s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.toggle-checkbox:checked + .toggle-switch {
  background: #8b5cf6;
}

.toggle-checkbox:checked + .toggle-switch::after {
  left: 22px;
}

.toggle-text {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
}

.subscriber-fields {
  animation: fadeIn 0.3s ease;
  padding: 20px;
  background: #fafafa;
  border-radius: 10px;
  margin-bottom: 20px;
}

/* SSN Input */
.ssn-input {
  display: flex;
  align-items: stretch;
}

.ssn-prefix {
  display: flex;
  align-items: center;
  padding: 0 12px;
  background: #f3f4f6;
  border: 1.5px solid #e5e7eb;
  border-right: none;
  border-radius: 8px 0 0 8px;
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
  font-family: monospace;
}

.ssn-field {
  max-width: 80px;
  border-radius: 0 8px 8px 0;
  font-family: monospace;
  letter-spacing: 2px;
}

/* Coverage Grid */
.coverage-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.coverage-card {
  background: #f9fafb;
  border: 1.5px solid #e5e7eb;
  border-radius: 12px;
  padding: 16px;
  text-align: center;
  transition: all 0.2s ease;
}

.coverage-card:hover {
  border-color: #8b5cf6;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
}

.coverage-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  margin-bottom: 12px;
}

.coverage-header i {
  font-size: 24px;
  color: #8b5cf6;
}

.coverage-header span {
  font-size: 13px;
  font-weight: 600;
  color: #374151;
}

.coverage-input {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  margin-bottom: 8px;
}

.coverage-input .form-input {
  width: 60px;
  text-align: center;
  font-weight: 600;
  padding: 8px;
}

.percent-symbol {
  font-size: 16px;
  font-weight: 600;
  color: #6b7280;
}

.coverage-desc {
  font-size: 11px;
  color: #9ca3af;
  margin: 0;
  line-height: 1.4;
}

/* Modal Footer */
.modal-footer {
  padding: 20px 24px;
  border-top: 1.5px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f9fafb;
}

.footer-actions {
  display: flex;
  gap: 12px;
}

.btn-cancel,
.btn-save,
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

.btn-cancel {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
}

.btn-cancel:hover {
  background: #f9fafb;
  border-color: #d1d5db;
}

.btn-secondary {
  background: white;
  color: #374151;
  border: 1.5px solid #e5e7eb;
}

.btn-secondary:hover {
  background: #f9fafb;
}

.btn-primary {
  background: #4f46e5;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #4338ca;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-primary:disabled,
.btn-save:disabled {
  background: #d1d5db;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

.btn-save {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
}

.btn-save:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Responsive Styles */
@media (max-width: 768px) {
  .modal-container.insurance-modal {
    max-width: 100%;
    max-height: 100vh;
    border-radius: 0;
  }

  .step-tabs {
    flex-wrap: wrap;
    gap: 8px;
  }

  .step-divider {
    display: none;
  }

  .step-tab {
    flex: 1;
    min-width: calc(33% - 8px);
    justify-content: center;
    padding: 8px 12px;
  }

  .step-label {
    display: none;
  }

  .coverage-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .form-row,
  .form-row.three-col {
    grid-template-columns: 1fr;
  }

  .modal-footer {
    flex-direction: column;
    gap: 12px;
  }

  .footer-actions {
    width: 100%;
    justify-content: flex-end;
  }

  .btn-cancel {
    width: 100%;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .coverage-grid {
    grid-template-columns: 1fr 1fr;
  }

  .modal-body {
    padding: 16px;
  }

  .section-header {
    padding: 10px 12px;
    font-size: 13px;
  }
}
</style>
