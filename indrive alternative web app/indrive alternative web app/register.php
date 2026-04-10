<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $phone]);
        
        $_SESSION['success'] = 'Registration successful! Please login.';
        header('Location: login.php');
        exit();
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Professional Real Estate Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Same CSS variables and base styles as login page */
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --secondary-color: #64748b;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --background-color: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%),
                        url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-wrapper {
            width: 100%;
            padding: 2rem;
        }

        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-3px);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-header h2 {
            color: #1e293b;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .auth-form .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }

        .btn-auth {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
        }

        .btn-auth:hover {
            background: var(--primary-hover);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .alert {
            padding: 0.75rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .row {
            display: flex;
            gap: 1rem;
            margin: 0 -0.5rem;
        }

        .col-md-6 {
            flex: 1;
            padding: 0 0.5rem;
        }

        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: var(--primary-hover);
        }

        @media (max-width: 768px) {
            .auth-card {
                padding: 1rem;
                margin: 0 1rem;
            }

            .row {
                flex-direction: column;
                gap: 0;
            }

            .col-md-6 {
                width: 100%;
                padding: 0;
            }

            .auth-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Join our Real Estate community</p>
        </div>
        
        <div class="auth-body">
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32)) ?>">
                
                <div class="form-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>

                <div class="form-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-auth">
                        <i class="fas fa-user-plus mr-2"></i> Register Now
                    </button>
                </div>

                <div class="text-center mt-4">
                    <span class="text-muted">Already have an account? </span>
                    <a href="login.php" class="auth-link">Sign In Here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>