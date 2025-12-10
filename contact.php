<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Recolte Pure</title>
    <link rel="stylesheet" href="Contact.css">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="back-home">
            <a href="homepage.php">← Back to Home</a>
        </div>
        <h1>Get In Touch</h1>
        <p>We'd love to hear from you! Whether you have questions about our products or want to become a vendor, reach out to us.</p>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="contact-wrapper">
            <!-- Contact Info Cards -->
            <div class="contact-info">
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <h3>Visit Our Location</h3>
                        </div>
                    </div>
                    <div class="info-content">
                        <p>23 Rue de la Ferme<br>75015 Paris, France<br>Île-de-France</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">📞</div>
                        <div class="info-content">
                            <h3>Call Us</h3>
                        </div>
                    </div>
                    <div class="info-content">
                        <p>Main: <a href="tel:+33145678901">+33 1 45 67 89 01</a><br>
                        Vendor Info: <a href="tel:+33145678902">+33 1 45 67 89 02</a></p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">✉️</div>
                        <div class="info-content">
                            <h3>Email Us</h3>
                        </div>
                    </div>
                    <div class="info-content">
                        <p>General: <a href="mailto:contact@recoltepure.fr">contact@recoltepure.fr</a><br>
                        Vendors: <a href="mailto:vendeurs@recoltepure.fr">vendeurs@recoltepure.fr</a></p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="form-container">
                <h2>Send Us a Message</h2>
                <p class="subtitle">Fill out the form below and we'll get back to you within 24 hours</p>

                <?php
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success">Your message has been sent successfully! We\'ll get back to you soon.</div>';
                }
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-error">There was an error sending your message. Please try again.</div>';
                }
                ?>

                <form action="contact_process.php" method="POST" id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+33">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Choose a topic</option>
                            <option value="general">General Inquiry</option>
                            <option value="vendor">Become a Vendor</option>
                            <option value="products">Product Questions</option>
                            <option value="partnership">Partnership Opportunities</option>
                            <option value="feedback">Feedback & Suggestions</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Map Section with Google Maps -->
        <div class="map-section">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d83998.94722687767!2d2.277020999999999!3d48.856614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e670ae2e9e6c5f%3A0x1e4d5b95c4e7f87a!2sParis%2C%20France!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Recolte Pure. All rights reserved. | Connecting farmers with consumers in Paris.</p>
    </footer>
</body>
</html>