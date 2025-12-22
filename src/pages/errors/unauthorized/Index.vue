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
        <!-- Lock Icon Animation -->
        <div class="lock-wrapper">
          <div class="lock-icon">
            <i class="fas fa-lock"></i>
          </div>
          <div class="shield-bg">
            <i class="fas fa-shield-alt"></i>
          </div>
        </div>

        <h1 class="error-title">Access Denied</h1>
        <p class="error-message">
          You don't have permission to access this page. This might be because your session 
          has expired or you're trying to access a restricted area.
        </p>

        <!-- Info Cards -->
        <div class="info-cards">
          <div class="info-card">
            <i class="fas fa-clock"></i>
            <div>
              <h4>Session Expired?</h4>
              <p>Try logging in again to refresh your session.</p>
            </div>
          </div>
          <div class="info-card">
            <i class="fas fa-user-shield"></i>
            <div>
              <h4>Need Access?</h4>
              <p>Contact your administrator to request permissions.</p>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <router-link to="/" class="primary-btn">
            <i class="fas fa-sign-in-alt"></i>
            Log In
          </router-link>
          <button @click="goBack" class="secondary-btn">
            <i class="fas fa-arrow-left"></i>
            Go Back
          </button>
        </div>

        <!-- Contact Admin -->
        <div class="contact-section">
          <p>Think this is a mistake?</p>
          <a href="mailto:admin@nymodental.com" class="contact-link">
            <i class="fas fa-envelope"></i>
            Contact Administrator
          </a>
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
    router.push('/')
  }
}
</script>

<style scoped>
/* ============================================
   ERROR PAGE STYLES - Unauthorized
   ============================================ */

.error-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 30%, #f5f0ff 100%);
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
    radial-gradient(circle at 20% 80%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(43, 40, 153, 0.08) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.06) 0%, transparent 40%);
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
    0 0 0 1px rgba(245, 158, 11, 0.15);
}

/* Lock Icon */
.lock-wrapper {
  position: relative;
  display: inline-block;
  margin-bottom: 1.5rem;
}

.lock-icon {
  width: 90px;
  height: 90px;
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  color: white;
  box-shadow: 0 15px 40px rgba(245, 158, 11, 0.35);
  position: relative;
  z-index: 2;
  animation: lockBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

@keyframes lockBounce {
  0% { transform: scale(0); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

.shield-bg {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 8rem;
  color: rgba(245, 158, 11, 0.08);
  z-index: 1;
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

/* Info Cards */
.info-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-bottom: 2rem;
}

.info-card {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1.25rem;
  background: var(--color-section-bg);
  border-radius: 12px;
  text-align: left;
}

.info-card > i {
  font-size: 1.25rem;
  color: var(--color-secondary);
  margin-top: 0.25rem;
  flex-shrink: 0;
}

.info-card h4 {
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--color-text-primary);
  margin: 0 0 0.25rem;
}

.info-card p {
  font-size: 0.8rem;
  color: var(--color-text-muted);
  margin: 0;
  line-height: 1.5;
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

/* Contact Section */
.contact-section {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--color-border);
}

.contact-section > p {
  font-size: 0.875rem;
  color: var(--color-text-muted);
  margin: 0 0 0.75rem;
}

.contact-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--color-secondary);
  text-decoration: none;
  font-size: 0.95rem;
  font-weight: 600;
  transition: color 0.2s;
}

.contact-link:hover {
  color: var(--color-secondary-dark);
  text-decoration: underline;
}

/* Responsive */
@media (max-width: 600px) {
  .info-cards {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .error-page {
    padding: 1rem;
  }

  .error-content {
    padding: 2rem 1.5rem;
  }

  .lock-icon {
    width: 70px;
    height: 70px;
    font-size: 1.75rem;
  }

  .shield-bg {
    font-size: 6rem;
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

