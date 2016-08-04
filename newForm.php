<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="myStyle.css">
  </head>

<?php
$title = 'Survey for Future Visitor';
include 'header.php';
$formData = array();
$firstNameErr = $lastNameErr = $emailErr = $phoneErr="";
$firstName =  $lastName = $email =  $phone =  "";
$preferred = "";
function validateForm() {
	global $firstNameErr, $lastNameErr, $emailErr, $phoneErr, $firstName, $lastName, $email,  $phone, $comment, $preferred;

$errCount = 0 ;

  if (empty($_POST["firstName"])) {
     $firstNameErr = "First Name is required";
     $errCount++;
    
   } else {
     $firstName = testInput($_POST["firstName"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
       $firstNameErr="Only letters and white space allowed";
       $errCount++;
     }
   }

if (empty($_POST["lastName"])) {
     $lastNameErr = "Last Name is required";
     $errCount++;
     
   } else {
     $lastName = testInput($_POST["lastName"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
       $lastNameErr = "Only letters and white space allowed";
       $errCount++; 
   
     }
   }
    if (!empty($_POST["preferred"])) {
     $preferred = testInput($_POST["preferred"]);
     

 }

    if (empty($_POST["email"])) {
     $emailErr .= "Email is required";
     $errCount++;
   } else {
    $email=testInput($_POST["email"]);
     // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr .= "Invalid email format"; 
       $errCount++;
     }
   
     }

     if (empty($_POST["phone"])) {
     $phoneErr .= "Phone is required";
     $errCount++;

   } else {
    $phone=testInput($_POST["phone"]);

     if (!preg_match("/^\d{3}-\d{3}-\d{4}$/",$phone)) {
       $phoneErr .= "Invalid phone format";
       $errCount++;
     }
   
     }

    
    if (!empty($_POST["comment"])) {
     $comment = testInput($_POST["comment"]);
 }

    if ($errCount == 0) {
	//display confirmation and send email
	$preference = findname($firstname,$preferred);
	$summary = "<div id='results'><h2>Thank you for your participating ".$preference."</h2><br><h4>Summarizing your input: </h4><br>".$email."<br>".$phone."<br>".$comment."<br><br>You have done the folloving Requirements:<br>";
	$summary .=listPrereqs();
	$summary .=listFormFields();
	echo $summary;
	sendMyMsg ($summary);
 } else {
    buildForm();
	}
}


function sendMyMsg($msg) {
	$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .="Content-type : text/html;charset=UTF-8" . "\r\n";
		$headers .="From: ilknurgokcuoglu@hotmail.com";

		$to = "ilknurgokcuoglu@gmail.com";
		$subject = "Fall2015 JavaScriptPHP class roster";

		mail($to, $subject, $msg, $headers );

}

function testInput($data){
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function findName($firstName , $preferred) {
	if ($preferred == "") {
		$answer = $firstName;
	} else {
		$answer = $preferred;
	}
	return $answer;

}

function listFormFields() {
  
	if (isset($_POST['experience'])) {
		$r = 1;
		$answer = "<ul class = 'finish'>";
		$limit = count($_POST['experience']);
		$exper = $_POST['experience'];
		for ($i=1; $i<$limit; $i++) {
			$answer .= '<br><br>City:'.$i.' </label><input type = "text" name="experience[]" id="experience"'.$i.'" value= "'.$exper[$i].'">';	
		}
		$answer .= "</ul>";
	}  else {
		$answer = "";
	}
	return $answer;
}


function listPrereqs() {
	if(isset($_POST['prereqs'])) {
		$answer = "<ul class= 'finish'>";
		$preList = $_POST['prereqs'] ;
		foreach ( $preList as $myClass ) {
			$answer .= "<li>$myClass</li>";
		}
		$answer .= "</ul>";
	} else {
		$answer = "";
	}
	return $answer ;
}


startHere();
function startHere() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		validateForm();
	} else {
		buildForm();

	}
}

?>

<?php
function buildForm() {
	global $firstNameErr, $lastNameErr, $emailErr, $phoneErr, $firstName, 
	$lastName, $email,  $phone, $comment, $preferred;
?>
	<script src= "formFunctions.js"></script>
	<h1>
		Future Visitor Survey
	</h1>

	<div class= "intro">
		<h2>
			Tell us about yourself
		</h2>
		<p> This form will help us start organizing your trip faster and we will be reaching you as soon as you complete the survey. It helps us customize the whole-trip if you tell us a bit about your plans, specifically your desire destinations. The email and phone fields are pretty strict please make sure you follow the directions. If you want us to get ready for your trip, make sure that you provide correct information. Now you can start your survey. Talk to you soon!
		</p>

   <form id="survey"  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
   <label for="firstName">First Name: </label><input type="text" name="firstName" value="<?php echo $firstName;?>">
   <span class="error">* <?php echo $firstNameErr; ?></span>
   <br>

   <br>
   <label for="lastName">Last Name: </label><input type="text" name="lastName" value="<?php echo $lastName;?>">
   <span class="error">* <?php echo $lastNameErr; ?></span>
   <br>
 
   <br>
   <p>If you go by something other than your name...</p>
   <label for="preferred">Preferred: </label><input type="text" name="preferred" value="<?php echo $preferred;?>">
   <br>

   <br>
<fieldset>
  <legend>Contact Info</legend>
  <p class="disclaimer">Please provide us your e-mail address then we can connect with you as soon as possible.<br> For example; nobody@ucsc-extension.edu </p>
  <br>
  <label for="email"> Email: </label>
  <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr; ?></span>
  <br>
  <p class= "disclaimer">Please provide us your phone number then we can connect with you as soon as possible. Please follow  the directions.Such as; 800-555-1212</p>
  <br>
  <label for="phone">Phone: </label>
  <input type="tel" name="phone" id="phone" value="<?php echo $phone;?>">
  <span class="error">* <?php echo $phoneErr; ?> </span>
</fieldset>
<br>
<fieldset><legend>Trip Requirements</legend> 
<input type="checkbox" name="prereqs[]" value="passport"> Validate Passport<br>
<input type="checkbox" name="prereqs[]" value="visa"> Validate Visa <br>
</fieldset>
<br>
<fieldset><legend>Other Cities</legend>
<p class="disclaimer">Add other city names you would like to visit during your trip! Please add one city per field.</p>
    <ul id="extra"> 
    <?php
    if (isset($_POST['experience'])) {
      $myList = listFormFields();
    }else{
      $myList="";
    }
    echo  $myList;
    ?>

    </ul> <br>
    <br>
    <button type="button" class="add" onclick="buildExtraField()">Add City</button>
</fieldset>
 <br>

 <label for="comment">Expectations for this trip: <label><br>
  <br>
 <textarea name="comment" id="comment" id="comment" rows="5" cols="40" placeholder="Please tell us what else you would like us to do for you?"></textarea>	
 <br>
 <br>
 <input type="reset" name="clear" onclick="clearForm()" value="Clear Form">
 <input type="submit" name="submit" value="Register">
</form>

<?PHP

}
?>

</div>
<?php
include "footer.php"
?>
</html>


