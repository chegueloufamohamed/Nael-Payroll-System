<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Payroll — Nael Media</title>
<style>
:root{
  --bg:#f1f5f9;--white:#fff;--border:#e2e8f0;--text:#1e293b;--muted:#64748b;
  --accent:#6366f1;--green:#16a34a;--green-bg:#dcfce7;--red:#dc2626;--red-bg:#fee2e2;
  --orange:#d97706;--orange-bg:#fef3c7;--teal:#0d9488;--teal-bg:#ccfbf1;
  --blue:#2563eb;--blue-bg:#dbeafe;--sat-bg:#fef9ec;--sun-bg:#eff6ff;
  --shadow:0 1px 3px rgba(0,0,0,.08);--shadow-lg:0 8px 30px rgba(0,0,0,.12);
  --radius:10px;--font:'Segoe UI',system-ui,sans-serif;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font);background:var(--bg);color:var(--text);min-height:100vh}
#login-screen{position:fixed;inset:0;z-index:999;background:#0f172a;display:flex;align-items:center;justify-content:center;padding:20px}
#login-screen.hidden{display:none}
.login-box{background:#1e293b;border-radius:16px;padding:38px 42px;width:100%;max-width:400px;box-shadow:var(--shadow-lg)}
.login-box .logo{text-align:center;margin-bottom:26px}
.login-box .logo-img{height:56px;width:auto;object-fit:contain;margin:0 auto 12px;display:block}
.login-box h1{font-size:20px;font-weight:800;color:#fff;text-align:center}
.login-box p{font-size:12px;color:#64748b;text-align:center;margin-top:4px}
.lfield{margin-bottom:14px}
.lfield label{display:block;font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px}
.lfield input{width:100%;padding:11px 13px;background:#0f172a;border:1.5px solid #334155;border-radius:7px;font-size:14px;color:#e2e8f0;outline:none;font-family:var(--font)}
.lfield input:focus{border-color:var(--accent)}
.lfield input::placeholder{color:#475569}
.lbtn{width:100%;padding:11px;background:var(--accent);color:#fff;border:none;border-radius:7px;font-size:14px;font-weight:700;cursor:pointer;margin-top:6px;font-family:var(--font);display:flex;align-items:center;justify-content:center;gap:8px}
.lbtn:disabled{background:#334155;cursor:not-allowed}
.lerr{background:#450a0a;border:1px solid #7f1d1d;border-radius:7px;padding:9px 13px;font-size:12px;color:#fca5a5;margin-top:12px;display:none}
.lerr.show{display:block}
.lhint{font-size:12px;color:#475569;text-align:center;margin-top:10px}
#lspinner{width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none}
#topbar{background:var(--white);border-bottom:1px solid var(--border);padding:12px 24px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
#topbar .brand{display:flex;align-items:center;gap:10px}
#topbar .brand-logo{height:36px;width:auto;object-fit:contain}
#topbar .brand h2{font-size:14px;font-weight:700;color:var(--text)}
#topbar .brand p{font-size:11px;color:var(--muted)}
.signout-btn{padding:6px 13px;background:#fee2e2;color:var(--red);border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;font-family:var(--font)}
#content{max-width:900px;margin:0 auto;padding:22px 20px}
.tabs{display:flex;gap:2px;background:var(--white);border-radius:var(--radius);padding:4px;box-shadow:var(--shadow);margin-bottom:20px;flex-wrap:wrap}
.tab{flex:1;min-width:80px;padding:8px 6px;text-align:center;font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;border-radius:7px;transition:all .15s;border:none;background:none;font-family:var(--font)}
.tab.active{background:var(--accent);color:#fff}
.tab:hover:not(.active){background:#f1f5f9;color:#1e293b}
.card{background:var(--white);border-radius:var(--radius);padding:18px 20px;box-shadow:var(--shadow);margin-bottom:16px}
.card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px}
.card-header h3{font-size:15px;font-weight:700}
.stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;margin-bottom:16px}
.stat{background:var(--white);border-radius:var(--radius);padding:14px;box-shadow:var(--shadow);text-align:center}
.stat .val{font-size:24px;font-weight:800;margin-bottom:3px}
.stat .lbl{font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase}
.tbl-wrap{overflow-x:auto;border-radius:8px;border:1px solid var(--border)}
table{width:100%;border-collapse:collapse;font-size:13px}
table th{background:#f8fafc;padding:8px 12px;text-align:left;font-weight:600;font-size:11px;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)}
table td{padding:8px 12px;border-bottom:1px solid var(--border);vertical-align:middle}
table tr:last-child td{border-bottom:none}
tr.row-present td{background:var(--green-bg)}
tr.row-absent td{background:var(--red-bg)}
tr.row-late td{background:var(--orange-bg)}
tr.row-sat td{background:var(--sat-bg)}
tr.row-sun td{background:var(--sun-bg)}
tr.row-exc td{background:var(--blue-bg)}
.badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600}
.badge-green{background:var(--green-bg);color:var(--green)}
.badge-red{background:var(--red-bg);color:var(--red)}
.badge-orange{background:var(--orange-bg);color:var(--orange)}
.badge-blue{background:var(--blue-bg);color:var(--blue)}
.badge-gray{background:#f1f5f9;color:var(--muted)}
.badge-teal{background:var(--teal-bg);color:var(--teal)}
.badge-purple{background:#f5f3ff;color:#7c3aed}
.month-sel{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.month-sel select{padding:7px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;background:var(--white);color:var(--text);outline:none;font-family:var(--font)}
.month-sel select:focus{border-color:var(--accent)}
.btn{padding:7px 14px;border-radius:7px;border:none;cursor:pointer;font-size:13px;font-weight:600;font-family:var(--font);display:inline-flex;align-items:center;gap:6px}
.btn-primary{background:var(--accent);color:#fff}
.btn-secondary{background:#f1f5f9;color:var(--text);border:1.5px solid var(--border)}
.btn-teal{background:var(--teal);color:#fff}
.salary-hidden{text-align:center;padding:40px 30px;background:#f8fafc;border-radius:12px;color:var(--muted)}
.salary-hidden .icon{font-size:44px;margin-bottom:12px}
.remark-form{background:#f8fafc;border-radius:8px;padding:16px;margin-top:14px}
.remark-form h4{font-size:13px;font-weight:700;margin-bottom:12px}
.fg{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.fg label{font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase}
.fg input,.fg select,.fg textarea{padding:8px 11px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;font-family:var(--font);background:var(--white);color:var(--text);outline:none}
.fg input:focus,.fg select:focus,.fg textarea:focus{border-color:var(--accent)}
.fg textarea{resize:vertical;min-height:80px}
.loader{text-align:center;padding:40px;color:var(--muted)}
.spinner{width:30px;height:30px;border:3px solid var(--border);border-top-color:var(--accent);border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 12px}
.alert{padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px}
.alert-info{background:var(--blue-bg);color:#1d4ed8}
.alert-warn{background:var(--orange-bg);color:#92400e}
.alert-success{background:var(--green-bg);color:#14532d}
@keyframes spin{to{transform:rotate(360deg)}}
@media(max-width:600px){#content{padding:14px 12px}.login-box{padding:28px 22px}}
</style>
</head>
<body>
<div id="login-screen">
  <div class="login-box">
    <div class="logo">
      <img decoding="async" class="logo-img" src="https://naeladvertising.ae/wp-content/uploads/2026/04/cropped-Nael_Logo-02.png" alt="Nael Media">
      <h1>My Payroll</h1>
      <p>Nael Media — Employee Portal</p>
    </div>

    <div id="step-email">
      <div class="lfield">
        <label>Work Email</label>
        <input type="email" id="inp-email" placeholder="you@naelmedia.ae" autocomplete="email">
      </div>
      <div id="method-choice" style="display:flex;flex-direction:column;gap:8px">
        <button id="tab-otp-btn" style="width:100%;padding:11px;border-radius:7px;border:1.5px solid #334155;background:transparent;color:#e2e8f0;font-size:14px;font-weight:700;cursor:pointer;font-family:var(--font)">Email Code</button>
        <button id="tab-pwd-btn" style="width:100%;padding:11px;border-radius:7px;border:1.5px solid #334155;background:transparent;color:#e2e8f0;font-size:14px;font-weight:700;cursor:pointer;font-family:var(--font)">Password</button>
      </div>
      <div id="method-otp" style="display:none">
        <button class="lbtn" id="otp-btn">
          <div id="lspinner"></div>
          <span id="otp-btn-txt">Send Login Code</span>
        </button>
      </div>
      <div id="method-pwd" style="display:none">
        <div class="lfield">
          <label>Password</label>
          <input type="password" id="inp-pwd" placeholder="••••••••" autocomplete="current-password">
        </div>
        <button class="lbtn" id="pwd-btn">
          <div id="pwd-spinner" style="width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none"></div>
          <span id="pwd-btn-txt">Sign In</span>
        </button>
        <div class="lhint" style="margin-top:10px">
          <button id="forgot-btn" style="background:none;border:none;color:#6366f1;cursor:pointer;font-size:13px">Forgot password?</button>
        </div>
      </div>
      <div class="lerr" id="l-err1"></div>
    </div>

    <div id="step-otp" style="display:none">
      <div style="margin-bottom:16px">
        <button id="back-btn" style="background:none;border:none;color:#6366f1;cursor:pointer;font-size:13px;padding:0">← Back</button>
      </div>
      <div class="lhint" id="otp-hint" style="margin-bottom:14px;color:#94a3b8"></div>
      <div class="lfield">
        <label>6-digit Code</label>
        <input type="text" id="inp-otp" placeholder="123456" maxlength="6" autocomplete="one-time-code"
          style="letter-spacing:6px;font-size:22px;text-align:center"
          oninput="this.value=this.value.replace(/\D/g,'')">
      </div>
      <button class="lbtn" id="verify-btn">
        <div id="lspinner2" style="width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none"></div>
        <span id="verify-btn-txt">Sign In</span>
      </button>
      <div class="lerr" id="l-err2"></div>
    </div>

    <div id="step-set-password" style="display:none">
      <div id="set-pwd-hint" class="lhint" style="margin-bottom:16px;color:#94a3b8;text-align:left;line-height:1.6"></div>
      <div class="lfield">
        <label>New Password</label>
        <input type="password" id="inp-newpwd" placeholder="Min. 6 characters" autocomplete="new-password">
      </div>
      <div class="lfield">
        <label>Confirm Password</label>
        <input type="password" id="inp-confirmpwd" placeholder="Repeat password" autocomplete="new-password">
      </div>
      <button class="lbtn" id="setpwd-btn">
        <div id="setpwd-spinner" style="width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none"></div>
        <span id="setpwd-btn-txt">Save Password & Sign In</span>
      </button>
      <div class="lerr" id="l-err-setpwd"></div>
    </div>

    <div id="step-forgot" style="display:none">
      <div class="lhint" style="margin-bottom:14px;color:#94a3b8">Enter your email — we'll send a reset code.</div>
      <div class="lfield">
        <label>Work Email</label>
        <input type="email" id="inp-forgot-email" placeholder="you@naelmedia.ae" autocomplete="email">
      </div>
      <button class="lbtn" id="forgot-send-btn">
        <div id="forgot-spinner" style="width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none"></div>
        <span id="forgot-send-txt">Send Reset Code</span>
      </button>
      <div class="lerr" id="l-err-forgot"></div>
      <div class="lhint" style="margin-top:10px">
        <button id="back-to-login-btn" style="background:none;border:none;color:#6366f1;cursor:pointer;font-size:13px">← Back to Sign In</button>
      </div>
    </div>

    <div id="step-forgot-otp" style="display:none">
      <div class="lhint" id="forgot-otp-hint" style="margin-bottom:14px;color:#94a3b8"></div>
      <div class="lfield">
        <label>6-digit Code</label>
        <input type="text" id="inp-forgot-otp" placeholder="123456" maxlength="6" autocomplete="one-time-code"
          style="letter-spacing:6px;font-size:22px;text-align:center"
          oninput="this.value=this.value.replace(/\D/g,'')">
      </div>
      <div class="lfield" style="margin-top:12px">
        <label>New Password</label>
        <input type="password" id="inp-reset-pwd" placeholder="Min. 6 characters" autocomplete="new-password">
      </div>
      <div class="lfield">
        <label>Confirm Password</label>
        <input type="password" id="inp-reset-confirm" placeholder="Repeat password" autocomplete="new-password">
      </div>
      <button class="lbtn" id="reset-pwd-btn">
        <div id="reset-spinner" style="width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none"></div>
        <span id="reset-btn-txt">Reset Password & Sign In</span>
      </button>
      <div class="lerr" id="l-err-reset"></div>
    </div>

  </div>
</div>

<div id="topbar" style="display:none">
  <div class="brand">
    <img decoding="async" class="brand-logo" src="https://naeladvertising.ae/wp-content/uploads/2026/04/cropped-Nael_Logo-02.png" alt="Nael Media">
    <div>
      <h2 id="emp-name-display">Employee</h2>
      <p id="emp-role-display"></p>
    </div>
  </div>
  <button class="signout-btn" id="signout-btn">Sign Out</button>
</div>

<div id="content" style="display:none">
  <div class="tabs" id="tabs">
    <button class="tab active" data-tab="attendance">Attendance</button>
    <button class="tab" data-tab="saturday">Saturday</button>
    <button class="tab" data-tab="payroll">My Payroll</button>
    <button class="tab" data-tab="advances">Advances</button>
    <button class="tab" data-tab="deductions">Deductions</button>
    <button class="tab" data-tab="commissions">Commissions</button>
    <button class="tab" data-tab="reimbursements">Reimbursements</button>
    <button class="tab" data-tab="remarks">My Remarks</button>
  </div>
  <div id="tab-content"></div>
</div>

<script>
const API      = 'https://naeladvertising.ae/pms_api.php';
const TOKEN_KEY= 'emp_portal_token';
const NAME_KEY = 'emp_portal_name';
const ID_KEY   = 'emp_portal_id';

let empData = null;
let activeTab = 'attendance';
let currentEmail = '';

// ── UTILS ──────────────────────────────────────────────────────
const months_en=['January','February','March','April','May','June','July','August','September','October','November','December'];
const monthNums={January:1,February:2,March:3,April:4,May:5,June:6,July:7,August:8,September:9,October:10,November:11,December:12};
function getDaysInMonth(y,m){return new Date(y,m,0).getDate()}
function getWeekday(ds){return new Date(ds+'T00:00:00').getDay()}
function timeToMins(t){if(!t)return 0;const[h,m]=(t||'').split(':').map(Number);return h*60+m}
function esc(s){return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;')}
function toast(msg,type='success'){
  const el=document.createElement('div');
  el.style.cssText=`position:fixed;bottom:20px;right:20px;z-index:9999;padding:11px 18px;border-radius:8px;font-size:13px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,.15);`;
  el.style.background=type==='success'?'#16a34a':type==='error'?'#dc2626':'#0d9488';
  el.style.color='#fff'; el.textContent=msg;
  document.body.appendChild(el); setTimeout(()=>el.remove(),3000);
}
function fmtDate(ds){
  const d=new Date(ds+'T00:00:00');
  return d.toLocaleDateString('en-GB',{weekday:'short',day:'2-digit',month:'short',year:'numeric'});
}
function currentMonthName(){return months_en[new Date().getMonth()]}
function currentYear(){return new Date().getFullYear()}

// ── AUTH ───────────────────────────────────────────────────────
let _loginMethod = 'otp';

function setLoginMethod(m){
  _loginMethod=m;
  document.getElementById('method-choice').style.display='none';
  document.getElementById('method-otp').style.display = m==='otp' ? 'block' : 'none';
  document.getElementById('method-pwd').style.display = m==='pwd' ? 'block' : 'none';
  if(!document.getElementById('login-back-arrow')){
    const arrow=document.createElement('button');
    arrow.id='login-back-arrow';
    arrow.textContent='← Back';
    arrow.style.cssText='background:none;border:none;color:#6366f1;cursor:pointer;font-size:13px;padding:0;margin-bottom:14px;display:block';
    arrow.addEventListener('click', backToMethodChoice);
    const stepEmail=document.getElementById('step-email');
    stepEmail.insertBefore(arrow, stepEmail.firstChild);
  }
  if(m==='pwd') setTimeout(()=>document.getElementById('inp-pwd')?.focus(),50);
}

function backToMethodChoice(){
  _loginMethod='otp';
  document.getElementById('method-choice').style.display='flex';
  document.getElementById('method-otp').style.display='none';
  document.getElementById('method-pwd').style.display='none';
  document.getElementById('inp-pwd').value='';
  clearErr('l-err1');
  const arrow=document.getElementById('login-back-arrow');
  if(arrow) arrow.remove();
}

function showStep(step){
  ['step-email','step-otp','step-set-password','step-forgot','step-forgot-otp'].forEach(id=>{
    const el=document.getElementById(id);
    if(el) el.style.display='none';
  });
  const target=document.getElementById(step);
  if(target) target.style.display='block';
}

function showErr(id,msg){const el=document.getElementById(id);if(el){el.textContent=msg;el.classList.add('show');}}
function clearErr(id){const el=document.getElementById(id);if(el)el.classList.remove('show');}

async function requestOtp(){
  const email=document.getElementById('inp-email').value.trim();
  if(!email){showErr('l-err1','Please enter your email');return}
  const btn=document.getElementById('otp-btn'),sp=document.getElementById('lspinner'),txt=document.getElementById('otp-btn-txt');
  btn.disabled=true;if(sp)sp.style.display='block';if(txt)txt.textContent='Sending…';
  clearErr('l-err1');
  try{
    const r=await fetch(API+'?action=request_otp',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({email})});
    if(!r.ok) throw new Error('Server error: HTTP '+r.status);
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Failed');
    currentEmail=email;
    const hint=document.getElementById('otp-hint');
    if(hint) hint.textContent='Code sent to '+email+' — check your inbox';
    document.getElementById('verify-btn-txt').textContent='Sign In';
    showStep('step-otp');
    setTimeout(()=>document.getElementById('inp-otp')?.focus(),100);
  }catch(e){showErr('l-err1',e.message||'Connection failed');}
  btn.disabled=false;if(sp)sp.style.display='none';if(txt)txt.textContent='Send Login Code';
}

async function verifyOtp(){
  const otp=document.getElementById('inp-otp').value.trim();
  if(!otp||otp.length!==6){showErr('l-err2','Enter the 6-digit code');return}
  const btn=document.getElementById('verify-btn'),sp=document.getElementById('lspinner2'),txt=document.getElementById('verify-btn-txt');
  btn.disabled=true;sp.style.display='block';txt.textContent='Verifying…';
  clearErr('l-err2');
  try{
    const r=await fetch(`${API}?action=verify_otp`,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({email:currentEmail,otp})});
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Failed');
    sessionStorage.setItem(TOKEN_KEY,d.token);
    sessionStorage.setItem(NAME_KEY,d.empName);
    sessionStorage.setItem(ID_KEY,d.empId);
    if(d.needsPassword){
      const hint=document.getElementById('set-pwd-hint');
      if(hint) hint.textContent='Welcome '+d.empName+'! Please set a password for faster sign-in next time.';
      document.getElementById('setpwd-btn-txt').textContent='Save Password & Sign In';
      showStep('step-set-password');
    } else {
      launchApp(d.token,d.empName);
    }
  }catch(e){showErr('l-err2',e.message);}
  btn.disabled=false;sp.style.display='none';txt.textContent='Sign In';
}

async function setPassword(){
  const pwd=document.getElementById('inp-newpwd').value;
  const confirm=document.getElementById('inp-confirmpwd').value;
  clearErr('l-err-setpwd');
  if(pwd.length<6){showErr('l-err-setpwd','Password must be at least 6 characters');return}
  if(pwd!==confirm){showErr('l-err-setpwd','Passwords do not match');return}
  const btn=document.getElementById('setpwd-btn'),sp=document.getElementById('setpwd-spinner'),txt=document.getElementById('setpwd-btn-txt');
  btn.disabled=true;sp.style.display='block';txt.textContent='Saving…';
  const token=sessionStorage.getItem(TOKEN_KEY);
  try{
    const r=await fetch(`${API}?action=set_password`,{method:'POST',headers:{'X-PMS-Token':token,'Content-Type':'application/json'},body:JSON.stringify({password:pwd})});
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Failed');
    toast('Password saved! You can now sign in with it next time.');
    launchApp(token,sessionStorage.getItem(NAME_KEY));
  }catch(e){showErr('l-err-setpwd',e.message);}
  btn.disabled=false;sp.style.display='none';txt.textContent='Save Password & Sign In';
}

async function loginWithPassword(){
  const email=document.getElementById('inp-email').value.trim();
  const pwd=document.getElementById('inp-pwd').value;
  clearErr('l-err1');
  if(!email||!pwd){showErr('l-err1','Please enter your email and password');return}
  const btn=document.getElementById('pwd-btn'),sp=document.getElementById('pwd-spinner'),txt=document.getElementById('pwd-btn-txt');
  btn.disabled=true;sp.style.display='block';txt.textContent='Signing in…';
  try{
    const r=await fetch(`${API}?action=login_password`,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({email,password:pwd})});
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Incorrect email or password');
    sessionStorage.setItem(TOKEN_KEY,d.token);
    sessionStorage.setItem(NAME_KEY,d.empName);
    sessionStorage.setItem(ID_KEY,d.empId);
    launchApp(d.token,d.empName);
  }catch(e){showErr('l-err1',e.message);}
  btn.disabled=false;sp.style.display='none';txt.textContent='Sign In';
}

async function sendForgotOtp(){
  const email=document.getElementById('inp-forgot-email').value.trim();
  if(!email){showErr('l-err-forgot','Please enter your email');return}
  const btn=document.getElementById('forgot-send-btn'),sp=document.getElementById('forgot-spinner'),txt=document.getElementById('forgot-send-txt');
  btn.disabled=true;sp.style.display='block';txt.textContent='Sending…';
  clearErr('l-err-forgot');
  try{
    const r=await fetch(API+'?action=request_otp',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({email})});
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Failed');
    currentEmail=email;
    const hint=document.getElementById('forgot-otp-hint');
    if(hint) hint.textContent='Reset code sent to '+email+'. Enter it below and choose a new password.';
    showStep('step-forgot-otp');
    setTimeout(()=>document.getElementById('inp-forgot-otp')?.focus(),100);
  }catch(e){showErr('l-err-forgot',e.message);}
  btn.disabled=false;sp.style.display='none';txt.textContent='Send Reset Code';
}

async function resetPassword(){
  const otp=document.getElementById('inp-forgot-otp').value.trim();
  const pwd=document.getElementById('inp-reset-pwd').value;
  const confirm=document.getElementById('inp-reset-confirm').value;
  clearErr('l-err-reset');
  if(!otp||otp.length!==6){showErr('l-err-reset','Enter the 6-digit code');return}
  if(pwd.length<6){showErr('l-err-reset','Password must be at least 6 characters');return}
  if(pwd!==confirm){showErr('l-err-reset','Passwords do not match');return}
  const btn=document.getElementById('reset-pwd-btn'),sp=document.getElementById('reset-spinner'),txt=document.getElementById('reset-btn-txt');
  btn.disabled=true;sp.style.display='block';txt.textContent='Resetting…';
  try{
    const r=await fetch(`${API}?action=reset_password`,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({email:currentEmail,otp,password:pwd})});
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Failed');
    sessionStorage.setItem(TOKEN_KEY,d.token);
    sessionStorage.setItem(NAME_KEY,d.empName);
    sessionStorage.setItem(ID_KEY,d.empId);
    toast('Password reset! Signing you in…');
    launchApp(d.token,d.empName);
  }catch(e){showErr('l-err-reset',e.message);}
  btn.disabled=false;sp.style.display='none';txt.textContent='Reset Password & Sign In';
}

function backToEmail(){
  showStep('step-email');
  document.getElementById('method-choice').style.display='flex';
  document.getElementById('method-otp').style.display='none';
  document.getElementById('method-pwd').style.display='none';
  const arrow=document.getElementById('login-back-arrow');
  if(arrow) arrow.remove();
  clearErr('l-err1');clearErr('l-err2');
  document.getElementById('inp-otp').value='';
}

function signOut(){
  sessionStorage.removeItem(TOKEN_KEY);sessionStorage.removeItem(NAME_KEY);sessionStorage.removeItem(ID_KEY);
  empData=null;
  document.getElementById('topbar').style.display='none';
  document.getElementById('content').style.display='none';
  document.getElementById('login-screen').classList.remove('hidden');
  showStep('step-email');
  document.getElementById('method-choice').style.display='flex';
  document.getElementById('method-otp').style.display='none';
  document.getElementById('method-pwd').style.display='none';
  const arrow=document.getElementById('login-back-arrow');
  if(arrow) arrow.remove();
  document.getElementById('inp-email').value='';
  document.getElementById('inp-pwd').value='';
  document.getElementById('inp-otp').value='';
  clearErr('l-err1');clearErr('l-err2');
}

async function launchApp(token, name){
  document.getElementById('login-screen').classList.add('hidden');
  document.getElementById('topbar').style.display='flex';
  document.getElementById('content').style.display='block';
  document.getElementById('emp-name-display').textContent=name;
  document.getElementById('tab-content').innerHTML=`<div class="loader"><div class="spinner"></div><p>Loading your data…</p></div>`;
  try{
    const r=await fetch(`${API}?action=my_data`,{headers:{'X-PMS-Token':token}});
    const d=await r.json();
    if(!d.ok) throw new Error(d.error||'Failed');
    empData=d;
    document.getElementById('emp-role-display').textContent=`${d.employee.Role} — ${d.employee.Department}`;
    showTab('attendance');
  }catch(e){
    document.getElementById('tab-content').innerHTML=`<div class="card"><div class="alert alert-warn">⚠️ ${esc(e.message)}</div></div>`;
  }
}

function showTab(tab){
  activeTab=tab;
  document.querySelectorAll('.tab').forEach(b=>{
    b.classList.toggle('active', b.dataset.tab===tab);
  });
  const fn={attendance:showAttendance,saturday:showSaturday,payroll:showPayroll,advances:showAdvances,
             deductions:showDeductions,commissions:showCommissions,reimbursements:showReimbursements,remarks:showMyRemarks};
  if(fn[tab]) fn[tab]();
}

function monthSelector(selMonth, selYear, onload){
  const mOpts=months_en.map(m=>`<option ${m===selMonth?'selected':''}>${m}</option>`).join('');
  const curYr=new Date().getFullYear(); let yOpts=''; for(let y=2024;y<=curYr;y++) yOpts+=`<option ${y==selYear?'selected':''}>${y}</option>`;
  return `<div class="month-sel">
    <select id="sel-month">${mOpts}</select>
    <select id="sel-year">${yOpts}</select>
    <button class="btn btn-primary btn-sm" onclick="${onload}()" style="padding:7px 14px">Load</button>
  </div>`;
}

// ── ATTENDANCE ─────────────────────────────────────────────────
function showAttendance(){
  if(!empData){return}
  const selM=currentMonthName(), selY=currentYear();
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>Attendance</h3>${monthSelector(selM,selY,'loadAttendance')}</div>
      <div id="att-body"></div>
    </div>`;
  loadAttendance();
  setTimeout(checkAndShowSaturdayBanner, 100);
}

function loadAttendance(){
  if(!empData) return;
  const month=document.getElementById('sel-month')?.value||currentMonthName();
  const year=parseInt(document.getElementById('sel-year')?.value||currentYear());
  const mn=monthNums[month];
  const days=getDaysInMonth(year,mn);
  const att=empData.attendance||{};
  const excMap={};
  (empData.exceptions||[]).filter(x=>x.Date.startsWith(`${year}-${String(mn).padStart(2,'0')}`)).forEach(x=>{excMap[x.Date]=x.Reason;});
  const excSet=new Set(Object.keys(excMap));
  const WORK_M=9*60, LATE_C=10*60;
  function _ded(ci,co){
    const ciM=timeToMins(ci),coM=co?timeToMins(co):null;
    const expEnd=ciM+WORK_M;
    const lateMin=Math.max(0,ciM-LATE_C);
    const earlyMin=(coM!==null&&coM<expEnd)?Math.max(0,expEnd-coM):0;
    const eh=String(Math.floor(expEnd/60)).padStart(2,'0'),em=String(expEnd%60).padStart(2,'0');
    return{lateMin,earlyMin,total:lateMin+earlyMin,expEnd:`${eh}:${em}`};
  }
  const today=new Date(),todayStr=today.toISOString().split('T')[0];
  const isCurrentMonth=(year===today.getFullYear()&&mn===today.getMonth()+1);
  const maxDay=isCurrentMonth?today.getDate():days;
  let presentN=0,absentN=0,lateN=0,rows='';
  for(let d=1;d<=maxDay;d++){
    const ds=`${year}-${String(mn).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
    const wd=getWeekday(ds),rec=att[ds],ci=rec?.CheckIn||'',co=rec?.CheckOut||'';
    if(wd===6){rows+=`<tr class="row-sat"><td>${fmtDate(ds)}</td><td>—</td><td>—</td><td>—</td><td><span class="badge badge-orange">Saturday</span></td></tr>`;continue}
    if(wd===0){rows+=`<tr class="row-sun"><td>${fmtDate(ds)}</td><td>—</td><td>—</td><td>—</td><td><span class="badge badge-gray">Sunday (Off)</span></td></tr>`;continue}
    if(excSet.has(ds)){rows+=`<tr class="row-exc"><td>${fmtDate(ds)}</td><td>—</td><td>—</td><td>—</td><td><span class="badge badge-blue">Exception: ${esc(excMap[ds]||'')}</span></td></tr>`;continue}
    if(!ci&&!co){absentN++;rows+=`<tr class="row-absent"><td>${fmtDate(ds)}</td><td>—</td><td>—</td><td>—</td><td><span class="badge badge-red">Absent</span></td></tr>`;continue;}
    const {lateMin,earlyMin,total:totalMin,expEnd}=_ded(ci,co);
    if(totalMin>0){
      lateN++;
      const parts=[];
      if(lateMin>0) parts.push(`Late ${lateMin}m (after 10:00 AM)`);
      if(earlyMin>0) parts.push(`Left early ${earlyMin}m (before ${expEnd})`);
      rows+=`<tr class="row-late"><td>${fmtDate(ds)}</td><td>${ci}</td><td>${co||'—'}</td><td style="color:var(--orange);font-size:12px">${parts.join(' + ')}</td><td><span class="badge badge-orange">Late/Early</span></td></tr>`;
    } else {
      presentN++;
      rows+=`<tr class="row-present"><td>${fmtDate(ds)}</td><td>${ci}</td><td>${co||'—'}</td><td style="font-size:11px;color:var(--green)">Out by ${expEnd}</td><td><span class="badge badge-green">Present ✓</span></td></tr>`;
    }
  }
  document.getElementById('att-body').innerHTML=`
    <div class="stat-grid" style="margin-bottom:14px">
      <div class="stat"><div class="val" style="color:var(--green)">${presentN}</div><div class="lbl">Present</div></div>
      <div class="stat"><div class="val" style="color:var(--red)">${absentN}</div><div class="lbl">Absent</div></div>
      <div class="stat"><div class="val" style="color:var(--orange)">${lateN}</div><div class="lbl">Late / Early leave</div></div>
    </div>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Date</th><th>Check-in</th><th>Check-out</th><th>Details</th><th>Status</th></tr></thead>
      <tbody>${rows}</tbody>
    </table></div>`;
}

// ── PAYROLL — always locked, coming soon ──────────────────────
function showPayroll(){
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>My Payroll</h3></div>
      <div class="salary-hidden">
        <div class="icon">⚙️</div>
        <p style="font-weight:700;font-size:16px;margin-bottom:8px;color:var(--text)">We're working on it</p>
        <p style="font-size:13px;color:var(--muted);line-height:1.6">Your payroll summary will be available here soon.<br>In the meantime, please contact HR for any salary queries.</p>
      </div>
    </div>`;
}

// ── ADVANCES ───────────────────────────────────────────────────
function showAdvances(){
  if(!empData) return;
  const adv=empData.advances||[];
  const total=adv.reduce((s,a)=>s+parseFloat(a.Amount||0),0);
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>💳 My Advances</h3><span class="badge badge-orange">Total: AED ${total.toFixed(2)}</span></div>
      ${!adv.length?`<p style="color:var(--muted);text-align:center;padding:20px">No advances recorded.</p>`:
      `<div class="tbl-wrap"><table>
        <thead><tr><th>#</th><th>Date</th><th>Amount</th><th>Reason</th><th>Notes</th></tr></thead>
        <tbody>${adv.map(a=>`<tr><td>${esc(a.AdvanceID)}</td><td>${esc(a.Date)}</td>
          <td style="font-weight:700;color:var(--orange)">AED ${parseFloat(a.Amount||0).toFixed(2)}</td>
          <td>${esc(a.Reason)}</td><td style="color:var(--muted)">${esc(a.Notes||'')}</td></tr>`).join('')}
        </tbody></table></div>`}
    </div>`;
}

// ── DEDUCTIONS ─────────────────────────────────────────────────
function showDeductions(){
  if(!empData) return;
  const deds=empData.deductions||[];
  const catLabels={parking_card:'Parking Card',uniform:'Uniform / Equipment',loan:'Loan Repayment',damage:'Damage / Loss',absence_pen:'Absence Penalty',other:'Other'};
  const total=deds.reduce((s,d)=>s+parseFloat(d.Amount||0),0);
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>✂️ My Deductions</h3><span class="badge badge-red">Total: AED ${total.toFixed(2)}</span></div>
      ${!deds.length?`<p style="color:var(--muted);text-align:center;padding:20px">No deductions recorded.</p>`:
      `<div class="tbl-wrap"><table>
        <thead><tr><th>#</th><th>Date</th><th>Category</th><th>Amount</th><th>Reason</th></tr></thead>
        <tbody>${deds.map(d=>`<tr><td>${esc(d.DedID)}</td><td>${esc(d.Date)}</td>
          <td><span class="badge badge-red">${catLabels[d.Category]||d.Category}</span></td>
          <td style="font-weight:700;color:var(--red)">AED ${parseFloat(d.Amount||0).toFixed(2)}</td>
          <td>${esc(d.Reason||'')}</td></tr>`).join('')}
        </tbody></table></div>`}
    </div>`;
}

// ── REIMBURSEMENTS ─────────────────────────────────────────────
function showReimbursements(){
  if(!empData) return;
  const reimbs=empData.reimbursements||[];
  const catLabels={fuel:'Fuel',parking:'Parking',supplies:'Office Supplies',meals:'Meals / Entertainment',transport:'Transport / Taxi',maintenance:'Maintenance',other:'Other'};
  const statusBadge={pending:'badge-orange',approved:'badge-teal',rejected:'badge-red'};
  const total=reimbs.reduce((s,r)=>s+parseFloat(r.Amount||0),0);
  const approvedTotal=reimbs.filter(r=>r.Status==='approved').reduce((s,r)=>s+parseFloat(r.Amount||0),0);
  const today=new Date().toISOString().split('T')[0];
  const catOptions=Object.entries(catLabels).map(([k,v])=>`<option value="${k}">${v}</option>`).join('');
  let rows='';
  if(reimbs.length){
    reimbs.slice().reverse().forEach(r=>{
      const receiptCell=(r.Receipt&&/^https?:\/\//.test(r.Receipt))?`<a href="${esc(r.Receipt)}" target="_blank" rel="noopener" style="color:var(--accent);font-weight:600">📎 View</a>`:esc(r.Receipt||'—');
      rows+=`<tr>
        <td>${esc(r.ReimbID)}</td><td>${esc(r.Date)}</td>
        <td><span class="badge badge-teal">${catLabels[r.Category]||r.Category}</span></td>
        <td style="font-size:12px">${esc(r.Description||'—')}</td>
        <td style="font-weight:700;color:var(--teal)">AED ${parseFloat(r.Amount||0).toFixed(2)}</td>
        <td>${receiptCell}</td>
        <td><span class="badge ${statusBadge[r.Status]||'badge-gray'}">${r.Status}</span></td>
        <td>${r.AdminNote?`<div style="background:#fef3c7;border-left:3px solid #f59e0b;border-radius:6px;padding:7px 10px;color:#78350f;font-size:12px;font-weight:600">💬 ${esc(r.AdminNote)}</div>`:'<span style="color:var(--muted);font-size:12px">—</span>'}</td>
      </tr>`;
    });
  }
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>🧾 Submit a Reimbursement</h3></div>
      <div class="alert alert-info" style="margin-bottom:14px">Fill in the expense, attach a photo or PDF of the receipt, and submit. HR will review and approve it — only approved reimbursements are added to your salary.</div>
      <div class="remark-form">
        <div class="fg"><label>Category</label>
          <select id="rb-cat" onchange="updateReimbCatHint(this.value)">${catOptions}</select>
        </div>
        <div id="rb-cat-hint" style="display:none;background:#fef3c7;border:1.5px solid #f59e0b;border-radius:8px;padding:11px 14px;font-size:13px;color:#78350f;margin-top:-4px;margin-bottom:4px">
          ⛽ <b>Fuel Policy:</b> The tax invoice <b>must be issued in the company car name — Nael Advertising Expert League FZCO</b>. Receipts issued under your personal name or a personal car will not be approved unless the use of another vehicle was pre-approved by management. Please ask the petrol station to issue the invoice to the company car before you pay.
        </div>
        <div class="fg"><label>Date of expense</label><input type="date" id="rb-date" max="${today}" value="${today}"></div>
        <div class="fg"><label>Amount (AED)</label><input type="number" id="rb-amount" step="0.01" min="0.01" placeholder="0.00"></div>
        <div class="fg"><label>Description</label><input type="text" id="rb-desc" placeholder="e.g. Fuel for client visit to Sharjah"></div>
        <div class="fg"><label>Receipt (photo or PDF — optional)</label>
          <input type="file" id="rb-receipt" accept="image/*,application/pdf">
          <small style="color:var(--muted);font-size:11px">Max 5 MB. A clear photo of the receipt helps HR approve faster.</small>
        </div>
        <button class="btn btn-teal" id="submit-reimb-btn">Submit for Approval</button>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3>🧾 My Reimbursements</h3>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          <span class="badge badge-teal">Approved: AED ${approvedTotal.toFixed(2)}</span>
          <span class="badge badge-gray">Total: AED ${total.toFixed(2)}</span>
        </div>
      </div>
      ${!reimbs.length?`<p style="color:var(--muted);text-align:center;padding:20px">No reimbursements yet. Submit one above.</p>`:
      `<div class="tbl-wrap"><table>
        <thead><tr><th>#</th><th>Date</th><th>Category</th><th>Description</th><th>Amount</th><th>Receipt</th><th>Status</th><th>HR Note</th></tr></thead>
        <tbody>${rows}</tbody>
      </table></div>`}
    </div>`;
  updateReimbCatHint(document.getElementById('rb-cat')?.value||'');
}

function updateReimbCatHint(val){
  const hint=document.getElementById('rb-cat-hint');
  if(!hint) return;
  hint.style.display=val==='fuel'?'block':'none';
}

function submitReimbursement(btn){
  const token=sessionStorage.getItem(TOKEN_KEY);
  const cat=document.getElementById('rb-cat').value;
  const date=document.getElementById('rb-date').value;
  const amount=parseFloat(document.getElementById('rb-amount').value);
  const desc=document.getElementById('rb-desc').value.trim();
  const fileInput=document.getElementById('rb-receipt');
  const file=(fileInput&&fileInput.files)?fileInput.files[0]:null;
  if(!date||!cat||!amount||amount<=0){toast('Please fill category, date and a valid amount','error');return;}
  if(file&&file.size>5*1024*1024){toast('Receipt is too large (max 5 MB)','error');return;}
  const doSend=(receiptData)=>{
    if(btn){btn.disabled=true;btn.textContent='Submitting…';}
    fetch(API+'?action=submit_reimbursement',{
      method:'POST',headers:{'X-PMS-Token':token,'Content-Type':'application/json'},
      body:JSON.stringify({date,category:cat,amount,description:desc,receiptData:receiptData||''})
    }).then(r=>r.json()).then(d=>{
      if(!d.ok) throw new Error(d.error||'Failed');
      if(d.reimbursement){(empData.reimbursements=empData.reimbursements||[]).push(d.reimbursement);}
      toast('✅ Reimbursement submitted for approval','success');
      showReimbursements();
    }).catch(e=>{
      toast(e.message||'Error','error');
      if(btn){btn.disabled=false;btn.textContent='Submit for Approval';}
    });
  };
  if(file){const reader=new FileReader();reader.onload=()=>doSend(reader.result);reader.onerror=()=>toast('Could not read the receipt file','error');reader.readAsDataURL(file);}
  else doSend('');
}

// ── COMMISSIONS ────────────────────────────────────────────────
function showCommissions(){
  if(!empData) return;
  const emp=empData.employee;
  const splitsByDeal={};
  (empData.splits||[]).forEach(s=>{if(!splitsByDeal[s.DealID])splitsByDeal[s.DealID]=[];splitsByDeal[s.DealID].push(s)});
  const rows=(empData.deals||[]).map(d=>{
    const src=(d.Source||'').toLowerCase(),pct=src==='lead'?0.05:src==='outside'||src==='renewal'?0.10:0;
    const total=parseFloat(d.Amount||0)*pct,sps=splitsByDeal[d.DealID]||[];
    let myPct=100,myComm=total;
    if(sps.length){const mySplit=sps.find(s=>s.EmployeeID==emp.ID);myPct=mySplit?parseFloat(mySplit.SharePercent||0):0;myComm=total*(myPct/100);}
    return `<tr><td>${esc(d.DealID)}</td><td>${esc(d.Date)}</td><td><b>${esc(d.Client)}</b></td>
      <td>AED ${parseFloat(d.Amount||0).toLocaleString()}</td>
      <td>${(pct*100).toFixed(0)}%</td><td>${myPct}%</td>
      <td style="font-weight:700;color:var(--green)">AED ${myComm.toFixed(2)}</td></tr>`;
  });
  const totalComm=(empData.deals||[]).reduce((s,d)=>{
    const src=(d.Source||'').toLowerCase(),pct=src==='lead'?0.05:src==='outside'||src==='renewal'?0.10:0;
    const total=parseFloat(d.Amount||0)*pct,sps=splitsByDeal[d.DealID]||[];
    if(!sps.length&&d.PrimaryEmpID==emp.ID)return s+total;
    const my=sps.find(sp=>sp.EmployeeID==emp.ID);
    return s+(my?total*(parseFloat(my.SharePercent||0)/100):0);
  },0);
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>🤝 My Commissions</h3><span class="badge badge-green">Total: AED ${totalComm.toFixed(2)}</span></div>
      ${!rows.length?`<p style="color:var(--muted);text-align:center;padding:20px">No commissions recorded.</p>`:
      `<div class="tbl-wrap"><table>
        <thead><tr><th>#</th><th>Date</th><th>Client</th><th>Deal Value</th><th>Base %</th><th>My Split</th><th>My Commission</th></tr></thead>
        <tbody>${rows.join('')}</tbody>
      </table></div>`}
    </div>`;
}

// ── SATURDAY ──────────────────────────────────────────────────
function upcomingSaturdayStr(){
  const d=new Date(),add=(6-d.getDay()+7)%7;
  d.setDate(d.getDate()+add);
  return d.toISOString().split('T')[0];
}

async function showSaturday(){
  if(!empData) return;
  const token=sessionStorage.getItem(TOKEN_KEY);
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>📆 Saturday Availability</h3></div>
      <div id="sat-status-area"><div class="loader"><div class="spinner"></div></div></div>
    </div>
    <div class="card">
      <div class="card-header"><h3>History</h3></div>
      <div id="sat-history-area"></div>
    </div>`;
  try{
    const r=await fetch(API+'?action=my_saturday',{headers:{'X-PMS-Token':token}});
    const d=await r.json();
    const records=d.records||[];
    renderSaturdayStatus(records);
    renderSaturdayHistory(records);
  }catch(e){
    const a=document.getElementById('sat-status-area');
    if(a) a.innerHTML=`<div class="alert alert-warn">Could not load Saturday data: ${esc(e.message)}</div>`;
  }
}

function renderSaturdayStatus(records){
  const area=document.getElementById('sat-status-area');
  if(!area) return;
  const now=new Date(),isSat=now.getDay()===6,todayStr=now.toISOString().split('T')[0];
  const hour=now.getHours(),windowOpen=hour>=9&&hour<11,tooEarly=hour<9;
  const submittedToday=records.find(x=>x.date===todayStr);
  let html='';
  if(isSat){
    if(submittedToday){
      html=`<div class="alert alert-success" style="font-size:14px">✅ <b>You're marked available for today (${fmtDate(todayStr)}).</b><br><span style="font-size:12px">Submitted at ${esc(submittedToday.submittedAt)} — this Saturday counts as a paid day.</span></div>`;
    } else if(tooEarly){
      html=`<div class="alert alert-info" style="font-size:14px">🕘 <b>The availability window opens at 9:00 AM.</b><br><span style="font-size:12px">Come back between <b>9:00 AM and 11:00 AM</b> to mark yourself available for remote work.</span></div>`;
    } else if(windowOpen){
      html=`<div class="alert alert-info" style="font-size:14px">📅 <b>Today is Saturday — window is open!</b> Mark yourself available before <b>11:00 AM</b>.<br><span style="font-size:12px">If you don't, the day is automatically deducted from your salary.</span></div>
      <button class="btn btn-primary" id="sat-avail-btn" style="padding:11px 22px;font-size:14px;margin-top:10px">✋ I'm Available Today</button>`;
    } else {
      html=`<div class="alert alert-warn" style="font-size:14px">❌ <b>The 11:00 AM deadline has passed.</b><br><span style="font-size:12px">The window was open from 9:00 AM to 11:00 AM. Today will be deducted from your salary.</span></div>`;
    }
  } else {
    const next=upcomingSaturdayStr();
    html=`<div class="alert alert-info" style="font-size:14px">📆 <b>Next Saturday: ${fmtDate(next)}</b><br><span style="font-size:12px">Open this tab between <b>9:00 AM and 11:00 AM</b> and tap <b>I'm Available</b> so we can assign you work. Miss the deadline and the day is deducted automatically.</span></div>`;
  }
  area.innerHTML=html;
}

function renderSaturdayHistory(records){
  const area=document.getElementById('sat-history-area');
  if(!area) return;
  if(!records.length){area.innerHTML=`<p style="color:var(--muted);font-size:13px;text-align:center;padding:14px">No Saturday submissions yet.</p>`;return;}
  area.innerHTML=`<div class="tbl-wrap"><table>
    <thead><tr><th>Saturday</th><th>Submitted At</th><th>Status</th></tr></thead>
    <tbody>${records.map(r=>`<tr class="row-present"><td><b>${fmtDate(r.date)}</b></td><td>${esc(r.submittedAt)}</td><td><span class="badge badge-green">Available — Paid</span></td></tr>`).join('')}</tbody>
  </table></div>`;
}

async function checkAndShowSaturdayBanner(){
  const now=new Date();
  if(now.getDay()!==6) return;
  const token=sessionStorage.getItem(TOKEN_KEY);
  const hour=now.getHours(),windowOpen=hour>=9&&hour<11,tooEarly=hour<9,todayStr=now.toISOString().split('T')[0];
  try{
    const r=await fetch(API+'?action=my_saturday',{headers:{'X-PMS-Token':token}});
    const d=await r.json();
    const records=d.records||[],todayRec=records.find(x=>x.date===todayStr);
    const banner=document.createElement('div');banner.id='sat-banner';
    if(todayRec){
      banner.style.cssText='background:#dcfce7;border:2px solid #16a34a;border-radius:10px;padding:14px 18px;margin-bottom:16px';
      banner.innerHTML='<div style="font-weight:700;font-size:14px;color:#14532d">✅ Saturday availability confirmed!</div><div style="font-size:12px;color:#166534;margin-top:3px">Submitted at '+esc(todayRec.submittedAt)+' — this Saturday is counted as paid.</div>';
    } else if(tooEarly){
      banner.style.cssText='background:#f1f5f9;border:2px solid #94a3b8;border-radius:10px;padding:14px 18px;margin-bottom:16px';
      banner.innerHTML='<div style="font-weight:700;font-size:14px;color:#475569">🕘 Availability window opens at 9:00 AM</div><div style="font-size:12px;color:#64748b;margin-top:3px">Come back between 9:00 AM and 11:00 AM to mark yourself available.</div>';
    } else if(windowOpen){
      banner.style.cssText='background:#dbeafe;border:2px solid #2563eb;border-radius:10px;padding:14px 18px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px';
      banner.innerHTML='<div><div style="font-weight:700;font-size:14px;color:#1e3a8a">📅 Today is Saturday — mark your availability before 11 AM!</div><div style="font-size:12px;color:#1d4ed8;margin-top:3px">Window: 9:00 AM – 11:00 AM. Not submitting = full day deducted.</div></div><button id="sat-avail-btn" style="background:#2563eb;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap">✋ I&#39;m Available Today</button>';
    } else {
      banner.style.cssText='background:#fee2e2;border:2px solid #dc2626;border-radius:10px;padding:14px 18px;margin-bottom:16px';
      banner.innerHTML='<div style="font-weight:700;font-size:14px;color:#7f1d1d">❌ Saturday deadline passed</div><div style="font-size:12px;color:#991b1b;margin-top:3px">The window (9:00 AM – 11:00 AM) is now closed. This Saturday will be deducted from your salary.</div>';
    }
    const tc=document.getElementById('tab-content');
    if(tc) tc.insertBefore(banner,tc.firstChild);
  }catch(e){console.log('Saturday banner error:',e);}
}

function submitSaturdayAvailability(btn){
  const token=sessionStorage.getItem(TOKEN_KEY);
  if(btn){btn.disabled=true;btn.textContent='Submitting…';}
  fetch(API+'?action=submit_saturday',{method:'POST',headers:{'X-PMS-Token':token,'Content-Type':'application/json'},body:JSON.stringify({})})
    .then(r=>r.json()).then(d=>{
      if(!d.ok) throw new Error(d.error||'Failed');
      toast('✅ Availability confirmed! This Saturday is paid.','success');
      if(activeTab==='saturday') showSaturday();
      else{const banner=document.getElementById('sat-banner');if(banner)banner.remove();checkAndShowSaturdayBanner();}
    }).catch(e=>{
      toast(e.message||'Error','error');
      if(btn){btn.disabled=false;btn.textContent="✋ I'm Available Today";}
    });
}

// ── REMARKS ────────────────────────────────────────────────────
async function showMyRemarks(){
  if(!empData) return;
  const token=sessionStorage.getItem(TOKEN_KEY);
  document.getElementById('tab-content').innerHTML=`
    <div class="card">
      <div class="card-header"><h3>My Remarks & Disputes</h3></div>
      <div class="remark-form">
        <h4>Submit a new remark</h4>
        <div class="fg"><label>Date (the day you're disputing)</label>
          <input type="date" id="rmk-date" max="${new Date().toISOString().split('T')[0]}">
          <small style="color:var(--muted);font-size:11px">Only current and previous month allowed</small>
        </div>
        <div class="fg"><label>Explanation</label>
          <textarea id="rmk-text" placeholder="e.g. I was at a client site on this day and couldn't check in on the device. Please add an exception." rows="3"></textarea>
        </div>
        <div class="fg"><label>Supporting Document <span style="font-weight:400;text-transform:none;font-size:11px;color:var(--muted)">(optional — medical certificate, screenshot, etc.)</span></label>
          <input type="file" id="rmk-file" accept="image/*,application/pdf,.doc,.docx">
          <small style="color:var(--muted);font-size:11px">Max 5 MB. Accepted: images, PDF, Word documents.</small>
        </div>
        <button class="btn btn-primary" id="submit-remark-btn">Submit Remark</button>
      </div>
      <div id="my-remarks-list" style="margin-top:16px"><div class="loader"><div class="spinner"></div></div></div>
    </div>`;
  const _n=new Date(),_prev=new Date(_n.getFullYear(),_n.getMonth()-1,1);
  const rmkDate=document.getElementById('rmk-date');
  if(rmkDate) rmkDate.min=_prev.toISOString().split('T')[0];
  try{
    const r=await fetch(`${API}?action=my_remarks`,{headers:{'X-PMS-Token':token}});
    const d=await r.json();
    const remarks=d.remarks||[];
    const statusBadge={pending:'badge-orange',opened:'badge-blue',processing:'badge-purple',approved:'badge-green',refused:'badge-red'};
    const statusLabel={pending:'Pending',opened:'Opened — HR is reviewing',processing:'Processing',approved:'Approved',refused:'Refused'};
    document.getElementById('my-remarks-list').innerHTML=!remarks.length?
      `<p style="color:var(--muted);font-size:13px">No remarks submitted yet.</p>`:
      `<h4 style="font-size:13px;font-weight:700;margin-bottom:10px">Your submitted remarks:</h4>
      <div class="tbl-wrap"><table>
        <thead><tr><th>Date</th><th>Remark</th><th>Document</th><th>Submitted</th><th>Status</th><th>HR Note</th><th></th></tr></thead>
        <tbody>${remarks.reverse().map(r=>`<tr>
          <td><b>${esc(r.date)}</b></td>
          <td style="max-width:220px;white-space:pre-wrap;font-size:12px">${esc(r.remark)}</td>
          <td>${r.fileUrl?`<a href="${esc(r.fileUrl)}" target="_blank" rel="noopener" style="color:var(--accent);font-weight:600;font-size:12px">📎 View</a>`:'<span style="color:var(--muted);font-size:12px">—</span>'}</td>
          <td style="font-size:11px;color:var(--muted)">${esc(r.submittedAt||'')}</td>
          <td><span class="badge ${statusBadge[r.status]||'badge-gray'}">${statusLabel[r.status]||r.status}</span></td>
          <td style="font-size:12px">${r.adminNote?`<div style="background:#fef3c7;border-left:3px solid #f59e0b;border-radius:5px;padding:5px 8px;color:#78350f;font-weight:600">💬 ${esc(r.adminNote)}</div>`:'<span style="color:var(--muted)">—</span>'}</td>
          <td>${['pending','opened'].includes(r.status)?`<button class="btn btn-secondary" style="padding:4px 10px;font-size:11px" onclick="editRemark('${esc(r.id)}','${esc(r.date)}',\`${esc(r.remark)}\`)">✏️ Edit</button>`:''}</td>
        </tr>`).join('')}</tbody>
      </table></div>`;
  }catch(e){
    document.getElementById('my-remarks-list').innerHTML=`<p style="color:var(--red);font-size:13px">Could not load remarks.</p>`;
  }
}

async function submitRemark(){
  const token=sessionStorage.getItem(TOKEN_KEY);
  const date=document.getElementById('rmk-date').value;
  const remark=document.getElementById('rmk-text').value.trim();
  const fileInput=document.getElementById('rmk-file');
  const file=fileInput&&fileInput.files?fileInput.files[0]:null;
  if(!date||!remark){toast('Please fill both fields','error');return}
  if(file&&file.size>5*1024*1024){toast('File too large (max 5 MB)','error');return}
  const editId=document.getElementById('rmk-edit-id')?.value||'';
  const action=editId?'update_remark_emp':'submit_remark';
  const doSubmit=async(fileData)=>{
    const btn=document.getElementById('submit-remark-btn');
    if(btn){btn.disabled=true;btn.textContent='Submitting…';}
    try{
      const r=await fetch(`${API}?action=${action}`,{method:'POST',headers:{'X-PMS-Token':token,'Content-Type':'application/json'},body:JSON.stringify({id:editId,date,remark,fileData:fileData||''})});
      const d=await r.json();
      if(!d.ok) throw new Error(d.error);
      toast(editId?'Remark updated!':'Remark submitted! HR will review it.');
      document.getElementById('rmk-date').value='';
      document.getElementById('rmk-text').value='';
      if(fileInput) fileInput.value='';
      showMyRemarks();
    }catch(e){
      toast(e.message,'error');
      if(btn){btn.disabled=false;btn.textContent=editId?'Update Remark':'Submit Remark';}
    }
  };
  if(file){const reader=new FileReader();reader.onload=()=>doSubmit(reader.result);reader.onerror=()=>toast('Could not read the file','error');reader.readAsDataURL(file);}
  else doSubmit('');
}

function editRemark(id,date,remark){
  const formEl=document.querySelector('.remark-form');
  if(formEl) formEl.scrollIntoView({behavior:'smooth',block:'start'});
  const dateEl=document.getElementById('rmk-date'),textEl=document.getElementById('rmk-text'),fileEl=document.getElementById('rmk-file');
  if(dateEl) dateEl.value=date;if(textEl) textEl.value=remark;if(fileEl) fileEl.value='';
  let hiddenId=document.getElementById('rmk-edit-id');
  if(!hiddenId){hiddenId=document.createElement('input');hiddenId.type='hidden';hiddenId.id='rmk-edit-id';formEl?.appendChild(hiddenId);}
  hiddenId.value=id;
  const btn=document.getElementById('submit-remark-btn');
  if(btn){btn.textContent='Update Remark';btn.style.background='var(--orange)';}
  let cancelEl=document.getElementById('rmk-edit-cancel');
  if(!cancelEl){cancelEl=document.createElement('button');cancelEl.id='rmk-edit-cancel';cancelEl.className='btn btn-secondary';cancelEl.style.cssText='margin-left:8px;padding:8px 14px;font-size:13px';cancelEl.textContent='Cancel';cancelEl.onclick=cancelEditRemark;btn?.parentNode?.insertBefore(cancelEl,btn.nextSibling);}
  if(formEl){formEl.style.border='2px solid var(--orange)';formEl.style.borderRadius='8px';formEl.style.padding='16px';}
  const fileHint=document.getElementById('rmk-file-edit-hint');
  if(!fileHint){const hint=document.createElement('small');hint.id='rmk-file-edit-hint';hint.style.cssText='color:var(--orange);font-size:11px;display:block;margin-top:3px';hint.textContent='Upload a new file to replace the existing one, or leave empty to keep it.';document.getElementById('rmk-file')?.parentNode?.appendChild(hint);}
}

function cancelEditRemark(){
  document.getElementById('rmk-date').value='';document.getElementById('rmk-text').value='';
  const fileEl=document.getElementById('rmk-file');if(fileEl) fileEl.value='';
  const hiddenId=document.getElementById('rmk-edit-id');if(hiddenId) hiddenId.value='';
  const btn=document.getElementById('submit-remark-btn');if(btn){btn.textContent='Submit Remark';btn.style.background='';}
  document.getElementById('rmk-edit-cancel')?.remove();document.getElementById('rmk-file-edit-hint')?.remove();
  const formEl=document.querySelector('.remark-form');if(formEl){formEl.style.border='';formEl.style.borderRadius='';formEl.style.padding='16px';}
}

// ── INIT ───────────────────────────────────────────────────────
(function init(){
  const otpBtn=document.getElementById('otp-btn');
  const verifyBtn=document.getElementById('verify-btn');
  const backBtn=document.getElementById('back-btn');
  const signoutBtn=document.getElementById('signout-btn');
  const pwdBtn=document.getElementById('pwd-btn');
  const forgotBtn=document.getElementById('forgot-btn');
  const forgotSendBtn=document.getElementById('forgot-send-btn');
  const backLoginBtn=document.getElementById('back-to-login-btn');
  const resetPwdBtn=document.getElementById('reset-pwd-btn');
  const setpwdBtn=document.getElementById('setpwd-btn');

  if(otpBtn)        otpBtn.addEventListener('click',requestOtp);
  if(verifyBtn)     verifyBtn.addEventListener('click',verifyOtp);
  if(backBtn)       backBtn.addEventListener('click',backToEmail);
  if(signoutBtn)    signoutBtn.addEventListener('click',signOut);
  if(pwdBtn)        pwdBtn.addEventListener('click',loginWithPassword);
  if(forgotBtn)     forgotBtn.addEventListener('click',()=>{showStep('step-forgot');document.getElementById('inp-forgot-email').value=document.getElementById('inp-email').value;});
  if(forgotSendBtn) forgotSendBtn.addEventListener('click',sendForgotOtp);
  if(backLoginBtn)  backLoginBtn.addEventListener('click',()=>showStep('step-email'));
  if(resetPwdBtn)   resetPwdBtn.addEventListener('click',resetPassword);
  if(setpwdBtn)     setpwdBtn.addEventListener('click',setPassword);
  document.getElementById('tab-otp-btn')?.addEventListener('click',()=>setLoginMethod('otp'));
  document.getElementById('tab-pwd-btn')?.addEventListener('click',()=>setLoginMethod('pwd'));

  document.getElementById('inp-otp')?.addEventListener('keydown',e=>{if(e.key==='Enter')verifyOtp();});
  document.getElementById('inp-email')?.addEventListener('keydown',e=>{if(e.key==='Enter'){if(_loginMethod==='otp')requestOtp();else loginWithPassword();}});
  document.getElementById('inp-pwd')?.addEventListener('keydown',e=>{if(e.key==='Enter')loginWithPassword();});
  document.getElementById('inp-forgot-otp')?.addEventListener('keydown',e=>{if(e.key==='Enter')resetPassword();});
  document.getElementById('inp-reset-confirm')?.addEventListener('keydown',e=>{if(e.key==='Enter')resetPassword();});
  document.getElementById('inp-confirmpwd')?.addEventListener('keydown',e=>{if(e.key==='Enter')setPassword();});

  document.querySelectorAll('.tab[data-tab]').forEach(btn=>{
    btn.addEventListener('click',function(){showTab(this.dataset.tab);});
  });

  document.addEventListener('click',function(e){
    if(e.target&&e.target.id==='submit-remark-btn') submitRemark();
    if(e.target&&e.target.id==='sat-avail-btn') submitSaturdayAvailability(e.target);
    if(e.target&&e.target.id==='submit-reimb-btn') submitReimbursement(e.target);
  });

  const token=sessionStorage.getItem(TOKEN_KEY);
  const name=sessionStorage.getItem(NAME_KEY);
  if(token&&name) launchApp(token,name);
})();
</script>
</body>
</html>