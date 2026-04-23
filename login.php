    <?php 
    include 'db.php';

    session_start();

    // Processes login data only when the form is submitted via POST method
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];

        //Uses Prepared Statements to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        //Verifies the entered password against the hashed version (encryption) stored in the database
        if($user && password_verify($_POST['password'], $user['password'])){
            
            //Securely stores user identity and permissions in session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            
            //Redirects authenticated users to the main dashboard
            header("Location: dashboard.php");
        } else {
            //Feedback mechanism for failed authentication attempts
            $error = "Invalid Credentials";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>Login - Assignment System</title>
    </head>
    <body class="d-flex align-items-center vh-100 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card shadow-sm p-4">
                        <h2 class="text-center text-primary mb-4">Login</h2>
                        
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger py-2" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0 text-muted small">Don't have an account?</p>
                            <a href="register.php" class="text-decoration-none fw-bold">Register here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
