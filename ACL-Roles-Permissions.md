# NymoDental Access Control List (ACL)
## Roles and Permissions Documentation

**Document Date:** October 22, 2025
**Version:** 1.0
**Purpose:** Define comprehensive Access Control List (ACL) for NymoDental system

---

## Table of Contents

1. [Overview](#overview)
2. [User Roles Definition](#user-roles-definition)
3. [Permission Categories](#permission-categories)
4. [Detailed Permission Matrix](#detailed-permission-matrix)
5. [Role-Permission Mapping](#role-permission-mapping)
6. [Database Schema for ACL](#database-schema-for-acl)
7. [Implementation Guidelines](#implementation-guidelines)

---

## Overview

### What is ACL?

Access Control List (ACL) is a security mechanism that defines which users or system processes are granted access to objects (resources, features, data) and what operations are allowed on given objects.

### NymoDental ACL Architecture

**Model:** Role-Based Access Control (RBAC)
- Users are assigned to Roles
- Roles have Permissions
- Permissions control access to Resources and Actions

**Key Principles:**
- **Principle of Least Privilege:** Users should have minimum access necessary
- **Separation of Duties:** Critical tasks require multiple users
- **Audit Trail:** All access and actions are logged
- **HIPAA Compliance:** Protected Health Information (PHI) access is strictly controlled

---

## User Roles Definition

### Internal Staff Roles (11 Roles)

#### 1. PRACTICE_OWNER
**Role ID:** `ROLE_PRACTICE_OWNER`
**Description:** Practice owner with full system access
**Typical Count per Practice:** 1-2
**Hierarchy Level:** 1 (Highest)

**Primary Responsibilities:**
- Ultimate system authority
- Practice-wide configuration
- Financial oversight
- User management
- Strategic decision-making
- Legal and compliance oversight

**Access Philosophy:** Complete unrestricted access to all modules

---

#### 2. PRACTICE_ADMINISTRATOR
**Role ID:** `ROLE_PRACTICE_ADMIN`
**Description:** System administrator with near-full access
**Typical Count per Practice:** 1-2
**Hierarchy Level:** 1 (Highest)

**Primary Responsibilities:**
- System configuration and maintenance
- User and role management
- Integration setup
- Security management
- Data backup oversight
- Technical administration

**Access Philosophy:** Full access except ownership transfer

---

#### 3. PRACTICE_MANAGER
**Role ID:** `ROLE_PRACTICE_MANAGER`
**Description:** Operations manager with administrative and financial access
**Typical Count per Practice:** 1-3
**Hierarchy Level:** 2

**Primary Responsibilities:**
- Day-to-day operations
- Staff scheduling and management
- Financial oversight
- Practice performance monitoring
- Patient flow optimization
- Compliance monitoring

**Access Philosophy:** Full operational access, limited system configuration

---

#### 4. DENTIST_PROVIDER
**Role ID:** `ROLE_DENTIST`
**Description:** Licensed dentist providing clinical services
**Typical Count per Practice:** 1-10
**Hierarchy Level:** 2

**Primary Responsibilities:**
- Patient diagnosis and treatment
- Treatment planning
- Clinical documentation
- Prescription writing
- Patient care oversight
- Clinical decision-making

**Access Philosophy:** Full clinical access, view financial, limited admin

---

#### 5. DENTAL_HYGIENIST
**Role ID:** `ROLE_HYGIENIST`
**Description:** Licensed hygienist providing preventive services
**Typical Count per Practice:** 2-8
**Hierarchy Level:** 3

**Primary Responsibilities:**
- Hygiene services (cleaning, scaling)
- Periodontal assessment
- Patient education
- Preventive care
- Hygiene recall management

**Access Philosophy:** Hygiene-specific clinical access, own scheduling

---

#### 6. DENTAL_ASSISTANT
**Role ID:** `ROLE_DENTAL_ASSISTANT`
**Description:** Assistant supporting clinical procedures
**Typical Count per Practice:** 2-10
**Hierarchy Level:** 3

**Primary Responsibilities:**
- Chairside assistance
- Patient preparation
- Imaging capture
- Sterilization
- Clinical support documentation

**Access Philosophy:** Support-level clinical access, no treatment planning

---

#### 7. FRONT_DESK_RECEPTIONIST
**Role ID:** `ROLE_FRONT_DESK`
**Description:** Front office staff managing appointments and patient flow
**Typical Count per Practice:** 2-5
**Hierarchy Level:** 3

**Primary Responsibilities:**
- Appointment scheduling
- Patient check-in/out
- Phone management
- Patient demographics
- Insurance verification
- Waiting room management

**Access Philosophy:** Scheduling and demographics access, limited clinical/financial

---

#### 8. BILLING_SPECIALIST
**Role ID:** `ROLE_BILLING_SPECIALIST`
**Description:** Financial specialist managing billing and insurance
**Typical Count per Practice:** 1-3
**Hierarchy Level:** 2

**Primary Responsibilities:**
- Insurance claims
- Payment posting
- Accounts receivable
- Collections
- Financial reporting
- Insurance follow-up

**Access Philosophy:** Full financial access, view clinical, limited admin

---

#### 9. INSURANCE_COORDINATOR
**Role ID:** `ROLE_INSURANCE_COORDINATOR`
**Description:** Specialist focused on insurance operations
**Typical Count per Practice:** 1-2
**Hierarchy Level:** 3

**Primary Responsibilities:**
- Insurance verification
- Pre-authorizations
- Claims management
- Benefit breakdown
- Denial appeals

**Access Philosophy:** Insurance-specific access, view clinical for claims

---

#### 10. LAB_TECHNICIAN
**Role ID:** `ROLE_LAB_TECHNICIAN`
**Description:** Technician managing lab cases (can be external)
**Typical Count per Practice:** 0-2 (internal), unlimited (external)
**Hierarchy Level:** 4

**Primary Responsibilities:**
- Lab case management
- Work order completion
- Case status updates
- Communication with providers

**Access Philosophy:** Lab cases only, no patient PHI beyond lab needs

---

#### 11. MARKETING_COORDINATOR
**Role ID:** `ROLE_MARKETING_COORDINATOR`
**Description:** Marketing specialist managing patient outreach
**Typical Count per Practice:** 0-2
**Hierarchy Level:** 3

**Primary Responsibilities:**
- Marketing campaigns
- Patient communication
- Review management
- Referral tracking
- Patient acquisition analytics

**Access Philosophy:** Marketing and communication access, limited PHI

---

### External User Roles (2 Roles)

#### 12. PATIENT
**Role ID:** `ROLE_PATIENT`
**Description:** Patient with access to own records via portal
**Typical Count:** Unlimited
**Hierarchy Level:** External

**Primary Responsibilities:**
- Manage own appointments
- Update personal information
- View treatment history
- Make payments
- Complete forms

**Access Philosophy:** Own data only, no access to practice operations

---

#### 13. REFERRING_PROVIDER
**Role ID:** `ROLE_REFERRING_PROVIDER`
**Description:** External specialist receiving referrals
**Typical Count:** Unlimited
**Hierarchy Level:** External

**Primary Responsibilities:**
- View referred patient information
- Upload consultation reports
- Communicate with referring dentist

**Access Philosophy:** Referred patients only, limited PHI

---

## Permission Categories

### 1. MODULE ACCESS PERMISSIONS

#### DASHBOARD
- `dashboard.view_own` - View personal dashboard
- `dashboard.view_practice` - View practice-wide dashboard
- `dashboard.view_provider` - View specific provider dashboards
- `dashboard.view_analytics` - View advanced analytics

#### PATIENTS
- `patients.view` - View patient list and search
- `patients.view_demographics` - View patient demographics
- `patients.view_medical_history` - View medical history
- `patients.create` - Create new patients
- `patients.edit` - Edit patient information
- `patients.delete` - Delete/archive patients
- `patients.merge` - Merge duplicate patients
- `patients.export` - Export patient data
- `patients.view_family` - View family relationships
- `patients.manage_family` - Manage family accounts

#### APPOINTMENTS
- `appointments.view_own` - View own appointments
- `appointments.view_all` - View all appointments
- `appointments.view_provider` - View specific provider appointments
- `appointments.create` - Create appointments
- `appointments.edit` - Edit appointments
- `appointments.delete` - Delete appointments
- `appointments.reschedule` - Reschedule appointments
- `appointments.confirm` - Confirm appointments
- `appointments.check_in` - Check-in patients
- `appointments.manage_waiting_room` - Manage waiting room
- `appointments.block_time` - Block schedule time
- `appointments.view_operatory` - View operatory schedule
- `appointments.assign_operatory` - Assign operatories

#### CLINICAL_CHART
- `chart.view` - View dental charts
- `chart.edit` - Edit dental charts
- `chart.view_history` - View chart history
- `chart.view_conditions` - View existing conditions
- `chart.add_conditions` - Add conditions/findings
- `chart.edit_conditions` - Edit conditions
- `chart.view_perio` - View periodontal charting
- `chart.edit_perio` - Edit periodontal charting
- `chart.view_soft_tissue` - View soft tissue exam
- `chart.edit_soft_tissue` - Edit soft tissue exam

#### CLINICAL_NOTES
- `notes.view` - View clinical notes
- `notes.create` - Create clinical notes
- `notes.edit` - Edit clinical notes
- `notes.delete` - Delete clinical notes
- `notes.sign` - Sign/lock clinical notes
- `notes.view_all_providers` - View all providers' notes

#### TREATMENT_PLANS
- `treatment_plan.view` - View treatment plans
- `treatment_plan.create` - Create treatment plans
- `treatment_plan.edit` - Edit treatment plans
- `treatment_plan.delete` - Delete treatment plans
- `treatment_plan.present` - Present to patients
- `treatment_plan.accept` - Mark as accepted
- `treatment_plan.schedule` - Schedule treatment

#### IMAGING
- `imaging.view` - View images/X-rays
- `imaging.upload` - Upload images
- `imaging.edit` - Edit/annotate images
- `imaging.delete` - Delete images
- `imaging.share` - Share images externally
- `imaging.ai_diagnosis` - Access AI diagnosis tools
- `imaging.export` - Export images
- `imaging.print` - Print images

#### PRESCRIPTIONS
- `prescriptions.view` - View prescription history
- `prescriptions.create` - Create prescriptions (requires DEA)
- `prescriptions.edit` - Edit pending prescriptions
- `prescriptions.delete` - Delete pending prescriptions
- `prescriptions.controlled_substances` - Prescribe controlled substances (requires EPCS)
- `prescriptions.view_drug_interactions` - View drug interaction alerts

#### FINANCIALS
- `financials.view_patient_balance` - View patient balances
- `financials.view_production` - View production reports
- `financials.view_collections` - View collection reports
- `financials.view_ar_aging` - View A/R aging
- `financials.post_payment` - Post payments
- `financials.post_adjustment` - Post adjustments
- `financials.post_refund` - Process refunds
- `financials.void_transaction` - Void transactions
- `financials.view_ledger` - View patient ledger
- `financials.print_statement` - Print patient statements
- `financials.manage_payment_plans` - Create payment plans

#### INSURANCE
- `insurance.view` - View insurance information
- `insurance.edit` - Edit insurance information
- `insurance.verify_eligibility` - Verify eligibility
- `insurance.create_claim` - Create insurance claims
- `insurance.submit_claim` - Submit claims
- `insurance.view_claim_status` - View claim status
- `insurance.post_insurance_payment` - Post insurance payments
- `insurance.manage_era` - Manage ERA (Electronic Remittance)
- `insurance.manage_preauth` - Manage pre-authorizations
- `insurance.appeal_denial` - Appeal denied claims

#### LAB_CASES
- `lab.view` - View lab cases
- `lab.create` - Create lab cases
- `lab.edit` - Edit lab cases
- `lab.update_status` - Update lab case status
- `lab.complete` - Mark lab case complete
- `lab.view_all` - View all practice lab cases

#### REFERRALS
- `referrals.view` - View referrals
- `referrals.create` - Create referrals
- `referrals.edit` - Edit referrals
- `referrals.track` - Track referral status
- `referrals.view_reports` - View referral reports

#### REPORTS
- `reports.view_basic` - View basic reports
- `reports.view_financial` - View financial reports
- `reports.view_production` - View production reports
- `reports.view_clinical` - View clinical reports
- `reports.view_marketing` - View marketing reports
- `reports.create_custom` - Create custom reports
- `reports.export` - Export reports
- `reports.schedule` - Schedule automated reports
- `reports.sql_query` - Run SQL queries

#### COMMUNICATION
- `communication.send_sms` - Send SMS messages
- `communication.send_email` - Send emails
- `communication.view_history` - View communication history
- `communication.two_way_text` - Two-way texting
- `communication.mass_email` - Send mass emails
- `communication.manage_campaigns` - Manage marketing campaigns

#### STAFF_MANAGEMENT
- `staff.view` - View staff list
- `staff.create` - Add staff
- `staff.edit` - Edit staff information
- `staff.delete` - Remove staff
- `staff.manage_schedule` - Manage staff schedules

#### PRACTICE_SETTINGS
- `settings.view` - View practice settings
- `settings.edit` - Edit practice settings
- `settings.view_integrations` - View integrations
- `settings.manage_integrations` - Manage integrations
- `settings.manage_operatories` - Manage operatories
- `settings.manage_appointment_types` - Manage appointment types
- `settings.manage_fee_schedule` - Manage fee schedules
- `settings.manage_insurance_plans` - Manage insurance plans

#### USER_MANAGEMENT
- `users.view` - View users
- `users.create` - Create users
- `users.edit` - Edit users
- `users.delete` - Delete users
- `users.manage_roles` - Assign roles
- `users.manage_permissions` - Manage custom permissions
- `users.view_audit_log` - View audit logs
- `users.reset_password` - Reset user passwords

#### PATIENT_PORTAL
- `portal.access` - Access patient portal
- `portal.view_appointments` - View own appointments
- `portal.request_appointment` - Request appointments
- `portal.view_treatment_history` - View treatment history
- `portal.view_invoices` - View invoices
- `portal.make_payment` - Make payments
- `portal.update_info` - Update personal information
- `portal.message_practice` - Message practice

---

## Detailed Permission Matrix

### Complete ACL Matrix

| Permission | Owner | Admin | Manager | Dentist | Hygienist | Assistant | Front Desk | Billing | Insurance | Lab Tech | Marketing | Patient | Referrer |
|-----------|-------|-------|---------|---------|-----------|-----------|------------|---------|-----------|----------|-----------|---------|----------|
| **DASHBOARD** |
| dashboard.view_own | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| dashboard.view_practice | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| dashboard.view_provider | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| dashboard.view_analytics | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ✅ | ❌ | ❌ |
| **PATIENTS** |
| patients.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ⚠️ | ❌ | ❌ |
| patients.view_demographics | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ⚠️ | ✅* | ⚠️ |
| patients.view_medical_history | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ | ⚠️ | ⚠️ | ❌ | ❌ | ✅* | ⚠️ |
| patients.create | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| patients.edit | ✅ | ✅ | ✅ | ✅ | ⚠️ | ⚠️ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ⚠️* | ❌ |
| patients.delete | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| patients.merge | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| patients.export | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| patients.view_family | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅* | ❌ |
| patients.manage_family | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **APPOINTMENTS** |
| appointments.view_own | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅* | ❌ |
| appointments.view_all | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| appointments.view_provider | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| appointments.create | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ⚠️* | ❌ |
| appointments.edit | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| appointments.delete | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| appointments.reschedule | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ⚠️* | ❌ |
| appointments.confirm | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| appointments.check_in | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ✅* | ❌ |
| appointments.manage_waiting_room | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| appointments.block_time | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| appointments.view_operatory | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| appointments.assign_operatory | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **CLINICAL_CHART** |
| chart.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ | ⚠️ | ⚠️ | ❌ | ❌ | ⚠️* | ⚠️ |
| chart.edit | ✅ | ✅ | ❌ | ✅ | ⚠️ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| chart.view_history | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅* | ⚠️ |
| chart.view_conditions | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ⚠️* | ⚠️ |
| chart.add_conditions | ✅ | ✅ | ❌ | ✅ | ⚠️ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| chart.edit_conditions | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| chart.view_perio | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ⚠️* | ❌ |
| chart.edit_perio | ✅ | ✅ | ❌ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| chart.view_soft_tissue | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| chart.edit_soft_tissue | ✅ | ✅ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **CLINICAL_NOTES** |
| notes.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ⚠️* | ⚠️ |
| notes.create | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ⚠️ |
| notes.edit | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| notes.delete | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| notes.sign | ✅ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| notes.view_all_providers | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **TREATMENT_PLANS** |
| treatment_plan.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ | ✅ | ✅ | ❌ | ❌ | ✅* | ⚠️ |
| treatment_plan.create | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| treatment_plan.edit | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| treatment_plan.delete | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| treatment_plan.present | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ⚠️ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| treatment_plan.accept | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ⚠️ | ✅ | ❌ | ❌ | ❌ | ⚠️* | ❌ |
| treatment_plan.schedule | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **IMAGING** |
| imaging.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ⚠️ | ❌ | ⚠️* | ⚠️ |
| imaging.upload | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| imaging.edit | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| imaging.delete | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| imaging.share | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| imaging.ai_diagnosis | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| imaging.export | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| imaging.print | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **PRESCRIPTIONS** |
| prescriptions.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅* | ❌ |
| prescriptions.create | ✅ | ❌ | ❌ | ✅** | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| prescriptions.edit | ✅ | ❌ | ❌ | ✅** | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| prescriptions.delete | ✅ | ❌ | ❌ | ✅** | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| prescriptions.controlled_substances | ✅ | ❌ | ❌ | ✅*** | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| prescriptions.view_drug_interactions | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **FINANCIALS** |
| financials.view_patient_balance | ✅ | ✅ | ✅ | ✅ | ⚠️ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅* | ❌ |
| financials.view_production | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ⚠️ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| financials.view_collections | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| financials.view_ar_aging | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| financials.post_payment | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ✅* | ❌ |
| financials.post_adjustment | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ❌ |
| financials.post_refund | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| financials.void_transaction | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| financials.view_ledger | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅* | ❌ |
| financials.print_statement | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅* | ❌ |
| financials.manage_payment_plans | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ⚠️ | ✅ | ⚠️ | ❌ | ❌ | ⚠️* | ❌ |
| **INSURANCE** |
| insurance.view | ✅ | ✅ | ✅ | ✅ | ⚠️ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅* | ❌ |
| insurance.edit | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ⚠️* | ❌ |
| insurance.verify_eligibility | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| insurance.create_claim | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ⚠️ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| insurance.submit_claim | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| insurance.view_claim_status | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ⚠️ | ✅ | ✅ | ❌ | ❌ | ⚠️* | ❌ |
| insurance.post_insurance_payment | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| insurance.manage_era | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| insurance.manage_preauth | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ⚠️ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| insurance.appeal_denial | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **LAB_CASES** |
| lab.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ✅ | ❌ | ⚠️* | ⚠️ |
| lab.create | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| lab.edit | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ |
| lab.update_status | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ |
| lab.complete | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ |
| lab.view_all | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ |
| **REFERRALS** |
| referrals.view | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ⚠️* | ✅ |
| referrals.create | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| referrals.edit | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |
| referrals.track | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| referrals.view_reports | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| **REPORTS** |
| reports.view_basic | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| reports.view_financial | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| reports.view_production | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| reports.view_clinical | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| reports.view_marketing | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| reports.create_custom | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ⚠️ | ❌ | ❌ |
| reports.export | ✅ | ✅ | ✅ | ✅ | ⚠️ | ❌ | ⚠️ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| reports.schedule | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ⚠️ | ❌ | ❌ |
| reports.sql_query | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **COMMUNICATION** |
| communication.send_sms | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| communication.send_email | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| communication.view_history | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅* | ❌ |
| communication.two_way_text | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| communication.mass_email | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| communication.manage_campaigns | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| **STAFF_MANAGEMENT** |
| staff.view | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| staff.create | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| staff.edit | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| staff.delete | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| staff.manage_schedule | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **PRACTICE_SETTINGS** |
| settings.view | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.edit | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.view_integrations | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.manage_integrations | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.manage_operatories | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.manage_appointment_types | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.manage_fee_schedule | ✅ | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| settings.manage_insurance_plans | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **USER_MANAGEMENT** |
| users.view | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.create | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.edit | ✅ | ✅ | ⚠️ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.delete | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.manage_roles | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.manage_permissions | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.view_audit_log | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| users.reset_password | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ⚠️* | ❌ |
| **PATIENT_PORTAL** |
| portal.access | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.view_appointments | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.request_appointment | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.view_treatment_history | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.view_invoices | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.make_payment | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.update_info | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| portal.message_practice | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |

**Legend:**
- ✅ Full Access
- ❌ No Access
- ⚠️ Limited/Conditional Access
- \* Own data only (patients)
- \*\* Requires valid DEA license
- \*\*\* Requires EPCS certification

---

## Role-Permission Mapping

### JSON Structure for Roles

```json
{
  "roles": [
    {
      "id": "ROLE_PRACTICE_OWNER",
      "name": "Practice Owner",
      "description": "Owner with full system access",
      "hierarchy_level": 1,
      "is_staff": true,
      "is_provider": false,
      "permissions": ["*"]
    },
    {
      "id": "ROLE_PRACTICE_ADMIN",
      "name": "Practice Administrator",
      "description": "System administrator with near-full access",
      "hierarchy_level": 1,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.*",
        "patients.*",
        "appointments.*",
        "chart.view",
        "chart.view_history",
        "notes.view",
        "notes.view_all_providers",
        "treatment_plan.view",
        "treatment_plan.present",
        "imaging.*",
        "prescriptions.view",
        "financials.*",
        "insurance.*",
        "lab.*",
        "referrals.*",
        "reports.*",
        "communication.*",
        "staff.*",
        "settings.*",
        "users.*"
      ]
    },
    {
      "id": "ROLE_PRACTICE_MANAGER",
      "name": "Practice Manager",
      "description": "Operations manager",
      "hierarchy_level": 2,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.view_own",
        "dashboard.view_practice",
        "dashboard.view_provider",
        "dashboard.view_analytics",
        "patients.*",
        "appointments.*",
        "chart.view",
        "chart.view_history",
        "chart.view_conditions",
        "notes.view",
        "notes.view_all_providers",
        "treatment_plan.view",
        "treatment_plan.present",
        "treatment_plan.accept",
        "treatment_plan.schedule",
        "imaging.view",
        "imaging.edit",
        "imaging.share",
        "imaging.export",
        "imaging.print",
        "prescriptions.view",
        "financials.*",
        "insurance.*",
        "lab.*",
        "referrals.*",
        "reports.view_basic",
        "reports.view_financial",
        "reports.view_production",
        "reports.view_clinical",
        "reports.view_marketing",
        "reports.create_custom",
        "reports.export",
        "reports.schedule",
        "communication.*",
        "staff.*",
        "settings.view",
        "settings.edit",
        "settings.view_integrations",
        "settings.manage_integrations",
        "settings.manage_operatories",
        "settings.manage_appointment_types",
        "settings.manage_fee_schedule",
        "settings.manage_insurance_plans",
        "users.view",
        "users.create",
        "users.edit",
        "users.view_audit_log",
        "users.reset_password"
      ]
    },
    {
      "id": "ROLE_DENTIST",
      "name": "Dentist/Provider",
      "description": "Licensed dentist",
      "hierarchy_level": 2,
      "is_staff": true,
      "is_provider": true,
      "requires_license": "DEA",
      "permissions": [
        "dashboard.view_own",
        "dashboard.view_provider",
        "dashboard.view_analytics",
        "patients.view",
        "patients.view_demographics",
        "patients.view_medical_history",
        "patients.create",
        "patients.edit",
        "patients.export",
        "patients.view_family",
        "patients.manage_family",
        "appointments.*",
        "chart.*",
        "notes.*",
        "treatment_plan.*",
        "imaging.view",
        "imaging.upload",
        "imaging.edit",
        "imaging.delete",
        "imaging.share",
        "imaging.ai_diagnosis",
        "imaging.export",
        "imaging.print",
        "prescriptions.view",
        "prescriptions.create",
        "prescriptions.edit",
        "prescriptions.delete",
        "prescriptions.controlled_substances",
        "prescriptions.view_drug_interactions",
        "financials.view_patient_balance",
        "financials.view_production",
        "financials.view_collections",
        "financials.post_payment",
        "financials.post_adjustment",
        "financials.view_ledger",
        "financials.print_statement",
        "insurance.view",
        "insurance.edit",
        "insurance.verify_eligibility",
        "insurance.create_claim",
        "insurance.view_claim_status",
        "insurance.manage_preauth",
        "insurance.appeal_denial",
        "lab.*",
        "referrals.view",
        "referrals.create",
        "referrals.edit",
        "referrals.track",
        "referrals.view_reports",
        "reports.view_basic",
        "reports.view_financial",
        "reports.view_production",
        "reports.view_clinical",
        "reports.create_custom",
        "reports.export",
        "communication.send_sms",
        "communication.send_email",
        "communication.view_history",
        "communication.two_way_text",
        "staff.view",
        "settings.view",
        "settings.manage_appointment_types",
        "settings.manage_fee_schedule"
      ]
    },
    {
      "id": "ROLE_HYGIENIST",
      "name": "Dental Hygienist",
      "description": "Licensed hygienist",
      "hierarchy_level": 3,
      "is_staff": true,
      "is_provider": true,
      "permissions": [
        "dashboard.view_own",
        "patients.view",
        "patients.view_demographics",
        "patients.view_medical_history",
        "patients.edit",
        "patients.view_family",
        "appointments.view_own",
        "appointments.view_provider",
        "appointments.create",
        "appointments.edit",
        "appointments.reschedule",
        "appointments.confirm",
        "appointments.check_in",
        "appointments.manage_waiting_room",
        "appointments.block_time",
        "appointments.view_operatory",
        "appointments.assign_operatory",
        "chart.view",
        "chart.edit",
        "chart.view_history",
        "chart.view_conditions",
        "chart.add_conditions",
        "chart.view_perio",
        "chart.edit_perio",
        "chart.view_soft_tissue",
        "chart.edit_soft_tissue",
        "notes.view",
        "notes.create",
        "notes.edit",
        "notes.sign",
        "treatment_plan.view",
        "treatment_plan.present",
        "imaging.view",
        "imaging.upload",
        "imaging.edit",
        "imaging.print",
        "prescriptions.view",
        "prescriptions.view_drug_interactions",
        "financials.view_patient_balance",
        "financials.view_production",
        "insurance.view",
        "lab.view",
        "referrals.view",
        "reports.view_basic",
        "reports.view_production",
        "reports.view_clinical",
        "reports.export",
        "communication.send_sms",
        "communication.send_email",
        "communication.view_history",
        "communication.two_way_text"
      ]
    },
    {
      "id": "ROLE_DENTAL_ASSISTANT",
      "name": "Dental Assistant",
      "description": "Clinical assistant",
      "hierarchy_level": 3,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.view_own",
        "patients.view",
        "patients.view_demographics",
        "patients.view_medical_history",
        "patients.edit",
        "patients.view_family",
        "appointments.view_own",
        "appointments.view_provider",
        "appointments.confirm",
        "appointments.check_in",
        "appointments.manage_waiting_room",
        "appointments.view_operatory",
        "appointments.assign_operatory",
        "chart.view",
        "chart.edit",
        "chart.view_history",
        "chart.view_conditions",
        "chart.add_conditions",
        "chart.view_perio",
        "chart.edit_perio",
        "notes.view",
        "notes.create",
        "notes.edit",
        "treatment_plan.view",
        "imaging.view",
        "imaging.upload",
        "imaging.edit",
        "imaging.print",
        "prescriptions.view",
        "prescriptions.view_drug_interactions",
        "lab.view",
        "lab.create",
        "lab.edit",
        "lab.update_status",
        "referrals.view",
        "communication.send_sms",
        "communication.send_email",
        "communication.view_history",
        "communication.two_way_text"
      ]
    },
    {
      "id": "ROLE_FRONT_DESK",
      "name": "Front Desk / Receptionist",
      "description": "Front office staff",
      "hierarchy_level": 3,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.view_own",
        "patients.view",
        "patients.view_demographics",
        "patients.view_medical_history",
        "patients.create",
        "patients.edit",
        "patients.view_family",
        "patients.manage_family",
        "appointments.*",
        "chart.view",
        "treatment_plan.view",
        "treatment_plan.present",
        "treatment_plan.accept",
        "treatment_plan.schedule",
        "financials.view_patient_balance",
        "financials.view_production",
        "financials.post_payment",
        "financials.view_ledger",
        "financials.print_statement",
        "financials.manage_payment_plans",
        "insurance.view",
        "insurance.edit",
        "insurance.verify_eligibility",
        "insurance.create_claim",
        "insurance.view_claim_status",
        "insurance.manage_preauth",
        "lab.view",
        "referrals.view",
        "referrals.create",
        "referrals.edit",
        "referrals.track",
        "reports.view_basic",
        "reports.export",
        "communication.send_sms",
        "communication.send_email",
        "communication.view_history",
        "communication.two_way_text",
        "staff.view",
        "staff.manage_schedule",
        "settings.manage_appointment_types"
      ]
    },
    {
      "id": "ROLE_BILLING_SPECIALIST",
      "name": "Billing Specialist",
      "description": "Financial and insurance specialist",
      "hierarchy_level": 2,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.view_own",
        "dashboard.view_analytics",
        "patients.view",
        "patients.view_demographics",
        "patients.view_medical_history",
        "patients.create",
        "patients.edit",
        "patients.merge",
        "patients.export",
        "patients.view_family",
        "patients.manage_family",
        "appointments.view_all",
        "appointments.view_provider",
        "chart.view",
        "treatment_plan.view",
        "treatment_plan.present",
        "treatment_plan.accept",
        "treatment_plan.schedule",
        "financials.*",
        "insurance.*",
        "reports.view_basic",
        "reports.view_financial",
        "reports.view_production",
        "reports.create_custom",
        "reports.export",
        "reports.schedule",
        "communication.send_sms",
        "communication.send_email",
        "communication.view_history",
        "communication.two_way_text",
        "settings.view",
        "settings.view_integrations",
        "settings.manage_fee_schedule",
        "settings.manage_insurance_plans"
      ]
    },
    {
      "id": "ROLE_INSURANCE_COORDINATOR",
      "name": "Insurance Coordinator",
      "description": "Insurance operations specialist",
      "hierarchy_level": 3,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.view_own",
        "patients.view",
        "patients.view_demographics",
        "patients.view_medical_history",
        "patients.edit",
        "patients.view_family",
        "appointments.view_all",
        "appointments.view_provider",
        "appointments.confirm",
        "chart.view",
        "chart.view_history",
        "chart.view_conditions",
        "treatment_plan.view",
        "financials.view_patient_balance",
        "financials.view_ar_aging",
        "financials.post_adjustment",
        "financials.view_ledger",
        "financials.print_statement",
        "financials.manage_payment_plans",
        "insurance.*",
        "reports.view_basic",
        "reports.view_financial",
        "reports.export",
        "communication.send_sms",
        "communication.send_email",
        "communication.view_history",
        "communication.two_way_text",
        "settings.manage_insurance_plans"
      ]
    },
    {
      "id": "ROLE_LAB_TECHNICIAN",
      "name": "Lab Technician",
      "description": "Lab case specialist",
      "hierarchy_level": 4,
      "is_staff": false,
      "is_provider": false,
      "is_external": true,
      "permissions": [
        "dashboard.view_own",
        "imaging.view",
        "lab.*"
      ]
    },
    {
      "id": "ROLE_MARKETING_COORDINATOR",
      "name": "Marketing Coordinator",
      "description": "Marketing and patient outreach",
      "hierarchy_level": 3,
      "is_staff": true,
      "is_provider": false,
      "permissions": [
        "dashboard.view_own",
        "patients.view",
        "patients.view_demographics",
        "referrals.view",
        "referrals.track",
        "referrals.view_reports",
        "reports.view_basic",
        "reports.view_marketing",
        "reports.create_custom",
        "reports.export",
        "reports.schedule",
        "communication.*"
      ]
    },
    {
      "id": "ROLE_PATIENT",
      "name": "Patient",
      "description": "Patient portal user",
      "hierarchy_level": 0,
      "is_staff": false,
      "is_provider": false,
      "is_external": true,
      "permissions": [
        "portal.*"
      ],
      "data_scope": "own_only"
    },
    {
      "id": "ROLE_REFERRING_PROVIDER",
      "name": "Referring Provider",
      "description": "External specialist",
      "hierarchy_level": 0,
      "is_staff": false,
      "is_provider": true,
      "is_external": true,
      "permissions": [
        "dashboard.view_own",
        "patients.view_demographics",
        "patients.view_medical_history",
        "chart.view",
        "chart.view_history",
        "chart.view_conditions",
        "notes.view",
        "notes.create",
        "treatment_plan.view",
        "imaging.view",
        "lab.view",
        "lab.edit",
        "referrals.view",
        "referrals.edit"
      ],
      "data_scope": "referrals_only"
    }
  ]
}
```

---

## Database Schema for ACL

### Table: `roles`

```sql
CREATE TABLE roles (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    hierarchy_level INT NOT NULL DEFAULT 3,
    is_staff BOOLEAN DEFAULT TRUE,
    is_provider BOOLEAN DEFAULT FALSE,
    is_external BOOLEAN DEFAULT FALSE,
    requires_license VARCHAR(50),
    is_system_role BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Table: `permissions`

```sql
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permission_key VARCHAR(100) UNIQUE NOT NULL,
    module VARCHAR(50) NOT NULL,
    action VARCHAR(50) NOT NULL,
    description TEXT,
    requires_phi_access BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Table: `role_permissions`

```sql
CREATE TABLE role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id VARCHAR(50) NOT NULL,
    permission_id INT NOT NULL,
    granted BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    UNIQUE KEY (role_id, permission_id)
);
```

### Table: `users`

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    practice_id INT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    is_active BOOLEAN DEFAULT TRUE,
    is_locked BOOLEAN DEFAULT FALSE,
    failed_login_attempts INT DEFAULT 0,
    last_login_at TIMESTAMP NULL,
    password_changed_at TIMESTAMP NULL,
    mfa_enabled BOOLEAN DEFAULT FALSE,
    mfa_secret VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (practice_id) REFERENCES practices(id) ON DELETE CASCADE
);
```

### Table: `user_roles`

```sql
CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id VARCHAR(50) NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assigned_by INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY (user_id, role_id)
);
```

### Table: `user_custom_permissions`

```sql
CREATE TABLE user_custom_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    permission_id INT NOT NULL,
    granted BOOLEAN DEFAULT TRUE,
    reason TEXT,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assigned_by INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY (user_id, permission_id)
);
```

### Table: `audit_log`

```sql
CREATE TABLE audit_log (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    resource_type VARCHAR(50) NOT NULL,
    resource_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_action (user_id, action),
    INDEX idx_resource (resource_type, resource_id),
    INDEX idx_created (created_at)
);
```

### Table: `phi_access_log`

```sql
CREATE TABLE phi_access_log (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    patient_id INT NOT NULL,
    access_type VARCHAR(50) NOT NULL,
    reason TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_patient (patient_id),
    INDEX idx_created (created_at)
);
```

---

## Implementation Guidelines

### Backend Implementation (Node.js/Express Example)

#### 1. Middleware: Check Permission

```javascript
// middleware/checkPermission.js
const checkPermission = (permission) => {
  return async (req, res, next) => {
    try {
      const user = req.user; // From authentication middleware

      // Check if user has permission
      const hasPermission = await hasUserPermission(user.id, permission);

      if (!hasPermission) {
        return res.status(403).json({
          error: 'Forbidden',
          message: `You do not have permission: ${permission}`
        });
      }

      next();
    } catch (error) {
      return res.status(500).json({ error: 'Internal server error' });
    }
  };
};

// Helper function to check user permission
async function hasUserPermission(userId, permission) {
  // Get user roles
  const userRoles = await db.query(`
    SELECT role_id FROM user_roles WHERE user_id = ?
  `, [userId]);

  // Check wildcard permission (admin)
  const hasWildcard = await db.query(`
    SELECT COUNT(*) as count FROM role_permissions rp
    JOIN permissions p ON rp.permission_id = p.id
    WHERE rp.role_id IN (?) AND p.permission_key = '*' AND rp.granted = TRUE
  `, [userRoles.map(r => r.role_id)]);

  if (hasWildcard[0].count > 0) return true;

  // Check specific permission
  const hasSpecific = await db.query(`
    SELECT COUNT(*) as count FROM role_permissions rp
    JOIN permissions p ON rp.permission_id = p.id
    WHERE rp.role_id IN (?) AND p.permission_key = ? AND rp.granted = TRUE
  `, [userRoles.map(r => r.role_id), permission]);

  if (hasSpecific[0].count > 0) return true;

  // Check custom user permissions
  const hasCustom = await db.query(`
    SELECT COUNT(*) as count FROM user_custom_permissions ucp
    JOIN permissions p ON ucp.permission_id = p.id
    WHERE ucp.user_id = ? AND p.permission_key = ? AND ucp.granted = TRUE
  `, [userId, permission]);

  return hasCustom[0].count > 0;
}

module.exports = { checkPermission };
```

#### 2. Route Protection Example

```javascript
// routes/patients.js
const express = require('express');
const router = express.Router();
const { checkPermission } = require('../middleware/checkPermission');
const { authenticate } = require('../middleware/auth');

// All routes require authentication
router.use(authenticate);

// View patients
router.get('/', checkPermission('patients.view'), async (req, res) => {
  // Handler code
});

// Create patient
router.post('/', checkPermission('patients.create'), async (req, res) => {
  // Handler code
});

// Edit patient
router.put('/:id', checkPermission('patients.edit'), async (req, res) => {
  // Handler code
});

// Delete patient
router.delete('/:id', checkPermission('patients.delete'), async (req, res) => {
  // Handler code
});

module.exports = router;
```

#### 3. Audit Logging

```javascript
// middleware/auditLog.js
const auditLog = (action, resourceType) => {
  return async (req, res, next) => {
    // Store original send
    const originalSend = res.send;

    // Override send
    res.send = function(data) {
      // Log the action
      logAction(
        req.user.id,
        action,
        resourceType,
        req.params.id || null,
        req.body,
        req.ip,
        req.get('User-Agent')
      );

      // Call original send
      originalSend.call(this, data);
    };

    next();
  };
};

async function logAction(userId, action, resourceType, resourceId, data, ip, userAgent) {
  await db.query(`
    INSERT INTO audit_log (user_id, action, resource_type, resource_id, new_values, ip_address, user_agent)
    VALUES (?, ?, ?, ?, ?, ?, ?)
  `, [userId, action, resourceType, resourceId, JSON.stringify(data), ip, userAgent]);
}

module.exports = { auditLog };
```

### Frontend Implementation (Vue.js Example)

#### 1. Permission Directive

```javascript
// directives/permission.js
export default {
  mounted(el, binding, vnode) {
    const { value } = binding;
    const user = vnode.ctx.$store.state.user;

    if (value && !hasPermission(user, value)) {
      el.parentNode && el.parentNode.removeChild(el);
    }
  }
};

function hasPermission(user, permission) {
  if (!user || !user.permissions) return false;

  // Check wildcard
  if (user.permissions.includes('*')) return true;

  // Check exact match
  if (user.permissions.includes(permission)) return true;

  // Check wildcard module (e.g., "patients.*")
  const [module] = permission.split('.');
  if (user.permissions.includes(`${module}.*`)) return true;

  return false;
}
```

#### 2. Using Permission Directive

```vue
<template>
  <div>
    <!-- Button visible only if user has permission -->
    <button v-permission="'patients.create'" @click="createPatient">
      Create Patient
    </button>

    <!-- Edit button -->
    <button v-permission="'patients.edit'" @click="editPatient">
      Edit Patient
    </button>

    <!-- Delete button -->
    <button v-permission="'patients.delete'" @click="deletePatient">
      Delete Patient
    </button>
  </div>
</template>

<script setup>
// Component logic
</script>
```

#### 3. Permission Composable

```javascript
// composables/usePermission.js
import { computed } from 'vue';
import { useStore } from 'vuex';

export function usePermission() {
  const store = useStore();

  const hasPermission = (permission) => {
    const user = store.state.user;

    if (!user || !user.permissions) return false;

    // Check wildcard
    if (user.permissions.includes('*')) return true;

    // Check exact match
    if (user.permissions.includes(permission)) return true;

    // Check wildcard module
    const [module] = permission.split('.');
    if (user.permissions.includes(`${module}.*`)) return true;

    return false;
  };

  const hasAnyPermission = (permissions) => {
    return permissions.some(p => hasPermission(p));
  };

  const hasAllPermissions = (permissions) => {
    return permissions.every(p => hasPermission(p));
  };

  return {
    hasPermission,
    hasAnyPermission,
    hasAllPermissions
  };
}
```

#### 4. Route Guards

```javascript
// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/patients',
      component: () => import('../pages/sections/Patients/PatientsView.vue'),
      meta: { requiresAuth: true, permission: 'patients.view' }
    },
    {
      path: '/appointments',
      component: () => import('../pages/sections/Appointments/AppointmentsView.vue'),
      meta: { requiresAuth: true, permission: 'appointments.view_all' }
    },
    {
      path: '/settings',
      component: () => import('../pages/sections/SettingsView.vue'),
      meta: { requiresAuth: true, permission: 'settings.view' }
    }
  ]
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const permission = to.meta.permission;
  const user = store.state.user;

  if (requiresAuth && !user) {
    next('/login');
    return;
  }

  if (permission && !hasPermission(user, permission)) {
    next('/unauthorized');
    return;
  }

  next();
});

