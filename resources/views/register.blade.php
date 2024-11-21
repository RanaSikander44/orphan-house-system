<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            /* Light gray background */
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 80px;
        }

        .border {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow around the form */
            background-color: #fff;
            /* White background for the form */
        }

        h3 {
            color: #007bff;
            /* Bootstrap primary color for heading */
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #4e555b;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="border rounded p-4">
                    <h3 class="text-center mb-4">Register</h3>
                    <form action="{{ route('registerSave') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="username" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userpassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3">
                            <label for="userpassword-confirm" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="userpassword-confirm" placeholder="Confirm your password" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>

                @if ($errors->any())
                    <div class="card-footer text-body-secondary">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
