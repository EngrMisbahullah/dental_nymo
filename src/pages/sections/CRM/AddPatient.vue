<template>
  <div class="page-container">
    <h2 class="page-title">Add Patient</h2>
    <p class="page-subtitle">Add a new patient to your clinic's records.</p>

    <form @submit.prevent="submitForm">
      <div class="form-row">
        <div class="form-group">
          <label>First Name</label>
          <input v-model="form.firstName" type="text" required />
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input v-model="form.lastName" type="text" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Email</label>
          <input v-model="form.email" type="email" required />
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input v-model="form.phone" type="text" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Date of Birth</label>
          <input v-model="form.dob" type="date" />
        </div>
        <div class="form-group">
          <label>Gender</label>
          <select v-model="form.gender">
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Skin Type</label>
        <input v-model="form.skinType" placeholder="e.g., Oily, Dry, Combination" />
      </div>

      <div class="form-group">
        <label>Concerns</label>
        <textarea
          v-model="form.concerns"
          placeholder="e.g., Acne, Scars, Fine lines"
        ></textarea>
      </div>

      <div class="form-group">
        <label>Profile Photo</label>
        <div class="file-upload-box" @click="triggerFileInput">
          <i class="fas fa-cloud-upload-alt upload-icon"></i>
          <p><a href="#">Upload a file</a> or drag and drop</p>
          <p class="hint">PNG, JPG, GIF up to 10MB</p>
          <input
            ref="fileInput"
            type="file"
            accept="image/*"
            @change="handleFileUpload"
            style="display: none"
          />
        </div>
      </div>

      <div class="form-footer">
        <button type="button" class="cancel-btn" @click="goBack">Cancel</button>
        <button type="submit" class="save-btn">Save Patient</button>
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

<style scoped>
.page-container {
  max-width: 700px;
  margin: 40px auto;
  padding: 32px;
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.page-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 4px;
}

.page-subtitle {
  color: #6b7280;
  font-size: 14px;
  margin-bottom: 24px;
}

.form-row {
  display: flex;
  gap: 20px;
}

.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.form-group label {
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 6px;
}

input,
select,
textarea {
  padding: 10px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
}

textarea {
  resize: vertical;
  min-height: 80px;
}

.file-upload-box {
  border: 2px dashed #d1d5db;
  text-align: center;
  padding: 32px;
  border-radius: 10px;
  color: #6b7280;
  cursor: pointer;
}

.file-upload-box a {
  color: #4f46e5;
  text-decoration: underline;
}

.file-upload-box .upload-icon {
  font-size: 28px;
  margin-bottom: 12px;
  color: #9ca3af;
}

.hint {
  font-size: 12px;
  color: #9ca3af;
}

.form-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

.cancel-btn {
  background: #f3f4f6;
  color: #111827;
  padding: 10px 18px;
  border-radius: 6px;
  border: 1px solid #d1d5db;
  cursor: pointer;
}

.save-btn {
  background: #4f46e5;
  color: white;
  padding: 10px 18px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3);
}
</style>
