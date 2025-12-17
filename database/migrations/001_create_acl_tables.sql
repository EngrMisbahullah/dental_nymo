-- ========================================
-- NymoDental ACL Database Schema
-- Phase 1: Basic Role-Based Access Control
-- ========================================

-- ========================================
-- 1. PRACTICES TABLE (Multi-tenancy support)
-- ========================================
CREATE TABLE IF NOT EXISTS practices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(50),
    postal_code VARCHAR(20),
    country VARCHAR(100) DEFAULT 'United Kingdom',
    phone VARCHAR(20),
    email VARCHAR(255),
    website VARCHAR(255),
    logo_url VARCHAR(500),
    timezone VARCHAR(50) DEFAULT 'Europe/London',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_is_active (is_active)
);

-- ========================================
-- 2. ROLES TABLE (5 Basic Roles)
-- ========================================
CREATE TABLE IF NOT EXISTS roles (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    hierarchy_level INT NOT NULL DEFAULT 3,
    is_staff BOOLEAN DEFAULT TRUE,
    is_provider BOOLEAN DEFAULT FALSE,
    is_external BOOLEAN DEFAULT FALSE,
    color VARCHAR(7) DEFAULT '#6B7280',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- 3. PERMISSIONS TABLE (Module-level)
-- ========================================
CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permission_key VARCHAR(100) UNIQUE NOT NULL,
    module VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_module (module)
);

-- ========================================
-- 4. ROLE_PERMISSIONS TABLE (Many-to-Many)
-- ========================================
CREATE TABLE IF NOT EXISTS role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id VARCHAR(50) NOT NULL,
    permission_id INT NOT NULL,
    granted BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_role_permission (role_id, permission_id),
    INDEX idx_role (role_id),
    INDEX idx_permission (permission_id)
);

-- ========================================
-- 5. USERS TABLE (Staff and External Users)
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    practice_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    avatar_url VARCHAR(500),
    is_active BOOLEAN DEFAULT TRUE,
    is_locked BOOLEAN DEFAULT FALSE,
    failed_login_attempts INT DEFAULT 0,
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    password_changed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (practice_id) REFERENCES practices(id) ON DELETE CASCADE,
    UNIQUE KEY unique_email_per_practice (practice_id, email),
    INDEX idx_email (email),
    INDEX idx_practice (practice_id),
    INDEX idx_is_active (is_active)
);

-- ========================================
-- 6. USER_ROLES TABLE (Many-to-Many)
-- ========================================
CREATE TABLE IF NOT EXISTS user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id VARCHAR(50) NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assigned_by INT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_role (user_id, role_id),
    INDEX idx_user (user_id),
    INDEX idx_role (role_id)
);

-- ========================================
-- 7. AUDIT_LOG TABLE (Track all actions)
-- ========================================
CREATE TABLE IF NOT EXISTS audit_log (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    practice_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    resource_type VARCHAR(50) NOT NULL,
    resource_id INT NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (practice_id) REFERENCES practices(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_practice (practice_id),
    INDEX idx_action (action),
    INDEX idx_resource (resource_type, resource_id),
    INDEX idx_created (created_at)
);

-- ========================================
-- 8. SESSIONS TABLE (JWT token management)
-- ========================================
CREATE TABLE IF NOT EXISTS sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    refresh_token VARCHAR(500) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_refresh_token (refresh_token(255)),
    INDEX idx_expires (expires_at),
    INDEX idx_is_active (is_active)
);

-- ========================================
-- SEED DATA: Insert Default Roles
-- ========================================

INSERT INTO roles (id, name, description, hierarchy_level, is_staff, is_provider, is_external, color) VALUES
('ROLE_ADMIN', 'Practice Owner/Admin', 'Practice owner or administrator with full system access', 1, TRUE, FALSE, FALSE, '#DC2626'),
('ROLE_DENTIST', 'Dentist/Provider', 'Licensed dentist providing clinical services', 2, TRUE, TRUE, FALSE, '#2563EB'),
('ROLE_HYGIENIST', 'Dental Hygienist', 'Licensed hygienist providing preventive services', 3, TRUE, TRUE, FALSE, '#16A34A'),
('ROLE_FRONT_DESK', 'Front Desk/Receptionist', 'Front office staff managing appointments and patient flow', 3, TRUE, FALSE, FALSE, '#9333EA'),
('ROLE_PATIENT', 'Patient', 'Patient with access to personal portal', 0, FALSE, FALSE, TRUE, '#0891B2');

-- ========================================
-- SEED DATA: Insert Default Permissions
-- ========================================

-- Dashboard Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('dashboard', 'dashboard', 'Access dashboard'),
('dashboard.analytics', 'dashboard', 'Access advanced analytics');

-- Patient Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('patients', 'patients', 'Access patient module'),
('patients.view', 'patients', 'View patient list and details'),
('patients.create', 'patients', 'Create new patients'),
('patients.edit', 'patients', 'Edit patient information'),
('patients.delete', 'patients', 'Delete patients');

-- Appointment Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('appointments', 'appointments', 'Access appointment module'),
('appointments.view_all', 'appointments', 'View all appointments'),
('appointments.view_own', 'appointments', 'View own appointments only'),
('appointments.create', 'appointments', 'Create appointments'),
('appointments.edit', 'appointments', 'Edit appointments'),
('appointments.delete', 'appointments', 'Delete appointments');

-- Clinical Chart Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('chart', 'chart', 'Access clinical charts'),
('chart.view', 'chart', 'View dental charts'),
('chart.edit', 'chart', 'Edit dental charts');

