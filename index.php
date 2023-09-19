<?php

        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    $errName = $errEmail = $errNumber = $errMessage  = $result = $message = '';

    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $message = $_POST['message'];

    
        // Check if name has been entered
        if (empty($name)) {
            $errName = 'Please enter your name';
        }

        // Check if email has been entered and is valid
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errEmail = 'Please enter a valid email address';
        }

        if (empty($number)) {
            $errNumber = 'Please enter Number';
        }

        // Check if message has been entered
        if (empty($message)) {
            $errMessage = 'Please enter your message';
        }

        // If there are no errors, send the email
        if (empty($errName) && empty($errEmail) && empty($errNumber) && empty($errMessage)) {

                                
                //Load Composer's autoloader
                require 'PHPMailer/Exception.php';
                require 'PHPMailer/PHPMailer.php';
                require 'PHPMailer/SMTP.php';

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
             
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'example@gmail.com';                     //SMTP username
                    $mail->Password   = 'password';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('example@gmail.com', 'Contact Form');
                    $mail->addAddress('example@gmail.com', 'Our website');     //Add a recipient
                

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'From Contact Form';
                    $mail->Body    = "Name:- $name <br> Email:- $email <br> Mob No:- $number <br> Message:- $message " ;
                

                  if( $mail->send()){
                        $result = "Thank You! Your message send successfuly";
                
                  }else{
                    $result = " ";
                  }
                } catch (Exception $e) {
                    $result =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

          
   }

        // Database connection and insert
        $conn = mysqli_connect("localhost", "root", "", "contact_form");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "INSERT INTO tbl_contact (name, email, number, message) VALUES ('$name', '$email','$number', '$message')";
        if (mysqli_query($conn, $query)) {
            $message = "Successfully Added.";
        } else {
            $message = "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap contact form with PHP example by BootstrapBay.com.">
    <meta name="author" content="BootstrapBay.com">
    <title> Contact Form </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <style>
      body {
        background-image: url("https://images.pexels.com/photos/33999/pexels-photo.jpg?cs=srgb&dl=pexels-negative-space-33999.jpg&fm=jpg");
        background-repeat: no-repeat;
        background-size: cover;

    }
      </style>
</head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center">Contact Form</h1>
				<form class="form-horizontal" role="form" method="post" action="index.php">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"  />
							<span><?php echo "<p class='text-danger'>$errName</p>";?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email" />
							<?php echo "<p class='text-danger'>$errEmail</p>";?>
						</div>
					</div>
                    <div class="form-group">
						<label for="number" class="col-sm-2 control-label">Number</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" id="number" name="number" placeholder="Mob No" />
							<?php echo "<p class='text-danger'>$errNumber</p>";?>
						</div>
					</div>
					<div class="form-group">
						<label for="message" class="col-sm-2 control-label fs-3">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="4" name="message"></textarea>
							<?php echo "<p class='text-danger'>$errMessage</p>";?>
						</div>
					</div>
				
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo "<script> alert('$result');</script>"; ?>
							<?php echo "<script> alert('$message');</script>"; ?>

						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>   
   
 
  </body>
</html>
