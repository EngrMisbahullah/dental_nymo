<template>
  <div class="uda-dashboard-app">
    <header class="bg-white shadow-md sticky top-0 z-40">
      <nav class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-2 md:space-x-4">
          <button
            @click="navigate('progression')"
            :class="{ 'nav-link': true, active: currentView === 'progression' }"
          >
            UDA Progression
          </button>
          <button
            @click="navigate('distribution')"
            :class="{ 'nav-link': true, active: currentView === 'distribution' }"
          >
            Band Distribution
          </button>
          <button
            @click="navigate('leaderboard')"
            :class="{ 'nav-link': true, active: currentView === 'leaderboard' }"
          >
            Performer Leaderboard
          </button>
          <button
            @click="navigate('summary')"
            :class="{ 'nav-link': true, active: currentView === 'summary' }"
          >
            Period Summary
          </button>
          <button
            @click="navigate('claims')"
            :class="{ 'nav-link': true, active: currentView === 'claims' }"
          >
            Claims Activity
          </button>
        </div>
      </nav>

      <div class="card filters-card">
        <div class="filters">
          <div class="filter">
            <label for="contract">Contract</label>
            <select id="contract" v-model="filters.contract">
              <option v-for="contract in filterOptions.contracts" :key="contract">
                {{ contract }}
              </option>
            </select>
          </div>
          <div class="filter">
            <label for="performer">Performer</label>
            <select id="performer" v-model="filters.performer">
              <option v-for="performer in filterOptions.performers" :key="performer">
                {{ performer }}
              </option>
            </select>
          </div>
          <div class="filter">
            <label for="period">Period</label>
            <select id="period" v-model="filters.period">
              <option v-for="period in filterOptions.periods" :key="period">
                {{ period }}
              </option>
            </select>
          </div>
          <div class="filter-toggle">
            <label class="toggle-label-text">Include Provisional Claims</label>
            <div class="toggle-container">
              <input
                type="checkbox"
                v-model="filters.includeProvisional"
                class="toggle-checkbox"
              />
              <label class="toggle-label"></label>
            </div>
          </div>
        </div>
      </div>

      <div v-if="filteredData.alert" class="alert alert-red">
        <p>⚠️ {{ filteredData.alert }}</p>
      </div>
    </header>

    <main class="page-content-container">
      <div v-if="currentView === 'progression'" class="page-view">
        <div class="kpi-grid">
          <div class="kpi-card border-green">
            <h3>Target UDAs</h3>
            <p class="text-gray-800">
              {{ filteredData.kpis.targetUDAs.toLocaleString() }}
            </p>
          </div>
          <div class="kpi-card border-blue">
            <h3>Achieved UDAs</h3>
            <p class="text-blue-600">
              {{ filteredData.kpis.achievedUDAs.toLocaleString() }}
            </p>
          </div>
          <div class="kpi-card border-yellow">
            <h3>Provisional UDAs</h3>
            <p class="text-yellow-600">
              {{ filteredData.kpis.provisionalUDAs.toLocaleString() }}
            </p>
          </div>
          <div class="kpi-card border-red">
            <h3>Variance</h3>
            <p class="text-red-600">{{ filteredData.kpis.variance.toLocaleString() }}</p>
          </div>
          <div class="kpi-card border-gray">
            <h3>Forecast</h3>
            <p class="text-gray-800">{{ filteredData.kpis.forecast.toLocaleString() }}</p>
          </div>
        </div>
        <div class="card progression-card">
          <h3 class="section-title">UDA Progression</h3>
          <div class="progress-bars-container">
            <div>
              <div class="progress-text">
                <span class="progress-label text-blue-700">Achieved UDAs</span>
                <span class="progress-value text-blue-700"
                  >{{ filteredData.kpis.achievedUDAs.toLocaleString() }} /
                  {{ filteredData.kpis.targetUDAs.toLocaleString() }} ({{
                    (
                      (filteredData.kpis.achievedUDAs / filteredData.kpis.targetUDAs) *
                      100
                    ).toFixed(0)
                  }}%)</span
                >
              </div>
              <div class="progress-bar-bg">
                <div
                  class="progress-bar progress-blue"
                  :style="{
                    width:
                      (
                        (filteredData.kpis.achievedUDAs / filteredData.kpis.targetUDAs) *
                        100
                      ).toFixed(0) + '%',
                  }"
                ></div>
              </div>
            </div>
            <div>
              <div class="progress-text">
                <span class="progress-label text-gray-700">Target Progression</span>
                <span class="progress-value text-gray-700"
                  >Day {{ filteredData.progression.day }} /
                  {{ filteredData.progression.totalDays }} ({{
                    (
                      (filteredData.progression.day /
                        filteredData.progression.totalDays) *
                      100
                    ).toFixed(0) + "%"
                  }})</span
                >
              </div>
              <div class="progress-bar-bg">
                <div
                  class="progress-bar progress-gray"
                  :style="{
                    width:
                      (
                        (filteredData.progression.day /
                          filteredData.progression.totalDays) *
                        100
                      ).toFixed(0) + '%',
                  }"
                ></div>
              </div>
            </div>
          </div>
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Day</th>
                  <th>Target Progression</th>
                  <th>Achieved UDAs (Cumulative)</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in filteredData.progression.table" :key="index">
                  <td>{{ item.day }}</td>
                  <td>{{ item.targetProgression }}</td>
                  <td>{{ item.achievedUDAs }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div v-if="currentView === 'distribution'" class="page-view">
        <h2 class="section-title">Band Distribution</h2>
        <div class="card">
          <div class="band-distribution-bars">
            <div v-for="(band, index) in filteredData.bandDistribution" :key="index">
              <p class="band-label">{{ band.name }}</p>
              <div class="progress-bar-bg">
                <div
                  class="progress-bar"
                  :class="getBandColor(band.name)"
                  :style="{
                    width:
                      ((band.udas / filteredData.kpis.achievedUDAs) * 100).toFixed(0) +
                      '%',
                  }"
                ></div>
              </div>
            </div>
          </div>
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Band</th>
                  <th>UDAs</th>
                  <th>% of Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(band, index) in filteredData.bandDistribution" :key="index">
                  <td>{{ band.name }}</td>
                  <td>{{ band.udas }}</td>
                  <td>
                    {{ ((band.udas / filteredData.kpis.achievedUDAs) * 100).toFixed(1) }}%
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div v-if="currentView === 'leaderboard'" class="page-view">
        <h2 class="section-title">Performer Leaderboard</h2>
        <div class="card">
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Performer</th>
                  <th>Achieved UDAs</th>
                  <th>Target UDAs</th>
                  <th>% Complete</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(performer, index) in filteredData.leaderboard" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ performer.name }}</td>
                  <td>{{ performer.achieved }}</td>
                  <td>{{ performer.target }}</td>
                  <td>
                    <span
                      :class="{
                        'text-green-600': performer.achieved / performer.target >= 1,
                        'text-yellow-600':
                          performer.achieved / performer.target < 1 &&
                          performer.achieved / performer.target >= 0.9,
                        'text-red-600': performer.achieved / performer.target < 0.9,
                      }"
                    >
                      {{ ((performer.achieved / performer.target) * 100).toFixed(0) }}%
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div v-if="currentView === 'summary'" class="page-view">
        <h2 class="section-title">Period Summary</h2>
        <div class="card">
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Period</th>
                  <th>Target</th>
                  <th>Achieved</th>
                  <th>Provisional</th>
                  <th>Variance</th>
                  <th>% Complete</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(summary, index) in filteredData.periodSummary" :key="index">
                  <td>{{ summary.period }}</td>
                  <td>{{ summary.target }}</td>
                  <td>{{ summary.achieved }}</td>
                  <td>{{ summary.provisional }}</td>
                  <td>{{ summary.variance }}</td>
                  <td>{{ summary.complete }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div v-if="currentView === 'claims'" class="page-view">
        <h2 class="section-title">Claims Activity</h2>
        <div class="claims-controls">
          <!-- <input
            type="text"
            placeholder="Search claims..."
            class="search-input"
            v-model="searchQuery"
          /> -->
          <div class="claims-buttons">
            <button
              class="status-button all"
              :class="{ active: selectedStatus === 'All' }"
              @click="selectedStatus = 'All'"
            >
              All
            </button>
            <button
              class="status-button confirmed"
              :class="{ active: selectedStatus === 'Confirmed' }"
              @click="selectedStatus = 'Confirmed'"
            >
              Confirmed
            </button>
            <button
              class="status-button provisional"
              :class="{ active: selectedStatus === 'Provisional' }"
              @click="selectedStatus = 'Provisional'"
            >
              Provisional
            </button>
            <button
              class="status-button rejected"
              :class="{ active: selectedStatus === 'Rejected' }"
              @click="selectedStatus = 'Rejected'"
            >
              Rejected
            </button>
            <button class="export-button" @click="exportClaimsToCsv">Export</button>
          </div>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Performer</th>
                <th>Patient</th>
                <th>Claim No.</th>
                <th>Band</th>
                <th>UDAs</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(claim, index) in filteredClaims" :key="index">
                <td>{{ claim.date }}</td>
                <td>{{ claim.performer }}</td>
                <td>{{ claim.patient }}</td>
                <td>{{ claim.claimNo }}</td>
                <td>{{ claim.band }}</td>
                <td>{{ claim.udas }}</td>
                <td>
                  <span :class="getStatusClass(claim.status)">{{ claim.status }}</span>
                </td>
              </tr>
              <tr v-if="filteredClaims.length === 0">
                <td colspan="7" class="no-results">No claims found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "UdaDashboard",
  data() {
    return {
      currentView: "progression", // Landing screen as requested
      filters: {
        contract: "All Contracts",
        performer: "All Performers",
        period: "Month",
        includeProvisional: true,
      },
      searchQuery: "",
      selectedStatus: "All",
      filterOptions: {
        contracts: ["All Contracts", "Contract A", "Contract B"],
        performers: ["All Performers", "Dr. Smith", "Dr. Jones", "Dr. Lee"],
        periods: ["Month", "Quarter", "Year", "Financial Year"],
      },
      // Dummy data for all views based on filter combinations
      dummyData: {
        "All Contracts-All Performers-Month-true": {
          alert: "⚠️ Dr. Smith is projected to underperform by 15% this quarter.",
          kpis: {
            targetUDAs: 10000,
            achievedUDAs: 8500,
            provisionalUDAs: 1200,
            variance: -300,
            forecast: 9800,
          },
          progression: {
            day: 25,
            totalDays: 30,
            table: [
              { day: 1, targetProgression: 0, achievedUDAs: 0 },
              { day: 5, targetProgression: 300, achievedUDAs: 250 },
              { day: 10, targetProgression: 600, achievedUDAs: 550 },
              { day: 15, targetProgression: 3000, achievedUDAs: 2800 },
              { day: 20, targetProgression: 6000, achievedUDAs: 5800 },
              { day: 25, targetProgression: 8300, achievedUDAs: 8500 },
            ],
          },
          bandDistribution: [
            { name: "Band 1", udas: 300 },
            { name: "Band 2", udas: 500 },
            { name: "Band 3", udas: 150 },
            { name: "Urgent", udas: 50 },
          ],
          leaderboard: [
            { name: "Dr. Smith", achieved: 1200, target: 1500 },
            { name: "Dr. Jones", achieved: 1800, target: 1700 },
            { name: "Dr. Lee", achieved: 900, target: 1000 },
          ],
          periodSummary: [
            {
              period: "Q1 2025",
              target: 2500,
              achieved: 2200,
              provisional: 350,
              variance: -100,
              complete: 88,
            },
          ],
          claimsActivity: [
            {
              date: "2023-08-12",
              performer: "Dr. Smith",
              patient: "Sophia Hayes",
              claimNo: "#25487",
              band: "Band 2",
              udas: 3,
              status: "Confirmed",
            },
            {
              date: "2023-08-11",
              performer: "Dr. Jones",
              patient: "Mia Coleman",
              claimNo: "#70546",
              band: "Band 1",
              udas: 1,
              status: "Provisional",
            },
            {
              date: "2023-08-10",
              performer: "Dr. Smith",
              patient: "Ethan Thompson",
              claimNo: "#68176",
              band: "Band 2",
              udas: 3,
              status: "Rejected",
            },
            {
              date: "2023-08-12",
              performer: "Dr. Jones",
              patient: "Liam Carter",
              claimNo: "#34521",
              band: "Urgent",
              udas: 1,
              status: "Confirmed",
            },
            {
              date: "2023-08-09",
              performer: "Dr. Lee",
              patient: "Olivia Rodriguez",
              claimNo: "#99823",
              band: "Band 3",
              udas: 2,
              status: "Provisional",
            },
          ],
        },
        "All Contracts-All Performers-Month-false": {
          alert: "Provisional claims are not included in the data.",
          kpis: {
            targetUDAs: 10000,
            achievedUDAs: 8500,
            provisionalUDAs: 0,
            variance: -1500,
            forecast: 8500,
          },
          progression: {
            day: 25,
            totalDays: 30,
            table: [
              { day: 1, targetProgression: 0, achievedUDAs: 0 },
              { day: 5, targetProgression: 300, achievedUDAs: 250 },
              { day: 10, targetProgression: 600, achievedUDAs: 550 },
              { day: 15, targetProgression: 3000, achievedUDAs: 2800 },
              { day: 20, targetProgression: 6000, achievedUDAs: 5800 },
              { day: 25, targetProgression: 8300, achievedUDAs: 8500 },
            ],
          },
          bandDistribution: [
            { name: "Band 1", udas: 300 },
            { name: "Band 2", udas: 500 },
            { name: "Band 3", udas: 150 },
            { name: "Urgent", udas: 50 },
          ],
          leaderboard: [
            { name: "Dr. Smith", achieved: 1200, target: 1500 },
            { name: "Dr. Jones", achieved: 1800, target: 1700 },
            { name: "Dr. Lee", achieved: 900, target: 1000 },
          ],
          periodSummary: [
            {
              period: "Q1 2025",
              target: 2500,
              achieved: 2200,
              provisional: 0,
              variance: -300,
              complete: 88,
            },
          ],
          claimsActivity: [
            {
              date: "2023-08-12",
              performer: "Dr. Smith",
              patient: "Sophia Hayes",
              claimNo: "#25487",
              band: "Band 2",
              udas: 3,
              status: "Confirmed",
            },
            {
              date: "2023-08-10",
              performer: "Dr. Smith",
              patient: "Ethan Thompson",
              claimNo: "#68176",
              band: "Band 2",
              udas: 3,
              status: "Rejected",
            },
            {
              date: "2023-08-12",
              performer: "Dr. Jones",
              patient: "Liam Carter",
              claimNo: "#34521",
              band: "Urgent",
              udas: 1,
              status: "Confirmed",
            },
          ],
        },
        "Contract A-Dr. Smith-Month-true": {
          alert: "Dr. Smith is on track for Contract A.",
          kpis: {
            targetUDAs: 5000,
            achievedUDAs: 4500,
            provisionalUDAs: 800,
            variance: 300,
            forecast: 5300,
          },
          progression: {
            day: 25,
            totalDays: 30,
            table: [
              { day: 1, targetProgression: 0, achievedUDAs: 0 },
              { day: 5, targetProgression: 150, achievedUDAs: 200 },
              { day: 10, targetProgression: 300, achievedUDAs: 400 },
              { day: 15, targetProgression: 1500, achievedUDAs: 1800 },
              { day: 20, targetProgression: 3000, achievedUDAs: 3500 },
              { day: 25, targetProgression: 4150, achievedUDAs: 4500 },
            ],
          },
          bandDistribution: [
            { name: "Band 1", udas: 150 },
            { name: "Band 2", udas: 250 },
            { name: "Band 3", udas: 75 },
            { name: "Urgent", udas: 25 },
          ],
          leaderboard: [
            { name: "Dr. Smith", achieved: 1200, target: 1500 },
            { name: "Dr. Jones", achieved: 1800, target: 1700 },
            { name: "Dr. Lee", achieved: 900, target: 1000 },
          ],
          periodSummary: [
            {
              period: "Q1 2025",
              target: 1250,
              achieved: 1100,
              provisional: 175,
              variance: 25,
              complete: 88,
            },
          ],
          claimsActivity: [
            {
              date: "2023-08-12",
              performer: "Dr. Smith",
              patient: "Sophia Hayes",
              claimNo: "#25487",
              band: "Band 2",
              udas: 3,
              status: "Confirmed",
            },
            {
              date: "2023-08-10",
              performer: "Dr. Smith",
              patient: "Ethan Thompson",
              claimNo: "#68176",
              band: "Band 2",
              udas: 3,
              status: "Rejected",
            },
          ],
        },
      },
    };
  },
  computed: {
    // A single computed property to get the correct data based on filters
    filteredData() {
      const key = `${this.filters.contract}-${this.filters.performer}-${this.filters.period}-${this.filters.includeProvisional}`;
      return (
        this.dummyData[key] || this.dummyData["All Contracts-All Performers-Month-true"]
      );
    },
    // Filter claims data based on search and status
    filteredClaims() {
      let claims = this.filteredData.claimsActivity;
      if (this.selectedStatus !== "All") {
        claims = claims.filter((claim) => claim.status === this.selectedStatus);
      }
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        claims = claims.filter((claim) =>
          Object.values(claim).some((value) =>
            String(value).toLowerCase().includes(query)
          )
        );
      }
      return claims;
    },
  },
  methods: {
    // Method to switch between different views
    navigate(view) {
      this.currentView = view;
    },
    // Dynamically assign CSS classes for status badges
    getStatusClass(status) {
      return {
        "status-badge-confirmed": status === "Confirmed",
        "status-badge-provisional": status === "Provisional",
        "status-badge-rejected": status === "Rejected",
      };
    },
    // Dynamically assign colors for band distribution bars
    getBandColor(bandName) {
      switch (bandName) {
        case "Band 1":
          return "progress-red";
        case "Band 2":
          return "progress-blue";
        case "Band 3":
          return "progress-yellow";
        case "Urgent":
          return "progress-green";
        default:
          return "progress-gray";
      }
    },
    exportClaimsToCsv() {
      // Create the CSV content
      const headers = Object.keys(this.filteredClaims[0]).join(",");
      const csvContent = this.filteredClaims
        .map((claim) => Object.values(claim).join(","))
        .join("\n");
      const fullCsv = `${headers}\n${csvContent}`;

      // Create a Blob and a download link
      const blob = new Blob([fullCsv], { type: "text/csv;charset=utf-8;" });
      const url = URL.createObjectURL(blob);
      const link = document.createElement("a");
      link.setAttribute("href", url);
      link.setAttribute("download", "claims-activity.csv");
      link.style.visibility = "hidden";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
  },
};
</script>

