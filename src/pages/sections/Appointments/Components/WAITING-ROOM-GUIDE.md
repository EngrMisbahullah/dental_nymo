# Waiting Room Panel - User Guide

A real-time patient tracking system integrated into your Appointments module to manage patient flow from check-in to completion.

## 📍 Location

The Waiting Room Panel is located on the **right side** of the Appointments Scheduler page.

**Access**: Navigate to **Appointments** from the sidebar, or go to `/dashboard/appointments`

---

## 🎯 Overview

The Waiting Room Panel helps you:
- Track patients from check-in to check-out in real-time
- Monitor wait times automatically
- Quickly update patient status
- Identify patients who have been waiting too long
- Manage patient queue efficiently

---

## 📊 Patient Status Workflow

Patients progress through 7 status stages:

```
1. Unconfirmed → 2. Confirmed → 3. Arrived → 4. Ready → 5. In Room → 6. Check Out → 7. Completed
```

### Status Descriptions

| Status | Color | Description |
|--------|-------|-------------|
| **Unconfirmed** | Gray | Appointment not yet confirmed by patient |
| **Confirmed** | Blue | Patient confirmed their appointment |
| **Arrived** | Yellow | Patient checked in at reception |
| **Ready** | Green | Patient ready to be seen |
| **In Room** | Purple | Patient currently with dentist/hygienist |
| **Check Out** | Teal | Treatment completed, ready for checkout |
| **Completed** | Dark Green | Patient checked out and left |

---

## 🎨 Visual Indicators

### Patient Card Colors
- **Standard**: Light gray background with colored status
- **Overdue (>20 min)**: Red border with pink background + pulsing wait time badge

### Wait Time Badge
- **Normal**: Blue badge showing minutes waited
- **Alert (>20 min)**: Red badge with pulsing animation

---

## 🔧 How to Use

### 1. Viewing Patients in Queue

The panel displays all patients currently in the waiting room with:
- Patient name
- Practitioner/dentist name
- Appointment time
- Check-in time
- Current wait time (auto-updates)
- Current status

**Empty State**: When no patients are waiting, you'll see:
```
🪑 No patients in waiting room
```

### 2. Changing Patient Status

**Method 1: Status Dropdown**
1. Click on a patient card to select it
2. Click the **status dropdown** (colored button showing current status)
3. Select the new status from the list
4. Status updates immediately

**Method 2: Quick Action Buttons**

Each patient card has quick action buttons based on their current status:

| Current Status | Quick Action Available | Button Icon | What It Does |
|---------------|----------------------|-------------|--------------|
| **Arrived** | Mark as Ready | ✓ (Green) | Changes status to "Ready" |
| **Ready** | Move to Room | 🚪 (Purple) | Changes status to "In Room" |
| **In Room** | Complete | ✓✓ (Blue) | Changes status to "Completed" |
| **Any Status** | View Details | ℹ️ (Gray) | Shows patient appointment details |

**Example Workflow**:
1. Patient arrives → Reception marks as "Arrived" ✅
2. Dentist ready → Click **green ✓** to mark as "Ready" ✅
3. Patient called in → Click **purple 🚪** to mark as "In Room" ✅
4. Treatment done → Click **blue ✓✓** to mark as "Completed" ✅
5. Patient automatically removed from panel after 2 seconds

### 3. Sorting Patients

Use the **Sort dropdown** at the bottom of the panel:

- **Wait Time** (Default): Longest wait time first
- **Appointment Time**: Earliest appointment first
- **Check-in Time**: Earliest check-in first

**How to Sort**:
1. Look for the sort control at the bottom: `🔄 Sort: [Dropdown]`
2. Click the dropdown
3. Select your preferred sorting method

### 4. Monitoring Wait Times

Wait times are calculated automatically:
- **Auto-updates**: Every minute
- **Calculation**: Current time - Check-in time
- **Display**: Shows minutes waited (e.g., "5 min", "22 min")

**Overdue Alerts**:
- When wait time exceeds **20 minutes**:
  - Card border turns **red**
  - Background changes to **light pink**
  - Wait time badge **pulses** in red
  - This draws attention to patients waiting too long

### 5. Selecting a Patient

Click anywhere on a patient card to select it:
- Card background becomes highlighted
- Patient details can be accessed
- Ready for status updates

---

## 📱 Panel Features

### Header
- **Title**: "Waiting Room" with clock icon
- **Patient Count**: Shows total patients in queue (e.g., "4 Patients")

### Patient Card Information

Each card displays:

**Top Section**:
- **Patient Name** (bold, large font)
- **Practitioner Name** (smaller, gray text)
- **Wait Time Badge** (right side, shows minutes)

**Middle Section**:
- 📅 **Appointment Time** (e.g., "10:00 AM")
- 📥 **Check-in Time** (e.g., "Check-in: 09:55 AM")

