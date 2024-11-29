<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background-color: #f4fcff; /* Changed background color to skyblue */
            border-radius: 8px; /* Optional: Adds rounded corners for a softer look */
        }

        .form-heading {
            margin-bottom: 60px; /* 60px gap below the heading */
        }
    </style>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <div class="border rounded p-4 shadow form-container">
                    <h3 class="text-center form-heading">Login</h3>
                    <form action="{{ route('loginMatch') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="useremail"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label for="userpassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                @if ($errors->any())
                    <div class="mt-3 alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
