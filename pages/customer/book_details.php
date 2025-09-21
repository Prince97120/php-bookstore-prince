<?php
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$book_id = $_GET['id'];

// Get book details
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND is_active = 1");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    $_SESSION['message'] = 'Book not found';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="text-center p-4 bg-light">
                    <?php if (!empty($book['image'])): ?>
                        <img src="<?php echo $book['image']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-white" style="height: 300px;">
                            <i class="fas fa-book fa-5x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h1>
                    <p class="text-muted h5">by <?php echo htmlspecialchars($book['author']); ?></p>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6"><?php echo htmlspecialchars($book['category']); ?></span>
                        <span class="badge bg-secondary fs-6">Published: <?php echo $book['publish_year']; ?></span>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-primary">$<?php echo number_format($book['price'], 2); ?></h3>
                        <p class="text-muted">
                            <i class="fas fa-box"></i> Stock: <?php echo $book['stock']; ?> available
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <?php if ($book['stock'] > 0): ?>
                            <form method="POST" action="actions/add_to_cart.php" class="d-inline">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="fas fa-times"></i> Out of Stock
                            </button>
                        <?php endif; ?>
                        
                        <a href="index.php" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Back to Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
