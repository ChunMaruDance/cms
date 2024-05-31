<body>
    <h1>Trends Management</h1>

    <!-- Форма для додавання нового тренду -->
    <form action="/trends/add" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="subtitle">Subtitle:</label>
        <input type="text" id="subtitle" name="subtitle" required>
        <br>
        <label for="text">Text:</label>
        <textarea id="text" name="text" rows="4" required></textarea>
        <br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <br>
        <button type="submit">Add Trend</button>
    </form>

    <hr>
    <ul>
        <?php foreach ($trends as $trend): ?>
            <li>
                <h2><?php echo $trend['title']; ?></h2>
                <h3><?php echo $trend['subtitle']; ?></h3>
                <p><?php echo $trend['text']; ?></p>
                <img src="<?php echo $trend['image']; ?>" alt="Trend Image" width="200">
                
                <form action="/trends/delete/<?php echo $trend['id']; ?>" method="POST">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>