<style scoped>
/* Main Layout */
.uda-dashboard-app {
  background-color: #f9f9f9; /* Light gray background */
  min-height: 100vh;
  font-family: "Inter", sans-serif;
  padding: 1.5rem; /* Add padding to the whole container */
}

/* Page content container with border */
.page-content-container {
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  padding: 1.5rem;
}

.page-view {
  padding: 0;
}

/* Header and Navigation */
header {
  padding-bottom: 1rem;
}
.nav-link {
  position: relative;
  padding: 0.5rem 0.75rem;
  font-size: 0.9rem;
  font-weight: 500;
  color: #4b5563; /* gray-600 */
  background: none;
  border: none;
  border-radius: 0;
  cursor: pointer;
  transition: color 0.2s ease;
}
.nav-link.active::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -4px; /* space below text */
  width: 100%;
  height: 2px;
  background-color: #000; /* underline */
  border-radius: 2px;
}
.nav-link.active {
  color: #000; /* active is darker and bold */
  font-weight: 600;
}

.nav-link:not(.active) {
  color: #4b5563;
}
.nav-link:not(.active):hover {
  background-color: #e5e7eb;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1rem;
}

.card {
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  margin-bottom: 1.5rem;
}

/* Filters */
.filters-card {
  padding: 1rem;
  box-shadow: none;
  border-top: 1px solid #e5e7eb;
  border-radius: 0;
  margin-bottom: 0;
}
.filters {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
}
.filter {
  flex: 1;
  min-width: 150px;
}
.filter label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
}
.filter select {
  margin-top: 0.25rem;
  display: block;
  width: 100%;
  padding-left: 0.75rem;
  padding-right: 2.5rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  font-size: 1rem;
  border-width: 1px;
  border-color: #d1d5db;
  border-radius: 0.375rem;
  outline: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"%3e%3cpath fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /%3e%3c/svg%3e');
  background-repeat: no-repeat;
  background-position: right 0.5rem center;
  background-size: 1.25em;
}
.filter-toggle {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding-top: 1.25rem;
}
.toggle-label-text {
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
}
.toggle-container {
  position: relative;
  display: inline-block;
  width: 2.5rem;
  height: 1.5rem;
  vertical-align: middle;
  transition: all 0.2s ease-in;
}
.toggle-checkbox {
  position: absolute;
  top: 0;
  left: 0;
  width: 2.5rem;
  height: 1.5rem;
  background-color: #d1d5db;
  border-radius: 9999px;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}
