<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Practice Owner gets ALL permissions
        $allPermissions = DB::table('permissions')->pluck('id');
        foreach ($allPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => 'ROLE_PRACTICE_OWNER',
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Practice Admin - near-full access (exclude ownership transfer)
        $practiceAdminPermissions = [
            // Dashboard
            'dashboard.view_own', 'dashboard.view_practice', 'dashboard.view_provider', 'dashboard.view_analytics',
            // Patients
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.create',
            'patients.edit', 'patients.delete', 'patients.merge', 'patients.export', 'patients.view_family', 'patients.manage_family',
            // Appointments
            'appointments.view_own', 'appointments.view_all', 'appointments.view_provider', 'appointments.create',
            'appointments.edit', 'appointments.delete', 'appointments.reschedule', 'appointments.confirm',
            'appointments.check_in', 'appointments.manage_waiting_room', 'appointments.block_time',
            'appointments.view_operatory', 'appointments.assign_operatory',
            // Chart
            'chart.view', 'chart.view_history', 'chart.view_conditions',
            // Notes
            'notes.view', 'notes.view_all_providers',
            // Treatment Plan
            'treatment_plan.view', 'treatment_plan.present',
            // Imaging
            'imaging.view', 'imaging.upload', 'imaging.edit', 'imaging.delete', 'imaging.share',
            'imaging.ai_diagnosis', 'imaging.export', 'imaging.print',
            // Prescriptions
            'prescriptions.view', 'prescriptions.view_drug_interactions',
            // Financials
            'financials.view_patient_balance', 'financials.view_production', 'financials.view_collections',
            'financials.view_ar_aging', 'financials.post_payment', 'financials.post_adjustment',
            'financials.post_refund', 'financials.void_transaction', 'financials.view_ledger',
            'financials.print_statement', 'financials.manage_payment_plans',
            // Insurance
            'insurance.view', 'insurance.edit', 'insurance.verify_eligibility', 'insurance.create_claim',
            'insurance.submit_claim', 'insurance.view_claim_status', 'insurance.post_insurance_payment',
            'insurance.manage_era', 'insurance.manage_preauth', 'insurance.appeal_denial',
            // Lab
            'lab.view', 'lab.create', 'lab.edit', 'lab.update_status', 'lab.complete', 'lab.view_all',
            // Referrals
            'referrals.view', 'referrals.create', 'referrals.edit', 'referrals.track', 'referrals.view_reports',
            // Reports
            'reports.view_basic', 'reports.view_financial', 'reports.view_production', 'reports.view_clinical',
            'reports.view_marketing', 'reports.create_custom', 'reports.export', 'reports.schedule', 'reports.sql_query',
            // Communication
            'communication.send_sms', 'communication.send_email', 'communication.view_history',
            'communication.two_way_text', 'communication.mass_email', 'communication.manage_campaigns',
            // Staff
            'staff.view', 'staff.create', 'staff.edit', 'staff.delete', 'staff.manage_schedule',
            // Settings
            'settings.view', 'settings.edit', 'settings.view_integrations', 'settings.manage_integrations',
            'settings.manage_operatories', 'settings.manage_appointment_types', 'settings.manage_fee_schedule',
            'settings.manage_insurance_plans',
            // Users
            'users.view', 'users.create', 'users.edit', 'users.delete', 'users.manage_roles',
            'users.manage_permissions', 'users.view_audit_log', 'users.reset_password',
        ];
        $this->assignPermissions('ROLE_PRACTICE_ADMIN', $practiceAdminPermissions);

        // Practice Manager
        $practiceManagerPermissions = [
            'dashboard.view_own', 'dashboard.view_practice', 'dashboard.view_provider', 'dashboard.view_analytics',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.create',
            'patients.edit', 'patients.delete', 'patients.merge', 'patients.export', 'patients.view_family', 'patients.manage_family',
            'appointments.view_own', 'appointments.view_all', 'appointments.view_provider', 'appointments.create',
            'appointments.edit', 'appointments.delete', 'appointments.reschedule', 'appointments.confirm',
            'appointments.check_in', 'appointments.manage_waiting_room', 'appointments.block_time',
            'appointments.view_operatory', 'appointments.assign_operatory',
            'chart.view', 'chart.view_history', 'chart.view_conditions',
            'notes.view', 'notes.view_all_providers',
            'treatment_plan.view', 'treatment_plan.present', 'treatment_plan.accept', 'treatment_plan.schedule',
            'imaging.view', 'imaging.upload', 'imaging.edit', 'imaging.share', 'imaging.export', 'imaging.print',
            'prescriptions.view',
            'financials.view_patient_balance', 'financials.view_production', 'financials.view_collections',
            'financials.view_ar_aging', 'financials.post_payment', 'financials.post_adjustment',
            'financials.post_refund', 'financials.void_transaction', 'financials.view_ledger',
            'financials.print_statement', 'financials.manage_payment_plans',
            'insurance.view', 'insurance.edit', 'insurance.verify_eligibility', 'insurance.create_claim',
            'insurance.submit_claim', 'insurance.view_claim_status', 'insurance.post_insurance_payment',
            'insurance.manage_era', 'insurance.manage_preauth', 'insurance.appeal_denial',
            'lab.view', 'lab.create', 'lab.edit', 'lab.update_status', 'lab.complete', 'lab.view_all',
            'referrals.view', 'referrals.create', 'referrals.edit', 'referrals.track', 'referrals.view_reports',
            'reports.view_basic', 'reports.view_financial', 'reports.view_production', 'reports.view_clinical',
            'reports.view_marketing', 'reports.create_custom', 'reports.export', 'reports.schedule',
            'communication.send_sms', 'communication.send_email', 'communication.view_history',
            'communication.two_way_text', 'communication.mass_email', 'communication.manage_campaigns',
            'staff.view', 'staff.create', 'staff.edit', 'staff.delete', 'staff.manage_schedule',
            'settings.view', 'settings.edit', 'settings.view_integrations', 'settings.manage_integrations',
            'settings.manage_operatories', 'settings.manage_appointment_types', 'settings.manage_fee_schedule',
            'settings.manage_insurance_plans',
            'users.view', 'users.create', 'users.edit', 'users.view_audit_log', 'users.reset_password',
        ];
        $this->assignPermissions('ROLE_PRACTICE_MANAGER', $practiceManagerPermissions);

        // Dentist/Provider
        $dentistPermissions = [
            'dashboard.view_own', 'dashboard.view_provider', 'dashboard.view_analytics',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.create',
            'patients.edit', 'patients.export', 'patients.view_family', 'patients.manage_family',
            'appointments.view_own', 'appointments.view_all', 'appointments.view_provider', 'appointments.create',
            'appointments.edit', 'appointments.delete', 'appointments.reschedule', 'appointments.confirm',
            'appointments.check_in', 'appointments.manage_waiting_room', 'appointments.block_time',
            'appointments.view_operatory', 'appointments.assign_operatory',
            'chart.view', 'chart.edit', 'chart.view_history', 'chart.view_conditions', 'chart.add_conditions',
            'chart.edit_conditions', 'chart.view_perio', 'chart.edit_perio', 'chart.view_soft_tissue', 'chart.edit_soft_tissue',
            'notes.view', 'notes.create', 'notes.edit', 'notes.delete', 'notes.sign', 'notes.view_all_providers',
            'treatment_plan.view', 'treatment_plan.create', 'treatment_plan.edit', 'treatment_plan.delete',
            'treatment_plan.present', 'treatment_plan.accept', 'treatment_plan.schedule',
            'imaging.view', 'imaging.upload', 'imaging.edit', 'imaging.delete', 'imaging.share',
            'imaging.ai_diagnosis', 'imaging.export', 'imaging.print',
            'prescriptions.view', 'prescriptions.create', 'prescriptions.edit', 'prescriptions.delete',
            'prescriptions.controlled_substances', 'prescriptions.view_drug_interactions',
            'financials.view_patient_balance', 'financials.view_production', 'financials.view_collections',
            'financials.post_payment', 'financials.post_adjustment', 'financials.view_ledger', 'financials.print_statement',
            'insurance.view', 'insurance.edit', 'insurance.verify_eligibility', 'insurance.create_claim',
            'insurance.view_claim_status', 'insurance.manage_preauth', 'insurance.appeal_denial',
            'lab.view', 'lab.create', 'lab.edit', 'lab.update_status', 'lab.complete', 'lab.view_all',
            'referrals.view', 'referrals.create', 'referrals.edit', 'referrals.track', 'referrals.view_reports',
            'reports.view_basic', 'reports.view_financial', 'reports.view_production', 'reports.view_clinical',
            'reports.create_custom', 'reports.export',
            'communication.send_sms', 'communication.send_email', 'communication.view_history', 'communication.two_way_text',
            'staff.view',
            'settings.view', 'settings.manage_appointment_types', 'settings.manage_fee_schedule',
        ];
        $this->assignPermissions('ROLE_DENTIST', $dentistPermissions);

        // Dental Hygienist
        $hygienistPermissions = [
            'dashboard.view_own',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.edit', 'patients.view_family',
            'appointments.view_own', 'appointments.view_provider', 'appointments.create', 'appointments.edit',
            'appointments.reschedule', 'appointments.confirm', 'appointments.check_in', 'appointments.manage_waiting_room',
            'appointments.block_time', 'appointments.view_operatory', 'appointments.assign_operatory',
            'chart.view', 'chart.edit', 'chart.view_history', 'chart.view_conditions', 'chart.add_conditions',
            'chart.view_perio', 'chart.edit_perio', 'chart.view_soft_tissue', 'chart.edit_soft_tissue',
            'notes.view', 'notes.create', 'notes.edit', 'notes.sign',
            'treatment_plan.view', 'treatment_plan.present',
            'imaging.view', 'imaging.upload', 'imaging.edit', 'imaging.print',
            'prescriptions.view', 'prescriptions.view_drug_interactions',
            'financials.view_patient_balance', 'financials.view_production',
            'insurance.view',
            'lab.view',
            'referrals.view',
            'reports.view_basic', 'reports.view_production', 'reports.view_clinical', 'reports.export',
            'communication.send_sms', 'communication.send_email', 'communication.view_history', 'communication.two_way_text',
        ];
        $this->assignPermissions('ROLE_HYGIENIST', $hygienistPermissions);

        // Dental Assistant
        $dentalAssistantPermissions = [
            'dashboard.view_own',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.edit', 'patients.view_family',
            'appointments.view_own', 'appointments.view_provider', 'appointments.confirm', 'appointments.check_in',
            'appointments.manage_waiting_room', 'appointments.view_operatory', 'appointments.assign_operatory',
            'chart.view', 'chart.edit', 'chart.view_history', 'chart.view_conditions', 'chart.add_conditions',
            'chart.view_perio', 'chart.edit_perio',
            'notes.view', 'notes.create', 'notes.edit',
            'treatment_plan.view',
            'imaging.view', 'imaging.upload', 'imaging.edit', 'imaging.print',
            'prescriptions.view', 'prescriptions.view_drug_interactions',
            'lab.view', 'lab.create', 'lab.edit', 'lab.update_status',
            'referrals.view',
            'communication.send_sms', 'communication.send_email', 'communication.view_history', 'communication.two_way_text',
        ];
        $this->assignPermissions('ROLE_DENTAL_ASSISTANT', $dentalAssistantPermissions);

        // Front Desk/Receptionist
        $frontDeskPermissions = [
            'dashboard.view_own',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.create',
            'patients.edit', 'patients.view_family', 'patients.manage_family',
            'appointments.view_own', 'appointments.view_all', 'appointments.view_provider', 'appointments.create',
            'appointments.edit', 'appointments.delete', 'appointments.reschedule', 'appointments.confirm',
            'appointments.check_in', 'appointments.manage_waiting_room', 'appointments.block_time',
            'appointments.view_operatory', 'appointments.assign_operatory',
            'chart.view',
            'treatment_plan.view', 'treatment_plan.present', 'treatment_plan.accept', 'treatment_plan.schedule',
            'financials.view_patient_balance', 'financials.view_production', 'financials.post_payment',
            'financials.view_ledger', 'financials.print_statement', 'financials.manage_payment_plans',
            'insurance.view', 'insurance.edit', 'insurance.verify_eligibility', 'insurance.create_claim',
            'insurance.view_claim_status', 'insurance.manage_preauth',
            'lab.view',
            'referrals.view', 'referrals.create', 'referrals.edit', 'referrals.track',
            'reports.view_basic', 'reports.export',
            'communication.send_sms', 'communication.send_email', 'communication.view_history', 'communication.two_way_text',
            'staff.view', 'staff.manage_schedule',
            'settings.manage_appointment_types',
        ];
        $this->assignPermissions('ROLE_FRONT_DESK', $frontDeskPermissions);

        // Billing Specialist
        $billingSpecialistPermissions = [
            'dashboard.view_own', 'dashboard.view_analytics',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.create',
            'patients.edit', 'patients.merge', 'patients.export', 'patients.view_family', 'patients.manage_family',
            'appointments.view_all', 'appointments.view_provider',
            'chart.view',
            'treatment_plan.view', 'treatment_plan.present', 'treatment_plan.accept', 'treatment_plan.schedule',
            'financials.view_patient_balance', 'financials.view_production', 'financials.view_collections',
            'financials.view_ar_aging', 'financials.post_payment', 'financials.post_adjustment',
            'financials.post_refund', 'financials.void_transaction', 'financials.view_ledger',
            'financials.print_statement', 'financials.manage_payment_plans',
            'insurance.view', 'insurance.edit', 'insurance.verify_eligibility', 'insurance.create_claim',
            'insurance.submit_claim', 'insurance.view_claim_status', 'insurance.post_insurance_payment',
            'insurance.manage_era', 'insurance.manage_preauth', 'insurance.appeal_denial',
            'reports.view_basic', 'reports.view_financial', 'reports.view_production', 'reports.create_custom',
            'reports.export', 'reports.schedule',
            'communication.send_sms', 'communication.send_email', 'communication.view_history', 'communication.two_way_text',
            'settings.view', 'settings.view_integrations', 'settings.manage_fee_schedule', 'settings.manage_insurance_plans',
        ];
        $this->assignPermissions('ROLE_BILLING_SPECIALIST', $billingSpecialistPermissions);

        // Insurance Coordinator
        $insuranceCoordinatorPermissions = [
            'dashboard.view_own',
            'patients.view', 'patients.view_demographics', 'patients.view_medical_history', 'patients.edit', 'patients.view_family',
            'appointments.view_all', 'appointments.view_provider', 'appointments.confirm',
            'chart.view', 'chart.view_history', 'chart.view_conditions',
            'treatment_plan.view',
            'financials.view_patient_balance', 'financials.view_ar_aging', 'financials.post_adjustment',
            'financials.view_ledger', 'financials.print_statement', 'financials.manage_payment_plans',
            'insurance.view', 'insurance.edit', 'insurance.verify_eligibility', 'insurance.create_claim',
            'insurance.submit_claim', 'insurance.view_claim_status', 'insurance.post_insurance_payment',
            'insurance.manage_era', 'insurance.manage_preauth', 'insurance.appeal_denial',
            'reports.view_basic', 'reports.view_financial', 'reports.export',
            'communication.send_sms', 'communication.send_email', 'communication.view_history', 'communication.two_way_text',
            'settings.manage_insurance_plans',
        ];
        $this->assignPermissions('ROLE_INSURANCE_COORDINATOR', $insuranceCoordinatorPermissions);

        // Lab Technician
        $labTechnicianPermissions = [
            'dashboard.view_own',
            'imaging.view',
            'lab.view', 'lab.create', 'lab.edit', 'lab.update_status', 'lab.complete', 'lab.view_all',
        ];
        $this->assignPermissions('ROLE_LAB_TECHNICIAN', $labTechnicianPermissions);

        // Marketing Coordinator
        $marketingCoordinatorPermissions = [
            'dashboard.view_own', 'dashboard.view_analytics',
            'patients.view', 'patients.view_demographics',
            'referrals.view', 'referrals.track', 'referrals.view_reports',
            'reports.view_basic', 'reports.view_marketing', 'reports.create_custom', 'reports.export', 'reports.schedule',
            'communication.send_sms', 'communication.send_email', 'communication.view_history',
            'communication.two_way_text', 'communication.mass_email', 'communication.manage_campaigns',
        ];
        $this->assignPermissions('ROLE_MARKETING_COORDINATOR', $marketingCoordinatorPermissions);

        // Patient (Portal Access Only)
        $patientPermissions = [
            'portal.access', 'portal.view_appointments', 'portal.request_appointment',
            'portal.view_treatment_history', 'portal.view_invoices', 'portal.make_payment',
            'portal.update_info', 'portal.message_practice',
        ];
        $this->assignPermissions('ROLE_PATIENT', $patientPermissions);

        // Referring Provider
        $referringProviderPermissions = [
            'dashboard.view_own',
            'patients.view_demographics', 'patients.view_medical_history',
            'chart.view', 'chart.view_history', 'chart.view_conditions',
            'notes.view', 'notes.create',
            'treatment_plan.view',
            'imaging.view',
            'lab.view', 'lab.edit',
            'referrals.view', 'referrals.edit',
        ];
        $this->assignPermissions('ROLE_REFERRING_PROVIDER', $referringProviderPermissions);
    }

    protected function assignPermissions(string $roleId, array $permissionKeys): void
    {
        foreach ($permissionKeys as $key) {
            $permission = DB::table('permissions')->where('permission_key', $key)->first();
            if ($permission) {
                DB::table('role_permissions')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permission->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
