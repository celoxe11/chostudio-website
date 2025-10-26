# Commission Management System Documentation

## Overview
The Commission Management System provides a comprehensive workflow for artists to manage client commissions from order placement to final delivery. The system tracks both payment and progress statuses with specific actions available at each stage.

## Status Types

### 1. Progress Status
Represents the current stage of the commission work.

| Status | Description | Next Action | Artist Can |
|--------|-------------|-------------|-----------|
| `pending` | New commission awaiting artist response | Accept or Reject | Accept commission, Reject with reason |
| `accepted` | Commission accepted, not yet started | Start work | Mark as "Start Sketch" |
| `in_progress_sketch` | Artist is working on sketch phase | Submit sketch for review | Upload sketch progress, Mark as "Submit for Review" |
| `in_progress_coloring` | Artist is working on coloring phase | Submit for final review | Upload coloring progress, Mark as "Submit for Review" |
| `review` | Work submitted, waiting for client feedback | Client reviews | Wait for client response |
| `revision` | Client requested changes | Make revisions | Upload revised work, Resubmit for review |
| `completed` | Work approved and delivered | Archive | Mark as paid (if unpaid), Download final files |
| `cancelled` | Commission cancelled | Archive | View cancellation reason |

### 2. Payment Status
Tracks the payment state of the commission.

| Status | Description | When Set |
|--------|-------------|----------|
| `pending` | No payment received | Initial state |
| `dp` | Down payment (50%) received | After initial payment |
| `paid` | Full payment received | After final payment |
| `refunded` | Payment returned to client | After cancellation |

## Workflow Diagrams

### Happy Path Flow
```
pending → accepted → in_progress_sketch → review → in_progress_coloring → review → completed
```

### With Revision Flow
```
pending → accepted → in_progress_sketch → review → revision → in_progress_sketch → review → completed
```

### Cancellation Flow
```
Any Status → cancelled
```

## Action Buttons by Status

### Pending Status
```
[Accept Commission] [Reject Commission]
```
- **Accept Commission**: Moves to `accepted`, sends notification to client
- **Reject Commission**: Moves to `cancelled`, requires reason, triggers refund if paid

### Accepted Status
```
[Start Sketch Phase] [Cancel Commission]
```
- **Start Sketch Phase**: Moves to `in_progress_sketch`, sets start timestamp
- **Cancel Commission**: Moves to `cancelled`, requires reason

### In Progress (Sketch) Status
```
[Upload Progress] [Submit Sketch for Review] [Cancel Commission]
```
- **Upload Progress**: Adds work-in-progress image (multiple allowed)
- **Submit Sketch for Review**: Moves to `review`, notifies client
- **Cancel Commission**: Moves to `cancelled`, requires reason

### Review Status (After Sketch)
```
[Start Coloring Phase] [Request Revision Details]
```
- **Start Coloring Phase**: Available if client approved, moves to `in_progress_coloring`
- **Request Revision Details**: If client rejected, moves to `revision`

### In Progress (Coloring) Status
```
[Upload Progress] [Submit Final Work] [Cancel Commission]
```
- **Upload Progress**: Adds work-in-progress image
- **Submit Final Work**: Moves to `review`, notifies client for final approval

### Review Status (After Coloring)
```
[Mark as Completed] [Request Revision Details]
```
- **Mark as Completed**: Available if client approved, moves to `completed`
- **Request Revision Details**: If client rejected, moves to `revision`

### Revision Status
```
[Upload Revised Work] [Resubmit for Review] [Contact Client]
```
- **Upload Revised Work**: Adds revised version
- **Resubmit for Review**: Moves back to `review`, notifies client
- **Contact Client**: Opens communication modal

### Completed Status
```
[Mark as Paid] [Download Files] [Archive]
```
- **Mark as Paid**: Changes payment_status to `paid` (if not already)
- **Download Files**: Downloads all commission files as ZIP
- **Archive**: Soft deletes the commission record

### Cancelled Status
```
[View Cancellation Details] [Archive]
```
- **View Cancellation Details**: Shows cancellation reason and timestamp
- **Archive**: Soft deletes the commission record

## Progress Tracking Features

### 1. File Upload System
- Artists can upload multiple progress images at each stage
- Each upload includes:
  - Image file (JPEG/PNG, max 5MB)
  - Optional description/notes
  - Timestamp
  - Stage indicator (sketch/coloring/revision)

### 2. Communication Log
- Timeline of all status changes
- Client feedback notes
- Revision requests
- File upload history

### 3. Notifications
System sends notifications to client when:
- Commission accepted/rejected
- Work submitted for review
- Revision needed
- Work completed

## Payment Integration

