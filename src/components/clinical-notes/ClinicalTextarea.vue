<template>
  <div class="clinical-textarea group">
    <!-- Header with Label and Tools -->
    <div class="flex items-center justify-between mb-2">
      <label :for="id" class="flex items-center gap-2 text-sm font-semibold text-slate-700">
        <span 
          class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm"
          :class="colorClasses.badge"
        >
          {{ letter }}
        </span>
        {{ label }}
      </label>
      
      <!-- Quick Actions -->
      <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
        <button 
          type="button"
          @click="toggleMacros"
          class="p-1.5 rounded-md text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-all"
          title="Insert Macro"
        >
          <i class="fas fa-bolt text-xs"></i>
        </button>
        <button 
          type="button"
          @click="toggleTemplates"
          class="p-1.5 rounded-md text-slate-400 hover:text-violet-600 hover:bg-violet-50 transition-all"
          title="Procedure Templates"
        >
          <i class="fas fa-file-medical text-xs"></i>
        </button>
      </div>
    </div>

    <!-- Textarea Container -->
    <div class="relative">
      <textarea
        :id="id"
        v-model="content"
        :placeholder="placeholder"
        :class="[
          'w-full px-4 py-3 pr-12 border rounded-xl resize-y min-h-[120px] text-sm text-slate-700 placeholder-slate-400 transition-all duration-200',
          'focus:outline-none focus:ring-2 focus:border-transparent',
          isFocused ? colorClasses.focusRing : 'border-slate-200 bg-slate-50/50',
          isRecording ? 'border-red-400 bg-red-50/30' : ''
        ]"
        @focus="isFocused = true"
        @blur="isFocused = false"
      ></textarea>

      <!-- Voice Dictation Button -->
      <button
        type="button"
        @click="toggleRecording"
        :class="[
          'absolute right-3 top-3 w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200',
          isRecording 
            ? 'bg-red-500 text-white animate-pulse shadow-lg shadow-red-500/30' 
            : 'bg-slate-100 text-slate-400 hover:bg-teal-500 hover:text-white hover:shadow-md'
        ]"
        :title="isRecording ? 'Stop Recording' : 'Voice Dictation'"
      >
        <i :class="isRecording ? 'fas fa-stop' : 'fas fa-microphone'" class="text-sm"></i>
      </button>

      <!-- Recording Indicator -->
      <div v-if="isRecording" class="absolute left-4 bottom-3 flex items-center gap-2 text-red-500 text-xs font-medium">
        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
        Recording...
      </div>
    </div>

    <!-- Toolbar -->
    <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-100">
      <!-- Left Tools -->
      <div class="flex items-center gap-1">
        <!-- AI Assist Button -->
        <button
          type="button"
          @click="$emit('ai-assist', id)"
          class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-gradient-to-r from-violet-500 to-purple-500 text-white hover:from-violet-600 hover:to-purple-600 transition-all shadow-sm hover:shadow-md"
        >
          <i class="fas fa-magic"></i>
          <span class="hidden sm:inline">AI Draft</span>
        </button>

        <!-- Format Buttons -->
        <div class="hidden sm:flex items-center gap-0.5 ml-2 pl-2 border-l border-slate-200">
          <button type="button" class="p-1.5 rounded text-slate-400 hover:text-slate-600 hover:bg-slate-100" title="Bold">
            <i class="fas fa-bold text-xs"></i>
          </button>
          <button type="button" class="p-1.5 rounded text-slate-400 hover:text-slate-600 hover:bg-slate-100" title="Bullet List">
            <i class="fas fa-list-ul text-xs"></i>
          </button>
          <button type="button" class="p-1.5 rounded text-slate-400 hover:text-slate-600 hover:bg-slate-100" title="ICD Code">
            <i class="fas fa-code text-xs"></i>
          </button>
        </div>
      </div>

      <!-- Character Count -->
      <span class="text-xs text-slate-400">
        {{ content.length }} chars
      </span>
    </div>

    <!-- Macros Dropdown -->
    <transition name="dropdown">
      <div v-if="showMacros" class="mt-2 p-2 bg-white border border-slate-200 rounded-xl shadow-lg">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-2 py-1 mb-1">
          Quick Macros
        </div>
        <button
          v-for="macro in macros"
          :key="macro.id"
          type="button"
          @click="insertMacro(macro)"
          class="w-full text-left px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-teal-50 hover:text-teal-700 transition-colors flex items-center gap-2"
        >
          <i class="fas fa-bolt text-amber-500 text-xs"></i>
          <span class="font-medium">{{ macro.name }}</span>
          <span class="ml-auto text-xs text-slate-400">{{ macro.shortcut }}</span>
        </button>
      </div>
    </transition>

    <!-- Templates Dropdown -->
    <transition name="dropdown">
      <div v-if="showTemplates" class="mt-2 p-2 bg-white border border-slate-200 rounded-xl shadow-lg max-h-48 overflow-y-auto">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-2 py-1 mb-1">
          Procedure Templates
        </div>
        <button
          v-for="template in templates"
          :key="template.id"
          type="button"
          @click="insertTemplate(template)"
          class="w-full text-left px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-violet-50 hover:text-violet-700 transition-colors"
        >
          <div class="flex items-center gap-2">
            <i class="fas fa-file-medical text-violet-500 text-xs"></i>
            <span class="font-medium">{{ template.name }}</span>
          </div>
          <p class="text-xs text-slate-400 mt-0.5 ml-5 truncate">{{ template.preview }}</p>
        </button>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  label: { type: String, required: true },
  letter: { type: String, required: true },
  placeholder: { type: String, default: '' },
  color: { type: String, default: 'teal' },
  modelValue: { type: String, default: '' }
})

