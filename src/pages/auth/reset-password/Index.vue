<template>
  <div class="auth-page">
    <!-- Decorative Background -->
    <div class="auth-bg">
      <div class="bg-pattern"></div>
      <div class="floating-tooth tooth-1">🦷</div>
      <div class="floating-tooth tooth-2">🦷</div>
      <div class="floating-tooth tooth-3">🦷</div>
    </div>

    <div class="auth-container compact">
      <!-- Left Panel - Branding -->
      <div class="branding-panel">
        <div class="branding-content">
          <div class="brand-icon">
            <!-- <i class="fas fa-tooth"></i> -->
            <img src="/logo/logo.svg" alt="logo" />
          </div>
          <h1 class="brand-title">NymoDental</h1>
          <p class="brand-tagline">Professional Dental Practice Management</p>
          
          <div class="security-info">
            <div class="info-card">
              <i class="fas fa-lock"></i>
              <div>
                <h4>Create a Strong Password</h4>
                <p>Use a mix of letters, numbers, and symbols for maximum security.</p>
              </div>
            </div>
            <div class="info-card">
              <i class="fas fa-shield-alt"></i>
              <div>
                <h4>Your Security Matters</h4>
                <p>We use industry-standard encryption to protect your account.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Panel - Reset Password Form -->
      <div class="form-panel">
        <div class="form-content">
          <!-- Logo for mobile -->
          <div class="mobile-logo">
            <img src="/logo/logo.svg" alt="NymoDental" />
          </div>

          <!-- Token Error State -->
          <div v-if="tokenError" class="error-state">
            <div class="error-icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>Invalid or Expired Link</h3>
            <p>This password reset link is invalid or has expired. Please request a new one.</p>
            <router-link to="/forgot-password" class="request-new-btn">
              <i class="fas fa-redo"></i>
              Request New Link
            </router-link>
            <router-link to="/" class="back-to-login-link">
              <i class="fas fa-arrow-left"></i>
              Back to Login
            </router-link>
          </div>

          <!-- Success State -->
          <div v-else-if="resetSuccess" class="success-state">
            <div class="success-icon">
              <i class="fas fa-check"></i>
            </div>
            <h3>Password Reset Complete!</h3>
            <p>Your password has been successfully changed. You can now log in with your new password.</p>
            <router-link to="/" class="login-btn-link">
              <i class="fas fa-sign-in-alt"></i>
              Log In Now
            </router-link>
          </div>

          <!-- Reset Password Form -->
          <template v-else>
            <router-link to="/" class="back-link">
              <i class="fas fa-arrow-left"></i>
              Back to Login
            </router-link>

            <div class="form-header">
              <div class="header-icon">
                <i class="fas fa-lock-open"></i>
              </div>
              <h2>Reset Your Password</h2>
              <p>Enter your new password below. Make sure it's secure and memorable.</p>
            </div>

            <form @submit.prevent="handleSubmit" class="auth-form">
              <!-- New Password Field -->
              <div class="form-group">
                <label for="password">
                  <i class="fas fa-lock"></i>
                  New Password
                </label>
                <div class="input-wrapper" :class="{ 'has-error': v$.password.$error, 'is-valid': !v$.password.$invalid && password }">
                  <input
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    v-model="password"
                    @blur="v$.password.$touch()"
                    placeholder="Enter new password"
                    autocomplete="new-password"
                  />
                  <button 
                    type="button" 
                    class="toggle-password"
                    @click="showPassword = !showPassword"
                    :aria-label="showPassword ? 'Hide password' : 'Show password'"
                  >
                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                  </button>
                </div>
                <transition name="fade">
                  <div v-if="v$.password.$error" class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span v-if="v$.password.required.$invalid">Password is required</span>
                    <span v-else-if="v$.password.minLength.$invalid">Password must be at least 8 characters</span>
                  </div>
                </transition>
                
                <!-- Password strength indicator -->
                <div v-if="password" class="password-strength">
                  <div class="strength-bars">
                    <div class="bar" :class="{ active: passwordStrength >= 1 }"></div>
                    <div class="bar" :class="{ active: passwordStrength >= 2 }"></div>
                    <div class="bar" :class="{ active: passwordStrength >= 3 }"></div>
                    <div class="bar" :class="{ active: passwordStrength >= 4 }"></div>
                  </div>
                  <span class="strength-text">{{ passwordStrengthText }}</span>
                </div>
              </div>

              <!-- Confirm Password Field -->
              <div class="form-group">
                <label for="confirmPassword">
                  <i class="fas fa-lock"></i>
                  Confirm New Password
                </label>
                <div class="input-wrapper" :class="{ 'has-error': v$.confirmPassword.$error, 'is-valid': !v$.confirmPassword.$invalid && confirmPassword }">
                  <input
                    id="confirmPassword"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    v-model="confirmPassword"
                    @blur="v$.confirmPassword.$touch()"
                    placeholder="Confirm new password"
                    autocomplete="new-password"
                  />
                  <button 
                    type="button" 
                    class="toggle-password"
                    @click="showConfirmPassword = !showConfirmPassword"
                    :aria-label="showConfirmPassword ? 'Hide password' : 'Show password'"
                  >
                    <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                  </button>
                </div>
                <transition name="fade">
                  <div v-if="v$.confirmPassword.$error" class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span v-if="v$.confirmPassword.required.$invalid">Please confirm your password</span>
                    <span v-else-if="v$.confirmPassword.sameAs.$invalid">Passwords do not match</span>
                  </div>
                </transition>
              </div>

              <!-- Password Requirements -->
              <div class="password-requirements">
                <p class="requirements-title">Password must contain:</p>
                <ul>
                  <li :class="{ met: password.length >= 8 }">
                    <i :class="password.length >= 8 ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                    At least 8 characters
                  </li>
                  <li :class="{ met: /[A-Z]/.test(password) }">
                    <i :class="/[A-Z]/.test(password) ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                    One uppercase letter
                  </li>
                  <li :class="{ met: /[0-9]/.test(password) }">
                    <i :class="/[0-9]/.test(password) ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                    One number
                  </li>
                  <li :class="{ met: /[^A-Za-z0-9]/.test(password) }">
                    <i :class="/[^A-Za-z0-9]/.test(password) ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                    One special character
                  </li>
                </ul>
              </div>

              <!-- Error Alert -->
              <transition name="slide-fade">
                <div v-if="errorMessage" class="error-alert">
                  <i class="fas fa-exclamation-triangle"></i>
                  <span>{{ errorMessage }}</span>
                  <button type="button" @click="errorMessage = ''" class="close-alert">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </transition>

              <!-- Submit Button -->
              <button 
                type="submit" 
                class="submit-btn"
                :disabled="isSubmitDisabled"
                :class="{ 'is-loading': isSubmitting }"
              >
                <span v-if="!isSubmitting">
                  <i class="fas fa-save"></i>
                  Reset Password
                </span>
                <span v-else class="loading-spinner">
                  <i class="fas fa-circle-notch fa-spin"></i>
                  Resetting...
                </span>
              </button>
            </form>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useVuelidate } from '@vuelidate/core'