function hasPermission(user, permission) {
  if (!user || !user.permissions) return false;
  if (user.permissions.includes('*')) return true;
  if (user.permissions.includes(permission)) return true;

  const [module] = permission.split('.');
  if (user.permissions.includes(`${module}.*`)) return true;

  return false;
}

export default router;
```

---

## Security Best Practices

### 1. Password Policies
- Minimum 12 characters
- Require uppercase, lowercase, numbers, symbols
- Password expiration (90 days for privileged users)
- No password reuse (last 10 passwords)
- Account lockout after 5 failed attempts

### 2. Session Management
- JWT tokens with short expiration (15 minutes)
- Refresh tokens (7 days)
- Automatic logout after inactivity (30 minutes)
- Concurrent session limits (3 devices)

### 3. Multi-Factor Authentication (MFA)
- Required for admin roles
- Optional for other roles
- TOTP (Time-based One-Time Password)
- Backup codes

### 4. IP Whitelisting
- Optional for practices
- Restrict access by IP range
- Override for emergency access

### 5. Audit Logging
- Log all PHI access
- Log all data modifications
- Log all permission changes
- Log all login attempts
- Retain logs for 7 years (HIPAA requirement)

### 6. Data Encryption
- Encrypt data at rest (AES-256)
- Encrypt data in transit (TLS 1.3)
- Encrypt backups
- Secure key management

### 7. Regular Security Audits
- Quarterly permission reviews
- Annual penetration testing
- Vulnerability scanning
- User access reviews

---

## Document End

This ACL documentation provides a comprehensive framework for implementing role-based access control in NymoDental, ensuring HIPAA compliance and secure, granular access to patient data and system features.
