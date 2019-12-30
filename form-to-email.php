<?php
if(!isset($_POST['submit']))
{
  //This page should not be accessed directly. Need to submit the form.
  echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];
$date = $_POST['date'];
$number = $_POST['number'];

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}


$email_from = "$visitor_email";
$email_subject = "Appointment Request";
$email_body = "From: $name". "\n".
    "message:\n $message" . "\n Address:$date"  ."\n Number: $number";
    
$to = "medstreeremoval@gmail.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.

echo "<script type='text/javascript'>window.top.location='http://medstreeremoval.com/';</script>";

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
} 
?>