.toggle-checkbox:checked {
  background-color: #16a34a;
}
.toggle-label {
  content: "";
  position: absolute;
  top: 0.125rem;
  left: 0.125rem;
  width: 1.25rem;
  height: 1.25rem;
  border-radius: 9999px;
  background-color: #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  transition: all 0.2s ease-in-out;
}
.toggle-checkbox:checked + .toggle-label {
  transform: translateX(1rem);
}

/* Alert */
.alert {
  padding: 1rem;
  margin-bottom: 0;
  border-left-width: 4px;
  border-radius: 0.375rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  border-radius: 0;
  border-left: none;
}
.alert-red {
  background-color: #fef2f2;
  border-top: 1px solid #ef4444;
  color: #b91c1c;
}
.alert-title {
  font-weight: 700;
}

/* KPI Cards */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}
.kpi-card {
  background-color: #fff;
  padding: 1rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  border-left: 4px solid transparent;
}
.kpi-card h3 {
  font-size: 0.875rem;
  font-weight: 500;
  color: #6b7280;
}
.kpi-card p {
  font-size: 1.5rem;
  font-weight: 700;
  margin-top: 0.25rem;
}
.kpi-card .text-gray-800 {
  color: #1f2937;
}
.kpi-card .text-green-600 {
  color: #16a34a;
}
.kpi-card .text-blue-600 {
  color: #2563eb;
}
.kpi-card .text-yellow-600 {
  color: #ca8a04;
}
.kpi-card .text-red-600 {
  color: #dc2626;
}
.kpi-card.border-green {
  border-color: #16a34a;
}
.kpi-card.border-blue {
  border-color: #2563eb;
}
.kpi-card.border-yellow {
  border-color: #ca8a04;
}
.kpi-card.border-red {
  border-color: #dc2626;
}
.kpi-card.border-gray {
  border-color: #9ca3af;
}

