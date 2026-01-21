<?php
session_start();

// Include database connection
include('db_connection.php');

// Check if connection exists
if (!isset($conn)) {
    die("Database connection failed. Please check db_connection.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
        header("Location: contact.php?error=required");
        exit();
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=email");
        exit();
    }
    
    try {
        // Insert into database
        $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            header("Location: contact.php?error=database");
            exit();
        }
        
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $subject, $message);
        
        if ($stmt->execute()) {
            // Optional: Send email notification
            // Uncomment the lines below if you want email notifications
            /*
            $to = "contact@recoltepure.fr";
            $email_subject = "New Contact Form Submission: " . $subject;
            $email_body = "Name: $firstName $lastName\n";
            $email_body .= "Email: $email\n";
            $email_body .= "Phone: $phone\n";
            $email_body .= "Subject: $subject\n\n";
            $email_body .= "Message:\n$message\n";
            
            $headers = "From: noreply@recoltepure.fr\r\n";
            $headers .= "Reply-To: $email\r\n";
            
            mail($to, $email_subject, $email_body, $headers);
            */
            
            $stmt->close();
            $conn->close();
            
            // Redirect with success message
            header("Location: contact.php?success=1");
            exit();
        } else {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            $conn->close();
            header("Location: contact.php?error=database");
            exit();
        }
        
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        if (isset($conn)) {
            $conn->close();
        }
        header("Location: contact.php?error=server");
        exit();
    }
    
} else {
    // If not POST request, redirect to contact page
    header("Location: contact.php");
    exit();
}
?>