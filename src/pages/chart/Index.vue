<template>
  <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-gray-50 to-teal-50/30 font-[Poppins]">
    <!-- Main Container -->
    <div class="mx-auto py-4 md:py-6 lg:py-8">
      
      <!-- Patient Header Card -->
      <header class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-200/60 mb-6">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-400"></div>
        
        <div class="p-5 md:p-6">
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <!-- Patient Avatar & Info -->
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-teal-500/20 overflow-hidden">
                <img 
                  v-if="patient.avatar" 
                  :src="patient.avatar" 
                  :alt="patient.name"
                  class="w-full h-full object-cover"
                />
                <span v-else>{{ getInitials(patient.name) }}</span>
              </div>
              <div>
                <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">{{ patient.name }}</h1>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                    <i class="fas fa-calendar mr-1.5 text-slate-400"></i>
                    DOB: {{ patient.dob }}
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                    <i class="fas fa-id-card mr-1.5 text-slate-400"></i>
                    ID: {{ patient.id }}
                  </span>
                  <span v-if="patient.medicalAlert" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600">
                    <i class="fas fa-exclamation-triangle mr-1.5"></i>
                    {{ patient.medicalAlert }}
                  </span>
                </div>
              </div>
            </div>
            
            <!-- Chart Mode Toggle -->
            <div class="sm:ml-auto flex items-center gap-2">
              <div class="flex items-center bg-slate-100 rounded-xl p-1">
                <button 
                  :class="[
                    'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                    chartMode === 'permanent' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700'
                  ]"
                  @click="chartMode = 'permanent'"
                >
                  Adult (1-32)
                </button>
                <button 
                  :class="[
                    'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                    chartMode === 'primary' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700'
                  ]"
                  @click="chartMode = 'primary'"
                >
                  Pediatric (A-T)
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        
        <!-- Left Sidebar - Treatment List -->
        <aside class="xl:col-span-1 space-y-6">
          <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-400"></div>
            
            <!-- Sidebar Header -->
            <div class="flex items-center gap-3 p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-sm">
                <i class="fas fa-list-ul text-white text-sm"></i>
              </div>
              <div>
                <h3 class="text-sm font-semibold text-slate-800">Treatment List</h3>
                <p class="text-xs text-slate-400">Drag to add treatments</p>
              </div>
            </div>
            
            <!-- Tabs -->
            <div class="flex border-b border-slate-100">
              <button 
                :class="[
                  'flex-1 px-4 py-3 text-xs font-medium transition-all border-b-2',
                  sidebarView === 'treatments' 
                    ? 'text-teal-600 border-teal-500 bg-teal-50/50' 
                    : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50'
                ]"
                @click="sidebarView = 'treatments'"
              >
                Treatment List
              </button>
              <button 
                :class="[
                  'flex-1 px-4 py-3 text-xs font-medium transition-all border-b-2',
                  sidebarView === 'templates' 
                    ? 'text-teal-600 border-teal-500 bg-teal-50/50' 
                    : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50'
                ]"
                @click="sidebarView = 'templates'"
              >
                Plan Templates
              </button>
            </div>
            
            <!-- Search -->
            <div class="p-3 border-b border-slate-100">
              <div class="relative">
                <input 
                  type="text" 
                  v-model="treatmentSearch"
                  placeholder="Search treatments..." 
                  class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
                />
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              </div>
            </div>
            
            <!-- Treatment List -->
            <div class="max-h-[400px] overflow-y-auto">
              <div 
                v-for="treatment in filteredTreatments" 
                :key="treatment.code"
                class="flex items-center gap-3 px-4 py-3 border-b border-slate-50 cursor-pointer transition-all hover:bg-teal-50/50 group"
                :class="{ 'bg-teal-50 border-l-2 border-l-teal-500': selectedTreatment?.code === treatment.code }"
                @click="selectTreatment(treatment)"
                draggable="true"
              >
                <i :class="['fas fa-star text-xs', treatment.favorite ? 'text-amber-400' : 'text-slate-200 group-hover:text-slate-300']"></i>
                <span class="text-xs font-bold text-teal-600 min-w-[50px]">{{ treatment.code }}</span>
                <span class="text-sm text-slate-600 truncate">{{ treatment.name }}</span>
              </div>
            </div>
            
            <!-- Alphabet Quick Nav -->
            <div class="flex flex-wrap gap-1 p-3 bg-slate-50 border-t border-slate-100">
              <span 
                v-for="letter in alphabet" 
                :key="letter"
                class="w-5 h-5 flex items-center justify-center text-[10px] font-semibold text-slate-400 hover:text-white hover:bg-teal-500 rounded cursor-pointer transition-all"
                @click="filterByLetter(letter)"
              >{{ letter }}</span>
            </div>
          </div>
        </aside>

        <!-- Main Chart Area -->
        <main class="xl:col-span-2 space-y-6">
          
          <!-- Dental Chart Card -->
          <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-500 via-teal-500 to-emerald-400"></div>
            
            <!-- Chart Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-teal-500 flex items-center justify-center shadow-sm">
                  <i class="fas fa-tooth text-white text-sm"></i>
                </div>
                <div>
                  <h2 class="text-lg font-semibold text-slate-800">Dental Chart</h2>
                  <p class="text-xs text-slate-400">Universal Numbering System</p>
                </div>
              </div>
              
              <!-- Chart Type Buttons -->
              <div class="sm:ml-auto flex items-center gap-2">
                <button 
                  v-for="type in chartTypes" 
                  :key="type.id"
                  :class="[
                    'px-3 py-1.5 rounded-lg text-xs font-medium transition-all',
                    activeChartType === type.id 
                      ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-sm' 
                      : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                  ]"
                  @click="activeChartType = type.id"
                >
                  {{ type.label }}
                </button>
              </div>
            </div>

            <!-- Dental Chart -->
            <div class="p-6">
              <div class="dental-chart-wrapper">
                <!-- Side Labels -->
                <div class="side-label-left">R</div>
                <div class="side-label-right">L</div>
                
                <!-- Upper Jaw -->
                <div class="jaw-section">
                  <div class="tooth-numbers-row">
                    <span v-for="tooth in upperTeeth" :key="'num-u-'+tooth.number" class="tooth-number">
                      {{ tooth.number }}
                    </span>
                  </div>
                  <div class="teeth-row">
                    <div 
                      v-for="tooth in upperTeeth" 
                      :key="tooth.number"
                      :class="['tooth-item', { selected: selectedTooth?.number === tooth.number }]"
                      @click="selectTooth(tooth)"
                    >
                      <!-- Tooth Crown -->
                      <div class="tooth-crown-wrapper">
                        <svg viewBox="0 0 44 44" class="odontogram-svg">
                          <!-- Buccal (Top) -->
                          <path d="M 2 2 L 12 12 L 32 12 L 42 2 Z" :class="['surface-path', getSurfaceClass(tooth, 'buccal')]" @click.stop="toggleSurface(tooth, 'buccal')"/>
                          <!-- Lingual (Bottom) -->
                          <path d="M 2 42 L 12 32 L 32 32 L 42 42 Z" :class="['surface-path', getSurfaceClass(tooth, 'lingual')]" @click.stop="toggleSurface(tooth, 'lingual')"/>
                          <!-- Mesial (Left) -->
                          <path d="M 2 2 L 12 12 L 12 32 L 2 42 Z" :class="['surface-path', getSurfaceClass(tooth, 'mesial')]" @click.stop="toggleSurface(tooth, 'mesial')"/>
                          <!-- Distal (Right) -->
                          <path d="M 42 2 L 32 12 L 32 32 L 42 42 Z" :class="['surface-path', getSurfaceClass(tooth, 'distal')]" @click.stop="toggleSurface(tooth, 'distal')"/>
                          <!-- Occlusal (Center) -->
                          <rect x="12" y="12" width="20" height="20" :class="['surface-path', getSurfaceClass(tooth, 'occlusal')]" @click.stop="toggleSurface(tooth, 'occlusal')"/>
                          <!-- Condition Overlays -->
                          <g v-if="tooth.condition === 'implant'">
                            <text x="22" y="26" text-anchor="middle" class="implant-label">IMP</text>
                          </g>
                          <g v-if="tooth.condition === 'missing'">
                            <line x1="8" y1="8" x2="36" y2="36" class="missing-cross"/>
                            <line x1="36" y1="8" x2="8" y2="36" class="missing-cross"/>
                          </g>
                        </svg>
                      </div>
                      <!-- Root (Upper) -->
                      <div class="tooth-root upper">
                        <svg viewBox="0 0 44 28" class="root-svg">
                          <path :d="getRootPath(tooth.type, 'upper')" :class="['root-path', { 'root-implant': tooth.condition === 'implant' }]"/>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Jaw Divider -->
                <div class="jaw-divider">
                  <span class="divider-text">R</span>
                  <div class="divider-line"></div>
                  <span class="divider-text">L</span>
                </div>

                <!-- Lower Jaw -->
                <div class="jaw-section lower">
                  <div class="teeth-row">
                    <div 
                      v-for="tooth in lowerTeeth" 
                      :key="tooth.number"
                      :class="['tooth-item', { selected: selectedTooth?.number === tooth.number }]"
                      @click="selectTooth(tooth)"
                    >
                      <!-- Root (Lower) -->
                      <div class="tooth-root lower">
                        <svg viewBox="0 0 44 28" class="root-svg">
                          <path :d="getRootPath(tooth.type, 'lower')" :class="['root-path', { 'root-implant': tooth.condition === 'implant' }]"/>
                        </svg>
                      </div>
                      <!-- Tooth Crown -->
                      <div class="tooth-crown-wrapper">
                        <svg viewBox="0 0 44 44" class="odontogram-svg">
                          <path d="M 2 42 L 12 32 L 32 32 L 42 42 Z" :class="['surface-path', getSurfaceClass(tooth, 'buccal')]" @click.stop="toggleSurface(tooth, 'buccal')"/>
                          <path d="M 2 2 L 12 12 L 32 12 L 42 2 Z" :class="['surface-path', getSurfaceClass(tooth, 'lingual')]" @click.stop="toggleSurface(tooth, 'lingual')"/>
                          <path d="M 2 2 L 12 12 L 12 32 L 2 42 Z" :class="['surface-path', getSurfaceClass(tooth, 'mesial')]" @click.stop="toggleSurface(tooth, 'mesial')"/>
                          <path d="M 42 2 L 32 12 L 32 32 L 42 42 Z" :class="['surface-path', getSurfaceClass(tooth, 'distal')]" @click.stop="toggleSurface(tooth, 'distal')"/>
                          <rect x="12" y="12" width="20" height="20" :class="['surface-path', getSurfaceClass(tooth, 'occlusal')]" @click.stop="toggleSurface(tooth, 'occlusal')"/>
                          <g v-if="tooth.condition === 'implant'">
                            <text x="22" y="26" text-anchor="middle" class="implant-label">IMP</text>
                          </g>
                          <g v-if="tooth.condition === 'missing'">
                            <line x1="8" y1="8" x2="36" y2="36" class="missing-cross"/>
                            <line x1="36" y1="8" x2="8" y2="36" class="missing-cross"/>
                          </g>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div class="tooth-numbers-row">
                    <span v-for="tooth in lowerTeeth" :key="'num-l-'+tooth.number" class="tooth-number">
                      {{ tooth.number }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Legend -->
              <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="flex flex-wrap items-center gap-4">
                  <span class="text-xs font-semibold text-slate-500">Legend:</span>
                  <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2">
                      <span class="w-4 h-4 rounded border-2 border-slate-300 bg-white"></span>
                      <span class="text-xs text-slate-600">Healthy</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="w-4 h-4 rounded bg-red-500"></span>
                      <span class="text-xs text-slate-600">Decay</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="w-4 h-4 rounded bg-blue-500"></span>
                      <span class="text-xs text-slate-600">Filling</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="w-4 h-4 rounded bg-amber-500"></span>
                      <span class="text-xs text-slate-600">Crown</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="w-4 h-4 rounded bg-emerald-500"></span>
                      <span class="text-xs text-slate-600">Implant</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="w-4 h-4 rounded bg-slate-400"></span>
                      <span class="text-xs text-slate-600">Missing</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab Actions Bar -->
          <div class="flex flex-wrap gap-2 p-1.5 bg-white/60 backdrop-blur-sm rounded-xl border border-slate-200/60 w-fit">
            <button
              v-for="tab in chartTabs"
              :key="tab.id"
              :class="[
                'flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 outline-none',
                activeChartTab === tab.id
                  ? 'bg-white text-slate-800 shadow-sm border border-slate-200/60'
                  : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'
              ]"
              @click="activeChartTab = tab.id"
            >
              <i :class="[tab.icon, activeChartTab === tab.id ? 'text-teal-500' : 'text-slate-400']"></i>
              {{ tab.label }}
              <span v-if="tab.indicator" class="w-2 h-2 rounded-full" :style="{ background: tab.indicator }"></span>
            </button>
          </div>

          <!-- Appointments Section -->
          <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-violet-500 via-purple-500 to-fuchsia-400"></div>
            
            <div class="flex items-center gap-3 p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                <i class="fas fa-calendar-check text-white text-sm"></i>
              </div>
              <div>
                <h3 class="text-sm font-semibold text-slate-800">Appointments</h3>
                <p class="text-xs text-slate-400">Treatment schedule</p>
              </div>
              <span class="ml-auto px-2.5 py-1 rounded-full text-xs font-medium bg-violet-100 text-violet-600">
                {{ appointments.length }} active
              </span>
            </div>
            
            <div class="divide-y divide-slate-100">
              <div v-for="(appt, idx) in appointments" :key="appt.id" class="p-4">
                <div class="flex items-center gap-3 mb-3">
                  <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-violet-100 text-violet-600 text-xs font-bold">
                    {{ idx + 1 }}
                  </span>
                  <span class="text-sm font-medium text-slate-700">Appointment {{ idx + 1 }}</span>
                  <span :class="[
                    'ml-auto px-2.5 py-1 rounded-full text-xs font-medium',
                    appt.status === 'booked' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600'
                  ]">
                    {{ appt.statusLabel }}
                  </span>
                </div>
                
                <div class="space-y-2">
                  <div 
                    v-for="item in appt.items" 
                    :key="item.id"
                    class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl text-sm"
                  >
                    <input type="checkbox" v-model="item.completed" class="w-4 h-4 rounded border-slate-300 text-teal-500 focus:ring-teal-500 cursor-pointer" />
                    <span class="text-slate-500 text-xs">{{ item.date }}</span>
                    <span class="font-medium text-slate-700">{{ item.tooth }}</span>
                    <span class="text-slate-600 flex-1">{{ item.procedure }}</span>
                    <span class="text-slate-400 text-xs">{{ item.provider }}</span>
                    <span class="font-medium text-slate-700">{{ item.price }}</span>
                  </div>
                </div>
                
                <button class="mt-3 flex items-center gap-2 px-3 py-2 text-xs font-medium text-teal-600 hover:bg-teal-50 rounded-lg transition-all">
                  <i class="fas fa-plus"></i>
                  Add Treatment
                </button>
              </div>
            </div>
            
            <!-- Footer -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-4 bg-slate-50 border-t border-slate-100">
              <div class="flex items-center gap-3">
                <span class="text-sm text-slate-600">Total: <strong class="text-slate-800">{{ formatCurrency(totalPrice) }}</strong></span>
                <span class="text-sm text-slate-600">Uncharged: <strong class="text-amber-600">{{ formatCurrency(uncharged) }}</strong></span>
              </div>
              <div class="sm:ml-auto flex gap-3">
                <button class="px-4 py-2.5 text-sm font-medium rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all">
                  Charge
                </button>
                <button class="px-4 py-2.5 text-sm font-medium rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 transition-all">
                  Complete Plan
                </button>
              </div>
            </div>
          </div>
        </main>

        <!-- Right Sidebar - Selected Tooth Info -->
        <aside class="xl:col-span-1 space-y-6">
          
          <!-- Selected Tooth Card -->
          <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-400"></div>
            
            <div class="flex items-center gap-3 p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                <i class="fas fa-tooth text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-semibold text-slate-800">Selected Tooth</h3>
            </div>
            
            <div class="p-4">
              <div v-if="selectedTooth" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                  <div class="p-3 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-1">Number</p>
                    <p class="text-lg font-bold text-slate-800">#{{ selectedTooth.number }}</p>
                  </div>
                  <div class="p-3 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-1">Type</p>
                    <p class="text-sm font-medium text-slate-700 capitalize">{{ selectedTooth.type }}</p>
                  </div>
                </div>
                
                <div class="p-3 bg-slate-50 rounded-xl">
                  <p class="text-xs text-slate-400 mb-1">Name</p>
                  <p class="text-sm font-medium text-slate-700">{{ selectedTooth.name }}</p>
                </div>
                
                <div class="p-3 rounded-xl" :class="getConditionBgClass(selectedTooth.condition)">
                  <p class="text-xs opacity-70 mb-1">Condition</p>
                  <p class="text-sm font-semibold capitalize">{{ selectedTooth.condition || 'Healthy' }}</p>
                </div>
                
                <!-- Affected Surfaces -->
                <div v-if="hasAffectedSurfaces(selectedTooth)" class="pt-3 border-t border-slate-100">
                  <p class="text-xs font-semibold text-slate-500 mb-2">Affected Surfaces</p>
                  <div class="flex flex-wrap gap-2">
                    <span 
                      v-for="(val, surface) in selectedTooth.surfaces" 
                      :key="surface"
                      v-if="val"
                      :class="['px-2.5 py-1 rounded-lg text-xs font-medium capitalize', getSurfaceTagClass(val)]"
                    >
                      {{ surface }}
                    </span>
                  </div>
                </div>
              </div>
              
              <div v-else class="text-center py-8">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
                  <i class="fas fa-hand-pointer text-slate-400"></i>
                </div>
                <p class="text-sm text-slate-500">Click on a tooth to view details</p>
              </div>
            </div>
          </div>

          <!-- Quick Actions Card -->
          <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 via-orange-500 to-red-400"></div>
            
            <div class="flex items-center gap-3 p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                <i class="fas fa-bolt text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-semibold text-slate-800">Quick Actions</h3>
            </div>
            
            <div class="p-4 grid grid-cols-2 gap-2">
              <button 
                @click="setCondition('decay')"
                class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 hover:border-red-300 hover:bg-red-50 transition-all group"
              >
                <span class="w-4 h-4 rounded bg-red-500"></span>
                <span class="text-xs font-medium text-slate-600 group-hover:text-red-600">Decay</span>
              </button>
              <button 
                @click="setCondition('filling')"
                class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition-all group"
              >
                <span class="w-4 h-4 rounded bg-blue-500"></span>
                <span class="text-xs font-medium text-slate-600 group-hover:text-blue-600">Filling</span>
              </button>
              <button 
                @click="setCondition('crown')"
                class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all group"
              >
                <span class="w-4 h-4 rounded bg-amber-500"></span>
                <span class="text-xs font-medium text-slate-600 group-hover:text-amber-600">Crown</span>
              </button>
              <button 
                @click="setCondition('implant')"
                class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 transition-all group"
              >
                <span class="w-4 h-4 rounded bg-emerald-500"></span>
                <span class="text-xs font-medium text-slate-600 group-hover:text-emerald-600">Implant</span>
              </button>
              <button 
                @click="setCondition('missing')"
                class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 hover:border-slate-400 hover:bg-slate-100 transition-all group"
              >
                <span class="w-4 h-4 rounded bg-slate-400"></span>
                <span class="text-xs font-medium text-slate-600 group-hover:text-slate-700">Missing</span>
              </button>
              <button 
                @click="clearCondition"
                class="flex items-center gap-2 p-3 rounded-xl border border-red-200 hover:border-red-300 hover:bg-red-50 transition-all group"
              >
                <i class="fas fa-times-circle text-red-400 group-hover:text-red-500"></i>
                <span class="text-xs font-medium text-red-500 group-hover:text-red-600">Clear</span>
              </button>
            </div>
          </div>

          <!-- Patient Notes Card -->
          <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-slate-400 via-slate-500 to-slate-600"></div>
            
            <div class="flex items-center gap-3 p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
              <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center shadow-sm">
                <i class="fas fa-sticky-note text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-semibold text-slate-800">Patient Notes</h3>
            </div>
            
            <div class="p-4">
              <textarea
                v-model="patientNotes"
                placeholder="Add general patient notes..."
                rows="4"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl resize-none text-sm text-slate-700 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-400 transition-all"
              ></textarea>
              <button class="mt-3 w-full px-4 py-2.5 text-sm font-medium rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md shadow-teal-500/25 hover:shadow-lg hover:shadow-teal-500/30 transition-all">
                <i class="fas fa-save mr-2"></i>
                Save Notes
              </button>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Patient data
