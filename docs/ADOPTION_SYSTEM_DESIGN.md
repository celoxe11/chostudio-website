# Adoption (Art Sales) System Design

## Overview
The adoption system allows **anyone** (no login required) to purchase original artwork from the artist's gallery via email. Each artwork can only be sold once (unique ownership concept).

**MVP Approach**: Simple email-based system with manual artist verification. No payment gateway integration required.

---

## Database Structure

### Tables Involved
1. **`gallery`** - Contains artworks available for adoption
2. **`adoptions`** - Tracks purchase orders with buyer contact info

---

## Workflow

### 1. **Browsing Phase (Public - No Login Required)**
- Anyone can browse the gallery
- Each artwork shows:
  - Image/preview (watermarked)
  - Title and description
  - Price
  - Availability status (available/reserved/sold)

### 2. **Purchase Process**

#### Step 1: Order Placement (Buyer)
- Buyer fills out order form on artwork page:
  - Name
  - Email (primary contact)
  - Phone (optional)
  - Message to artist (optional)
- System creates adoption record:
  ```
  order_status: 'pending'
  payment_status: 'unpaid'
  ```
- **Automated Email #1**: Confirmation email sent to buyer with order details
- Artist receives notification via email aswell

#### Step 2: Artist Reviews Order
- Artist reviews order in dashboard
- Can **confirm** or **cancel**:
  - **Confirm**: 
    - `order_status` → `'confirmed'`
    - `confirmed_at` → current timestamp
    - **Automated Email #2**: Confirmation email to buyer with payment instructions
  - **Cancel**: 
    - `order_status` → `'cancelled'`
    - Artwork returns to available
    - **Automated Email**: Cancellation notice to buyer

#### Step 3: Payment (Manual Process)
- Buyer transfers payment via bank transfer/e-wallet
- Buyer sends payment proof to artist via email/WhatsApp
- Artist manually verifies payment in dashboard
- Artist marks payment as confirmed:
  - `payment_status` → `'paid'`
  - `paid_at` → current timestamp
  - `order_status` → `'processing'`
  - **Automated Email #3**: Payment confirmation email to buyer

#### Step 4: File Preparation (Artist)
- Artist prepares high-resolution files
- Artist can add delivery notes (file formats, resolution, etc.)

#### Step 5: Delivery (Artist)
- Artist uploads files to server or prepares download link
- Artist marks order as delivered:
  - `order_status` → `'delivered'`
  - `delivered_at` → current timestamp
  - **Automated Email #4**: Delivery email to buyer with download link/instructions
  
#### Step 6: Completion (Automatic or Manual)
- Artist manually marks as completed after confirming with the buyer
  - `order_status` → `'completed'`
  - `completed_at` → current timestamp

---

## Status Flow Diagram

```
PENDING → CONFIRMED → PROCESSING → DELIVERED → COMPLETED
   ↓
CANCELLED (can happen at PENDING or CONFIRMED stage)
```

### Payment Status Flow
```
UNPAID → PAID
   ↓
FAILED (if payment processing fails)
   ↓
REFUNDED (if order cancelled after payment)
```

---

## Business Rules

### 1. Artwork Availability
- Each artwork can only be adopted once
- When order is `pending` or `confirmed`, artwork is shown to be `reserved`
- If order `cancelled`, artwork becomes available again
- Once order is `completed`, artwork is permanently adopted

### 2. Payment Rules
- **Manual verification**: Artist manually confirms payment after receiving proof
- Payment must be confirmed before file delivery
- Artist handles refunds manually if order cancelled after payment

### 3. Cancellation Rules
- **Artist can cancel**: At `'pending'` or `'confirmed'` stage
- After `'processing'` starts (payment confirmed), artist should coordinate with buyer
- Refunds handled manually outside the system

### 4. Delivery Rules
- Files only delivered after artist confirms payment
- Download links sent via automated email

---

## Core Features (MVP)

### 1. **Email Notifications** (Automated)
Required email triggers:
- **Order Placed**: Confirmation email to buyer with order details
- **Order Confirmed**: Email to buyer with payment instructions
- **Order Cancelled**: Notification email to buyer
- **Payment Confirmed**: Confirmation email to buyer
- **Files Delivered**: Email to buyer with download link

Email should include:
- Order number
- Artwork details
- Current status
- Next steps
- Contact information

### 2. **Manual Payment Verification**
- Artist dashboard shows pending payments
- Artist reviews payment proof (received via email/WhatsApp)
- Simple "Confirm Payment" button in dashboard
- No integration with payment gateways needed

### 3. **File Delivery**
- Simple file upload interface for artist
- Secure file storage (outside public directory)
- Temporary download links sent via email
- Support common formats (PNG, JPG, PSD, AI)

### 4. **Order Tracking**
- Buyers can check order status by entering email + order ID
- Simple status page showing current stage

### 5. **Artist Dashboard**
- View all orders
- Filter by status
- Quick actions: Confirm order, Confirm payment, Upload files
- Basic order statistics

---

## Database Queries Examples

### Check if artwork is available
```php
$artwork = Gallery::where('gallery_id', $id)
    ->whereDoesntHave('adoptions', function($query) {
        $query->whereIn('order_status', ['pending', 'confirmed', 'processing', 'delivered', 'completed']);
    })
    ->first();
```

