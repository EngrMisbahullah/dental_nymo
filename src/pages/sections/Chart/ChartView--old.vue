<template>
  <div class="app-container">
    <div class="main-layout">
      <div class="sidebar">
        <div class="button-group">
          <button
            v-for="view in ['PD', 'PTD', 'DD', 'DTD']"
            :key="view"
            :class="{ done: selectedView === view }"
            @click="selectedView = view"
          >
            {{ view }}
          </button>
        </div>

        <div class="button-group" style="margin-top: 10px">
          <button
            :class="{ done: selectedListView === 'treatmentList' }"
            @click="selectedListView = 'treatmentList'"
          >
            Treatment List
          </button>
          <button
            :class="{ done: selectedListView === 'plans' }"
            @click="selectedListView = 'plans'"
          >
            Plans
          </button>
        </div>

        <div v-if="selectedListView === 'treatmentList'">
          <h2>Treatment List</h2>
          <div class="search-container">
            <span class="material-icons icon">search</span>
            <input type="text" placeholder="Search..." class="search-input" />
          </div>

          <ul class="treatment-list">
            <li
              v-for="treatment in treatments"
              :key="treatment.id"
              :class="{ active: treatment.id === selectedTreatmentId }"
              @click="selectTreatment(treatment.id)"
            >
              ⭐ {{ treatment.name }}
            </li>
          </ul>
        </div>

        <div v-else-if="selectedListView === 'plans'">
          <h2>Plans</h2>
          <div class="search-container">
            <span class="material-icons icon">search</span>
            <input type="text" placeholder="Search..." class="search-input" />
          </div>

          <ul class="treatment-list">
            <li
              v-for="plan in plans"
              :key="plan.id"
              :class="{ active: plan.id === selectedPlanId }"
              @click="selectPlan(plan.id)"
            >
              ⭐ {{ plan.name }}
            </li>
          </ul>
        </div>
      </div>

      <div class="content">
        <div class="custom-jaw-chart">
          <div class="jaw-labels">
            <span>R</span>
            <span>L</span>
          </div>

          <div class="number-row">
            <div class="flex-numbers">
              <span>8</span><span>7</span><span>6</span><span>5</span><span>4</span
              ><span>3</span><span>2</span><span>1</span>
            </div>
            <div class="flex-numbers">
              <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span
              ><span>6</span><span>7</span><span>8</span>
            </div>
          </div>

          <div class="jaw upper">
            <div class="tooth-row">
              <div v-for="n in 16" :key="'u' + n" class="tooth upper-tooth">
                <div class="surface top"></div>
                <div class="surface right"></div>
                <div class="surface bottom"></div>
                <div class="surface left"></div>
                <div class="center"></div>
                <div class="root upper-root" v-if="n <= 5 || n >= 12"></div>
                <div class="molar-root molar-root-upper" v-else>
                  <div class="r1"></div>
                  <div class="r2"></div>
                  <div v-if="n === 1 || n === 16" class="r3"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="jaw lower">
            <div class="tooth-row">
              <div v-for="n in 16" :key="'l' + n" class="tooth lower-tooth">
                <div class="surface top"></div>
                <div class="surface right"></div>
                <div class="surface bottom"></div>
                <div class="surface left"></div>
                <div class="center"></div>
                <div class="root lower-root" v-if="n <= 5 || n >= 12"></div>
                <div class="molar-root molar-root-lower" v-else>
                  <div class="r1"></div>
                  <div class="r2"></div>
                  <div v-if="n === 1 || n === 16" class="r3"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="number-row bottom">
            <div class="flex-numbers">
              <span>8</span><span>7</span><span>6</span><span>5</span><span>4</span
              ><span>3</span><span>2</span><span>1</span>
            </div>
            <div class="flex-numbers">
              <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span
              ><span>6</span><span>7</span><span>8</span>
            </div>
          </div>

          <div class="jaw-labels bottom">
            <span>R</span>
            <span>L</span>
          </div>
        </div>

        <div class="btn-group">
          <div class="grow"></div>
          <div class="links">
            <a href="#" @click.prevent="openModal('Images')">Images</a>
            <a href="#" @click.prevent="openModal('BPE')">BPE</a>
            <a href="#" @click.prevent="openModal('History')">History</a>
            <a href="#" @click.prevent="openModal('Base Chart')">Base Chart</a>
            <a href="#" @click.prevent="openModal('Ortho')">Ortho</a>
          </div>
        </div>

        <div v-if="selectedView === 'PD' && selectedListView === 'treatmentList'">
          <div class="table-container">
            <div v-if="selectedTreatment && selectedTreatment.tableData">
              <table>
                <thead>
                  <tr>
                    <th>APPT.</th>
                    <th>EXAM</th>
                    <th>{{ selectedTreatment.name }}</th>
                    <th class="text-right">Price</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in selectedTreatment.tableData" :key="index">
                    <td>
                      <input type="checkbox" :checked="!!row.appt" />
                      {{ row.appt }}
                    </td>
                    <td>
                      <input type="checkbox" :checked="!!row.exam" />
                      {{ row.exam }}
                    </td>
                    <td>
                      {{ row.patient }}
                      <small v-if="row.date">{{ row.date }}</small>
                    </td>
                    <td class="text-right">
                      <span v-if="row.status" class="status">{{ row.status }}</span>
                      <span v-else>{{ row.price }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="table-footer">
                <div>
                  <strong>Total Price: £186.00</strong>
                  <span class="text-muted">Uncharged: £186.00</span>
                </div>
                <div class="actions">
                  <button class="secondary">Charge</button>
                  <button class="primary">Complete treatment plan</button>
                </div>
              </div>
            </div>
            <div v-else>
              <p>No table data available for this treatment.</p>
            </div>
          </div>
        </div>

        <div v-else-if="selectedView === 'PD' && selectedListView === 'plans'">
          <div class="plan-details">
            <div v-if="selectedPlan">
              <h3>Plan: {{ selectedPlan.name }}</h3>
              <p>{{ selectedPlan.description }}</p>
              <h4>Procedures:</h4>
              <ul>
                <li v-for="(proc, index) in selectedPlan.procedures" :key="index">
                  {{ proc }}
                </li>
              </ul>
              <div
                v-if="selectedPlan.images && selectedPlan.images.length > 0"
                class="plan-images"
              >
                <h5>Related Images:</h5>
                <div
                  class="image-wrapper small"
                  v-for="(img, index) in selectedPlan.images"
                  :key="index"
                >
                  <img :src="img.url" :alt="img.label" />
                  <span class="img-label">{{ img.label }}</span>
                </div>
              </div>
            </div>
            <div v-else>
              <p>No plan selected.</p>
            </div>
          </div>
        </div>

        <div v-else-if="selectedView === 'PTD'">
          <div class="ptd-content">
            <h3>PTD View</h3>
            <p>
              This is the content for the PTD (Planned Treatment Done) view. You can add
              specific components and data here.
            </p>
          </div>
        </div>

        <div v-else-if="selectedView === 'DD'">
          <div class="dd-content">
            <h3>DD View</h3>
            <p>
              This is the content for the DD (Done) view. This section will show all
              completed treatments.
            </p>
          </div>
        </div>

        <div v-else-if="selectedView === 'DTD'">
          <div class="dtd-content">
            <h3>DTD View</h3>
            <p>
              This is the content for the DTD (Done Treatment Done) view. You can
              customize the layout here.
            </p>
          </div>
        </div>
      </div>

      <aside class="right-panel">
        <div class="panel-header">
          <h2>Visuals</h2>
        </div>
        <div class="images">
          <div
            class="image-wrapper"
            v-for="(image, index) in rightPanelImages"
            :key="index"
          >
            <img :src="image.url" :alt="image.label" />
            <span class="img-label">{{ image.label }}</span>
          </div>
        </div>
      </aside>
    </div>

    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ modalTitle }}</h3>
          <span class="close-btn" @click="closeModal">&times;</span>
        </div>
        <div class="modal-body">
          <div v-if="modalTitle === 'Images'">
            <div class="images modal-images">
              <div
                class="image-wrapper large"
                v-for="(image, index) in rightPanelImages"
                :key="index"
              >
                <img :src="image.url" :alt="image.label" />
                <span class="img-label">{{ image.label }}</span>
              </div>
            </div>
          </div>
          <div v-else-if="modalTitle === 'BPE'">
            <h4>Basic Periodontal Examination Scores</h4>
            <div class="bpe-table">
              <table>
                <thead>
                  <tr>
                    <th>Sextant</th>
                    <th>Score</th>
                    <th>Notes</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Upper Right</td>
                    <td>1</td>
                    <td>Bleeding on probing</td>
                  </tr>
                  <tr>
                    <td>Upper Anterior</td>
                    <td>2</td>
                    <td>Calculus present</td>
                  </tr>
                  <tr>
                    <td>Upper Left</td>
                    <td>3</td>
                    <td>Probing depth 4-5mm</td>
                  </tr>
                  <tr>
                    <td>Lower Left</td>
                    <td>0</td>
                    <td>Healthy</td>
                  </tr>
                  <tr>
                    <td>Lower Anterior</td>
                    <td>1</td>
                    <td>Bleeding on probing</td>
                  </tr>
                  <tr>
                    <td>Lower Right</td>
                    <td>2</td>
                    <td>Calculus present</td>
                  </tr>
                </tbody>
              </table>
              <p class="bpe-key">
                **Key:** 0 = Healthy, 1 = Bleeding on probing, 2 = Calculus present, 3 =
                Probing depth 4-5mm, 4 = Probing depth 6mm+, * = Furcation involvement.
              </p>
            </div>
          </div>
          <div v-else-if="modalTitle === 'History'">
            <h4>Patient Medical History</h4>
            <p>
              **Allergies:** Penicillin<br />
              **Medical Conditions:** Controlled hypertension, Mild asthma<br />
              **Medications:** Lisinopril, Albuterol (as needed)<br />
              **Notes:** Patient reports no smoking and infrequent alcohol use.
            </p>
          </div>
          <div v-else-if="modalTitle === 'Base Chart'">
            <h4>Base Dental Chart</h4>
            <div class="chart-content">
              <p>
                This section shows the permanent and deciduous dentition, along with any
                existing restorations, missing teeth, or other conditions. This is a
                comprehensive view for planning purposes.
              </p>
              <img
                :src="'https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M'"
                alt="Detailed Dental Chart"
                style="width: 100%; border-radius: 8px"
              />
              <p>
                **Annotations:**<br />
                - **#18:** Missing<br />
                - **#14:** Amalgam filling<br />
                - **#25:** Crown<br />
                - **#36:** Root canal completed
              </p>
            </div>
          </div>
          <div v-else-if="modalTitle === 'Ortho'">
            <h4>Orthodontic Treatment Plan</h4>
            <p>
              **Current Plan:** Braces for upper and lower arches.<br />
              **Objective:** Correct Class II malocclusion and close diastema between
              central incisors.<br />
              **Estimated Duration:** 18-24 months.<br />
              **Appointments:** Monthly adjustments scheduled.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "DentalRecordsApp",
  data() {
    return {
      filterText: "",
      selectedView: "PD", // Tracks PD, PTD, DD, DTD
      selectedListView: "treatmentList", // Tracks Treatment List and Plans
      highlightedTeeth: ["UR6"],
      patient: ref(null),
      isModalOpen: false,
      modalTitle: "",

      treatments: [
        {
          id: 1,
          name: "01201 Exam & Diag, Limited Oral...",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 1",
              exam: "Acquire Images",
              patient: "Al Thomason",
              date: "Fri 13 Sep at 9:00",
              price: "£50.00",
              status: "Arrived",
            },
            {
              appt: "",
              exam: "Fri 11 Oct 24",
              patient: "AM (Private)",
              date: "",
              price: "£0.00",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Exam & Diag",
            },
          ],
        },
        {
          id: 2,
          name: "02102 Radiographs, Regional/Loc...",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 2",
              exam: "Full Mouth X-Ray",
              patient: "Jane Doe",
              date: "Tue 10 Sep at 10:00",
              price: "£75.00",
              status: "In Progress",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Full Mouth X-Ray",
            },
          ],
        },
        {
          id: 3,
          name: "21223 Non Bonded, Permanent M...",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 3",
              exam: "Check Gums",
              patient: "John Smith",
              date: "Mon 09 Sep at 11:00",
              price: "£60.00",
              status: "Completed",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Molar Restoration",
            },
          ],
        },
        {
          id: 4,
          name: "56112 Dentures, Replication, Prov...",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 4",
              exam: "Denture Fitting",
              patient: "Emily White",
              date: "Thu 12 Sep at 13:00",
              price: "£150.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Denture Fitting",
            },
          ],
        },
        {
          id: 5,
          name: "100 Exam",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 5",
              exam: "General Exam",
              patient: "Michael Brown",
              date: "Wed 11 Sep at 14:00",
              price: "£40.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "General View",
            },
          ],
        },
        {
          id: 6,
          name: "101 Exam & Scale & Polish",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 6",
              exam: "Cleaning",
              patient: "Sarah Connor",
              date: "Fri 13 Sep at 15:00",
              price: "£85.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Scale & Polish",
            },
          ],
        },
        {
          id: 7,
          name: "102 New Patient Exam",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 7",
              exam: "New Patient Consult",
              patient: "Kyle Reese",
              date: "Mon 16 Sep at 10:00",
              price: "£95.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "New Patient",
            },
          ],
        },
        {
          id: 8,
          name: "103 Review",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 8",
              exam: "Follow-up",
              patient: "T-800",
              date: "Tue 17 Sep at 11:00",
              price: "£30.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Review",
            },
          ],
        },
        {
          id: 9,
          name: "104 Assessment & Advice",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 9",
              exam: "Assessment",
              patient: "Dr. Silberman",
              date: "Wed 18 Sep at 12:00",
              price: "£45.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Assessment",
            },
          ],
        },
        {
          id: 10,
          name: "105 Small Radiograph",
          category: "PD",
          tableData: [
            {
              appt: "Appt. 10",
              exam: "Small X-Ray",
              patient: "Miles Dyson",
              date: "Thu 19 Sep at 13:00",
              price: "£25.00",
              status: "Scheduled",
            },
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Small Radiograph",
            },
          ],
        },
      ],

      plans: [
        {
          id: 1,
          name: "Crowns & Bridges Plan",
          description: "This plan includes procedures for dental crowns and bridges.",
          procedures: [
            "Preparation of tooth for crown",
            "Placement of temporary crown",
            "Fitting of permanent crown",
            "Bridge placement and cementing",
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Crown",
            },
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Bridge",
            },
          ],
        },
        {
          id: 2,
          name: "Root Canal Treatment Plan",
          description: "A detailed plan for endodontic treatment of a single tooth.",
          procedures: [
            "Diagnostic X-ray and assessment",
            "Access cavity preparation",
            "Root canal cleaning and shaping",
            "Obturation and final restoration",
          ],
          images: [
            {
              url:
                "https://lh3.googleusercontent.com/aida-public/AB6AXuDYIZ42a9f8CiUzhZNrVsaPFAPe2HfUaSpakjtMjDiY38QtxGVR_iFmBa7gRHPn50m5l9UUY5LebMuIZNuBLulA8wdvMup_x1SKKxg51Uin0bf0b6MpUb9d31lCoQQY56vhAkzuYH4870xODgbrbExVtuiaOyvNQvHNblo8zgDJh5Bm8CkaXyH8bIaNeWvk4tMfYEQHhkN0DW3_j9ujjpF83Ci7TbIo22yLXsV2FkWSE5vP6ux00U3phGhbF9MGEu_yNPa8lbfCy3M",
              label: "Root Canal",
            },
          ],
        },
      ],
      selectedPlanId: 1,
      selectedTreatmentId: 1,
    };
  },
  computed: {
    selectedTreatment() {
      return this.treatments.find((t) => t.id === this.selectedTreatmentId);
    },
    selectedPlan() {
      return this.plans.find((p) => p.id === this.selectedPlanId);
    },
    rightPanelImages() {
      if (this.selectedListView === "plans") {
        return this.selectedPlan ? this.selectedPlan.images : [];
      } else {
        return this.selectedTreatment ? this.selectedTreatment.images : [];
      }
    },
  },
  methods: {
    selectTreatment(id) {
      this.selectedTreatmentId = id;
    },
    selectPlan(id) {
      this.selectedPlanId = id;
    },
    highlightTooth(toothCode) {
      return this.highlightedTeeth.includes(toothCode) ? "highlight" : "";
    },
    openModal(title) {
      this.modalTitle = title;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
  },
};
</script>

