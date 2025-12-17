/**
 * Vue directive for permission-based element visibility
 *
 * Usage:
 *   v-permission="'patients.view'"           - Single permission
 *   v-permission="['patients.view']"         - Array with single permission
 *   v-permission.any="['patients.view', 'patients.edit']"  - Any of the permissions
 *   v-permission.all="['patients.view', 'patients.edit']"  - All permissions required
 *
 * The element will be removed from DOM if user doesn't have the required permission(s)
 */

// Lazy getter for auth store to avoid Pinia initialization issues
let _authStore = null;
const getAuthStore = () => {
  if (!_authStore) {
    const { useAuthStore } = require('../stores/auth');
    _authStore = useAuthStore();
  }
  return _authStore;
};

export const vPermission = {
  mounted(el, binding) {
    checkPermission(el, binding);
  },
  updated(el, binding) {
    checkPermission(el, binding);
  },
};

function checkPermission(el, binding) {
  const authStore = getAuthStore();
  const { value, modifiers } = binding;

  if (!value) {
    console.warn('v-permission directive requires a permission value');
    return;
  }

  let hasAccess = false;

  // Handle array of permissions
  if (Array.isArray(value)) {
    if (modifiers.all) {
      // User must have ALL permissions
      hasAccess = authStore.hasAllPermissions(value);
    } else {
      // User must have ANY permission (default for arrays)
      hasAccess = authStore.hasAnyPermission(value);
    }
  } else {
    // Single permission check
    hasAccess = authStore.hasPermission(value);
  }

  if (!hasAccess) {
    // Remove element from DOM
    el.parentNode && el.parentNode.removeChild(el);
  }
}

/**
 * Vue directive for role-based element visibility
 *
 * Usage:
 *   v-role="'ROLE_DENTIST'"                    - Single role
 *   v-role="['ROLE_DENTIST', 'ROLE_HYGIENIST']" - Any of the roles
 */
export const vRole = {
  mounted(el, binding) {
    checkRole(el, binding);
  },
  updated(el, binding) {
    checkRole(el, binding);
  },
};

function checkRole(el, binding) {
  const authStore = getAuthStore();
  const { value } = binding;

  if (!value) {
    console.warn('v-role directive requires a role value');
    return;
  }

  let hasAccess = false;

  if (Array.isArray(value)) {
    hasAccess = value.some((role) => authStore.hasRole(role));
  } else {
    hasAccess = authStore.hasRole(value);
  }

  if (!hasAccess) {
    el.parentNode && el.parentNode.removeChild(el);
  }
}

/**
 * Vue directive for disabling elements based on permissions
 * Unlike v-permission, this keeps the element visible but disabled
 *
 * Usage:
 *   v-permission-disable="'patients.edit'"
 */
export const vPermissionDisable = {
  mounted(el, binding) {
    checkPermissionDisable(el, binding);
  },
  updated(el, binding) {
    checkPermissionDisable(el, binding);
  },
};

function checkPermissionDisable(el, binding) {
  const authStore = getAuthStore();
  const { value, modifiers } = binding;

  if (!value) return;

  let hasAccess = false;

  if (Array.isArray(value)) {
    if (modifiers.all) {
      hasAccess = authStore.hasAllPermissions(value);
    } else {
      hasAccess = authStore.hasAnyPermission(value);
    }
  } else {
    hasAccess = authStore.hasPermission(value);
  }

  if (!hasAccess) {
    el.disabled = true;
    el.classList.add('permission-disabled');
    el.style.opacity = '0.5';
    el.style.cursor = 'not-allowed';
    el.title = 'You do not have permission to perform this action';
  }
}

// Register all directives
export function registerPermissionDirectives(app) {
  app.directive('permission', vPermission);
  app.directive('role', vRole);
  app.directive('permission-disable', vPermissionDisable);
}

export default {
  vPermission,
  vRole,
  vPermissionDisable,
  registerPermissionDirectives,
};
