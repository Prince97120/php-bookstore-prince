<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore - Footer</title>
</head>
<body>
    <footer class="bg-dark text-light mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-book"></i> BookStore</h5>
                    <p class="text-muted">Your one-stop destination for amazing books. Discover, read, and build your personal library with us.</p>
                </div>
                <div class="col-md-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="index.php?page=login" class="text-muted text-decoration-none">Login</a></li>
                        <li><a href="index.php?page=register" class="text-muted text-decoration-none">Register</a></li>
                        <li><a href="index.php?page=admin" class="text-muted text-decoration-none">Admin</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Contact Info</h6>
                    <p class="text-muted mb-1">
                        <i class="fas fa-envelope"></i> info@bookstore.com
                    </p>
                    <p class="text-muted mb-1">
                        <i class="fas fa-phone"></i> +1 (555) 123-4567
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt"></i> 123 Book Street, Library City
                    </p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">
                        &copy; <?php echo date('Y'); ?> BookStore. All rights reserved. | 
                        Made with <i class="fas fa-heart text-danger"></i> for book lovers
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>