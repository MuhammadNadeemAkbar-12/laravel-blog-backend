<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | My Laravel Site</title>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
</head>
<body>
    <section class="contact-section">
        <div class="container">
            <h2>Contact Us</h2>
            <p>We’d love to hear from you! Fill out the form below and we’ll get in touch soon.</p>

            <form action="#" class="contact-form">
                <input type="text" placeholder="Your Name" required>
                <input type="email" placeholder="Your Email" required>
                <textarea placeholder="Your Message" rows="5" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>
</body>
</html>
