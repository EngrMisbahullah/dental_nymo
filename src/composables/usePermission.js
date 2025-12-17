import { computed } from 'vue';
import { useAuthStore } from '../stores/auth';

/**
 * Composable for permission checking throughout the application
 * Based on the ACL-Roles-Permissions.md specification
 */
export function usePermission() {
  const authStore = useAuthStore();

  /**
   * Check if user has a specific permission
   * @param {string} permission - Permission key (e.g., 'patients.view')
   * @returns {boolean}
   */
  const hasPermission = (permission) => {
    return authStore.hasPermission(permission);
  };

  /**
   * Check if user has ANY of the provided permissions
   * @param {string[]} permissions - Array of permission keys
   * @returns {boolean}
   */
  const hasAnyPermission = (permissions) => {
    return authStore.hasAnyPermission(permissions);
  };

  /**
   * Check if user has ALL of the provided permissions
   * @param {string[]} permissions - Array of permission keys
   * @returns {boolean}
   */
  const hasAllPermissions = (permissions) => {
    return authStore.hasAllPermissions(permissions);
  };

  /**
   * Check if user has a specific role
   * @param {string} roleName - Role name or ID
   * @returns {boolean}
   */
  const hasRole = (roleName) => {
    return authStore.hasRole(roleName);
  };

  /**
   * Check if user has any of the specified roles
   * @param {string[]} roleNames - Array of role names or IDs
   * @returns {boolean}
   */
  const hasAnyRole = (roleNames) => {
    return roleNames.some((role) => authStore.hasRole(role));
  };

  /**
   * Check if user is a staff member (internal user)
   * @returns {boolean}
   */
  const isStaff = computed(() => {
    const roles = authStore.roles;
    return roles.some((r) => r.is_staff === true);
  });

  /**
   * Check if user is a provider (dentist, hygienist, etc.)
   * @returns {boolean}
   */
  const isProvider = computed(() => {
    const roles = authStore.roles;
    return roles.some((r) => r.is_provider === true);
  });

  /**
   * Check if user is an external user (patient, referring provider, lab tech)
   * @returns {boolean}
   */
  const isExternal = computed(() => {
    const roles = authStore.roles;
    return roles.some((r) => r.is_external === true);
  });

  /**
   * Get user's highest hierarchy level (lower number = higher access)
   * @returns {number}
   */
  const hierarchyLevel = computed(() => {
    const roles = authStore.roles;
    if (!roles || roles.length === 0) return 999;
    return Math.min(...roles.map((r) => r.hierarchy_level || 999));
  });

  /**
   * Check if user can access a specific module
   * @param {string} module - Module name (e.g., 'patients', 'appointments')
   * @returns {boolean}
   */
  const canAccessModule = (module) => {
    const permissions = authStore.permissions;
    if (!permissions) return false;

    // Check for wildcard access
    if (permissions.includes('*')) return true;
    if (permissions.includes(`${module}.*`)) return true;

    // Check for any permission in the module
    return permissions.some((p) => p.startsWith(`${module}.`));
  };

  /**
   * Get all permissions for a specific module
   * @param {string} module - Module name
   * @returns {string[]}
   */
  const getModulePermissions = (module) => {
    const permissions = authStore.permissions;
    if (!permissions) return [];
    return permissions.filter((p) => p.startsWith(`${module}.`));
  };

  return {
    // Permission checks
    hasPermission,
    hasAnyPermission,
    hasAllPermissions,
    // Role checks
    hasRole,
    hasAnyRole,
    // User type checks
    isStaff,
    isProvider,
    isExternal,
    // Hierarchy
    hierarchyLevel,
    // Module access
    canAccessModule,
    getModulePermissions,
    // Direct access to store values
    user: computed(() => authStore.user),
    permissions: computed(() => authStore.permissions),
    roles: computed(() => authStore.roles),
    isAuthenticated: computed(() => authStore.isAuthenticated),
  };
}
