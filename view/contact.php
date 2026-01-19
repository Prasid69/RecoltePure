<?php
include 'view/layout/header.php';
?>
<style>
    /* Scoped Contact Page Styles to avoid overlap */
    .cnt-hero {
        background: linear-gradient(135deg, #2e7d32 0%, #66bb6a 100%);
        color: white;
        padding: 60px 20px 100px;
        position: relative;
        text-align: center;
    }

    .back-home {
        position: absolute;
        top: 20px;
        left: 20px;
    }

    .back-home a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.95);
        color: #2e7d32;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .cnt-hero-content {
        max-width: 800px;
        margin: 40px auto 0;
    }

    .cnt-hero h1 {
        font-size: 48px;
        margin-bottom: 15px;
        font-weight: 700;
        color: white;
    }

    .cnt-hero p {
        font-size: 18px;
        opacity: 0.95;
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto;
        color: white;
    }

    .cnt-container {
        max-width: 1200px;
        margin: -60px auto 60px;
        padding: 0 20px;
        position: relative;
        z-index: 10;
    }

    .cnt-wrapper {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 30px;
        margin-bottom: 50px;
    }

    .cnt-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cnt-info-card {
        background: white !important;
        border-radius: 15px;
        padding: 24px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative !important;
        bottom: auto !important;
        left: auto !important;
        display: flex;
        flex-direction: column;
    }

    .cnt-info-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .cnt-info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        color: #2e7d32;
    }

    .cnt-info-card h3 {
        font-size: 17px;
        color: #333;
        font-weight: 600;
        margin: 0;
    }

    .cnt-form-container {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
    }

    .cnt-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .cnt-form-group label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .cnt-form-group input,
    .cnt-form-group textarea,
    .cnt-form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #2e7d32 0%, #66bb6a 100%);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .cnt-map-section {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-top: 50px;
    }

    .cnt-map-title {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
        text-align: center;
    }

    .cnt-map-container {
        border-radius: 12px;
        overflow: hidden;
        height: 450px;
        width: 100%;
    }

    .cnt-map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    @media (max-width: 968px) {
        .cnt-wrapper {
            grid-template-columns: 1fr;
        }

        .cnt-form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="cnt-hero">
    <div class="back-home">
        <a href="index.php?page=home">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to Home
        </a>
    </div>
    <div class="cnt-hero-content">
        <h1>Get In Touch</h1>
        <p>We'd love to hear from you! Whether you have questions about our products or want to become a vendor, reach
            out to us.</p>
    </div>
</section>

<div class="cnt-container">
    <div class="cnt-wrapper">
        <!-- Contact Info Cards -->
        <div class="cnt-info">
            <div class="cnt-info-card">
                <div class="cnt-info-card-header">
                    <div class="cnt-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3>Visit Our Location</h3>
                </div>
                <div class="cnt-info-card-content">
                    <p>23 Rue de la Ferme<br>75015 Paris, France<br>Île-de-France</p>
                </div>
            </div>

            <div class="cnt-info-card">
                <div class="cnt-info-card-header">
                    <div class="cnt-info-icon"><i class="fas fa-phone-alt"></i></div>
                    <h3>Call Us</h3>
                </div>
                <div class="cnt-info-card-content">
                    <p>Main: <a href="tel:+33145678901">+33 1 45 67 89 01</a><br>
                        Vendor: <a href="tel:+33145678902">+33 1 45 67 89 02</a></p>
                </div>
            </div>

            <div class="cnt-info-card">
                <div class="cnt-info-card-header">
                    <div class="cnt-info-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Email Us</h3>
                </div>
                <div class="cnt-info-card-content">
                    <p>General: <a href="mailto:contact@recoltepure.fr">contact@recoltepure.fr</a><br>
                        Vendors: <a href="mailto:vendeurs@recoltepure.fr">vendeurs@recoltepure.fr</a></p>
                </div>
            </div>
        </div>

        <div class="cnt-form-container">
            <div class="cnt-form-header">
                <h2>Send Us a Message</h2>
            </div>

            <?php if (isset($successMsg)): ?>
                <div class="alert alert-success"><?php echo $successMsg; ?></div>
            <?php endif; ?>

            <?php if (isset($errorMsg)): ?>
                <div class="alert alert-error"><?php echo $errorMsg; ?></div>
            <?php endif; ?>

            <form action="index.php?page=contact" method="POST" id="contactForm">
                <div class="cnt-form-row">
                    <div class="cnt-form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" id="firstName" name="firstName" required>
                    </div>

                    <div class="cnt-form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" required>
                    </div>
                </div>

                <div class="cnt-form-row">
                    <div class="cnt-form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="cnt-form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="+33 X XX XX XX XX">
                    </div>
                </div>

                <div class="cnt-form-group">
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

                <div class="cnt-form-group">
                    <label for="message">Your Message <span class="required">*</span></label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>

                <button type="submit" class="submit-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <div class="cnt-map-section">
        <h2 class="cnt-map-title">Find Us On Map</h2>
        <div class="cnt-map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d83998.94722687767!2d2.277020999999999!3d48.856614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e670ae2e9e6c5f%3A0x1e4d5b95c4e7f87a!2sParis%2C%20France!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>

<?php include 'view/layout/footer.php'; ?>