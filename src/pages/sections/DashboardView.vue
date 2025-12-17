<template>
  <div>
    <!-- Cards -->
    <div class="cards">
      <div class="card good">
        <div class="icon-wrapper"><i class="fas fa-shield-alt"></i></div>
        <div class="card-content">
          <div class="value">Good</div>
          <div class="label">Inventory Status</div>
        </div>
      </div>
      <div class="card revenue">
        <div class="icon-wrapper"><i class="fas fa-money-bill-wave"></i></div>
        <div class="card-content">
          <div class="value">£8,55,875</div>
          <div class="label">Revenue: May</div>
        </div>
      </div>
      <div class="card available">
        <div class="icon-wrapper"><i class="fas fa-capsules"></i></div>
        <div class="card-content">
          <div class="value">298</div>
          <div class="label">Medicines Available</div>
        </div>
      </div>
      <div class="card shortage">
        <div class="icon-wrapper"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="card-content">
          <div class="value">01</div>
          <div class="label">Medicine Shortage</div>
        </div>
      </div>
    </div>

    <!-- Grid Section -->
    <div class="grid-section">
      <div class="sub-card">
        <div class="subcard-header">
          <span>Inventory</span>
          <a class="config-link">Go to Configuration »</a>
        </div>
        <div class="subcard-body">
          <div class="stat-icon"><i class="fas fa-pills"></i></div>
          <div class="stat-info">
            <div class="stat-block">
              <span class="stat-value">298</span>
              <span class="stat-label">Total no of Medicines</span>
            </div>
            <div class="stat-block">
              <span class="stat-value">24</span>
              <span class="stat-label">Medicine Groups</span>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-card">
        <div class="subcard-header">
          <span>Quick Report</span>
          <a class="config-link">Go to Configuration »</a>
        </div>
        <div class="subcard-body">
          <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
          <div class="stat-info">
            <div class="stat-block">
              <span class="stat-value">70,856</span>
              <span class="stat-label">Qty of Medicines Sold</span>
            </div>
            <div class="stat-block">
              <span class="stat-value">5,288</span>
              <span class="stat-label">Invoices Generated</span>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-card">
        <div class="subcard-header">
          <span>My Pharmacy</span>
          <a class="config-link">Go to Configuration »</a>
        </div>
        <div class="subcard-body">
          <div class="stat-icon"><i class="fas fa-hospital-alt"></i></div>
          <div class="stat-info">
            <div class="stat-block">
              <span class="stat-value">04</span>
              <span class="stat-label">Total no of Suppliers</span>
            </div>
            <div class="stat-block">
              <span class="stat-value">05</span>
              <span class="stat-label">Total no of Users</span>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-card">
        <div class="subcard-header">
          <span>Customers</span>
          <a class="config-link">Go to Customers Page »</a>
        </div>
        <div class="subcard-body">
          <div class="stat-icon"><i class="fas fa-users"></i></div>
          <div class="stat-info">
            <div class="stat-block">
              <span class="stat-value">845</span>
              <span class="stat-label">No of Customers</span>
            </div>
          </div>
          <div class="tag">Adalimumab</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DashboardView",
};
</script>

<style scoped>
.dashboard-container {
  display: flex;
  background: #ffffff;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

/* Sidebar styles (unchanged)... */

.main {
  flex-grow: 1;
  padding: 20px 30px;
  background: #fff;
}
.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.title {
  font: 600 28px Poppins;
  color: #303030;
}
.subtitle {
  font: bold 16px Poppins;
  color: #34d8d1;
}
.user {
  display: flex;
  align-items: center;
  gap: 12px;
}
.user img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}
/* Search Row */
.search-row {
  display: flex;
  gap: 10px;
  margin: 20px 0;
}
.search-row input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
}
.search-row button {
  display: flex;
  align-items: center;
  gap: 6px;
  background-color: #fff;
  border: 1px solid #ddd;
  padding: 10px 16px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
  border-radius: 6px;
  cursor: pointer;
}
/* Cards */
.cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin: 30px 0;
}
.card {
  padding: 20px;
  border-radius: 12px;
  color: #fff;
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.icon-wrapper i {
  font-size: 32px;
}
.card-content .value {
  font: bold 37px Poppins;
}
.card-content .label {
  font: 600 19px Poppins;
}
.card.good {
  background: #34d8d1;
}
.card.revenue {
  background: #34a7d8;
}
.card.available {
  background: #34d899;
}
.card.shortage {
  background: #d69759;
}

/* Grid Section */
.grid-section {
  background: #f3f5f7;
  padding: 30px;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}
.sub-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}
.subcard-header {
  background: #fff;
  padding: 20px 24px;
  font-weight: 600;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #6a6969;
}
.config-link {
  font-size: 12px;
  color: #00a6a6;
  text-decoration: none;
  font-weight: 500;
}
.subcard-body {
  background: #f3f5f7;
  padding: 20px 24px;
  display: flex;
  align-items: center;
  gap: 24px;
}
.stat-icon i {
  font-size: 32px;
  color: #34a7d8;
}
.stat-info {
  display: flex;
  justify-content: space-between;
  flex: 1;
}
.stat-block {
  display: flex;
  flex-direction: column;
}
.stat-label {
  text-align: left;
  font: normal normal medium 15px/23px Poppins;
  letter-spacing: 0px;
  color: #1d242e;
  opacity: 1;
}
.stat-value {
  /* font-size: 18px; */
  font-weight: 600;
  color: #34a7d8;
  font: normal normal bold 27px/40px Poppins;
}
.tag {
  margin-top: 12px;
  color: #007bff;
  font-weight: 600;
}
</style>
