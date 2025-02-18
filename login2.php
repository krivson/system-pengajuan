<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="login-wrapper">
    <!-- Logo -->
    <img src="../uploads/Telkom.png" alt="Company Logo" class="logo">
    
    <!-- Judul -->
    <h2 class="text-center">Login Teknisi</h2>
    <p class="text-center">Login terlebih dahulu</p>
    
    <!-- Pesan Error -->
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    
    <form method="POST">
    <div class="form-group username-container">
    <label for="username"><i class="fas fa-user"></i> Username</label>
    <input type="text" id="username" name="username" placeholder="Enter your username" required>
  
</div>
        
        <div class="form-group password-container">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
            </div>
        </div>
        
        <button type="submit" class="btn-login">Log In</button>
    </form>
</div>

<script>
function togglePassword() {
    let passwordField = document.getElementById("password");
    let toggleIcon = document.querySelector(".toggle-password");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
        
    }
}
</script>
</body>
</html>