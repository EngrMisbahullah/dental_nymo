<template>
  <div class="account-card">
    <div class="card-header">
      <h3>
        <i class="fas fa-wallet"></i>
        Family Account Overview
      </h3>
    </div>
    <div class="card-body">
      <div class="balance-summary">
        <div class="total-balance">
          <span class="label">Total Family Balance</span>
          <span class="amount" :class="{ negative: family.totalBalance > 0 }">
            £{{ formatCurrency(family.totalBalance) }}
          </span>
        </div>
      </div>

      <div class="account-details">
        <div class="detail-item">
          <div class="detail-icon">
            <i class="fas fa-user-shield"></i>
          </div>
          <div class="detail-content">
            <span class="detail-label">Account Holder</span>
            <span class="detail-value">{{ family.primaryAccountHolder?.name || 'N/A' }}</span>
          </div>
        </div>

        <div class="detail-item">
          <div class="detail-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div class="detail-content">
            <span class="detail-label">Insurance Provider</span>
            <span class="detail-value">{{ family.insuranceProvider || 'None' }}</span>
          </div>
        </div>

        <div class="detail-item">
          <div class="detail-icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="detail-content">
            <span class="detail-label">Family Members</span>
            <span class="detail-value">{{ family.members?.length || 0 }}</span>
          </div>
        </div>
      </div>

      <div class="member-balances">
        <h4>Individual Balances</h4>
        <div class="balance-list">
          <div
            v-for="member in family.members"
            :key="member.patientId"
            class="balance-item"
          >
            <div class="member-info">
              <i v-if="member.role === 'Guarantor'" class="fas fa-star guarantor-icon"></i>
              <span>{{ member.name }}</span>
            </div>
            <span class="member-balance">£{{ formatCurrency(member.balance || 0) }}</span>
          </div>
        </div>
      </div>

      <div class="action-buttons">
        <button class="btn-outline">
          <i class="fas fa-file-invoice"></i>
          View Invoices
        </button>
        <button class="btn-outline">
          <i class="fas fa-credit-card"></i>
          Make Payment
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>

const props = defineProps({
  family: {
    type: Object,
    required: true
  }
});

const formatCurrency = (amount) => {
  return Math.abs(amount).toFixed(2);
};
</script>

<style scoped>
.account-card {
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
  color: #4f46e5;
}

.card-body {
  padding: 20px;
}

.balance-summary {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  padding: 24px;
  border-radius: 10px;
  margin-bottom: 20px;
  color: white;
}

.total-balance {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.total-balance .label {
  font-size: 13px;
  opacity: 0.9;
}

.total-balance .amount {
  font-size: 32px;
  font-weight: 700;
}

.total-balance .amount.negative {
  color: #fecaca;
}

.account-details {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
}

.detail-item {
  display: flex;
  align-items: center;
  gap: 14px;
}

.detail-icon {
  width: 40px;
  height: 40px;
  background: #f3f4f6;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.detail-icon i {
  color: #4f46e5;
  font-size: 16px;
}

.detail-content {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.detail-label {
  font-size: 12px;
  color: #6b7280;
}

.detail-value {
  font-size: 14px;
  font-weight: 500;
  color: #111827;
}

.member-balances {
  margin-bottom: 20px;
}

.member-balances h4 {
  font-size: 14px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 12px 0;
}

.balance-list {
  background: #f9fafb;
  border-radius: 8px;
  padding: 8px;
}

.balance-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 12px;
  border-radius: 6px;
  transition: background 0.2s ease;
}

.balance-item:hover {
  background: white;
}

.member-info {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #374151;
}

.guarantor-icon {
  color: #f59e0b;
  font-size: 11px;
}

.member-balance {
  font-size: 13px;
  font-weight: 600;
  color: #111827;
}

.action-buttons {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}

.btn-outline {
  padding: 10px 16px;
  border: 1.5px solid #e5e7eb;
  background: white;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  color: #374151;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-outline:hover {
  background: #f9fafb;
  border-color: #4f46e5;
  color: #4f46e5;
}

.btn-outline i {
  font-size: 12px;
}
</style>
