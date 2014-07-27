<?php

// Change email and subject.
$email_to = "publicarray@icloud.com";
$subject = "My Profile";

// Error Checking, Validation and Sanitisation of user input.
$error = '';
$email_exp = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
$string_exp = "/^[A-Za-z .'-äüöÄÜÖ]+$/";

if (strlen($_POST['title'] > 0)) {
    $error.= 'Sorry, but it appears a Spam Boot is trying to submit this form. <br>';
}

if (empty($_POST['name'])) {
    $error.= 'Please enter your Name. <br>';
} else {
    $name = htmlspecialchars($_POST['name']);
    if(!preg_match($string_exp, $name)) {
      $error.= 'You entered unknown characters as your Name. Use A-Z, dots or slashes only. <br>';
    }
}

if (empty($_POST['subject'])) {
    // $error.= 'Please enter a Subject. <br>';
} else {
    $subject = htmlspecialchars($_POST['subject']);
}

if (empty($_POST['email'])) {
    $error.= 'Please enter an Email Address. <br>';
} else {
    $email = htmlspecialchars($_POST['email']);
    if(!preg_match($email_exp, $email)) {
      $error.= 'Please enter a valid Email Address. <br>';
    }
}

if (empty($_POST['message'])) {
    $error.= 'Please enter a Message. <br>';
} else {
    $message = htmlspecialchars($_POST['message']);
    if(strlen($message) < 3) {
      $error.= 'Please enter a Message. <br>';
    }
}

// If there are no errors than send the email otherwise show error message(s) and redirect back to index.php
if (empty($error)) {
    sendEmail($name, $email, $email_to, $subject, $message);
} else{
    echo '<div class="block"><div class="alert red">'.$error.'</div></div>';
    exit;
}

// Send email method
function sendEmail($name, $email_from, $email_to, $email_subject, $message){

    // check strings for cross site scripting (illegal characters).
    function clean_string($string) {

        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_message = "Name: ".clean_string($name)."\r\n";
    $email_message .= "Email: ".clean_string($email_from)."\r\n";
    $email_message .= "Message: \r\n".clean_string($message)."\r\n";
    $email_message = wordwrap($email_message, 70, "\r\n");

    // create email headers From, Cc and Bcc.
    $headers = 'From: '.$email_from."\r\n".
    // $headers .= "Cc: publicarray@icloud.com\r\n";
    // $headers .= "Bcc: admin@publicarray.com\r\n";

    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    set_time_limit(0);

    // actually send email & redirect
    if (mail($email_to, $email_subject, $email_message, $headers)){
        echo '<div class="block"><div class="alert green">Message Send!</div></div>';
    }
    else {
        echo '<div class="block"><div class="alert red">Sorry, but it there was a problem sending this email. <br /> Please try again later or send it  directly to: admin@publicarray.com</div></div>';
    }
}

    ?>