<style scoped>
/*
 * This is the provided CSS. 
 * I haven't changed any of this. 
 * You can add new styles for the new sections (PTD, DD, DTD) as needed.
 */
.app-container {
  font-family: "Roboto", sans-serif;
  background-color: #f7fafc;
  height: 100vh;
  display: flex;
  flex-direction: column;
  width: 1180px;
}

.search-container {
  background: #edf2f7;
  display: flex;
  align-items: center;
  padding: 0.5rem;
  border-radius: 4px;
}

.search-input {
  border: none;
  background: transparent;
  margin-left: 0.5rem;
  outline: none;
}

.main-layout {
  flex: 1;
  display: flex;
  overflow: hidden;
}

.sidebar {
  width: 220px;
  background-color: #e2e8f0;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  overflow-y: auto;
}

.button-group {
  display: flex;
  gap: 0.5rem;
}

.button-group button {
  padding: 0.25rem 0.5rem;
  border: none;
  background: #cbd5e0;
  border-radius: 4px;
  flex: 1; /* Make buttons fill the space */
  cursor: pointer;
}

.button-group .done {
  background: #2b6cb0;
  color: white;
}

.treatment-list {
  list-style: none;
  padding: 0;
}

.treatment-list li {
  padding: 0.5rem;
  cursor: pointer;
}

