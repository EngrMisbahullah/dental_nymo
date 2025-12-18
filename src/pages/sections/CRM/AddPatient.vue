<template>
  <div class="max-w-[700px] mx-auto my-10 p-8 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-1">Add Patient</h2>
    <p class="text-gray-500 text-sm mb-6">Add a new patient to your clinic's records.</p>

    <form @submit.prevent="submitForm">
      <div class="flex flex-col sm:flex-row gap-5 mb-4">
        <div class="flex-1 flex flex-col">
          <label class="text-sm font-medium mb-1.5">First Name</label>
          <input v-model="form.firstName" type="text" required class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20" />
        </div>
        <div class="flex-1 flex flex-col">
          <label class="text-sm font-medium mb-1.5">Last Name</label>
          <input v-model="form.lastName" type="text" required class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20" />
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-5 mb-4">
        <div class="flex-1 flex flex-col">
          <label class="text-sm font-medium mb-1.5">Email</label>
          <input v-model="form.email" type="email" required class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20" />
        </div>
        <div class="flex-1 flex flex-col">
          <label class="text-sm font-medium mb-1.5">Phone</label>
          <input v-model="form.phone" type="text" class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20" />
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-5 mb-4">
        <div class="flex-1 flex flex-col">
          <label class="text-sm font-medium mb-1.5">Date of Birth</label>
          <input v-model="form.dob" type="date" class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20" />
        </div>
        <div class="flex-1 flex flex-col">
          <label class="text-sm font-medium mb-1.5">Gender</label>
          <select v-model="form.gender" class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20">
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select>
        </div>
      </div>

      <div class="flex flex-col mb-4">
        <label class="text-sm font-medium mb-1.5">Skin Type</label>
        <input v-model="form.skinType" placeholder="e.g., Oily, Dry, Combination" class="p-2.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20" />
      </div>

      <div class="flex flex-col mb-4">
        <label class="text-sm font-medium mb-1.5">Concerns</label>
        <textarea
          v-model="form.concerns"
          placeholder="e.g., Acne, Scars, Fine lines"
          class="p-2.5 border border-gray-300 rounded-md text-sm resize-y min-h-[80px] focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20"
        ></textarea>
      </div>

      <div class="flex flex-col mb-4">
        <label class="text-sm font-medium mb-1.5">Profile Photo</label>
        <div class="border-2 border-dashed border-gray-300 text-center py-8 px-4 rounded-xl text-gray-500 cursor-pointer hover:border-gray-400 transition-colors" @click="triggerFileInput">
          <i class="fas fa-cloud-upload-alt text-3xl mb-3 text-gray-400"></i>
          <p class="m-0"><a href="#" class="text-indigo-600 underline font-semibold">Upload a file</a> or drag and drop</p>
          <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
          <input
            ref="fileInput"
            type="file"
            accept="image/*"
            @change="handleFileUpload"
            class="hidden"
          />
        </div>
      </div>

      <div class="flex justify-end gap-2.5 mt-5">
        <button type="button" class="bg-gray-100 text-gray-900 py-2.5 px-4 rounded-md border border-gray-300 cursor-pointer hover:bg-gray-200 transition-colors" @click="goBack">Cancel</button>
        <button type="submit" class="bg-indigo-600 text-white py-2.5 px-4 rounded-md border-none cursor-pointer shadow-md hover:bg-indigo-700 transition-colors">Save Patient</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const fileInput = ref(null);

const form = ref({
  firstName: "",
  lastName: "",
  email: "",
  phone: "",
  dob: "",
  gender: "Male",
  skinType: "",
  concerns: "",
  profilePhoto: null,
});

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.value.profilePhoto = file;
  }
};

const submitForm = () => {
  const newPatient = {
    name: `${form.value.firstName} ${form.value.lastName}`,
    email: form.value.email,
    phone: form.value.phone,
    skinType: form.value.skinType,
    concerns: form.value.concerns,
    avatar: "https://randomuser.me/api/portraits/men/70.jpg", // placeholder
  };

  console.log("New Patient Submitted:", newPatient);

  // Redirect back to CRM page
  router.push("/dashboard/crm");
};

const goBack = () => {
  router.back();
};
</script>
