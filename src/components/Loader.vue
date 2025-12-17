<template>
  <div id="loader">
    <div id="shadow1"></div>
    <div id="shadow2"></div>
    <div id="shadow3"></div>
    <div id="box1"></div>
    <div id="box2"></div>
    <div id="box3"></div>
  </div>
</template>
<script>
export default {
  name: "Loader",
};
</script>

<style scoped>
#loader {
  margin-left: -75px;
  position: absolute;
  top: calc(50% - 20px);
  left: calc(50% - 20px);
}

#box1,
#box2,
#box3 {
  width: 50px;
  height: 50px;
  background: #2b2899;
  animation: animate 0.5s linear infinite;
  position: absolute;
  top: 0;
  border-radius: 3px;
}

#box1 {
  left: 0;
}

#box2 {
  left: 73px;
}

#box3 {
  left: 142px;
}

@keyframes animate {
  17% {
    border-bottom-right-radius: 3px;
  }
  25% {
    transform: translateY(9px) rotate(22.5deg);
  }
  50% {
    transform: translateY(18px) scale(1, 0.9) rotate(45deg);
    border-bottom-right-radius: 40px;
  }
  75% {
    transform: translateY(9px) rotate(67.5deg);
  }
  100% {
    transform: translateY(0) rotate(90deg);
  }
}

#shadow1,
#shadow2,
#shadow3 {
  width: 50px;
  height: 5px;
  background: #000;
  opacity: 0.1;
  position: absolute;
  top: 59px;
  border-radius: 50%;
  animation: shadow 0.5s linear infinite;
}

#shadow1 {
  left: 0;
}

#shadow2 {
  left: 73px;
}

#shadow3 {
  left: 142px;
}

@keyframes shadow {
  50% {
    transform: scale(1.2, 1);
  }
}
</style>