const emit = defineEmits(['update:modelValue', 'ai-assist'])

// State
const content = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val)
})
const isFocused = ref(false)
const isRecording = ref(false)
const showMacros = ref(false)
const showTemplates = ref(false)

// Color classes based on prop
const colorClasses = computed(() => {
  const colors = {
    teal: {
      badge: 'bg-gradient-to-br from-teal-400 to-teal-600',
      focusRing: 'ring-teal-500/20 border-teal-400 bg-white'
    },
    cyan: {
      badge: 'bg-gradient-to-br from-cyan-400 to-cyan-600',
      focusRing: 'ring-cyan-500/20 border-cyan-400 bg-white'
    },
    violet: {
      badge: 'bg-gradient-to-br from-violet-400 to-violet-600',
      focusRing: 'ring-violet-500/20 border-violet-400 bg-white'
    },
    amber: {
      badge: 'bg-gradient-to-br from-amber-400 to-amber-600',
      focusRing: 'ring-amber-500/20 border-amber-400 bg-white'
    }
  }
  return colors[props.color] || colors.teal
})

// Sample macros
const macros = [
  { id: 1, name: 'No abnormalities detected', shortcut: '/nad', text: 'No abnormalities detected on examination.' },
  { id: 2, name: 'Patient informed', shortcut: '/inf', text: 'Patient informed of findings and treatment options. Questions answered.' },
  { id: 3, name: 'Follow-up scheduled', shortcut: '/fu', text: 'Follow-up appointment scheduled in 2 weeks.' },
  { id: 4, name: 'Consent obtained', shortcut: '/con', text: 'Informed consent obtained. Risks and benefits discussed.' }
]

// Sample templates
const templates = [
  { id: 1, name: 'Root Canal', preview: 'Pulp extirpation, canal debridement...', text: 'Procedure: Root Canal Therapy\n- Local anesthesia administered\n- Rubber dam isolation\n- Access cavity preparation\n- Pulp extirpation\n- Working length determination\n- Canal debridement and shaping\n- Irrigation with NaOCl\n- Calcium hydroxide dressing placed\n- Temporary restoration' },
  { id: 2, name: 'Extraction', preview: 'Tooth extraction with local anesthesia...', text: 'Procedure: Tooth Extraction\n- Local anesthesia administered\n- Luxation with elevator\n- Forceps extraction\n- Socket inspection\n- Hemostasis achieved\n- Post-op instructions provided' },
  { id: 3, name: 'Filling', preview: 'Composite restoration procedure...', text: 'Procedure: Composite Restoration\n- Local anesthesia administered\n- Caries excavation\n- Acid etching (30s)\n- Bonding agent applied\n- Composite placement and curing\n- Occlusion adjusted\n- Polish completed' },
  { id: 4, name: 'Crown Prep', preview: 'Crown preparation and impression...', text: 'Procedure: Crown Preparation\n- Local anesthesia administered\n- Tooth preparation (360° reduction)\n- Margin refinement\n- Impression taken\n- Shade selection\n- Temporary crown fabricated and cemented' }
]

// Methods
const toggleRecording = () => {
  isRecording.value = !isRecording.value
  if (isRecording.value) {
    // Simulate voice recording (would integrate with Web Speech API)
    console.log('Started voice recording for:', props.id)
  } else {
    console.log('Stopped voice recording')
  }
}

const toggleMacros = () => {
  showMacros.value = !showMacros.value
  showTemplates.value = false
}

const toggleTemplates = () => {
  showTemplates.value = !showTemplates.value
  showMacros.value = false
}

const insertMacro = (macro) => {
  content.value += (content.value ? ' ' : '') + macro.text
  showMacros.value = false
}

const insertTemplate = (template) => {
  content.value += (content.value ? '\n\n' : '') + template.text
  showTemplates.value = false
}
</script>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
</style>