**Status Section**:
- Color-coded **status dropdown** for changing status

**Bottom Section**:
- **Quick Action Buttons** (context-sensitive based on status)

### Footer Controls
- **Sort Options**: Change patient display order
- Visible only when patients are present

---

## 💡 Best Practices

### Reception Staff
1. **On Patient Arrival**:
   - Update status from "Confirmed" to "Arrived"
   - Note the check-in time is recorded automatically

2. **Monitor Queue**:
   - Keep an eye on wait times
   - Alert dentist when patients exceed 20 minutes

### Dental Staff
1. **Before Seeing Patient**:
   - Mark patient as "Ready" when prepared

2. **When Calling Patient**:
   - Change status to "In Room" immediately

3. **After Treatment**:
   - Mark as "Completed" when done
   - Patient auto-removes from list

### Office Managers
1. **Track Efficiency**:
   - Monitor average wait times
   - Identify bottlenecks in patient flow

2. **Staff Allocation**:
   - See which practitioners have patients waiting
   - Redistribute if needed

---

## 🎯 Common Workflows

### Scenario 1: Normal Patient Flow
```
09:50 AM - Patient checks in → Mark as "Arrived"
09:55 AM - Dentist ready → Mark as "Ready"
10:00 AM - Call patient in → Mark as "In Room"
10:30 AM - Treatment done → Mark as "Completed"
```

### Scenario 2: Long Wait Time
```
Patient waiting 25 minutes:
- Card shows RED BORDER
- Wait time badge PULSING in red
- Reception should notify dentist
- Consider calling patient to exam room
```

### Scenario 3: Emergency Patient
```
Emergency arrives:
- Check in as "Arrived"
- Immediately mark as "Ready"
- Dentist sees "Ready" status
- Move to "In Room" ASAP
```

---

## ⚠️ Important Notes

### Status Rules
- **Cannot skip statuses**: Follow the workflow order
- **Completed patients**: Auto-remove after 2 seconds
- **Status history**: All changes are tracked with timestamps

### Wait Time Alerts
- **>20 minutes**: Visual alert with red border and pulsing badge
- **Audio alerts**: Coming soon (future feature)
- **Notifications**: Future feature for SMS/email alerts

### Data Persistence
- Status changes save immediately
- Wait times update every 60 seconds
- Status history maintained for reporting

---

## 🔮 Future Enhancements

Coming soon:
- [ ] Audio notification for long waits (>20 min)
- [ ] Filter by practitioner
- [ ] Print patient queue list
- [ ] SMS notifications to patients
- [ ] Integration with appointment booking
- [ ] Patient self-check-in kiosk
- [ ] Average wait time analytics
- [ ] Export wait time reports

---

## 📊 Status Color Reference

Quick reference for status colors:

| Status | Background Color | Text Color | Use Case |
|--------|-----------------|------------|----------|
| Unconfirmed | Light Gray (#f3f4f6) | Gray (#6b7280) | Not confirmed yet |
| Confirmed | Light Blue (#dbeafe) | Dark Blue (#1e40af) | Confirmed by patient |
| Arrived | Light Yellow (#fef3c7) | Brown (#92400e) | Just checked in |
| Ready | Light Green (#d1fae5) | Dark Green (#065f46) | Ready to be seen |
| In Room | Light Purple (#e9d5ff) | Dark Purple (#6b21a8) | Currently with dentist |
| Check Out | Light Teal (#ccfbf1) | Dark Teal (#134e4a) | Ready for checkout |
| Completed | Green (#bbf7d0) | Dark Green (#14532d) | All done |

---

## 🆘 Troubleshooting

### Problem: Patient not showing in waiting room
**Solution**: Ensure patient status is not "Completed" or "Cancelled"

### Problem: Wait time not updating
**Solution**: Refresh the page - wait times update automatically every minute

### Problem: Can't change status
**Solution**: Make sure patient card is selected (click on it first)

### Problem: Panel too crowded
**Solution**: Use the sort feature to organize by wait time

---

## 💻 Technical Details

### Responsive Behavior
- **Desktop (>1200px)**: Panel on right side, fixed width 350px
- **Tablet (768px-1200px)**: Panel moves above calendar
- **Mobile (<768px)**: Panel full width, max height 400px

### Keyboard Shortcuts (Future)
- Coming soon: Keyboard navigation for status changes

### Integration Points
- Syncs with appointment scheduler
- Updates reflect in appointment records
- Status history saved for reporting

---

## 📞 Support

For questions or issues:
1. Check this guide first
2. Contact your system administrator
3. Submit feedback for feature requests

---

**Last Updated**: November 5, 2025
**Version**: 1.0
**Component**: WaitingRoomPanel.vue