-- Clinical Notes Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('notes', 'notes', 'Access clinical notes'),
('notes.view', 'notes', 'View clinical notes'),
('notes.create', 'notes', 'Create clinical notes'),
('notes.edit', 'notes', 'Edit clinical notes');

-- Treatment Plan Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('treatment_plans', 'treatment_plans', 'Access treatment plans'),
('treatment_plans.view', 'treatment_plans', 'View treatment plans'),
('treatment_plans.create', 'treatment_plans', 'Create treatment plans'),
('treatment_plans.edit', 'treatment_plans', 'Edit treatment plans');

-- Imaging Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('imaging', 'imaging', 'Access imaging module'),
('imaging.view', 'imaging', 'View images and X-rays'),
('imaging.upload', 'imaging', 'Upload images'),
('imaging.edit', 'imaging', 'Edit/annotate images');

-- Prescription Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('prescriptions', 'prescriptions', 'Access prescriptions module'),
('prescriptions.view', 'prescriptions', 'View prescriptions'),
('prescriptions.create', 'prescriptions', 'Create prescriptions');

-- Financial Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('financials', 'financials', 'Access financial module'),
('financials.view', 'financials', 'View financial information'),
('financials.manage', 'financials', 'Manage payments and billing');

-- Insurance Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('insurance', 'insurance', 'Access insurance module'),
('insurance.view', 'insurance', 'View insurance information'),
('insurance.manage', 'insurance', 'Manage insurance claims');

-- Reports Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('reports', 'reports', 'Access reports module'),
('reports.view', 'reports', 'View reports'),
('reports.financial', 'reports', 'View financial reports');

-- Settings Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('settings', 'settings', 'Access practice settings'),
('settings.view', 'settings', 'View settings'),
('settings.edit', 'settings', 'Edit settings');

-- User Management Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('users', 'users', 'Access user management'),
('users.view', 'users', 'View users'),
('users.create', 'users', 'Create users'),
('users.edit', 'users', 'Edit users'),
('users.delete', 'users', 'Delete users');

-- Communication Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('communication', 'communication', 'Access communication module'),
('communication.send', 'communication', 'Send messages to patients');

-- Patient Portal Permissions
INSERT INTO permissions (permission_key, module, description) VALUES
('portal', 'portal', 'Access patient portal'),
('portal.appointments', 'portal', 'Manage own appointments via portal'),
('portal.payments', 'portal', 'Make payments via portal');

-- ========================================
-- SEED DATA: Assign Permissions to Roles
-- ========================================

-- ROLE_ADMIN: Full Access (All Permissions)
INSERT INTO role_permissions (role_id, permission_id, granted)
SELECT 'ROLE_ADMIN', id, TRUE FROM permissions;

-- ROLE_DENTIST: Clinical Full Access + Limited Financial
INSERT INTO role_permissions (role_id, permission_id, granted)
SELECT 'ROLE_DENTIST', id, TRUE FROM permissions WHERE permission_key IN (
    'dashboard', 'dashboard.analytics',
    'patients', 'patients.view', 'patients.create', 'patients.edit',
    'appointments', 'appointments.view_all', 'appointments.create', 'appointments.edit', 'appointments.delete',
    'chart', 'chart.view', 'chart.edit',
    'notes', 'notes.view', 'notes.create', 'notes.edit',
    'treatment_plans', 'treatment_plans.view', 'treatment_plans.create', 'treatment_plans.edit',
    'imaging', 'imaging.view', 'imaging.upload', 'imaging.edit',
    'prescriptions', 'prescriptions.view', 'prescriptions.create',
    'financials', 'financials.view',
    'insurance', 'insurance.view',
    'reports', 'reports.view', 'reports.financial',
    'communication', 'communication.send'
);

-- ROLE_HYGIENIST: Limited Clinical Access
INSERT INTO role_permissions (role_id, permission_id, granted)
SELECT 'ROLE_HYGIENIST', id, TRUE FROM permissions WHERE permission_key IN (
    'dashboard',
    'patients', 'patients.view', 'patients.edit',
    'appointments', 'appointments.view_own', 'appointments.create', 'appointments.edit',
    'chart', 'chart.view', 'chart.edit',
    'notes', 'notes.view', 'notes.create', 'notes.edit',
    'treatment_plans', 'treatment_plans.view',
    'imaging', 'imaging.view', 'imaging.upload',
    'prescriptions', 'prescriptions.view',
    'financials.view',
    'communication', 'communication.send'
);

-- ROLE_FRONT_DESK: Scheduling + Demographics + Limited Financial
INSERT INTO role_permissions (role_id, permission_id, granted)
SELECT 'ROLE_FRONT_DESK', id, TRUE FROM permissions WHERE permission_key IN (
    'dashboard',
    'patients', 'patients.view', 'patients.create', 'patients.edit',
    'appointments', 'appointments.view_all', 'appointments.create', 'appointments.edit', 'appointments.delete',
    'financials', 'financials.view', 'financials.manage',
    'insurance', 'insurance.view',
    'communication', 'communication.send'
);

-- ROLE_PATIENT: Portal Only (Own Data)
INSERT INTO role_permissions (role_id, permission_id, granted)
SELECT 'ROLE_PATIENT', id, TRUE FROM permissions WHERE permission_key IN (
    'portal', 'portal.appointments', 'portal.payments'
);

-- ========================================
-- END OF MIGRATION
-- ========================================
