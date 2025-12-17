# Missing Frontend Functionality

This document outlines the frontend components and features that need to be built to match the reference dental practice management system.

---

## 1. Family Module - Complete Module Missing

### Overview
A complete patient family management system to link family members together and manage shared accounts.

### Components to Build

```
📁 src/pages/sections/Family/
  ├── FamilyView.vue (main family management page)
  ├── Components/
  │   ├── FamilyTree.vue (visual family relationship tree)
  │   ├── AddFamilyMember.vue (link new family member)
  │   └── FamilyAccountOverview.vue (shared financial summary)
```

### Features Required

#### FamilyView.vue
- Search and select family groups
- Display all family members in a list/card view
- Quick add/remove family members
- Family-wide appointment scheduling
- Shared account balance overview

#### FamilyTree.vue
- Visual tree diagram showing relationships
- Drag-and-drop to reorganize family structure
- Color-coded nodes (parents, children, siblings, spouses)
- Clickable nodes to view member details
- Relationship labels (Mother, Father, Child, Sibling, Spouse, etc.)

#### AddFamilyMember.vue
- Modal/drawer to link existing patients to family
- Search existing patient database
- Create new family member (quick add form)
- Define relationship type (dropdown)
- Set primary account holder
- Family member roles (guarantor, dependent, etc.)

#### FamilyAccountOverview.vue
- Combined family account balance
- Individual member balances
- Payment history for entire family
- Outstanding invoices
- Family insurance coverage

### UI/UX Requirements
- Sidebar icon: `fa-people-group` or `fa-users`
- Clean card-based layout
- Quick filters (show adults only, children only, etc.)
- Export family report functionality
- Print family summary

### Data Structure (Frontend Mock Data)
```javascript
{
  familyId: 1,
  familyName: "Smith Family",
  primaryAccountHolder: {
    patientId: 101,
    name: "John Smith",
    relationship: "Head of Household"
  },
  members: [
    {
      patientId: 101,
      name: "John Smith",
      relationship: "Self",
      dob: "1980-05-15",
      role: "Guarantor"
    },
    {
      patientId: 102,
      name: "Jane Smith",
      relationship: "Spouse",
      dob: "1982-08-22",
      role: "Dependent"
    },
    {
      patientId: 103,
      name: "Emma Smith",
      relationship: "Daughter",
      dob: "2010-03-10",
      role: "Dependent"
    }
  ],
  totalBalance: 1250.00,
  insuranceProvider: "Delta Dental"
}
```

---

## 2. Imaging Module - Complete Module Missing

### Overview
Dental imaging management system for X-rays, photographs, and scans with annotation and comparison tools.

### Components to Build

```
📁 src/pages/sections/Imaging/
  ├── ImagingView.vue (main imaging page)
  ├── Components/
  │   ├── ImageViewer.vue (lightbox/zoom viewer)
  │   ├── ImageUpload.vue (drag-drop upload)
  │   ├── ImageAnnotation.vue (draw on images)
  │   ├── ImageComparison.vue (before/after slider)
  │   └── ImageGallery.vue (grid view of patient images)
```

### Features Required

#### ImagingView.vue
- Patient selector dropdown
- Image type filter (X-Ray, Photo, Scan, CBCT)
- Date range filter
- Tooth number filter
- Grid/list view toggle
- Bulk upload functionality
- Export/print selected images

#### ImageViewer.vue
- Full-screen lightbox modal
- Zoom in/out controls (mouse wheel, pinch, buttons)
- Pan functionality (click and drag)
- Rotate image (90° increments)
- Brightness/contrast adjustments
- Image metadata display (date, type, notes)
- Previous/Next navigation
- Download original image
- Delete image (with confirmation)

#### ImageUpload.vue
- Drag-and-drop upload zone
- Multi-file selection
- Progress bar for uploads
- File type validation (JPEG, PNG, DICOM, etc.)
- Image preview before upload
- Add metadata form:
  - Image type dropdown
  - Tooth number(s)
  - Date taken
  - Notes/description
  - Practitioner who took image

#### ImageAnnotation.vue
- Drawing tools:
  - Freehand pen
  - Arrow
  - Circle/ellipse
  - Rectangle
  - Text annotation
- Color picker for annotations
- Line thickness control
- Undo/redo functionality
- Save annotated version
- Toggle annotations on/off
- Multiple annotation layers

#### ImageComparison.vue
- Side-by-side view (2 images)
- Before/after slider (overlay with draggable divider)
- Synchronized zoom/pan
- Treatment progress tracking
- Date labels on images
- Difference highlighting mode

