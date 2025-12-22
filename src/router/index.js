import { createRouter, createWebHistory } from 'vue-router';

// Layout (eager load for immediate display)
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const routes = [
  // ==========================================
  // Auth Routes (Guest Only)
  // ==========================================
  {
    path: '/',
    name: 'Login',
    component: () => import('@/pages/auth/login/Index.vue'),
    meta: { guest: true }
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import('@/pages/auth/signup/Index.vue'),
    meta: { guest: true }
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('@/pages/auth/forgot-password/Index.vue'),
    meta: { guest: true }
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: () => import('@/pages/auth/reset-password/Index.vue'),
    meta: { guest: true }
  },

  // ==========================================
  // Dashboard Routes (Authenticated)
  // ==========================================
  {
    path: '/dashboard',
    component: DashboardLayout,
    meta: { requiresAuth: true },
    children: [
      // Dashboard Home
      {
        path: '',
        name: 'DashboardHome',
        component: () => import('@/pages/dashboard/Index.vue'),
        meta: { permission: 'dashboard.view_own' }
      },

      // CRM
      {
        path: 'crm',
        name: 'CRM',
        component: () => import('@/pages/crm/Index.vue'),
        meta: { permission: 'patients.view' }
      },
      {
        path: 'crm/add-patient',
        name: 'AddPatient',
        component: () => import('@/pages/crm/AddPatient.vue'),
        meta: { permission: 'patients.create' }
      },
      {
        path: 'crm/view-patient/:id',
        name: 'ViewPatient',
        component: () => import('@/pages/crm/ViewPatient.vue'),
        props: true,
        meta: { permission: 'patients.view' }
      },

      // Appointments
      {
        path: 'appointments',
        component: () => import('@/pages/appointments/Index.vue'),
        meta: { permissions: ['appointments.view_own', 'appointments.view_all'] },
        children: [
          {
            path: 'scheduler',
            name: 'Scheduler',
            component: () => import('@/pages/appointments/components/Scheduler.vue'),
            meta: { permissions: ['appointments.view_own', 'appointments.view_all'] }
          },
          {
            path: 'history',
            name: 'AppointmentHistory',
            component: () => import('@/pages/appointments/components/AppointmentHistory.vue'),
            meta: { permissions: ['appointments.view_own', 'appointments.view_all'] }
          },
          {
            path: 'communication',
            name: 'PatientCommunication',
            component: () => import('@/pages/appointments/components/PatientCommunication.vue'),
            meta: { permission: 'communication.view_history' }
          },
          {
            path: 'billing',
            name: 'BillingInformation',
            component: () => import('@/pages/appointments/components/BillingInformation.vue'),
            meta: { permission: 'financials.view_patient_balance' }
          },
          {
            path: 'waiting-list',
            name: 'WaitingList',
            component: () => import('@/pages/appointments/components/WaitingList.vue'),
            meta: { permission: 'appointments.manage_waiting_room' }
          },
          {
            path: 'types',
            name: 'AppointmentTypes',
            component: () => import('@/pages/appointments/components/AppointmentTypes.vue'),
            meta: { permission: 'settings.manage_appointment_types' }
          },
          {
            path: 'new',
            name: 'NewAppointment',
            component: () => import('@/pages/appointments/components/NewAppointment.vue'),
            meta: { permission: 'appointments.create' }
          },
        ],
      },

      // Chart
      {
        path: 'chart',
        name: 'ChartView',
        component: () => import('@/pages/chart/Index.vue'),
        meta: { permission: 'chart.view' }
      },

      // Clinical Notes
      {
        path: 'notes',
        name: 'ClinicalNotes',
        component: () => import('@/pages/clinical-notes/Index.vue'),
        meta: { permissions: ['notes.view', 'treatment_plan.view'] }
      },

      // Patients
      {
        path: 'patients',
        name: 'Patients',
        component: () => import('@/pages/patients/Index.vue'),
        meta: { permission: 'patients.view' }
      },

      // File Storage
      {
        path: 'files',
        name: 'FileStorage',
        component: () => import('@/pages/file-storage/Index.vue'),
        meta: { permission: 'imaging.view' }
      },

      // Private Treatment & Invoicing
      {
        path: 'private-treatment-invoicing',
        name: 'PrivateTreatmentInvoicing',
        component: () => import('@/pages/invoicing/Index.vue'),
        meta: { permission: 'financials.view_patient_balance' }
      },

      // NHS FP17 Claims
      {
        path: 'claims',
        name: 'NHSFP17Claims',
        component: () => import('@/pages/claims/Index.vue'),
        meta: { permissions: ['insurance.view', 'insurance.create_claim'] }
      },

      // UDA Management
      {
        path: 'uda',
        name: 'UDAManagement',
        component: () => import('@/pages/uda-management/Index.vue'),
        meta: { permissions: ['insurance.view', 'reports.view_production'] }
      },

      // Performer & Contract Management
      {
        path: 'pcm',
        name: 'PerformerContractManagement',
        component: () => import('@/pages/performer-management/Index.vue'),
        meta: { permission: 'staff.view' }
      },

      // Lab & Referral Workflow
      {
        path: 'lab',
        name: 'LabReferralWorkflow',
        component: () => import('@/pages/lab-workflow/Index.vue'),
        meta: { permissions: ['lab.view', 'referrals.view'] }
      },

      // Family
      {
        path: 'family',
        name: 'Family',
        component: () => import('@/pages/family/Index.vue'),
        meta: { permission: 'patients.view_family' }
      },

      // Imaging
      {
        path: 'imaging',
        name: 'Imaging',
        component: () => import('@/pages/imaging/Index.vue'),
        meta: { permission: 'imaging.view' }
      },

      // Staff
      {
        path: 'staff',
        name: 'Staff',
        component: () => import('@/pages/staff/Index.vue'),
        meta: { permission: 'staff.view' }
      },

      // Reports
      {
        path: 'reports',
        name: 'Reports',
        component: () => import('@/pages/reports/Index.vue'),
        meta: { permission: 'reports.view_basic' }
      },

      // Settings
      {
        path: 'settings',
        name: 'Settings',
        component: () => import('@/pages/settings/Index.vue'),
        meta: { permission: 'settings.view' }
      },
    ],
  },

  // ==========================================
  // Error Routes
  // ==========================================
  {
    path: '/error',
    name: 'ServerError',
    component: () => import('@/pages/errors/server-error/Index.vue'),
  },
  {
    path: '/unauthorized',
    name: 'Unauthorized',
    component: () => import('@/pages/errors/unauthorized/Index.vue'),
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/pages/errors/not-found/Index.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard
router.beforeEach(async (to, from, next) => {
  // Dynamically import to ensure Pinia is initialized
  const { useAuthStore } = await import('@/stores/auth');
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
