import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import api from '../services/api';

export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref(null);
  const token = ref(localStorage.getItem('auth_token') || null);
  const loading = ref(false);
  const error = ref(null);

  // Getters
  const isAuthenticated = computed(() => !!token.value && !!user.value);
  const permissions = computed(() => user.value?.permissions || []);
  const roles = computed(() => user.value?.roles || []);

  // Check if user has a specific permission
  const hasPermission = (permission) => {
    if (!user.value || !permissions.value) return false;

    // Check wildcard (full access)
    if (permissions.value.includes('*')) return true;

    // Check exact match
    if (permissions.value.includes(permission)) return true;

    // Check module wildcard (e.g., "patients.*")
    const [module] = permission.split('.');
    if (permissions.value.includes(`${module}.*`)) return true;

    return false;
  };

  // Check if user has any of the given permissions
  const hasAnyPermission = (perms) => {
    return perms.some((p) => hasPermission(p));
  };

  // Check if user has all of the given permissions
  const hasAllPermissions = (perms) => {
    return perms.every((p) => hasPermission(p));
  };

  // Check if user has a specific role
  const hasRole = (roleName) => {
    if (!roles.value) return false;
    return roles.value.some((r) => r.name === roleName || r.id === roleName);
  };

  // Actions
  const login = async (email, password) => {
    loading.value = true;
    error.value = null;

    try {
      const response = await api.post('/login', { email, password });
      const data = response.data;

      // Store token
      token.value = data.token;
      localStorage.setItem('auth_token', data.token);

      // Store user data
      user.value = data.user;
      localStorage.setItem('user', JSON.stringify(data.user));

      return { success: true, user: data.user };
    } catch (err) {
      const message = err.response?.data?.message ||
                      err.response?.data?.errors?.email?.[0] ||
                      'Login failed. Please try again.';
      error.value = message;
      return { success: false, error: message };
    } finally {
      loading.value = false;
    }
  };

  const logout = async () => {
    loading.value = true;

    try {
      await api.post('/logout');
    } catch (err) {
      // Ignore logout errors - we'll clear local data anyway
      console.error('Logout error:', err);
    } finally {
      // Clear all auth data
      token.value = null;
      user.value = null;
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      loading.value = false;
    }
  };

  const fetchUser = async () => {
    if (!token.value) return null;

    loading.value = true;
    try {
      const response = await api.get('/me');
      user.value = response.data.user;
      localStorage.setItem('user', JSON.stringify(response.data.user));
      return response.data.user;
    } catch (err) {
      // Token is invalid, clear auth data
      token.value = null;
      user.value = null;
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      return null;
    } finally {
      loading.value = false;
    }
  };

  // Initialize user from localStorage
  const initializeAuth = () => {
    const storedUser = localStorage.getItem('user');
    if (storedUser && token.value) {
      try {
        user.value = JSON.parse(storedUser);
      } catch (e) {
        localStorage.removeItem('user');
      }
    }
  };

  // Initialize on store creation
  initializeAuth();

  return {
    // State
    user,
    token,
    loading,
    error,
    // Getters
    isAuthenticated,
    permissions,
    roles,
    // Permission helpers
    hasPermission,
    hasAnyPermission,
    hasAllPermissions,
    hasRole,
    // Actions
    login,
    logout,
    fetchUser,
    initializeAuth,
  };
});
