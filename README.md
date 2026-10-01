# Nael Media — HR Payroll System & Employee Portal

Complete HR, Attendance Tracking, Payroll Management System, and Self-Service Employee Portal for Nael Media (Dubai).

## System Architecture

### 1. API & Backend Engine (`/api/pms_api.php`)
- **Database & Storage**: MySQL store handler (`pms_store` table) and file upload managers (`pms_remarks_files`, `pms_receipts`).
- **Authentication**: Dual-layer login (Password Auth & 6-digit OTP via Email).
- **SMTP Mailer**: Native Microsoft 365 / Office 365 TLS integration (`smtp.office365.com:587`).
- **Saturday Roster**: Automated availability submission window (Saturdays 9:00 AM – 11:00 AM GST).
- **Reimbursement Engine**: Expense categories (fuel, parking, transport, etc.) with receipt attachment support and pure-PHP zip archive exporter (`download_receipts`).
- **Disputes & Remarks**: Employee dispute filing and HR review workflow.

### 2. Admin Payroll Management System (`/payroll-management/index.php`)
- Live Dashboard (`https://naeladvertising.ae/payroll-managment/`)
- Attendance calendar, salary calculations, deal tracking & commission splits.
- Saturday availability monitoring roster.
- Reimbursement audit & bulk receipt ZIP downloader.

### 3. Employee Self-Service Portal (`/employee-portal/index.php`)
- Live Portal (`https://naeladvertising.ae/employee-portal/`)
- Individual attendance breakdown, salary slips, advances, and deductions.
- Saturday availability submission button (active during Dubai window).
- Expense reimbursement form with image/PDF receipt upload.
- Dispute & remark submission tracker.