/* Progress Bars */
.progress-bars-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.progress-text {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.25rem;
}
.progress-label {
  font-size: 1rem;
  font-weight: 500;
}
.progress-value {
  font-size: 0.875rem;
  font-weight: 500;
}
.progress-bar-bg {
  width: 100%;
  background-color: #e5e7eb;
  border-radius: 9999px;
  height: 1rem;
}
.progress-bar {
  height: 100%;
  border-radius: 9999px;
  transition: width 0.3s ease-in-out;
}
.progress-blue {
  background-color: #2563eb;
}
.progress-gray {
  background-color: #9ca3af;
}
.progress-red {
  background-color: #ef4444;
}
.progress-yellow {
  background-color: #f59e0b;
}
.progress-green {
  background-color: #10b981;
}

/* Tables */
.table-container {
  margin-top: 1.5rem;
  overflow-x: auto;
}
table {
  width: 100%;
  border-collapse: collapse;
}
thead {
  background-color: #f9fafb;
}
th {
  padding: 0.75rem 1.5rem;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 500;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
}
tbody {
  background-color: #fff;
}
td {
  padding: 1rem 1.5rem;
  white-space: nowrap;
  font-size: 0.875rem;
  color: #6b7280;
  border-bottom: 1px solid #e5e7eb;
}
td.no-results {
  text-align: center;
  font-style: italic;
  color: #9ca3af;
}

