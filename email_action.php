<?php

// Change email and subject.
$email_to = "publicarray@icloud.com";

// Error Checking, Validation and Sanitisation of user input.
$error = '';
$email_exp = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
$string_exp = "/^[A-Za-z .'-äüöÄÜÖ]+$/";

function has_header_injection ($str) {
    return preg_match("/[\r\n]/", $str);
}

$spam = $_POST['title'];
$name = htmlspecialchars(trim($_POST['name']));
$subject = htmlspecialchars(trim($_POST['subject']));
$email_from = htmlspecialchars(trim($_POST['email']));
$message = htmlspecialchars($_POST['message']);

if (has_header_injection($name) || has_header_injection($subject) || has_header_injection($email_from))

if (strlen($spam > 0)) {
    $error.= 'Sorry, but it appears a Spam Boot is trying to submit this form. <br>';
}

if (empty($name)) {
    $error.= 'Please enter your Name. <br>';
} else {
    if(!preg_match($string_exp, $name)) {
      $error.= 'You entered unknown characters as your Name. Use A-Z, dots or slashes only. <br>';
    }
}

if (empty($subject)) {
    // $error.= 'Please enter a Subject. <br>';
} else {
    if(!preg_match($string_exp, $name)) {
      $error.= 'You entered unknown characters as your Subject. Use A-Z, dots or slashes only. <br>';
    }
}

if (empty($email_from)) {
    $error.= 'Please enter an Email Address. <br>';
} else {
    if(!preg_match($email_exp, $email_from)) {
      $error.= 'Please enter a valid Email Address. <br>';
    }
}

if (empty($message)) {
    $error.= 'Please enter a Message. <br>';
} else {
    if(strlen($message) < 3) {
      $error.= 'Please enter a Message. <br>';
    }
}

// If there are no errors than send the email otherwise show error message(s) and redirect back to index.php
if (empty($error)) {
    sendEmail($name, $email_from, $email_to, $subject, $message);
} else{
    echo '<div class="block"><div class="alert red">'.$error.'</div></div>';
    exit;
}

// Send email method
function sendEmail($name, $from, $to, $user_subject, $msg){

    // check strings for cross site scripting (illegal characters).
    function clean_string($string) {

        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }
    $subject = "$name send you a message via your contact form";

    $message = "Name: ".clean_string($name)."\r\n";
    $message .= "Email: ".clean_string($from)."\r\n";
    if (isset($subject)) {
        $message .= "Subject: ".clean_string($user_subject)."\r\n";
    }
    $message .= "Message: \r\n".clean_string($msg)."\r\n";
    $message = wordwrap($message, 72);

    // create email headers From, Cc and Bcc.
    $headers = "MINE-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "From: $name <$from>\r\n";
    // $headers .= "Cc: publicarray@icloud.com\r\n";
    // $headers .= "Bcc: admin@publicarray.com\r\n";

    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    set_time_limit(0);

    // actually send email & redirect
    if (mail($to, $subject, $message, $headers)){
        echo '<div class="block"><div class="alert green">Message Send!</div></div>';
    }
    else {
        echo '<div class="block"><div class="alert red">Sorry, but it there was a problem sending this email. <br /> Please try again later or send it  directly to: admin@publicarray.com</div></div>';
    }
}

    ?>