### Get pending orders for artist
```php
$pendingOrders = Adoption::where('order_status', 'pending')
    ->with('gallery')
    ->orderBy('created_at', 'desc')
    ->get();
```

### Track order by email
```php
$myOrders = Adoption::where('buyer_email', 'customer@email.com')
    ->with('gallery')
    ->orderBy('created_at', 'desc')
    ->get();
```

### Find specific order by email and order ID
```php
$order = Adoption::where('adoption_id', $orderId)
    ->where('buyer_email', $email)
    ->with('gallery')
    ->first();
```

---

## Frontend Views Needed

### Public/Guest Side (No Login Required)
1. **Gallery Browse** - View all available artworks
2. **Artwork Detail** - Single artwork page with order form
3. **Order Confirmation** - Thank you page after order submission
4. **Track Order** - Simple form to check status (enter email + order ID)
5. **Order Status Page** - Shows current order status and next steps
6. **Download Page** - Access delivered files (with validation)

### Artist Side (Login Required)
1. **Adoptions Dashboard** - List all orders with filters
2. **Order Detail** - Manage specific order:
   - View buyer info
   - Confirm/cancel order
   - Confirm payment
   - Upload files
   - Add delivery notes
3. **Gallery Management** - Add/edit artworks with pricing

---

## Security Considerations

1. **File Security**
   - Store files outside public directory
   - Generate temporary signed URLs for downloads
   - Verify buyer identity before allowing download

2. **Payment Security**
   - Use HTTPS for all transactions
   - Store payment proofs securely
   - Log all payment-related actions

3. **Data Privacy**
   - Protect buyer information
   - GDPR compliance for EU customers
   - Secure payment information

---

## Implementation Checklist (MVP)

### Database & Models
- [x] Create adoptions migration
- [ ] Create Adoption model with relationships
- [ ] Create seeder for sample data

### Backend (Artist Dashboard)
- [ ] Artist login/auth
- [ ] Adoptions index page (list all orders)
- [ ] Order detail page with actions
- [ ] Confirm order endpoint
- [ ] Confirm payment endpoint
- [ ] Upload files endpoint
- [ ] Cancel order endpoint

### Frontend (Public)
- [ ] Gallery browse page (show available artworks)
- [ ] Artwork detail page with order form
- [ ] Order placement form validation
- [ ] Order confirmation page
- [ ] Order tracking page (enter email + order ID)
- [ ] Download page for delivered files

### Email System
- [ ] Setup Laravel mail configuration
- [ ] Create email templates:
  - [ ] Order placed notification
  - [ ] Order confirmed with payment instructions
  - [ ] Order cancelled notification
  - [ ] Payment confirmed notification
  - [ ] Files delivered with download link
- [ ] Configure email sending on status changes

### File Management
- [ ] Secure file upload for artist
- [ ] Generate download links
- [ ] File access validation
- [ ] Support multiple file formats

### Testing
- [ ] Test complete order flow
- [ ] Test email delivery
- [ ] Test file uploads and downloads
- [ ] Test order tracking

---

## Email Template Requirements

### 1. Order Placed (To Buyer)
```
Subject: Order Confirmation - [Artwork Title]

Hi [Buyer Name],

Thank you for your interest in "[Artwork Title]"!

Order Details:
- Order ID: #[adoption_id]
- Artwork: [artwork title]
- Price: Rp [price]
- Date: [created_at]

Your order is pending artist confirmation. You will receive another email once the artist reviews your order.

You can track your order status here: [tracking link]

Best regards,
Cho's Studio
```

### 2. Order Confirmed (To Buyer)
```
Subject: Order Confirmed - Payment Instructions

Hi [Buyer Name],

Great news! Your order for "[Artwork Title]" has been confirmed.

Payment Instructions:
[Payment details - bank account, e-wallet, etc.]
Amount: Rp [price]

Please send payment proof to: [artist email/WhatsApp]

Once payment is confirmed, we'll prepare your high-resolution files.

Order ID: #[adoption_id]
Track order: [tracking link]

Best regards,
Cho's Studio
```

### 3. Payment Confirmed (To Buyer)
```
Subject: Payment Received - Files Being Prepared

Hi [Buyer Name],

Payment confirmed! We're now preparing your high-resolution files for "[Artwork Title]".

You'll receive another email with the download link once the files are ready.

Order ID: #[adoption_id]

Best regards,
Cho's Studio
```

### 4. Files Delivered (To Buyer)
```
Subject: Your Artwork is Ready for Download!

Hi [Buyer Name],

Your artwork "[Artwork Title]" is ready!

Download Link: [secure download URL]

Delivery Notes from Artist:
[delivery_notes]

This link will be valid for 30 days. Please download your files soon.

Thank you for your purchase!

Order ID: #[adoption_id]

Best regards,
Cho's Studio
```

### 5. Order Cancelled (To Buyer)
```
Subject: Order Cancelled

Hi [Buyer Name],

Your order for "[Artwork Title]" has been cancelled.

If you've already made a payment, please contact us for refund processing.

Order ID: #[adoption_id]

Best regards,
Cho's Studio
```
