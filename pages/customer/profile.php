<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?page=login');
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address_street = $_POST['address_street'];
    $address_city = $_POST['address_city'];
    $address_state = $_POST['address_state'];
    $address_zip = $_POST['address_zip'];
    
    // Simple validation
    if (empty($name) || empty($email) || empty($phone)) {
        $_SESSION['message'] = 'Please fill in all required fields';
        $_SESSION['message_type'] = 'danger';
    } else {
        // Check if email is already used by another user
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user_id]);
        if ($stmt->fetch()) {
            $_SESSION['message'] = 'Email already exists';
            $_SESSION['message_type'] = 'danger';
        } else {
            // Update user profile
            $stmt = $pdo->prepare("
                UPDATE users 
                SET name = ?, email = ?, phone = ?, address_street = ?, address_city = ?, address_state = ?, address_zip = ? 
                WHERE id = ?
            ");
            if ($stmt->execute([$name, $email, $phone, $address_street, $address_city, $address_state, $address_zip, $user_id])) {
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['message'] = 'Profile updated successfully!';
                $_SESSION['message_type'] = 'success';
                
                // Refresh user data
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch();
            } else {
                $_SESSION['message'] = 'Error updating profile. Please try again.';
                $_SESSION['message_type'] = 'danger';
            }
        }
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-user"></i> My Profile</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Profile Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                            </div>
                        </div>
                        
                        <hr>
                        <h6>Address Information</h6>
                        
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="address_street" class="form-label">Street Address</label>
                                <input type="text" class="form-control" id="address_street" name="address_street" value="<?php echo htmlspecialchars($user['address_street']); ?>">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="address_city" class="form-label">City</label>
                                <input type="text" class="form-control" id="address_city" name="address_city" value="<?php echo htmlspecialchars($user['address_city']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="address_state" class="form-label">State</label>
                                <input type="text" class="form-control" id="address_state" name="address_state" value="<?php echo htmlspecialchars($user['address_state']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="address_zip" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" id="address_zip" name="address_zip" value="<?php echo htmlspecialchars($user['address_zip']); ?>">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Account Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                    <p><strong>Account Status:</strong> 
                        <?php if ($user['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </p>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="index.php?page=orders" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag"></i> View Orders
                        </a>
                        <a href="index.php?page=cart" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