#### ImageGallery.vue
- Responsive grid layout (thumbnail view)
- Thumbnail size slider
- Sort by date, type, tooth number
- Multi-select with checkboxes
- Batch operations (download, delete, tag)
- Infinite scroll or pagination
- Image count badge
- Quick preview on hover

### UI/UX Requirements
- Sidebar icon: `fa-camera` or `fa-x-ray`
- Clean, minimal interface (focus on images)
- Keyboard shortcuts:
  - `Space` = Next image
  - `Esc` = Close viewer
  - `+/-` = Zoom in/out
  - `Arrow keys` = Navigate
- Touch/gesture support for tablets
- Print-friendly layout

### Supported File Formats
- JPEG/JPG
- PNG
- DICOM (X-ray standard)
- TIFF
- BMP
- PDF (for scanned documents)

### Data Structure (Frontend Mock Data)
```javascript
{
  imageId: 1,
  patientId: 101,
  patientName: "John Smith",
  imageType: "X-Ray",
  toothNumbers: [14, 15],
  dateTaken: "2025-10-28",
  uploadedBy: "Dr. Sarah Lexington",
  fileUrl: "/storage/images/xray_001.jpg",
  thumbnailUrl: "/storage/images/thumbnails/xray_001_thumb.jpg",
  fileSize: "2.4 MB",
  dimensions: "1920x1080",
  notes: "Pre-treatment bitewing radiograph",
  annotations: [
    {
      type: "arrow",
      x1: 100, y1: 150,
      x2: 200, y2: 180,
      color: "#FF0000",
      thickness: 2
    }
  ]
}
```

---

## 3. Waiting Room Panel - Missing from Appointments

### Overview
Real-time waiting room status panel to track patients from check-in to check-out.

### Component to Build

```
📁 src/pages/sections/Appointments/Components/
  └── WaitingRoomPanel.vue
```

### Features Required

#### WaitingRoomPanel.vue
- Located on right side of Scheduler view (similar to reference screenshot)
- Real-time patient status display
- Color-coded status badges
- Auto-updating wait times
- Check-in/check-out buttons
- Patient queue order

### Status Workflow
```
Unconfirmed → Confirmed → Arrived → Ready → InRoom → ChkOut → Completed
```

