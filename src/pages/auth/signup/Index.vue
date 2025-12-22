<template>
  <div v-if="!loading" class="auth-page">
    <!-- Decorative Background -->
    <div class="auth-bg">
      <div class="bg-pattern"></div>
      <div class="floating-tooth tooth-1">🦷</div>
      <div class="floating-tooth tooth-2">🦷</div>
      <div class="floating-tooth tooth-3">🦷</div>
    </div>

    <div class="auth-container">
      <!-- Left Panel - Branding -->
      <div class="branding-panel">
        <div class="branding-content">
          <div class="brand-icon">
            <!-- <i class="fas fa-tooth"></i> -->
            <img src="/logo/logo.svg" alt="logo" />
          </div>
          <h1 class="brand-title">NymoDental</h1>
          <p class="brand-tagline">Professional Dental Practice Management</p>
          
          <div class="features-list">
            <div class="feature-item">
              <i class="fas fa-calendar-check"></i>
              <span>Smart Appointment Scheduling</span>
            </div>
            <div class="feature-item">
              <i class="fas fa-users"></i>
              <span>Patient Records Management</span>
            </div>
            <div class="feature-item">
              <i class="fas fa-chart-line"></i>
              <span>Analytics & Reporting</span>
            </div>
            <div class="feature-item">
              <i class="fas fa-shield-alt"></i>
              <span>Secure & HIPAA Compliant</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Panel - Signup Form -->
      <div class="form-panel">
        <div class="form-content">
          <!-- Logo for mobile -->
          <div class="mobile-logo">
            <img src="/logo/logo.svg" alt="NymoDental" />
          </div>

          <div class="form-header">
            <h2>Create Account</h2>
            <p>Join NymoDental to manage your practice</p>
          </div>

          <form @submit.prevent="handleSignup" class="auth-form">
            <!-- Name Fields Row -->
            <div class="form-row">
              <!-- First Name -->
              <div class="form-group">
                <label for="firstName">
                  <i class="fas fa-user"></i>
                  First Name
                </label>
                <div class="input-wrapper" :class="{ 'has-error': v$.firstName.$error, 'is-valid': !v$.firstName.$invalid && firstName }">
                  <input
                    id="firstName"
                    type="text"
                    v-model="firstName"
                    @blur="v$.firstName.$touch()"
                    placeholder="John"
                    autocomplete="given-name"
                  />
                </div>
                <transition name="fade">
                  <div v-if="v$.firstName.$error" class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span v-if="v$.firstName.required.$invalid">First name is required</span>
                  </div>
                </transition>
              </div>

              <!-- Last Name -->
              <div class="form-group">
                <label for="lastName">
                  <i class="fas fa-user"></i>
                  Last Name
                </label>
                <div class="input-wrapper" :class="{ 'has-error': v$.lastName.$error, 'is-valid': !v$.lastName.$invalid && lastName }">
                  <input
                    id="lastName"
                    type="text"
                    v-model="lastName"
                    @blur="v$.lastName.$touch()"
                    placeholder="Doe"
                    autocomplete="family-name"
                  />
                </div>
                <transition name="fade">
                  <div v-if="v$.lastName.$error" class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span v-if="v$.lastName.required.$invalid">Last name is required</span>
                  </div>
                </transition>
              </div>
            </div>

            <!-- Email Field -->
            <div class="form-group">
              <label for="email">
                <i class="fas fa-envelope"></i>
                Email Address
              </label>
              <div class="input-wrapper" :class="{ 'has-error': v$.email.$error, 'is-valid': !v$.email.$invalid && email }">
                <input
                  id="email"
                  type="email"
                  v-model="email"
                  @blur="v$.email.$touch()"
                  placeholder="john.doe@example.com"
                  autocomplete="email"
                />
                <i v-if="!v$.email.$invalid && email" class="fas fa-check-circle valid-icon"></i>
              </div>
              <transition name="fade">
                <div v-if="v$.email.$error" class="error-message">
                  <i class="fas fa-exclamation-circle"></i>
                  <span v-if="v$.email.required.$invalid">Email is required</span>
                  <span v-else-if="v$.email.email.$invalid">Please enter a valid email address</span>
                </div>
              </transition>
            </div>

            <!-- Password Field -->
            <div class="form-group">
              <label for="password">
                <i class="fas fa-lock"></i>
                Password
              </label>
              <div class="input-wrapper" :class="{ 'has-error': v$.password.$error, 'is-valid': !v$.password.$invalid && password }">
                <input
                  id="password"
                  :type="showPassword ? 'text' : 'password'"
                  v-model="password"
                  @blur="v$.password.$touch()"
                  placeholder="Create a strong password"
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
                Confirm Password
              </label>
              <div class="input-wrapper" :class="{ 'has-error': v$.confirmPassword.$error, 'is-valid': !v$.confirmPassword.$invalid && confirmPassword }">
                <input
                  id="confirmPassword"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  v-model="confirmPassword"
                  @blur="v$.confirmPassword.$touch()"
                  placeholder="Confirm your password"
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

            <!-- Terms Agreement -->
            <div class="form-group terms-group">
              <label class="checkbox-label" :class="{ 'has-error': v$.agreeTerms.$error }">
                <input type="checkbox" v-model="agreeTerms" @change="v$.agreeTerms.$touch()" />
                <span class="checkmark"></span>
                <span class="terms-text">
                  I agree to the 
                  <router-link to="/terms">Terms of Service</router-link> 
                  and 
                  <router-link to="/privacy">Privacy Policy</router-link>
                </span>
              </label>
              <transition name="fade">
                <div v-if="v$.agreeTerms.$error" class="error-message">
                  <i class="fas fa-exclamation-circle"></i>
                  <span>You must agree to the terms</span>
                </div>
              </transition>
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

            <!-- Success Alert -->
            <transition name="slide-fade">
              <div v-if="successMessage" class="success-alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ successMessage }}</span>
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
                <i class="fas fa-user-plus"></i>
                Create Account
              </span>
              <span v-else class="loading-spinner">
                <i class="fas fa-circle-notch fa-spin"></i>
                Creating account...
              </span>
            </button>

            <!-- Login Link -->
            <div class="auth-switch">
              <p>Already have an account? <router-link to="/">Sign in</router-link></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Loader -->
  <div v-else class="loader-wrapper">
    <Loader />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useVuelidate } from '@vuelidate/core'
