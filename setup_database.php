<?php
// Database setup script
// Run this once to set up the database and create an admin user

require_once 'config/database.php';

try {
    // Read and execute the schema
    $sql = file_get_contents('database/schema.sql');
    
    // Split by semicolon and execute each statement
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    // Create a default admin user (you should change this password!)
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password, is_active) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['Admin User', 'admin@bookstore.com', '1234567890', $admin_password, 1]);
    
    echo "Database setup completed successfully!\n";
    echo "Default admin credentials:\n";
    echo "Email: admin@bookstore.com\n";
    echo "Password: admin123\n";
    echo "Please change these credentials after first login!\n";
    
} catch (Exception $e) {
    echo "Error setting up database: " . $e->getMessage() . "\n";
}
?>
