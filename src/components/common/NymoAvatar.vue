<template>
    <div
        class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg" :class="[{'bg-gradient-to-br from-teal-400 to-cyan-500 shadow-teal-500/20': !src}]">
        <span v-if="label && !src">{{ label }}</span>
        <img v-if="src && !label" :src="src" alt="avatar" class="w-full h-full object-cover"/>
        <i class="fas fa-user" v-if="(!src && !label) || (src && label)"></i>
    </div>
</template>
<script setup>
const props = defineProps({
    avatar: {
        type: String,
        required: true
    },
    label: {
        type: String,
    },
    src: {
        type: String,
    },
})
const emit = defineEmits(['update:modelValue'])
const value = ref(props.modelValue)
watch(value, (newVal) => {
    emit('update:modelValue', newVal)
})
</script>