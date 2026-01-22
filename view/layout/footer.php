<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>About RecoltePure</h3>
            <p>Delivering fresh, organic produce directly from local farms to your doorstep. Quality you can trust.</p>
        </div>

        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php?page=home">Home</a></li>
                <li><a href="index.php?page=categories">Products</a></li>
                <li><a href="index.php?page=farmers">Our Farmers</a></li>
                <li><a href="index.php?page=contact">Contact Us</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Support</h3>
            <ul>
                <li><a href="index.php?page=faq">FAQ</a></li>
                <li><a href="index.php?page=terms_and_conditions">Terms & Conditions</a></li>
                <li><a href="index.php?page=contact">Customer Support</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Contact</h3>
            <p>Email: support@recoltepure.com</p>
            <p>Phone: +1 (555) 123-4567</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy;
            <?= date('Y'); ?> RecoltePure. All rights reserved.
        </p>
    </div>
</footer>

<style>
    .footer {
        background: linear-gradient(135deg, #2c7a3f 0%, #1e5a2e 100%);
        color: #fff;
        padding: 40px 20px 20px;
        margin-top: 60px;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .footer-section h3 {
        color: #fff;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .footer-section p,
    .footer-section ul {
        margin: 10px 0;
        line-height: 1.8;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin: 8px 0;
    }

    .footer-section a {
        color: #e0f2e5;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section a:hover {
        color: #fff;
        text-decoration: underline;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .footer-bottom p {
        margin: 0;
        font-size: 0.9rem;
    }
</style>