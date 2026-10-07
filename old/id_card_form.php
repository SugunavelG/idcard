<?php
$errors = $_SESSION['id_card_errors'] ?? [];
$old_input = $_SESSION['id_card_old'] ?? [];
unset($_SESSION['id_card_errors']);
unset($_SESSION['id_card_old']);

$last_app = $_SESSION['last_app_number'] ?? '';
unset($_SESSION['last_app_number']);
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($last_app): ?>
    <div class="alert alert-success">
        <strong>✅ Application Submitted!</strong> Your Application Number is: 
        <span class="fw-bold fs-5"><?php echo htmlspecialchars($last_app); ?></span>
    </div>
<?php endif; ?>

<form id="idCardForm" action="submit_id_card.php" method="POST" novalidate>
    <div class="row g-3">

        <!-- Application Number (read-only) -->
        <div class="col-md-4">
            <label for="app_no_display" class="form-label fw-semibold">Application Number</label>
            <input type="text" class="form-control" id="app_no_display" 
                   value="<?php echo htmlspecialchars($old_input['app_no_display']); ?>" >
        </div>

        <!-- Full Name -->
        <div class="col-md-4">
            <label for="full_name" class="form-label fw-semibold">Full Name <span class="required-star">*</span></label>
            <input type="text" class="form-control" id="full_name" name="full_name" 
                   value="<?php echo htmlspecialchars($old_input['full_name'] ?? ''); ?>">
            <div class="error-text" id="fullNameError"></div>
        </div>

        <!-- Date of Birth -->
        <div class="col-md-4">
            <label for="dob" class="form-label fw-semibold">Date of Birth <span class="required-star">*</span></label>
            <input type="date" class="form-control" id="dob" name="dob" 
                   value="<?php echo htmlspecialchars($old_input['dob'] ?? ''); ?>">
            <div class="error-text" id="dobError"></div>
        </div>

        <!-- Gender -->
        <div class="col-md-4">
            <label for="gender" class="form-label fw-semibold">Gender <span class="required-star">*</span></label>
            <select class="form-select" id="gender" name="gender">
                <option value="">-- Select --</option>
                <option value="Male" <?php echo (isset($old_input['gender']) && $old_input['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo (isset($old_input['gender']) && $old_input['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo (isset($old_input['gender']) && $old_input['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
            <div class="error-text" id="genderError"></div>
        </div>
        
         <!-- Mobile No -->
        <div class="col-md-4">
            <label for="mobile_no" class="form-label fw-semibold">Mobile No <span class="required-star">*</span></label>
            <input type="tel" class="form-control" id="mobile_no" name="mobile_no" 
                   value="<?php echo htmlspecialchars($old_input['mobile_no'] ?? ''); ?>">
            <div class="error-text" id="mobileError"></div>
        </div>

        <!-- Alternate Mobile No -->
        <div class="col-md-4">
            <label for="alternate_mobile_no" class="form-label fw-semibold">Alternate Mobile No</label>
            <input type="tel" class="form-control" id="alternate_mobile_no" name="alternate_mobile_no" 
                   value="<?php echo htmlspecialchars($old_input['alternate_mobile_no'] ?? ''); ?>">
            <div class="error-text" id="altMobileError"></div>
        </div>

        <!-- Department -->
        <div class="col-md-4">
            <label for="department" class="form-label fw-semibold">Department <span class="required-star">*</span></label>
            <input type="text" class="form-control" id="department" name="department" 
                   value="<?php echo htmlspecialchars($old_input['department'] ?? ''); ?>">
            <div class="error-text" id="deptError"></div>
        </div>

        <!-- Batch -->
        <div class="col-md-4">
            <label for="batch" class="form-label fw-semibold">Batch <span class="required-star">*</span></label>
            <input type="text" class="form-control" id="batch" name="batch" 
                   value="<?php echo htmlspecialchars($old_input['batch'] ?? ''); ?>">
            <div class="error-text" id="batchError"></div>
        </div>
        
        <!-- Blood Group -->
        <div class="col-md-4">
            <label for="blood_group" class="form-label fw-semibold">Blood Group</label>
            <select class="form-select" id="blood_group" name="blood_group">
                <option value="">-- Select (optional) --</option>
                <?php $bgroups = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; ?>
                <?php foreach ($bgroups as $bg): ?>
                    <option value="<?php echo $bg; ?>" <?php echo (isset($old_input['blood_group']) && $old_input['blood_group'] == $bg) ? 'selected' : ''; ?>><?php echo $bg; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="error-text" id="bloodError"></div>
        </div>
        
        <!-- Address – spans full width -->
        <div class="col-12">
            <label for="address" class="form-label fw-semibold">Address <span class="required-star">*</span></label>
            <textarea class="form-control" id="address" name="address" rows="2"><?php echo htmlspecialchars($old_input['address'] ?? ''); ?></textarea>
            <div class="error-text" id="addressError"></div>
        </div>

        <!-- ===== Issued Items (Yes/No) – 3 per row ===== -->
        <div class="col-md-4">
            <label for="bag" class="form-label fw-semibold">Bag Issued <span class="required-star">*</span></label>
            <select class="form-select" id="bag" name="bag">
                <option value="">-- Select --</option>
                <option value="Yes" <?php echo (isset($old_input['bag']) && $old_input['bag'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo (isset($old_input['bag']) && $old_input['bag'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
            <div class="error-text" id="bagError"></div>
        </div>
        
        <!-- ===== Issued Dates – 3 per row ===== -->
        <div class="col-md-4">
            <label for="bag_date" class="form-label fw-semibold">Bag Issued Date</label>
            <input type="date" class="form-control" id="bag_date" name="bag_date" 
                   value="<?php echo htmlspecialchars($old_input['bag_date'] ?? ''); ?>">
            <div class="error-text" id="bagDateError"></div>
        </div>
        
        <div class="col-md-4">
            <label for="tshirt" class="form-label fw-semibold">T‑shirt Issued <span class="required-star">*</span></label>
            <select class="form-select" id="tshirt" name="tshirt">
                <option value="">-- Select --</option>
                <option value="Yes" <?php echo (isset($old_input['tshirt']) && $old_input['tshirt'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo (isset($old_input['tshirt']) && $old_input['tshirt'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
            <div class="error-text" id="tshirtError"></div>
        </div>
        
         <div class="col-md-4">
            <label for="tshirt_date" class="form-label fw-semibold">T‑shirt Issued Date</label>
            <input type="date" class="form-control" id="tshirt_date" name="tshirt_date" 
                   value="<?php echo htmlspecialchars($old_input['tshirt_date'] ?? ''); ?>">
            <div class="error-text" id="tshirtDateError"></div>
        </div>
        
        
        <div class="col-md-4">
            <label for="kit" class="form-label fw-semibold">Welcome Kit Issued <span class="required-star">*</span></label>
            <select class="form-select" id="kit" name="kit">
                <option value="">-- Select --</option>
                <option value="Yes" <?php echo (isset($old_input['kit']) && $old_input['kit'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo (isset($old_input['kit']) && $old_input['kit'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
            <div class="error-text" id="kitError"></div>
        </div>
        
         <div class="col-md-4">
            <label for="kit_date" class="form-label fw-semibold">Welcome Kit Issued Date</label>
            <input type="date" class="form-control" id="kit_date" name="kit_date" 
                   value="<?php echo htmlspecialchars($old_input['kit_date'] ?? ''); ?>">
            <div class="error-text" id="kitDateError"></div>
        </div>

        <div class="col-md-4">
            <label for="idcard" class="form-label fw-semibold">ID Card Issued <span class="required-star">*</span></label>
            <select class="form-select" id="idcard" name="idcard">
                <option value="">-- Select --</option>
                <option value="Yes" <?php echo (isset($old_input['idcard']) && $old_input['idcard'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo (isset($old_input['idcard']) && $old_input['idcard'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
            <div class="error-text" id="idcardError"></div>
        </div>
        
        
        <div class="col-md-4">
            <label for="idcard_date" class="form-label fw-semibold">ID Card Issued Date</label>
            <input type="date" class="form-control" id="idcard_date" name="idcard_date" 
                   value="<?php echo htmlspecialchars($old_input['idcard_date'] ?? ''); ?>">
            <div class="error-text" id="idcardDateError"></div>
        </div>

        

        <!-- Created By -->
        <div class="col-md-4">
            <label for="cby" class="form-label fw-semibold">Created By <span class="required-star">*</span></label>
            <input type="text" class="form-control" id="cby" name="cby" 
                   value="<?php echo htmlspecialchars($old_input['cby'] ?? ''); ?>">
            <div class="error-text" id="cbyError"></div>
        </div>

        

        

       

       


        <!-- Submit -->
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary w-100 py-2"><i class="fas fa-paper-plane me-2"></i>Submit Application</button>
        </div>

    </div>
</form>
<script>
    $(document).ready(function() {

    // ---------- LOGIN VALIDATION ----------
    $('#loginForm').on('submit', function(e) {
        $('.error-text').text('');
        let isValid = true;
        const username = $('#loginUsername').val().trim();
        const password = $('#loginPassword').val().trim();

        if (username === '') {
            $('#loginUsernameError').text('Username is required.');
            isValid = false;
        }
        if (password === '') {
            $('#loginPasswordError').text('Password is required.');
            isValid = false;
        }
        if (!isValid) e.preventDefault();
    });

    // ---------- ID CARD FORM VALIDATION ----------
    $('#idCardForm').on('submit', function(e) {
        // Clear all previous error messages
        $('.error-text').text('');
        $('.alert-danger').remove();

        let isValid = true;

        // Gather all values
        const fullName = $('#full_name').val().trim();
        const dob = $('#dob').val();
        const address = $('#address').val().trim();
        const mobile = $('#mobile_no').val().trim();
        const altMobile = $('#alternate_mobile_no').val().trim();
        const gender = $('#gender').val();
        const dept = $('#department').val().trim();
        const batch = $('#batch').val().trim();
        const cby = $('#cby').val().trim();
        const bag = $('#bag').val();
        const tshirt = $('#tshirt').val();
        const kit = $('#kit').val();
        const idcard = $('#idcard').val();

        // Date fields
        const bagDate = $('#bag_date').val();
        const tshirtDate = $('#tshirt_date').val();
        const kitDate = $('#kit_date').val();
        const idcardDate = $('#idcard_date').val();
        const today = new Date().toISOString().split('T')[0];

        // ---------- VALIDATE EACH FIELD ----------
        // Full Name
        if (fullName === '') {
            $('#fullNameError').text('Full Name is required.');
            isValid = false;
        } else if (fullName.length < 3) {
            $('#fullNameError').text('Name must be at least 3 characters.');
            isValid = false;
        }

        // Date of Birth
        if (dob === '') {
            $('#dobError').text('Date of Birth is required.');
            isValid = false;
        } else if (dob > today) {
            $('#dobError').text('DOB cannot be in the future.');
            isValid = false;
        }

        // Address
        if (address === '') {
            $('#addressError').text('Address is required.');
            isValid = false;
        }

        // Mobile (10 digits)
        const mobileRegex = /^[0-9]{10}$/;
        if (mobile === '') {
            $('#mobileError').text('Mobile Number is required.');
            isValid = false;
        } else if (!mobileRegex.test(mobile)) {
            $('#mobileError').text('Enter a valid 10‑digit mobile number.');
            isValid = false;
        }

        // Alternate Mobile (if filled)
        if (altMobile !== '' && !mobileRegex.test(altMobile)) {
            $('#altMobileError').text('Alternate number must be 10 digits.');
            isValid = false;
        }

        // Gender
        if (gender === '') {
            $('#genderError').text('Please select a gender.');
            isValid = false;
        }

        // Department
        if (dept === '') {
            $('#deptError').text('Department is required.');
            isValid = false;
        }

        // Batch
        if (batch === '') {
            $('#batchError').text('Batch is required.');
            isValid = false;
        }

        // Created By
        if (cby === '') {
            $('#cbyError').text('Please enter your name/ID.');
            isValid = false;
        }

        // Bag Issued
        if (bag === '') {
            $('#bagError').text('Please select Bag Issued.');
            isValid = false;
        }

        // T‑shirt Issued
        if (tshirt === '') {
            $('#tshirtError').text('Please select T‑shirt Issued.');
            isValid = false;
        }

        // Welcome Kit Issued
        if (kit === '') {
            $('#kitError').text('Please select Welcome Kit Issued.');
            isValid = false;
        }

        // ID Card Issued
        if (idcard === '') {
            $('#idcardError').text('Please select ID Card Issued.');
            isValid = false;
        }

        // ---------- DATE VALIDATIONS (if provided) ----------
        if (bagDate && bagDate > today) {
            $('#bagDateError').text('Bag Issued Date cannot be in the future.');
            isValid = false;
        }
        if (tshirtDate && tshirtDate > today) {
            $('#tshirtDateError').text('T‑shirt Issued Date cannot be in the future.');
            isValid = false;
        }
        if (kitDate && kitDate > today) {
            $('#kitDateError').text('Welcome Kit Issued Date cannot be in the future.');
            isValid = false;
        }
        if (idcardDate && idcardDate > today) {
            $('#idcardDateError').text('ID Card Issued Date cannot be in the future.');
            isValid = false;
        }

        // If any errors, prevent submission and scroll to top
        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 300);
        }
    });
});
</script>