### Payment Rules
1. **Pending → DP**: Client must pay 50% before artist starts sketch
2. **DP → Paid**: Client pays remaining 50% before final delivery
3. **Refund Policy**: 
   - Full refund if cancelled before `accepted`
   - 50% refund if cancelled during `in_progress_sketch`
   - No refund after `in_progress_coloring`

### Payment Status Indicators
Visual indicators show payment status:
- 🔴 Red: Unpaid (pending)
- 🟡 Yellow: Partial payment (dp)
- 🟢 Green: Fully paid
- ⚪ Gray: Refunded

## Database Schema

### Existing Tables (Updated)

#### Commissions Table
```sql
-- Added fields to existing commisions table:
ALTER TABLE commisions ADD COLUMN status_notes TEXT NULL;
ALTER TABLE commisions ADD COLUMN cancellation_reason TEXT NULL;
ALTER TABLE commisions ADD COLUMN cancelled_by ENUM('artist', 'client', 'system') NULL;
ALTER TABLE commisions ADD COLUMN cancelled_at TIMESTAMP NULL;
ALTER TABLE commisions ADD COLUMN started_at TIMESTAMP NULL;
ALTER TABLE commisions ADD COLUMN completed_at TIMESTAMP NULL;
```

#### Commission Progress Table (Updated)
The existing `commission_progress` table is used to store progress images throughout the commission lifecycle.

```sql
-- Original structure:
CREATE TABLE commission_progress (
    com_progress_id BIGINT PRIMARY KEY,
    commission_id BIGINT,
    image_link VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Added fields:
ALTER TABLE commission_progress ADD COLUMN stage ENUM('sketch', 'coloring', 'final', 'revision') DEFAULT 'sketch';
ALTER TABLE commission_progress ADD COLUMN description TEXT NULL;
ALTER TABLE commission_progress ADD COLUMN status_from VARCHAR(50) NULL;
ALTER TABLE commission_progress ADD COLUMN status_to VARCHAR(50) NULL;
```

**Field Descriptions:**
- `com_progress_id`: Primary key
- `commission_id`: Foreign key to commissions table
- `image_link`: Path/URL to the progress image
- `stage`: Which phase of work this image represents (sketch/coloring/final/revision)
- `description`: Artist's notes about this progress update
- `status_from`: Optional - status before this update
- `status_to`: Optional - status after this update
- `created_at`: When the image was uploaded
- `deleted_at`: Soft delete timestamp

**Usage:**
- Artists upload progress images at each stage
- Each image can have a description
- Images track which stage they belong to
- Optionally track status changes with each upload
- Provides visual timeline of commission progress

## UI/UX Guidelines

### Color Coding
- **Pending**: Red (#EF4444)
- **Accepted**: Blue (#3B82F6)
- **In Progress (Sketch)**: Purple (#A855F7)
- **In Progress (Coloring)**: Purple (#C084FC)
- **Review**: Amber (#F59E0B)
- **Revision**: Orange (#F97316)
- **Completed**: Green (#10B981)
- **Cancelled**: Gray (#6B7280)

### Button States
- Primary actions: Bold, filled background
- Secondary actions: Outlined
- Destructive actions: Red color
- Disabled: 50% opacity

### Responsive Behavior
- Mobile: Stack action buttons vertically
- Tablet: 2 columns for action buttons
- Desktop: Horizontal layout with proper spacing

## API Endpoints

### Get Commission Details
```
GET /api/artist/commission/{id}
Response: Commission data with full progress history
```

### Update Commission Status
```
POST /api/artist/commission/{id}/status
Payload: { status: 'new_status', notes: 'optional notes' }
Response: Updated commission data
```

### Upload Progress File
```
POST /api/artist/commission/{id}/upload
Payload: FormData with file and metadata
Response: File record and updated commission
```

### Get Progress Timeline
```
GET /api/artist/commission/{id}/timeline
Response: Chronological list of all status changes and uploads
```

## Security Considerations

1. **Authorization**: Only the assigned artist can modify commission status
2. **File Validation**: Strict file type and size validation
3. **Status Validation**: Prevent invalid status transitions
4. **Audit Trail**: All changes logged with timestamp and user

## Future Enhancements

1. **Client Portal**: Allow clients to view progress and approve work
2. **Automated Reminders**: Notify artist of approaching deadlines
3. **Rating System**: Clients rate completed commissions
4. **Templates**: Save common commission types as templates
5. **Batch Operations**: Update multiple commissions at once
6. **Analytics Dashboard**: Track completion rates, average times, revenue

## Implementation Priority

### Phase 1 (Current)
- ✅ Status management system
- ✅ Action buttons based on status
- ✅ Basic file upload

### Phase 2 (Next Sprint)
- Progress timeline view
- Client notification system
- Commission files table

### Phase 3 (Future)
- Client approval workflow
- Automated payment integration
- Advanced analytics

---

**Last Updated**: October 26, 2025  
**Version**: 1.0  
**Author**: Development Team