const patient = ref({
  name: 'John Smith',
  dob: '03/15/1985',
  id: 'P-12345',
  lastVisit: '01/10/2025',
  avatar: null,
  medicalAlert: 'Peanut Allergy'
});

const chartMode = ref('permanent');
const sidebarView = ref('treatments');
const treatmentSearch = ref('');
const selectedTreatment = ref(null);
const activeChartType = ref('base');
const activeChartTab = ref('treatment');
const selectedTooth = ref(null);
const patientNotes = ref('');

const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

const chartTypes = [
  { id: 'pd', label: 'PD' },
  { id: 'dd', label: 'DD' },
  { id: 'base', label: 'Base' }
];

const chartTabs = [
  { id: 'treatment', label: 'Treatment', icon: 'fas fa-notes-medical' },
  { id: 'history', label: 'History', icon: 'fas fa-history' },
  { id: 'imaging', label: 'Imaging', icon: 'fas fa-x-ray' },
  { id: 'perio', label: 'Periodontal', icon: 'fas fa-chart-line', indicator: '#ef4444' }
];

// Treatment list data
const treatments = ref([
  { code: '2140A', name: 'Amalgam Filling', favorite: true },
  { code: '121', name: 'Assess and Advice', favorite: true },
  { code: '2140B', name: 'Composite Filling', favorite: true },
  { code: '1T', name: 'Together - Exam C/S', favorite: true },
  { code: '2T', name: 'Together - Radiographic Report', favorite: true },
  { code: '140', name: 'Urgent Assessment', favorite: true },
  { code: '*1', name: '*Base Test', favorite: false },
  { code: '24213', name: '24213123', favorite: false },
  { code: '77004', name: '3D CBVT Cone Beam Scan', favorite: false },
  { code: '77007', name: '3D CBVT Maxillary and Mandib', favorite: false },
  { code: '6062', name: 'Abutment Supported Cast Met', favorite: false },
  { code: '6063', name: 'Abutment Supported Cast Met', favorite: false },
  { code: 'ACORI', name: 'ACORN ASSESMENT', favorite: false }
]);

