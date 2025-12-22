<template>
  <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-gray-50 to-teal-50/30 font-[Poppins]">
    <!-- Main Container  max-w-7xl-->
    <div class=" mx-auto py-4 md:py-6 lg:py-8">
      
      <!-- Patient Header Card -->
      <header class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-200/60 mb-6">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-400"></div>
        
        <div class="p-5 md:p-6">
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <!-- Patient Avatar & Info -->
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-teal-500/20">
                JD
              </div>
              <div>
                <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">John Doe</h1>
                <div class="flex items-center gap-2 mt-1">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                    <i class="fas fa-id-card mr-1.5 text-slate-400"></i>
                    ID: 12345
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-50 text-teal-700">
                    <i class="fas fa-tooth mr-1.5"></i>
                    Active Patient
                  </span>
                </div>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="sm:ml-auto flex flex-wrap gap-2.5">
              <button 
                @click="showVersionHistory = true"
                class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl cursor-pointer transition-all duration-200 hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm"
              >
                <i class="fas fa-history text-slate-400 group-hover:text-teal-500 transition-colors"></i>
                <span class="hidden sm:inline">Review History</span>
                <span class="sm:hidden">History</span>
              </button>
              <button class="group flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">New Entry</span>
                <span class="sm:hidden">New</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Navigation Tabs -->
      <nav class="flex gap-2 mb-6 p-1.5 bg-white/60 backdrop-blur-sm rounded-xl border border-slate-200/60 w-fit">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          :class="[
            'flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 outline-none',
            activeTab === tab.id
              ? 'bg-white text-slate-800 shadow-sm border border-slate-200/60'
              : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'
          ]"
          @click="activeTab = tab.id"
        >
          <i :class="[tab.icon, activeTab === tab.id ? 'text-teal-500' : 'text-slate-400']"></i>
          {{ tab.label }}
        </button>
      </nav>

      <!-- Content Grid -->
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Main SOAP Note Form (2 columns on xl) -->
        <transition name="fade-slide" mode="out-in">
          <div v-if="activeTab === 'soap'" key="soap-form" class="xl:col-span-2 space-y-6">
            
            <!-- SOAP Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <!-- Card Header -->
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-sm">
                    <i class="fas fa-notes-medical text-white text-sm"></i>
                  </div>
                  <div>
                    <h2 class="text-lg font-semibold text-slate-800">New SOAP Note</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Structured clinical documentation</p>
                  </div>
                </div>
                <div class="sm:ml-auto flex items-center gap-3">
                  <!-- Note Type Toggle -->
                  <div class="flex items-center bg-slate-100 rounded-lg p-0.5">
                    <button 
                      :class="[
                        'px-3 py-1.5 rounded-md text-xs font-medium transition-all',
                        noteType === 'structured' ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'
                      ]"
                      @click="noteType = 'structured'"
                    >
                      <i class="fas fa-th-list mr-1.5"></i>Structured
                    </button>
                    <button 
                      :class="[
                        'px-3 py-1.5 rounded-md text-xs font-medium transition-all',
                        noteType === 'freetext' ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'
                      ]"
                      @click="noteType = 'freetext'"
                    >
                      <i class="fas fa-align-left mr-1.5"></i>Free-text
                    </button>
                  </div>
                  
                  <!-- Template Select -->
                  <select 
                    v-model="selectedTemplate"
                    class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all cursor-pointer"
                  >
                    <option value="">Select Template</option>
                    <option v-for="t in procedureTemplates" :key="t.id" :value="t.id">{{ t.name }}</option>
                  </select>
                </div>
              </div>
              
              <!-- Form Body -->
              <div class="p-5">
                <!-- Structured SOAP Fields -->
                <div v-if="noteType === 'structured'" class="space-y-5">
                  <ClinicalTextarea
                    v-for="field in soapFields"
                    :key="field.id"
                    :id="field.id"
                    :label="field.label"
                    :letter="field.letter"
                    :placeholder="field.placeholder"
                    :color="field.color"
                    v-model="soapData[field.id]"
                    @ai-assist="handleAIAssist"
                  />
                </div>
                
                <!-- Free-text Mode -->
                <div v-else class="space-y-4">
                  <div class="relative">
                    <textarea
                      v-model="freeTextNote"
                      placeholder="Enter your clinical notes here. Use natural language or dictation..."
                      class="w-full px-4 py-4 border border-slate-200 rounded-xl resize-y min-h-[300px] text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                    ></textarea>
                    <button
                      @click="isRecordingFreeText = !isRecordingFreeText"
                      :class="[
                        'absolute right-4 top-4 w-10 h-10 rounded-xl flex items-center justify-center transition-all',
                        isRecordingFreeText 
                          ? 'bg-red-500 text-white animate-pulse shadow-lg' 
                          : 'bg-slate-100 text-slate-400 hover:bg-teal-500 hover:text-white'
                      ]"
                    >
                      <i :class="isRecordingFreeText ? 'fas fa-stop' : 'fas fa-microphone'"></i>
                    </button>
                  </div>
                  <p class="text-xs text-slate-400 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    Tip: Click the microphone to use voice dictation
                  </p>
                </div>
              </div>
            </div>

            <!-- AI Enhancements Panel -->
            <div class="bg-gradient-to-br from-violet-500/5 via-purple-500/5 to-fuchsia-500/5 rounded-2xl border border-violet-200/50 overflow-hidden">
              <div class="flex items-center gap-3 p-4 border-b border-violet-200/30">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-sm">
                  <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div>
                  <h3 class="text-sm font-semibold text-slate-800">AI Enhancements</h3>
                  <p class="text-xs text-slate-500">Powered by clinical AI</p>
                </div>
                <span class="ml-auto px-2 py-0.5 rounded-full text-[10px] font-bold bg-violet-100 text-violet-600 uppercase">Beta</span>
              </div>
              
              <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Voice Dictation -->
                <button 
                  @click="startGlobalDictation"
                  :class="[
                    'flex flex-col items-center gap-2 p-4 rounded-xl border transition-all',
                    isGlobalRecording 
                      ? 'bg-red-50 border-red-200 text-red-600' 
                      : 'bg-white/60 border-slate-200/50 hover:bg-white hover:border-violet-300 text-slate-600 hover:text-violet-600'
                  ]"
                >
                  <div :class="[
                    'w-10 h-10 rounded-full flex items-center justify-center',
                    isGlobalRecording ? 'bg-red-500 animate-pulse' : 'bg-slate-100'
                  ]">
                    <i :class="[
                      isGlobalRecording ? 'fas fa-stop text-white' : 'fas fa-microphone',
                      isGlobalRecording ? '' : 'text-slate-500'
                    ]"></i>
                  </div>
                  <span class="text-xs font-medium">{{ isGlobalRecording ? 'Stop Recording' : 'Voice Dictation' }}</span>
                </button>
                
                <!-- AI Draft -->
                <button 
                  @click="generateAIDraft"
                  :class="[
                    'flex flex-col items-center gap-2 p-4 rounded-xl border transition-all bg-white/60 border-slate-200/50 hover:bg-white hover:border-violet-300',
                    isGeneratingDraft ? 'opacity-75 cursor-wait' : ''
                  ]"
                  :disabled="isGeneratingDraft"
                >
                  <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-100 to-purple-100 flex items-center justify-center">
                    <i :class="[
                      'fas',
                      isGeneratingDraft ? 'fa-spinner fa-spin' : 'fa-magic',
                      'text-violet-500'
                    ]"></i>
                  </div>
                  <span class="text-xs font-medium text-slate-600">AI-Assisted Draft</span>
                </button>
                
                <!-- Auto Summary -->
                <button 
                  @click="generateSummary"
                  class="flex flex-col items-center gap-2 p-4 rounded-xl border transition-all bg-white/60 border-slate-200/50 hover:bg-white hover:border-violet-300"
                >
                  <div class="w-10 h-10 rounded-full bg-gradient-to-br from-fuchsia-100 to-pink-100 flex items-center justify-center">
                    <i class="fas fa-file-alt text-fuchsia-500"></i>
                  </div>
                  <span class="text-xs font-medium text-slate-600">Auto Summary</span>
                </button>
              </div>
              
              <!-- AI Generated Content Preview -->
              <div v-if="aiSummary" class="mx-4 mb-4 p-3 bg-white/80 rounded-xl border border-violet-200/50">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-xs font-semibold text-violet-600">
                    <i class="fas fa-sparkles mr-1"></i>AI Summary
                  </span>
                  <button @click="aiSummary = ''" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed">{{ aiSummary }}</p>
              </div>
            </div>

            <!-- Attachments Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center justify-between p-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                    <i class="fas fa-paperclip text-white text-sm"></i>
                  </div>
                  <div>
                    <h3 class="text-sm font-semibold text-slate-800">Attachments</h3>
                    <p class="text-xs text-slate-400">X-rays, photos, documents</p>
                  </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                  {{ attachments.length }} files
                </span>
              </div>
              
              <div class="p-4">
                <!-- Upload Zone -->
                <div 
                  @drop.prevent="handleFileDrop"
                  @dragover.prevent="isDragging = true"
                  @dragleave="isDragging = false"
                  :class="[
                    'border-2 border-dashed rounded-xl p-6 text-center transition-all cursor-pointer',
                    isDragging 
                      ? 'border-teal-400 bg-teal-50/50' 
                      : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50/50'
                  ]"
                  @click="triggerFileInput"
                >
                  <input 
                    ref="fileInput" 
                    type="file" 
                    multiple 
                    accept="image/*,.pdf,.doc,.docx" 
                    class="hidden"
                    @change="handleFileSelect"
                  >
                  <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-cloud-upload-alt text-slate-400 text-xl"></i>
                  </div>
                  <p class="text-sm text-slate-600 font-medium">Drop files here or click to upload</p>
                  <p class="text-xs text-slate-400 mt-1">X-rays, Photos, PDFs up to 10MB</p>
                </div>

                <!-- Attachment List -->
                <div v-if="attachments.length > 0" class="mt-4 space-y-2">
                  <div 
                    v-for="(file, index) in attachments" 
                    :key="index"
                    class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl group"
                  >
                    <div :class="[
                      'w-10 h-10 rounded-lg flex items-center justify-center',
                      file.type === 'image' ? 'bg-blue-100' : file.type === 'pdf' ? 'bg-red-100' : 'bg-amber-100'
                    ]">
                      <i :class="[
                        'fas text-sm',
                        file.type === 'image' ? 'fa-image text-blue-500' : file.type === 'pdf' ? 'fa-file-pdf text-red-500' : 'fa-file text-amber-500'
                      ]"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-slate-700 truncate">{{ file.name }}</p>
                      <p class="text-xs text-slate-400">{{ file.size }}</p>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button class="p-1.5 rounded-lg text-slate-400 hover:text-blue-500 hover:bg-blue-50">
                        <i class="fas fa-eye text-xs"></i>
                      </button>
                      <button 
                        @click="removeAttachment(index)"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50"
                      >
                        <i class="fas fa-trash text-xs"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Consent Linkage -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center justify-between p-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center shadow-sm">
                    <i class="fas fa-file-signature text-white text-sm"></i>
                  </div>
                  <div>
                    <h3 class="text-sm font-semibold text-slate-800">Consent Linkage</h3>
                    <p class="text-xs text-slate-400">Link consent forms to this note</p>
                  </div>
                </div>
              </div>
              
              <div class="p-4">
                <div class="space-y-2">
                  <div 
                    v-for="consent in consentForms" 
                    :key="consent.id"
                    :class="[
                      'flex items-center gap-3 p-3 rounded-xl border transition-all cursor-pointer',
                      consent.linked 
                        ? 'bg-emerald-50/50 border-emerald-200' 
                        : 'bg-slate-50 border-slate-200 hover:border-slate-300'
                    ]"
                    @click="toggleConsent(consent.id)"
                  >
                    <div :class="[
                      'w-5 h-5 rounded-md border-2 flex items-center justify-center transition-all',
                      consent.linked 
                        ? 'bg-emerald-500 border-emerald-500' 
                        : 'border-slate-300'
                    ]">
                      <i v-if="consent.linked" class="fas fa-check text-white text-xs"></i>
                    </div>
                    <div class="flex-1">
                      <p class="text-sm font-medium text-slate-700">{{ consent.name }}</p>
                      <p class="text-xs text-slate-400">{{ consent.date }} · {{ consent.status }}</p>
                    </div>
                    <span :class="[
                      'px-2 py-0.5 rounded-full text-xs font-medium',
                      consent.status === 'Signed' 
                        ? 'bg-emerald-100 text-emerald-600' 
                        : 'bg-amber-100 text-amber-600'
                    ]">
                      {{ consent.status }}
                    </span>
                  </div>
                </div>
                
                <button class="w-full mt-3 px-4 py-2.5 text-sm font-medium text-teal-600 bg-teal-50 rounded-xl hover:bg-teal-100 transition-colors">
                  <i class="fas fa-plus mr-2"></i>
                  Request New Consent
                </button>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between gap-3 p-4 bg-white rounded-2xl shadow-sm border border-slate-200/60">
              <div class="flex items-center gap-2 text-xs text-slate-400">
                <i class="fas fa-clock"></i>
                <span>Auto-saved 2 minutes ago</span>
                <span class="w-1 h-1 rounded-full bg-emerald-400"></span>
                <span class="text-emerald-500">Draft</span>
              </div>
              <div class="flex gap-3">
                <button class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300">
                  <i class="fas fa-save mr-2 text-slate-400"></i>
                  Save Draft
                </button>
                <button class="px-5 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 hover:from-teal-600 hover:to-cyan-600">
                  <i class="fas fa-paper-plane mr-2"></i>
                  Submit Note
                </button>
              </div>
            </div>
          </div>
        </transition>

        <!-- Right Sidebar - History & Info -->
        <transition name="fade-slide" mode="out-in">
          <div v-if="activeTab === 'soap'" key="soap-sidebar" class="space-y-6">
            
            <!-- Version History -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center gap-3 p-4 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center shadow-sm">
                  <i class="fas fa-code-branch text-white text-sm"></i>
                </div>
                <div>
                  <h3 class="text-sm font-semibold text-slate-800">Version History</h3>
                  <p class="text-xs text-slate-400">Audit trail & revisions</p>
                </div>
              </div>
              
              <div class="p-4">
                <div class="relative">
                  <!-- Timeline line -->
                  <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-slate-200"></div>
                  
                  <div class="space-y-4">
                    <div 
                      v-for="(version, index) in versionHistory" 
                      :key="index"
                      class="relative flex gap-3 group cursor-pointer"
                    >
                      <div :class="[
                        'w-6 h-6 rounded-full flex items-center justify-center z-10 transition-all',
                        index === 0 ? 'bg-teal-500 ring-4 ring-teal-100' : 'bg-slate-200 group-hover:bg-slate-300'
                      ]">
                        <i :class="[
                          'fas text-[10px]',
                          version.type === 'created' ? 'fa-plus' : version.type === 'edited' ? 'fa-pen' : 'fa-check',
                          index === 0 ? 'text-white' : 'text-slate-500'
                        ]"></i>
                      </div>
                      <div class="flex-1 pb-4">
                        <p class="text-sm font-medium text-slate-700">{{ version.action }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ version.user }} · {{ version.time }}</p>
                        <button v-if="index > 0" class="text-xs text-teal-600 hover:text-teal-700 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                          View changes →
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- SOAP Notes History -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
              <div class="flex items-center gap-3 p-4 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-history text-white text-sm"></i>
                </div>
                <h3 class="text-sm font-semibold text-slate-800">Recent Notes</h3>
                <span class="ml-auto px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                  {{ soapNotes.length }}
                </span>
              </div>
              
              <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto">
                <div 
                  v-for="(note, index) in soapNotes" 
                  :key="index"
                  class="p-4 hover:bg-slate-50/50 transition-colors cursor-pointer group"
                >
                  <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                      <span class="text-xs font-medium text-slate-400">{{ note.date }}</span>
                      <span :class="[
                        'px-2 py-0.5 rounded-full text-[10px] font-medium',
                        note.type === 'Emergency Visit' ? 'bg-red-100 text-red-600' : 'bg-teal-100 text-teal-600'
                      ]">
                        {{ note.type }}
                      </span>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-teal-500 group-hover:translate-x-1 transition-all text-xs"></i>
                  </div>
                  
                  <div class="space-y-1">
                    <p v-for="(content, key) in note.content" :key="key" class="text-xs leading-relaxed text-slate-500 line-clamp-1">
                      <span :class="[
                        'inline-flex items-center justify-center w-4 h-4 rounded text-[10px] font-bold mr-1',
                        getSoapBadgeClass(key)
                      ]">
                        {{ key }}
                      </span>
                      {{ content }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>

        <!-- Treatment Plan Tab Content -->
        <transition name="fade-slide" mode="out-in">
          <div v-if="activeTab === 'treatment'" key="treatment-plan" class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <!-- Card Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-clipboard-list text-white text-sm"></i>
                </div>
                <h2 class="text-lg font-semibold text-slate-800">Current Treatment Plan</h2>
              </div>
              <button class="sm:ml-auto px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 hover:border-slate-300">
                <i class="fas fa-edit mr-2 text-slate-400"></i>
                Edit Plan
              </button>
            </div>
            
            <!-- Treatment Table -->
            <div class="p-5">
              <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full min-w-[500px]">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Procedure</th>
                      <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tooth</th>
                      <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Cost</th>
                      <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-100">
                    <tr 
                      v-for="(treatment, index) in treatments" 
                      :key="index"
                      class="hover:bg-slate-50/50 transition-colors"
                    >
                      <td class="px-4 py-3.5 text-sm font-medium text-slate-700">{{ treatment.procedure }}</td>
                      <td class="px-4 py-3.5 text-sm text-slate-600">{{ treatment.tooth }}</td>
                      <td class="px-4 py-3.5 text-sm font-medium text-slate-700">{{ treatment.cost }}</td>
                      <td class="px-4 py-3.5">
                        <StatusBadge :status="treatment.status" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <div class="mt-6 p-4 rounded-xl bg-amber-50/50 border border-amber-200/50">
                <h3 class="text-sm font-semibold text-amber-800 flex items-center gap-2 mb-2">
                  <i class="fas fa-sticky-note text-amber-500"></i>
                  Additional Notes
                </h3>
                <p class="text-sm text-amber-700/80 leading-relaxed">
                  Patient has expressed some anxiety about the upcoming extraction. Consider offering sedation options.
                </p>
              </div>
              
              <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-700 flex items-center gap-2 mb-3">
                  <i class="fas fa-signature text-slate-400"></i>
                  Digital Signature
                </h3>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                  <span class="italic text-slate-400 text-sm">Patient signature required to proceed</span>
                  <button class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium rounded-xl cursor-pointer transition-all duration-200 bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30">
                    <i class="fas fa-pen-fancy"></i>
                    Capture Signature
                  </button>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>
    <NymoCheckbox />
    <!-- Version History Modal -->
    <transition name="modal">
      <div v-if="showVersionHistory" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="showVersionHistory = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[80vh] overflow-hidden">
          <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-800">Version History</h3>
            <button @click="showVersionHistory = false" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="p-5 overflow-y-auto max-h-[60vh]">
            <div class="space-y-4">
              <div 
                v-for="(version, index) in fullVersionHistory" 
                :key="index"
                class="p-4 rounded-xl border border-slate-200 hover:border-slate-300 transition-colors"
              >
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm font-medium text-slate-700">{{ version.action }}</span>
                  <span class="text-xs text-slate-400">{{ version.time }}</span>
                </div>
                <p class="text-xs text-slate-500">{{ version.user }}</p>
                <p v-if="version.changes" class="text-xs text-slate-400 mt-2 p-2 bg-slate-50 rounded-lg">{{ version.changes }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ClinicalTextarea from '@/components/clinical-notes/ClinicalTextarea.vue'

// Reactive state
const activeTab = ref('soap')
const noteType = ref('structured')
const selectedTemplate = ref('')
const isRecordingFreeText = ref(false)
const isGlobalRecording = ref(false)
const isGeneratingDraft = ref(false)
const isDragging = ref(false)
const showVersionHistory = ref(false)
const aiSummary = ref('')
const freeTextNote = ref('')
const fileInput = ref(null)

// SOAP form data
const soapData = ref({
  subjective: '',
  objective: '',
  assessment: '',
  plan: ''
})

// Tab configuration
const tabs = [
  { id: 'soap', label: 'SOAP Notes', icon: 'fas fa-notes-medical' },
  { id: 'treatment', label: 'Treatment Plans', icon: 'fas fa-clipboard-list' }
]

// SOAP form fields
const soapFields = [
  { id: 'subjective', letter: 'S', label: 'Subjective', placeholder: "Patient's chief complaint, history of present illness, symptoms described in their own words...", color: 'teal' },
  { id: 'objective', letter: 'O', label: 'Objective', placeholder: 'Clinical findings, vital signs, examination results, test findings...', color: 'cyan' },
  { id: 'assessment', letter: 'A', label: 'Assessment', placeholder: 'Diagnosis or differential diagnosis, clinical interpretation...', color: 'violet' },
  { id: 'plan', letter: 'P', label: 'Plan', placeholder: 'Treatment plan, medications, procedures, follow-up schedule...', color: 'amber' }
]

// Procedure templates
const procedureTemplates = [
  { id: 1, name: 'General Checkup' },
  { id: 2, name: 'Emergency Visit' },
  { id: 3, name: 'Root Canal' },
  { id: 4, name: 'Extraction' },
  { id: 5, name: 'Crown Prep' },
  { id: 6, name: 'Filling' }
]

// Sample SOAP notes data
const soapNotes = ref([
  {
    date: '2024-05-15',
    type: 'General Checkup',
    content: {
      S: 'Patient reports sensitivity in upper right quadrant, especially to cold beverages.',
      O: 'Old amalgam filling on tooth #3. Small recurrent decay visible on distal margin.',
      A: 'Recurrent decay, tooth #3.',
      P: 'Composite filling scheduled. Patient consented.'
    }
  },
  {
    date: '2024-03-20',
    type: 'Emergency Visit',
    content: {
      S: 'Severe pain on lower left side. Sharp and constant.',
      O: 'Large carious lesion on tooth #19. X-ray confirms extensive decay.',
      A: 'Irreversible pulpitis, tooth #19.',
      P: 'Emergency pulpectomy performed. Root canal recommended.'
    }
  }
])

// Treatment data
const treatments = ref([
  { procedure: 'Examination', tooth: 'All', cost: '$50', status: 'completed' },
  { procedure: 'Filling', tooth: '18', cost: '$120', status: 'scheduled' },
  { procedure: 'Extraction', tooth: '21', cost: '$200', status: 'pending' },
  { procedure: 'Crown', tooth: '12', cost: '$800', status: 'proposed' }
])

// Attachments
const attachments = ref([
  { name: 'Panoramic_Xray_2024.jpg', type: 'image', size: '2.4 MB' },
  { name: 'Consent_Form.pdf', type: 'pdf', size: '156 KB' }
])

// Consent forms
const consentForms = ref([
  { id: 1, name: 'General Treatment Consent', date: '2024-01-15', status: 'Signed', linked: true },
  { id: 2, name: 'Extraction Consent Form', date: '2024-05-10', status: 'Pending', linked: false },
  { id: 3, name: 'Sedation Authorization', date: '2024-05-12', status: 'Signed', linked: false }
])

// Version history
const versionHistory = ref([
  { type: 'created', action: 'Note created', user: 'Dr. Smith', time: '10 min ago' },
  { type: 'edited', action: 'Assessment updated', user: 'Dr. Smith', time: '2 hours ago' },
  { type: 'edited', action: 'Plan modified', user: 'Dr. Johnson', time: 'Yesterday' }
])

const fullVersionHistory = ref([
  { action: 'Note created', user: 'Dr. Smith', time: 'Dec 22, 2024 10:30 AM', changes: null },
  { action: 'Assessment section updated', user: 'Dr. Smith', time: 'Dec 22, 2024 8:15 AM', changes: 'Changed diagnosis from "Suspected decay" to "Recurrent decay, tooth #3"' },
  { action: 'Plan section modified', user: 'Dr. Johnson', time: 'Dec 21, 2024 4:45 PM', changes: 'Added follow-up appointment details' },
  { action: 'Attachment added', user: 'Dr. Smith', time: 'Dec 21, 2024 2:30 PM', changes: 'Uploaded Panoramic_Xray_2024.jpg' },
  { action: 'Initial draft saved', user: 'Dr. Smith', time: 'Dec 21, 2024 1:00 PM', changes: null }
])

// Methods
const getSoapBadgeClass = (key) => {
  const classes = {
    S: 'bg-teal-100 text-teal-700',
    O: 'bg-cyan-100 text-cyan-700',
    A: 'bg-violet-100 text-violet-700',
    P: 'bg-amber-100 text-amber-700'
  }
  return classes[key] || 'bg-slate-100 text-slate-700'
}

const handleAIAssist = (fieldId) => {
  console.log('AI assist requested for:', fieldId)
  // Would integrate with AI service
}

const startGlobalDictation = () => {
  isGlobalRecording.value = !isGlobalRecording.value
  if (isGlobalRecording.value) {
    console.log('Started global voice dictation')
    // Would integrate with Web Speech API
  }
}

const generateAIDraft = async () => {
  isGeneratingDraft.value = true
  // Simulate AI generation
  await new Promise(resolve => setTimeout(resolve, 2000))
  soapData.value.subjective = 'Patient presents with chief complaint of tooth sensitivity in the upper right quadrant.'
  soapData.value.objective = 'Clinical examination reveals recurrent decay on tooth #3 with old amalgam restoration.'
  isGeneratingDraft.value = false
}

const generateSummary = () => {
  aiSummary.value = 'Patient John Doe (ID: 12345) presented for routine checkup. Key findings include recurrent decay on tooth #3 requiring composite restoration. Treatment plan discussed and patient consented. Follow-up scheduled.'
}

const toggleConsent = (id) => {
  const consent = consentForms.value.find(c => c.id === id)
  if (consent) consent.linked = !consent.linked
}

const triggerFileInput = () => {
  fileInput.value?.click()
}

const handleFileSelect = (event) => {
  const files = event.target.files
  if (files) {
    addFiles(files)
  }
}

const handleFileDrop = (event) => {
  isDragging.value = false
  const files = event.dataTransfer.files
  if (files) {
    addFiles(files)
  }
}

const addFiles = (files) => {
  for (const file of files) {
    const type = file.type.startsWith('image/') ? 'image' : file.type === 'application/pdf' ? 'pdf' : 'document'
    attachments.value.push({
      name: file.name,
      type,
      size: formatFileSize(file.size)
    })
  }
}

const formatFileSize = (bytes) => {
  if (bytes < 1024) return bytes + ' B'
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
}

const removeAttachment = (index) => {
  attachments.value.splice(index, 1)
}
</script>

<!-- Status Badge Component -->
<script>
const StatusBadge = {
  props: ['status'],
  computed: {
    badgeClass() {
      const classes = {
        completed: 'bg-emerald-50 text-emerald-700 border-emerald-200',
        scheduled: 'bg-amber-50 text-amber-700 border-amber-200',
        pending: 'bg-rose-50 text-rose-700 border-rose-200',
        proposed: 'bg-sky-50 text-sky-700 border-sky-200'
      }
      return classes[this.status] || 'bg-slate-50 text-slate-700 border-slate-200'
    },
    icon() {
      const icons = {
        completed: 'fas fa-check-circle',
        scheduled: 'fas fa-calendar-check',
        pending: 'fas fa-clock',
        proposed: 'fas fa-lightbulb'
      }
      return icons[this.status] || 'fas fa-circle'
    },
    label() {
      return this.status.charAt(0).toUpperCase() + this.status.slice(1)
    }
  },
  template: `
    <span :class="['inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium border', badgeClass]">
      <i :class="[icon, 'text-[10px]']"></i>
      {{ label }}
    </span>
  `
}

export default {
  components: { StatusBadge }
}
</script>

<style scoped>
/* Fade slide transition */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Modal transition */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-from > div,
.modal-leave-to > div {
  transform: scale(0.95);
}

/* Line clamp utility */
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