### Status Badge Colors
- **Unconfirmed**: Gray (#9E9E9E)
- **Confirmed**: Blue (#2196F3)
- **Arrived**: Yellow (#FFC107)
- **Ready**: Green (#4CAF50)
- **InRoom**: Purple (#9C27B0)
- **ChkOut**: Teal (#009688)
- **Completed**: Dark Green (#1B5E20)

### UI Layout
```
┌─────────────────────────────┐
│     Waiting Room            │
│  ┌─────────────┬──────────┐ │
│  │   Patient   │  Waited  │ │
│  ├─────────────┼──────────┤ │
│  │ John Smith  │  5 min   │ │
│  │ [Ready]     │          │ │
│  ├─────────────┼──────────┤ │
│  │ Jane Doe    │  12 min  │ │
│  │ [Arrived]   │          │ │
│  └─────────────┴──────────┘ │
└─────────────────────────────┘
```

### Features
- Auto-calculate wait time (current time - arrival time)
- Click patient to view appointment details
- Quick status change dropdown
- Sort by wait time or arrival time
- Filter by practitioner
- Audio/visual alert for long wait times (>20 min)
- Empty state message when no patients waiting

### Data Structure (Frontend Mock Data)
```javascript
{
  appointmentId: 1,
  patientName: "John Smith",
  practitionerName: "Dr. Sarah Lexington",
  appointmentTime: "10:00 AM",
  checkInTime: "09:55 AM",
  currentStatus: "Ready",
  waitTime: 5, // minutes
  statusHistory: [
    { status: "Confirmed", timestamp: "2025-11-01 08:30:00" },
    { status: "Arrived", timestamp: "2025-11-01 09:55:00" },
    { status: "Ready", timestamp: "2025-11-01 10:00:00" }
  ]
}
```

---

## 4. Appointment Quick Actions - Missing Toolbar

### Overview
Quick action toolbar for common appointment operations (similar to reference screenshot top toolbar).

### Component to Build

```
📁 src/pages/sections/Appointments/Components/
  └── AppointmentQuickActions.vue
```

### Features Required

#### Action Buttons
1. **Select Patient** - Dropdown to choose active patient
2. **Make Appt** - Open new appointment modal
3. **Make Recall** - Schedule follow-up/recall appointment
4. **Unsched** - Unschedule selected appointment
5. **Break** - Add break/blocked time to schedule
6. **Complete** - Mark appointment as completed
7. **Delete** - Delete appointment (with confirmation)
8. **Rapid Call** - Quick phone call log

### UI Layout
```
┌──────────────────────────────────────────────────────────────┐
│ [Select Patient ▼] [Make Appt] [Make Recall] [Unsched]      │
│ [Break] [Complete] [Delete] [Rapid Call]                     │
└──────────────────────────────────────────────────────────────┘
```

### Button Specifications

#### Select Patient Dropdown
- Searchable dropdown
- Shows recent patients
- Display patient name and ID
- Avatar/photo if available
- Keyboard navigation (type to search)

#### Make Appt Button
- Opens NewAppointment.vue modal
- Pre-fill selected patient if one is chosen
- Focus on date/time picker

#### Make Recall Button
- Opens NewAppointment.vue modal
- Pre-fill with recall appointment type
- Suggest date based on last appointment + recall interval (e.g., 6 months)
- Default duration based on appointment type

#### Unsched Button
- Enabled only when appointment is selected
- Confirmation dialog: "Are you sure you want to unschedule this appointment?"
- Move appointment to waiting list option
- Send notification to patient option

#### Break Button
- Opens time block modal
- Select practitioner
- Select date/time range
- Reason dropdown (Lunch, Meeting, Personal, etc.)
- Recurring break option (e.g., daily lunch 12-1pm)

#### Complete Button
- Enabled only when appointment is selected
- One-click mark as completed
- Update appointment status to "Completed"
- Prompt to add clinical notes (optional)

#### Delete Button
- Enabled only when appointment is selected
- Confirmation dialog with warning
- Reason for deletion dropdown (Patient cancelled, No show, etc.)
- Cannot delete completed appointments (soft delete only)

#### Rapid Call Button
- Quick log modal
- Patient selector
- Call type (Reminder, Follow-up, Enquiry)
- Notes textarea
- Log call button

### Button States
- **Enabled**: Full color, clickable
- **Disabled**: Grayed out (when no appointment selected)
- **Loading**: Spinner icon during API call
- **Success**: Green checkmark flash on success

### Keyboard Shortcuts
- `Ctrl + N` = Make Appt
- `Ctrl + R` = Make Recall
- `Ctrl + B` = Break
- `Delete` = Delete appointment
- `Enter` = Complete appointment

---

## 5. Week View - Only Day View Exists

### Overview
Week calendar view to see multiple days of appointments simultaneously.

### Component to Build

```
📁 src/pages/sections/Appointments/Components/
  └── WeekViewScheduler.vue
```

### Features Required

#### Week View Layout
- 7 columns (Monday - Sunday) or 5 columns (Mon - Fri, configurable)
- Time slots on Y-axis (8am - 6pm, configurable)
- Multiple practitioner rows per day (optional toggle)
- Current day highlighted
- Today indicator line

#### View Toggle
```
┌─────────────────────────────┐
│  [Day] [Week] [Month]       │
└─────────────────────────────┘
```

- Toggle between Day, Week, Month views
- Persist user preference (localStorage)
- Smooth transition between views

#### Week View Specific Features
- **Week Navigation**:
  - Previous week (`<` button)
  - Next week (`>` button)
  - Jump to today button
  - Week number display (e.g., "Week 44, 2025")
  - Date range display (e.g., "Oct 28 - Nov 3, 2025")

- **Appointment Display**:
  - Smaller appointment cards (fit more on screen)
  - Show time + patient name only (hide details)
  - Color-coded by appointment type
  - Tooltip on hover (full details)
  - Click to expand/edit

- **Multi-day Appointments**:
  - Span across multiple days if needed
  - Visual connector between days

- **Practitioner Filter**:
  - Checkbox list to show/hide practitioners
  - "Select All" / "Deselect All" buttons
  - Color-coded practitioner rows

#### Responsive Behavior
- Desktop: Show full 7 days
- Tablet: Show 5 days (Mon-Fri)
- Mobile: Show 3 days, swipe to navigate

#### Performance Optimization
- Virtualized scrolling for time slots
- Lazy load appointments as user scrolls
- Cache week data to reduce API calls

### UI Layout
```
┌─────────────────────────────────────────────────────────────────────┐
│  Week 44, 2025  |  Oct 28 - Nov 3, 2025                   [Day ▼]  │
│  [< Prev]  [Today]  [Next >]                                        │
├──────┬──────┬──────┬──────┬──────┬──────┬──────┬──────────────────┤
│ Time │ Mon  │ Tue  │ Wed  │ Thu  │ Fri  │ Sat  │ Sun  │            │
│      │  28  │  29  │  30  │  31  │  1   │  2   │  3   │            │
├──────┼──────┼──────┼──────┼──────┼──────┼──────┼──────┤            │
│ 8am  │      │      │[Appt]│      │      │      │      │ Practitioner│
│ 9am  │[Appt]│      │[Appt]│[Appt]│      │      │      │ Filter      │
│ 10am │      │[Appt]│      │      │[Appt]│      │      │ □ Dr. Smith │
│ 11am │[Appt]│      │      │[Appt]│      │      │      │ ☑ Dr. Jones │
│ ...  │      │      │      │      │      │      │      │             │
└──────┴──────┴──────┴──────┴──────┴──────┴──────┴──────┴─────────────┘
```

### Data Structure
```javascript
{
  weekStart: "2025-10-28",
  weekEnd: "2025-11-03",
  weekNumber: 44,
  days: [
    {
      date: "2025-10-28",
      dayName: "Monday",
      isToday: false,
      appointments: [
        {
          appointmentId: 1,
          patientName: "John Smith",
          practitionerId: 2,
          practitionerName: "Dr. Jones",
          startTime: "09:00",
          endTime: "09:30",
          appointmentType: "Exam",
          color: "#4CAF50"
        }
      ]
    },
    // ... 6 more days
  ]
}
```

---

## Implementation Priority

### Phase 1 - Critical (Immediate)
1. **Waiting Room Panel** - Essential for daily operations
2. **Appointment Quick Actions** - Core workflow efficiency

### Phase 2 - Important (Short-term)
3. **Week View Scheduler** - Better scheduling visibility
4. **Family Module** - Patient relationship management

### Phase 3 - Valuable (Medium-term)
5. **Imaging Module** - Clinical documentation

---

## Technical Stack Recommendations

### Component Libraries
- **Image Viewer**: [vue-easy-lightbox](https://www.npmjs.com/package/vue-easy-lightbox) or [v-viewer](https://www.npmjs.com/package/v-viewer)
- **Image Upload**: [vue-dropzone](https://www.npmjs.com/package/vue2-dropzone) or native HTML5 drag-drop
- **Image Annotation**: [fabric.js](http://fabricjs.com/) or [konva.js](https://konvajs.org/)
- **Tree Diagram**: [vue-tree](https://www.npmjs.com/package/vue-tree) or [d3.js](https://d3js.org/)
- **Calendar**: Existing drag-drop implementation, extend for week view

### State Management
- Use Pinia or Vuex for shared state
- Modules: appointments, patients, family, imaging, waitingRoom

### API Integration (Future)
- Axios for HTTP requests
- WebSocket for real-time waiting room updates
- Polling fallback for older browsers

---

## Design Consistency Guidelines

### Color Palette
- **Primary**: #4b3c97 (Purple - from existing sidebar active state)
- **Success**: #4CAF50 (Green)
- **Warning**: #FFC107 (Yellow)
- **Danger**: #F44336 (Red)
- **Info**: #2196F3 (Blue)
- **Neutral**: #9E9E9E (Gray)

### Typography
- Font: System default or existing project font
- Headings: 18-24px, bold
- Body: 14-16px, regular
- Small text: 12px

### Spacing
- Container padding: 20-30px
- Card padding: 16-24px
- Button padding: 10px 20px
- Grid gap: 16px

### Icons
- Icon library: Font Awesome (already in use)
- Icon size: 18-20px for buttons, 14-16px for inline

---

## Estimated Development Time (Frontend Only)

| Module | Components | Estimated Hours |
|--------|-----------|-----------------|
| Family Module | 4 components | 16-20 hours |
| Imaging Module | 5 components | 24-30 hours |
| Waiting Room Panel | 1 component | 8-10 hours |
| Appointment Quick Actions | 1 component + modals | 10-12 hours |
| Week View Scheduler | 1 component | 12-16 hours |
| **Total** | **12 components** | **70-88 hours** |

---

## Next Steps

1. Review and approve this document
2. Prioritize which module to build first
3. Create mockups/wireframes (optional)
4. Set up component structure
5. Build with mock data first
6. Test UI/UX thoroughly
7. Integrate with backend APIs (future phase)

---

**Document Version**: 1.0
**Last Updated**: November 1, 2025
**Created By**: Claude Code Analysis
