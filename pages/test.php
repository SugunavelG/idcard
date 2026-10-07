<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student profile · layout</title>
  <!-- Font Awesome 6 (free) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body {
      background: #f4f7fc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .profile-card {
      max-width: 1100px;
      width: 100%;
      background: white;
      border-radius: 32px;
      box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.12);
      padding: 2rem 2.5rem 2.5rem;
      transition: 0.2s;
    }

    /* ===== grid layout ===== */
    .profile-grid {
      display: grid;
      grid-template-columns: 1fr 1.6fr;
      gap: 2rem 2.8rem;
      margin-top: 0.25rem;
    }

    /* ---------- left column ---------- */
    .left-panel {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    /* avatar + name */
    .avatar-section {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .avatar-placeholder {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(145deg, #d9e2ef, #c0cee0);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 500;
      color: #1f2a44;
      flex-shrink: 0;
      box-shadow: 0 6px 12px rgba(0,0,0,0.02);
    }

    .name-title h2 {
      font-size: 1.6rem;
      font-weight: 600;
      color: #0b1a33;
      letter-spacing: -0.3px;
    }

    .name-title .badge {
      background: #eef3fa;
      padding: 0.25rem 1rem;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 600;
      color: #1f3a6b;
      display: inline-block;
      margin-top: 4px;
      letter-spacing: 0.3px;
    }

    /* info blocks */
    .info-block {
      background: #f9fbfe;
      border-radius: 20px;
      padding: 1.2rem 1.5rem;
    }

    .info-block .label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #6b7e9c;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .info-row {
      display: flex;
      align-items: baseline;
      gap: 0.75rem;
      padding: 0.35rem 0;
      font-size: 0.95rem;
    }

    .info-row i {
      width: 1.2rem;
      color: #3f5a82;
      font-size: 0.9rem;
    }

    .info-row .value {
      color: #14273e;
      font-weight: 450;
      word-break: break-word;
    }

    .info-row .sub {
      color: #5d738f;
      font-size: 0.85rem;
    }

    .language-tag {
      background: #e3eaf5;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      font-size: 0.8rem;
      font-weight: 500;
      color: #1f3a6b;
      display: inline-block;
    }

    .bio-text {
      color: #1e344e;
      line-height: 1.5;
      font-size: 0.95rem;
      margin-top: 0.2rem;
    }

    /* ---------- right panel (edit) ---------- */
    .right-panel {
      display: flex;
      flex-direction: column;
      gap: 1.8rem;
    }

    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #0b1a33;
      letter-spacing: -0.2px;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      border-bottom: 1px solid #e7ecf5;
      padding-bottom: 0.7rem;
    }

    .section-title i {
      color: #2c4a7c;
      font-size: 1rem;
    }

    .edit-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem 1.8rem;
    }

    .form-group {
      flex: 1 0 calc(50% - 1rem);
      min-width: 160px;
    }

    .form-group.full-width {
      flex: 1 0 100%;
    }

    .form-group label {
      display: block;
      font-size: 0.7rem;
      font-weight: 600;
      color: #40587a;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      margin-bottom: 0.25rem;
    }

    .form-group label .required-star {
      color: #b22234;
      margin-left: 2px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.7rem 1rem;
      background: #f6f9ff;
      border: 1px solid #dde5f0;
      border-radius: 16px;
      font-size: 0.9rem;
      color: #0f1f33;
      transition: 0.15s;
      outline: none;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: #6f8fc9;
      background: white;
      box-shadow: 0 0 0 3px rgba(60, 100, 177, 0.08);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: #8c9eb8;
      font-weight: 300;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 70px;
    }

    .form-group .hint {
      font-size: 0.7rem;
      color: #7b8ea8;
      margin-top: 4px;
    }

    /* change password block */
    .password-block {
      background: #fafcff;
      border-radius: 20px;
      padding: 1rem 0 0.2rem 0;
      margin-top: 0.2rem;
    }

    .password-block .form-group {
      margin-bottom: 0.8rem;
    }

    /* notification + buttons */
    .action-row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      margin-top: 0.8rem;
      border-top: 1px solid #e7ecf5;
      padding-top: 1.4rem;
    }

    .notification-toggle {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      color: #1f3a6b;
      font-weight: 500;
      font-size: 0.9rem;
    }

    .notification-toggle i {
      font-size: 1.3rem;
      color: #2f4c7c;
    }

    .btn-group {
      display: flex;
      gap: 1rem;
    }

    .btn {
      padding: 0.6rem 1.8rem;
      border-radius: 40px;
      font-weight: 600;
      font-size: 0.85rem;
      border: none;
      background: transparent;
      cursor: default;
      transition: 0.1s;
      letter-spacing: 0.2px;
    }

    .btn-outline {
      background: #f0f4fe;
      color: #1f3a6b;
      border: 1px solid #d4e0f0;
    }

    .btn-primary {
      background: #1b3a6b;
      color: white;
      box-shadow: 0 4px 8px rgba(25, 60, 130, 0.12);
    }

    .btn-primary i {
      margin-right: 6px;
    }

    /* small extras */
    .profile-image-edit {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      padding: 0.4rem 0;
    }

    .profile-image-edit span {
      font-weight: 500;
      color: #1f3a6b;
    }

    .profile-image-edit i {
      color: #4b6b97;
    }

    .edit-pic-link {
      color: #2a4d84;
      font-size: 0.8rem;
      font-weight: 500;
      text-decoration: none;
      border-bottom: 1px dashed #b2c6e0;
    }

    /* responsive */
    @media (max-width: 780px) {
      .profile-grid {
        grid-template-columns: 1fr;
        gap: 1.8rem;
      }
      .profile-card {
        padding: 1.5rem;
      }
      .form-group {
        flex: 1 0 100%;
      }
      .action-row {
        flex-direction: column;
        align-items: start;
        gap: 1rem;
      }
      .btn-group {
        width: 100%;
        justify-content: flex-end;
      }
    }

    @media (max-width: 480px) {
      .avatar-section {
        flex-direction: column;
        align-items: flex-start;
      }
      .btn-group {
        flex-wrap: wrap;
      }
      .btn {
        flex: 1;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="profile-card">
    <!-- header: name + title (replicates "Jacob Jones" style) -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; flex-wrap: wrap;">
      <div>
        <h1 style="font-size: 1.7rem; font-weight: 600; color: #0b1a33; letter-spacing: -0.5px;">Jacob Jones</h1>
        <div style="color: #556b89; font-size: 0.85rem; margin-top: 2px;"><i class="far fa-envelope" style="margin-right: 6px;"></i> ifrandom@gmail.com</div>
      </div>
      <div style="background: #eef3fa; padding: 0.3rem 1.2rem; border-radius: 60px; font-size: 0.75rem; font-weight: 600; color: #1f3a6b;"><i class="fas fa-user-graduate" style="margin-right: 6px;"></i> Student</div>
    </div>

    <div class="profile-grid">
      <!-- LEFT COLUMN : Personal Info, Department, Languages, Bio -->
      <div class="left-panel">
        <!-- avatar + name (Will Jonto style) -->
        <div class="avatar-section">
          <div class="avatar-placeholder">WJ</div>
          <div class="name-title">
            <h2>Will Jonto</h2>
            <span class="badge"><i class="fas fa-id-badge" style="margin-right: 6px;"></i> ID: S-2026</span>
          </div>
        </div>

        <!-- Personal Info -->
        <div class="info-block">
          <div class="label"><i class="fas fa-address-card" style="margin-right: 6px;"></i> Personal Info</div>
          <div class="info-row"><i class="far fa-envelope"></i> <span class="value">willjontoax@gmail.com</span></div>
          <div class="info-row"><i class="fas fa-phone-alt"></i> <span class="value">(1) 2536 2561 2365</span> <span class="sub">· mobile</span></div>
          <div class="info-row"><i class="fas fa-hashtag"></i> <span class="value">(1) 2536 2561 2365</span> <span class="sub">· number</span></div>
        </div>

        <!-- Department -->
        <div class="info-block">
          <div class="label"><i class="fas fa-building"></i> Department</div>
          <div class="info-row"><span class="value" style="font-weight: 500;">Design · UI UX Designer</span></div>
          <div class="info-row" style="font-size: 0.85rem; color: #2b4670;"><i class="fas fa-pencil-ruler"></i> Student · design track</div>
        </div>

        <!-- Languages -->
        <div class="info-block">
          <div class="label"><i class="fas fa-globe"></i> Languages</div>
          <div class="info-row"><span class="language-tag"><i class="fas fa-check-circle" style="margin-right: 6px; color: #2b6f4b;"></i> English</span> <span style="margin-left: 6px; color: #4a6688;">(fluent)</span></div>
        </div>

        <!-- Bio -->
        <div class="info-block">
          <div class="label"><i class="fas fa-pencil-alt"></i> Bio</div>
          <div class="bio-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
        </div>
      </div>

      <!-- RIGHT COLUMN : Edit Profile + Change Password + Notification -->
      <div class="right-panel">

        <!-- Edit Profile (with profile image line) -->
        <div>
          <div class="section-title"><i class="fas fa-user-edit"></i> Edit Profile</div>
          <div class="edit-form" style="margin-top: 0.5rem;">
            <!-- Profile Image (replica) -->
            <div class="profile-image-edit">
              <i class="fas fa-camera" style="font-size: 1.2rem; color: #1f3a6b;"></i>
              <span>Profile Image</span>
              <a href="#" class="edit-pic-link" style="margin-left: auto;"><i class="fas fa-upload"></i> change photo</a>
            </div>

            <!-- two columns form -->
            <div class="form-row">
              <div class="form-group"><label>Full Name <span class="required-star">*</span></label> <input type="text" value="Will Jonto" placeholder="Enter Full Name"></div>
              <div class="form-group"><label>Email <span class="required-star">*</span></label> <input type="email" value="willjontoax@gmail.com" placeholder="Enter email address"></div>
            </div>
            <div class="form-row">
              <div class="form-group"><label>Phone</label> <input type="text" value="(1) 2536 2561 2365" placeholder="Enter phone number"></div>
              <div class="form-group"><label>Department <span class="required-star">*</span></label> <input type="text" value="Design" placeholder="Enter Event Title"></div>
            </div>
            <div class="form-row">
              <div class="form-group"><label>Designation <span class="required-star">*</span></label> <input type="text" value="UI UX Designer" placeholder="Designation"></div>
              <div class="form-group"><label>Language <span class="required-star">*</span></label> <input type="text" value="English" placeholder="Language"></div>
            </div>
            <div class="form-group full-width">
              <label>Description</label>
              <textarea placeholder="Write description...">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</textarea>
            </div>
          </div>
        </div>

        <!-- Change Password -->
        <div>
          <div class="section-title"><i class="fas fa-lock"></i> Change Password</div>
          <div class="password-block">
            <div class="form-group"><label>Current Password</label> <input type="password" placeholder="••••••••"></div>
            <div class="form-row" style="gap: 1rem;">
              <div class="form-group"><label>New Password</label> <input type="password" placeholder="New password"></div>
              <div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Confirm"></div>
            </div>
            <div style="font-size: 0.75rem; color: #5d738f; margin-top: 0.2rem; padding-left: 0.2rem;"><i class="fas fa-info-circle"></i> Minimum 8 characters</div>
          </div>
        </div>

        <!-- Notification Settings + Cancel/Save -->
        <div class="action-row">
          <div class="notification-toggle">
            <i class="fas fa-bell"></i> Notification Settings
            <span style="background: #dce6f2; border-radius: 30px; padding: 0.15rem 1rem; font-size: 0.7rem; margin-left: 0.3rem;">on</span>
          </div>
          <div class="btn-group">
            <button class="btn btn-outline"><i class="fas fa-times"></i> Cancel</button>
            <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
          </div>
        </div>

        <!-- tiny extra: “Edit Profile” image line hint from original design, already present -->
      </div>
    </div>
    <!-- footer: subtle (optional) -->
    <div style="margin-top: 1.8rem; border-top: 1px solid #e6ecf5; padding-top: 0.8rem; display: flex; justify-content: flex-end; font-size: 0.7rem; color: #7f94b2;">
      <span><i class="far fa-clock"></i> last updated: today</span>
    </div>
  </div>
</body>
</html>