/* Claims Activity Table Styles */
.claims-table {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.claims-table thead {
  background-color: #f8f8f8;
  color: #616161;
}

.claims-table th {
  font-weight: 600;
  padding: 12px 16px;
  text-transform: none;
  font-size: 0.9rem;
  border-bottom: 2px solid #e0e0e0;
}

.claims-table tbody tr:last-child td {
  border-bottom: none;
}

.claims-table td {
  padding: 12px 16px;
  color: #424242;
  font-size: 0.95rem;
}

.claims-table td:first-child {
  font-weight: 600;
}

.claims-table td .status-badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 500;
  text-transform: capitalize;
}

.claims-table td .status-badge.status-accepted {
  background-color: #e8f5e9;
  color: #43a047;
}

.claims-table td .status-badge.status-error {
  background-color: #ffebee;
  color: #e53935;
}
/* Claims Controls */
.claims-controls {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 1.5rem;
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
}

.claims-controls .search-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  outline: none;
  font-size: 0.875rem;
  color: #4b5563;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%239e9e9e"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>');
  background-repeat: no-repeat;
  background-position: left 1rem center;
  background-size: 20px;
  padding-left: 3rem;
  background-color: #f9fafb;
}

@media (min-width: 768px) {
  .claims-controls {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
}
.claims-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}
.status-button {
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 500;
  background-color: #f3f4f6;
  color: #4b5563;
  transition: all 0.2s ease-in-out;
  cursor: pointer;
  border: 1px solid transparent;
}
.status-button:hover {
  background-color: #e5e7eb;
}
.status-button.active {
  background-color: #1f2937;
  color: #fff;
}
.export-button {
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  background-color: #2563eb;
  color: #fff;
  font-weight: 500;
  font-size: 0.875rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}