const filteredTreatments = computed(() => {
  if (!treatmentSearch.value) return treatments.value;
  const search = treatmentSearch.value.toLowerCase();
  return treatments.value.filter(t => 
    t.code.toLowerCase().includes(search) || 
    t.name.toLowerCase().includes(search)
  );
});

// Tooth data - Universal Numbering System (1-32)
const permanentTeeth = ref([
  // Upper Right (1-8)
  { number: 1, name: 'UR 3rd Molar', type: 'molar', condition: null, surfaces: {} },
  { number: 2, name: 'UR 2nd Molar', type: 'molar', condition: null, surfaces: {} },
  { number: 3, name: 'UR 1st Molar', type: 'molar', condition: 'filling', surfaces: { occlusal: 'filling' } },
  { number: 4, name: 'UR 2nd Premolar', type: 'premolar', condition: null, surfaces: {} },
  { number: 5, name: 'UR 1st Premolar', type: 'premolar', condition: 'decay', surfaces: { mesial: 'decay', occlusal: 'decay' } },
  { number: 6, name: 'UR Canine', type: 'canine', condition: null, surfaces: {} },
  { number: 7, name: 'UR Lateral Incisor', type: 'incisor', condition: null, surfaces: {} },
  { number: 8, name: 'UR Central Incisor', type: 'incisor', condition: null, surfaces: {} },
  // Upper Left (9-16)
  { number: 9, name: 'UL Central Incisor', type: 'incisor', condition: null, surfaces: {} },
  { number: 10, name: 'UL Lateral Incisor', type: 'incisor', condition: null, surfaces: {} },
  { number: 11, name: 'UL Canine', type: 'canine', condition: null, surfaces: {} },
  { number: 12, name: 'UL 1st Premolar', type: 'premolar', condition: null, surfaces: {} },
  { number: 13, name: 'UL 2nd Premolar', type: 'premolar', condition: 'crown', surfaces: {} },
  { number: 14, name: 'UL 1st Molar', type: 'molar', condition: 'implant', surfaces: {} },
  { number: 15, name: 'UL 2nd Molar', type: 'molar', condition: null, surfaces: {} },
  { number: 16, name: 'UL 3rd Molar', type: 'molar', condition: 'missing', surfaces: {} },
  // Lower Left (17-24)
  { number: 17, name: 'LL 3rd Molar', type: 'molar', condition: null, surfaces: {} },
  { number: 18, name: 'LL 2nd Molar', type: 'molar', condition: null, surfaces: {} },
  { number: 19, name: 'LL 1st Molar', type: 'molar', condition: 'filling', surfaces: { occlusal: 'filling', distal: 'filling' } },
  { number: 20, name: 'LL 2nd Premolar', type: 'premolar', condition: null, surfaces: {} },
  { number: 21, name: 'LL 1st Premolar', type: 'premolar', condition: null, surfaces: {} },
  { number: 22, name: 'LL Canine', type: 'canine', condition: null, surfaces: {} },
  { number: 23, name: 'LL Lateral Incisor', type: 'incisor', condition: null, surfaces: {} },
  { number: 24, name: 'LL Central Incisor', type: 'incisor', condition: null, surfaces: {} },
  // Lower Right (25-32)
  { number: 25, name: 'LR Central Incisor', type: 'incisor', condition: null, surfaces: {} },
  { number: 26, name: 'LR Lateral Incisor', type: 'incisor', condition: null, surfaces: {} },
  { number: 27, name: 'LR Canine', type: 'canine', condition: null, surfaces: {} },
  { number: 28, name: 'LR 1st Premolar', type: 'premolar', condition: null, surfaces: {} },
  { number: 29, name: 'LR 2nd Premolar', type: 'premolar', condition: 'decay', surfaces: { buccal: 'decay' } },
  { number: 30, name: 'LR 1st Molar', type: 'molar', condition: null, surfaces: {} },
  { number: 31, name: 'LR 2nd Molar', type: 'molar', condition: 'crown', surfaces: {} },
  { number: 32, name: 'LR 3rd Molar', type: 'molar', condition: null, surfaces: {} }
]);

