<template>
  <div class="space-y-6">
    
    <!-- Financial Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-5 rounded-xl border border-emerald-200/50">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center shadow-sm">
            <i class="fas fa-check-circle text-emerald-600"></i>
          </div>
          <div>
            <p class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Total Paid</p>
            <p class="text-2xl font-bold text-emerald-700">£{{ financialSummary.totalPaid.toFixed(2) }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-xl border border-amber-200/50">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center shadow-sm">
            <i class="fas fa-clock text-amber-600"></i>
          </div>
          <div>
            <p class="text-xs font-medium text-amber-600 uppercase tracking-wide">Outstanding</p>
            <p class="text-2xl font-bold text-amber-700">£{{ financialSummary.outstanding.toFixed(2) }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-5 rounded-xl border border-blue-200/50">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center shadow-sm">
            <i class="fas fa-chart-line text-blue-600"></i>
          </div>
          <div>
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wide">Total Billed</p>
            <p class="text-2xl font-bold text-blue-700">£{{ financialSummary.totalBilled.toFixed(2) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Invoices List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50/50 to-transparent">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center shadow-sm">
            <i class="fas fa-file-invoice-dollar text-white text-sm"></i>
          </div>
          <div>
            <h2 class="text-lg font-semibold text-slate-800">Invoices & Payments</h2>
            <p class="text-xs text-slate-400 mt-0.5">Billing history and transactions</p>
          </div>
        </div>
        <div class="sm:ml-auto flex gap-2">
          <button 
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl cursor-pointer transition-all duration-200 hover:bg-slate-50 hover:border-slate-300"
          >
            <i class="fas fa-download"></i>
            <span class="hidden sm:inline">Export</span>
          </button>
          <button 
            @click="$emit('create-invoice')"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl cursor-pointer transition-all duration-200 hover:from-teal-600 hover:to-cyan-600 shadow-md shadow-teal-500/25"
          >
            <i class="fas fa-plus"></i>
            <span>New Invoice</span>
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
      
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
              <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Invoice #</th>
              <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
              <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</th>
              <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
              <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
              <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr 
              v-for="invoice in filteredInvoices" 
              :key="invoice.id"
              class="hover:bg-slate-50/50 transition-colors"
            >
              <td class="px-5 py-4">
                <div class="flex items-center gap-2">
                  <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i class="fas fa-file-alt text-slate-500 text-xs"></i>
                  </div>
                  <span class="text-sm font-medium text-slate-700">{{ invoice.number }}</span>
                </div>
              </td>
              <td class="px-5 py-4 text-sm text-slate-600">{{ invoice.date }}</td>
              <td class="px-5 py-4">
                <div>
                  <p class="text-sm font-medium text-slate-700">{{ invoice.description }}</p>
                  <p class="text-xs text-slate-400 mt-0.5">{{ invoice.items }} items</p>
                </div>
              </td>
              <td class="px-5 py-4">
                <p class="text-sm font-semibold text-slate-700">£{{ invoice.amount.toFixed(2) }}</p>
                <p v-if="invoice.paid < invoice.amount" class="text-xs text-amber-600">
                  £{{ (invoice.amount - invoice.paid).toFixed(2) }} due
                </p>
              </td>
              <td class="px-5 py-4">
                <span :class="[
                  'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium',
                  invoice.status === 'paid' ? 'bg-emerald-100 text-emerald-700' :
                  invoice.status === 'partial' ? 'bg-amber-100 text-amber-700' :
                  invoice.status === 'overdue' ? 'bg-red-100 text-red-700' :
                  'bg-slate-100 text-slate-700'
                ]">
                  <i :class="[
                    'fas text-[10px]',
                    invoice.status === 'paid' ? 'fa-check-circle' :
                    invoice.status === 'partial' ? 'fa-clock' :
                    invoice.status === 'overdue' ? 'fa-exclamation-triangle' :
                    'fa-circle'
                  ]"></i>
                  {{ invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1) }}
                </span>
              </td>
              <td class="px-5 py-4">
                <div class="flex items-center gap-2">
                  <button 
                    @click="viewInvoice(invoice)"
                    class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                    title="View"
                  >
                    <i class="fas fa-eye text-sm"></i>
                  </button>
                  <button 
                    class="p-2 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-colors"
                    title="Download"
                  >
                    <i class="fas fa-download text-sm"></i>
                  </button>
                  <button 
                    v-if="invoice.status !== 'paid'"
                    @click="recordPayment(invoice)"
                    class="p-2 rounded-lg text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-colors"
                    title="Record Payment"
                  >
                    <i class="fas fa-cash-register text-sm"></i>
                  </button>
                  <button 
                    class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                    title="More options"
                  >
                    <i class="fas fa-ellipsis-v text-sm"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="filteredInvoices.length === 0" class="text-center py-12">
        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-receipt text-slate-400 text-2xl"></i>
        </div>
        <p class="text-slate-500 font-medium">No invoices found</p>
        <p class="text-sm text-slate-400 mt-1">Create a new invoice to get started</p>
      </div>
    </div>

    <!-- Payment History -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
      <div class="flex items-center gap-3 p-5 border-b border-slate-100">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center shadow-sm">
          <i class="fas fa-history text-white text-sm"></i>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-slate-800">Payment History</h3>
          <p class="text-xs text-slate-400">Recent transactions</p>
        </div>
        <span class="ml-auto px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
          {{ paymentHistory.length }} payments
        </span>
      </div>
      
      <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto">
        <div 
          v-for="(payment, index) in paymentHistory" 
          :key="index"
          class="p-4 hover:bg-slate-50/50 transition-colors"
        >
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <div :class="[
                'w-10 h-10 rounded-lg flex items-center justify-center',
                payment.method === 'Card' ? 'bg-blue-100' :
                payment.method === 'Cash' ? 'bg-green-100' :
                payment.method === 'Bank Transfer' ? 'bg-purple-100' :
                'bg-slate-100'
              ]">
                <i :class="[
                  'fas',
                  payment.method === 'Card' ? 'fa-credit-card text-blue-600' :
                  payment.method === 'Cash' ? 'fa-money-bill text-green-600' :
                  payment.method === 'Bank Transfer' ? 'fa-university text-purple-600' :
                  'fa-wallet text-slate-600'
                ]"></i>
              </div>
              <div>
                <p class="text-sm font-semibold text-slate-700">£{{ payment.amount.toFixed(2) }}</p>
                <div class="flex items-center gap-2 mt-0.5">
                  <span class="text-xs text-slate-500">{{ payment.method }}</span>
                  <span class="text-xs text-slate-300">•</span>
                  <span class="text-xs text-slate-400">{{ payment.date }}</span>
                </div>
              </div>
            </div>
            <div class="text-right">
              <p class="text-xs text-slate-500">{{ payment.invoice }}</p>
              <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-emerald-100 text-emerald-700 mt-1">
                <i class="fas fa-check text-[8px]"></i>
                Received
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Methods -->
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl border border-slate-200 p-5">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-9 h-9 rounded-xl bg-slate-700 flex items-center justify-center">
          <i class="fas fa-credit-card text-white text-sm"></i>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-slate-800">Saved Payment Methods</h3>
          <p class="text-xs text-slate-500">Manage payment options</p>
        </div>
      </div>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="bg-white p-4 rounded-xl border border-slate-200">
          <div class="flex items-center justify-between mb-3">
            <i class="fab fa-cc-visa text-2xl text-blue-600"></i>
            <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-emerald-100 text-emerald-700">
              Primary
            </span>
          </div>
          <p class="text-sm font-semibold text-slate-700">•••• 4532</p>
          <p class="text-xs text-slate-400 mt-1">Expires 12/25</p>
        </div>
        
        <button class="bg-white p-4 rounded-xl border-2 border-dashed border-slate-200 hover:border-teal-300 hover:bg-teal-50/30 transition-all flex flex-col items-center justify-center gap-2 cursor-pointer">
          <i class="fas fa-plus text-slate-400 text-xl"></i>
          <span class="text-sm font-medium text-slate-600">Add Payment Method</span>
        </button>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'PatientInvoices',
  props: {
    patient: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      activeFilter: 'All Invoices',
      filters: ['All Invoices', 'Paid', 'Pending', 'Overdue'],
      financialSummary: {
        totalPaid: 2450.00,
        outstanding: 380.00,
        totalBilled: 2830.00
      },
      invoices: [
        {
          id: 1,
          number: 'INV-2024-001',
          date: '2024-12-20',
          description: 'Dental Filling - Tooth #14',
          items: 2,
          amount: 180.00,
          paid: 180.00,
          status: 'paid'
        },
        {
          id: 2,
          number: 'INV-2024-002',
          date: '2024-12-15',
          description: 'Root Canal Treatment',
          items: 3,
          amount: 450.00,
          paid: 450.00,
          status: 'paid'
        },
        {
          id: 3,
          number: 'INV-2024-003',
          date: '2024-11-28',
          description: 'Dental Cleaning & Examination',
          items: 2,
          amount: 120.00,
          paid: 60.00,
          status: 'partial'
        },
        {
          id: 4,
          number: 'INV-2024-004',
          date: '2024-10-15',
          description: 'Crown Preparation',
          items: 4,
          amount: 680.00,
          paid: 0,
          status: 'overdue'
        },
        {
          id: 5,
          number: 'INV-2024-005',
          date: '2024-09-20',
          description: 'Orthodontic Consultation',
          items: 1,
          amount: 80.00,
          paid: 80.00,
          status: 'paid'
        }
      ],
      paymentHistory: [
        {
          amount: 180.00,
          method: 'Card',
          date: '2024-12-20',
          invoice: 'INV-2024-001'
        },
        {
          amount: 450.00,
          method: 'Bank Transfer',
          date: '2024-12-15',
          invoice: 'INV-2024-002'
        },
        {
          amount: 60.00,
          method: 'Cash',
          date: '2024-11-28',
          invoice: 'INV-2024-003'
        },
        {
          amount: 80.00,
          method: 'Card',
          date: '2024-09-20',
          invoice: 'INV-2024-005'
        }
      ]
    };
  },
  computed: {
    filteredInvoices() {
      if (this.activeFilter === 'All Invoices') {
        return this.invoices;
      }
      const filter = this.activeFilter.toLowerCase();
      return this.invoices.filter(invoice => invoice.status === filter || 
        (filter === 'pending' && invoice.status === 'partial'));
    }
  },
  methods: {
    viewInvoice(invoice) {
      console.log('View invoice:', invoice);
      // Implement view invoice logic
    },
    recordPayment(invoice) {
      console.log('Record payment for:', invoice);
      // Implement record payment logic
    }
  }
};
</script>


