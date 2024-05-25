<style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .contact-section {
            background: #f8f9fa;
            padding: 50px 0;
        }
        .contact-info {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .contact-form {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-form textarea {
            resize: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #000;
        }
        .btn-submit {
            background: #000;
            color: #fff;
            border: none;
        }
        .btn-submit:hover {
            background: #333;
        }
    </style>

<section class="contact-section">
    <div class="container">
        <h1 class="text-center mb-5">Contact Us</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="contact-info">
                    <h4>Contact Information</h4>
                    <p>If you have any questions or need further information, please contact us:</p>
                    <ul class="list-unstyled">
                        <li><strong>Email:</strong> admin@mysite.com</li>
                        <li><strong>Phone:</strong> +123 456 7890</li>
                        <li><strong>Address:</strong> 1234 Street Name, City, Country</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-form">
                    <h4>Leave a Feedback</h4>
                    <!-- Відображення помилок -->
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($error_message as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                   
                    <form action="submitFeedback" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-submit btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

