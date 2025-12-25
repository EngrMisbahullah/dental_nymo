<template>
  <div class="space-y-6">
    
    <!-- Clinical Notes List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
            <i class="fas fa-notes-medical text-white text-sm"></i>
          </div>
          <div>
            <h2 class="text-lg font-semibold text-slate-800">Clinical Notes</h2>
            <p class="text-xs text-slate-400 mt-0.5">Medical history and documentation</p>
          </div>
        </div>
        <div class="sm:ml-auto">
          <button 
            @click="$emit('add-note')"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25"
          >
            <i class="fas fa-plus"></i>
            <span>New Note</span>
          </button>
        </div>
      </div>
      
      <!-- Filter Tabs -->
      <div class="flex gap-2 p-4 border-b border-slate-100 overflow-x-auto">
        <button
          v-for="filter in filters"
          :key="filter"
          :class="[
            'px-4 py-2 rounded-lg text-xs font-medium whitespace-nowrap transition-all',
            activeFilter === filter 
              ? 'bg-teal-500 text-white shadow-md' 
              : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
          ]"
          @click="activeFilter = filter"
        >
          {{ filter }}
        </button>
      </div>
      
      <div class="p-5 space-y-4">
        <div
          v-for="(note, index) in filteredNotes"
          :key="index"
          class="p-5 rounded-xl border-2 border-slate-200 hover:border-violet-300 hover:bg-violet-50/20 transition-all cursor-pointer"
        >
          <!-- Note Header -->
          <div class="flex items-start justify-between gap-3 mb-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-100 to-purple-100 flex items-center justify-center">
                <i class="fas fa-user-md text-violet-600"></i>
              </div>
              <div>
                <p class="text-sm font-semibold text-slate-700">{{ note.doctor }}</p>
                <p class="text-xs text-slate-400">{{ note.date }} · {{ note.time }}</p>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <span :class="[
                'px-2.5 py-1 rounded-lg text-xs font-medium',
                note.type === 'SOAP' ? 'bg-teal-100 text-teal-700' :
                note.type === 'Treatment' ? 'bg-amber-100 text-amber-700' :
                note.type === 'Consultation' ? 'bg-blue-100 text-blue-700' :
                'bg-slate-100 text-slate-700'
              ]">
                {{ note.type }}
              </span>
              <button class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                <i class="fas fa-ellipsis-v text-sm"></i>
              </button>
            </div>
          </div>

          <!-- SOAP Content -->
          <div v-if="note.type === 'SOAP'" class="space-y-3">
            <div class="flex gap-3">
              <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-teal-100 text-teal-700 text-xs font-bold">
                  S
                </span>
              </div>
              <div class="flex-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Subjective</p>
                <p class="text-sm text-slate-700 leading-relaxed">{{ note.subjective }}</p>
              </div>
            </div>
            
            <div class="flex gap-3">
              <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-cyan-100 text-cyan-700 text-xs font-bold">
                  O
                </span>
              </div>
              <div class="flex-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Objective</p>
                <p class="text-sm text-slate-700 leading-relaxed">{{ note.objective }}</p>
              </div>
            </div>
            
            <div class="flex gap-3">
              <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-violet-100 text-violet-700 text-xs font-bold">
                  A
                </span>
              </div>
              <div class="flex-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Assessment</p>
                <p class="text-sm text-slate-700 leading-relaxed">{{ note.assessment }}</p>
              </div>
            </div>
            
            <div class="flex gap-3">
              <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">
                  P
                </span>
              </div>
              <div class="flex-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Plan</p>
                <p class="text-sm text-slate-700 leading-relaxed">{{ note.plan }}</p>
              </div>
            </div>
          </div>

          <!-- Regular Note Content -->
          <div v-else>
            <h4 class="text-sm font-semibold text-slate-700 mb-2">{{ note.title }}</h4>
            <p class="text-sm text-slate-600 leading-relaxed">{{ note.content }}</p>
          </div>

          <!-- Note Footer -->
          <div class="flex items-center gap-4 mt-4 pt-4 border-t border-slate-100">
            <button class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-teal-600 transition-colors">
              <i class="fas fa-paperclip"></i>
              {{ note.attachments || 0 }} Attachments
            </button>
            <button class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-violet-600 transition-colors">
              <i class="fas fa-edit"></i>
              Edit
            </button>
            <button class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-600 transition-colors">
              <i class="fas fa-share"></i>
              Share
            </button>
          </div>
        </div>

        <div v-if="filteredNotes.length === 0" class="text-center py-12">
          <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-file-medical text-slate-400 text-2xl"></i>
          </div>
          <p class="text-slate-500 font-medium">No clinical notes found</p>
          <p class="text-sm text-slate-400 mt-1">Add a new note to start documenting</p>
        </div>
      </div>
    </div>

    <!-- Treatment Summary -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <div class="flex items-center gap-3 p-5 border-b border-slate-100">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center shadow-sm">
          <i class="fas fa-clipboard-list text-white text-sm"></i>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-slate-800">Treatment Summary</h3>
          <p class="text-xs text-slate-400">Current and past treatments</p>
        </div>
      </div>
      
      <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="p-4 rounded-xl bg-gradient-to-br from-teal-50 to-cyan-50 border border-teal-200/50">
            <div class="flex items-center gap-3 mb-2">
              <i class="fas fa-tooth text-teal-600"></i>
              <p class="text-xs font-medium text-teal-700 uppercase tracking-wide">Procedures Done</p>
            </div>
            <p class="text-2xl font-bold text-teal-700">{{ treatments.completed }}</p>
          </div>
          
          <div class="p-4 rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200/50">
            <div class="flex items-center gap-3 mb-2">
              <i class="fas fa-calendar-alt text-amber-600"></i>
              <p class="text-xs font-medium text-amber-700 uppercase tracking-wide">In Progress</p>
            </div>
            <p class="text-2xl font-bold text-amber-700">{{ treatments.inProgress }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Medical Alerts -->
    <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl border border-red-200 p-5">
      <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
          <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
          </div>
        </div>
        <div class="flex-1">
          <h3 class="text-sm font-semibold text-red-800 mb-2">Medical Alerts & Allergies</h3>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="alert in medicalAlerts"
              :key="alert"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white text-red-700 border border-red-200"
            >
              <i class="fas fa-exclamation-circle"></i>
              {{ alert }}
            </span>
          </div>
          <p v-if="medicalAlerts.length === 0" class="text-sm text-red-700/70">No known allergies or alerts</p>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'PatientClinicalNotes',
  props: {
    patient: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      activeFilter: 'All Notes',
      filters: ['All Notes', 'SOAP', 'Treatment', 'Consultation', 'Emergency'],
      clinicalNotes: [
        {
          id: 1,
          type: 'SOAP',
          doctor: 'Dr. Sarah Johnson',
          date: '2024-12-20',
          time: '09:00 AM',
          subjective: 'Patient complains of sensitivity in upper right molar. Pain increases with cold beverages. No spontaneous pain.',
          objective: 'Clinical examination reveals recurrent decay around existing amalgam restoration on tooth #3. Slight percussion sensitivity. X-ray shows decay extending to middle third of dentin.',
          assessment: 'Recurrent caries tooth #3. Secondary decay under amalgam restoration. Reversible pulpitis.',
          plan: 'Remove existing restoration. Excavate decay. Composite restoration if pulp not exposed. Recommend desensitizing toothpaste. Follow-up in 2 weeks if symptoms persist.',
          attachments: 2
        },
        {
          id: 2,
          type: 'Treatment',
          doctor: 'Dr. Michael Chen',
          date: '2024-11-15',
          time: '02:00 PM',
          title: 'Root Canal Treatment - Tooth #14',
          content: 'Successful completion of root canal therapy on tooth #14. Access cavity prepared, working length determined using apex locator. Cleaning and shaping completed using rotary NiTi files. Obturation with gutta-percha using lateral condensation technique. Post-operative X-ray confirms adequate fill. Patient advised about temporary sensitivity and prescribed antibiotics.',
          attachments: 3
        },
        {
          id: 3,
          type: 'Consultation',
          doctor: 'Dr. Emily White',
          date: '2024-10-10',
          time: '11:30 AM',
          title: 'Orthodontic Consultation',
          content: 'Initial orthodontic assessment. Patient presents with Class II malocclusion, overjet 6mm, overbite 4mm. Crowding in lower anterior region. Discussed treatment options including traditional braces and clear aligners. Treatment duration estimated 18-24 months. Records taken: photographs, impressions for study models, cephalometric X-ray.',
          attachments: 5
        }
      ],
      treatments: {
        completed: 12,
        inProgress: 2
      },
      medicalAlerts: ['Penicillin Allergy', 'Latex Sensitivity']
    };
  },
  computed: {
    filteredNotes() {
      if (this.activeFilter === 'All Notes') {
        return this.clinicalNotes;
      }
      return this.clinicalNotes.filter(note => note.type === this.activeFilter);
    }
  }
};
</script>


