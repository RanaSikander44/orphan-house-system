<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login To Roshni Crm Portal</title>
    <link rel="shortcut icon" href="{{ asset('backend/images/roshnilogo.jpg') }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery Toast Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

    <style>
        body {
            background-image: url('/backend/images/bg-login.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 420px;
            height: 390px;
            background-color: #f4fcff;
            /* Changed background color to skyblue */
            border-radius: 8px;
            /* Optional: Adds rounded corners for a softer look */
        }

        .form-heading {
            margin-bottom: 60px;
            /* 60px gap below the heading */
            font-weight: bold;
            /* Bolder heading */
        }
    </style>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <div class="border rounded p-4 shadow form-container">
                    <h3 class="text-center form-heading">Login</h3> 
                    <form id="loginForm" action="{{ route('loginMatch') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="useremail"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="d-flex justify-content-end mb-2">
                            <button type="submit" class="btn w-100 text-white"
                                style="background-color:#e28029;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            @if(session('error'))
                $.toast({
                    heading: 'Error',
                    text: '{{ session('error') }}',
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#f44336', // Red color for the loader
                });
            @endif
        });
    </script>




    <!-- 
    <script>
        $(document).ready(function () {
            $("#loginForm").on("submit", function (event) {
                event.preventDefault();

                var email = $("#useremail").val();
                var password = $("#password").val();

                $.ajax({
                    url: "{{ route('loginMatch') }}",  // Your login route
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email,
                        password: password
                    },
                    success: function (response) {
                        // Redirect or other actions on successful login
                        window.location.href = "admin/dashboard";
                        // $.toast({
                        //     heading: 'Success',
                        //     text: '<strong>Login Successful!</strong><br>Welcome back, John Doe. <a href="/dashboard" style="color: #fff; text-decoration: underline;">Go to Dashboard</a>',
                        //     showHideTransition: 'slide', // Can use 'fade', 'slide', or 'plain'
                        //     icon: 'success', // Dynamically set 'success', 'error', 'info', or 'warning'
                        //     position: 'top-right', // Toast will appear at the top-right
                        //     loader: true, // Enable progress bar
                        //     loaderBg: '#4CAF50', // Custom loader background color
                        //     bgColor: '#1E88E5', // Background color
                        //     textColor: '#ffffff', // Text color
                        //     hideAfter: 5000, // Auto close after 5 seconds
                        //     stack: 5, // Allow stacking up to 5 toasts
                        //     allowToastClose: true, // Allow users to close manually
                        //     afterHidden: function () {
                        //         console.log('Toast closed. Executing callback...');
                        //         // Perform any action after the toast is hidden
                        //     }
                        // });

                    },
                    error: function (xhr) {
                        // Show specific toast messages for invalid username or password
                        if (xhr.status === 400) {
                            $.toast({
                                heading: 'Error',
                                text: 'Invalid username. Please try again.',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right'  // Toast will appear at the top-right
                            });
                        } else if (xhr.status === 401) {
                            $.toast({
                                heading: 'Error',
                                text: 'Invalid password. Please try again.',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right'  // Toast will appear at the top-right
                            });
                        } else {
                            // Handle other error cases here
                            $.toast({
                                heading: 'Error',
                                text: 'An error occurred. Please try again.',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right'
                            });
                        }
                    }
                });
            });
        });
    </script> -->

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>