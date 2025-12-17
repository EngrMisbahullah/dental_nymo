import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue';
import DashboardLayout from '../pages/Dashboard.vue';

// Dashboard main views
import DashboardView from '../pages/sections/DashboardView.vue';

// Appointments
// We've removed AppointmentsView and will use AppointmentsLayout instead.
import AppointmentsLayout from '../pages/sections/Appointments/AppointmentsLayout.vue'; 
import Scheduler from '../pages/sections/Appointments/Components/Scheduler.vue';
import AppointmentHistory from '../pages/sections/Appointments/Components/AppointmentHistory.vue';
import PatientCommunication from '../pages/sections/Appointments/Components/PatientCommunication.vue';
import BillingInformation from '../pages/sections/Appointments/Components/BillingInformation.vue';
import WaitingList from '../pages/sections/Appointments/Components/WaitingList.vue';
import AppointmentTypes from '../pages/sections/Appointments/Components/AppointmentTypes.vue';
import NewAppointment from '../pages/sections/Appointments/Components/NewAppointment.vue';

// Chart module
import ChartView from '../pages/sections/Chart/ChartView.vue';

//clinical notes and treatment plan
import ClinicalNotes from '../pages/sections/ClinicalNotes/ClinicalNotes-TreatmentPlan.vue';

//Private Treatment & Invoicing
import PrivateTreatmentInvoicing from '../pages/sections/PrivateTreatmentInvoicing/PrivateTreatmentInvoicing.vue';
 
//Patient management
import PatientsView from '../pages/sections/Patients/Patients.vue';

// File storage
import FileStorage from '../pages/sections/FileStorage.vue';

// NHS FP17 Claims
import NHSFP17Claims from '../pages/sections/NHSFP17Claims/Claims.vue';

//UDA Management
import UDAManagement from '../pages/sections/UDAManagement/UDAManagement.vue';

//Performer & Contract Management
import PerformerContractManagement from '../pages/sections/Performer&ContractManagement/PerformerContractManagement.vue';

//Lab & Referral Workflow
import LabReferralWorkflow from '../pages/sections/Lab&ReferralWorkflow/LabReferralWorkflow.vue';

import StaffView from '../pages/sections/StaffView.vue';
import ReportsView from '../pages/sections/ReportsView.vue';
import SettingsView from '../pages/sections/SettingsView.vue';

// CRM views
import CRMView from '../pages/sections/CRM/CRMView.vue';
import AddPatient from '../pages/sections/CRM/AddPatient.vue';
import ViewPatient from '../pages/sections/CRM/ViewPatient.vue';

// Family module
import FamilyView from '../pages/sections/Family/FamilyView.vue';

