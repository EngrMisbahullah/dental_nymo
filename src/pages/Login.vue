<template>  
  <div v-if="!loading" class="flex flex-row justify-center mx-auto">
    <div class="mt-12 max-w-[1440px] p-8 flex-1 flex flex-row justify-center items-center lg:flex-col">
      <div class="w-2/5 lg:w-full">
        <!-- Logo -->
        <div class="mb-20 flex items-center justify-center">
          <img src="/logo/logo.svg" alt="logo" />
        </div>

        <!-- Login Form -->
        <div class="flex flex-col gap-3">
          <!-- Email Field -->
          <div class="relative flex items-center border-2 border-secondary border-l-[7px] rounded-md px-2.5 py-1.5 transition-all duration-300">
            <input
              type="email"
              v-model="email"
              required
              @focus="focusInput('email')"
              @blur="blurInput('email')"
              class="w-full relative z-[1] border-none bg-transparent outline-none text-base py-2 my-0.5 autofill:bg-transparent autofill:shadow-[0_0_0px_1000px_transparent_inset]"
            />
            <label 
              :class="[
                'absolute left-3 top-1/2 -translate-y-1/2 text-base font-medium text-gray-500 bg-white px-1.5 transition-all duration-300',
                { '!top-1 !text-sm !text-secondary': email || focused.email }
              ]"
            >Email</label>
          </div>

          <!-- Password Field -->
          <div class="relative flex items-center border-2 border-secondary border-l-[7px] rounded-md px-2.5 py-1.5 transition-all duration-300">
            <input
              :type="showPassword ? 'text' : 'password'"
              v-model="password"
              required
              @focus="focusInput('password')"
              @blur="blurInput('password')"
              class="w-full relative z-[1] border-none bg-transparent outline-none text-base py-2 my-0.5"
            />
            <label 
              :class="[
                'absolute left-3 top-1/2 -translate-y-1/2 text-base font-medium text-gray-500 bg-white px-1.5 transition-all duration-300',
                { '!top-1 !text-sm !text-secondary': password || focused.password }
              ]"
            >Password</label>
            <i
              :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"
              class="absolute right-2.5 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500"
              @click="togglePassword"
            ></i>
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="bg-red-100 border border-red-500 rounded-md px-4 py-2.5 mt-4">
          <p class="text-red-600 m-0 text-sm">{{ errorMessage }}</p>
        </div>

        <!-- Forgot Password -->
        <div class="text-right">
          <p class="text-gray-400 my-5 text-[15px]">
            Forgot password? click <router-link to="#" class="text-secondary hover:underline">here</router-link> to reset your password
          </p>
        </div>

        <!-- Login Buttons -->
        <div class="mt-10 flex flex-row items-center justify-center sm:flex-col">
          <button 
            @click="login" 
            :disabled="isLoginDisabled"
            class="border-none rounded-lg bg-secondary py-2.5 px-10 text-base border border-secondary text-white hover:bg-secondary-dark disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            Log in
          </button>
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
