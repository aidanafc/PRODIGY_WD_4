<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // reCAPTCHA secret key
    $recaptchaSecret = '6Lf-PVUrAAAAANnf633jWxpnvbtnvNF92rvdXnzS';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify reCAPTCHA
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $response = json_decode($verify);

    if ($response->success) {
        // Replace with your real email address
        $to = "contact@aidanrodrigues.dev";
        $subject = "New Contact Form Submission";

        // Get form values safely
        $name = htmlspecialchars($_POST["fullname"]);
        $email = htmlspecialchars($_POST["email"]);
        $message = htmlspecialchars($_POST["message"]);

        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Email body
        $body = "You have a new message from your website contact form:\n\n";
        $body .= "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Message:\n$message\n";

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('We Have Received your Message!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Sorry, something went wrong. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.'); window.history.back();</script>";
    }
} else {
    // Block direct access
    http_response_code(403);
    echo "There was a problem with your submission.";
}
?>
