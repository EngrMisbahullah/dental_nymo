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
        <div class="error-code">
          <span class="digit">4</span>
          <div class="tooth-icon">
            <i class="fas fa-tooth"></i>
          </div>
          <span class="digit">4</span>
        </div>

        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">
          Oops! The page you're looking for seems to have gone missing. 
          It might have been moved, deleted, or perhaps it never existed.
        </p>

        <!-- Illustration -->
        <div class="illustration">
          <div class="search-icon">
            <i class="fas fa-search"></i>
          </div>
          <div class="document-icon">
            <i class="fas fa-file-alt"></i>
            <span class="question-mark">?</span>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <router-link to="/dashboard" class="primary-btn">
            <i class="fas fa-home"></i>
            Go to Dashboard
          </router-link>
          <button @click="goBack" class="secondary-btn">
            <i class="fas fa-arrow-left"></i>
            Go Back
          </button>
        </div>

        <!-- Help Section -->
        <div class="help-section">
          <p>Need assistance? <router-link to="/dashboard">Contact Support</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goBack = () => {
  if (window.history.length > 2) {
    router.back()
  } else {
    router.push('/dashboard')
  }
}
</script>

<style scoped>
/* ============================================
   ERROR PAGE STYLES - 404 Not Found
   ============================================ */

.error-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #f0fdfc 0%, #e0f7f6 50%, #f5f0ff 100%);
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
    0 25px 50px -12px rgba(0, 0, 0, 0.08),
    0 0 0 1px rgba(43, 40, 153, 0.05);
}

/* Error Code */
.error-code {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
}

.error-code .digit {
  font-size: 5rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1;
}

.tooth-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  color: white;
  box-shadow: 0 10px 30px rgba(52, 216, 209, 0.3);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
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
  margin: 0 0 2rem;
  line-height: 1.7;
}

/* Illustration */
.illustration {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1.5rem;
  margin-bottom: 2.5rem;
  padding: 1.5rem;
  background: var(--color-section-bg);
  border-radius: 16px;
}

.search-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
}

.document-icon {
  position: relative;
  width: 50px;
  height: 60px;
  background: white;
  border: 2px solid var(--color-border);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  color: var(--color-text-muted);
}

.question-mark {
  position: absolute;
  top: -8px;
  right: -8px;
  width: 24px;
  height: 24px;
  background: var(--color-shortage);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: 700;
  color: white;
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
  cursor: pointer;
  transition: all 0.2s ease;
}

.secondary-btn:hover {
  background: var(--color-border);
  border-color: var(--color-text-muted);
}

/* Help Section */
.help-section {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--color-border);
}

.help-section p {
  font-size: 0.9rem;
  color: var(--color-text-muted);
  margin: 0;
}

.help-section a {
  color: var(--color-secondary);
  text-decoration: none;
  font-weight: 600;
}

.help-section a:hover {
  text-decoration: underline;
}

/* Responsive */
@media (max-width: 480px) {
  .error-page {
    padding: 1rem;
  }

  .error-content {
    padding: 2rem 1.5rem;
  }

  .error-code .digit {
    font-size: 3.5rem;
  }

  .tooth-icon {
    width: 60px;
    height: 60px;
    font-size: 1.75rem;
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
}
</style>