.export-button:hover {
  background-color: #1e40af;
}

/* Status Badges */
.status-badge-confirmed {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #d1fae5;
  color: #065f46;
}
.status-badge-provisional {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #fef3c7;
  color: #b45309;
}
.status-badge-rejected {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #fee2e2;
  color: #991b1b;
}

/* Responsive adjustments */
@media (min-width: 768px) {
  .kpi-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
@media (min-width: 1024px) {
  .kpi-grid {
    grid-template-columns: repeat(5, minmax(0, 1fr));
  }
}
/* Tabs container */
.tabs {
  display: flex;
  border-bottom: 1px solid #ddd;
  margin-bottom: 1rem;
}

/* Each tab */
.tab {
  position: relative;
  padding: 0.5rem 1rem;
  font-size: 0.95rem;
  font-weight: 500;
  color: #555;
  background: none;
  border: none;
  cursor: pointer;
  transition: color 0.2s ease;
}

/* Hover effect */
.tab:hover {
  color: #000;
}

/* Active tab */
.tab.active {
  color: #000;
  font-weight: 600;
}

/* Active tab underline */
.tab.active::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -1px;
  width: 100%;
  height: 2px;
  background-color: #000;
  border-radius: 2px;
}

/* Tab content (unchanged) */
.tab-content {
  padding: 1rem 0;
}

