<template>
  <div class="error-page">
    <!-- Decorative Background -->
    <div class="error-bg">
      <div class="bg-pattern"></div>
      <div class="floating-tooth tooth-1">🦷</div>
      <div class="floating-tooth tooth-2">🦷</div>
      <div class="floating-tooth tooth-3">🦷</div>
    </div>

    <div class="error-container">
      <!-- Logo -->
      <div class="logo-wrapper">
        <img src="/logo/logo.svg" alt="NymoDental" />
      </div>

      <!-- Error Content -->
      <div class="error-content">
        <!-- Error Icon -->
        <div class="error-icon-wrapper">
          <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <div class="gears-animation">
            <i class="fas fa-cog gear gear-1"></i>
            <i class="fas fa-cog gear gear-2"></i>
          </div>
        </div>

        <h1 class="error-title">Something Went Wrong</h1>
        <p class="error-message">
          We're sorry, but something unexpected happened. Our team has been notified 
          and we're working to fix the issue. Please try again in a few moments.
        </p>

        <!-- Error Details (optional) -->
        <div v-if="errorDetails" class="error-details">
          <button @click="showDetails = !showDetails" class="details-toggle">
            <i :class="showDetails ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
            {{ showDetails ? 'Hide Details' : 'Show Details' }}
          </button>
          <transition name="slide">
            <div v-if="showDetails" class="details-content">
              <code>{{ errorDetails }}</code>
            </div>
          </transition>
        </div>

        <!-- Status Indicator -->
        <div class="status-indicator">
          <div class="status-dot"></div>
          <span>Our team is investigating the issue</span>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <button @click="retryAction" class="primary-btn">
            <i class="fas fa-redo"></i>
            Try Again
          </button>
          <router-link to="/dashboard" class="secondary-btn">
            <i class="fas fa-home"></i>
            Go to Dashboard
          </router-link>
        </div>

        <!-- Support Section -->
        <div class="support-section">
          <p>If the problem persists, please contact our support team</p>
          <div class="support-options">
            <a href="mailto:support@nymodental.com" class="support-link">
              <i class="fas fa-envelope"></i>
              Email Support
            </a>
            <span class="divider">|</span>
            <a href="#" class="support-link">
              <i class="fas fa-phone"></i>
              Call Us
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const showDetails = ref(false)
const errorDetails = ref('') // Can be populated with actual error info

const retryAction = () => {
  // Reload the page or retry the failed action
  window.location.reload()
}
</script>

<style scoped>
/* ============================================
   ERROR PAGE STYLES - Server Error
   ============================================ */

.error-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 30%, #f5f0ff 100%);
  padding: 2rem;
}

/* Background decoration */
.error-bg {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}

.bg-pattern {
  position: absolute;
  inset: 0;
  background-image: 
    radial-gradient(circle at 20% 80%, rgba(239, 68, 68, 0.08) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(43, 40, 153, 0.06) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(239, 68, 68, 0.04) 0%, transparent 40%);
}

.floating-tooth {
  position: absolute;
  font-size: 3rem;
  opacity: 0.06;
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

/* Container */
.error-container {
  text-align: center;
  max-width: 600px;
  width: 100%;
  position: relative;
  z-index: 1;
}

/* Logo */
.logo-wrapper {
  margin-bottom: 2.5rem;
}

.logo-wrapper img {
  max-height: 50px;
}

/* Error Content */
.error-content {
  background: white;
  padding: 3rem;
  border-radius: 24px;
  box-shadow: 
    0 25px 50px -12px rgba(0, 0, 0, 0.1),
    0 0 0 1px rgba(239, 68, 68, 0.1);
}

/* Error Icon */
.error-icon-wrapper {
  position: relative;
  display: inline-block;
  margin-bottom: 1.5rem;
}

.error-icon {
  width: 100px;
  height: 100px;
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.75rem;
  color: white;
  box-shadow: 0 15px 40px rgba(239, 68, 68, 0.35);
  animation: shake 0.5s ease-in-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px) rotate(-2deg); }
  75% { transform: translateX(5px) rotate(2deg); }
}

.gears-animation {
  position: absolute;
  top: -10px;
  right: -25px;
}

.gear {
  color: var(--color-text-muted);
  animation: spin 4s linear infinite;
}

.gear-1 {
  font-size: 1.5rem;
}

.gear-2 {
  font-size: 1rem;
  margin-left: -5px;
  animation-direction: reverse;
  animation-duration: 3s;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Title & Message */
.error-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 1rem;
}

.error-message {
  font-size: 1rem;
  color: var(--color-text-secondary);
  margin: 0 0 1.5rem;
  line-height: 1.7;
}

/* Error Details */
.error-details {
  margin-bottom: 1.5rem;
}

.details-toggle {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: none;
  border: none;
  color: var(--color-text-muted);
  font-size: 0.875rem;
  cursor: pointer;
  padding: 0.5rem;
  transition: color 0.2s;
}

.details-toggle:hover {
  color: var(--color-secondary);
}

.details-content {
  margin-top: 1rem;
  padding: 1rem;
  background: var(--color-section-bg);
  border-radius: 8px;
  text-align: left;
  overflow-x: auto;
}

.details-content code {
  font-family: 'Fira Code', 'Consolas', monospace;
  font-size: 0.8rem;
  color: #ef4444;
}

/* Status Indicator */
.status-indicator {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  border-radius: 50px;
  margin-bottom: 2rem;
}

.status-dot {
  width: 10px;
  height: 10px;
  background: #f59e0b;
  border-radius: 50%;
  animation: blink 1.5s ease-in-out infinite;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}

.status-indicator span {
  font-size: 0.85rem;
  font-weight: 500;
  color: #92400e;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.primary-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem 2rem;
  background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 600;
  font-family: inherit;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(43, 40, 153, 0.3);
}

.primary-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(43, 40, 153, 0.4);
}

.secondary-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem 2rem;
  background: var(--color-section-bg);
  color: var(--color-text-primary);
  border: 2px solid var(--color-border);
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 600;
  font-family: inherit;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.2s ease;
}

.secondary-btn:hover {
  background: var(--color-border);
  border-color: var(--color-text-muted);
}

/* Support Section */
.support-section {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--color-border);
}

.support-section > p {
  font-size: 0.875rem;
  color: var(--color-text-muted);
  margin: 0 0 1rem;
}

.support-options {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.support-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--color-secondary);
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 600;
  transition: color 0.2s;
}

.support-link:hover {
  color: var(--color-secondary-dark);
  text-decoration: underline;
}

.divider {
  color: var(--color-border);
}

/* Transitions */
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Responsive */
@media (max-width: 480px) {
  .error-page {
    padding: 1rem;
  }

  .error-content {
    padding: 2rem 1.5rem;
  }

  .error-icon {
    width: 80px;
    height: 80px;
    font-size: 2rem;
  }

  .error-title {
    font-size: 1.5rem;
  }

  .action-buttons {
    flex-direction: column;
  }

  .primary-btn,
  .secondary-btn {
    width: 100%;
  }

  .support-options {
    flex-direction: column;
    gap: 0.75rem;
  }

  .divider {
    display: none;
  }
}
</style>

