<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Taste of Africa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- country-select-js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.1/css/countrySelect.min.css">

    <style>
        .btn-custom{background-color:#D19C97;border-color:#D19C97;color:#fff;transition:background-color .3s,border-color .3s}
        .btn-custom:hover{background-color:#b77a7a;border-color:#b77a7a}
        .highlight{color:#D19C97;transition:color .3s}
        .highlight:hover{color:#b77a7a}
        body{background-color:#f8f9fa;background-image:
            repeating-linear-gradient(0deg,#b77a7a,#b77a7a 1px,transparent 1px,transparent 20px),
            repeating-linear-gradient(90deg,#b77a7a,#b77a7a 1px,transparent 1px,transparent 20px),
            linear-gradient(rgba(183,122,122,.1),rgba(183,122,122,.1));
            background-blend-mode:overlay;background-size:20px 20px;min-height:100vh;margin:0;padding:0;font-family:Arial,sans-serif}
        .register-container{margin-top:50px}
        .card{border:none;border-radius:15px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.1)}
        .card-header{background-color:#D19C97;color:#fff}
        .custom-radio .form-check-input:checked+.form-check-label::before{background-color:#D19C97;border-color:#D19C97}
        .form-check-label{position:relative;padding-left:2rem;cursor:pointer}
        .form-check-label::before{content:"";position:absolute;left:0;top:50%;transform:translateY(-50%);
            width:1rem;height:1rem;border:2px solid #D19C97;border-radius:50%;background-color:#fff;transition:background-color .3s,border-color .3s}
        .form-check-input:focus+.form-check-label::before{box-shadow:0 0 0 .2rem rgba(209,156,151,.5)}
        .animate-pulse-custom{animation:pulse 2s infinite}
        @keyframes pulse{0%{transform:scale(1)}50%{transform:scale(1.05)}100%{transform:scale(1)}}
        
        /* Custom styles for country dropdown to match your theme */
        .country-select {
            width: 100% !important;
        }
        .country-select .flag {
            margin-right: 8px;
        }
        .country-select input {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            width: 100%;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .country-select input:focus {
            border-color: #D19C97;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(209, 156, 151, 0.25);
        }
        .country-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            margin-top: 2px;
            background-color: #fff;
            z-index: 1000;
        }
        .country-list .country {
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .country-list .country:hover {
            background-color: #f8f9fa;
        }
        .country-list .country.highlight {
            background-color: #D19C97;
            color: #fff;
        }
        .country-list .flag {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container register-container">
        <div class="row justify-content-center animate__animated animate__fadeInDown">
            <div class="col-md-6">
                <div class="card animate__animated animate__zoomIn">
                    <div class="card-header text-center highlight">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" class="mt-4" id="register-form">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Name <i class="fa fa-user"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="full_name" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <i class="fa fa-envelope"></i></label>
                                <input type="email" class="form-control animate__animated animate__fadeInUp" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <i class="fa fa-lock"></i></label>
                                <input type="password" class="form-control animate__animated animate__fadeInUp" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country <i class="fa fa-flag"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="country" name="country" placeholder="Type or select your country" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City <i class="fa fa-city"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="city" name="city" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Phone Number <i class="fa fa-phone"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="contact" name="contact" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Register As</label>
                                <div class="d-flex justify-content-start">
                                    <div class="form-check me-3 custom-radio">
                                        <input class="form-check-input" type="radio" name="role" id="customer" value="2" checked>
                                        <label class="form-check-label" for="customer">Customer</label>
                                    </div>
                                    <div class="form-check custom-radio">
                                        <input class="form-check-input" type="radio" name="role" id="owner" value="1">
                                        <label class="form-check-label" for="owner">Restaurant Owner</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-custom w-100 animate-pulse-custom">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Already have an account? <a href="login.php" class="highlight">Login here</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.1/js/countrySelect.min.js"></script>

    <script src="../js/register.js"></script>
</body>
</html>