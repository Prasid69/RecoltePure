<?php
include 'view/layout/header.php';
?>
<style>
    .faq-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 24px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        color: #333;
    }

    .faq-container h1 {
        color: #2c7a3f;
        text-align: center;
        margin-bottom: 20px;
    }

    .faq-item {
        margin-bottom: 18px;
    }

    .faq-item h3 {
        margin: 0 0 8px 0;
        color: #2c7a3f;
    }

    .faq-item p {
        margin: 0;
    }

    .nav {
        text-align: center;
        margin-top: 28px;
    }

    .nav a {
        margin: 6px;
        padding: 8px 16px;
        background: #2c7a3f;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .nav a:hover {
        background: #1e5a2e;
    }

    .page-header {
        margin-bottom: 24px;
    }
</style>




<div class="faq-container">
    <h1>Frequently Asked Questions (FAQ)</h1>

    <div class="faq-item">
        <h3>How do I create an account?</h3>
        <p>Click the "Sign Up" button and fill out the necessary details. Make sure to provide accurate contact and
            address information.</p>
    </div>

    <div class="faq-item">
        <h3>How can I become a seller (farmer)?</h3>
        <p>Use the farmer registration form available on the site. Once approved, you can create product listings and
            manage orders.</p>
    </div>

    <div class="faq-item">
        <h3>What payment methods are accepted?</h3>
        <p>We support multiple secure payment options—details are shown at checkout. Contact customer support if you
            need help.</p>
    </div>

    <div class="faq-item">
        <h3>Who handles shipping and delivery?</h3>
        <p>Sellers are responsible for arranging shipping. Delivery terms are listed on each product page; please
            contact the seller for specifics.</p>
    </div>

    <div class="faq-item">
        <h3>What is your return policy?</h3>
        <p>Return and refund policies are set by each seller. Inspect your order on delivery and report any issues
            within 24 hours.</p>
    </div>

    <div class="faq-item">
        <h3>How do I contact support?</h3>
        <p>Use the Contact page or email us directly through the contact form available on the site.</p>
    </div>

</div>
<?php include 'view/layout/footer.php'; ?>