// Imaging module
import ImagingView from '../pages/sections/Imaging/ImagingView.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
    meta: { guest: true }
  },
  {
    path: '/dashboard',
    component: DashboardLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'DashboardHome',
        component: DashboardView,
        meta: { permission: 'dashboard.view_own' }
      },
      {
        path: 'crm',
        name: 'CRM',
        component: CRMView,
        meta: { permission: 'patients.view' }
      },

      // CRM children are correctly placed here.
      {
        path: 'crm/add-patient',
        name: 'AddPatient',
        component: AddPatient,
        meta: { permission: 'patients.create' }
      },
      {
        path: 'crm/view-patient/:id',
        name: 'ViewPatient',
        component: ViewPatient,
        props: true,
        meta: { permission: 'patients.view' }
      },

      // Appointments routes
      {
        path: 'appointments',
        component: AppointmentsLayout,
        meta: { permissions: ['appointments.view_own', 'appointments.view_all'] },
        children: [
          {
            path: 'scheduler',
            name: 'Scheduler',
            component: Scheduler,
            meta: { permissions: ['appointments.view_own', 'appointments.view_all'] }
          },
          {
            path: 'history',
            name: 'AppointmentHistory',
            component: AppointmentHistory,
            meta: { permissions: ['appointments.view_own', 'appointments.view_all'] }
          },
          {
            path: 'communication',
            name: 'PatientCommunication',
            component: PatientCommunication,
            meta: { permission: 'communication.view_history' }
          },
          {
            path: 'billing',
            name: 'BillingInformation',
            component: BillingInformation,
            meta: { permission: 'financials.view_patient_balance' }
          },
          {
            path: 'waiting-list',
            name: 'WaitingList',
            component: WaitingList,
            meta: { permission: 'appointments.manage_waiting_room' }
          },
          {
            path: 'types',
            name: 'AppointmentTypes',
            component: AppointmentTypes,
            meta: { permission: 'settings.manage_appointment_types' }
          },
          {
            path: 'new',
            name: 'NewAppointment',
            component: NewAppointment,
            meta: { permission: 'appointments.create' }
          },
        ],
      },

      // chart
      {
        path: 'chart',
        name: 'ChartView',
        component: ChartView,
        meta: { permission: 'chart.view' }
      },

      // clinical notes
      {
        path: 'notes',
        name: 'ClinicalNotes',
        component: ClinicalNotes,
        meta: { permissions: ['notes.view', 'treatment_plan.view'] }
      },

      // patient management
      {
        path: 'patients',
        name: 'Patients',
        component: PatientsView,
        meta: { permission: 'patients.view' }
      },

      // file storage
      {
        path: 'files',
        name: 'FileStorage',
        component: FileStorage,
        meta: { permission: 'imaging.view' }
      },

      // PrivateTreatmentInvoicing
      {
        path: 'private-treatment-invoicing',
        name: 'PrivateTreatmentInvoicing',
        component: PrivateTreatmentInvoicing,
        meta: { permission: 'financials.view_patient_balance' }
      },

      // NHS FP17 Claims
      {
        path: 'claims',
        name: 'NHSFP17Claims',
        component: NHSFP17Claims,
        meta: { permissions: ['insurance.view', 'insurance.create_claim'] }
      },

      // UDA Management
      {
        path: 'uda',
        name: 'UDAManagement',
        component: UDAManagement,
        meta: { permissions: ['insurance.view', 'reports.view_production'] }
      },

      // Performer & Contract Management
      {
        path: 'pcm',
        name: 'PerformerContractManagement',
        component: PerformerContractManagement,
        meta: { permission: 'staff.view' }
      },

      // Lab & Referral Workflow
      {
        path: 'lab',
        name: 'LabReferralWorkflow',
        component: LabReferralWorkflow,
        meta: { permissions: ['lab.view', 'referrals.view'] }
      },

      // Family module
      {
        path: 'family',
        name: 'Family',
        component: FamilyView,
        meta: { permission: 'patients.view_family' }
      },

      // Imaging module
      {
        path: 'imaging',
        name: 'Imaging',
        component: ImagingView,
        meta: { permission: 'imaging.view' }
      },

      {
        path: 'staff',
        name: 'Staff',
        component: StaffView,
        meta: { permission: 'staff.view' }
      },
      {
        path: 'reports',
        name: 'Reports',
        component: ReportsView,
        meta: { permission: 'reports.view_basic' }
      },
      {
        path: 'settings',
        name: 'Settings',
        component: SettingsView,
        meta: { permission: 'settings.view' }
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard
router.beforeEach(async (to, from, next) => {
  // Dynamically import to ensure Pinia is initialized
  const { useAuthStore } = await import('../stores/auth');
  const authStore = useAuthStore();

  // Check if route requires authentication
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isGuestRoute = to.matched.some(record => record.meta.guest);

  if (requiresAuth && !authStore.isAuthenticated) {
    // Redirect to login if trying to access protected route without auth
    next({ name: 'Login' });
    return;
  }

  if (isGuestRoute && authStore.isAuthenticated) {
    // Redirect to dashboard if trying to access login while authenticated
    next({ path: '/dashboard' });
    return;
  }

  // Check route-level permissions
  const routePermission = to.meta.permission;
  const routePermissions = to.meta.permissions;

  if (routePermission || routePermissions) {
    let hasAccess = false;

    if (routePermission) {
      // Single permission required
      hasAccess = authStore.hasPermission(routePermission);
    } else if (routePermissions && Array.isArray(routePermissions)) {
      // Any of the permissions (OR logic)
      hasAccess = authStore.hasAnyPermission(routePermissions);
    }

    if (!hasAccess) {
      // User doesn't have permission
      console.warn(`Access denied to ${to.path}. Required: ${routePermission || routePermissions.join(', ')}`);

      // If user lacks dashboard access, redirect to login to prevent infinite loop
      if (to.name === 'DashboardHome' || to.path === '/dashboard') {
        console.error('User lacks basic dashboard permissions. Logging out.');
        await authStore.logout();
        next({ name: 'Login', query: { error: 'insufficient_permissions' } });
        return;
      }

      // Otherwise redirect to dashboard
      next({ name: 'DashboardHome' });
      return;
    }
  }

  next();
});

export default router;