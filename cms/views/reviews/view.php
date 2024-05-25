<section class="feedback-section">
    <div class="container">
        <br>
        <h1 class="text-center mb-5">Feedback</h1>
        <?php if (!empty($reviews)): ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($reviews as $index => $review): ?>
                    <div class="col">
                        <div class="card h-100 mb-4">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $review->name; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $review->email; ?></h6>
                                <p class="card-text flex-grow-1"><?php echo $review->message; ?></p>
                                <p class="card-text"><small class="text-muted">Created at: <?php echo date('Y-m-d H:i:s', strtotime($review->created_at)); ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No feedback available.</p>
        <?php endif; ?>
    </div>
</section>