<template>
  <div class="top-bar">
    <div>
      <div class="title">{{ title }}</div>
      <div class="subtitle">{{ subtitle }}</div>
    </div>
    <div class="user">
      <div>
        <div class="user-name">Dr Joseph Smith</div>
        <div class="user-role">Super Admin</div>
      </div>
      <img src="https://randomuser.me/api/portraits/men/75.jpg" />
    </div>
  </div>
</template>

<script>
export default {
  name: "TopBar",
  props: {
    title: String,
    subtitle: String,
  },
};
</script>

<style scoped>
.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.title {
  font: 600 28px Poppins;
  color: #303030;
}
.subtitle {
  font: bold 16px Poppins;
  color: #34d8d1;
}
.user {
  display: flex;
  align-items: center;
  gap: 12px;
}
.user img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}
</style>