const upperTeeth = computed(() => permanentTeeth.value.slice(0, 16));
const lowerTeeth = computed(() => permanentTeeth.value.slice(16, 32));

// Appointments data
const appointments = ref([
  {
    id: 1,
    status: 'not-booked',
    statusLabel: 'Not yet booked',
    items: [
      { id: 1, date: 'Wed 05 Feb 25', tooth: 'LL4 - OD', procedure: 'Amalgam Filling', provider: 'AM (Private)', price: '-£20.00', completed: false },
      { id: 2, date: 'Wed 05 Feb 25', tooth: 'LL5 - OD', procedure: 'Amalgam Filling', provider: 'AM (Private)', price: '-£20.00', completed: false },
      { id: 3, date: 'Wed 05 Feb 25', tooth: '', procedure: 'Exam', provider: 'AM (Private)', price: '£50.00', completed: false },
      { id: 4, date: 'Wed 05 Feb 25', tooth: 'UR5 - DO', procedure: 'Amalgam Filling', provider: '', price: '-£10.00', completed: false }
    ]
  }
]);

const totalPrice = ref(0);
const uncharged = ref(0);

// Methods
function getInitials(name) {
  return name.split(' ').map(n => n[0]).join('').substring(0, 2);
}

function selectTreatment(treatment) {
  selectedTreatment.value = treatment;
}

