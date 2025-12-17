<template>
  <div v-if="!loading" class="main-login">
    <div class="pulse-login-row">
      <div class="pulse-login-column1">
        <div class="login-logo">
          <img src="/logo/logo.svg" alt="logo" />
        </div>

        <div class="login-container">
          <div class="login-field">
            <input
              type="email"
              v-model="email"
              required
              @focus="focusInput('email')"
              @blur="blurInput('email')"
            />
            <label :class="{ active: email || focused.email }" class="floating-label"
              >Email</label
            >
          </div>

          <div class="login-field">
            <input
              :type="showPassword ? 'text' : 'password'"
              v-model="password"
              required
              @focus="focusInput('password')"
              @blur="blurInput('password')"
            />
            <label
              :class="{ active: password || focused.password }"
              class="floating-label"
              >Password</label
            >
            <i
              :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"
              class="eye-icon"
              @click="togglePassword"
            ></i>
          </div>
        </div>

        <div v-if="errorMessage" class="error-message">
          <p>{{ errorMessage }}</p>
        </div>

        <div class="forgot-link-pass">
          <p>
            Forgot password? click <router-link to="#">here</router-link> to reset your
            password
          </p>
        </div>

        <div class="login-btns">
          <button class="login-btn1" @click="login" :disabled="isLoginDisabled">
            Log in
          </button>
          <!-- <router-link to="/signup">
            <button class="login-btn2 ml-13">Sign up</button>
          </router-link> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Show loader while logging in -->
  <div v-else>
    <Loader />
  </div>
</template>

<script>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";
import Loader from "../components/Loader.vue";

export default {
  components: { Loader },
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();

    const loading = ref(false);
    const email = ref("");
    const password = ref("");
    const showPassword = ref(false);
    const errorMessage = ref("");
    const focused = ref({
      email: false,
      password: false,
    });

    const login = async () => {
      loading.value = true;
      errorMessage.value = "";

      try {
        const result = await authStore.login(email.value, password.value);

        if (result.success) {
          router.push("/dashboard");
        } else {
          errorMessage.value = result.error;
          loading.value = false;
        }
      } catch (err) {
        errorMessage.value = "An unexpected error occurred. Please try again.";
        loading.value = false;
      }
    };

    const togglePassword = () => {
      showPassword.value = !showPassword.value;
    };

    const focusInput = (field) => {
      focused.value[field] = true;
    };

    const blurInput = (field) => {
      if (!email.value && field === "email") focused.value.email = false;
      if (!password.value && field === "password") focused.value.password = false;
    };

    const isLoginDisabled = computed(() => {
      return !email.value || !password.value || loading.value;
    });

    return {
      loading,
      email,
      password,
      showPassword,
      focused,
      errorMessage,
      login,
      togglePassword,
      focusInput,
      blurInput,
      isLoginDisabled,
    };
  },
};
</script>
<style scoped>
.main-login {
  display: flex;
  flex-direction: row;
  justify-content: center;
  margin-left: auto;
  margin-right: auto;
}

.pulse-login-row {
  margin-top: 50px;
  max-width: 1440px;
  padding: 30px;
  flex: 1;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.pulse-login-column1 {
  width: 40%;
}

@media (max-width: 1000px) {
  .pulse-login-row {
    flex-direction: column;
  }

  .pulse-login-column1 {
    width: 100%;
  }
}

.login-logo {
  margin-bottom: 75px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-container {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.login-field {
  position: relative;
  display: flex;
  align-items: center;
  border: 2px solid #2b2899;
  padding: 7px 10px;
  border-left: 7px solid #2b2899;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.login-field input {
  width: 100%;
  position: relative;
  z-index: 1;
  border: none;
  background-color: transparent !important;
  outline: none;
  font-size: 16px;
  padding: 8px 0;
  margin: 2px 0;
}

.login-field input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
  box-shadow: 0 0 0px 1000px transparent inset !important;
  -webkit-text-fill-color: #000 !important;
  transition: background-color 9999s ease-in-out 0s;
}

.floating-label {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 16px;
  font-weight: 500;
  color: #666;
  background: white;
  padding: 0 5px;
  transition: all 0.3s ease;
}

.floating-label.active {
  top: 5px;
  font-size: 14px;
  color: #2b2899;
}

.eye-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #666;
}

.forgot-link-pass {
  text-align: right;
}

.forgot-link-pass p {
  color: rgb(155, 155, 155);
  margin-top: 20px;
  margin-bottom: 20px;
  font-size: 15px;
}

.login-btns {
  margin-top: 40px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
}

.login-btn1 {
  border: none;
  border-radius: 7px;
  background-color: #2b2899;
  padding: 10px 40px;
  font-size: 16px;
  border: 1px solid #2b2899;
  color: white;
}

.login-btn2 {
  border: 1px solid #2b2899;
  border-radius: 7px;
  background-color: white;
  padding: 10px 40px;
  font-size: 16px;
  color: #2b2899;
}

@media (max-width: 350px) {
  .login-btns {
    flex-direction: column;
  }

  .login-btn2 {
    width: 100%;
    margin-left: 0px !important;
    margin-top: 10px;
  }
}

.error-message {
  background-color: #fee2e2;
  border: 1px solid #ef4444;
  border-radius: 6px;
  padding: 10px 15px;
  margin-top: 15px;
}

.error-message p {
  color: #dc2626;
  margin: 0;
  font-size: 14px;
}
</style>
