<template>
    <label class="nymo-checkbox">
        <input type="checkbox" v-model="rememberMe" />
        <span class="checkmark"></span>
        {{ label }}
    </label>
</template>
<script setup>
const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true
    },
    label: {
        type: String,
    }
})
const emit = defineEmits(['update:modelValue'])
const value = ref(props.modelValue)
watch(value, (newVal) => {
    emit('update:modelValue', newVal)
})
</script>
<style scoped>
.nymo-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--color-text-secondary);
    cursor: pointer;
    position: relative;
    padding-left: 1.75rem;
}

.nymo-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.nymo-checkbox input:checked~.checkmark {
    background: var(--color-secondary);
    border-color: var(--color-secondary);
}

.nymo-checkbox input:checked~.checkmark::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>