function filterByLetter(letter) {
  treatmentSearch.value = letter;
}

function selectTooth(tooth) {
  selectedTooth.value = tooth;
}

function getSurfaceClass(tooth, surface) {
  const surfaceCondition = tooth.surfaces?.[surface];
  if (surfaceCondition) return surfaceCondition;
  if (tooth.condition === 'crown') return 'crown';
  if (tooth.condition === 'implant') return 'implant';
  return 'healthy';
}

function toggleSurface(tooth, surface) {
  if (!tooth.surfaces) tooth.surfaces = {};
  
  if (tooth.surfaces[surface]) {
    delete tooth.surfaces[surface];
  } else if (selectedTreatment.value) {
    const conditionMap = {
      'Amalgam Filling': 'filling',
      'Composite Filling': 'filling',
      'Assess and Advice': 'decay'
    };
    tooth.surfaces[surface] = conditionMap[selectedTreatment.value.name] || 'decay';
  } else {
    tooth.surfaces[surface] = 'decay';
  }
}

function getRootPath(type, jaw) {
  const isUpper = jaw === 'upper';
  const paths = {
    molar: isUpper 
      ? 'M 8 0 L 10 18 L 14 24 L 14 0 M 18 0 L 18 20 L 22 26 L 26 20 L 26 0 M 30 0 L 30 24 L 34 18 L 36 0'
      : 'M 8 28 L 10 10 L 14 4 L 14 28 M 18 28 L 18 8 L 22 2 L 26 8 L 26 28 M 30 28 L 30 4 L 34 10 L 36 28',
    premolar: isUpper
      ? 'M 14 0 L 16 20 L 22 26 L 28 20 L 30 0'
      : 'M 14 28 L 16 8 L 22 2 L 28 8 L 30 28',
    canine: isUpper
      ? 'M 16 0 L 18 18 L 22 26 L 26 18 L 28 0'
      : 'M 16 28 L 18 10 L 22 2 L 26 10 L 28 28',
    incisor: isUpper
      ? 'M 18 0 L 19 16 L 22 24 L 25 16 L 26 0'
      : 'M 18 28 L 19 12 L 22 4 L 25 12 L 26 28'
  };
  return paths[type] || paths.molar;
}