.treatment-list li.active {
  background-color: #2b6cb0;
  color: white;
  border-radius: 4px;
}

.content {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
}

.ptd-content,
.dd-content,
.dtd-content,
.plan-details {
  background-color: white;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.btn-group {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.grow {
  flex-grow: 1;
}

.links a {
  margin-left: 1rem;
  color: #2b6cb0;
  text-decoration: none;
}

.table-container {
  background-color: white;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.table-container table {
  width: 100%;
  border-collapse: collapse;
}

.table-container th,
.table-container td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
}

.text-right {
  text-align: right;
}

.status {
  background-color: #38a169;
  color: white;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
}

.text-muted {
  color: #718096;
  font-size: 0.875rem;
}

.table-footer {
  margin-top: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.actions button {
  padding: 0.5rem 1rem;
  margin-left: 0.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.actions .secondary {
  background-color: #e2e8f0;
}

.actions .primary {
  background-color: #2b6cb0;
  color: white;
}

.right-panel {
  width: 250px;
  background-color: #edf2f7;
  padding: 1rem;
  overflow-y: auto;
}

.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.images {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.image-wrapper {
  position: relative;
}

.image-wrapper img {
  width: 100%;
  border-radius: 4px;
}

.img-label {
  position: absolute;
  bottom: 4px;
  right: 4px;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
  padding: 2px 4px;
  font-size: 0.75rem;
  border-radius: 2px;
}

.custom-jaw-chart {
  background: #f1f5f9;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
}

.jaw-labels,
.jaw-labels.bottom {
  display: flex;
  justify-content: space-between;
  padding: 0 2rem;
  color: #4b5563;
  margin-bottom: 0.5rem;
}

.number-row {
  display: flex;
  justify-content: center;
  gap: 1rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.number-row.bottom {
  margin-top: 1rem;
}

.flex-numbers {
  display: flex;
  gap: 0.2rem;
}

.flex-numbers span {
  width: 40px;
  text-align: center;
}

.jaw {
  background: #e5e7eb;
  padding: 0.5rem;
  border-radius: 6px;
  margin-bottom: 0.5rem;
}

.tooth-row {
  display: flex;
  justify-content: center;
  gap: 0.2rem;
}

.tooth {
  position: relative;
  width: 40px;
  height: 40px;
  border: 1px solid #9ca3af;
}

.surface {
  position: absolute;
  width: 0;
  height: 0;
}

.surface.top {
  border-left: 20px solid transparent;
  border-right: 20px solid transparent;
  border-bottom: 20px solid white;
  top: 0;
  left: 0;
}

.surface.bottom {
  border-left: 20px solid transparent;
  border-right: 20px solid transparent;
  border-top: 20px solid white;
  bottom: 0;
  left: 0;
}

.surface.left {
  border-top: 20px solid transparent;
  border-bottom: 20px solid transparent;
  border-right: 20px solid white;
  left: 0;
  top: 0;
}

.surface.right {
  border-top: 20px solid transparent;
  border-bottom: 20px solid transparent;
  border-left: 20px solid white;
  right: 0;
  top: 0;
}

.center {
  position: absolute;
  top: 10px;
  left: 10px;
  width: 20px;
  height: 20px;
  background-color: white;
  border: 1px solid #9ca3af;
}

.root.upper-root {
  position: absolute;
  width: 0;
  height: 0;
  border-left: 20px solid transparent;
  border-right: 20px solid transparent;
  border-bottom: 30px solid #f3e8d3;
  top: -30px;
  left: 0;
}

.root.lower-root {
  position: absolute;
  width: 0;
  height: 0;
  border-left: 20px solid transparent;
  border-right: 20px solid transparent;
  border-top: 30px solid #f3e8d3;
  bottom: -30px;
  left: 0;
}

.molar-root-upper,
.molar-root-lower {
  position: absolute;
  width: 40px;
  height: 30px;
  overflow: hidden;
}

.molar-root-upper {
  top: -30px;
}

.molar-root-lower {
  bottom: -30px;
}

.molar-root-upper > div,
.molar-root-lower > div {
  position: absolute;
  width: 0;
  height: 0;
  border-left: 13.33px solid transparent;
  border-right: 13.33px solid transparent;
}

.molar-root-upper .r1,
.molar-root-upper .r2,
.molar-root-upper .r3 {
  border-bottom: 25px solid #f3e8d3;
}

.molar-root-lower .r1,
.molar-root-lower .r2,
.molar-root-lower .r3 {
  border-top: 25px solid #f3e8d3;
}

.molar-root-upper .r1,
.molar-root-lower .r1 {
  left: 0;
}

.molar-root-upper .r2,
.molar-root-lower .r2 {
  left: 13.33px;
}

.molar-root-upper .r3,
.molar-root-lower .r3 {
  right: 0;
}

.plan-images {
  display: flex;
  gap: 10px;
  margin-top: 15px;
}

.image-wrapper.small {
  width: 100px;
  height: auto;
}

.image-wrapper.small img {
  width: 100%;
  height: auto;
  border-radius: 4px;
}

/* Modal specific styles */
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
  z-index: 1000;
}

.modal-content {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  max-width: 800px;
  width: 90%;
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 1rem;
  margin-bottom: 1rem;
}

.modal-header h3 {
  margin: 0;
}

.close-btn {
  font-size: 1.5rem;
  cursor: pointer;
}

.modal-images {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1rem;
}

.image-wrapper.large {
  width: 100%;
  height: auto;
}

.bpe-table table {
  width: 100%;
  border-collapse: collapse;
}

.bpe-table th,
.bpe-table td {
  border: 1px solid #cbd5e0;
  padding: 0.5rem;
  text-align: left;
}

.bpe-key {
  font-size: 0.8rem;
  color: #718096;
  margin-top: 1rem;
}

.chart-content img {
  margin: 1rem 0;
}
</style>
