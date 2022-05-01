<?php
        use Twilio\Rest\Client;

session_start();
include "config.php";
if (isset($_POST['name']) && isset($_POST['address'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $name = $add = $phone = $status = $jobdes = $jobdate = $ref = '';
    $name = validate($_POST['name']);
    $add = validate($_POST['address']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']);
    $jobdes = validate($_POST['jobdes']);
    $jobdate = validate($_POST['jobdate']);
    $ref = validate($_POST['ref']);
    if (empty($name)||empty($add)||empty($phone)||empty($status)||empty($jobdes)||empty($jobdate)||empty($ref) ) {
        $_SESSION['msg']="You have to fill all field!";
        header("Location: home.php");
        exit();
    }else{

        require '../vendor/autoload.php';

       
        // Use the REST API Client to make requests to the Twilio REST API

        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC33b532a5098204235ca5f24644827377';
        $token = 'f0a32b64d33ae79625c92a2d255d07f1';
        $client = new Client($sid, $token);
        $body = "Name: ".$name.", Address: ".$add.", Phone: ".$phone.", Status: ".$status.", Job Description: ".$jobdes.", Job Date: ".$jobdate.", Ref: ".$ref;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            '+14168232377',
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+18608543558',
                // the body of the text message you'd like to send
                'body' => $body
            ]
        );

        $name = "'".$name."'";
        $add = "'".$add."'";
        $phone = "'".$phone."'";
        $status = "'".$status."'";
        $jobdes = "'".$jobdes."'";
        $jobdate = "'".$jobdate."'";
        $ref = "'".$ref."'";

        $sql = "INSERT INTO messages (name, address, phone, status, jobdes, jobdate, ref) VALUES ($name, $add, $phone, $status, $jobdes, $jobdate, $ref)";
        mysqli_query($conn, $sql);
        $_SESSION['msg'] = "SMS send Success!";
        header("Location: home.php");
    }
}else{
    header("Location: ../index.php");
    exit();
}