function setCondition(condition) {
  if (selectedTooth.value) {
    selectedTooth.value.condition = condition;
    if (condition === 'crown' || condition === 'implant' || condition === 'missing') {
      selectedTooth.value.surfaces = {};
    }
  }
}

function clearCondition() {
  if (selectedTooth.value) {
    selectedTooth.value.condition = null;
    selectedTooth.value.surfaces = {};
  }
}

function getConditionBgClass(condition) {
  const classes = {
    decay: 'bg-red-50 text-red-700',
    filling: 'bg-blue-50 text-blue-700',
    crown: 'bg-amber-50 text-amber-700',
    implant: 'bg-emerald-50 text-emerald-700',
    missing: 'bg-slate-100 text-slate-600'
  };
  return classes[condition] || 'bg-emerald-50 text-emerald-700';
}

function getSurfaceTagClass(condition) {
  const classes = {
    decay: 'bg-red-100 text-red-700',
    filling: 'bg-blue-100 text-blue-700'
  };
  return classes[condition] || 'bg-slate-100 text-slate-600';
}

function hasAffectedSurfaces(tooth) {
  return tooth.surfaces && Object.values(tooth.surfaces).some(v => v);
}

function formatCurrency(amount) {
  return new Intl.NumberFormat('en-GB', { style: 'currency', currency: 'GBP' }).format(amount);
}
</script>

