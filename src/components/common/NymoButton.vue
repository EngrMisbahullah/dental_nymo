<template>
    <button
        class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white rounded-xl cursor-pointer transition-all duration-200 shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30" :class="[severities[severity], sizes[size], variants[variant], {'opacity-50 cursor-not-allowed': disabled || loading}, direction === 'ltr' ? 'flex-row' : 'flex-row-reverse']"
        :type="type" :disabled="disabled || loading">
        <i v-if="!loading" :class="icon"></i>
        <span v-if="!loading" class="">{{ label }}</span>
        <span v-if="loading" :class="loadingStateIcon"></span>
        <span v-if="loading" class="loading-spinner">
            <i :class="loadingStateIcon"></i>
            <span>{{ loadingStateLabel }}</span>
        </span>
    </button>
</template>
<script setup>
const props = defineProps({
    type: {
        type: String,
        default: 'button'
    },
    icon: {
        type: String,
        default: ''
    },
    label: {
        type: String,
        default: ''
    },
    severity: {
        type: String,
        default: 'primary'
    },
    size: {
        type: String,
        default: 'medium'
    },
    variant: {
        type: String,
        default: 'solid'
    },
    direction: {
        type: String,
        default: 'ltr'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    loading: {
        type: Boolean,
        default: false
    },
    loadingStateIcon: {
        type: String,
        default: 'fas fa-spinner fa-spin'
    },
    loadingStateLabel: {
        type: String,
        default: 'Loading...'
    },
});
const emit = defineEmits(['click'])
    
const severities = {
    primary: 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600',
    secondary: 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600',
    danger: 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700',
    warning: 'bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700',
    info: 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700',
    success: 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700',
}
const sizes = {
    small: 'text-xs',
    medium: 'text-sm',
    large: 'text-lg',
}
const variants = {
    solid: 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600',
    outline: 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600',
    ghost: 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600',
    link: 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600',
}
</script>