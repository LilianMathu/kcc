<?php
//Database setup
require 'Include/Config.php';
require 'Include/Functions.php';

//Set the page title
require 'Include/Header.php';

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$number = $_POST['number'];

// Database connection

$sSERVERNAME = 'localhost';
$dbPort = '3306';
$sUSER = 'root';
$sPASSWORD = '';
$sDATABASE = 'churchcrm';


// Database connection
$conn = new mysqli($sSERVERNAME, $sUSER, $sPASSWORD, $sDATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }  

$sql = "insert into testassets (lastName, email) 
    values ('$lastName', '$email')";

    
if (mysqli_query($conn, $sql)) {
    echo "DB connected successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

// else {
// 	$stmt = $conn->prepare
// 	$stmt->bind_param($firstName, $lastName, $lastName, $email, $password, $number);
// 	$execval = $stmt->execute();
// 	echo $execval;
// 	echo "Registration successfully...";
// 	$stmt->close();
// 	$conn->close();
//}

?>


<div class="container">
    <div class="row col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h1>Registration Form</h1>
            </div>
            <div class="panel-body">
                <form action="connect.php" method="post">
                    
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" />
                    </div>
                   
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" />
                    </div>
                   
                    <input type="submit" class="btn btn-primary" />
                </form>
            </div>

        </div>
    </div>
</div>

<?php require 'Include/Footer.php' ?>