<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Recolte Pure</title>
    <link rel="stylesheet" href="../assets/css/Contact.css">
    
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="back-home">
            <a href="homepage.php">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
        <div class="hero-content">
            <h1>Get In Touch</h1>
            <p>We'd love to hear from you! Whether you have questions about our products or want to become a vendor, reach out to us.</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="contact-wrapper">
            <!-- Contact Info Cards -->
            <div class="contact-info">
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">📍</div>
                        <h3>Visit Our Location</h3>
                    </div>
                    <div class="info-card-content">
                        <p>23 Rue de la Ferme<br>75015 Paris, France<br>Île-de-France</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">📞</div>
                        <h3>Call Us</h3>
                    </div>
                    <div class="info-card-content">
                        <p>Main: <a href="tel:+33145678901">+33 1 45 67 89 01</a><br>
                        Vendor: <a href="tel:+33145678902">+33 1 45 67 89 02</a></p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">✉️</div>
                        <h3>Email Us</h3>
                    </div>
                    <div class="info-card-content">
                        <p>General: <a href="mailto:contact@recoltepure.fr">contact@recoltepure.fr</a><br>
                        Vendors: <a href="mailto:vendeurs@recoltepure.fr">vendeurs@recoltepure.fr</a></p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="form-container">
                <div class="form-header">
                    <h2>Send Us a Message</h2>
                    <p>Fill out the form below and we'll get back to you within 24 hours</p>
                </div>

                <?php
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            Your message has been sent successfully! We\'ll get back to you soon.
                          </div>';
                }
                if (isset($_GET['error'])) {
                    $errorMsg = 'There was an error sending your message. Please try again.';
                    if ($_GET['error'] == 'required') {
                        $errorMsg = 'Please fill in all required fields.';
                    } elseif ($_GET['error'] == 'email') {
                        $errorMsg = 'Please enter a valid email address.';
                    }
                    echo '<div class="alert alert-error">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            ' . $errorMsg . '
                          </div>';
                }
                ?>

                <form action="contact_process.php" method="POST" id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name <span class="required">*</span></label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last Name <span class="required">*</span></label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+33 X XX XX XX XX">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject <span class="required">*</span></label>
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
                        <label for="message">Your Message <span class="required">*</span></label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <h2 class="map-title">Find Us On Map</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d83998.94722687767!2d2.277020999999999!3d48.856614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e670ae2e9e6c5f%3A0x1e4d5b95c4e7f87a!2sParis%2C%20France!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <h3> Recolte Pure</h3>
                <p>Connecting farmers with consumers in Paris</p>
            </div>
            <div class="footer-links">
                <a href="homepage.php">Home</a>
                <a href="categories.php">Categories</a>
                <a href="best team.php">Our Team</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Recolte Pure. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Form validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();

            if (!firstName || !lastName || !email || !subject || !message) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                return false;
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>