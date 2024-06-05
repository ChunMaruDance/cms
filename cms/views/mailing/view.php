<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscriber List</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  <style>
    .form-group {
      margin-bottom: 20px;
    }
    .btn-primary {
      background-color: black;
      border-color: black;
    }
    .btn-primary:hover {
      background-color: #000 !important;
      border-color: #000 !important;
    }
    .contact-section {
      padding: 30px 0;
      background-color: #f9f9f9;
    }
    .contact-info {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .contact-info h4 {
      margin-bottom: 20px;
    }
    .contact-info ul li {
      margin-bottom: 10px;
    }
    .contact-form {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .contact-form h4 {
      margin-bottom: 20px;
    }
    .btn-submit {
      background-color: #000;
      color: #fff;
    }
    .btn-submit:hover {
      background-color: #000;
      color: #fff;
    }
  </style>
</head>
<body>
  <section class="contact-section" data-aos="fade-up">
    <div class="container">
      <h1 class="text-center mb-5">Mailing</h1>
      <div class="row">
        <div class="col-md-6" data-aos="fade-right">
          <div class="contact-info">
            <h4>Email Subscribers</h4>
            <ul class="list-unstyled">
              <?php foreach ($emails_subscribers as $email): ?>
                <li><?php echo $email; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <br>
          <div class="contact-info">
            <h4>Email Orders</h4>
            <ul class="list-unstyled">
              <?php foreach ($emails_orders as $email): ?>
                <li><?php echo $email; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-left">
          <div class="contact-form">
            <h4>Send Message</h4>
            <!-- Відображення помилок -->
            <div id="response-message" style="display: none;"></div>
            <form id="message-form">
              <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" required>
              </div>
              <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="5" required></textarea>
              </div>
              <div class="form-group">
                <label for="email">Email (optional)</label>
                <input type="email" class="form-control" id="email">
              </div>
              <br>
              <button type="submit" class="btn btn-submit btn-block">Send</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init();

    document.getElementById('message-form').addEventListener('submit', function(event) {
      event.preventDefault();

      const subject = document.getElementById('subject').value;
      const message = document.getElementById('message').value;
      const email = document.getElementById('email').value;
      const responseMessage = document.getElementById('response-message');

      fetch('/mailing/sendMessage', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ subject: subject, message: message, email: email })
      })
      .then(response => response.json())
      .then(data => {
        responseMessage.style.display = 'block';
        if (data.success) {
          responseMessage.className = 'alert alert-success';
        } else {
          responseMessage.className = 'alert alert-danger';
        }
        responseMessage.textContent = data.message;
      })
      .catch(error => {
        responseMessage.style.display = 'block';
        responseMessage.className = 'alert alert-danger';
        responseMessage.textContent = 'An error occurred. Please try again later.';
        console.error('Error:', error);
      });
    });
  </script>
</body>
</html>