import { required, minLength, sameAs } from '@vuelidate/validators'

// Router
const route = useRoute()
const router = useRouter()

// Form state
const password = ref('')
const confirmPassword = ref('')
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')
const tokenError = ref(false)
const resetSuccess = ref(false)
const token = ref('')

// Validation rules
const rules = computed(() => ({
  password: { required, minLength: minLength(8) },
  confirmPassword: { required, sameAs: sameAs(password) }
}))

// Initialize vuelidate
const v$ = useVuelidate(rules, { password, confirmPassword })

// Password strength calculation
const passwordStrength = computed(() => {
  let strength = 0
  if (password.value.length >= 8) strength++
  if (/[A-Z]/.test(password.value)) strength++
  if (/[0-9]/.test(password.value)) strength++
  if (/[^A-Za-z0-9]/.test(password.value)) strength++
  return strength
})

const passwordStrengthText = computed(() => {
  const texts = ['Weak', 'Fair', 'Good', 'Strong']
  return texts[passwordStrength.value - 1] || 'Too short'
})

// Computed
const isSubmitDisabled = computed(() => {
  return v$.value.$invalid || isSubmitting.value
})

// Methods
const handleSubmit = async () => {
  const isFormValid = await v$.value.$validate()
  if (!isFormValid) return

  isSubmitting.value = true
  errorMessage.value = ''

  try {
    // TODO: Implement actual reset password API call
    // const result = await authStore.resetPassword({
    //   token: token.value,
    //   password: password.value
    // })
    
    // Simulating API call
    await new Promise(resolve => setTimeout(resolve, 1500))
    
    resetSuccess.value = true
    
  } catch (err) {
    if (err.response?.status === 400) {
      tokenError.value = true
    } else {
      errorMessage.value = 'An unexpected error occurred. Please try again.'
    }
  } finally {
    isSubmitting.value = false
  }
}

// Validate token on mount
onMounted(async () => {
  token.value = route.query.token || ''
  
  if (!token.value) {
    tokenError.value = true
    return
  }
  
  // TODO: Optionally validate token on page load
  // try {
  //   await authStore.validateResetToken(token.value)
  // } catch {
  //   tokenError.value = true
  // }
})
</script>

