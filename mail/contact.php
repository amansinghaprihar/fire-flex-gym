

 <?php
// Check if the form is submitted and validate the input fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Validate the form fields
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If any of the fields are empty or the email is invalid, set the response and exit
        http_response_code(400);
        echo "Please fill in all the required fields and provide a valid email address.";
        exit;
    }

    // Sanitize the user input to prevent XSS
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    // Prepare the email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Prepare the email body
    $body = "You have received a new message from your website contact form:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Subject: $subject\n\n";
    $body .= "Message:\n$message\n";

    // Set the recipient email address
    $to = "amansinghparihar708@gmail.com";

    // Send the email
    $result = mail($to, $subject, $body, $headers);

    // Check if the email was sent successfully
    if ($result) {
        http_response_code(200);
        echo "Your message has been sent successfully!";
    } else {
        http_response_code(500);
        echo "Sorry, there was a problem sending your message. Please try again later.";
    }
}
?>