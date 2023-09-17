<?php
if (isset($_POST['Email'])) {
    // Define email recipient and subject
    $email_to = "eneshalilovic@ymail.com";
    $email_subject = "Neue Nachricht";

    // Function to handle errors
    function handle_error($error)
    {
        echo "We're sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // Validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        handle_error("There appears to be a problem with the form you submitted.");
    }

    $name = $_POST['Name'];     // required
    $email = $_POST['Email'];   // required
    $message = $_POST['Message']; // required

    $error_message = "";

    // Validate email using filter_var
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message .= 'Die Email die Sie eingegeben Haben schein nicht richtig zu sein.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered does not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        handle_error($error_message);
    }

    $email_message = "Form details below.\n\n";
    
    // Function to clean input
    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // Create email headers
    $headers = 'From: ' . clean_string($email) . "\r\n" .
        'Reply-To: ' . clean_string($email) . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (@mail($email_to, $email_subject, $email_message, $headers)) {
        // Success message
        echo "Vielen Dank für die Kontaktaufnahme. Ich melde mich bei Ihnen schnellstmöglich.";
    } else {
        // Error sending email
        echo "Es ist ein Fehler aufgetreten, bitte versuchen sie es nochmal.";
    }
}
?>