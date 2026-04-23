<?php 
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm p-4">
                <h3 class="text-center text-primary mb-4">Create Account</h3>
                
                <?php
                // Only processes data if a POST request is sent
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $role = $_POST['role']; 

                    // Implements modern encryption by hashing the password before database storage
                    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    // Utilizes Prepared Statements to safeguard the system against SQL Injection
                    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $name, $email, $pass, $role);
                    
                    // Provides immediate user feedback upon successful operation
                    if($stmt->execute()){
                        echo "<div class='alert alert-success mt-3'>Registered! <a href='login.php' class='fw-bold'>Login here</a></div>";
                    }
                }
                ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Select Role</label>
                        <select name="role" class="form-select" required>
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none small text-muted">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
