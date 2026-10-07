<!DOCTYPE html>
<html lang="en">

<head>
    <title>AVIT Admission Management System</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Flash Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Flash Able, Flash Able bootstrap admin template" />
    <meta name="author" content="Codedthemes" />

    <!-- Favicon icon -->
    <link rel="icon" href="./assets/logo/favicon.png" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="./assets/plugins/animation/css/animate.min.css">

    <!-- vendor css -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <style>
        /* ── Custom validation styles ── */
        .form-group {
            position: relative;
        }

        .form-group .error {
            color: #dc3545;
            font-size: 80%;
            margin-top: 4px;
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        .input-group .is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .input-group .is-valid {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .input-group .is-invalid~.input-group-prepend .input-group-text {
            border-color: #dc3545;
            color: #dc3545;
        }

        .input-group .is-valid~.input-group-prepend .input-group-text {
            border-color: #28a745;
            color: #28a745;
        }

        /* ── Toast / alert messages ── */
        .login-alert {
            display: none;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
            font-weight: 500;
            animation: fadeInDown 0.4s ease;
        }
        .login-alert.alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .login-alert.alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .login-alert.alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }
        .login-alert.show {
            display: block;
        }

        /* ── Spinner on button ── */
        .btn-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }
        .btn-loading .btn-text {
            visibility: hidden;
        }
        .btn-loading .btn-spinner {
            display: inline-block;
        }
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-wrapper .card-body .btn-primary {
            min-width: 120px;
        }

        @media (max-width: 575.98px) {
            .auth-wrapper .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- [ auth-signin ] start -->
    <div class="auth-wrapper">
        <div class="auth-content container">
            <div class="card">
                <div class="row align-items-center">
                    
                    <div class="col-md-6 d-none d-md-block">
                        <img src="./assets/images/auth-bg.jpg" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <!-- Logo -->
                            <img src="./assets/logo/AVITLogowhite.png" alt="" class="img-fluid mb-4">

                            <h2 class="mb-3 f-w-700 text-center"> AVIT Admission Management System</h2>

                            <!-- ═══ ALERT CONTAINER ═══ -->
                            <div id="loginAlert" class="login-alert"></div>

                            <!-- ═══ LOGIN FORM ═══ -->
                            <form id="loginForm" novalidate>

                                <!-- Username -->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                                        </div>
                                        <input type="text"
                                        class="form-control"
                                        id="username"
                                        name="username"
                                        placeholder="Username"
                                        autocomplete="off"
                                        autofocus>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                        </div>
                                        <input type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        autocomplete="off"
                                        placeholder="Password">
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button type="submit"
                                class="btn btn-primary mb-4 text-center"
                                id="loginBtn">
                                <span class="btn-text">Login</span>
                                <span class="btn-spinner"></span>
                            </button>

                        </form>
                        <!-- ═══ END FORM ═══ -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->


<!-- ════════════════════════════════════════════════════════════ -->
<!--  REQUIRED JS                                              -->
<!-- ════════════════════════════════════════════════════════════ -->

<!-- Vendor -->
<script src="./assets/js/vendor-all.min.js"></script>
<script src="./assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- ── jQuery Validation ── -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js">
</script>

<!-- ════════════════════════════════════════════════════════════ -->
<!--  CUSTOM VALIDATION + AJAX (USERNAME VERSION)             -->
<!-- ════════════════════════════════════════════════════════════ -->
<script>
$(function() {

    var $form = $('#loginForm');
    var $btn = $('#loginBtn');
    var $alert = $('#loginAlert');

    function showAlert(message, type) {
        $alert
            .removeClass('alert-danger alert-success alert-info show')
            .addClass('alert-' + type + ' show')
            .html(message);
    }

    function hideAlert() {
        $alert.removeClass('show').html('');
    }

    function setLoading(loading) {
        if (loading) {
            $btn.addClass('btn-loading');
        } else {
            $btn.removeClass('btn-loading');
        }
    }

    $form.validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            password: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            username: {
                required: 'Please enter your username',
                minlength: 'Username must be at least 3 characters'
            },
            password: {
                required: 'Please enter your password',
                minlength: 'Password must be at least 4 characters'
            }
        },
        errorPlacement: function(error, element) {
            var $group = element.closest('.form-group');
            var $inputGroup = element.closest('.input-group');
            if ($inputGroup.length) {
                $inputGroup.after(error);
            } else {
                $group.append(error);
            }
        },
        highlight: function(element) {
            var $el = $(element);
            $el.addClass('is-invalid').removeClass('is-valid');
            var $group = $el.closest('.input-group');
            if ($group.length) {
                $group.find('.input-group-text').css({ borderColor: '#dc3545', color: '#dc3545' });
            }
        },
        unhighlight: function(element) {
            var $el = $(element);
            $el.removeClass('is-invalid').addClass('is-valid');
            var $group = $el.closest('.input-group');
            if ($group.length) {
                $group.find('.input-group-text').css({ borderColor: '#28a745', color: '#28a745' });
            }
        },
        submitHandler: function(form) {
            hideAlert();
            setLoading(true);

            var formData = {
                username: $('#username').val().trim(),
                password: $('#password').val().trim()
            };

            // ── REAL AJAX CALL ──
            $.ajax({
                url: 'common/checkLogin.php?request=checkLoginCredentials',
                method: 'POST',
                data: formData,          // sent as application/x-www-form-urlencoded
                dataType: 'json',
                success: function(res) {
                    setLoading(false);
                    if (res.status === 'success') {
                        showAlert(res.message || 'Login successful!', 'success');
                        // Redirect if needed:
                         window.location.href = './pages/index.php';
                    } else {
                        showAlert(res.message || 'Login failed. Please try again.', 'danger');
                        // Re-trigger validation to show field errors
                        $form.find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
                        $form.find('.input-group-text').css({ borderColor: '', color: '' });
                        $form.validate().element('#username');
                        $form.validate().element('#password');
                    }
                },
                error: function(xhr) {
                    setLoading(false);
                    var msg = xhr.responseJSON?.message || 'Server error. Please try again.';
                    showAlert(msg, 'danger');
                }
            });
        }
    });

    // Clear validation styling on input
    $form.find('input').on('input', function() {
        var $el = $(this);
        if ($el.hasClass('is-invalid') || $el.hasClass('is-valid')) {
            $el.removeClass('is-invalid is-valid');
            var $group = $el.closest('.input-group');
            if ($group.length) {
                $group.find('.input-group-text').css({ borderColor: '', color: '' });
            }
        }
        hideAlert();
    });

    $form.find('input').on('focus', function() {
        hideAlert();
    });

});
</script>

 

</body>

</html>