<style scoped>
/* Dental Chart Specific Styles */
.dental-chart-wrapper {
  position: relative;
  padding: 0 40px;
}

.side-label-left,
.side-label-right {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 24px;
  font-weight: 800;
  color: #cbd5e1;
}

.side-label-left {
  left: 0;
}

.side-label-right {
  right: 0;
}

.jaw-section {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.jaw-section.lower {
  margin-top: 8px;
}

.tooth-numbers-row {
  display: flex;
  justify-content: space-between;
  gap: 2px;
  margin: 6px 0;
  width: 100%;
}

.tooth-number {
  /* width: 40px; */
  text-align: center;
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
}

.teeth-row {
  display: flex;
  justify-content: center;
  gap: 2px;
}

.tooth-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  padding: 3px;
  border-radius: 8px;
  transition: all 0.15s ease;
}

.tooth-item:hover {
  background: rgba(20, 184, 166, 0.1);
}

.tooth-item.selected {
  background: rgba(20, 184, 166, 0.2);
  box-shadow: 0 0 0 2px #14b8a6;
}

.tooth-crown-wrapper {
  width: 40px;
  height: 40px;
}

.odontogram-svg {
  width: 100%;
  height: 100%;
}

.surface-path {
  stroke: #94a3b8;
  stroke-width: 1;
  cursor: pointer;
  transition: all 0.15s ease;
}