<style scoped>
/* ============================================
   AUTH PAGE STYLES - Dental Theme
   ============================================ */

.auth-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #f0fdfc 0%, #e0f7f6 50%, #f5f0ff 100%);
}

/* Background decoration */
.auth-bg {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}

.bg-pattern {
  position: absolute;
  inset: 0;
  background-image: 
    radial-gradient(circle at 20% 80%, rgba(52, 216, 209, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(43, 40, 153, 0.08) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(52, 216, 153, 0.06) 0%, transparent 40%);
}

.floating-tooth {
  position: absolute;
  font-size: 3rem;
  opacity: 0.08;
  animation: float 6s ease-in-out infinite;
  filter: grayscale(1);
}

.tooth-1 { top: 15%; left: 10%; animation-delay: 0s; }
.tooth-2 { top: 60%; right: 15%; animation-delay: 2s; font-size: 4rem; }
.tooth-3 { bottom: 20%; left: 20%; animation-delay: 4s; font-size: 2.5rem; }

@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

/* Main container */
.auth-container {
  display: flex;
  width: 100%;
  max-width: 1000px;
  margin: 1.5rem;
  background: white;
  border-radius: 24px;
  box-shadow: 
    0 25px 50px -12px rgba(0, 0, 0, 0.08),
    0 0 0 1px rgba(43, 40, 153, 0.05);
  overflow: hidden;
  position: relative;
  z-index: 1;
}

.auth-container.compact {
  max-width: 950px;
}

/* Branding Panel (Left) */
.branding-panel {
  flex: 0 0 45%;
  background: linear-gradient(145deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  padding: 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.branding-panel::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 200%;
  background: radial-gradient(circle, rgba(52, 216, 209, 0.15) 0%, transparent 60%);
  pointer-events: none;
}

.branding-content {
  position: relative;
  z-index: 1;
  color: white;
}

.brand-icon {
  width: 70px;
  height: 70px;
  /* background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); */
  background-color: white;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(52, 216, 209, 0.3);
}

.brand-title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.5rem;
  letter-spacing: -0.5px;
}

.brand-tagline {
  font-size: 1rem;
  opacity: 0.85;
  margin: 0 0 2.5rem;
  font-weight: 300;
}

.security-info {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.info-card {
  display: flex;
  gap: 1rem;
  padding: 1.25rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  backdrop-filter: blur(10px);
}

.info-card > i {
  font-size: 1.5rem;
  color: var(--color-primary);
  flex-shrink: 0;
  margin-top: 0.25rem;
}

.info-card h4 {
  font-size: 0.95rem;
  font-weight: 600;
  margin: 0 0 0.25rem;
}

.info-card p {
  font-size: 0.8rem;
  opacity: 0.8;
  margin: 0;
  line-height: 1.5;
}

/* Form Panel (Right) */
.form-panel {
  flex: 1;
  padding: 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  overflow-y: auto;
}

.form-content {
  max-width: 400px;
  margin: 0 auto;
  width: 100%;
}

.mobile-logo {
  display: none;
  margin-bottom: 2rem;
  text-align: center;
}

.mobile-logo img {
  max-height: 60px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--color-text-secondary);
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 2rem;
  transition: color 0.2s;
}

.back-link:hover {
  color: var(--color-secondary);
}

.back-link i {
  font-size: 0.75rem;
}

.form-header {
  margin-bottom: 2rem;
  text-align: center;
}

.header-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, var(--color-secondary-light) 0%, var(--color-secondary) 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 1.75rem;
  color: white;
  box-shadow: 0 10px 30px rgba(43, 40, 153, 0.25);
}

.form-header h2 {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 0.75rem;
}

.form-header p {
  color: var(--color-text-secondary);
  margin: 0;
  font-size: 0.9rem;
  line-height: 1.6;
}

