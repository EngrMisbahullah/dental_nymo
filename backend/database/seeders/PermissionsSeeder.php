<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // DASHBOARD
            ['permission_key' => 'dashboard.view_own', 'module' => 'dashboard', 'description' => 'View personal dashboard'],
            ['permission_key' => 'dashboard.view_practice', 'module' => 'dashboard', 'description' => 'View practice-wide dashboard'],
            ['permission_key' => 'dashboard.view_provider', 'module' => 'dashboard', 'description' => 'View specific provider dashboards'],
            ['permission_key' => 'dashboard.view_analytics', 'module' => 'dashboard', 'description' => 'View advanced analytics'],

            // PATIENTS
            ['permission_key' => 'patients.view', 'module' => 'patients', 'description' => 'View patient list and search'],
            ['permission_key' => 'patients.view_demographics', 'module' => 'patients', 'description' => 'View patient demographics'],
            ['permission_key' => 'patients.view_medical_history', 'module' => 'patients', 'description' => 'View medical history'],
            ['permission_key' => 'patients.create', 'module' => 'patients', 'description' => 'Create new patients'],
            ['permission_key' => 'patients.edit', 'module' => 'patients', 'description' => 'Edit patient information'],
            ['permission_key' => 'patients.delete', 'module' => 'patients', 'description' => 'Delete/archive patients'],
            ['permission_key' => 'patients.merge', 'module' => 'patients', 'description' => 'Merge duplicate patients'],
            ['permission_key' => 'patients.export', 'module' => 'patients', 'description' => 'Export patient data'],
            ['permission_key' => 'patients.view_family', 'module' => 'patients', 'description' => 'View family relationships'],
            ['permission_key' => 'patients.manage_family', 'module' => 'patients', 'description' => 'Manage family accounts'],

            // APPOINTMENTS
            ['permission_key' => 'appointments.view_own', 'module' => 'appointments', 'description' => 'View own appointments'],
            ['permission_key' => 'appointments.view_all', 'module' => 'appointments', 'description' => 'View all appointments'],
            ['permission_key' => 'appointments.view_provider', 'module' => 'appointments', 'description' => 'View specific provider appointments'],
            ['permission_key' => 'appointments.create', 'module' => 'appointments', 'description' => 'Create appointments'],
            ['permission_key' => 'appointments.edit', 'module' => 'appointments', 'description' => 'Edit appointments'],
            ['permission_key' => 'appointments.delete', 'module' => 'appointments', 'description' => 'Delete appointments'],
            ['permission_key' => 'appointments.reschedule', 'module' => 'appointments', 'description' => 'Reschedule appointments'],
            ['permission_key' => 'appointments.confirm', 'module' => 'appointments', 'description' => 'Confirm appointments'],
            ['permission_key' => 'appointments.check_in', 'module' => 'appointments', 'description' => 'Check-in patients'],
            ['permission_key' => 'appointments.manage_waiting_room', 'module' => 'appointments', 'description' => 'Manage waiting room'],
            ['permission_key' => 'appointments.block_time', 'module' => 'appointments', 'description' => 'Block schedule time'],
            ['permission_key' => 'appointments.view_operatory', 'module' => 'appointments', 'description' => 'View operatory schedule'],
            ['permission_key' => 'appointments.assign_operatory', 'module' => 'appointments', 'description' => 'Assign operatories'],

            // CLINICAL_CHART
            ['permission_key' => 'chart.view', 'module' => 'chart', 'description' => 'View dental charts'],
            ['permission_key' => 'chart.edit', 'module' => 'chart', 'description' => 'Edit dental charts'],
            ['permission_key' => 'chart.view_history', 'module' => 'chart', 'description' => 'View chart history'],
            ['permission_key' => 'chart.view_conditions', 'module' => 'chart', 'description' => 'View existing conditions'],
            ['permission_key' => 'chart.add_conditions', 'module' => 'chart', 'description' => 'Add conditions/findings'],
            ['permission_key' => 'chart.edit_conditions', 'module' => 'chart', 'description' => 'Edit conditions'],
            ['permission_key' => 'chart.view_perio', 'module' => 'chart', 'description' => 'View periodontal charting'],
            ['permission_key' => 'chart.edit_perio', 'module' => 'chart', 'description' => 'Edit periodontal charting'],
            ['permission_key' => 'chart.view_soft_tissue', 'module' => 'chart', 'description' => 'View soft tissue exam'],
            ['permission_key' => 'chart.edit_soft_tissue', 'module' => 'chart', 'description' => 'Edit soft tissue exam'],

            // CLINICAL_NOTES
            ['permission_key' => 'notes.view', 'module' => 'notes', 'description' => 'View clinical notes'],
            ['permission_key' => 'notes.create', 'module' => 'notes', 'description' => 'Create clinical notes'],
            ['permission_key' => 'notes.edit', 'module' => 'notes', 'description' => 'Edit clinical notes'],
            ['permission_key' => 'notes.delete', 'module' => 'notes', 'description' => 'Delete clinical notes'],
            ['permission_key' => 'notes.sign', 'module' => 'notes', 'description' => 'Sign/lock clinical notes'],
            ['permission_key' => 'notes.view_all_providers', 'module' => 'notes', 'description' => 'View all providers notes'],

            // TREATMENT_PLANS
            ['permission_key' => 'treatment_plan.view', 'module' => 'treatment_plan', 'description' => 'View treatment plans'],
            ['permission_key' => 'treatment_plan.create', 'module' => 'treatment_plan', 'description' => 'Create treatment plans'],
            ['permission_key' => 'treatment_plan.edit', 'module' => 'treatment_plan', 'description' => 'Edit treatment plans'],
            ['permission_key' => 'treatment_plan.delete', 'module' => 'treatment_plan', 'description' => 'Delete treatment plans'],
            ['permission_key' => 'treatment_plan.present', 'module' => 'treatment_plan', 'description' => 'Present to patients'],
            ['permission_key' => 'treatment_plan.accept', 'module' => 'treatment_plan', 'description' => 'Mark as accepted'],
            ['permission_key' => 'treatment_plan.schedule', 'module' => 'treatment_plan', 'description' => 'Schedule treatment'],

            // IMAGING
            ['permission_key' => 'imaging.view', 'module' => 'imaging', 'description' => 'View images/X-rays'],
            ['permission_key' => 'imaging.upload', 'module' => 'imaging', 'description' => 'Upload images'],
            ['permission_key' => 'imaging.edit', 'module' => 'imaging', 'description' => 'Edit/annotate images'],
            ['permission_key' => 'imaging.delete', 'module' => 'imaging', 'description' => 'Delete images'],
            ['permission_key' => 'imaging.share', 'module' => 'imaging', 'description' => 'Share images externally'],
            ['permission_key' => 'imaging.ai_diagnosis', 'module' => 'imaging', 'description' => 'Access AI diagnosis tools'],
            ['permission_key' => 'imaging.export', 'module' => 'imaging', 'description' => 'Export images'],
            ['permission_key' => 'imaging.print', 'module' => 'imaging', 'description' => 'Print images'],

            // PRESCRIPTIONS
            ['permission_key' => 'prescriptions.view', 'module' => 'prescriptions', 'description' => 'View prescription history'],
            ['permission_key' => 'prescriptions.create', 'module' => 'prescriptions', 'description' => 'Create prescriptions (requires DEA)'],
            ['permission_key' => 'prescriptions.edit', 'module' => 'prescriptions', 'description' => 'Edit pending prescriptions'],
            ['permission_key' => 'prescriptions.delete', 'module' => 'prescriptions', 'description' => 'Delete pending prescriptions'],
            ['permission_key' => 'prescriptions.controlled_substances', 'module' => 'prescriptions', 'description' => 'Prescribe controlled substances (requires EPCS)'],
            ['permission_key' => 'prescriptions.view_drug_interactions', 'module' => 'prescriptions', 'description' => 'View drug interaction alerts'],

            // FINANCIALS
            ['permission_key' => 'financials.view_patient_balance', 'module' => 'financials', 'description' => 'View patient balances'],
            ['permission_key' => 'financials.view_production', 'module' => 'financials', 'description' => 'View production reports'],
            ['permission_key' => 'financials.view_collections', 'module' => 'financials', 'description' => 'View collection reports'],
            ['permission_key' => 'financials.view_ar_aging', 'module' => 'financials', 'description' => 'View A/R aging'],
            ['permission_key' => 'financials.post_payment', 'module' => 'financials', 'description' => 'Post payments'],
            ['permission_key' => 'financials.post_adjustment', 'module' => 'financials', 'description' => 'Post adjustments'],
            ['permission_key' => 'financials.post_refund', 'module' => 'financials', 'description' => 'Process refunds'],
            ['permission_key' => 'financials.void_transaction', 'module' => 'financials', 'description' => 'Void transactions'],
            ['permission_key' => 'financials.view_ledger', 'module' => 'financials', 'description' => 'View patient ledger'],
            ['permission_key' => 'financials.print_statement', 'module' => 'financials', 'description' => 'Print patient statements'],
            ['permission_key' => 'financials.manage_payment_plans', 'module' => 'financials', 'description' => 'Create payment plans'],

            // INSURANCE
            ['permission_key' => 'insurance.view', 'module' => 'insurance', 'description' => 'View insurance information'],
            ['permission_key' => 'insurance.edit', 'module' => 'insurance', 'description' => 'Edit insurance information'],
            ['permission_key' => 'insurance.verify_eligibility', 'module' => 'insurance', 'description' => 'Verify eligibility'],
            ['permission_key' => 'insurance.create_claim', 'module' => 'insurance', 'description' => 'Create insurance claims'],
            ['permission_key' => 'insurance.submit_claim', 'module' => 'insurance', 'description' => 'Submit claims'],
            ['permission_key' => 'insurance.view_claim_status', 'module' => 'insurance', 'description' => 'View claim status'],
            ['permission_key' => 'insurance.post_insurance_payment', 'module' => 'insurance', 'description' => 'Post insurance payments'],
            ['permission_key' => 'insurance.manage_era', 'module' => 'insurance', 'description' => 'Manage ERA (Electronic Remittance)'],
            ['permission_key' => 'insurance.manage_preauth', 'module' => 'insurance', 'description' => 'Manage pre-authorizations'],
            ['permission_key' => 'insurance.appeal_denial', 'module' => 'insurance', 'description' => 'Appeal denied claims'],

            // LAB_CASES
            ['permission_key' => 'lab.view', 'module' => 'lab', 'description' => 'View lab cases'],
            ['permission_key' => 'lab.create', 'module' => 'lab', 'description' => 'Create lab cases'],
            ['permission_key' => 'lab.edit', 'module' => 'lab', 'description' => 'Edit lab cases'],
            ['permission_key' => 'lab.update_status', 'module' => 'lab', 'description' => 'Update lab case status'],
            ['permission_key' => 'lab.complete', 'module' => 'lab', 'description' => 'Mark lab case complete'],
            ['permission_key' => 'lab.view_all', 'module' => 'lab', 'description' => 'View all practice lab cases'],

            // REFERRALS
            ['permission_key' => 'referrals.view', 'module' => 'referrals', 'description' => 'View referrals'],
            ['permission_key' => 'referrals.create', 'module' => 'referrals', 'description' => 'Create referrals'],
            ['permission_key' => 'referrals.edit', 'module' => 'referrals', 'description' => 'Edit referrals'],
            ['permission_key' => 'referrals.track', 'module' => 'referrals', 'description' => 'Track referral status'],
            ['permission_key' => 'referrals.view_reports', 'module' => 'referrals', 'description' => 'View referral reports'],

            // REPORTS
            ['permission_key' => 'reports.view_basic', 'module' => 'reports', 'description' => 'View basic reports'],
            ['permission_key' => 'reports.view_financial', 'module' => 'reports', 'description' => 'View financial reports'],
            ['permission_key' => 'reports.view_production', 'module' => 'reports', 'description' => 'View production reports'],
            ['permission_key' => 'reports.view_clinical', 'module' => 'reports', 'description' => 'View clinical reports'],
            ['permission_key' => 'reports.view_marketing', 'module' => 'reports', 'description' => 'View marketing reports'],
            ['permission_key' => 'reports.create_custom', 'module' => 'reports', 'description' => 'Create custom reports'],
            ['permission_key' => 'reports.export', 'module' => 'reports', 'description' => 'Export reports'],
            ['permission_key' => 'reports.schedule', 'module' => 'reports', 'description' => 'Schedule automated reports'],
            ['permission_key' => 'reports.sql_query', 'module' => 'reports', 'description' => 'Run SQL queries'],

            // COMMUNICATION
            ['permission_key' => 'communication.send_sms', 'module' => 'communication', 'description' => 'Send SMS messages'],
            ['permission_key' => 'communication.send_email', 'module' => 'communication', 'description' => 'Send emails'],
            ['permission_key' => 'communication.view_history', 'module' => 'communication', 'description' => 'View communication history'],
            ['permission_key' => 'communication.two_way_text', 'module' => 'communication', 'description' => 'Two-way texting'],
            ['permission_key' => 'communication.mass_email', 'module' => 'communication', 'description' => 'Send mass emails'],
            ['permission_key' => 'communication.manage_campaigns', 'module' => 'communication', 'description' => 'Manage marketing campaigns'],

            // STAFF_MANAGEMENT
            ['permission_key' => 'staff.view', 'module' => 'staff', 'description' => 'View staff list'],
            ['permission_key' => 'staff.create', 'module' => 'staff', 'description' => 'Add staff'],
            ['permission_key' => 'staff.edit', 'module' => 'staff', 'description' => 'Edit staff information'],
            ['permission_key' => 'staff.delete', 'module' => 'staff', 'description' => 'Remove staff'],
            ['permission_key' => 'staff.manage_schedule', 'module' => 'staff', 'description' => 'Manage staff schedules'],

            // PRACTICE_SETTINGS
            ['permission_key' => 'settings.view', 'module' => 'settings', 'description' => 'View practice settings'],
            ['permission_key' => 'settings.edit', 'module' => 'settings', 'description' => 'Edit practice settings'],
            ['permission_key' => 'settings.view_integrations', 'module' => 'settings', 'description' => 'View integrations'],
            ['permission_key' => 'settings.manage_integrations', 'module' => 'settings', 'description' => 'Manage integrations'],
            ['permission_key' => 'settings.manage_operatories', 'module' => 'settings', 'description' => 'Manage operatories'],
            ['permission_key' => 'settings.manage_appointment_types', 'module' => 'settings', 'description' => 'Manage appointment types'],
            ['permission_key' => 'settings.manage_fee_schedule', 'module' => 'settings', 'description' => 'Manage fee schedules'],
            ['permission_key' => 'settings.manage_insurance_plans', 'module' => 'settings', 'description' => 'Manage insurance plans'],

            // USER_MANAGEMENT
            ['permission_key' => 'users.view', 'module' => 'users', 'description' => 'View users'],
            ['permission_key' => 'users.create', 'module' => 'users', 'description' => 'Create users'],
            ['permission_key' => 'users.edit', 'module' => 'users', 'description' => 'Edit users'],
            ['permission_key' => 'users.delete', 'module' => 'users', 'description' => 'Delete users'],
            ['permission_key' => 'users.manage_roles', 'module' => 'users', 'description' => 'Assign roles'],
            ['permission_key' => 'users.manage_permissions', 'module' => 'users', 'description' => 'Manage custom permissions'],
            ['permission_key' => 'users.view_audit_log', 'module' => 'users', 'description' => 'View audit logs'],
            ['permission_key' => 'users.reset_password', 'module' => 'users', 'description' => 'Reset user passwords'],

            // PATIENT_PORTAL
            ['permission_key' => 'portal.access', 'module' => 'portal', 'description' => 'Access patient portal'],
            ['permission_key' => 'portal.view_appointments', 'module' => 'portal', 'description' => 'View own appointments'],
            ['permission_key' => 'portal.request_appointment', 'module' => 'portal', 'description' => 'Request appointments'],
            ['permission_key' => 'portal.view_treatment_history', 'module' => 'portal', 'description' => 'View treatment history'],
            ['permission_key' => 'portal.view_invoices', 'module' => 'portal', 'description' => 'View invoices'],
            ['permission_key' => 'portal.make_payment', 'module' => 'portal', 'description' => 'Make payments'],
            ['permission_key' => 'portal.update_info', 'module' => 'portal', 'description' => 'Update personal information'],
            ['permission_key' => 'portal.message_practice', 'module' => 'portal', 'description' => 'Message practice'],
        ];

        foreach ($permissions as &$permission) {
            $permission['created_at'] = now();
            $permission['updated_at'] = now();
        }

        DB::table('permissions')->insert($permissions);
    }
}