/* New/Modified styles for Claims Activity view to match the image */
.claims-activity-container {
  padding: 2rem;
}

.claims-activity-controls {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
  background: #fff;
  padding: 2rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
}

.claims-activity-search {
  flex-grow: 1;
}

.claims-activity-search input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  outline: none;
  font-size: 0.9rem;
  color: #4b5563;
}

.claims-activity-buttons {
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.claims-activity-button {
  padding: 0.75rem 1.25rem;
  border-radius: 0.5rem;
  font-size: 0.9rem;
  font-weight: 500;
  border: 1px solid #d1d5db;
  background-color: #f3f4f6;
  color: #4b5563;
  cursor: pointer;
  transition: all 0.2s ease;
}

.claims-activity-button.active {
  background-color: #fff;
  color: #000;
  border-color: #000;
}

.claims-activity-table-container {
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  overflow: hidden;
  margin-bottom: 1.5rem;
}

.claims-activity-table {
  width: 100%;
  border-collapse: collapse;
}

.claims-activity-table th,
.claims-activity-table td {
  padding: 1rem 1.5rem;
  text-align: left;
  white-space: nowrap;
}

.claims-activity-table th {
  font-size: 0.85rem;
  font-weight: 600;
  color: #374151;
  background-color: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
}

.claims-activity-table td {
  font-size: 0.9rem;
  color: #6b7280;
  border-bottom: 1px solid #e5e7eb;
}

.claims-activity-table tbody tr:hover {
  background-color: #f9fafb;
}

.status-error {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #fee2e2;
  color: #991b1b;
}

.status-accepted {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #d1fae5;
  color: #065f46;
}

.status-pending {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #e5e7eb;
  color: #4b5563;
}

.status-submitted {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
  background-color: #bfdbfe;
  color: #1e40af;
}

.claims-actions-links {
  display: flex;
  gap: 1rem;
}

.claims-actions-links a {
  color: #2563eb;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
}

.claims-actions-links a:hover {
  text-decoration: underline;
}
</style>