/* Form styles */
.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--color-text-primary);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.form-group label i {
  color: var(--color-secondary);
  font-size: 0.8rem;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-wrapper input {
  width: 100%;
  padding: 0.875rem 1rem;
  padding-right: 3rem;
  font-size: 1rem;
  border: 2px solid var(--color-border);
  border-radius: 12px;
  background: var(--color-section-bg);
  color: var(--color-text-primary);
  transition: all 0.2s ease;
  font-family: inherit;
}

.input-wrapper input::placeholder {
  color: var(--color-text-muted);
}

.input-wrapper input:focus {
  outline: none;
  border-color: var(--color-secondary);
  background: white;
  box-shadow: 0 0 0 4px rgba(43, 40, 153, 0.1);
}

.input-wrapper.has-error input {
  border-color: #ef4444;
  background: #fef2f2;
}

.input-wrapper.has-error input:focus {
  box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

.input-wrapper.is-valid input {
  border-color: var(--color-available);
}

.toggle-password {
  position: absolute;
  right: 0.75rem;
  background: none;
  border: none;
  color: var(--color-text-muted);
  cursor: pointer;
  padding: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: color 0.2s;
}

.toggle-password:hover {
  color: var(--color-secondary);
}

/* Password strength */
.password-strength {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-top: 0.25rem;
}

.strength-bars {
  display: flex;
  gap: 4px;
}

.strength-bars .bar {
  width: 40px;
  height: 4px;
  background: var(--color-border);
  border-radius: 2px;
  transition: background 0.2s;
}

.strength-bars .bar.active:nth-child(1) { background: #ef4444; }
.strength-bars .bar.active:nth-child(2) { background: #f97316; }
.strength-bars .bar.active:nth-child(3) { background: #eab308; }
.strength-bars .bar.active:nth-child(4) { background: var(--color-available); }

.strength-text {
  font-size: 0.75rem;
  color: var(--color-text-muted);
  font-weight: 500;
}

/* Password requirements */
.password-requirements {
  background: var(--color-section-bg);
  padding: 1rem 1.25rem;
  border-radius: 12px;
  margin-top: -0.25rem;
}

.requirements-title {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--color-text-primary);
  margin: 0 0 0.75rem;
}

.password-requirements ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.5rem 1rem;
}

.password-requirements li {
  font-size: 0.8rem;
  color: var(--color-text-muted);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: color 0.2s;
}

.password-requirements li.met {
  color: var(--color-available);
}

.password-requirements li i {
  font-size: 0.7rem;
}

/* Error message */
.error-message {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.8rem;
  color: #ef4444;
  padding-left: 0.25rem;
}

.error-message i {
  font-size: 0.75rem;
}

/* Alerts */
.error-alert {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 1.25rem;
  background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
  border: 1px solid #fecaca;
  border-radius: 12px;
  color: #dc2626;
  font-size: 0.875rem;
}

.error-alert i:first-child {
  font-size: 1.1rem;
}

.close-alert {
  margin-left: auto;
  background: none;
  border: none;
  color: inherit;
  cursor: pointer;
  padding: 0.25rem;
  opacity: 0.7;
  transition: opacity 0.2s;
}

.close-alert:hover {
  opacity: 1;
}

/* Submit button */
.submit-btn {
  width: 100%;
  padding: 1rem 1.5rem;
  font-size: 1rem;
  font-weight: 600;
  font-family: inherit;
  color: white;
  background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  box-shadow: 0 4px 15px rgba(43, 40, 153, 0.3);
  margin-top: 0.5rem;
}

.submit-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(43, 40, 153, 0.4);
}

.submit-btn:active:not(:disabled) {
  transform: translateY(0);
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.submit-btn.is-loading {
  pointer-events: none;
}

.loading-spinner {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Error State */
.error-state {
  text-align: center;
  padding: 2rem 0;
}

.error-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 2rem;
  color: white;
}

.error-state h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 0.75rem;
}

.error-state > p {
  color: var(--color-text-secondary);
  margin: 0 0 2rem;
  font-size: 0.95rem;
  line-height: 1.6;
}

.request-new-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 1rem 1.5rem;
  background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  color: white;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  margin-bottom: 1rem;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(43, 40, 153, 0.3);
}

.request-new-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(43, 40, 153, 0.4);
}

.back-to-login-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  color: var(--color-text-secondary);
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
  transition: color 0.2s;
}

.back-to-login-link:hover {
  color: var(--color-secondary);
}

/* Success State */
.success-state {
  text-align: center;
  padding: 2rem 0;
}

.success-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--color-available) 0%, #22c55e 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 2.5rem;
  color: white;
  animation: pop 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

@keyframes pop {
  0% { transform: scale(0); }
  100% { transform: scale(1); }
}

.success-state h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 0.75rem;
}

.success-state > p {
  color: var(--color-text-secondary);
  margin: 0 0 2rem;
  font-size: 0.95rem;
  line-height: 1.6;
}

.login-btn-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 1rem 1.5rem;
  background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  color: white;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(43, 40, 153, 0.3);
}

.login-btn-link:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(43, 40, 153, 0.4);
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Responsive */
@media (max-width: 900px) {
  .branding-panel {
    display: none;
  }
  
  .mobile-logo {
    display: block;
  }
  
  .auth-container {
    max-width: 480px;
  }
}

@media (max-width: 480px) {
  .auth-container {
    margin: 1rem;
    border-radius: 20px;
  }
  
  .form-panel {
    padding: 2rem 1.5rem;
  }
  
  .form-header h2 {
    font-size: 1.35rem;
  }
  
  .password-requirements ul {
    grid-template-columns: 1fr;
  }
}
</style>

