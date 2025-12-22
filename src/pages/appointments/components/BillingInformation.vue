<template>
  <div class="main-content">
    <header class="main-header">
      <h2 class="main-title">Billing Information</h2>
      <div class="header-toolbar">
        <div class="search-container">
          <span class="material-icons search-icon">search</span>
          <input
            class="search-input"
            placeholder="Search by patient name..."
            type="text"
          />
        </div>
        <button class="filter-button">
          <span class="material-icons icon">filter_list</span>
          Filter
        </button>
      </div>
    </header>
    <div class="billing-table-card">
      <table class="billing-table">
        <thead class="table-header">
          <tr>
            <th scope="col">Patient Name</th>
            <th scope="col">Date</th>
            <th scope="col">Treatment</th>
            <th scope="col">Amount</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody class="table-body">
          <tr v-for="(bill, index) in billingData" :key="index">
            <td>
              <div class="patient-info">
                <img :src="bill.avatar" :alt="bill.patientName" class="patient-avatar" />
                <div class="patient-details">
                  <div class="patient-name">{{ bill.patientName }}</div>
                  <div class="patient-email">{{ bill.email }}</div>
                </div>
              </div>
            </td>
            <td>{{ bill.date }}</td>
            <td>{{ bill.treatment }}</td>
            <td class="bill-amount">{{ bill.amount }}</td>
            <td>
              <span :class="getStatusClass(bill.status)">
                {{ bill.status }}
              </span>
            </td>
            <td>
              <a href="#" class="view-details-link">View Details</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  name: "BillingInformation",
  data() {
    return {
      billingData: [
        {
          patientName: "David Rutherford",
          email: "david.r@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuDb2n6ysy5dJr1n5U5hQlj8WFpNwMNDcm7LoS7jwIYGMvWBOhTtt-rB3AUvKH2AqgKrFIxsFLUFGvtWnNx8m0P5UmYJlyJCBaU2Z7AOgio8yu65l8tztFgwD7XkxHuXeSmhfAstVXpj_VIDeNjRzwGuHMh7-hm5BgYCGZa-MkHpixdZxi1O9u3u2AGgF8oynFSIZ-tp3oSZasHjUmC0ZsHxBHcxKORswfD3n-PXeczAiq6eMFORCraoJvc9IxThxIxW327yYTYy7uY",
          date: "27 Aug 2020",
          treatment: "Crown Preparation",
          amount: "$250.00",
          status: "Paid",
        },
        {
          patientName: "Helena Nichols",
          email: "helena.n@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuCx-WqgXC6Sxi5zQ25ms6a9eQk4Sj5lEvqDAnyMo2nnJH2G-9OY7dWxOTnVU2Pw-ej9lrBTfmz1vYET_l9Ln4Zngv37UeEGGESx4DJAJ9D0h6Zl1jSET5PJ1wTBTAjBFnJBmxoubfsLEuJVUQjrUbbSZGSgVq_IXKBc0I6mWI8Fep07zG0aTjvOTIIFcn1xl8nHORAs7FZy2obAiSFCtAvFZXhDnAFuJJIPKE2iXo709Zufac23RY7-RoEl4h5pgROWo6T8uCz_Dms",
          date: "27 Aug 2020",
          treatment: "Check-up, Scale & Polish",
          amount: "$120.00",
          status: "Pending",
        },
        {
          patientName: "James Harker",
          email: "james.h@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuC2iMiu-CYDYO5v4M5X9ArgrSt9L5T6IuAFymKNyKanONhFNqnQWayjniVvW0Ca6WrrG5kOaO5zxWThKbF7mnH8bblI7ZgVHOAgjNBgyTUWMBEfH4eLsSkwv5LNDW2heaGMla3m2Q9NZI2OKxQHPmVF4MX5WCLBIZm-g-7VaK1HbRDrXAX57j-78qxMqAdkoeMw21iPrgMDZfx0AnURuwiMotTlhh7iOa4fVM-uP5FZBBpIKIBLyXng9mZy7OShxx04p5QWPoeQ9WY",
          date: "27 Aug 2020",
          treatment: "Private Patients only",
          amount: "$300.00",
          status: "Overdue",
        },
        {
          patientName: "Rayne Carlsson",
          email: "rayne.c@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuBtFfG3mW02mhzq3Q1ndi6LIjbBIEjnx0uK7roBZ_f1W6FGWGVBKPhRtLAYb0WVqxIzlohX4fNFUWe9iEVIFG7q5Gh1HqxhrdoSAcDAyskXvV93J6g25pk7vtpEscUuPge4zQMTbdT6fbHBE5l9fw3HUDJmZUXVEoJ4P2tfqyhX3Jv0SRSiPMWfOXZ9ypGlb0f_nTayM2p-6MgmTojEBuPOhPtZtfxh81nJoVonzlHjcvumpvLANHVTp4h0igajpD33byS7S5Wb3bQ",
          date: "27 Aug 2020",
          treatment: "Zoom Call",
          amount: "$50.00",
          status: "Paid",
        },
        {
          patientName: "Sam Clarke",
          email: "sam.c@example.com",
          avatar:
            "https://lh3.googleusercontent.com/aida-public/AB6AXuBEqBNUKP3ytWqqaJTM6ytxDaRIlDILqJqQBBOxXG_KzEx8QErBT8OpZYWMayxviLPTWYp62A9Rh2gAZrOThlgFENshsqGmtQQcbM7CSkQR6e5EA24CLqSx3pCWBWAEIZGbYc6u2bmhBVrcXxbK5Paw5Fu4N-GctV-2l8YxZnS4wyQeg5pwpca8BXD-bEBEGGdz24C7D5Ups77-qEagFSSFcGqrHmppXVZQ2K04Iohe0ZMX3BT2zU56YZbsncchNAE8KXy5YckTVlU",
          date: "26 Aug 2020",
          treatment: "Follow-up",
          amount: "$80.00",
          status: "Pending",
        },
      ],
    };
  },
  methods: {
    getStatusClass(status) {
      switch (status) {
        case "Paid":
          return "status-badge status-paid";
        case "Pending":
          return "status-badge status-pending";
        case "Overdue":
          return "status-badge status-overdue";
        default:
          return "status-badge";
      }
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");

.main-content {
  flex: 1;
  padding: 2rem;
  font-family: "Roboto", sans-serif;
  background-color: #f9fafb;
}

.main-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.main-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
}

.header-toolbar {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.search-container {
  position: relative;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.search-input {
  padding: 0.5rem 1rem 0.5rem 2.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  outline: none;
  font-size: 0.875rem;
}

.search-input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.filter-button {
  display: flex;
  align-items: center;
  background-color: #ffffff;
  color: #4b5563;
  border: 1px solid #d1d5db;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: background-color 0.2s;
  cursor: pointer;
}

.filter-button:hover {
  background-color: #f3f4f6;
}

.icon {
  margin-right: 0.5rem;
}

.billing-table-card {
  background-color: #ffffff;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  overflow: hidden;
}

.billing-table {
  width: 100%;
  border-collapse: collapse;
}

.table-header {
  background-color: #f3f4f6;
}

.billing-table th {
  padding: 1rem;
  text-align: left;
  font-size: 0.875rem;
  font-weight: 600;
  color: #4b5563;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.table-body tr {
  border-bottom: 1px solid #e5e7eb;
}

.table-body tr:last-child {
  border-bottom: none;
}

.billing-table td {
  padding: 1rem;
  white-space: nowrap;
  font-size: 0.875rem;
  color: #6b7280;
}

.patient-info {
  display: flex;
  align-items: center;
}

.patient-avatar {
  height: 2.5rem;
  width: 2.5rem;
  border-radius: 9999px;
  object-fit: cover;
}

.patient-details {
  margin-left: 1rem;
}

.patient-name {
  font-weight: 500;
  color: #1f2937;
}

.patient-email {
  color: #6b7280;
}

.bill-amount {
  font-weight: 500;
  color: #1f2937;
}

.status-badge {
  display: inline-flex;
  padding: 0.125rem 0.5rem;
  font-size: 0.75rem;
  line-height: 1.25rem;
  font-weight: 600;
  border-radius: 9999px;
}

.status-paid {
  background-color: #d1fae5;
  color: #065f46;
}

.status-pending {
  background-color: #fef3c7;
  color: #92400e;
}

.status-overdue {
  background-color: #fee2e2;
  color: #991b1b;
}

.view-details-link {
  color: #2563eb;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s;
}

.view-details-link:hover {
  color: #1e40af;
}
</style>
