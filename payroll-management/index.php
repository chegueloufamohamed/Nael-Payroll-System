<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payroll Management System</title>
<style>
:root {
  --bg:#f1f5f9;--sidebar:#0f172a;--sidebar-hover:#1e293b;
  --accent:#6366f1;--accent-light:#e0e7ff;
  --text:#1e293b;--text-muted:#64748b;--white:#ffffff;--border:#e2e8f0;
  --green:#16a34a;--green-bg:#dcfce7;--red:#dc2626;--red-bg:#fee2e2;
  --orange:#d97706;--orange-bg:#fef3c7;--blue:#2563eb;--blue-bg:#dbeafe;
  --teal:#0d9488;--teal-bg:#ccfbf1;
  --purple-bg:#f5f3ff;--sat-bg:#fef9ec;--sun-bg:#eff6ff;
  --shadow:0 1px 3px rgba(0,0,0,0.08),0 1px 2px rgba(0,0,0,0.06);
  --shadow-lg:0 4px 16px rgba(0,0,0,0.12);
  --radius:10px;--font:'Segoe UI',system-ui,-apple-system,sans-serif;
  --sidebar-w:230px;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font);background:var(--bg);color:var(--text);min-height:100vh;display:flex}
[dir="rtl"] body{font-family:'Segoe UI',Tahoma,Arial,sans-serif}
#sidebar{width:var(--sidebar-w);min-width:var(--sidebar-w);background:var(--sidebar);display:flex;flex-direction:column;position:fixed;top:0;bottom:0;z-index:100;overflow-y:auto;transition:left 0.3s}
[dir="ltr"] #sidebar{left:0}
[dir="rtl"] #sidebar{right:0;left:auto}
#sidebar .brand{padding:22px 20px 16px;border-bottom:1px solid rgba(255,255,255,0.08)}
#sidebar .brand h1{font-size:13px;font-weight:700;color:#fff;letter-spacing:0.3px;line-height:1.4}
#sidebar .brand p{font-size:11px;color:#94a3b8;margin-top:2px}
#sidebar nav{padding:10px 0;flex:1}
#sidebar nav a{display:flex;align-items:center;gap:10px;padding:10px 18px;font-size:13px;font-weight:500;color:#94a3b8;cursor:pointer;transition:all 0.15s;border-radius:0}
[dir="ltr"] #sidebar nav a{border-left:3px solid transparent}
[dir="rtl"] #sidebar nav a{border-right:3px solid transparent}
#sidebar nav a:hover{background:var(--sidebar-hover);color:#e2e8f0}
[dir="ltr"] #sidebar nav a.active{background:rgba(99,102,241,0.15);color:#a5b4fc;border-left-color:#6366f1}
[dir="rtl"] #sidebar nav a.active{background:rgba(99,102,241,0.15);color:#a5b4fc;border-right-color:#6366f1}
#sidebar nav a .icon{font-size:15px;width:20px;text-align:center;flex-shrink:0}
#sidebar .sidebar-footer{padding:14px 18px;border-top:1px solid rgba(255,255,255,0.08);font-size:11px;color:#475569}
#main{flex:1;min-height:100vh;display:flex;flex-direction:column}
[dir="ltr"] #main{margin-left:var(--sidebar-w)}
[dir="rtl"] #main{margin-right:var(--sidebar-w)}
#topbar{background:var(--white);border-bottom:1px solid var(--border);padding:13px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
#topbar h2{font-size:16px;font-weight:700;color:var(--text)}
#topbar .topbar-right{display:flex;gap:10px;align-items:center}
#content{padding:22px 28px;flex:1}
.cards-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px;margin-bottom:22px}
.stat-card{background:var(--white);border-radius:var(--radius);padding:16px 18px;box-shadow:var(--shadow)}
.stat-card .label{font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px}
.stat-card .value{font-size:26px;font-weight:800;margin:5px 0 2px;color:var(--text)}
.stat-card .sub{font-size:11px;color:var(--text-muted)}
.stat-card.c-accent{background:var(--accent)}.stat-card.c-accent .label,.stat-card.c-accent .sub,.stat-card.c-accent .value{color:#fff}
.stat-card.c-teal{background:var(--teal)}.stat-card.c-teal .label,.stat-card.c-teal .sub,.stat-card.c-teal .value{color:#fff}
.stat-card.c-green{background:var(--green)}.stat-card.c-green .label,.stat-card.c-green .sub,.stat-card.c-green .value{color:#fff}
.card{background:var(--white);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow);margin-bottom:18px}
.card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px}
.card-header h3,.card-title{font-size:15px;font-weight:700}
.table-wrap{overflow-x:auto;border-radius:8px;border:1px solid var(--border)}
table{width:100%;border-collapse:collapse;font-size:13px}
table th{background:#f8fafc;padding:9px 13px;text-align:start;font-weight:600;font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.4px;border-bottom:1px solid var(--border);white-space:nowrap}
table td{padding:9px 13px;border-bottom:1px solid var(--border);vertical-align:middle}
table tr:last-child td{border-bottom:none}
table tr:hover td{background:#f8fafc;cursor:pointer}
table tr.row-sat td{background:var(--sat-bg)}
table tr.row-sun td{background:var(--sun-bg)}
table tr.row-absent td{background:var(--red-bg)}
table tr.row-halfday td{background:var(--orange-bg)}
table tr.row-present td{background:var(--green-bg)}
table tr.row-exception td{background:var(--blue-bg)}
table tr.row-reimb td{background:var(--teal-bg)}
.badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap}
.badge-green{background:var(--green-bg);color:var(--green)}
.badge-red{background:var(--red-bg);color:var(--red)}
.badge-orange{background:var(--orange-bg);color:var(--orange)}
.badge-blue{background:var(--blue-bg);color:var(--blue)}
.badge-gray{background:#f1f5f9;color:var(--text-muted)}
.badge-purple{background:var(--purple-bg);color:#7c3aed}
.badge-teal{background:var(--teal-bg);color:var(--teal)}
.form-row{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:12px;align-items:flex-end}
.form-group{display:flex;flex-direction:column;gap:5px;flex:1;min-width:130px}
.form-group label{font-size:11.5px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.4px}
.form-group input,.form-group select,.form-group textarea{padding:8px 11px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;font-family:var(--font);background:var(--white);color:var(--text);outline:none;transition:border 0.15s}
.form-group input:focus,.form-group select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(99,102,241,0.1)}
.form-group.narrow{min-width:110px;flex:0}
.form-group.wide{min-width:200px}
.btn{padding:8px 15px;border-radius:7px;border:none;cursor:pointer;font-size:13px;font-weight:600;font-family:var(--font);transition:all 0.15s;display:inline-flex;align-items:center;gap:6px;white-space:nowrap}
.btn-primary{background:var(--accent);color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-success{background:var(--green);color:#fff}.btn-success:hover{background:#15803d}
.btn-danger{background:var(--red);color:#fff}.btn-danger:hover{background:#b91c1c}
.btn-teal{background:var(--teal);color:#fff}.btn-teal:hover{background:#0f766e}
.btn-secondary{background:#f1f5f9;color:var(--text);border:1.5px solid var(--border)}.btn-secondary:hover{background:#e2e8f0}
.btn-ghost{background:transparent;color:var(--text-muted);border:1.5px solid var(--border)}.btn-ghost:hover{background:#f1f5f9}
.btn-sm{padding:5px 11px;font-size:12px}
.btn-group{display:flex;flex-wrap:wrap;gap:8px}
.lang-btn{padding:5px 12px;border-radius:20px;border:1.5px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#94a3b8;font-size:12px;font-weight:700;cursor:pointer;transition:all 0.15s;letter-spacing:0.5px}
.lang-btn.active{background:var(--accent);color:#fff;border-color:var(--accent)}
#modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:200;align-items:center;justify-content:center;padding:20px}
#modal-bg.open{display:flex}
.modal{background:var(--white);border-radius:14px;box-shadow:var(--shadow-lg);width:100%;max-width:580px;max-height:92vh;overflow-y:auto;animation:modal-in 0.18s ease}
@keyframes modal-in{from{transform:scale(0.95);opacity:0}to{transform:scale(1);opacity:1}}
.modal-header{padding:18px 22px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.modal-header h3{font-size:15px;font-weight:700}
.modal-close{background:none;border:none;font-size:20px;cursor:pointer;color:var(--text-muted);line-height:1;padding:2px 6px}
.modal-body{padding:18px 22px}
.modal-footer{padding:14px 22px;border-top:1px solid var(--border);display:flex;gap:10px;justify-content:flex-end}
.alert{padding:11px 15px;border-radius:8px;font-size:13px;margin-bottom:12px;display:flex;align-items:flex-start;gap:8px}
.alert-info{background:var(--blue-bg);color:#1d4ed8}
.alert-warn{background:var(--orange-bg);color:#92400e}
.alert-success{background:var(--green-bg);color:#14532d}
.alert-teal{background:var(--teal-bg);color:#134e4a}
.filter-bar{background:var(--white);border-radius:var(--radius);padding:15px 18px;box-shadow:var(--shadow);margin-bottom:18px;display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end}
.payroll-summary{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px}
.summary-box{background:#f8fafc;border-radius:8px;padding:13px}
.summary-box h4{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:8px;text-align:start}
.summary-row{display:flex;justify-content:space-between;font-size:13px;padding:3px 0}
.summary-row span:first-child{text-align:start}
.summary-row span:last-child{text-align:end;direction:ltr}
.summary-row.total{font-weight:700;border-top:1px solid var(--border);margin-top:6px;padding-top:8px;font-size:14px}
.summary-row.total .amount{color:var(--green)}
.splits-section{border:1.5px solid var(--border);border-radius:8px;padding:13px;margin-top:12px}
.splits-section h4{font-size:13px;font-weight:700;margin-bottom:10px;color:var(--text-muted)}
.empty-state{text-align:center;padding:44px 20px;color:var(--text-muted)}
.empty-state .icon{font-size:44px;margin-bottom:10px}
.empty-state p{font-size:14px}
.tag{display:inline-block;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:var(--accent-light);color:var(--accent)}
.mt-2{margin-top:8px}.mt-3{margin-top:12px}.mt-4{margin-top:16px}
.flex{display:flex}.gap-2{gap:8px}.gap-3{gap:12px}.items-center{align-items:center}.flex-1{flex:1}
.text-right{text-align:end}.text-muted{color:var(--text-muted)}.text-sm{font-size:12px}.fw-bold{font-weight:700}
.reimb-pending{background:#fef3c7;color:#92400e}
.reimb-approved{background:var(--teal-bg);color:var(--teal)}
.reimb-rejected{background:var(--red-bg);color:var(--red)}
[dir="rtl"] .form-row{flex-direction:row-reverse}
[dir="rtl"] .btn-group{flex-direction:row-reverse}
[dir="rtl"] .modal-footer{flex-direction:row-reverse}
[dir="rtl"] table th,[dir="rtl"] table td{text-align:right}
[dir="rtl"] .summary-row{flex-direction:row-reverse}
[dir="rtl"] .summary-row span:last-child{direction:ltr;text-align:start}
[dir="rtl"] .payroll-summary{direction:rtl}
@media(max-width:768px){:root{--sidebar-w:190px}#content{padding:14px}}
@keyframes spin{to{transform:rotate(360deg)}}
#login-screen{position:fixed;inset:0;z-index:9999;background:var(--sidebar);display:flex;align-items:center;justify-content:center;padding:20px}
#login-screen.hidden{display:none}
.login-box{background:#1e293b;border-radius:16px;padding:40px 44px;width:100%;max-width:420px;box-shadow:0 24px 60px rgba(0,0,0,0.4)}
.login-logo{text-align:center;margin-bottom:30px}
.login-logo h1{font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.3px}
.login-logo p{font-size:13px;color:#64748b;margin-top:4px}
.login-logo .logo-icon{width:52px;height:52px;background:var(--accent);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px}
.login-field{margin-bottom:16px}
.login-field label{display:block;font-size:11.5px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px}
.login-field input{width:100%;padding:11px 14px;background:#0f172a;border:1.5px solid #334155;border-radius:8px;font-size:14px;color:#e2e8f0;font-family:var(--font);outline:none;transition:border 0.15s}
.login-field input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(99,102,241,0.15)}
.login-field input::placeholder{color:#475569}
.login-btn{width:100%;padding:12px;background:var(--accent);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;font-family:var(--font);cursor:pointer;margin-top:8px;transition:background 0.15s;display:flex;align-items:center;justify-content:center;gap:8px}
.login-btn:hover{background:#4f46e5}
.login-btn:disabled{background:#334155;cursor:not-allowed}
.login-error{background:#450a0a;border:1px solid #7f1d1d;border-radius:8px;padding:10px 14px;font-size:13px;color:#fca5a5;margin-top:14px;display:none}
.login-error.show{display:block}
.login-lock{text-align:center;padding:14px;background:#1c1917;border-radius:8px;font-size:13px;color:#fb923c;margin-top:14px;display:none}
.login-lock.show{display:block}
#login-spinner{width:18px;height:18px;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;display:none}
.logout-btn{margin:8px 14px 14px;background:rgba(220,38,38,0.1);border:1px solid rgba(220,38,38,0.2);color:#f87171;padding:8px 14px;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;width:calc(100% - 28px);text-align:left;transition:all 0.15s;font-family:var(--font)}
.logout-btn:hover{background:rgba(220,38,38,0.2);color:#fca5a5}
</style>
</head>
<body>
<div id="login-screen">
  <div class="login-box">
    <div class="login-logo">
      <div class="logo-icon">🏢</div>
      <h1>Payroll Management</h1>
      <p>Nael Advertising — Secure Access</p>
    </div>
    <div class="login-field">
      <label>Email Address</label>
      <input type="email" id="login-email" placeholder="your@email.com" autocomplete="email" onkeydown="if(event.key==='Enter')doLogin()">
    </div>
    <div class="login-field">
      <label>Password</label>
      <input type="password" id="login-pass" placeholder="••••••••••••" autocomplete="current-password" onkeydown="if(event.key==='Enter')doLogin()">
    </div>
    <button class="login-btn" id="login-btn" onclick="doLogin()">
      <div id="login-spinner"></div>
      <span id="login-btn-text">Sign In</span>
    </button>
    <div class="login-error" id="login-error">Incorrect email or password. Please try again.</div>
    <div class="login-lock" id="login-lock">🔒 Too many failed attempts. Try again in <span id="lock-countdown">60</span>s.</div>
  </div>
</div>
<div id="sidebar">
  <div class="brand">
    <h1 id="brand-title">Payroll Management</h1>
    <p id="brand-sub">System v2.1</p>
  </div>
  <nav id="sidenav"></nav>
  <div style="padding:12px 14px;display:flex;gap:6px">
    <button class="lang-btn active" id="btn-en" onclick="setLang('en')">EN</button>
    <button class="lang-btn" id="btn-ar" onclick="setLang('ar')">عربي</button>
  </div>
  <button class="logout-btn" onclick="doLogout()">🔓 Sign Out</button>
  <div class="sidebar-footer" id="sidebar-footer-text">Data saved in browser</div>
</div>
<div id="main">
  <div id="topbar">
    <h2 id="page-title">Dashboard</h2>
    <div class="topbar-right" id="topbar-actions"></div>
  </div>
  <div id="content"></div>
</div>
<div id="modal-bg" onclick="closeModalBg(event)">
  <div class="modal" id="modal-box">
    <div class="modal-header">
      <h3 id="modal-title">Modal</h3>
      <button class="modal-close" onclick="closeModal()">×</button>
    </div>
    <div class="modal-body" id="modal-body"></div>
    <div class="modal-footer" id="modal-footer"></div>
  </div>
</div>
<script>
// ===================== TRANSLATIONS =====================
const LANG = {
  en: {
    brand:'Payroll Management',brand_sub:'System v2.1',sidebar_footer:'Data saved in browser',
    dashboard:'Dashboard',employees:'Employees',attendance:'Attendance',exceptions:'Exceptions',
    advances:'Salary Advances',commissions:'Commissions',reimbursements:'Reimbursements',payroll:'Payroll',
    employee_mgmt:'Employee Management',attendance_overview:'Attendance Overview',
    manage_exceptions:'Manage Exceptions',salary_advances:'Salary Advances',payroll_calculation:'Payroll Calculation',settings_nav:'Settings',
    add_employee:'Add Employee',edit_employee:'Edit Employee',add_advance:'Add Advance',add_deal:'Add Deal',
    add_reimb:'Add Reimbursement',add_exception:'Add Exception',add_for_all:'Add for All Employees',
    save:'Save',cancel:'Cancel',delete:'Delete',edit:'Edit',load:'Load',
    calculate:'🧮 Calculate',download:'⬇️ Download CSV',import_csv:'📂 Import CSV',
    import_device:'📡 Import from Device',device_settings:'⚙️ Device Settings',
    bridge_url:'Bridge URL (PC running zk_bridge.py)',test_conn:'Test Connection',connecting:'Connecting…',
    device_ok:'✓ Device Connected',device_fail:'✗ Connection Failed',importing:'Importing from device…',
    import_ok:'✓ Import Complete',import_fail:'Import Failed – Is zk_bridge.py running?',
    id_mismatch_hint:'⚠️ Employee IDs in this app must match User IDs enrolled in the ZKTeco device.',
    name:'Name',employee_id:'Employee ID',department:'Department',role:'Role',salary:'Salary (AED)',
    status:'Status',shift:'Shift',actions:'Actions',month:'Month',year:'Year',employee:'Employee',
    all_employees:'(All)',date:'Date',amount:'Amount (AED)',reason:'Reason',notes:'Notes',
    check_in:'Check-in',check_out:'Check-out',present:'Present ✓',absent:'Absent',
    saturday:'Saturday (Remote)',sunday:'Sunday (Off)',exception_lbl:'Exception',full_name:'Full Name',
    default_shift:'Flexible (9:00–10:00 AM start, 9h shift)',late_shift:'Late Shift (11:30–20:00)',
    category:'Category',description:'Description',receipt:'Receipt / Reference',reimb_status:'Status',
    pending:'Pending',approved:'Approved',rejected:'Rejected',
    cat_fuel:'Fuel',cat_parking:'Parking',cat_supplies:'Office Supplies',cat_meals:'Meals / Entertainment',
    cat_transport:'Transport / Taxi',cat_maintenance:'Maintenance',cat_other:'Other',
    total_employees:'Total Employees',active:'active',this_month_advances:'This Month Advances',
    this_month_deals:'This Month Deals',total_exceptions:'Total Exceptions',total_reimbs:'Approved Reimbursements',
    quick_actions:'Quick Actions',basic_salary:'Basic Monthly Salary',days_in_month:'Days in Month',
    daily_rate:'Daily Rate',working_days:'Working Days (Mon–Fri)',absence_deductions:'Absence Deductions',
    absence_cost:'Absence Cost',bonus_recovery:'Bonus Recovery',att_salary:'Attendance Salary',
    commission:'Commission',advances_lbl:'Advances',reimb_lbl:'Reimbursements',net_total:'💰 NET TOTAL PAY',
    day_breakdown:'Day-by-Day Breakdown',fill_fields:'Please fill all required fields.',
    dup_id:'Employee ID already exists.',emp_not_found:'Employee not found.',select_emp:'Select an employee first.',
    select_emp_month_year:'Select Employee, Month and Year.',record_saved:'Record saved.',record_deleted:'Record deleted.',
    emp_added:'Employee added.',emp_updated:'Employee updated.',emp_deleted:'Employee deleted.',
    advance_saved:'Advance saved.',deal_saved:'Deal saved.',reimb_saved:'Reimbursement saved.',
    exception_saved:'Exception saved.',calc_first:'Calculate payroll first.',
    no_advances:'No advances found for this period.',no_deals:'No deals for this period.',
    no_reimbs:'No reimbursements found for this period.',no_exceptions:'No exceptions recorded yet.',
    no_employees:'No employees yet.',up_to_day:'Up to day (optional)',
    import_hint:'💡 CSV Import: ZKBio format with EmployeeID/Name + DateTime columns.',
    data_browser_hint:'ℹ️ All data is saved in your browser\'s local storage.',
    approved_only_hint:'ℹ️ Only Approved reimbursements are included in payroll.',
    by_dept:'Employees by Department',source:'Source',base_pct:'Base %',primary_emp:'Primary Employee',
    split_pct:'Split %',deal_id:'Deal #',client:'Client',
    excl_all_warn:'This will add the selected exception for every employee.',
    partial_month:'(up to day',total:'Total',
    splits_title:'Commission Splits (how commission is shared)',
    add_split:'Add',update_split:'Update',remove_split:'Remove',split_total:'Split total',
    advance_id:'#',reimb_id:'#',full_absent:'Full Absent',absent_halves:'Absent Halves Gathered',
    att_days:'Attendance Days',fully_checked:'Fully Checked Days',exc_days:'Exception Days (paid)',
    weekends_paid:'Weekends (paid)',bonus_lbl:'Bonus (recovered days)',halves_gathered:'Halves Gathered',
    reimb_total:'Reimbursements Total',remarks_nav:'Employee Remarks',
    remarks_title:'Employee Disputes & Remarks',mark_reviewed:'Mark Reviewed',
    no_remarks:'No remarks submitted yet.',pending_remarks:'Pending',
    deductions:'Deductions',deduction_mgmt:'Deductions',add_deduction:'Add Deduction',
    deduction_id:'#',deduction_reason:'Reason / Description',no_deductions:'No deductions for this period.',
    deduction_saved:'Deduction saved.',deductions_lbl:'Deductions',
    cat_parking_card:'Parking Card',cat_uniform:'Uniform / Equipment',cat_loan:'Loan Repayment',
    cat_damage:'Damage / Loss',cat_absence_pen:'Absence Penalty',cat_other_ded:'Other',
    this_month_deductions:'This Month Deductions',saturday_nav:'Saturday Roster',
    saturday_title:'Saturday Availability Roster',saturday_date:'Saturday Date',
    sat_available:'Available ✓',sat_late:'After 11 AM ⚠️',sat_absent:'Not Submitted',
    sat_deadline:'Deadline: before 11:00 AM',sat_paid:'Paid Saturday',sat_deducted:'Deducted',
    reimb_from_emp:'From Employee',
  },
  ar: {
    brand:'نظام إدارة الرواتب',brand_sub:'الإصدار 2.1',sidebar_footer:'البيانات محفوظة في المتصفح',
    dashboard:'لوحة التحكم',employees:'الموظفون',attendance:'الحضور',exceptions:'الاستثناءات',
    advances:'دفع مسبق',commissions:'العمولات',reimbursements:'المصروفات',payroll:'الراتب',
    employee_mgmt:'إدارة الموظفين',attendance_overview:'نظرة عامة على الحضور',
    manage_exceptions:'إدارة الاستثناءات',salary_advances:'دفع مسبق',payroll_calculation:'حساب الراتب',settings_nav:'الإعدادات',
    add_employee:'إضافة موظف',edit_employee:'تعديل موظف',add_advance:'إضافة دفعة مسبقة',
    add_deal:'إضافة صفقة',add_reimb:'إضافة مصروف',add_exception:'إضافة استثناء',
    add_for_all:'إضافة لجميع الموظفين',save:'حفظ',cancel:'إلغاء',delete:'حذف',edit:'تعديل',load:'تحميل',
    calculate:'🧮 احتساب',download:'⬇️ تحميل CSV',import_csv:'📂 استيراد CSV',
    import_device:'📡 استيراد من الجهاز',device_settings:'⚙️ إعدادات الجهاز',
    bridge_url:'رابط البريدج',test_conn:'اختبار الاتصال',connecting:'جارٍ الاتصال…',
    device_ok:'✓ الجهاز متصل',device_fail:'✗ فشل الاتصال',importing:'جارٍ الاستيراد…',
    import_ok:'✓ اكتمل الاستيراد',import_fail:'فشل الاستيراد — هل يعمل zk_bridge.py؟',
    id_mismatch_hint:'⚠️ يجب أن تتطابق أرقام الموظفين مع أرقام المستخدمين في جهاز ZKTeco.',
    name:'الاسم',employee_id:'رقم الموظف',department:'القسم',role:'المسمى الوظيفي',
    salary:'الراتب (درهم)',status:'الحالة',shift:'الوردية',actions:'الإجراءات',
    month:'الشهر',year:'السنة',employee:'الموظف',all_employees:'(الكل)',
    date:'التاريخ',amount:'المبلغ (درهم)',reason:'السبب',notes:'ملاحظات',
    check_in:'وقت الدخول',check_out:'وقت الخروج',present:'حاضر ✓',absent:'غائب',
    saturday:'السبت (عن بُعد)',sunday:'الأحد (إجازة)',exception_lbl:'استثناء',full_name:'الاسم الكامل',
    default_shift:'افتراضية (10:30–19:00)',late_shift:'وردية متأخرة (11:30–20:00)',
    category:'الفئة',description:'الوصف',receipt:'الإيصال / المرجع',reimb_status:'الحالة',
    pending:'قيد المراجعة',approved:'معتمد',rejected:'مرفوض',
    cat_fuel:'وقود',cat_parking:'مواقف',cat_supplies:'مستلزمات مكتبية',cat_meals:'وجبات / ترفيه',
    cat_transport:'مواصلات / تاكسي',cat_maintenance:'صيانة',cat_other:'أخرى',
    total_employees:'إجمالي الموظفين',active:'نشط',this_month_advances:'دفعات مسبقة هذا الشهر',
    this_month_deals:'صفقات هذا الشهر',total_exceptions:'إجمالي الاستثناءات',total_reimbs:'مصروفات معتمدة',
    quick_actions:'إجراءات سريعة',basic_salary:'الراتب الأساسي الشهري',days_in_month:'أيام الشهر',
    daily_rate:'الراتب اليومي',working_days:'أيام العمل (إثنين–جمعة)',absence_deductions:'خصومات الغياب',
    absence_cost:'تكلفة الغياب',bonus_recovery:'استعادة الخصم',att_salary:'راتب الحضور',
    commission:'العمولة',advances_lbl:'دفع مسبق',reimb_lbl:'المصروفات',net_total:'💰 صافي الراتب',
    day_breakdown:'تفصيل يومي',fill_fields:'يرجى ملء جميع الحقول المطلوبة.',
    dup_id:'رقم الموظف موجود مسبقاً.',emp_not_found:'الموظف غير موجود.',
    select_emp:'الرجاء اختيار موظف.',select_emp_month_year:'اختر الموظف والشهر والسنة.',
    record_saved:'تم حفظ السجل.',record_deleted:'تم حذف السجل.',
    emp_added:'تمت إضافة الموظف.',emp_updated:'تم تحديث الموظف.',emp_deleted:'تم حذف الموظف.',
    advance_saved:'تم حفظ الدفع المسبق.',deal_saved:'تم حفظ الصفقة.',reimb_saved:'تم حفظ المصروف.',
    exception_saved:'تم حفظ الاستثناء.',calc_first:'احتسب الراتب أولاً.',
    no_advances:'لا توجد دفعات مسبقة في هذه الفترة.',no_deals:'لا توجد صفقات في هذه الفترة.',
    no_reimbs:'لا توجد مصروفات في هذه الفترة.',no_exceptions:'لا توجد استثناءات مسجلة.',
    no_employees:'لا يوجد موظفون.',up_to_day:'حتى اليوم (اختياري)',
    import_hint:'💡 استيراد CSV: تنسيق ZKBio مع أعمدة رقم الموظف والتاريخ والوقت.',
    data_browser_hint:'ℹ️ جميع البيانات محفوظة في متصفحك.',
    approved_only_hint:'ℹ️ يتم احتساب المصروفات المعتمدة فقط في الراتب.',
    by_dept:'الموظفون حسب القسم',source:'المصدر',base_pct:'% الأساس',
    primary_emp:'الموظف الرئيسي',split_pct:'% التوزيع',deal_id:'رقم الصفقة',client:'العميل',
    excl_all_warn:'سيتم إضافة الاستثناء لجميع الموظفين.',partial_month:'حتى يوم',total:'الإجمالي',
    splits_title:'توزيع العمولة',add_split:'إضافة',update_split:'تحديث',remove_split:'حذف',
    split_total:'مجموع التوزيع',advance_id:'#',reimb_id:'#',full_absent:'أيام غياب كاملة',
    absent_halves:'نصف أيام مجمّعة',att_days:'أيام الحضور',fully_checked:'أيام حضور كاملة',
    exc_days:'أيام استثناء (مدفوعة)',weekends_paid:'عطل نهاية الأسبوع (مدفوعة)',
    bonus_lbl:'استعادة الخصم',halves_gathered:'أنصاف مجمّعة',reimb_total:'إجمالي المصروفات',
    remarks_nav:'ملاحظات الموظفين',remarks_title:'نزاعات وملاحظات الموظفين',
    mark_reviewed:'تم المراجعة',no_remarks:'لا توجد ملاحظات بعد.',pending_remarks:'معلق',
    deductions:'الخصومات',deduction_mgmt:'الخصومات',add_deduction:'إضافة خصم',
    deduction_id:'#',deduction_reason:'السبب / الوصف',no_deductions:'لا توجد خصومات في هذه الفترة.',
    deduction_saved:'تم حفظ الخصم.',deductions_lbl:'الخصومات',
    cat_parking_card:'بطاقة مواقف',cat_uniform:'زي / معدات',cat_loan:'سداد قرض',
    cat_damage:'تلف / فقدان',cat_absence_pen:'غرامة غياب',cat_other_ded:'أخرى',
    this_month_deductions:'خصومات هذا الشهر',saturday_nav:'حضور السبت',
    saturday_title:'قائمة توافر السبت',saturday_date:'تاريخ السبت',
    sat_available:'متاح ✓',sat_late:'بعد الحادية عشرة ⚠️',sat_absent:'لم يسجّل',
    sat_deadline:'الموعد النهائي: قبل 11:00 صباحاً',sat_paid:'سبت مدفوع',sat_deducted:'محسوم',
    reimb_from_emp:'من الموظف',
  }
};
// ===================== STATE =====================
let currentLang = localStorage.getItem('pms_lang') || 'en';
let currentView = 'dashboard';
let lastPayroll = null;
let attState = {};
let bridgeUrl = localStorage.getItem('pms_bridge_url') || 'http://192.168.70.47:5000';
function t(key){ return (LANG[currentLang][key])||(LANG['en'][key])||key; }
function setLang(lang){
  currentLang=lang; localStorage.setItem('pms_lang',lang);
  document.getElementById('html-root').setAttribute('lang',lang);
  document.getElementById('html-root').setAttribute('dir',lang==='ar'?'rtl':'ltr');
  document.getElementById('btn-en').classList.toggle('active',lang==='en');
  document.getElementById('btn-ar').classList.toggle('active',lang==='ar');
  document.getElementById('brand-title').textContent=t('brand');
  document.getElementById('brand-sub').textContent=t('brand_sub');
  document.getElementById('sidebar-footer-text').textContent=t('sidebar_footer');
  buildNav(); route(currentView);
}
// ===================== DATA LAYER =====================
const PMS_API   = 'https://naeladvertising.ae/pms_api.php';
const PMS_TOKEN = 'PmS_N@3l_X7k2_2026!';
function _serverWrite(key,jsonStr){
  fetch(`${PMS_API}?key=${key}`,{method:'POST',headers:{'X-PMS-Token':PMS_TOKEN,'Content-Type':'application/json'},body:jsonStr}).catch(()=>{});
}
async function syncAllFromServer(){
  const keyList=Object.values(KEYS);
  let serverTotal=0;
  const results=await Promise.allSettled(keyList.map(k=>
    fetch(`${PMS_API}?key=${k}`,{headers:{'X-PMS-Token':PMS_TOKEN},signal:AbortSignal.timeout(15000)})
      .then(r=>r.text()).then(text=>({key:k,text}))
  ));
  for(const r of results){
    if(r.status==='fulfilled'){
      const{key,text}=r.value;
      if(!text||text==='null')continue;
      try{const p=JSON.parse(text);const c=Array.isArray(p)?p.length:Object.keys(p).length;if(c>0)serverTotal+=c;}catch{}
    }
  }
  if(serverTotal>0){
    for(const r of results){
      if(r.status==='fulfilled'&&r.value.text&&r.value.text!=='null'){
        try{JSON.parse(r.value.text);localStorage.setItem(r.value.key,r.value.text);}catch{}
      }
    }
  } else {
    const pushAll=keyList.map(k=>{
      const local=localStorage.getItem(k);
      if(!local||local==='null'||local==='[]'||local==='{}')return Promise.resolve();
      return fetch(`${PMS_API}?key=${k}`,{method:'POST',headers:{'X-PMS-Token':PMS_TOKEN,'Content-Type':'application/json'},body:local}).catch(()=>{});
    });
    await Promise.allSettled(pushAll);
  }
}
const KEYS={employees:'pms_employees',attendance:'pms_attendance',exceptions:'pms_exceptions',advances:'pms_advances',deals:'pms_deals',splits:'pms_splits',reimbs:'pms_reimbs',deductions:'pms_deductions',saturday:'pms_saturday'};
const db={
  get:(k,def)=>JSON.parse(localStorage.getItem(KEYS[k])||JSON.stringify(def!==undefined?def:[])),
  set:(k,v)=>{const json=JSON.stringify(v);localStorage.setItem(KEYS[k],json);_serverWrite(KEYS[k],json);},
  getEmployees:()=>db.get('employees'),setEmployees:v=>db.set('employees',v),
  getAttendance:()=>db.get('attendance',{}),setAttendance:v=>db.set('attendance',v),
  getExceptions:()=>db.get('exceptions'),setExceptions:v=>db.set('exceptions',v),
  getAdvances:()=>db.get('advances'),setAdvances:v=>db.set('advances',v),
  getDeals:()=>db.get('deals'),setDeals:v=>db.set('deals',v),
  getSplits:()=>db.get('splits'),setSplits:v=>db.set('splits',v),
  getReimbs:()=>db.get('reimbs'),setReimbs:v=>db.set('reimbs',v),
  getDeductions:()=>db.get('deductions'),setDeductions:v=>db.set('deductions',v),
  getSaturday:()=>db.get('saturday'),setSaturday:v=>db.set('saturday',v),
};
// ===================== UTILS =====================
const months_en=['January','February','March','April','May','June','July','August','September','October','November','December'];
const months_ar=['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
const monthNums={January:1,February:2,March:3,April:4,May:5,June:6,July:7,August:8,September:9,October:10,November:11,December:12};
const months_ar_to_en={يناير:'January',فبراير:'February',مارس:'March',أبريل:'April',مايو:'May',يونيو:'June',يوليو:'July',أغسطس:'August',سبتمبر:'September',أكتوبر:'October',نوفمبر:'November',ديسمبر:'December'};
function getMonthEN(val){return months_ar_to_en[val]||val;}
function getMonthsList(){return currentLang==='ar'?months_ar:months_en;}
function getMonthNum(val){const en=getMonthEN(val);return monthNums[en]||1;}
function getDaysInMonth(y,m){return new Date(y,m,0).getDate();}
function getWeekday(ds){return new Date(ds+'T00:00:00').getDay();}
function dateLabel(ds){
  const d=new Date(ds+'T00:00:00');
  const loc=currentLang==='ar'?'ar-SA':'en-GB';
  return d.toLocaleDateString(loc,{weekday:'short',day:'2-digit',month:'short',year:'numeric'})
    .replace(/[\u0660-\u0669]/g,c=>c.charCodeAt(0)-0x0660)
    .replace(/[\u06f0-\u06f9]/g,c=>c.charCodeAt(0)-0x06f0);
}
function timeToMins(t){if(!t)return 0;const[h,m]=(t||'').split(':').map(Number);return h*60+m;}
function num(n){return String(n).replace(/[\u0660-\u0669\u06f0-\u06f9]/g,c=>c.charCodeAt(0)-(c.charCodeAt(0)>=0x06f0?0x06f0:0x0660));}
function nextId(arr,field){const ids=arr.map(x=>parseInt(x[field]||0)).filter(n=>!isNaN(n));return String(ids.length?Math.max(...ids)+1:1);}
function esc(s){return String(s||'').replace(/&/g,'&amp;').replace(/</g,'<').replace(/>/g,'>').replace(/"/g,'"');}
function toast(msg,type='success'){
  const el=document.createElement('div');
  const dir=currentLang==='ar'?'right:auto;left:24px':'right:24px;left:auto';
  el.style.cssText=`position:fixed;bottom:24px;${dir};z-index:9999;padding:12px 20px;border-radius:8px;font-size:13px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,0.15);animation:modal-in 0.18s ease;`;
  el.style.background=type==='success'?'#16a34a':type==='error'?'#dc2626':'#0d9488';
  el.style.color='#fff';el.textContent=msg;
  document.body.appendChild(el);setTimeout(()=>el.remove(),3000);
}
function yearOptions(sel=''){let s='';for(let y=2023;y<=2035;y++)s+=`<option ${y==sel?'selected':''}>${y}</option>`;return s;}
function monthOptions(sel=''){return getMonthsList().map(m=>`<option ${m===sel||getMonthEN(m)===getMonthEN(sel)?'selected':''}>${m}</option>`).join('');}
function currentMonth(){return getMonthsList()[new Date().getMonth()];}
function currentYear(){return new Date().getFullYear();}
function getCurrentMonthEN(){return months_en[new Date().getMonth()];}
function getReimbCats(){
  return [{key:'fuel',label:t('cat_fuel')},{key:'parking',label:t('cat_parking')},
    {key:'supplies',label:t('cat_supplies')},{key:'meals',label:t('cat_meals')},
    {key:'transport',label:t('cat_transport')},{key:'maintenance',label:t('cat_maintenance')},
    {key:'other',label:t('cat_other')}];
}
function excReasons(){
  return ['Off-site Work','Sick Leave','Late with Approval','Early Leave with Approval','Personal Vacation',
    'Annual Vacation','Maternity / Paternity Leave','Bereavement Leave','System Error','Public Holiday'];
}
// ===================== AUTH =====================
const _AUTH={email:'admin@naeladvertising.ae',_pc:[78,97,101,108,64,65,100,118,35,50,48,50,54,33]};
let _failCount=0,_lockUntil=0,_expectedHash='';
let _currentRole='admin';
let _currentUserViews=null; // null = all access

const ALL_VIEWS=['dashboard','employees','attendance','exceptions','advances','commissions',
  'reimbursements','deductions','remarks','saturday','payroll','settings'];

function isManager(){return _currentRole==='manager';}
function canAccess(view){
  if(!isManager()) return true; // admin sees everything
  if(view==='settings') return false; // managers never see settings
  if(_currentUserViews) return _currentUserViews.has(view);
  return false;
}

// Returns true if a manager is trying to act on their own linked employee record
function isSelf(empId){
  if(!isManager()) return false;
  const selfEmpId=sessionStorage.getItem('pms_self_emp_id');
  if(!selfEmpId) return false;
  return String(selfEmpId)===String(empId);
}
function blockSelf(){
  toast('You cannot modify your own employee record or data','error');
}

async function getMgrUsers(){
  try{
    const r=await fetch(`${PMS_API}?action=store&key=pms_mgr_users`,{headers:{'X-PMS-Token':PMS_TOKEN}});
    const text=await r.text();
    if(!text||text==='null') return [];
    return JSON.parse(text);
  }catch{return [];}
}
async function setMgrUsers(users){
  const body=JSON.stringify(users);
  await fetch(`${PMS_API}?action=store&key=pms_mgr_users`,{method:'POST',
    headers:{'X-PMS-Token':PMS_TOKEN,'Content-Type':'application/json'},body});
}

// ── AUDIT LOG ─────────────────────────────────────────────────
function _currentUserName(){
  const role=sessionStorage.getItem('pms_role')||'admin';
  if(role==='admin') return 'Admin';
  // Try to find manager name from stored users
  const email=sessionStorage.getItem('pms_audit_email')||'Manager';
  return email;
}
async function auditLog(action,details=''){
  try{
    const existing=await fetch(`${PMS_API}?action=store&key=pms_audit_log`,{headers:{'X-PMS-Token':PMS_TOKEN}});
    const text=await existing.text();
    const logs=text&&text!=='null'?JSON.parse(text):[];
    logs.unshift({
      ts:new Date().toISOString(),
      user:_currentUserName(),
      role:sessionStorage.getItem('pms_role')||'admin',
      action,details
    });
    // Keep last 500 entries
    if(logs.length>500) logs.splice(500);
    await fetch(`${PMS_API}?action=store&key=pms_audit_log`,{method:'POST',
      headers:{'X-PMS-Token':PMS_TOKEN,'Content-Type':'application/json'},
      body:JSON.stringify(logs)});
  }catch(e){console.log('Audit log error:',e);}
}

async function _sha256(str){const buf=await crypto.subtle.digest('SHA-256',new TextEncoder().encode(str));return Array.from(new Uint8Array(buf)).map(b=>b.toString(16).padStart(2,'0')).join('');}
(async()=>{const pwd=_AUTH._pc.map(c=>String.fromCharCode(c)).join('');_expectedHash=await _sha256(_AUTH.email.toLowerCase()+'::'+pwd);})();
function isLoggedIn(){const tok=sessionStorage.getItem('pms_tok');const exp=parseInt(sessionStorage.getItem('pms_tok_exp')||'0');return(tok==='authenticated_nael_2026'||tok==='authenticated_nael_mgr_2026')&&Date.now()<exp;}

async function doLogin(){
  const now=Date.now();if(now<_lockUntil)return;
  const email=document.getElementById('login-email').value.trim().toLowerCase();
  const pass=document.getElementById('login-pass').value;
  const btn=document.getElementById('login-btn'),spinner=document.getElementById('login-spinner'),btnTxt=document.getElementById('login-btn-text');
  const errEl=document.getElementById('login-error'),lockEl=document.getElementById('login-lock');
  if(!email||!pass){errEl.classList.add('show');errEl.textContent='Please enter email and password.';return;}
  btn.disabled=true;spinner.style.display='block';btnTxt.textContent='Signing in…';
  errEl.classList.remove('show');lockEl.classList.remove('show');
  await new Promise(r=>setTimeout(r,800));
  const inputHash=await _sha256(email+'::'+pass);

  // Check admin
  if(email===_AUTH.email.toLowerCase()&&inputHash===_expectedHash){
    _failCount=0;_currentRole='admin';_currentUserViews=null;
    sessionStorage.setItem('pms_tok','authenticated_nael_2026');
    sessionStorage.setItem('pms_tok_exp',String(Date.now()+43200000));
    sessionStorage.setItem('pms_role','admin');
    sessionStorage.setItem('pms_audit_email','Admin');
    sessionStorage.removeItem('pms_user_views');
    document.getElementById('login-screen').classList.add('hidden');
    return;
  }

  // Check dynamic manager accounts from server
  const users=await getMgrUsers();
  const user=users.find(u=>u.email===email&&u.active!==false);
  if(user&&user.hash===inputHash){
    _failCount=0;_currentRole='manager';
    _currentUserViews=new Set(user.views||[]);
    sessionStorage.setItem('pms_tok','authenticated_nael_mgr_2026');
    sessionStorage.setItem('pms_tok_exp',String(Date.now()+43200000));
    sessionStorage.setItem('pms_role','manager');
    sessionStorage.setItem('pms_audit_email',user.name||user.email);
    sessionStorage.setItem('pms_user_views',JSON.stringify(user.views||[]));
    if(user.selfEmpId) sessionStorage.setItem('pms_self_emp_id',user.selfEmpId);
    else sessionStorage.removeItem('pms_self_emp_id');
    document.getElementById('login-screen').classList.add('hidden');
    return;
  }

  _failCount++;btn.disabled=false;spinner.style.display='none';btnTxt.textContent='Sign In';
  document.getElementById('login-pass').value='';
  if(_failCount>=5){
    _lockUntil=Date.now()+60000;btn.disabled=true;
    lockEl.classList.add('show');errEl.classList.remove('show');
    let secs=60;
    const iv=setInterval(()=>{secs--;document.getElementById('lock-countdown').textContent=secs;
      if(secs<=0){clearInterval(iv);_failCount=0;_lockUntil=0;btn.disabled=false;lockEl.classList.remove('show');}
    },1000);
  } else {
    errEl.classList.add('show');
    errEl.textContent=`Incorrect email or password. ${5-_failCount} attempt${5-_failCount===1?'':'s'} remaining.`;
  }
}

function doLogout(){
  if(!confirm('Sign out of Payroll Management?'))return;
  sessionStorage.removeItem('pms_tok');sessionStorage.removeItem('pms_tok_exp');
  sessionStorage.removeItem('pms_role');sessionStorage.removeItem('pms_user_views');
  sessionStorage.removeItem('pms_self_emp_id');
  _currentRole='admin';_currentUserViews=null;
  document.getElementById('login-email').value='';document.getElementById('login-pass').value='';
  document.getElementById('login-error').classList.remove('show');
  document.getElementById('login-lock').classList.remove('show');
  document.getElementById('login-screen').classList.remove('hidden');
}
// ===================== NAV =====================
const NAV_ITEMS=[
  {view:'dashboard',icon:'📊',key:'dashboard'},{view:'employees',icon:'👥',key:'employee_mgmt'},
  {view:'attendance',icon:'📅',key:'attendance_overview'},{view:'exceptions',icon:'📋',key:'manage_exceptions'},
  {view:'advances',icon:'💰',key:'salary_advances'},{view:'commissions',icon:'🤝',key:'commissions'},
  {view:'reimbursements',icon:'🧾',key:'reimbursements'},{view:'deductions',icon:'✂️',key:'deduction_mgmt'},
  {view:'remarks',icon:'🔔',key:'remarks_nav'},{view:'saturday',icon:'📆',key:'saturday_nav'},
  {view:'payroll',icon:'🧮',key:'payroll_calculation'},
  {view:'settings',icon:'⚙️',key:'settings_nav'},
];
function buildNav(){
  const visibleItems=NAV_ITEMS.filter(n=>canAccess(n.view));
  fetch(`${PMS_API}?action=get_remarks&token=${encodeURIComponent(PMS_TOKEN)}`)
    .then(r=>r.json()).then(data=>{
      const pending=data.pending||0;
      document.getElementById('sidenav').innerHTML=visibleItems.map(n=>{
        const badge=(n.view==='remarks'&&pending>0)?`<span style="background:#dc2626;color:#fff;border-radius:20px;padding:1px 7px;font-size:10px;margin-left:auto">${pending}</span>`:'';
        return `<a onclick="route('${n.view}')" data-view="${n.view}" class="${currentView===n.view?'active':''}"><span class="icon">${n.icon}</span>${t(n.key)}${badge}</a>`;
      }).join('')+(isManager()?`<div style="background:#1e293b;color:#64748b;font-size:11px;font-weight:600;padding:8px 16px;margin:8px 0;border-radius:6px;text-align:center">👤 Manager Access</div>`:'');
    }).catch(()=>{
      document.getElementById('sidenav').innerHTML=visibleItems.map(n=>`<a onclick="route('${n.view}')" data-view="${n.view}" class="${currentView===n.view?'active':''}"><span class="icon">${n.icon}</span>${t(n.key)}</a>`).join('');
    });
}
// ===================== ROUTER =====================
function route(view){
  if(!canAccess(view)){
    document.getElementById('content').innerHTML=`<div class="card" style="text-align:center;padding:60px 30px">
      <div style="font-size:48px;margin-bottom:16px">🔒</div>
      <h2 style="font-size:18px;font-weight:700;margin-bottom:8px">Access Restricted</h2>
      <p style="color:var(--text-muted);font-size:14px">You don't have permission to view this section.<br>Please contact your administrator.</p>
    </div>`;
    return;
  }
  currentView=view;buildNav();
  const titleKeys={dashboard:'dashboard',employees:'employee_mgmt',attendance:'attendance_overview',
    exceptions:'manage_exceptions',advances:'salary_advances',commissions:'commissions',
    reimbursements:'reimbursements',deductions:'deduction_mgmt',remarks:'remarks_title',
    saturday:'saturday_title',payroll:'payroll_calculation',settings:'settings_nav'};
  document.getElementById('page-title').textContent=t(titleKeys[view]||view);
  document.getElementById('topbar-actions').innerHTML='';
  const views={dashboard:showDashboard,employees:showEmployees,attendance:showAttendance,
    exceptions:showExceptions,advances:showAdvances,commissions:showCommissions,
    reimbursements:showReimbursements,deductions:showDeductions,remarks:showRemarks,
    saturday:showSaturdayRoster,payroll:showPayroll,settings:showSettings};
  if(views[view])views[view]();
}
// ===================== MODAL =====================
function openModal(title,bodyHtml,footerHtml=''){
  document.getElementById('modal-title').textContent=title;
  document.getElementById('modal-body').innerHTML=bodyHtml;
  document.getElementById('modal-footer').innerHTML=footerHtml;
  document.getElementById('modal-bg').classList.add('open');
}
function closeModal(){document.getElementById('modal-bg').classList.remove('open');}
function closeModalBg(e){if(e.target===document.getElementById('modal-bg'))closeModal();}
// ===================== DEVICE BRIDGE =====================
function openDeviceSettings(){
  openModal('⚙️ '+t('device_settings'),`
    <div style="background:#0f172a;border-radius:8px;padding:14px 16px;margin-bottom:14px;font-size:12px;color:#94a3b8;line-height:1.7">
      <b style="color:#a5b4fc;font-size:13px">Your device settings (from photos):</b><br>
      • Device IP: <b style="color:#6ee7b7">192.168.70.201</b> &nbsp; Port: <b style="color:#6ee7b7">4370</b><br>
      • Your PC IP (bridge must run here): <b style="color:#fbbf24">192.168.70.47</b><br><br>
      <b style="color:#a5b4fc">3 steps to enable Import from Device:</b><br>
      1. On PC (192.168.70.23), open terminal and run:<br>
      &nbsp;&nbsp;<code style="background:#1e293b;padding:2px 6px;border-radius:3px">pip install flask flask-cors pyzk</code><br>
      2. Run the bridge: <code style="background:#1e293b;padding:2px 6px;border-radius:3px">python zk_bridge.py</code><br>
      3. The Bridge URL below should stay as-is (already pre-filled).
    </div>
    <div class="form-group"><label>${t('bridge_url')}</label>
      <input id="bridge-url-in" value="${esc(bridgeUrl)}" placeholder="http://192.168.70.23:5000">
    </div>
    <div id="dev-test-res" style="margin-top:10px"></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button>
     <button class="btn btn-ghost" onclick="testBridge()" id="test-conn-btn">🔌 ${t('test_conn')}</button>
     <button class="btn btn-primary" onclick="saveBridgeUrl()">${t('save')}</button>`);
}
function saveBridgeUrl(){
  const v=(document.getElementById('bridge-url-in').value||'').trim().replace(/\/+$/,'');
  if(!v){toast(t('fill_fields'),'error');return;}
  bridgeUrl=v;localStorage.setItem('pms_bridge_url',v);closeModal();toast(t('record_saved'));
}
async function testBridge(){
  const url=(document.getElementById('bridge-url-in')?.value||bridgeUrl).trim().replace(/\/+$/,'');
  const btn=document.getElementById('test-conn-btn'),res=document.getElementById('dev-test-res');
  if(btn)btn.disabled=true;
  if(res)res.innerHTML=`<div style="color:#94a3b8;font-size:13px">⏳ ${t('connecting')}</div>`;
  try{
    const d=await fetch(url+'/test',{mode:'cors'}).then(r=>r.json());
    if(d.status==='connected'){
      if(res)res.innerHTML=`<div class="alert alert-success">✓ ${t('device_ok')}<br><small>Device: ${d.device_name||'—'} · Users: ${d.user_count||0} · Records: ${d.attendance_count||0}</small></div>`;
    } else throw new Error(d.error||'Unknown');
  }catch(e){
    const msg=e.message.toLowerCase().includes('fetch')||e.message.toLowerCase().includes('failed')?
      'Bridge not reachable. Make sure zk_bridge.py is running on 192.168.70.23':e.message;
    if(res)res.innerHTML=`<div class="alert alert-warn">✗ ${t('device_fail')}<br><small>${msg}</small></div>`;
  }
  if(btn)btn.disabled=false;
}
async function importFromDevice(){
  openModal('📡 '+t('import_device'),
    `<div style="text-align:center;padding:24px 0">
       <div style="width:40px;height:40px;border:3px solid #e2e8f0;border-top-color:var(--accent);border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 14px"></div>
       <div style="font-weight:600">${t('importing')}</div>
       <div id="imp-prog" style="font-size:12px;color:var(--text-muted);margin-top:6px">Connecting to bridge at ${bridgeUrl}…</div>
     </div>`,''
  );
  const setProg=msg=>{const el=document.getElementById('imp-prog');if(el)el.textContent=msg;};
  try{
    setProg('Fetching punch records from device (this may take 10–30 seconds)…');
    const resp=await fetch(bridgeUrl.replace(/\/+$/,'')+'/attendance',{mode:'cors'});
    if(!resp.ok)throw new Error('HTTP '+resp.status);
    const data=await resp.json();
    if(data.status!=='ok')throw new Error(data.error||'Device error');
    const records=data.records||[];
    setProg(`Processing ${records.length} punch records…`);
    const emps=db.getEmployees();
    const empById=Object.fromEntries(emps.map(e=>[String(e.ID).trim(),e]));
    const empByName=Object.fromEntries(emps.map(e=>[e.Name.toLowerCase().trim(),e]));
    const raw={};let matched=0,skipped=0;
    for(const r of records){
      const id=String(r.emp_id||'').trim(),name=(r.name||'').toLowerCase().trim();
      const emp=empById[id]||empByName[name];
      if(!emp){skipped++;continue;}
      if(!raw[emp.ID])raw[emp.ID]={};if(!raw[emp.ID][r.date])raw[emp.ID][r.date]=[];
      if(r.time)raw[emp.ID][r.date].push(r.time);matched++;
    }
    const all=db.getAttendance();let saved=0;
    for(const empId in raw){
      if(!all[empId])all[empId]={};
      const empRec=empById[empId],midMins=(empRec?.Shift==='late_shift')?870:810;
      for(const d in raw[empId]){
        const times=[...new Set(raw[empId][d])].filter(Boolean).sort();
        const inT=[],outT=[];
        for(const tt of times){const m=timeToMins(tt);if(m<360)continue;if(m<=midMins)inT.push(tt);else outT.push(tt);}
        all[empId][d]={CheckIn:inT[0]||'',CheckOut:outT[outT.length-1]||''};saved++;
      }
    }
    db.setAttendance(all);
    const warnHtml=skipped>0?`<div class="alert alert-warn" style="margin-top:12px;text-align:left">⚠️ ${skipped} records skipped — employee IDs in app don't match ZK device user IDs.</div>`:'';
    document.getElementById('modal-body').innerHTML=`<div style="text-align:center;padding:20px 0"><div style="font-size:42px;margin-bottom:10px">✅</div><div style="font-weight:700;color:var(--green);font-size:15px">${t('import_ok')}</div><div style="font-size:13px;color:var(--text-muted);margin-top:6px">${records.length} punch records → ${saved} attendance days saved</div>${warnHtml}</div>`;
    document.getElementById('modal-footer').innerHTML=`<button class="btn btn-primary" onclick="closeModal();if(attState.empId)loadAttendanceView()">OK</button>`;
  }catch(e){
    const isConn=e.message.toLowerCase().includes('fetch')||e.message.toLowerCase().includes('failed');
    document.getElementById('modal-body').innerHTML=`<div style="text-align:center;padding:20px 0"><div style="font-size:42px;margin-bottom:10px">❌</div><div style="font-weight:700;color:var(--red);font-size:15px">${t('import_fail')}</div><div class="alert alert-warn" style="text-align:left;margin-top:14px">${isConn?`Bridge not reachable at <b>${bridgeUrl}</b>.`:e.message}</div></div>`;
    document.getElementById('modal-footer').innerHTML=`<button class="btn btn-secondary" onclick="closeModal()">Close</button><button class="btn btn-ghost" onclick="openDeviceSettings()">⚙️ Settings</button>`;
  }
}
// ===================== DASHBOARD =====================
function showDashboard(){
  const emps=db.getEmployees(),advances=db.getAdvances(),deals=db.getDeals(),exceptions=db.getExceptions(),reimbs=db.getReimbs();
  const m=getCurrentMonthEN(),mn=monthNums[m],y=currentYear();
  const thisMonthAdv=advances.filter(a=>{try{const d=new Date(a.Date);return d.getMonth()+1===mn&&d.getFullYear()===y}catch{return false}}).reduce((s,a)=>s+parseFloat(a.Amount||0),0);
  const thisMonthDeals=deals.filter(d=>{try{const dt=new Date(d.Date);return dt.getMonth()+1===mn&&dt.getFullYear()===y}catch{return false}});
  const totalDealVal=thisMonthDeals.reduce((s,d)=>s+parseFloat(d.Amount||0),0);
  const activeEmps=emps.filter(e=>e.Status&&e.Status.toLowerCase().includes('active'));
  const thisMonthReimbs=reimbs.filter(r=>{try{const d=new Date(r.Date);return d.getMonth()+1===mn&&d.getFullYear()===y&&r.Status==='approved'}catch{return false}}).reduce((s,r)=>s+parseFloat(r.Amount||0),0);
  const thisMonthDeds=db.getDeductions().filter(d=>{try{const dt=new Date(d.Date);return dt.getMonth()+1===mn&&dt.getFullYear()===y}catch{return false}}).reduce((s,d)=>s+parseFloat(d.Amount||0),0);
  const pendingReimbs=reimbs.filter(r=>r.Status==='pending').length;
  // ── PERFORMANCE ENGINE ─────────────────────────────────────
  const perfData=calcPerformance(emps,'month'); // default: this month
  document.getElementById('content').innerHTML=`
    <div class="cards-grid">
      <div class="stat-card c-accent"><div class="label">${t('total_employees')}</div><div class="value">${emps.length}</div><div class="sub">${activeEmps.length} ${t('active')}</div></div>
      ${!isManager()?`<div class="stat-card c-green"><div class="label">${t('this_month_advances')}</div><div class="value">${thisMonthAdv.toLocaleString('en',{maximumFractionDigits:0})}</div><div class="sub">${t('month')}: ${currentMonth()}</div></div>`:''}
      <div class="stat-card"><div class="label">${t('this_month_deals')}</div><div class="value">${thisMonthDeals.length}</div><div class="sub">AED ${totalDealVal.toLocaleString()}</div></div>
      ${!isManager()?`<div class="stat-card c-teal"><div class="label">${t('total_reimbs')}</div><div class="value">${thisMonthReimbs.toLocaleString('en',{maximumFractionDigits:0})}</div><div class="sub">AED – ${currentMonth()}</div></div>`:''}
      ${!isManager()?`<div class="stat-card"><div class="label">${t('this_month_deductions')}</div><div class="value" style="color:var(--red)">${thisMonthDeds.toLocaleString('en',{maximumFractionDigits:0})}</div><div class="sub">AED – ${currentMonth()}</div></div>`:''}
      ${pendingReimbs>0?`<div class="stat-card" style="background:var(--orange);cursor:pointer" onclick="route('reimbursements')"><div class="label" style="color:#fff">Pending Reimbs</div><div class="value" style="color:#fff">${pendingReimbs}</div><div class="sub" style="color:#fff">Tap to review</div></div>`:''}
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
      <div class="card"><div class="card-header"><h3>${t('by_dept')}</h3></div>${deptBreakdown(emps)}</div>
      <div class="card">
        <div class="card-header"><h3>${t('quick_actions')}</h3></div>
        <div class="btn-group">
          <button class="btn btn-primary" onclick="route('employees')">➕ ${t('add_employee')}</button>
          <button class="btn btn-secondary" onclick="route('attendance')">📅 ${t('attendance')}</button>
          <button class="btn btn-teal" onclick="route('reimbursements')">🧾 ${t('reimbursements')}${pendingReimbs>0?` <span style="background:#fff;color:var(--teal);border-radius:20px;padding:0 7px;font-size:11px">${pendingReimbs}</span>`:''}</button>
          <button class="btn btn-secondary" onclick="route('payroll')">🧮 ${t('payroll')}</button>
          <button class="btn btn-primary" onclick="route('remarks')">🔔 Remarks</button>
        </div>
        <div class="alert alert-info mt-4" style="margin-bottom:0">${t('data_browser_hint')}</div>
      </div>
    </div>
    <div class="card mt-3" id="perf-card">
      <div class="card-header" style="flex-wrap:wrap;gap:10px">
        <div>
          <h3 style="font-size:16px">🏆 Employee Performance</h3>
          <div style="font-size:12px;color:var(--text-muted);margin-top:2px">Ranked by attendance score — punctuality, full hours & consistency</div>
        </div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
          <select id="perf-period" onchange="refreshPerf()" style="padding:6px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:12px;font-family:var(--font)">
            <option value="month">This Month</option>
            <option value="3months">Last 3 Months</option>
            <option value="6months">Last 6 Months</option>
            <option value="all">All Time</option>
          </select>
          <select id="perf-dept" onchange="refreshPerf()" style="padding:6px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:12px;font-family:var(--font)">
            <option value="">All Departments</option>
            ${[...new Set(emps.map(e=>e.Department).filter(Boolean))].map(d=>`<option value="${esc(d)}">${esc(d)}</option>`).join('')}
          </select>
        </div>
      </div>
      <div id="perf-body">${renderPerf(perfData,emps)}</div>
    </div>`;
}
// ── PERFORMANCE CALCULATION ──────────────────────────────────
function calcPerformance(emps,period){
  const att=db.getAttendance();
  const excSet=new Set(db.getExceptions().map(x=>`${x.EmployeeID}_${x.Date}`));
  const LATE_C=10*60, WORK_M=9*60;
  const now=new Date();
  // Date range based on period
  function getRange(period){
    const end=new Date(now.getFullYear(),now.getMonth(),now.getDate());
    let start;
    if(period==='month') start=new Date(now.getFullYear(),now.getMonth(),1);
    else if(period==='3months') start=new Date(now.getFullYear(),now.getMonth()-3,1);
    else if(period==='6months') start=new Date(now.getFullYear(),now.getMonth()-6,1);
    else start=new Date(2024,0,1); // all time from Jan 2024
    return{start,end};
  }
  const {start,end}=getRange(period);
  const results=[];
  for(const emp of emps){
    if(!emp.Status||!emp.Status.toLowerCase().includes('active')) continue;
    const empAtt=att[emp.ID]||{};
    let workdays=0,present=0,lateArrivals=0,earlyLeaves=0,totalLateMin=0,totalEarlyMin=0,perfectDays=0,absentDays=0;
    // Iterate every calendar day in range
    const cur=new Date(start);
    while(cur<=end){
      const wd=cur.getDay();
      const ds=cur.toISOString().split('T')[0];
      cur.setDate(cur.getDate()+1);
      if(wd===0||wd===6) continue; // skip weekends
      if(excSet.has(`${emp.ID}_${ds}`)) continue; // skip exceptions
      workdays++;
      const rec=empAtt[ds];
      const ci=rec?.CheckIn||'', co=rec?.CheckOut||'';
      if(!ci&&!co){absentDays++;continue;}
      present++;
      const ciM=timeToMins(ci);
      const coM=co?timeToMins(co):null;
      const lateMin=Math.max(0,ciM-LATE_C);
      const expEnd=ciM+WORK_M;
      const earlyMin=coM!==null&&coM<expEnd?Math.max(0,expEnd-coM):0;
      if(lateMin>0){lateArrivals++;totalLateMin+=lateMin;}
      if(earlyMin>0){earlyLeaves++;totalEarlyMin+=earlyMin;}
      if(lateMin===0&&earlyMin===0) perfectDays++;
    }
    if(workdays===0) continue;
    // ── SCORE FORMULA (0–100) ────────────────────────────────
    // If never showed up, score is 0 regardless of other metrics
    if(present===0){
      results.push({emp,workdays,present,absentDays,lateArrivals:0,earlyLeaves:0,
        totalLateMin:0,totalEarlyMin:0,perfectDays:0,
        attRate:0,punctRate:0,hoursRate:0,score:0,avgLateMin:0,avgEarlyMin:0});
      continue;
    }
    // Attendance rate: 40 pts
    const attRate=workdays>0?(present/workdays):0;
    const attScore=attRate*40;
    // Punctuality (no late arrivals): 30 pts — only meaningful if present
    const punctRate=present>0?((present-lateArrivals)/present):0;
    const punctScore=punctRate*30;
    // Full hours (no early leave): 20 pts — only meaningful if present
    const hoursRate=present>0?((present-earlyLeaves)/present):0;
    const hoursScore=hoursRate*20;
    // Perfect days bonus: 10 pts
    const perfRate=present>0?(perfectDays/present):0;
    const perfScore=perfRate*10;
    const totalScore=Math.round(attScore+punctScore+hoursScore+perfScore);
    results.push({
      emp,workdays,present,absentDays,lateArrivals,earlyLeaves,
      totalLateMin,totalEarlyMin,perfectDays,
      attRate:Math.round(attRate*100),
      punctRate:Math.round(punctRate*100),
      hoursRate:Math.round(hoursRate*100),
      score:totalScore,
      avgLateMin:lateArrivals>0?Math.round(totalLateMin/lateArrivals):0,
      avgEarlyMin:earlyLeaves>0?Math.round(totalEarlyMin/earlyLeaves):0,
    });
  }
  return results.sort((a,b)=>b.score-a.score);
}
function refreshPerf(){
  const period=document.getElementById('perf-period')?.value||'month';
  const dept=document.getElementById('perf-dept')?.value||'';
  const emps=db.getEmployees();
  let data=calcPerformance(emps,period);
  if(dept) data=data.filter(r=>r.emp.Department===dept);
  const body=document.getElementById('perf-body');
  if(body) body.innerHTML=renderPerf(data,emps);
}
function renderPerf(data,emps){
  if(!data.length) return`<div class="empty-state"><div class="icon">📊</div><p>No attendance data for this period.</p></div>`;
  const medals=['🥇','🥈','🥉'];
  const scoreColor=s=>s>=85?'var(--green)':s>=70?'#16a34a':s>=55?'var(--orange)':s>=40?'#d97706':'var(--red)';
  const scoreBg=s=>s>=85?'#dcfce7':s>=70?'#d1fae5':s>=55?'#fef3c7':s>=40?'#ffedd5':'#fee2e2';
  const scoreLabel=s=>s>=85?'Excellent':s>=70?'Good':s>=55?'Average':s>=40?'Below Average':'Poor';
  // Top 3 highlight cards
  const top3=data.slice(0,3);
  const topCards=top3.map((r,i)=>`
    <div style="flex:1;min-width:160px;background:${i===0?'linear-gradient(135deg,#fef9c3,#fde68a)':i===1?'linear-gradient(135deg,#f1f5f9,#e2e8f0)':'linear-gradient(135deg,#fef3e2,#fed7aa)'};border-radius:12px;padding:16px;text-align:center;border:2px solid ${i===0?'#f59e0b':i===1?'#94a3b8':'#f97316'}">
      <div style="font-size:28px;margin-bottom:4px">${medals[i]||''}</div>
      <div style="font-weight:800;font-size:14px;margin-bottom:2px">${esc(r.emp.Name)}</div>
      <div style="font-size:11px;color:#64748b;margin-bottom:8px">${esc(r.emp.Department)}</div>
      <div style="font-size:32px;font-weight:900;color:${scoreColor(r.score)}">${r.score}</div>
      <div style="font-size:11px;font-weight:700;color:${scoreColor(r.score)}">${scoreLabel(r.score)}</div>
      <div style="font-size:11px;color:#64748b;margin-top:6px">${r.attRate}% attendance · ${r.perfectDays} perfect days</div>
    </div>`).join('');
  // Full table
  const rows=data.map((r,i)=>{
    const bar=pct=>`<div style="width:100%;background:#f1f5f9;border-radius:20px;height:6px;margin-top:2px"><div style="background:${scoreColor(r.score)};border-radius:20px;height:6px;width:${pct}%"></div></div>`;
    return`<tr style="border-bottom:1px solid var(--border)">
      <td style="padding:10px 12px;font-weight:700;color:var(--text-muted);font-size:13px">${i<3?medals[i]:i+1}</td>
      <td style="padding:10px 12px">
        <div style="font-weight:700;font-size:13px">${esc(r.emp.Name)}</div>
        <div style="font-size:11px;color:var(--text-muted)">${esc(r.emp.Department)}</div>
      </td>
      <td style="padding:10px 12px;text-align:center">
        <div style="display:inline-block;background:${scoreBg(r.score)};color:${scoreColor(r.score)};font-weight:800;font-size:18px;width:50px;height:50px;border-radius:50%;line-height:50px;text-align:center">${r.score}</div>
        <div style="font-size:10px;color:${scoreColor(r.score)};font-weight:600;margin-top:2px">${scoreLabel(r.score)}</div>
      </td>
      <td style="padding:10px 12px;min-width:90px">
        <div style="font-size:12px;font-weight:600">${r.attRate}%</div>
        ${bar(r.attRate)}
        <div style="font-size:10px;color:var(--text-muted)">${r.present}/${r.workdays} days</div>
      </td>
      <td style="padding:10px 12px;min-width:90px">
        <div style="font-size:12px;font-weight:600">${r.punctRate}%</div>
        ${bar(r.punctRate)}
        <div style="font-size:10px;color:var(--text-muted)">${r.lateArrivals} late${r.lateArrivals>0?` · avg ${r.avgLateMin}m`:''}</div>
      </td>
      <td style="padding:10px 12px;min-width:90px">
        <div style="font-size:12px;font-weight:600">${r.hoursRate}%</div>
        ${bar(r.hoursRate)}
        <div style="font-size:10px;color:var(--text-muted)">${r.earlyLeaves} early${r.earlyLeaves>0?` · avg ${r.avgEarlyMin}m`:''}</div>
      </td>
      <td style="padding:10px 12px;text-align:center">
        <div style="font-size:16px;font-weight:800;color:var(--accent)">${r.perfectDays}</div>
        <div style="font-size:10px;color:var(--text-muted)">perfect</div>
      </td>
    </tr>`;
  }).join('');
  return`
    <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap">${topCards}</div>
    <div style="overflow-x:auto;border-radius:8px;border:1px solid var(--border)">
      <table style="width:100%;border-collapse:collapse;font-size:13px">
        <thead>
          <tr style="background:#f8fafc">
            <th style="padding:10px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">#</th>
            <th style="padding:10px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Employee</th>
            <th style="padding:10px 12px;text-align:center;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Score</th>
            <th style="padding:10px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Attendance</th>
            <th style="padding:10px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Punctuality</th>
            <th style="padding:10px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Full Hours</th>
            <th style="padding:10px 12px;text-align:center;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Perfect Days</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    </div>
    <div style="margin-top:10px;font-size:11px;color:var(--text-muted);display:flex;gap:16px;flex-wrap:wrap">
      <span>Score = Attendance (40pts) + Punctuality (30pts) + Full Hours (20pts) + Perfect Days (10pts)</span>
      <span style="display:flex;gap:8px">
        <span style="color:var(--green);font-weight:600">■ Excellent 85+</span>
        <span style="color:#16a34a;font-weight:600">■ Good 70+</span>
        <span style="color:var(--orange);font-weight:600">■ Average 55+</span>
        <span style="color:var(--red);font-weight:600">■ Poor <55</span>
      </span>
    </div>`;
}
function deptBreakdown(emps){
  const depts={};emps.forEach(e=>{depts[e.Department||'—']=(depts[e.Department||'—']||0)+1});
  if(!Object.keys(depts).length)return`<p class="text-muted text-sm">${t('no_employees')}</p>`;
  return Object.entries(depts).map(([d,c])=>`
    <div class="flex items-center gap-3 mt-2">
      <div style="width:120px;font-size:13px;flex-shrink:0">${esc(d)}</div>
      <div style="flex:1;background:#f1f5f9;border-radius:20px;height:7px"><div style="background:var(--accent);border-radius:20px;height:7px;width:${Math.min(100,(c/emps.length)*100)}%"></div></div>
      <div style="font-size:12px;font-weight:700;width:20px;text-align:end">${c}</div>
    </div>`).join('');
}
// ===================== EMPLOYEES =====================
function showEmployees(){document.getElementById('topbar-actions').innerHTML=`<button class="btn btn-primary btn-sm" onclick="openEmpModal()">${t('add_employee')}</button>`;renderEmployeeTable();}
function renderEmployeeTable(){
  const emps=db.getEmployees().sort((a,b)=>a.ID.localeCompare(b.ID,undefined,{numeric:true}));
  document.getElementById('content').innerHTML=`<div class="card"><div class="card-header"><h3>${t('employees')} (${emps.length})</h3></div>
    ${emps.length===0?`<div class="empty-state"><div class="icon">👥</div><p>${t('no_employees')}</p></div>`:
    `<div class="table-wrap"><table><thead><tr><th>${t('employee_id')}</th><th>${t('name')}</th><th>${t('department')}</th><th>${t('role')}</th><th>${t('salary')}</th><th>${t('status')}</th><th>${t('shift')}</th><th>Portal Email</th><th>${t('actions')}</th></tr></thead>
    <tbody>${emps.map(e=>`<tr><td><b>${esc(e.ID)}</b></td><td>${esc(e.Name)}</td><td>${esc(e.Department)}</td><td>${esc(e.Role)}</td><td style="font-weight:600">${parseFloat(e.Salary||0).toLocaleString()}</td><td><span class="badge ${e.Status&&e.Status.toLowerCase().includes('active')?'badge-green':'badge-gray'}">${esc(e.Status)}</span></td><td><span class="badge badge-purple">${esc(e.Shift||'default')}</span></td><td class="text-sm text-muted">${esc(e.Email||'—')}</td><td><button class="btn btn-ghost btn-sm" onclick="openEmpModal('${esc(e.ID)}')">✏️ ${t('edit')}</button><button class="btn btn-ghost btn-sm" onclick="deleteEmp('${esc(e.ID)}')">🗑️</button></td></tr>`).join('')}</tbody></table></div>`}
    </div>`;
}
function openEmpModal(id=null){
  const emps=db.getEmployees(),e=id?emps.find(x=>x.ID===id):null;
  openModal(e?t('edit_employee'):t('add_employee'),`
    <div class="form-row"><div class="form-group wide"><label>${t('full_name')}</label><input id="f-name" value="${esc(e?.Name||'')}" placeholder="${t('name')}"></div><div class="form-group narrow"><label>${t('employee_id')}</label><input id="f-id" value="${esc(e?.ID||'')}" placeholder="EMP001" ${e?'readonly':''}></div></div>
    <div class="form-row"><div class="form-group"><label>${t('department')}</label><input id="f-dept" value="${esc(e?.Department||'')}"></div><div class="form-group"><label>${t('role')}</label><input id="f-role" value="${esc(e?.Role||'')}"></div></div>
    <div class="form-row"><div class="form-group wide"><label>Email (for employee portal)</label><input id="f-email" type="email" value="${esc(e?.Email||'')}" placeholder="employee@naeladvertising.ae"></div></div>
    <div class="form-row"><div class="form-group narrow"><label>${t('salary')}</label><input id="f-salary" type="number" value="${esc(e?.Salary||'')}"></div><div class="form-group"><label>${t('status')}</label><input id="f-status" value="${esc(e?.Status||'Active')}"></div>
    <div class="form-group narrow"><label>${t('shift')}</label><select id="f-shift"><option value="default" ${(!e?.Shift||e?.Shift==='default')?'selected':''}>${t('default_shift')}</option><option value="late_shift" ${e?.Shift==='late_shift'?'selected':''}>${t('late_shift')}</option></select></div></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-primary" onclick="saveEmployee(${e?`'${id}'`:'null'})">${t('save')}</button>`);
}
function saveEmployee(editId){
  const name=document.getElementById('f-name').value.trim(),id=document.getElementById('f-id').value.trim();
  if(isSelf(editId||id)){blockSelf();return;}
  const dept=document.getElementById('f-dept').value.trim(),role=document.getElementById('f-role').value.trim();
  const salary=document.getElementById('f-salary').value.trim(),status=document.getElementById('f-status').value.trim();
  const shift=document.getElementById('f-shift').value,email=document.getElementById('f-email').value.trim().toLowerCase();
  if(!name||!id||!salary){toast(t('fill_fields'),'error');return;}
  let emps=db.getEmployees();
  if(!editId&&emps.find(e=>e.ID===id)){toast(t('dup_id'),'error');return;}
  const rec={Name:name,ID:id,Department:dept,Role:role,Salary:salary,Status:status,Shift:shift,Email:email};
  if(editId){const i=emps.findIndex(e=>e.ID===editId);if(i>=0)emps[i]=rec;}else emps.push(rec);
  db.setEmployees(emps);closeModal();renderEmployeeTable();
  auditLog(editId?'Employee Updated':'Employee Added',`${name} (ID: ${id}, Dept: ${dept}, Salary: AED ${salary})`);
  toast(editId?t('emp_updated'):t('emp_added'));
}
function deleteEmp(id){
  if(isSelf(id)){blockSelf();return;}
  if(!confirm(t('delete')+'?'))return;
  const emp=db.getEmployees().find(e=>e.ID===id);
  db.setEmployees(db.getEmployees().filter(e=>e.ID!==id));renderEmployeeTable();
  auditLog('Employee Deleted',`${emp?.Name||id} (ID: ${id})`);
  toast(t('emp_deleted'));
}
// ===================== ATTENDANCE =====================
function showAttendance(){
  const emps=db.getEmployees();
  if(!attState.month)attState={empId:null,month:currentMonth(),year:currentYear()};
  document.getElementById('content').innerHTML=`
    <div class="filter-bar">
      <div class="form-group"><label>${t('employee')}</label><select id="att-emp"><option value="">-- ${t('employee')} --</option>${emps.map(e=>`<option value="${esc(e.ID)}" ${attState.empId===e.ID?'selected':''}>${esc(e.Name)}</option>`).join('')}</select></div>
      <div class="form-group narrow"><label>${t('month')}</label><select id="att-month">${monthOptions(attState.month)}</select></div>
      <div class="form-group narrow"><label>${t('year')}</label><select id="att-year">${yearOptions(attState.year)}</select></div>
      <button class="btn btn-primary" onclick="loadAttendanceView()">${t('load')}</button>
      <button class="btn btn-secondary" onclick="importAttCsv()">${t('import_csv')}</button>
    </div>
    <div class="alert alert-info">${t('import_hint')} &nbsp;|&nbsp; 📡 Device sync runs automatically every 5 minutes in the background.</div>
    <div id="att-table-area"></div><div id="att-editor-area"></div>`;
  if(attState.empId)loadAttendanceView();
}
function loadAttendanceView(){
  autoSyncFromDevice();
  const empId=document.getElementById('att-emp').value,month=document.getElementById('att-month').value,year=parseInt(document.getElementById('att-year').value);
  if(!empId){toast(t('select_emp'),'error');return;}
  attState={empId,month,year};
  const emp=db.getEmployees().find(e=>e.ID===empId);
  if(!emp){toast(t('emp_not_found'),'error');return;}
  const mn=getMonthNum(month),days=getDaysInMonth(year,mn),empAtt=(db.getAttendance()[empId])||{};
  const excMap={};db.getExceptions().filter(x=>String(x.EmployeeID)===String(empId)).forEach(x=>{excMap[x.Date]=x.Reason;});
  const today=new Date(),todayStr=today.toISOString().split('T')[0];
  const isCurrentMonth=(year===today.getFullYear()&&mn===today.getMonth()+1);
  const maxDay=isCurrentMonth?today.getDate():days;
  let rows='';
  for(let d=1;d<=maxDay;d++){
    const ds=`${year}-${String(mn).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
    const wd=getWeekday(ds),rec=empAtt[ds],ci=rec?.CheckIn||'',co=rec?.CheckOut||'',excReason=excMap[ds];
    let cls='',badge='';
    if(wd===6){
      if(excReason){cls='row-exception';badge=`<span class="badge badge-blue">${t('exception_lbl')}: ${esc(excReason)} (Saturday)</span>`}
      else{cls='row-sat';badge=`<span class="badge badge-orange">${t('saturday')}</span>`}
    }
    else if(wd===0){cls='row-sun';badge=`<span class="badge badge-gray">${t('sunday')}</span>`}
    else if(excReason){cls='row-exception';badge=`<span class="badge badge-blue">${t('exception_lbl')}: ${esc(excReason)}</span>`}
    else if(ci){cls='row-present';badge=`<span class="badge badge-green">${t('present')}</span>`}
    else{cls='row-absent';badge=`<span class="badge badge-red">${t('absent')}</span>`}
    rows+=`<tr class="${cls}" onclick="fillAttEditor('${ds}','${ci}','${co}')"><td>${dateLabel(ds)}</td><td>${ci||'—'}</td><td>${co||'—'}</td><td>${badge}</td></tr>`;
  }
  document.getElementById('att-table-area').innerHTML=`<div class="card"><div class="card-header"><h3>${esc(emp.Name)} — ${month} ${year}${isCurrentMonth?' <span style="font-size:11px;font-weight:400;color:var(--text-muted)">(up to today)</span>':''}</h3><div class="flex gap-2"><span class="badge badge-green">■ ${t('present')}</span><span class="badge badge-red">■ ${t('absent')}</span><span class="badge badge-orange">■ ${t('saturday')}</span><span class="badge badge-blue">■ ${t('exception_lbl')}</span></div></div><div class="table-wrap"><table><thead><tr><th>${t('date')}</th><th>${t('check_in')}</th><th>${t('check_out')}</th><th>${t('status')}</th></tr></thead><tbody>${rows}</tbody></table></div></div>`;
  const defaultDate=isCurrentMonth?todayStr:`${year}-${String(mn).padStart(2,'0')}-${String(days).padStart(2,'0')}`;
  document.getElementById('att-editor-area').innerHTML=`<div class="card"><h3 class="card-title" style="margin-bottom:13px">Edit Record</h3><div class="form-row"><div class="form-group narrow"><label>${t('date')} (YYYY-MM-DD)</label><input id="att-date" value="${defaultDate}"></div><div class="form-group narrow"><label>${t('check_in')} (HH:MM)</label><input id="att-in"></div><div class="form-group narrow"><label>${t('check_out')} (HH:MM)</label><input id="att-out"></div></div><div class="btn-group"><button class="btn btn-success btn-sm" onclick="saveAttRow()">✅ ${t('save')}</button><button class="btn btn-danger btn-sm" onclick="deleteAttRow()">🗑️ ${t('delete')}</button><button class="btn btn-ghost btn-sm" onclick="clearAttEditor()">✕</button><button class="btn btn-blue btn-sm" style="background:var(--blue);color:#fff" onclick="openExcFromAttEditor()">📋 Add Exception</button></div></div>`;
}
function fillAttEditor(ds,ci,co){document.getElementById('att-date').value=ds;document.getElementById('att-in').value=ci;document.getElementById('att-out').value=co;}
function clearAttEditor(){const today=new Date().toISOString().split('T')[0];document.getElementById('att-date').value=today;document.getElementById('att-in').value='';document.getElementById('att-out').value='';}
function openExcFromAttEditor(){const ds=document.getElementById('att-date').value||new Date().toISOString().split('T')[0];addExcFromRemark(attState.empId,db.getEmployees().find(e=>e.ID===attState.empId)?.Name||'',ds);}
function saveAttRow(){
  const ds=document.getElementById('att-date').value.trim(),ci=document.getElementById('att-in').value.trim(),co=document.getElementById('att-out').value.trim();
  if(!ds||!/^\d{4}-\d{2}-\d{2}$/.test(ds)){toast('Date must be YYYY-MM-DD','error');return;}
  if(ci&&!/^\d{2}:\d{2}$/.test(ci)){toast('Check-in must be HH:MM','error');return;}
  if(co&&!/^\d{2}:\d{2}$/.test(co)){toast('Check-out must be HH:MM','error');return;}
  const all=db.getAttendance();if(!all[attState.empId])all[attState.empId]={};
  all[attState.empId][ds]={CheckIn:ci,CheckOut:co};db.setAttendance(all);loadAttendanceView();toast(t('record_saved'));
}
function deleteAttRow(){
  const ds=document.getElementById('att-date').value.trim();if(!ds){toast(t('select_emp'),'error');return;}
  const all=db.getAttendance();if(all[attState.empId]&&all[attState.empId][ds])delete all[attState.empId][ds];
  db.setAttendance(all);loadAttendanceView();toast(t('record_deleted'));
}
function importAttCsv(){
  const inp=document.createElement('input');inp.type='file';inp.accept='.csv,.txt';
  inp.onchange=e=>{const file=e.target.files[0];if(!file)return;const r=new FileReader();r.onload=ev=>parseZKBioCsv(ev.target.result);r.readAsText(file);};inp.click();
}
function parseZKBioCsv(text){
  const lines=text.split(/\r?\n/).filter(l=>l.trim());if(!lines.length){toast('Empty file','error');return;}
  const emps=db.getEmployees(),empById=Object.fromEntries(emps.map(e=>[e.ID,e])),empByName=Object.fromEntries(emps.map(e=>[e.Name.toLowerCase().trim(),e]));
  const all=db.getAttendance();let startLine=0;
  const h=lines[0].toLowerCase();if(h.includes('id')||h.includes('name')||h.includes('time')||h.includes('date'))startLine=1;
  const raw={};let imported=0;
  for(let i=startLine;i<lines.length;i++){
    const cols=lines[i].split(/[,\t]/);if(cols.length<2)continue;
    let empRef=cols[0].trim(),dtStr='';
    for(let c=1;c<cols.length;c++){const v=cols[c].trim();if(/\d{4}[-\/]\d{2}[-\/]\d{2}/.test(v)||/\d{2}[-\/]\d{2}[-\/]\d{4}/.test(v)){dtStr=v;break;}}
    if(!dtStr||!empRef)continue;
    let emp=empById[empRef]||empByName[empRef.toLowerCase()];if(!emp)continue;
    let d='',t2='';
    const m1=dtStr.match(/(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2})/),m2=dtStr.match(/(\d{2}\/\d{2}\/\d{4})\s+(\d{2}:\d{2})/),m3=dtStr.match(/(\d{4}-\d{2}-\d{2})/);
    if(m1){d=m1[1];t2=m1[2]}else if(m2){const p=m2[1].split('/');d=`${p[2]}-${p[1]}-${p[0]}`;t2=m2[2]}else if(m3){d=m3[1]}
    if(!d)continue;if(!raw[emp.ID])raw[emp.ID]={};if(!raw[emp.ID][d])raw[emp.ID][d]=[];if(t2)raw[emp.ID][d].push(t2);imported++;
  }
  for(const empId in raw){
    if(!all[empId])all[empId]={};
    const empRec=db.getEmployees().find(e=>e.ID===empId),shift=empRec?.Shift||'default',midMins=shift==='late_shift'?870:810;
    for(const d in raw[empId]){
      const times=raw[empId][d].sort(),inT=[],outT=[];
      for(const tt of times){const m=timeToMins(tt);if(m<360)continue;if(m===0){outT.push(tt);continue;}if(m<=midMins)inT.push(tt);else outT.push(tt);}
      all[empId][d]={CheckIn:inT.length?inT[0]:'',CheckOut:outT.length?outT[outT.length-1]:''};
    }
  }
  db.setAttendance(all);toast(`Imported ${imported} punch records`);if(attState.empId)loadAttendanceView();
}
// ===================== EXCEPTIONS =====================
function showExceptions(){document.getElementById('topbar-actions').innerHTML=`<button class="btn btn-primary btn-sm" onclick="openExcModal()">${t('add_exception')}</button>`;renderExcTable();}
function renderExcTable(){
  const excs=db.getExceptions();
  document.getElementById('content').innerHTML=`<div class="card"><div class="card-header"><h3>${t('exceptions')} (${excs.length})</h3><div class="btn-group"><button class="btn btn-primary btn-sm" onclick="openExcModal()">➕ ${t('add_exception')}</button><button class="btn btn-secondary btn-sm" onclick="openExcAllModal()">📋 ${t('add_for_all')}</button></div></div>
    ${excs.length===0?`<div class="empty-state"><div class="icon">📋</div><p>${t('no_exceptions')}</p></div>`:
    `<div class="table-wrap"><table><thead><tr><th>${t('name')}</th><th>${t('employee_id')}</th><th>${t('date')}</th><th>${t('reason')}</th><th>${t('actions')}</th></tr></thead>
    <tbody>${excs.map((x,i)=>`<tr><td>${esc(x.EmployeeName)}</td><td>${esc(x.EmployeeID)}</td><td>${esc(x.Date)}</td><td><span class="badge badge-blue">${esc(x.Reason)}</span></td><td><button class="btn btn-ghost btn-sm" onclick="openExcModal(${i})">✏️</button><button class="btn btn-ghost btn-sm" onclick="deleteExc(${i})">🗑️</button></td></tr>`).join('')}</tbody></table></div>`}
    </div>`;
}
function openExcModal(idx=null){
  const excs=db.getExceptions(),x=idx!==null?excs[idx]:null;
  openModal(x?t('exceptions'):t('add_exception'),`
    <div class="form-row"><div class="form-group"><label>${t('employee')}</label><select id="ex-emp"><option value="">--</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}" ${x&&x.EmployeeID===e.ID?'selected':''}>${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('date')}</label><input id="ex-date" type="date" value="${x?.Date||''}"></div></div>
    <div class="form-group"><label>${t('reason')}</label><select id="ex-reason">${excReasons().map(r=>`<option ${r===x?.Reason?'selected':''}>${r}</option>`).join('')}</select></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-primary" onclick="saveExc(${idx!==null?idx:'null'})">${t('save')}</button>`);
}
function saveExc(idx){
  const empId=document.getElementById('ex-emp').value,date=document.getElementById('ex-date').value,reason=document.getElementById('ex-reason').value;
  if(!empId||!date||!reason){toast(t('fill_fields'),'error');return;}
  if(isSelf(empId)){blockSelf();return;}
  const emp=db.getEmployees().find(e=>e.ID===empId);
  const rec={EmployeeName:emp.Name,EmployeeID:empId,Date:date,Reason:reason};
  const excs=db.getExceptions();if(idx!==null)excs[idx]=rec;else excs.push(rec);
  db.setExceptions(excs);closeModal();renderExcTable();
  auditLog(idx!==null?'Exception Updated':'Exception Added',`${emp.Name} — ${date} — ${reason}`);
  toast(t('exception_saved'));
  openModal(t('add_for_all'),`<div class="alert alert-warn">${t('excl_all_warn')}</div><div class="form-row"><div class="form-group narrow"><label>${t('date')}</label><input id="ex-all-date" type="date"></div><div class="form-group"><label>${t('reason')}</label><select id="ex-all-reason">${excReasons().map(r=>`<option>${r}</option>`).join('')}</select></div></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-primary" onclick="saveExcAll()">${t('save')}</button>`);
}
function saveExcAll(){
  const date=document.getElementById('ex-all-date').value,reason=document.getElementById('ex-all-reason').value;
  if(!date||!reason){toast(t('fill_fields'),'error');return;}
  const emps=db.getEmployees();if(!emps.length){toast(t('emp_not_found'),'error');return;}
  const excs=db.getExceptions();emps.forEach(e=>excs.push({EmployeeName:e.Name,EmployeeID:e.ID,Date:date,Reason:reason}));
  db.setExceptions(excs);closeModal();renderExcTable();
  auditLog('Exception Added for All',`${date} — ${reason} — ${emps.length} employees`);
  toast(t('exception_saved'));
}
function deleteExc(idx){
  if(!confirm(t('delete')+'?'))return;
  const excs=db.getExceptions();
  const x=excs[idx];
  if(x&&isSelf(x.EmployeeID)){blockSelf();return;}
  excs.splice(idx,1);db.setExceptions(excs);renderExcTable();
  auditLog('Exception Deleted',`${x?.EmployeeName||'?'} — ${x?.Date||'?'} — ${x?.Reason||'?'}`);
  toast(t('record_deleted'));
}
// ===================== ADVANCES =====================
function showAdvances(){
  document.getElementById('topbar-actions').innerHTML=`<button class="btn btn-primary btn-sm" onclick="openAdvModal()">${t('add_advance')}</button>`;
  document.getElementById('content').innerHTML=`<div class="filter-bar"><div class="form-group"><label>${t('employee')}</label><select id="adv-filter-emp"><option value="">${t('all_employees')}</option>${db.getEmployees().map(e=>`<option>${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('month')}</label><select id="adv-filter-month">${monthOptions(currentMonth())}</select></div><div class="form-group narrow"><label>${t('year')}</label><select id="adv-filter-year">${yearOptions(currentYear())}</select></div><button class="btn btn-primary" onclick="renderAdvTable()">${t('load')}</button></div><div id="adv-table-area"></div>`;
  renderAdvTable();
}
function renderAdvTable(){
  const month=document.getElementById('adv-filter-month')?.value||currentMonth(),year=parseInt(document.getElementById('adv-filter-year')?.value||currentYear()),empF=document.getElementById('adv-filter-emp')?.value||'',mn=getMonthNum(month);
  const advances=db.getAdvances().filter(a=>{try{const d=new Date(a.Date);if(d.getMonth()+1!==mn||d.getFullYear()!==year)return false;}catch{return false;}if(empF&&a.EmployeeName!==empF)return false;return true;});
  const total=advances.reduce((s,a)=>s+parseFloat(a.Amount||0),0);
  document.getElementById('adv-table-area').innerHTML=`<div class="card"><div class="card-header"><h3>${month} ${year}</h3><span class="badge badge-orange">${t('total')}: AED ${total.toFixed(2)}</span></div>
    ${advances.length===0?`<div class="empty-state"><div class="icon">💰</div><p>${t('no_advances')}</p></div>`:
    `<div class="table-wrap"><table><thead><tr><th>#</th><th>${t('date')}</th><th>${t('employee')}</th><th>${t('employee_id')}</th><th>${t('amount')}</th><th>${t('reason')}</th><th>${t('notes')}</th><th>${t('actions')}</th></tr></thead>
    <tbody>${advances.map(a=>`<tr><td>${esc(a.AdvanceID)}</td><td>${esc(a.Date)}</td><td><b>${esc(a.EmployeeName)}</b></td><td>${esc(a.EmployeeID)}</td><td style="font-weight:700;color:var(--orange)">${parseFloat(a.Amount||0).toFixed(2)}</td><td><span class="badge badge-orange">${esc(a.Reason)}</span></td><td class="text-muted text-sm">${esc(a.Notes)}</td><td><button class="btn btn-ghost btn-sm" onclick="openAdvModal('${esc(a.AdvanceID)}')">✏️</button><button class="btn btn-ghost btn-sm" onclick="deleteAdv('${esc(a.AdvanceID)}')">🗑️</button></td></tr>`).join('')}</tbody></table></div>`}
    </div>`;
}
function openAdvModal(advId=null){
  const advances=db.getAdvances(),a=advId?advances.find(x=>x.AdvanceID===advId):null;
  openModal(a?t('advances'):t('add_advance'),`
    <div class="form-row"><div class="form-group"><label>${t('employee')}</label><select id="adv-emp"><option value="">--</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}" ${a&&a.EmployeeID===e.ID?'selected':''}>${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('date')}</label><input id="adv-date" type="date" value="${a?.Date||''}"></div></div>
    <div class="form-row"><div class="form-group narrow"><label>${t('amount')}</label><input id="adv-amount" type="number" step="0.01" value="${a?.Amount||''}"></div><div class="form-group"><label>${t('reason')}</label><select id="adv-reason">${['Emergency','Personal','Medical','Travel','Other'].map(r=>`<option ${r===a?.Reason?'selected':''}>${r}</option>`).join('')}</select></div></div>
    <div class="form-group"><label>${t('notes')}</label><input id="adv-notes" value="${esc(a?.Notes||'')}"></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-primary" onclick="saveAdv('${advId||''}')">${t('save')}</button>`);
}
function saveAdv(advId){
  const empId=document.getElementById('adv-emp').value,date=document.getElementById('adv-date').value,amount=parseFloat(document.getElementById('adv-amount').value),reason=document.getElementById('adv-reason').value,notes=document.getElementById('adv-notes').value.trim();
  if(!empId||!date||!amount||amount<=0){toast(t('fill_fields'),'error');return;}
  if(isSelf(empId)){blockSelf();return;}
  const emp=db.getEmployees().find(e=>e.ID===empId),advances=db.getAdvances();
  const rec={AdvanceID:advId||nextId(advances,'AdvanceID'),EmployeeID:empId,EmployeeName:emp.Name,Date:date,Amount:amount.toFixed(2),Reason:reason,Notes:notes};
  if(advId){const i=advances.findIndex(x=>x.AdvanceID===advId);if(i>=0)advances[i]=rec;}else advances.push(rec);
  db.setAdvances(advances);closeModal();renderAdvTable();toast(t('advance_saved'));
}
function deleteAdv(advId){
  if(!confirm(t('delete')+'?'))return;
  const a=db.getAdvances().find(x=>x.AdvanceID===advId);
  if(a&&isSelf(a.EmployeeID)){blockSelf();return;}
  db.setAdvances(db.getAdvances().filter(a=>a.AdvanceID!==advId));renderAdvTable();toast(t('record_deleted'));
}
// ===================== COMMISSIONS =====================
function basePct(source){const s=(source||'').toLowerCase();if(s==='lead')return 0.05;if(s==='outside'||s==='renewal')return 0.10;return 0;}
function showCommissions(){
  document.getElementById('topbar-actions').innerHTML=`<button class="btn btn-primary btn-sm" onclick="openDealModal()">${t('add_deal')}</button>`;
  document.getElementById('content').innerHTML=`<div class="filter-bar"><div class="form-group narrow"><label>${t('month')}</label><select id="comm-month">${monthOptions(currentMonth())}</select></div><div class="form-group narrow"><label>${t('year')}</label><select id="comm-year">${yearOptions(currentYear())}</select></div><button class="btn btn-primary" onclick="renderDealsTable()">${t('load')}</button></div><div id="deals-table-area"></div>`;
  renderDealsTable();
}
function renderDealsTable(){
  const month=document.getElementById('comm-month')?.value||currentMonth(),year=parseInt(document.getElementById('comm-year')?.value||currentYear()),mn=getMonthNum(month);
  const deals=db.getDeals().filter(d=>{try{const dt=new Date(d.Date);return dt.getMonth()+1===mn&&dt.getFullYear()===year;}catch{return false;}});
  const splits=db.getSplits(),splitTotals={};splits.forEach(s=>{splitTotals[s.DealID]=(splitTotals[s.DealID]||0)+parseFloat(s.SharePercent||0)});
  const totalComm=deals.reduce((s,d)=>s+parseFloat(d.Amount||0)*basePct(d.Source),0);
  document.getElementById('deals-table-area').innerHTML=`<div class="card"><div class="card-header"><h3>${month} ${year}</h3><span class="badge badge-green">${t('total')}: AED ${totalComm.toFixed(2)}</span></div>
    ${deals.length===0?`<div class="empty-state"><div class="icon">🤝</div><p>${t('no_deals')}</p></div>`:
    `<div class="table-wrap"><table><thead><tr><th>${t('deal_id')}</th><th>${t('date')}</th><th>${t('client')}</th><th>${t('amount')}</th><th>${t('source')}</th><th>${t('base_pct')}</th><th>${t('commission')}</th><th>${t('primary_emp')}</th><th>${t('split_pct')}</th><th>${t('actions')}</th></tr></thead>
    <tbody>${deals.map(d=>{const pct=basePct(d.Source),comm=parseFloat(d.Amount||0)*pct,empName=db.getEmployees().find(e=>e.ID===d.PrimaryEmpID)?.Name||d.PrimaryEmpID;
    return`<tr><td>${esc(d.DealID)}</td><td>${esc(d.Date)}</td><td><b>${esc(d.Client)}</b></td><td>${parseFloat(d.Amount||0).toLocaleString()}</td><td><span class="badge ${d.Source==='lead'?'badge-orange':'badge-green'}">${esc(d.Source)}</span></td><td>${(pct*100).toFixed(0)}%</td><td style="font-weight:700">${comm.toFixed(2)}</td><td>${esc(empName)}</td><td>${(splitTotals[d.DealID]||0).toFixed(0)}%</td><td><button class="btn btn-ghost btn-sm" onclick="openDealModal('${esc(d.DealID)}')">✏️</button><button class="btn btn-ghost btn-sm" onclick="deleteDeal('${esc(d.DealID)}')">🗑️</button></td></tr>`;
    }).join('')}</tbody></table></div>`}</div>`;
}
function openDealModal(dealId=null){
  const deals=db.getDeals(),d=dealId?deals.find(x=>x.DealID===dealId):null,existingSplits=dealId?db.getSplits().filter(s=>s.DealID===dealId):[];
  openModal(d?`${t('commissions')} #${dealId}`:t('add_deal'),`
    <div class="form-row"><div class="form-group wide"><label>${t('client')}</label><input id="d-client" value="${esc(d?.Client||'')}"></div><div class="form-group narrow"><label>${t('date')}</label><input id="d-date" type="date" value="${d?.Date||''}"></div></div>
    <div class="form-row"><div class="form-group narrow"><label>${t('amount')}</label><input id="d-amount" type="number" step="0.01" value="${d?.Amount||''}"></div><div class="form-group narrow"><label>${t('source')}</label><select id="d-source"><option ${d?.Source==='lead'?'selected':''}>lead</option><option ${d?.Source==='outside'?'selected':''}>outside</option><option ${d?.Source==='renewal'?'selected':''}>renewal</option></select></div><div class="form-group"><label>${t('primary_emp')}</label><select id="d-primary"><option value="">--</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}" ${d&&d.PrimaryEmpID===e.ID?'selected':''}>${esc(e.Name)}</option>`).join('')}</select></div></div>
    <div class="form-group"><label>${t('notes')}</label><input id="d-notes" value="${esc(d?.Notes||'')}"></div>
    <div class="splits-section"><h4>${t('splits_title')}</h4><div class="form-row" style="margin-bottom:8px"><div class="form-group"><select id="sp-emp"><option value="">-- ${t('employee')} --</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}">${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><input id="sp-pct" type="number" placeholder="%" min="1" max="100"></div><button class="btn btn-secondary btn-sm" onclick="addSplitRow()" style="margin-bottom:0">${t('add_split')}</button></div>
    <div id="split-rows-list">${existingSplits.map((s,i)=>{const en=db.getEmployees().find(e=>e.ID===s.EmployeeID)?.Name||s.EmployeeID;return`<div class="flex items-center gap-2 mt-2" id="spr-${i}"><span style="flex:1">${esc(en)}</span><span class="badge badge-purple">${s.SharePercent}%</span><button class="btn btn-ghost btn-sm" onclick="this.closest('[id^=spr]').remove();updateSplitTotal()">×</button><input type="hidden" class="sp-emp-id" value="${esc(s.EmployeeID)}"><input type="hidden" class="sp-pct-val" value="${s.SharePercent}"></div>`;}).join('')}</div>
    <div id="split-total-label" class="text-muted text-sm mt-2"></div></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-primary" onclick="saveDeal('${dealId||''}')">${t('save')}</button>`);
  updateSplitTotal();
}
function addSplitRow(){
  const empId=document.getElementById('sp-emp').value,pct=parseFloat(document.getElementById('sp-pct').value);
  if(!empId||!pct||pct<=0){toast(t('fill_fields'),'error');return;}
  const emp=db.getEmployees().find(e=>e.ID===empId),list=document.getElementById('split-rows-list'),i=Date.now();
  const div=document.createElement('div');div.className='flex items-center gap-2 mt-2';div.id=`spr-${i}`;
  div.innerHTML=`<span style="flex:1">${esc(emp?.Name||empId)}</span><span class="badge badge-purple">${pct}%</span><button class="btn btn-ghost btn-sm" onclick="this.closest('[id^=spr]').remove();updateSplitTotal()">×</button><input type="hidden" class="sp-emp-id" value="${esc(empId)}"><input type="hidden" class="sp-pct-val" value="${pct}">`;
  list.appendChild(div);document.getElementById('sp-pct').value='';updateSplitTotal();
}
function updateSplitTotal(){let t2=0;document.querySelectorAll('.sp-pct-val').forEach(i=>t2+=parseFloat(i.value||0));const lbl=document.getElementById('split-total-label');if(lbl)lbl.textContent=`${t('split_total')}: ${t2.toFixed(0)}%${t2>100?' ⚠️':''}`;}
function saveDeal(dealId){
  const client=document.getElementById('d-client').value.trim(),date=document.getElementById('d-date').value,amount=parseFloat(document.getElementById('d-amount').value),source=document.getElementById('d-source').value,primary=document.getElementById('d-primary').value,notes=document.getElementById('d-notes').value.trim();
  if(!client||!date||!amount){toast(t('fill_fields'),'error');return;}
  const deals=db.getDeals(),id=dealId||nextId(deals,'DealID');
  const rec={DealID:id,Client:client,Amount:amount.toFixed(2),Source:source,Date:date,PrimaryEmpID:primary,Notes:notes};
  if(dealId){const i=deals.findIndex(d=>d.DealID===dealId);if(i>=0)deals[i]=rec;}else deals.push(rec);
  db.setDeals(deals);
  const splits=db.getSplits().filter(s=>s.DealID!==id);
  document.querySelectorAll('#split-rows-list [id^=spr]').forEach(row=>{const eId=row.querySelector('.sp-emp-id')?.value,pct=row.querySelector('.sp-pct-val')?.value;if(eId&&pct)splits.push({DealID:id,EmployeeID:eId,SharePercent:pct});});
  db.setSplits(splits);closeModal();renderDealsTable();toast(t('deal_saved'));
}
function deleteDeal(dealId){if(!confirm(t('delete')+'?'))return;db.setDeals(db.getDeals().filter(d=>d.DealID!==dealId));db.setSplits(db.getSplits().filter(s=>s.DealID!==dealId));renderDealsTable();toast(t('record_deleted'));}
// ===================== REIMBURSEMENTS =====================
// Pull fresh from server every time this view opens so employee submissions appear instantly
async function showReimbursements(){
  document.getElementById('topbar-actions').innerHTML=`<button class="btn btn-teal btn-sm" onclick="openReimbModal()">${t('add_reimb')}</button>`;
  // Silently refresh reimbs from server before rendering
  try{
    const txt=await fetch(`${PMS_API}?key=${KEYS.reimbs}`,{headers:{'X-PMS-Token':PMS_TOKEN},signal:AbortSignal.timeout(8000)}).then(r=>r.text());
    if(txt&&txt!=='null'){try{JSON.parse(txt);localStorage.setItem(KEYS.reimbs,txt);}catch{}}
  }catch(e){}
  document.getElementById('content').innerHTML=`
    <div class="alert alert-teal">${t('approved_only_hint')} &nbsp;|&nbsp; 🔄 Employee-submitted requests appear here as <b>Pending</b> — approve or reject them below.</div>
    <div class="filter-bar">
      <div class="form-group"><label>${t('employee')}</label><select id="reimb-filter-emp"><option value="">${t('all_employees')}</option>${db.getEmployees().map(e=>`<option>${esc(e.Name)}</option>`).join('')}</select></div>
      <div class="form-group narrow"><label>${t('category')}</label><select id="reimb-filter-cat"><option value="">${t('all_employees')}</option>${getReimbCats().map(c=>`<option value="${c.key}">${c.label}</option>`).join('')}</select></div>
      <div class="form-group narrow"><label>${t('reimb_status')}</label><select id="reimb-filter-status"><option value="">${t('all_employees')}</option><option value="pending">${t('pending')}</option><option value="approved">${t('approved')}</option><option value="rejected">${t('rejected')}</option></select></div>
      <div class="form-group narrow"><label>${t('month')}</label><select id="reimb-filter-month">${monthOptions(currentMonth())}</select></div>
      <div class="form-group narrow"><label>${t('year')}</label><select id="reimb-filter-year">${yearOptions(currentYear())}</select></div>
      <button class="btn btn-teal" onclick="renderReimbTable()">${t('load')}</button>
    </div>
    <div id="reimb-table-area"></div>`;
  renderReimbTable();
}
function renderReimbTable(){
  const month=document.getElementById('reimb-filter-month')?.value||currentMonth(),year=parseInt(document.getElementById('reimb-filter-year')?.value||currentYear()),empF=document.getElementById('reimb-filter-emp')?.value||'',catF=document.getElementById('reimb-filter-cat')?.value||'',statusF=document.getElementById('reimb-filter-status')?.value||'',mn=getMonthNum(month);
  let reimbs=db.getReimbs().filter(r=>{
    try{const d=new Date(r.Date);if(d.getMonth()+1!==mn||d.getFullYear()!==year)return false;}catch{return false;}
    if(empF&&r.EmployeeName!==empF)return false;if(catF&&r.Category!==catF)return false;if(statusF&&r.Status!==statusF)return false;return true;
  });
  const totalApproved=reimbs.filter(r=>r.Status==='approved').reduce((s,r)=>s+parseFloat(r.Amount||0),0);
  const totalPending=reimbs.filter(r=>r.Status==='pending').reduce((s,r)=>s+parseFloat(r.Amount||0),0);
  const catLabels=Object.fromEntries(getReimbCats().map(c=>[c.key,c.label]));
  // Helper: render receipt cell as link when it's a URL
  const receiptCell=r=>{
    const rec=r.Receipt||'';
    if(/^https?:\/\//.test(rec))return`<a href="${esc(rec)}" target="_blank" rel="noopener" style="color:var(--accent);font-weight:600;text-decoration:none">📎 View</a>`;
    return`<span class="text-muted text-sm">${esc(rec||'—')}</span>`;
  };
  // Tag employee-submitted ones
  const sourceTag=r=>(r.Notes&&r.Notes.includes('Submitted by employee'))?`<span class="badge" style="background:#e0e7ff;color:var(--accent);font-size:10px;margin-left:4px">👤 ${t('reimb_from_emp')}</span>`:'';
  document.getElementById('reimb-table-area').innerHTML=`
    <div class="cards-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:16px">
      <div class="stat-card c-teal"><div class="label">${t('approved')}</div><div class="value">${reimbs.filter(r=>r.Status==='approved').length}</div><div class="sub">AED ${totalApproved.toFixed(2)}</div></div>
      <div class="stat-card" style="${reimbs.filter(r=>r.Status==='pending').length>0?'background:var(--orange)':''}"><div class="label" style="${reimbs.filter(r=>r.Status==='pending').length>0?'color:#fff':''}">⏳ ${t('pending')}</div><div class="value" style="${reimbs.filter(r=>r.Status==='pending').length>0?'color:#fff':''}">${reimbs.filter(r=>r.Status==='pending').length}</div><div class="sub" style="${reimbs.filter(r=>r.Status==='pending').length>0?'color:#fff':''}">AED ${totalPending.toFixed(2)}</div></div>
      <div class="stat-card"><div class="label">${t('rejected')}</div><div class="value">${reimbs.filter(r=>r.Status==='rejected').length}</div><div class="sub">&nbsp;</div></div>
    </div>
    <div class="card">
      <div class="card-header"><h3>${t('reimbursements')} — ${month} ${year}</h3><button class="btn btn-teal btn-sm" onclick="openReimbModal()">${t('add_reimb')}</button></div>
      ${reimbs.length===0?`<div class="empty-state"><div class="icon">🧾</div><p>${t('no_reimbs')}</p></div>`:
      `<div class="table-wrap"><table><thead><tr><th>${t('reimb_id')}</th><th>${t('date')}</th><th>${t('employee')}</th><th>${t('category')}</th><th>${t('description')}</th><th>${t('amount')}</th><th>${t('receipt')}</th><th>${t('reimb_status')}</th><th>💬 Admin Note</th><th>${t('actions')}</th></tr></thead>
      <tbody>${reimbs.map(r=>`<tr class="${r.Status==='approved'?'row-reimb':r.Status==='rejected'?'row-absent':''}">
        <td>${esc(r.ReimbID)}</td><td>${esc(r.Date)}</td>
        <td><b>${esc(r.EmployeeName)}</b>${sourceTag(r)}</td>
        <td><span class="badge badge-teal">${catLabels[r.Category]||r.Category}</span></td>
        <td class="text-sm">${esc(r.Description||'—')}</td>
        <td style="font-weight:700;color:var(--teal)">${parseFloat(r.Amount||0).toFixed(2)}</td>
        <td>${receiptCell(r)}</td>
        <td><span class="badge reimb-${r.Status}">${t(r.Status)}</span></td>
        <td>${r.AdminNote?`<span style="color:#92400e;font-size:12px" title="${esc(r.AdminNote)}">💬 ${esc(r.AdminNote.length>30?r.AdminNote.slice(0,30)+'…':r.AdminNote)}</span>`:'<span style="color:var(--border)">—</span>'}</td>
        <td>
          <button class="btn btn-ghost btn-sm" onclick="openReimbModal('${esc(r.ReimbID)}')">✏️</button>
          <button class="btn btn-ghost btn-sm" onclick="quickApproveReimb('${esc(r.ReimbID)}','approved')" title="${t('approved')}" style="color:var(--teal)">✅</button>
          <button class="btn btn-ghost btn-sm" onclick="quickApproveReimb('${esc(r.ReimbID)}','rejected')" title="${t('rejected')}" style="color:var(--red)">❌</button>
          <button class="btn btn-ghost btn-sm" onclick="deleteReimb('${esc(r.ReimbID)}')">🗑️</button>
        </td>
      </tr>`).join('')}</tbody></table></div>`}
    </div>`;
}
function quickApproveReimb(id,status){
  const reimbs=db.getReimbs(),i=reimbs.findIndex(r=>r.ReimbID===id);
  if(i>=0){reimbs[i].Status=status;db.setReimbs(reimbs);renderReimbTable();toast(t(status),'info');}
}
function openReimbModal(reimbId=null){
  const reimbs=db.getReimbs(),r=reimbId?reimbs.find(x=>x.ReimbID===reimbId):null,cats=getReimbCats();
  const receiptPreview=r?.Receipt&&/^https?:\/\//.test(r.Receipt)?`<div style="margin-top:6px"><a href="${esc(r.Receipt)}" target="_blank" rel="noopener" style="color:var(--accent);font-size:12px">📎 View uploaded receipt</a></div>`:'';
  openModal(r?t('reimbursements'):t('add_reimb'),`
    <div class="form-row"><div class="form-group"><label>${t('employee')}</label><select id="r-emp"><option value="">--</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}" ${r&&r.EmployeeID===e.ID?'selected':''}>${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('date')}</label><input id="r-date" type="date" value="${r?.Date||''}"></div></div>
    <div class="form-row"><div class="form-group"><label>${t('category')}</label><select id="r-cat">${cats.map(c=>`<option value="${c.key}" ${r&&r.Category===c.key?'selected':''}>${c.label}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('amount')}</label><input id="r-amount" type="number" step="0.01" value="${r?.Amount||''}"></div></div>
    <div class="form-group" style="margin-bottom:12px"><label>${t('description')}</label><input id="r-desc" value="${esc(r?.Description||'')}" placeholder="${t('description')}..."></div>
    <div class="form-row"><div class="form-group"><label>${t('receipt')}</label><input id="r-receipt" value="${esc(r?.Receipt||'')}" placeholder="Receipt #, URL, or reference">${receiptPreview}</div><div class="form-group narrow"><label>${t('reimb_status')}</label><select id="r-status"><option value="pending" ${!r||r.Status==='pending'?'selected':''}>${t('pending')}</option><option value="approved" ${r?.Status==='approved'?'selected':''}>${t('approved')}</option><option value="rejected" ${r?.Status==='rejected'?'selected':''}>${t('rejected')}</option></select></div></div>
    <div class="form-group" style="margin-bottom:8px"><label>${t('notes')}</label><input id="r-notes" value="${esc(r?.Notes||'')}"></div>
    <div class="form-group" style="background:#fef9ec;border:1.5px solid #f59e0b;border-radius:8px;padding:12px">
      <label style="color:#92400e">💬 Admin Note to Employee <span style="font-weight:400;text-transform:none;font-size:11px">(visible to employee on their portal)</span></label>
      <textarea id="r-admin-note" rows="3" style="resize:vertical;margin-top:4px" placeholder="e.g. Please upload a receipt to get this approved. We need the original invoice to proceed.">${esc(r?.AdminNote||'')}</textarea>
    </div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-teal" onclick="saveReimb('${reimbId||''}')">${t('save')}</button>`);
}
function saveReimb(reimbId){
  const empId=document.getElementById('r-emp').value,date=document.getElementById('r-date').value,cat=document.getElementById('r-cat').value,amount=parseFloat(document.getElementById('r-amount').value),desc=document.getElementById('r-desc').value.trim(),receipt=document.getElementById('r-receipt').value.trim(),status=document.getElementById('r-status').value,notes=document.getElementById('r-notes').value.trim(),adminNote=document.getElementById('r-admin-note').value.trim();
  if(!empId||!date||!amount||amount<=0){toast(t('fill_fields'),'error');return;}
  if(isSelf(empId)){blockSelf();return;}
  const emp=db.getEmployees().find(e=>e.ID===empId),reimbs=db.getReimbs();
  const rec={ReimbID:reimbId||nextId(reimbs,'ReimbID'),EmployeeID:empId,EmployeeName:emp.Name,Date:date,Category:cat,Amount:amount.toFixed(2),Description:desc,Receipt:receipt,Status:status,Notes:notes,AdminNote:adminNote};
  if(reimbId){const i=reimbs.findIndex(x=>x.ReimbID===reimbId);if(i>=0){const old=reimbs[i];reimbs[i]=rec;auditLog('Reimbursement Updated',`${rec.EmployeeName} — ${rec.Category} AED ${rec.Amount} → Status: ${rec.Status}${old.Status!==rec.Status?` (was ${old.Status})`:''}`);}}
  else{reimbs.push(rec);auditLog('Reimbursement Added',`${rec.EmployeeName} — ${rec.Category} AED ${rec.Amount} — ${rec.Status}`);}
  db.setReimbs(reimbs);closeModal();renderReimbTable();toast(t('reimb_saved'));
}
function deleteReimb(id){
  if(!confirm(t('delete')+'?'))return;
  const r=db.getReimbs().find(x=>x.ReimbID===id);
  if(r&&isSelf(r.EmployeeID)){blockSelf();return;}
  db.setReimbs(db.getReimbs().filter(r=>r.ReimbID!==id));renderReimbTable();toast(t('record_deleted'));
}
// ===================== REMARKS =====================
async function loadRemarksCount(){
  try{
    const r=await fetch(`${PMS_API}?action=get_remarks`,{headers:{'X-PMS-Token':PMS_TOKEN}});
    const d=await r.json();const n=d.pending_count||0;
    const badge=document.getElementById('remarks-badge');if(badge){badge.textContent=n;badge.style.display=n>0?'inline':'none';}
  }catch(e){}
}
function showRemarks(){
  document.getElementById('content').innerHTML=`<div class="card"><div style="text-align:center;padding:30px"><div style="font-size:30px;animation:spin 1s linear infinite;display:inline-block">⟳</div><p style="margin-top:10px;color:var(--text-muted)">Loading remarks…</p></div></div>`;
  fetch(`${PMS_API}?action=get_remarks`,{headers:{'X-PMS-Token':PMS_TOKEN}})
    .then(r=>r.json()).then(d=>renderRemarks(d.remarks||[])).catch(()=>{
      document.getElementById('content').innerHTML=`<div class="card"><div class="empty-state"><div class="icon">⚠️</div><p>Could not load remarks.</p></div></div>`;
    });
}
let _allRemarks=[],_selectedEmpRemark=null;
function renderRemarks(remarks){
  _allRemarks=remarks;
  const byEmp={};
  remarks.forEach(r=>{if(!byEmp[r.empId])byEmp[r.empId]={name:r.empName,email:r.empEmail,remarks:[]};byEmp[r.empId].remarks.push(r);});
  const empList=Object.entries(byEmp);
  const pending=remarks.filter(r=>!['approved','refused'].includes(r.status));
  if(!_selectedEmpRemark||!byEmp[_selectedEmpRemark]){
    const firstPending=empList.find(([id,e])=>e.remarks.some(r=>!['approved','refused'].includes(r.status)));
    _selectedEmpRemark=firstPending?firstPending[0]:(empList[0]?.[0]||null);
  }
  document.getElementById('content').innerHTML=`
    ${pending.length>0?`<div class="alert alert-warn" style="font-weight:600;margin-bottom:14px">🔔 ${pending.length} unresolved remark${pending.length===1?'':'s'} — click an employee to review</div>`:''}
    <div style="display:grid;grid-template-columns:260px 1fr;gap:16px;align-items:start">
      <div class="card" style="padding:0;overflow:hidden">
        <div style="padding:12px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
          <span style="font-size:13px;font-weight:700">Employees (${empList.length})</span>
          <select id="rmk-status-filter" onchange="filterRemarksByStatus()" style="font-size:11px;padding:3px 6px;border:1px solid var(--border);border-radius:5px;background:var(--white)"><option value="">All</option><option value="active">Active</option><option value="done">Done</option></select>
        </div>
        <div id="emp-remark-list" style="overflow-y:auto;max-height:600px">
          ${empList.length===0?`<div style="padding:20px;text-align:center;color:var(--text-muted);font-size:13px">No remarks yet</div>`:''}
          ${empList.map(([empId,emp])=>{
            const empPending=emp.remarks.filter(r=>!['approved','refused'].includes(r.status)).length,isSelected=empId===_selectedEmpRemark;
            return`<div data-empid="${empId}" onclick="selectEmpRemark('${empId}')" style="padding:12px 14px;cursor:pointer;border-bottom:1px solid var(--border);background:${isSelected?'rgba(99,102,241,0.08)':'var(--white)'};border-left:3px solid ${isSelected?'var(--accent)':'transparent'};transition:all .15s"><div style="display:flex;align-items:center;justify-content:space-between"><span style="font-weight:${empPending>0?'700':'500'};font-size:13px;color:${isSelected?'var(--accent)':'var(--text)'}">${esc(emp.name)}</span><span class="rmk-badge">${empPending>0?`<span style="background:#ef4444;color:#fff;border-radius:20px;padding:1px 8px;font-size:10px;font-weight:700">${empPending}</span>`:'<span style="color:var(--green);font-size:11px">✓ done</span>'}</span></div><div style="font-size:11px;color:var(--text-muted);margin-top:2px">${emp.remarks.length} remark${emp.remarks.length===1?'':'s'}</div></div>`;
          }).join('')}
        </div>
      </div>
      <div id="emp-remark-detail">
        ${_selectedEmpRemark&&byEmp[_selectedEmpRemark]?renderEmpRemarks(byEmp[_selectedEmpRemark]):`<div class="card"><div class="empty-state"><div class="icon">👈</div><p>Select an employee to view their remarks</p></div></div>`}
      </div>
    </div>`;
  loadRemarksCount();
}
function renderEmpRemarks(emp){
  const STATUSES=[{key:'opened',label:'Opened',color:'#2563eb',bg:'#dbeafe'},{key:'processing',label:'Processing',color:'#7c3aed',bg:'#f5f3ff'},{key:'approved',label:'Approved',color:'#16a34a',bg:'#dcfce7'},{key:'refused',label:'Refused',color:'#dc2626',bg:'#fee2e2'}];
  const cols={opened:[],processing:[],approved:[],refused:[]};
  emp.remarks.forEach(r=>{const key=r.status==='pending'?'opened':(cols[r.status]!==undefined?r.status:'opened');cols[key].push(r);});
  const card=(r,colStatus)=>{
    const isFinal=['approved','refused'].includes(colStatus);
    return`<div style="background:#fff;border-radius:8px;padding:12px;margin-bottom:10px;box-shadow:0 1px 4px rgba(0,0,0,.08);border-left:3px solid ${colStatus==='opened'?'#2563eb':colStatus==='processing'?'#7c3aed':colStatus==='approved'?'#16a34a':'#dc2626'}">
      <div style="font-size:11px;color:var(--text-muted);margin-bottom:5px;display:flex;justify-content:space-between"><span>📅 ${esc(r.date)}</span><span>${esc((r.submittedAt||'').slice(0,10))}</span></div>
      <div style="font-size:13px;line-height:1.5;margin-bottom:8px">${esc(r.remark)}</div>
      ${r.fileUrl?`<div style="margin-bottom:8px"><a href="${esc(r.fileUrl)}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:5px;background:#e0e7ff;color:var(--accent);padding:4px 10px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none">📎 View Attachment</a></div>`:''}
      ${r.adminNote?`<div style="background:#f8fafc;border-radius:5px;padding:6px 8px;font-size:11px;color:var(--text-muted);margin-bottom:8px"><b>Note:</b> ${esc(r.adminNote)}</div>`:''}
      ${!isFinal?`<input id="note_${r.id}" value="${esc(r.adminNote||'')}" placeholder="Add note for employee…" style="width:100%;padding:5px 8px;border:1.5px solid var(--border);border-radius:5px;font-size:12px;font-family:var(--font);margin-bottom:7px">
      <div style="display:flex;gap:4px;flex-wrap:wrap">${colStatus!=='processing'?`<button class="btn btn-sm" style="background:#f5f3ff;color:#7c3aed;font-size:11px" onclick="updateRemark('${r.id}','processing')">⏳ Processing</button>`:''}
      <button class="btn btn-sm" style="background:#dcfce7;color:#16a34a;font-size:11px" onclick="updateRemark('${r.id}','approved')">✅ Approved</button>
      <button class="btn btn-sm" style="background:#fee2e2;color:#dc2626;font-size:11px" onclick="updateRemark('${r.id}','refused')">✕ Refused</button></div>`
      :`<div style="font-size:11px;color:var(--text-muted)">${esc((r.reviewedAt||'').slice(0,10))}</div>`}
    </div>`;
  };
  const col=(status,label,color,bg)=>`<div style="background:${bg};border-radius:10px;padding:12px;min-width:0"><div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px"><span style="font-size:12px;font-weight:700;color:${color};text-transform:uppercase;letter-spacing:.5px">${label}</span><span style="background:${color};color:#fff;border-radius:20px;padding:1px 8px;font-size:10px;font-weight:700">${cols[status].length}</span></div>${cols[status].length===0?`<div style="text-align:center;padding:20px 0;color:${color};opacity:.4;font-size:12px">Empty</div>`:cols[status].map(r=>card(r,status)).join('')}</div>`;
  return`<div class="card" style="overflow:visible"><div class="card-header"><div><h3 style="font-size:15px;font-weight:700">${esc(emp.name)}</h3><div style="font-size:12px;color:var(--text-muted);margin-top:2px">${esc(emp.email)}</div></div><span class="badge badge-gray">${emp.remarks.length} remark${emp.remarks.length===1?'':'s'}</span></div><div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px">${STATUSES.map(s=>col(s.key,s.label,s.color,s.bg)).join('')}</div></div>`;
}
function selectEmpRemark(empId){
  _selectedEmpRemark=empId;
  const pendingIds=_allRemarks.filter(r=>r.empId===empId&&r.status==='pending').map(r=>r.id);
  pendingIds.forEach(id=>{const rm=_allRemarks.find(r=>r.id===id);if(rm)rm.status='opened';fetch(`${PMS_API}?action=update_remark`,{method:'POST',headers:{'X-PMS-Token':PMS_TOKEN,'Content-Type':'application/json'},body:JSON.stringify({id,status:'opened',adminNote:''})}).catch(()=>{});});
  document.querySelectorAll('#emp-remark-list > div').forEach(el=>{const id=el.dataset.empid,isSelected=id===empId;el.style.background=isSelected?'rgba(99,102,241,0.08)':'var(--white)';el.style.borderLeft=`3px solid ${isSelected?'var(--accent)':'transparent'}`;});
  const byEmp={};_allRemarks.forEach(r=>{if(!byEmp[r.empId])byEmp[r.empId]={name:r.empName,email:r.empEmail,remarks:[]};byEmp[r.empId].remarks.push(r);});
  const listItem=document.querySelector(`#emp-remark-list [data-empid="${empId}"]`);
  if(listItem&&byEmp[empId]){const active=byEmp[empId].remarks.filter(r=>!['approved','refused'].includes(r.status)).length;const badgeEl=listItem.querySelector('.rmk-badge');if(badgeEl)badgeEl.innerHTML=active>0?`<span style="background:#ef4444;color:#fff;border-radius:20px;padding:1px 8px;font-size:10px;font-weight:700">${active}</span>`:'<span style="color:var(--green);font-size:11px">✓ done</span>';}
  const detail=document.getElementById('emp-remark-detail');if(detail&&byEmp[empId])detail.innerHTML=renderEmpRemarks(byEmp[empId]);
  if(pendingIds.length>0)loadRemarksCount();
}
function filterRemarksByStatus(){
  const filter=document.getElementById('rmk-status-filter')?.value||'',empListEl=document.getElementById('emp-remark-list');if(!empListEl)return;
  empListEl.querySelectorAll('div[onclick]').forEach(el=>{const empId=el.getAttribute('onclick').match(/'([^']+)'/)?.[1];if(!empId)return;const empRemarks=_allRemarks.filter(r=>r.empId===empId);const hasActive=empRemarks.some(r=>!['approved','refused'].includes(r.status));const hasDone=empRemarks.some(r=>['approved','refused'].includes(r.status));if(filter===''||(filter==='active'&&hasActive)||(filter==='done'&&hasDone&&!hasActive)){el.style.display='';}else{el.style.display='none';}});
}
async function updateRemark(id,status){
  auditLog('Remark Status Updated',`Remark ID: ${id} → ${status}`);
  // Block manager from updating their own remark
  const allRemarks=_allRemarks||[];
  const rmk=allRemarks.find(r=>r.id===id);
  if(rmk&&isSelf(rmk.empId)){blockSelf();return;}
  try{
    const noteEl=document.getElementById('note_'+id),adminNote=noteEl?noteEl.value.trim():'';
    await fetch(`${PMS_API}?action=update_remark`,{method:'POST',headers:{'X-PMS-Token':PMS_TOKEN,'Content-Type':'application/json'},body:JSON.stringify({id,status,adminNote})});
    const labels={opened:'Opened',processing:'Processing',approved:'Approved ✓',refused:'Refused'};toast(labels[status]||'Updated');
    const rm=_allRemarks.find(r=>r.id===id);if(rm){rm.status=status;rm.adminNote=adminNote;rm.reviewedAt=new Date().toISOString().slice(0,19).replace('T',' ');}
    const byEmp={};_allRemarks.forEach(r=>{if(!byEmp[r.empId])byEmp[r.empId]={name:r.empName,email:r.empEmail,remarks:[]};byEmp[r.empId].remarks.push(r);});
    const detail=document.getElementById('emp-remark-detail');if(detail&&_selectedEmpRemark&&byEmp[_selectedEmpRemark])detail.innerHTML=renderEmpRemarks(byEmp[_selectedEmpRemark]);
    if(_selectedEmpRemark&&byEmp[_selectedEmpRemark]){const active=byEmp[_selectedEmpRemark].remarks.filter(r=>!['approved','refused'].includes(r.status)).length;const listItem=document.querySelector(`#emp-remark-list [data-empid="${_selectedEmpRemark}"]`);if(listItem){const badgeEl=listItem.querySelector('.rmk-badge');if(badgeEl)badgeEl.innerHTML=active>0?`<span style="background:#ef4444;color:#fff;border-radius:20px;padding:1px 8px;font-size:10px;font-weight:700">${active}</span>`:'<span style="color:var(--green);font-size:11px">✓ done</span>';}}
    loadRemarksCount();
  }catch(e){toast('Error updating remark','error');}
}
function addExcFromRemark(empId,empName,date){
  openModal(t('add_exception'),`<div class="alert alert-info">Adding exception from employee dispute: <b>${esc(empName)}</b> on <b>${esc(date)}</b></div><div class="form-group" style="margin-bottom:12px"><label>${t('reason')}</label><select id="ex-reason-rm">${excReasons().map(r=>`<option>${r}</option>`).join('')}</select></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-primary" onclick="saveExcFromRemark('${empId}','${empName}','${date}')">${t('save')}</button>`);
}
function saveExcFromRemark(empId,empName,date){
  const reason=document.getElementById('ex-reason-rm').value;const excs=db.getExceptions();
  excs.push({EmployeeName:empName,EmployeeID:empId,Date:date,Reason:reason});db.setExceptions(excs);closeModal();toast(t('exception_saved'));showRemarks();
}
// ===================== DEDUCTIONS =====================
function getDeductionCats(){return[{key:'parking_card',label:t('cat_parking_card')},{key:'uniform',label:t('cat_uniform')},{key:'loan',label:t('cat_loan')},{key:'damage',label:t('cat_damage')},{key:'absence_pen',label:t('cat_absence_pen')},{key:'other',label:t('cat_other_ded')}];}
function showDeductions(){
  document.getElementById('topbar-actions').innerHTML=`<button class="btn btn-danger btn-sm" onclick="openDedModal()">✂️ ${t('add_deduction')}</button>`;
  document.getElementById('content').innerHTML=`<div class="filter-bar"><div class="form-group"><label>${t('employee')}</label><select id="ded-filter-emp"><option value="">${t('all_employees')}</option>${db.getEmployees().map(e=>`<option>${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('month')}</label><select id="ded-filter-month">${monthOptions(currentMonth())}</select></div><div class="form-group narrow"><label>${t('year')}</label><select id="ded-filter-year">${yearOptions(currentYear())}</select></div><button class="btn btn-primary" onclick="renderDedTable()">${t('load')}</button></div><div id="ded-table-area"></div>`;
  renderDedTable();
}
function renderDedTable(){
  const month=document.getElementById('ded-filter-month')?.value||currentMonth(),year=parseInt(document.getElementById('ded-filter-year')?.value||currentYear()),empF=document.getElementById('ded-filter-emp')?.value||'',mn=getMonthNum(month);
  const deds=db.getDeductions().filter(d=>{try{const dt=new Date(d.Date);if(dt.getMonth()+1!==mn||dt.getFullYear()!==year)return false;}catch{return false;}if(empF&&d.EmployeeName!==empF)return false;return true;});
  const total=deds.reduce((s,d)=>s+parseFloat(d.Amount||0),0),catLabels=Object.fromEntries(getDeductionCats().map(c=>[c.key,c.label]));
  document.getElementById('ded-table-area').innerHTML=`<div class="card"><div class="card-header"><h3>${t('deductions')} — ${month} ${year}</h3><span class="badge badge-red">${t('total')}: AED ${total.toFixed(2)}</span></div>
    ${deds.length===0?`<div class="empty-state"><div class="icon">✂️</div><p>${t('no_deductions')}</p></div>`:
    `<div class="table-wrap"><table><thead><tr><th>#</th><th>${t('date')}</th><th>${t('employee')}</th><th>${t('employee_id')}</th><th>${t('category')}</th><th>${t('deduction_reason')}</th><th>${t('amount')}</th><th>${t('actions')}</th></tr></thead>
    <tbody>${deds.map(d=>`<tr><td>${esc(d.DedID)}</td><td>${esc(d.Date)}</td><td><b>${esc(d.EmployeeName)}</b></td><td>${esc(d.EmployeeID)}</td><td><span class="badge badge-red">${catLabels[d.Category]||d.Category}</span></td><td class="text-sm">${esc(d.Reason)}</td><td style="font-weight:700;color:var(--red)">${parseFloat(d.Amount||0).toFixed(2)}</td><td><button class="btn btn-ghost btn-sm" onclick="openDedModal('${esc(d.DedID)}')">✏️</button><button class="btn btn-ghost btn-sm" onclick="deleteDed('${esc(d.DedID)}')">🗑️</button></td></tr>`).join('')}</tbody></table></div>`}
    </div>`;
}
function openDedModal(dedId=null){
  const deds=db.getDeductions(),d=dedId?deds.find(x=>x.DedID===dedId):null,cats=getDeductionCats();
  openModal(d?t('deductions'):t('add_deduction'),`
    <div class="form-row"><div class="form-group"><label>${t('employee')}</label><select id="ded-emp"><option value="">--</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}" ${d&&d.EmployeeID===e.ID?'selected':''}>${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('date')}</label><input id="ded-date" type="date" value="${d?.Date||''}"></div></div>
    <div class="form-row"><div class="form-group"><label>${t('category')}</label><select id="ded-cat">${cats.map(c=>`<option value="${c.key}" ${d&&d.Category===c.key?'selected':''}>${c.label}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('amount')}</label><input id="ded-amount" type="number" step="0.01" min="0.01" value="${d?.Amount||''}"></div></div>
    <div class="form-group"><label>${t('deduction_reason')}</label><input id="ded-reason" value="${esc(d?.Reason||'')}" placeholder="${t('deduction_reason')}…"></div>
    <div class="form-group"><label>${t('notes')}</label><input id="ded-notes" value="${esc(d?.Notes||'')}"></div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">${t('cancel')}</button><button class="btn btn-danger" onclick="saveDed('${dedId||''}')">${t('save')}</button>`);
}
function saveDed(dedId){
  const empId=document.getElementById('ded-emp').value,date=document.getElementById('ded-date').value,cat=document.getElementById('ded-cat').value,amount=parseFloat(document.getElementById('ded-amount').value),reason=document.getElementById('ded-reason').value.trim(),notes=document.getElementById('ded-notes').value.trim();
  if(!empId||!date||!amount||amount<=0){toast(t('fill_fields'),'error');return;}
  if(isSelf(empId)){blockSelf();return;}
  const emp=db.getEmployees().find(e=>e.ID===empId),deds=db.getDeductions();
  const rec={DedID:dedId||nextId(deds,'DedID'),EmployeeID:empId,EmployeeName:emp.Name,Date:date,Category:cat,Amount:amount.toFixed(2),Reason:reason,Notes:notes};
  if(dedId){const i=deds.findIndex(x=>x.DedID===dedId);if(i>=0)deds[i]=rec;}else deds.push(rec);
  db.setDeductions(deds);closeModal();renderDedTable();toast(t('deduction_saved'));
}
function deleteDed(dedId){
  if(!confirm(t('delete')+'?'))return;
  const d=db.getDeductions().find(x=>x.DedID===dedId);
  if(d&&isSelf(d.EmployeeID)){blockSelf();return;}
  db.setDeductions(db.getDeductions().filter(d=>d.DedID!==dedId));renderDedTable();toast(t('record_deleted'));
}
// ===================== SATURDAY ROSTER =====================
function showSaturdayRoster(){
  const allSat=db.getSaturday()||[],satDates=[...new Set(allSat.map(r=>r.date))].sort().reverse();
  const today=new Date(),todayStr=today.toISOString().split('T')[0],isTodaySat=today.getDay()===6;
  function getLastSaturday(){const d=new Date();d.setDate(d.getDate()-((d.getDay()+1)%7));return d.toISOString().split('T')[0];}
  const defaultDate=isTodaySat?todayStr:(satDates[0]||getLastSaturday());
  document.getElementById('content').innerHTML=`<div class="filter-bar"><div class="form-group"><label>${t('saturday_date')}</label><input type="date" id="sat-date-pick" value="${defaultDate}"></div><button class="btn btn-primary" onclick="loadSaturdayRoster()">${t('load')}</button></div><div id="sat-roster-area"></div>`;
  loadSaturdayRoster();
}
async function loadSaturdayRoster(){
  const date=document.getElementById('sat-date-pick').value;if(!date){toast('Select a date','error');return;}
  const area=document.getElementById('sat-roster-area');
  area.innerHTML=`<div class="card"><div style="text-align:center;padding:30px;color:var(--text-muted)"><div style="width:28px;height:28px;border:3px solid var(--border);border-top-color:var(--accent);border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 10px"></div>Loading…</div></div>`;
  try{
    const r=await fetch(`${PMS_API}?action=get_saturday&date=${encodeURIComponent(date)}`,{headers:{'X-PMS-Token':PMS_TOKEN}});
    const d=await r.json();if(!d.ok)throw new Error(d.error);
    const records=d.records||[],emps=db.getEmployees();
    const onTime=records.filter(r=>r.isBeforeDeadline),notSubmitted=emps.filter(e=>!onTime.some(r=>String(r.empId)===String(e.ID)));
    area.innerHTML=`
      <div class="cards-grid" style="grid-template-columns:1fr 1fr;margin-bottom:16px">
        <div class="stat-card c-green"><div class="label">${t('sat_available')}</div><div class="value">${onTime.length}</div><div class="sub">${t('sat_paid')}</div></div>
        <div class="stat-card" style="background:var(--red)"><div class="label" style="color:#fff">${t('sat_absent')}</div><div class="value" style="color:#fff">${notSubmitted.length}</div><div class="sub" style="color:#fff">${t('sat_deducted')}</div></div>
      </div>
      <div class="alert alert-info">📅 ${t('sat_deadline')} — submission window closes at 11:00 AM sharp. Late submissions are not counted.</div>
      <div class="card"><div class="card-header"><h3>✅ Available — Submitted Before 11 AM (${onTime.length})</h3></div>
        ${!onTime.length?`<p style="color:var(--text-muted);font-size:13px;padding:8px 0">No one submitted before the deadline.</p>`:
        `<div class="table-wrap"><table><thead><tr><th>${t('name')}</th><th>Submitted At</th><th>Status</th></tr></thead><tbody>${onTime.map(r=>`<tr class="row-present"><td><b>${esc(r.empName)}</b></td><td>${esc(r.submittedAt)}</td><td><span class="badge badge-green">${t('sat_paid')}</span></td></tr>`).join('')}</tbody></table></div>`}
      </div>
      <div class="card"><div class="card-header"><h3>❌ Did Not Submit / After Deadline (${notSubmitted.length})</h3></div>
        ${!notSubmitted.length?`<p style="color:var(--text-muted);font-size:13px;padding:8px 0">Everyone submitted on time!</p>`:
        `<div class="table-wrap"><table><thead><tr><th>${t('name')}</th><th>${t('department')}</th><th>Status</th></tr></thead><tbody>${notSubmitted.map(e=>`<tr class="row-absent"><td><b>${esc(e.Name)}</b></td><td>${esc(e.Department)}</td><td><span class="badge badge-red">${t('sat_deducted')}</span></td></tr>`).join('')}</tbody></table></div>`}
      </div>`;
  }catch(e){area.innerHTML=`<div class="alert alert-warn">Failed to load Saturday roster: ${esc(e.message)}</div>`;}
}
// ===================== PAYROLL =====================
// ── NEW SHIFT LOGIC ───────────────────────────────────────────
// Work day = 9 hours (540 min). Flexible start 9:00–10:00 AM.
// Expected end = check-in + 9 h (whatever time they arrive).
// Late = arrived after 10:00 AM → deduct (check-in − 10:00) min.
// Early leave = left before (check-in + 540 min) → deduct shortfall.
const WORK_MINS   = 9 * 60;  // 540 minutes
const LATE_CUTOFF = 10 * 60; // 10:00 AM in minutes from midnight
function calcDayDeductions(ci, co) {
  // Returns {lateMin, earlyMin, totalMin, expectedEnd (HH:MM)}
  const ciM = timeToMins(ci);
  const coM = co ? timeToMins(co) : null;
  const expectedEnd = ciM + WORK_MINS;          // e.g. 9:20 → 18:20
  const lateMin  = Math.max(0, ciM - LATE_CUTOFF); // after 10:00 = late
  const earlyMin = (coM !== null && coM < expectedEnd)
    ? Math.max(0, expectedEnd - coM) : 0;
  const totalMin = lateMin + earlyMin;
  // Format expectedEnd as HH:MM for display
  const eh = String(Math.floor(expectedEnd/60)).padStart(2,'0');
  const em = String(expectedEnd%60).padStart(2,'0');
  return {lateMin, earlyMin, totalMin, expectedEnd:`${eh}:${em}`};
}
// Keep for legacy CSV import mid-day split (no longer used for deductions)
function detectShift(ci,co){return{start:'09:00',end:'18:00',name:'9h Flexible'};}
function commissionFor(empId,year,month){
  const deals=db.getDeals(),splits=db.getSplits(),byDeal={};splits.forEach(s=>{if(!byDeal[s.DealID])byDeal[s.DealID]=[];byDeal[s.DealID].push(s);});
  let total=0;deals.forEach(d=>{try{const dt=new Date(d.Date);if(dt.getFullYear()!==year||dt.getMonth()+1!==month)return;}catch{return;}const comm=parseFloat(d.Amount||0)*basePct(d.Source),ds=byDeal[d.DealID];if(!ds||!ds.length){if(d.PrimaryEmpID===empId)total+=comm;return;}ds.forEach(s=>{if(s.EmployeeID===empId)total+=comm*(parseFloat(s.SharePercent||0)/100);});});
  return Math.round(total*100)/100;
}
function advancesFor(empId,year,month){return db.getAdvances().filter(a=>{try{const d=new Date(a.Date);return d.getFullYear()===year&&d.getMonth()+1===month&&a.EmployeeID===empId;}catch{return false;}}).reduce((s,a)=>s+parseFloat(a.Amount||0),0);}
function reimbsFor(empId,year,month){return db.getReimbs().filter(r=>{try{const d=new Date(r.Date);return d.getFullYear()===year&&d.getMonth()+1===month&&r.EmployeeID===empId&&r.Status==='approved';}catch{return false;}}).reduce((s,r)=>s+parseFloat(r.Amount||0),0);}
function reimbListFor(empId,year,month){return db.getReimbs().filter(r=>{try{const d=new Date(r.Date);return d.getFullYear()===year&&d.getMonth()+1===month&&r.EmployeeID===empId&&r.Status==='approved';}catch{return false;}});}
function deductionsFor(empId,year,month){return db.getDeductions().filter(d=>{try{const dt=new Date(d.Date);return dt.getFullYear()===year&&dt.getMonth()+1===month&&d.EmployeeID===empId;}catch{return false;}}).reduce((s,d)=>s+parseFloat(d.Amount||0),0);}
function deductionListFor(empId,year,month){return db.getDeductions().filter(d=>{try{const dt=new Date(d.Date);return dt.getFullYear()===year&&dt.getMonth()+1===month&&d.EmployeeID===empId;}catch{return false;}});}
function showPayroll(){
  document.getElementById('content').innerHTML=`<div class="filter-bar"><div class="form-group"><label>${t('employee')}</label><select id="pay-emp"><option value="">-- ${t('employee')} --</option>${db.getEmployees().map(e=>`<option value="${esc(e.ID)}">${esc(e.Name)}</option>`).join('')}</select></div><div class="form-group narrow"><label>${t('month')}</label><select id="pay-month">${monthOptions(currentMonth())}</select></div><div class="form-group narrow"><label>${t('year')}</label><select id="pay-year">${yearOptions(currentYear())}</select></div><div class="form-group narrow"><label>${t('up_to_day')}</label><input id="pay-uptoday" type="number" min="1" max="31" placeholder="e.g. 15"></div><div class="form-group narrow" style="justify-content:flex-end;padding-bottom:2px"><label style="white-space:nowrap;display:flex;align-items:center;gap:6px;text-transform:none;font-size:12px;font-weight:600;color:var(--text-muted);cursor:pointer"><input type="checkbox" id="pay-deduct-mins" checked style="width:15px;height:15px;accent-color:var(--accent);cursor:pointer"> Deduct late/early mins</label></div><button class="btn btn-primary" onclick="calculatePayroll()">${t('calculate')}</button><button class="btn btn-success" onclick="downloadPayrollCsv()">${t('download')}</button></div><div id="pay-results"></div>`;
}
function calculatePayroll(){
  const empId=document.getElementById('pay-emp').value,month=document.getElementById('pay-month').value,year=parseInt(document.getElementById('pay-year').value),uptoRaw=document.getElementById('pay-uptoday').value;
  if(!empId||!month||!year){toast(t('select_emp_month_year'),'error');return;}
  const emp=db.getEmployees().find(e=>e.ID===empId);if(!emp){toast(t('emp_not_found'),'error');return;}
  const mn=getMonthNum(month),daysInMonth=getDaysInMonth(year,mn),endDay=uptoRaw?Math.min(parseInt(uptoRaw)||daysInMonth,daysInMonth):daysInMonth;
  const salary=parseFloat(emp.Salary||0),workMinsPerDay=WORK_MINS,dailyRate=salary/daysInMonth,perMinRate=dailyRate/workMinsPerDay;
  const deductMins=document.getElementById('pay-deduct-mins')?.checked!==false; // default true
  const empAtt=(db.getAttendance()[empId])||{},excMap={};
  // Fix: use String() comparison so "21" === 21 doesn't fail
  db.getExceptions().filter(x=>String(x.EmployeeID)===String(empId)).forEach(x=>{excMap[x.Date]=x.Reason;});
  let totalLateMinutes=0,absentDays=0,lateDays=0,presentDays=0,satCount=0,sunCount=0,excCount=0;
  const dayLogs=[];
  for(let day=1;day<=endDay;day++){
    const ds=`${year}-${String(mn).padStart(2,'0')}-${String(day).padStart(2,'0')}`,wd=getWeekday(ds);
    if(wd===6){
      satCount++;
      // Check exception first — if Saturday has an exception, treat as paid day
      if(excMap[ds]){
        excCount++;
        dayLogs.push({ds,ci:'',co:'',lateMin:0,dedAED:0,status:`${t('exception_lbl')}: ${excMap[ds]} (Saturday — Paid)`,cls:'row-exception'});
      } else {
        const satAll=db.getSaturday()||[],satRec=satAll.find(r=>String(r.empId)===String(empId)&&r.date===ds&&r.isBeforeDeadline);
        if(satRec){dayLogs.push({ds,ci:'',co:'',lateMin:0,dedAED:0,status:'Saturday — Available ✓ (Paid)',cls:'row-present'});}
        else{absentDays++;const reason='Saturday — No availability submitted';dayLogs.push({ds,ci:'',co:'',lateMin:0,dedAED:dailyRate,isAbsent:true,status:`${reason} (−AED ${dailyRate.toFixed(2)})`,cls:'row-absent'});}
      }
      continue;
    }
    if(wd===0){sunCount++;dayLogs.push({ds,ci:'',co:'',lateMin:0,status:t('sunday'),cls:'row-sun'});continue;}
    const exc=excMap[ds];if(exc){excCount++;dayLogs.push({ds,ci:'',co:'',lateMin:0,status:`${t('exception_lbl')}: ${exc}`,cls:'row-exception'});continue;}
    const rec=empAtt[ds],ci=rec?.CheckIn||'',co=rec?.CheckOut||'';
    if(!ci&&!co){absentDays++;const dedAED=dailyRate.toFixed(2);dayLogs.push({ds,ci,co,lateMin:0,dedAED:parseFloat(dedAED),isAbsent:true,status:`${t('absent')} (−AED ${dedAED})`,cls:'row-absent'});continue;}
    const {lateMin,earlyMin,totalMin:totalMinDed,expectedEnd}=calcDayDeductions(ci,co);
    const effectiveMinDed=deductMins?totalMinDed:0; // skip minute deductions if toggle off
    const dedAED=effectiveMinDed*perMinRate;
    let parts=[];
    if(lateMin>0)  parts.push(`Late arrival ${lateMin} min (after 10:00 AM)${!deductMins?' [not deducted]':''}`);
    if(earlyMin>0) parts.push(`Left early ${earlyMin} min (before ${expectedEnd})${!deductMins?' [not deducted]':''}`);
    const dedLabel=dedAED>0?` (−AED ${dedAED.toFixed(2)})`:'',statusTxt=parts.length>0?parts.join(' + ')+dedLabel:t('present'),cls=effectiveMinDed>0?'row-halfday':'row-present';
    if(effectiveMinDed>0)lateDays++;else presentDays++;
    totalLateMinutes+=effectiveMinDed;dayLogs.push({ds,ci,co,lateMin:effectiveMinDed,lateArrival:lateMin,earlyLeave:earlyMin,dedAED,isAbsent:false,status:statusTxt,cls});
  }
  const absentDeduction=absentDays*dailyRate,minuteDeduction=totalLateMinutes*perMinRate,attendanceDeduction=absentDeduction+minuteDeduction,finalSalary=Math.max(0,salary-attendanceDeduction);
  const commission=commissionFor(empId,year,mn),advances=advancesFor(empId,year,mn),reimbs=reimbsFor(empId,year,mn),reimbList=reimbListFor(empId,year,mn),deductions=deductionsFor(empId,year,mn),deductionList=deductionListFor(empId,year,mn),totalPay=finalSalary+commission-advances+reimbs-deductions;
  let workingDays=0;for(let d=1;d<=endDay;d++){const wd=getWeekday(`${year}-${String(mn).padStart(2,'0')}-${String(d).padStart(2,'0')}`);if(wd!==0&&wd!==6)workingDays++;}
  lastPayroll={emp,month,year,endDay,daysInMonth,salary,dailyRate,perMinRate,workMinsPerDay,totalLateMinutes,absentDeduction,minuteDeduction,attendanceDeduction,finalSalary,absentDays,lateDays,presentDays,commission,advances,reimbs,reimbList,deductions,deductionList,totalPay,dayLogs,workingDays,mn,deductMins};
  const catLabels=Object.fromEntries(getReimbCats().map(c=>[c.key,c.label]));
  document.getElementById('pay-results').innerHTML=`
    <div class="card"><div class="card-header"><h3>${esc(emp.Name)} — ${month} ${year}${endDay<daysInMonth?` (${t('partial_month')} ${endDay})`:''}<span class="tag" style="margin-left:8px">ID: ${esc(emp.ID)}</span></h3></div>
      <div class="payroll-summary">
        <div class="summary-box"><h4>${t('att_salary')}</h4>
          <div class="summary-row"><span>${t('basic_salary')}</span><span>AED ${salary.toLocaleString()}</span></div>
          <div class="summary-row"><span>${t('days_in_month')}</span><span>${daysInMonth}</span></div>
          <div class="summary-row"><span>${t('daily_rate')}</span><span>AED ${dailyRate.toFixed(4)}</span></div>
          <div class="summary-row"><span>Work hours / day</span><span>9 hours (540 min)</span></div>
          <div class="summary-row"><span>Rate / minute</span><span>AED ${perMinRate.toFixed(5)}</span></div>
          <div class="summary-row"><span style="font-size:11px;color:var(--text-muted)">Late cutoff: 10:00 AM | Expected end = check-in + 9h</span><span></span></div>
          <div class="summary-row"><span>Absent days</span><span style="color:var(--red)">${absentDays} × AED ${dailyRate.toFixed(2)} = −AED ${absentDeduction.toFixed(2)}</span></div>
          <div class="summary-row"><span>Late / left early (min)</span><span style="color:${deductMins?'var(--orange)':'var(--text-muted)'}">${totalLateMinutes} min = ${deductMins?('−AED '+minuteDeduction.toFixed(2)):'<span style="background:#f1f5f9;padding:1px 8px;border-radius:4px;font-size:11px">not deducted</span>'}</span></div>
          <div class="summary-row"><span>${t('absence_cost')}</span><span style="color:var(--red)">−AED ${attendanceDeduction.toFixed(2)}</span></div>
          <div class="summary-row total"><span>${t('att_salary')}</span><span class="amount">AED ${finalSalary.toFixed(2)}</span></div>
        </div>
        <div class="summary-box"><h4>${t('net_total')}</h4>
          <div class="summary-row"><span>${t('att_salary')}</span><span>AED ${finalSalary.toFixed(2)}</span></div>
          <div class="summary-row"><span>${t('commission')}</span><span style="color:var(--green)">${commission>0?'+':''}AED ${commission.toFixed(2)}</span></div>
          <div class="summary-row"><span>${t('reimb_lbl')} (approved)</span><span style="color:var(--teal)">${reimbs>0?'+':''}AED ${reimbs.toFixed(2)}</span></div>
          <div class="summary-row"><span>${t('advances_lbl')}</span><span style="color:var(--red)">${advances>0?`−AED ${advances.toFixed(2)}`:'AED 0'}</span></div>
          <div class="summary-row"><span>${t('deductions_lbl')}</span><span style="color:var(--red)">${deductions>0?`−AED ${deductions.toFixed(2)}`:'AED 0'}</span></div>
          <div class="summary-row total"><span>${t('net_total')}</span><span class="amount">AED ${totalPay.toFixed(2)}</span></div>
        </div>
      </div>
      ${reimbs>0?`<div class="alert alert-teal mt-3">🧾 <b>${t('reimb_lbl')}:</b> ${reimbList.map(r=>`${catLabels[r.Category]||r.Category} (AED ${parseFloat(r.Amount).toFixed(2)}${r.Description?` — ${r.Description}`:''})`).join(' | ')}</div>`:''}
      ${deductions>0?`<div class="alert alert-warn mt-3">✂️ <b>${t('deductions_lbl')}:</b> ${deductionList.map(d=>{const dc=Object.fromEntries(getDeductionCats().map(c=>[c.key,c.label]));return`${dc[d.Category]||d.Category} (AED ${parseFloat(d.Amount).toFixed(2)}${d.Reason?` — ${d.Reason}`:''})`}).join(' | ')}</div>`:''}
    </div>
    <div class="card"><div class="card-header"><h3>${t('day_breakdown')}</h3></div>
      <div class="table-wrap"><table><thead><tr><th>${t('date')}</th><th>${t('check_in')}</th><th>${t('check_out')}</th><th>Late (min)</th><th>${t('status')}</th></tr></thead>
      <tbody>${dayLogs.map(l=>`<tr class="${l.cls}"><td>${dateLabel(l.ds)}</td><td>${l.ci||'—'}</td><td>${l.co||'—'}</td><td>${l.lateMin>0?`<span style="color:var(--red);font-weight:600">${l.lateMin}</span>`:'—'}</td><td>${esc(l.status)}</td></tr>`).join('')}</tbody></table></div>
    </div>`;
}
function downloadPayrollCsv(){
  if(!lastPayroll){toast(t('calc_first'),'error');return;}
  const p=lastPayroll,catLabels=Object.fromEntries(getReimbCats().map(c=>[c.key,c.label]));
  let csv=`Payroll Report\nEmployee,${p.emp.Name}\nID,${p.emp.ID}\nMonth,${p.month} ${p.year}\nDays in Month,${p.daysInMonth}\nWorking Days (Mon-Fri),${p.workingDays}\nBasic Salary,${p.salary}\nDaily Rate,${p.dailyRate.toFixed(4)}\nRate per Minute,${p.perMinRate.toFixed(6)}\nMinute Deductions,${p.deductMins?'Yes (applied)':'No (disabled for this calculation)'}\nAbsent Days,${p.absentDays}\nAbsent Deduction,${p.absentDeduction.toFixed(2)}\nLate/Early Minutes,${p.totalLateMinutes}\nMinute Deduction,${p.minuteDeduction.toFixed(2)}\nTotal Attendance Deduction,${p.attendanceDeduction.toFixed(2)}\nAttendance Salary,${p.finalSalary.toFixed(2)}\nCommission,${p.commission.toFixed(2)}\nReimbursements (Approved),${p.reimbs.toFixed(2)}\n`;
  if(p.reimbList.length)p.reimbList.forEach(r=>csv+=`  - ${catLabels[r.Category]||r.Category}: AED ${parseFloat(r.Amount).toFixed(2)}${r.Description?` (${r.Description})`:''}\n`);
  csv+=`Deductions,${p.deductions.toFixed(2)}\n`;
  if(p.deductionList&&p.deductionList.length){const dedCatLabels=Object.fromEntries(getDeductionCats().map(c=>[c.key,c.label]));p.deductionList.forEach(d=>csv+=`  - ${dedCatLabels[d.Category]||d.Category}: AED ${parseFloat(d.Amount).toFixed(2)}${d.Reason?` (${d.Reason})`:''}\n`);}
  csv+=`Advances,${p.advances.toFixed(2)}\nNet Total Pay,${p.totalPay.toFixed(2)}\n\nDate,Check-in,Check-out,Status\n`;
  p.dayLogs.forEach(l=>csv+=`${l.ds},${l.ci},${l.co},"${l.status}"\n`);
  const blob=new Blob(['\uFEFF'+csv],{type:'text/csv;charset=utf-8'}),a=document.createElement('a');
  a.href=URL.createObjectURL(blob);a.download=`payroll_${p.emp.Name.replace(/\s+/g,'_')}_${p.month}_${p.year}.csv`;a.click();toast(t('download'));
}
// ===================== AUTO SYNC =====================
let _autoSyncInterval=null;
async function autoSyncFromDevice(){
  try{
    const topbarRight=document.getElementById('topbar-actions');
    const syncBadge=document.createElement('div');syncBadge.id='sync-badge';
    syncBadge.style.cssText='display:flex;align-items:center;gap:6px;font-size:12px;color:#64748b;padding:5px 10px;background:#f1f5f9;border-radius:20px;';
    syncBadge.innerHTML='<div style="width:10px;height:10px;border:2px solid #cbd5e1;border-top-color:#6366f1;border-radius:50%;animation:spin 0.8s linear infinite"></div> Syncing…';
    topbarRight.prepend(syncBadge);
    const resp=await fetch(bridgeUrl.replace(/\/+$/,'')+'/attendance',{mode:'cors',signal:AbortSignal.timeout(20000)});
    if(!resp.ok)throw new Error('HTTP '+resp.status);
    const data=await resp.json();if(data.status!=='ok')throw new Error(data.error||'Device error');
    const records=data.records||[],emps=db.getEmployees(),empById=Object.fromEntries(emps.map(e=>[String(e.ID).trim(),e])),empByName=Object.fromEntries(emps.map(e=>[e.Name.toLowerCase().trim(),e]));
    const raw={};let matched=0;
    for(const r of records){const emp=empById[String(r.emp_id||'').trim()]||empByName[(r.name||'').toLowerCase().trim()];if(!emp)continue;if(!raw[emp.ID])raw[emp.ID]={};if(!raw[emp.ID][r.date])raw[emp.ID][r.date]=[];if(r.time)raw[emp.ID][r.date].push(r.time);matched++;}
    const all=db.getAttendance();let saved=0;
    for(const empId in raw){if(!all[empId])all[empId]={};const empRec=empById[empId],midMins=(empRec?.Shift==='late_shift')?870:810;
      for(const d in raw[empId]){const times=[...new Set(raw[empId][d])].filter(Boolean).sort(),inT=[],outT=[];
        for(const tt of times){const m=timeToMins(tt);if(m<360)continue;if(m<=midMins)inT.push(tt);else outT.push(tt);}
        all[empId][d]={CheckIn:inT[0]||'',CheckOut:outT[outT.length-1]||''};saved++;
      }
    }
    db.setAttendance(all);
    syncBadge.style.color='#16a34a';syncBadge.style.background='#dcfce7';
    syncBadge.innerHTML=`✓ Device synced &nbsp;<span style="color:#64748b">${records.length} records</span>`;
    setTimeout(()=>syncBadge.remove(),5000);
    if(currentView==='attendance'&&attState.empId)loadAttendanceView();
  }catch(e){
    const badge=document.getElementById('sync-badge');if(badge)badge.remove();
    if(e.message&&!e.message.toLowerCase().includes('fetch')&&!e.message.includes('abort')&&!e.message.includes('HTTP')){toast('Device sync: '+e.message,'error');}
  }
}
// ===================== SETTINGS =====================
const VIEW_LABELS={
  dashboard:'Dashboard',attendance:'Attendance Overview',exceptions:'Manage Exceptions',
  remarks:'Employee Remarks',saturday:'Saturday Roster',reimbursements:'Reimbursements',
  commissions:'Commissions',employees:'Employee Management',advances:'Salary Advances',
  deductions:'Deductions',payroll:'Payroll Calculation'
};
const VIEW_ICONS={
  dashboard:'📊',attendance:'📅',exceptions:'📋',remarks:'🔔',saturday:'📆',
  reimbursements:'🧾',commissions:'🤝',employees:'👥',advances:'💰',deductions:'✂️',payroll:'🧮'
};

async function showSettings(){
  document.getElementById('content').innerHTML=`<div class="card"><div class="loader"><div class="spinner"></div><p>Loading…</p></div></div>`;
  const users=await getMgrUsers();
  const rows=users.length===0
    ?`<tr><td colspan="4" style="padding:24px;text-align:center;color:var(--text-muted)">No manager accounts yet. Click <b>Add Manager</b> to create one.</td></tr>`
    :users.map((u,i)=>{
      const viewsList=(u.views||[]).map(v=>VIEW_LABELS[v]||v).join(', ')||'No access';
      return`<tr style="border-bottom:1px solid var(--border)">
        <td style="padding:12px 14px">
          <div style="font-weight:600;font-size:13px">${esc(u.email)}</div>
          <div style="font-size:11px;color:var(--text-muted);margin-top:2px">${esc(u.name||'')}${u.selfEmpId?` · 🔒 Linked to employee #${esc(u.selfEmpId)}`:''}</div>
        </td>
        <td style="padding:12px 14px;font-size:12px;color:var(--text-muted);max-width:280px">${esc(viewsList)}</td>
        <td style="padding:12px 14px">
          <span style="background:${u.active!==false?'var(--green-bg)':'var(--red-bg)'};color:${u.active!==false?'var(--green)':'var(--red)'};padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700">${u.active!==false?'Active':'Disabled'}</span>
        </td>
        <td style="padding:12px 14px">
          <div style="display:flex;gap:6px">
            <button class="btn btn-secondary btn-sm" onclick="openMgrModal(${i})">✏️ Edit</button>
            <button class="btn btn-secondary btn-sm" onclick="toggleMgrUser(${i})" style="color:${u.active!==false?'var(--orange)':'var(--green)'}">${u.active!==false?'Disable':'Enable'}</button>
            <button class="btn btn-ghost btn-sm" onclick="deleteMgrUser(${i})" style="color:var(--red)">🗑️</button>
          </div>
        </td>
      </tr>`;
    }).join('');

  document.getElementById('content').innerHTML=`
    <div style="max-width:760px">
      <div class="card" style="margin-bottom:18px">
        <div class="card-header"><h3>🔐 Admin Account</h3></div>
        <div style="display:flex;align-items:center;gap:14px;padding:6px 0">
          <div style="width:44px;height:44px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px">👑</div>
          <div><div style="font-weight:700">admin@naeladvertising.ae</div><div style="font-size:12px;color:var(--text-muted)">Full access — all sections visible</div></div>
          <span style="margin-left:auto;background:var(--green-bg);color:var(--green);padding:3px 12px;border-radius:20px;font-size:12px;font-weight:700">Active</span>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <div>
            <h3>👤 Manager Accounts</h3>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px">Each manager has a custom email, password and selected permissions</div>
          </div>
          <button class="btn btn-primary" onclick="openMgrModal(null)">➕ Add Manager</button>
        </div>
        <div class="table-wrap">
          <table style="width:100%;border-collapse:collapse">
            <thead><tr style="background:#f8fafc">
              <th style="padding:10px 14px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Account</th>
              <th style="padding:10px 14px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Can Access</th>
              <th style="padding:10px 14px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Status</th>
              <th style="padding:10px 14px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Actions</th>
            </tr></thead>
            <tbody>${rows}</tbody>
          </table>
        </div>
      </div>
      <!-- Audit Log -->
      <div class="card" style="margin-top:18px">
        <div class="card-header">
          <h3>📋 Audit Log</h3>
          <button class="btn btn-secondary btn-sm" onclick="loadAuditLog()">🔄 Refresh</button>
        </div>
        <div id="audit-log-area"><div class="loader"><div class="spinner"></div></div></div>
      </div>
    </div>`;
  loadAuditLog();
}

async function loadAuditLog(){
  const area=document.getElementById('audit-log-area');
  if(!area) return;
  try{
    const r=await fetch(`${PMS_API}?action=store&key=pms_audit_log`,{headers:{'X-PMS-Token':PMS_TOKEN}});
    const text=await r.text();
    const logs=text&&text!=='null'?JSON.parse(text):[];
    if(!logs.length){area.innerHTML=`<p style="color:var(--text-muted);text-align:center;padding:20px;font-size:13px">No changes recorded yet.</p>`;return;}
    const roleColor={admin:'var(--accent)',manager:'var(--teal)'};
    const actionIcon={'Employee Added':'👤+','Employee Updated':'✏️','Employee Deleted':'🗑️','Reimbursement Added':'🧾','Reimbursement Updated':'🧾','Remark Status Updated':'💬','Exception Added':'📋+','Exception Updated':'📋✏️','Exception Deleted':'📋🗑️','Exception Added for All':'📋+'};
    area.innerHTML=`
      <div style="max-height:420px;overflow-y:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13px">
          <thead style="position:sticky;top:0;background:#f8fafc;z-index:1">
            <tr>
              <th style="padding:8px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase;white-space:nowrap">When</th>
              <th style="padding:8px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Who</th>
              <th style="padding:8px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Action</th>
              <th style="padding:8px 12px;text-align:left;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase">Details</th>
            </tr>
          </thead>
          <tbody>${logs.map((l,i)=>{
            const d=new Date(l.ts);
            const when=d.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'})+' '+d.toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'});
            return`<tr style="border-top:1px solid var(--border);background:${i%2===0?'#fff':'#f8fafc'}">
              <td style="padding:8px 12px;font-size:11px;color:var(--text-muted);white-space:nowrap">${when}</td>
              <td style="padding:8px 12px"><span style="background:${roleColor[l.role]||'#64748b'}22;color:${roleColor[l.role]||'#64748b'};padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700">${esc(l.user||'?')}</span></td>
              <td style="padding:8px 12px;font-weight:600;white-space:nowrap">${actionIcon[l.action]||'•'} ${esc(l.action)}</td>
              <td style="padding:8px 12px;font-size:12px;color:var(--text-muted)">${esc(l.details||'')}</td>
            </tr>`;
          }).join('')}</tbody>
        </table>
      </div>
      <div style="padding:8px 12px;font-size:11px;color:var(--text-muted);border-top:1px solid var(--border)">${logs.length} entries · Last 500 kept</div>`;
  }catch(e){area.innerHTML=`<p style="color:var(--red);padding:16px;font-size:13px">Could not load: ${esc(e.message)}</p>`;}
}

async function openMgrModal(editIdx){
  const users=await getMgrUsers();
  const u=editIdx!==null&&editIdx!==undefined?users[editIdx]:null;
  const userViews=new Set(u?.views||[]);
  const emps=db.getEmployees();
  const checkboxes=Object.entries(VIEW_LABELS).map(([view,label])=>`
    <label style="display:flex;align-items:center;gap:8px;padding:7px 10px;border-radius:6px;cursor:pointer;border:1px solid var(--border);background:var(--white);font-size:13px">
      <input type="checkbox" class="mgr-view-chk" value="${view}" ${userViews.has(view)?'checked':''} style="width:15px;height:15px;accent-color:var(--accent)">
      <span>${VIEW_ICONS[view]||'•'} ${label}</span>
    </label>`).join('');

  const empOptions=`<option value="">— None (not an employee) —</option>`+
    emps.map(e=>`<option value="${esc(e.ID)}" ${u?.selfEmpId===e.ID?'selected':''}>${esc(e.Name)} (ID: ${esc(e.ID)})</option>`).join('');

  openModal(u?'Edit Manager Account':'Add Manager Account',`
    <div class="form-group" style="margin-bottom:12px">
      <label>Name</label>
      <input id="mgr-name" type="text" placeholder="e.g. Sondos" value="${esc(u?.name||'')}" style="width:100%">
    </div>
    <div class="form-group" style="margin-bottom:12px">
      <label>Email Address</label>
      <input id="mgr-email" type="email" placeholder="name@naelmedia.ae" value="${esc(u?.email||'')}" style="width:100%">
    </div>
    <div class="form-group" style="margin-bottom:12px">
      <label>${u?'New Password (leave blank to keep current)':'Password'}</label>
      <input id="mgr-pass" type="password" placeholder="Min. 6 characters" style="width:100%">
    </div>
    <div class="form-group" style="margin-bottom:16px">
      <label>Confirm Password</label>
      <input id="mgr-pass2" type="password" placeholder="Repeat password" style="width:100%">
    </div>
    <div class="form-group" style="margin-bottom:16px">
      <label>This manager is also an employee</label>
      <select id="mgr-self-emp" style="width:100%">${empOptions}</select>
      <div style="font-size:11px;color:var(--text-muted);margin-top:5px">⚠️ If selected, this manager can <b>view</b> that employee's data but <b>cannot edit, approve or modify</b> anything related to them.</div>
    </div>
    <div class="form-group">
      <label>Sections this manager can access</label>
      <div style="display:flex;gap:6px;margin-bottom:8px">
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.querySelectorAll('.mgr-view-chk').forEach(c=>c.checked=true)">✅ All</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.querySelectorAll('.mgr-view-chk').forEach(c=>c.checked=false)">☐ None</button>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;max-height:200px;overflow-y:auto">${checkboxes}</div>
    </div>`,
    `<button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
     <button class="btn btn-primary" onclick="saveMgrUser(${editIdx!==null&&editIdx!==undefined?editIdx:'null'})">Save</button>`
  );
}

async function saveMgrUser(editIdx){
  const name=document.getElementById('mgr-name').value.trim();
  const email=document.getElementById('mgr-email').value.trim().toLowerCase();
  const pass=document.getElementById('mgr-pass').value;
  const pass2=document.getElementById('mgr-pass2').value;
  const views=[...document.querySelectorAll('.mgr-view-chk:checked')].map(c=>c.value);
  const selfEmpId=document.getElementById('mgr-self-emp').value||null;

  if(!email){toast('Please enter an email address','error');return;}
  if(editIdx===null&&!pass){toast('Please enter a password','error');return;}
  if(pass&&pass.length<6){toast('Password must be at least 6 characters','error');return;}
  if(pass&&pass!==pass2){toast('Passwords do not match','error');return;}
  if(!views.length){toast('Please select at least one section','error');return;}

  const users=await getMgrUsers();
  let hash=editIdx!==null?users[editIdx]?.hash:'';
  if(pass){
    const buf=await crypto.subtle.digest('SHA-256',new TextEncoder().encode(email+'::'+pass));
    hash=Array.from(new Uint8Array(buf)).map(b=>b.toString(16).padStart(2,'0')).join('');
  }
  const record={name,email,hash,views,selfEmpId,active:true,createdAt:users[editIdx]?.createdAt||new Date().toISOString()};
  if(editIdx!==null) users[editIdx]=record;
  else users.push(record);
  await setMgrUsers(users);
  closeModal();
  toast(editIdx!==null?'Manager account updated ✅':'Manager account added ✅');
  showSettings();
}

async function toggleMgrUser(idx){
  const users=await getMgrUsers();
  users[idx].active=!users[idx].active;
  await setMgrUsers(users);
  toast(users[idx].active?'Account enabled':'Account disabled');
  showSettings();
}

async function deleteMgrUser(idx){
  if(!confirm('Delete this manager account? They will no longer be able to log in.'))return;
  const users=await getMgrUsers();
  users.splice(idx,1);
  await setMgrUsers(users);
  toast('Account deleted');
  showSettings();
}

function _showSyncStatus(msg,color='#64748b'){
  let el=document.getElementById('sync-status-bar');
  if(!el){el=document.createElement('div');el.id='sync-status-bar';el.style.cssText='position:fixed;top:0;left:0;right:0;z-index:9998;padding:8px 20px;font-size:12px;font-weight:600;text-align:center;transition:opacity 0.4s';document.body.appendChild(el);}
  el.style.background=color==='ok'?'#16a34a':color==='err'?'#dc2626':'#1e293b';el.style.color='#fff';el.style.opacity='1';el.textContent=msg;
  if(color==='ok'||color==='err'){setTimeout(()=>{el.style.opacity='0';setTimeout(()=>el.remove(),400);},4000);}
}
async function _loadApp(fromLogin=false){
  _currentRole=sessionStorage.getItem('pms_role')||'admin';
  const savedViews=sessionStorage.getItem('pms_user_views');
  _currentUserViews=savedViews?new Set(JSON.parse(savedViews)):null;
  // selfEmpId is already in sessionStorage — isSelf() reads it directly
  if(fromLogin){const btn=document.getElementById('login-btn'),sp=document.getElementById('login-spinner'),txt=document.getElementById('login-btn-text');if(btn)btn.disabled=true;if(sp)sp.style.display='block';if(txt)txt.textContent='Syncing data…';}
  _showSyncStatus('⟳  Syncing data from server…');
  await syncAllFromServer();
  document.getElementById('login-screen').classList.add('hidden');
  _showSyncStatus('✓  Data loaded','ok');
  const savedLang=localStorage.getItem('pms_lang')||'en';currentLang=savedLang;
  document.getElementById('html-root').setAttribute('lang',savedLang);document.getElementById('html-root').setAttribute('dir',savedLang==='ar'?'rtl':'ltr');
  document.getElementById('btn-en').classList.toggle('active',savedLang==='en');document.getElementById('btn-ar').classList.toggle('active',savedLang==='ar');
  document.getElementById('brand-title').textContent=t('brand');document.getElementById('brand-sub').textContent=t('brand_sub');document.getElementById('sidebar-footer-text').textContent=t('sidebar_footer');
  buildNav();route('dashboard');
  setTimeout(autoSyncFromDevice,2000);setTimeout(loadRemarksCount,3000);
  if(_autoSyncInterval)clearInterval(_autoSyncInterval);
  _autoSyncInterval=setInterval(autoSyncFromDevice,5*60*1000);
}
// ===================== INIT =====================
function init(){
  if(!isLoggedIn()){document.getElementById('login-email').value='admin@naeladvertising.ae';return;}
  document.getElementById('login-screen').classList.add('hidden');_loadApp(false);
}
const _origDoLogin=doLogin;
doLogin=async function(){await _origDoLogin();if(isLoggedIn())await _loadApp(true);}
init();
</script>
</body>
</html>