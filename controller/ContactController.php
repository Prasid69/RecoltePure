<?php
// controllers/ContactController.php

// Include the model
require_once "config/db_connection.php";
require_once 'model/Contact.php';

class ContactController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new ContactModel($dbConnection);
    }

    public function index() {
        $errorMsg = null;
        $successMsg = null;

        // Check for Success Message from Redirect
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $successMsg = "Your message has been sent successfully! We'll get back to you soon.";
        }

        // Handle POST Request (Form Submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmission($errorMsg);
        }

        // Load the View
        // Note: We use 'include' so the view can access $errorMsg and $successMsg
        include 'view/contact.php';
    }

    private function handleSubmission(&$errorMsg) {
        // Sanitize
        $firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
        $lastName  = htmlspecialchars(trim($_POST['lastName'] ?? ''));
        $email     = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone     = htmlspecialchars(trim($_POST['phone'] ?? ''));
        $subject   = htmlspecialchars(trim($_POST['subject'] ?? ''));
        $message   = htmlspecialchars(trim($_POST['message'] ?? ''));

        // Validate
        if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
            $errorMsg = "Please fill in all required fields.";
            return;
        } 
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg = "Please enter a valid email address.";
            return;
        }

        // Save using Model
        if ($this->model->saveMessage($firstName, $lastName, $email, $phone, $subject, $message)) {
            // Redirect to the ROUTE, not the file
            header("Location: index.php?page=contact&status=success");
            exit();
        } else {
            $errorMsg = "Database error. Please try again later.";
        }
    }
}
?>