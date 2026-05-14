<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lakhani Imperial City – Provisional Allocation Letter</title>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: #d6d0c4;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 40px 20px;
      font-family: 'EB Garamond', serif;
    }

    /* ── Page ── */
    .page {
      width: 210mm;
      min-height: 148mm;
      background: #f5f3ef;
      box-shadow: 0 8px 40px rgba(0,0,0,.25), 0 2px 8px rgba(0,0,0,.15);
      padding: 28px 36px 24px;
      position: relative;
      border: 1px solid #ccc8be;
    }

    /* ── Corner note ── */
    .corner-note {
      position: absolute;
      top: 14px;
      right: 18px;
      font-family: 'EB Garamond', serif;
      font-size: 13px;
      color: #1a4fa0;
      font-style: italic;
      border-bottom: 1.5px solid #1a4fa0;
      padding-bottom: 2px;
      letter-spacing: .5px;
    }

    /* ── Header ── */
    .header {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 16px;
    }

    .logo-placeholder {
      width: 90px;
      height: 34px;
      background: #e0ddd5;
      border: 1.5px dashed #999;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 9px;
      color: #888;
      letter-spacing: .5px;
      margin-bottom: 4px;
    }

    .brand-name {
      font-family: 'Cinzel', serif;
      font-size: 32px;
      font-weight: 700;
      letter-spacing: 6px;
      color: #2a2a2a;
      line-height: 1;
      /* embossed look */
      text-shadow: 1px 1px 0 rgba(255,255,255,.8), -1px -1px 0 rgba(0,0,0,.12);
    }

    .crown-divider {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 4px 0;
      color: #5a5a5a;
      font-size: 11px;
      letter-spacing: 2px;
    }
    .crown-divider::before,
    .crown-divider::after {
      content: '';
      display: block;
      width: 60px;
      height: 1px;
      background: linear-gradient(to right, transparent, #5a5a5a);
    }
    .crown-divider::after { background: linear-gradient(to left, transparent, #5a5a5a); }

    .sub-brand {
      font-family: 'Cinzel', serif;
      font-size: 11.5px;
      letter-spacing: 8px;
      color: #4a4a4a;
      text-transform: uppercase;
    }

    /* ── Title ── */
    .letter-title {
      text-align: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 20px;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #1a1a1a;
      margin: 10px 0 16px;
      border-top: 1.5px solid #333;
      border-bottom: 1.5px solid #333;
      padding: 5px 0;
    }

    /* ── Form Fields ── */
    .fields {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 12px;
    }

    .field-row {
      display: flex;
      align-items: flex-end;
      gap: 6px;
    }

    .field-label {
      font-size: 13.5px;
      white-space: nowrap;
      color: #1a1a1a;
      font-weight: 500;
      font-family: 'EB Garamond', serif;
      flex-shrink: 0;
    }

    .field-line {
      flex: 1;
      border-bottom: 1px solid #333;
      height: 18px;
    }

    /* CNIC grid */
    .cnic-row {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .cnic-boxes {
      display: flex;
      gap: 3px;
    }

    .cnic-box {
      width: 18px;
      height: 20px;
      border: 1px solid #444;
      background: transparent;
    }

    /* Allocate row */
    .allocate-row {
      display: flex;
      align-items: flex-end;
      gap: 6px;
    }

    /* Plot / Type / Block / Date row */
    .details-row {
      display: flex;
      align-items: flex-end;
      gap: 4px;
      flex-wrap: nowrap;
    }

    .details-row .field-label {
      white-space: nowrap;
    }

    .details-row .field-line-sm {
      width: 90px;
      border-bottom: 1px solid #333;
      height: 18px;
      flex-shrink: 0;
    }

    /* Project line */
    .project-line {
      font-size: 13.5px;
      color: #1a1a1a;
      font-weight: 500;
      margin-top: 2px;
    }
    .project-line span {
      font-weight: 700;
    }

    /* ── Signatures ── */
    .signatures {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 22px;
      margin-bottom: 10px;
    }

    .sig-block {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
    }

    .sig-line {
      width: 140px;
      border-top: 1px solid #333;
    }

    .sig-label {
      font-size: 11px;
      color: #333;
      text-align: center;
      letter-spacing: .3px;
    }

    .sig-right-label {
      font-size: 11px;
      color: #333;
      text-align: center;
      letter-spacing: .3px;
      font-style: italic;
    }

    /* ── Note ── */
    .note-section {
      display: flex;
      gap: 8px;
      align-items: flex-start;
      margin-bottom: 14px;
    }

    .note-label {
      font-size: 10.5px;
      font-weight: 700;
      white-space: nowrap;
      color: #1a1a1a;
    }

    .note-text {
      font-size: 10px;
      color: #333;
      line-height: 1.5;
    }

    /* ── Footer ── */
    .footer {
      display: flex;
      align-items: center;
      gap: 16px;
      border-top: 1px solid #bbb;
      padding-top: 10px;
    }

    .footer-logos {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }

    .footer-logo-block {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 3px;
    }

    .footer-logo-img {
      width: 38px;
      height: 38px;
      background: #e0ddd5;
      border: 1.5px dashed #999;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 7px;
      color: #888;
      text-align: center;
      line-height: 1.2;
    }

    .footer-logo-text {
      font-family: 'Cinzel', serif;
      font-size: 7px;
      letter-spacing: 1px;
      color: #222;
      text-align: center;
      text-transform: uppercase;
    }

    .footer-logo-sub {
      font-size: 6px;
      color: #555;
      text-align: center;
      letter-spacing: .5px;
    }

    .footer-address {
      flex: 1;
      text-align: center;
      font-size: 11px;
      color: #222;
      line-height: 1.7;
    }

    .footer-right-logo {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 3px;
      flex-shrink: 0;
    }

    .madiha-logo-img {
      width: 52px;
      height: 52px;
      background: #e0ddd5;
      border: 1.5px dashed #999;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 7px;
      color: #888;
      text-align: center;
      line-height: 1.2;
    }

    .madiha-text {
      font-family: 'Cinzel', serif;
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 2px;
      color: #1a1a1a;
      text-align: center;
    }

    .madiha-sub {
      font-size: 7px;
      color: #555;
      letter-spacing: 1px;
      text-align: center;
      text-transform: uppercase;
    }

    /* "A PROJECT OF" label */
    .project-of {
      font-size: 7px;
      color: #888;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 2px;
    }

    @media print {
      body { background: white; padding: 0; }
      .page { box-shadow: none; border: none; }
    }
  </style>
</head>
<body>

<div class="page">

  <!-- Corner note -->
  <div class="corner-note">10 / 20 /.</div>

  <!-- Header -->
  <div class="header">
    <div class="brand-name">LAKHANI</div>
    <div class="crown-divider">👑</div>
    <div class="sub-brand">— &nbsp; Imperial &nbsp; City &nbsp; —</div>
  </div>

  <!-- Title -->
  <div class="letter-title">Provisional Allocation Letter</div>

  <!-- Fields -->
  <div class="fields">

    <div class="field-row">
      <span class="field-label">Mr/Mrs/Miss</span>
      <div class="field-line"></div>
    </div>

    <div class="field-row">
      <span class="field-label">S/o, D/o, W/o.</span>
      <div class="field-line"></div>
    </div>

    <div class="field-row">
      <span class="field-label">Addrees:</span>
      <div class="field-line"></div>
    </div>

    <div class="field-row">
      <div class="field-line" style="margin-left: 60px;"></div>
    </div>

    <!-- CNIC -->
    <div class="cnic-row">
      <span class="field-label">CNIC No.</span>
      <div class="cnic-boxes">
        <!-- 13 boxes for CNIC + separators at positions 5 and 12 -->
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
        <div class="cnic-box"></div>
      </div>
    </div>

    <!-- Allocate -->
    <div class="allocate-row">
      <span class="field-label">We are pleased to allocate you:</span>
      <div class="field-line"></div>
    </div>

    <!-- Plot / Type / Block / Date -->
    <div class="details-row">
      <span class="field-label">Plot No.</span>
      <div class="field-line-sm"></div>
      <span class="field-label" style="margin-left:10px;">Type:</span>
      <div class="field-line-sm"></div>
      <span class="field-label" style="margin-left:10px;">Block:</span>
      <div class="field-line-sm"></div>
      <span class="field-label" style="margin-left:10px;">Date:</span>
      <div class="field-line-sm"></div>
    </div>

    <!-- Project -->
    <div class="project-line">In our project <span>"LAKHANI IMPERIAL CITY</span></div>

  </div>

  <!-- Signatures -->
  <div class="signatures">
    <div class="sig-block">
      <div class="sig-line"></div>
      <div class="sig-label">Applicant's Signature</div>
    </div>
    <div class="sig-block">
      <div class="sig-line"></div>
      <div class="sig-right-label">On Behalf of<br><strong>LAKHANI Group</strong></div>
    </div>
  </div>

  <!-- Note -->
  <div class="note-section">
    <span class="note-label">NOTE:</span>
    <p class="note-text">This Provisioonal Allocation Letter will be treated as cancelled if the allottee fails to pay the installments as per given schedule or in case of breach of any terms and conditions signed by the allottee</p>
  </div>

  <!-- Footer -->
  <div class="footer">

    <!-- Left logo -->
    <div class="footer-logo-block">
      <div class="project-of">A Project Of</div>
      <div class="footer-logo-img">LOGO<br>HERE</div>
      <div class="footer-logo-text">Lakhani Group</div>
      <div class="footer-logo-sub">Builders · Developers · Realestate</div>
    </div>

    <!-- Address -->
    <div class="footer-address">
      <strong>Head Office:</strong> 4th Floor, Syedda Chamber, SB-04, Main University Road, Block 13-C,<br>
      Gulshan-e-Iqbal, Karachi, 75300. PH: +92 21 34820600 &nbsp; <strong>Email:</strong> lakhani.group@yahoo.com
    </div>

    <!-- Right logo -->
    <div class="footer-right-logo">
      <div class="madiha-logo-img">LOGO<br>HERE</div>
      <div class="madiha-text">MADIHA</div>
      <div class="madiha-sub">Associates<br>Builders &amp; Developers</div>
    </div>

  </div>

</div>

</body>
</html>