.surface-path:hover {
  stroke: #14b8a6;
  stroke-width: 2;
}

.surface-path.healthy {
  fill: #ffffff;
}

.surface-path.decay {
  fill: #ef4444;
}

.surface-path.filling {
  fill: #3b82f6;
}

.surface-path.crown {
  fill: #f59e0b;
}

.surface-path.implant {
  fill: #10b981;
}

.surface-path.missing {
  fill: #94a3b8;
}

.implant-label {
  font-size: 8px;
  font-weight: 700;
  fill: white;
}

.missing-cross {
  stroke: #475569;
  stroke-width: 2;
}

.tooth-root {
  width: 40px;
  height: 24px;
}

.tooth-root.upper {
  transform: scaleY(-1);
}

.root-svg {
  width: 100%;
  height: 100%;
}

.root-path {
  fill: none;
  stroke: #94a3b8;
  stroke-width: 1.5;
}

.root-path.root-implant {
  stroke: #10b981;
  stroke-width: 2;
}

.jaw-divider {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 0;
  width: 100%;
}

.divider-text {
  font-size: 12px;
  font-weight: 800;
  color: #94a3b8;
}

.divider-line {
  flex: 1;
  height: 2px;
  background: linear-gradient(90deg, #14b8a6, #06b6d4, #14b8a6);
  opacity: 0.3;
}

/* Responsive Adjustments */
@media (max-width: 1280px) {
  .dental-chart-wrapper {
    padding: 0 20px;
  }
  
  .tooth-crown-wrapper {
    width: 36px;
    height: 36px;
  }
  
  .tooth-root {
    width: 36px;
    height: 20px;
  }
  
  .tooth-number {
    width: 36px;
    font-size: 10px;
  }
}

@media (max-width: 768px) {
  .teeth-row {
    flex-wrap: wrap;
    max-width: 360px;
  }
  
  .tooth-numbers-row {
    flex-wrap: wrap;
    max-width: 360px;
  }
}
</style>
