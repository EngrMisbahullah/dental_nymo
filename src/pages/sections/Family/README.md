# Family Management Module

A modern, comprehensive family management system for NymoDental - built to exceed the functionality of Open Dental with a superior UI/UX.

## 📁 File Structure

```
Family/
├── FamilyView.vue                    # Main family management page
├── Components/
│   ├── AddFamilyMember.vue          # Modal to add/link family members
│   ├── FamilyAccountOverview.vue    # Family account balance & overview
│   ├── InsurancePlans.vue           # Manage patient insurance plans
│   ├── PatientInformation.vue       # View/edit patient details
│   └── RecallManagement.vue         # Manage dental recalls & appointments
└── README.md                         # This file
```

## ✨ Features

### 🎯 Core Functionality

#### Family Members Management
- **View all family members** in a clean, modern table
- **Add new members** via:
  - Link existing patients from database
  - Create new patient records directly
- **Remove family members** with confirmation
- **Set guarantor** (primary account holder)
- **View member details**:
  - Name, relationship, gender, age
  - Status (Active/Inactive/Pending)
  - Recall due dates with overdue highlighting
  - Role (Guarantor/Dependent)

#### Patient Picture
- Upload/view patient photos
- Clean placeholder for patients without photos
- Quick patient identification

#### Recall Management
- View all recalls by type (Prophy, Perio, Exam, X-Rays)
- Track intervals and due dates
- Add custom recalls
- Overdue highlighting
- Schedule recall appointments
- Add recall notes

#### Patient Information
- View complete patient details
- Edit contact information
- Update patient status
- Display relationship and role
- Age calculation

#### Insurance Plans
- Add multiple insurance plans per patient
- Track primary, secondary, tertiary coverage
- Monitor policy details:
  - Provider name
  - Policy & group numbers
  - Coverage percentage
  - Expiry dates (with warnings)
  - Status
- Remove insurance plans

#### Family Account Overview
- Total family balance display
- Individual member balances
- Account holder information
- Insurance provider
- Family member count
- Quick access to invoices and payments

### 🎨 UI/UX Improvements Over Open Dental

1. **Modern Design**
   - Clean card-based layout
   - Smooth transitions and hover effects
   - Color-coded status badges
   - Intuitive iconography

2. **Better Organization**
   - Grid layout for optimal space usage
   - Clear visual hierarchy
   - Grouped related information
   - Responsive design

3. **Enhanced Interactions**
   - Modal-based workflows (no page navigation)
   - Real-time search and filtering
   - Visual feedback on actions
   - Inline editing capabilities

4. **Improved Visuals**
   - Gradient backgrounds for important info
   - Status-based color coding
   - Icon-enhanced labels
   - Professional typography

## 🚀 Usage

### Accessing the Module

1. Click the **Family** icon (fa-users) in the sidebar
2. Or navigate to `/dashboard/family`

### Adding a Family Member

**Option 1: Link Existing Patient**
1. Click "Add Member" button
2. Select "Link Existing Patient" tab
3. Search for patient by name, ID, or phone
4. Select patient from results
5. Choose relationship type
6. Click "Add to Family"

**Option 2: Create New Patient**
1. Click "Add Member" button
2. Select "Create New Patient" tab
3. Fill in required details:
   - First & Last Name
   - Date of Birth
   - Gender
   - Relationship
4. Optional: Add phone, email, address
5. Check "Set as Guarantor" if applicable
6. Click "Add to Family"

### Managing Recalls

1. Select a family member from the table
2. View existing recalls in the Recall Management card
3. Click "Add New Recall" to create new recall:
   - Choose recall type
   - Set interval
   - Select due date
4. Click "Schedule Recall Appointment" to book

### Managing Insurance

1. Select a family member
2. In Insurance Plans card, click the "+" button
3. Fill in insurance details:
   - Type (Primary/Secondary/Tertiary)
   - Provider name
   - Policy & group numbers
   - Coverage percentage
   - Expiry date
4. Click "Add Plan"

### Viewing Account Overview

- The Family Account Overview card shows:
  - Total family balance (all members combined)
  - Individual member balances
  - Quick access to invoices and payment options

## 🎨 Design System

### Colors

- **Primary**: #4f46e5 (Indigo)
- **Success**: #10b981 (Green)
- **Warning**: #f59e0b (Amber)
- **Danger**: #dc2626 (Red)
- **Info**: #3b82f6 (Blue)
- **Purple**: #8b5cf6 (For insurance)

### Status Colors

- **Active**: Green background
- **Inactive**: Red background
- **Pending**: Yellow background
- **Overdue**: Red text

### Icons

- Family: `fa-users`
- Add Member: `fa-user-plus`
- Remove: `fa-user-minus`
- Guarantor: `fa-star`
- Insurance: `fa-shield-alt`
- Recall: `fa-calendar-check`
- Patient Info: `fa-user-circle`
- Account: `fa-wallet`

## 📊 Mock Data

The module currently uses mock data for demonstration. To integrate with backend:

1. Replace mock data in `FamilyView.vue` with API calls
2. Update component `@add`, `@update`, `@delete` handlers
3. Connect to backend endpoints:
   - `GET /api/families`
   - `POST /api/families/{id}/members`
   - `PUT /api/patients/{id}`
   - `GET /api/patients`
   - `POST /api/recalls`
   - `POST /api/insurance`

## 🔄 Future Enhancements

- [ ] Family tree visualization (drag-drop)
- [ ] Bulk operations on family members
- [ ] Family-wide appointment scheduling
- [ ] Export family report (PDF)
- [ ] Payment history for entire family
- [ ] Shared notes across family
- [ ] Family communication preferences
- [ ] Insurance eligibility checks
- [ ] Auto-recall scheduling
- [ ] SMS/Email reminders

## 📱 Responsive Design

The module is fully responsive:

- **Desktop**: Full grid layout with sidebar
- **Tablet**: Stacked layout, optimized cards
- **Mobile**: Single column, collapsible sections

## 🔐 Permissions (Future)

Role-based access control to be implemented:

- **Admin**: Full access
- **Dentist**: View/edit patient info, recalls, insurance
- **Reception**: View, add members, schedule recalls
- **Billing**: View account overview, insurance

## 📝 Notes

- Guarantor cannot be deleted (must reassign first)
- Each family must have at least one guarantor
- Insurance plans are patient-specific, not family-wide
- Recall dates automatically highlight when overdue
- All monetary values are in GBP (£)

---

**Built with Vue 3 Composition API**
**Styled with modern CSS (no external UI library)**
**Icons from Font Awesome**
