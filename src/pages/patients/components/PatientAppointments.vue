<template>
  <div class="space-y-6">
    
    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-sm">
            <i class="fas fa-calendar-check text-white text-sm"></i>
          </div>
          <div>
            <h2 class="text-lg font-semibold text-slate-800">Upcoming Appointments</h2>
            <p class="text-xs text-slate-400 mt-0.5">Scheduled visits</p>
          </div>
        </div>
        <div class="sm:ml-auto">
          <button 
            @click="$emit('book-appointment')"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25"
          >
            <i class="fas fa-plus"></i>
            <span>New Appointment</span>
          </button>
        </div>
      </div>
      
      <div class="p-5 space-y-4">
        <div
          v-for="(appointment, index) in upcomingAppointments"
          :key="index"
          class="p-4 rounded-xl border-2 border-slate-200 hover:border-teal-300 hover:bg-teal-50/30 transition-all cursor-pointer group"
        >
          <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
              <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 flex flex-col items-center justify-center text-white shadow-md">
                <span class="text-lg font-bold">{{ appointment.day }}</span>
                <span class="text-[10px] uppercase font-medium">{{ appointment.month }}</span>
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between gap-3 mb-2">
                <div>
                  <h3 class="text-base font-semibold text-slate-800 mb-1">{{ appointment.title }}</h3>
                  <p class="text-sm text-slate-500">{{ appointment.description }}</p>
                </div>
                <span :class="[
                  'px-2.5 py-1 rounded-lg text-xs font-medium',
                  appointment.status === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'
                ]">
                  {{ appointment.status }}
                </span>
              </div>
              <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                <span class="inline-flex items-center gap-1.5">
                  <i class="fas fa-clock text-teal-500"></i>
                  {{ appointment.time }}
                </span>
                <span class="inline-flex items-center gap-1.5">
                  <i class="fas fa-user-md text-cyan-500"></i>
                  {{ appointment.doctor }}
                </span>
                <span class="inline-flex items-center gap-1.5">
                  <i class="fas fa-map-marker-alt text-slate-400"></i>
                  {{ appointment.location }}
                </span>
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <button class="p-2 rounded-lg text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-colors">
                <i class="fas fa-edit text-sm"></i>
              </button>
              <button class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                <i class="fas fa-times text-sm"></i>
              </button>
            </div>
          </div>
        </div>
        
        <div v-if="upcomingAppointments.length === 0" class="text-center py-12">
          <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-calendar-times text-slate-400 text-2xl"></i>
          </div>
          <p class="text-slate-500 font-medium">No upcoming appointments</p>
          <p class="text-sm text-slate-400 mt-1">Schedule a new appointment to get started</p>
        </div>
      </div>
    </div>

    <!-- Past Appointments -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <div class="flex items-center gap-3 p-5 border-b border-slate-100">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center shadow-sm">
          <i class="fas fa-history text-white text-sm"></i>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-slate-800">Appointment History</h3>
          <p class="text-xs text-slate-400">Past visits</p>
        </div>
        <span class="ml-auto px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
          {{ pastAppointments.length }} visits
        </span>
      </div>
      
      <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto">
        <div 
          v-for="(appointment, index) in pastAppointments" 
          :key="index"
          class="p-4 hover:bg-slate-50/50 transition-colors cursor-pointer group"
        >
          <div class="flex items-center justify-between gap-3 mb-2">
            <div class="flex items-center gap-3">
              <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
              <span class="text-sm font-semibold text-slate-700">{{ appointment.title }}</span>
            </div>
            <span class="text-xs text-slate-400">{{ appointment.date }}</span>
          </div>
          <div class="flex items-center gap-4 ml-5 text-xs text-slate-500">
            <span class="inline-flex items-center gap-1">
              <i class="fas fa-user-md"></i>
              {{ appointment.doctor }}
            </span>
            <span class="inline-flex items-center gap-1">
              <i class="fas fa-clock"></i>
              {{ appointment.time }}
            </span>
          </div>
          <p v-if="appointment.notes" class="text-xs text-slate-400 mt-2 ml-5 p-2 bg-slate-50 rounded-lg">
            {{ appointment.notes }}
          </p>
        </div>
      </div>
    </div>

    <!-- Appointment Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-5 rounded-xl border border-teal-200/50">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center">
            <i class="fas fa-calendar-check text-teal-600"></i>
          </div>
          <div>
            <p class="text-xs font-medium text-teal-600 uppercase tracking-wide">Total Visits</p>
            <p class="text-2xl font-bold text-teal-700">{{ stats.totalVisits }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-violet-50 to-purple-50 p-5 rounded-xl border border-violet-200/50">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center">
            <i class="fas fa-calendar-times text-violet-600"></i>
          </div>
          <div>
            <p class="text-xs font-medium text-violet-600 uppercase tracking-wide">Missed</p>
            <p class="text-2xl font-bold text-violet-700">{{ stats.missed }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-xl border border-amber-200/50">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center">
            <i class="fas fa-clock text-amber-600"></i>
          </div>
          <div>
            <p class="text-xs font-medium text-amber-600 uppercase tracking-wide">Upcoming</p>
            <p class="text-2xl font-bold text-amber-700">{{ stats.upcoming }}</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'PatientAppointments',
  props: {
    patient: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      upcomingAppointments: [
        {
          day: '28',
          month: 'Dec',
          title: 'Regular Check-up',
          description: 'Routine dental examination and cleaning',
          time: '10:30 AM',
          doctor: 'Dr. Sarah Johnson',
          location: 'Room 3',
          status: 'confirmed'
        },
        {
          day: '15',
          month: 'Jan',
          title: 'Root Canal Treatment',
          description: 'Continuation of root canal therapy',
          time: '02:00 PM',
          doctor: 'Dr. Michael Chen',
          location: 'Room 1',
          status: 'pending'
        }
      ],
      pastAppointments: [
        {
          date: '2024-12-20',
          title: 'Tooth Filling',
          doctor: 'Dr. Sarah Johnson',
          time: '09:00 AM',
          notes: 'Composite filling on tooth #14. Patient tolerated procedure well.'
        },
        {
          date: '2024-11-15',
          title: 'Dental Cleaning',
          doctor: 'Dr. Emily White',
          time: '11:30 AM',
          notes: 'Routine scaling and polishing completed.'
        },
        {
          date: '2024-10-10',
          title: 'Consultation',
          doctor: 'Dr. Michael Chen',
          time: '03:00 PM',
          notes: 'Initial consultation for orthodontic treatment.'
        },
        {
          date: '2024-09-05',
          title: 'X-Ray Examination',
          doctor: 'Dr. Sarah Johnson',
          time: '01:00 PM',
          notes: 'Panoramic X-ray taken. No significant findings.'
        }
      ],
      stats: {
        totalVisits: 24,
        missed: 2,
        upcoming: 2
      }
    };
  }
};
</script>