import { required, email as emailValidator, minLength, sameAs } from '@vuelidate/validators'
import Loader from '@/components/common/Loader.vue'

// Router
const router = useRouter()

// Form state
const firstName = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const agreeTerms = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const loading = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

// Custom validator for terms
const mustBeTrue = (value) => value === true

// Validation rules
const rules = computed(() => ({
  firstName: { required },
  lastName: { required },
  email: { required, email: emailValidator },
  password: { required, minLength: minLength(8) },
  confirmPassword: { required, sameAs: sameAs(password) },
  agreeTerms: { mustBeTrue }
}))

// Initialize vuelidate
const v$ = useVuelidate(rules, { firstName, lastName, email, password, confirmPassword, agreeTerms })

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
const handleSignup = async () => {
  const isFormValid = await v$.value.$validate()
  if (!isFormValid) return

  isSubmitting.value = true
  errorMessage.value = ''

  try {
    // TODO: Implement actual signup API call
    // const result = await authStore.signup({
    //   firstName: firstName.value,
    //   lastName: lastName.value,
    //   email: email.value,
    //   password: password.value
    // })
    
    // Simulating API call
    await new Promise(resolve => setTimeout(resolve, 1500))
    
    successMessage.value = 'Account created successfully! Redirecting to login...'
    
    setTimeout(() => {
      router.push('/')
    }, 2000)
    
  } catch (err) {
    errorMessage.value = 'An unexpected error occurred. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
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
  padding: 1rem 0;
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
  max-width: 1100px;
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

/* Branding Panel (Left) */
.branding-panel {
  flex: 0 0 42%;
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

.branding-panel::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 200px;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.1), transparent);
  pointer-events: none;
}

.branding-content {
  position: relative;
  z-index: 1;
  color: white;
}

.brand-icon {
  width: 80px;
  height: 80px;
  /* background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); */
  background-color: white;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(52, 216, 209, 0.3);
}

.brand-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin: 0 0 0.5rem;
  letter-spacing: -0.5px;
}

.brand-tagline {
  font-size: 1.1rem;
  opacity: 0.85;
  margin: 0 0 3rem;
  font-weight: 300;
}

.features-list {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.95rem;
  opacity: 0.9;
}

.feature-item i {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  flex-shrink: 0;
}

/* Form Panel (Right) */
.form-panel {
  flex: 1;
  padding: 2.5rem 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  overflow-y: auto;
  max-height: 100vh;
}

.form-content {
  max-width: 440px;
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

.form-header {
  margin-bottom: 2rem;
}

.form-header h2 {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 0.5rem;
}

.form-header p {
  color: var(--color-text-secondary);
  margin: 0;
  font-size: 0.95rem;
}

/* Form styles */
.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
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

.valid-icon {
  position: absolute;
  right: 1rem;
  color: var(--color-available);
  font-size: 1rem;
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

/* Terms checkbox */
.terms-group {
  margin-top: 0.5rem;
}

.checkbox-label {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  font-size: 0.875rem;
  color: var(--color-text-secondary);
  cursor: pointer;
  position: relative;
  padding-left: 2rem;
}

.checkbox-label input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.checkbox-label .checkmark {
  position: absolute;
  left: 0;
  top: 2px;
  width: 20px;
  height: 20px;
  border: 2px solid var(--color-border);
  border-radius: 6px;
  transition: all 0.2s;
}

.checkbox-label.has-error .checkmark {
  border-color: #ef4444;
}

.checkbox-label input:checked ~ .checkmark {
  background: var(--color-secondary);
  border-color: var(--color-secondary);
}

.checkbox-label input:checked ~ .checkmark::after {
  content: '';
  position: absolute;
  left: 6px;
  top: 2px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.terms-text a {
  color: var(--color-secondary);
  text-decoration: none;
  font-weight: 500;
}

.terms-text a:hover {
  text-decoration: underline;
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

.success-alert {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 1.25rem;
  background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
  border: 1px solid #bbf7d0;
  border-radius: 12px;
  color: #16a34a;
  font-size: 0.875rem;
}

.success-alert i:first-child {
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

/* Auth switch */
.auth-switch {
  text-align: center;
  margin-top: 1.5rem;
}

.auth-switch p {
  font-size: 0.9rem;
  color: var(--color-text-secondary);
  margin: 0;
}

.auth-switch a {
  color: var(--color-secondary);
  text-decoration: none;
  font-weight: 600;
}

.auth-switch a:hover {
  text-decoration: underline;
}

/* Loader wrapper */
.loader-wrapper {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f0fdfc 0%, #e0f7f6 50%, #f5f0ff 100%);
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
    max-width: 520px;
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
    font-size: 1.5rem;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>

