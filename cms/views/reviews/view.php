<?php
$this->Title = 'Перегляд повідомлень';
?>
<head>
  <link rel="stylesheet" href="/css/reviewView.css">
</head>
<section class="feedback-section py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h1 class="text-center mb-5 text-dark">Повідомлення</h1>
        <?php if (!empty($reviews)): ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($reviews as $index => $review): ?>
                    <div class="col">
                        <div class="card h-100 mb-4 shadow-sm hover-card">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-dark"><?php echo htmlspecialchars($review->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($review->email, ENT_QUOTES, 'UTF-8'); ?></h6>
                                <p class="card-text flex-grow-1 text-dark"><?php echo htmlspecialchars($review->message, ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="card-text"><small class="text-muted">Created at: <?php echo date('Y-m-d H:i:s', strtotime($review->created_at)); ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No feedback available.</p>
        <?php endif; ?>
    </div>
</section>
