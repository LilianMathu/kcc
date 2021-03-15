<?php

$sSERVERNAME = 'localhost';
$dbPort = '3306';
$sUSER = 'root';
$sPASSWORD = '';
$sDATABASE = 'churchcrm';

// Create connection
$conn = new mysqli($sSERVERNAME, $sUSER, $sPASSWORD, $sDATABASE);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="app.css">

    <title>Create a Product</title>
</head>

<body>
    <h1>Create a Product</h1>
    <!-- The action attribute specifies where the form should be submitted -->

    <form action="create.php" method="post">       
        <div class="form-group">
            <label>Product image</label> <br>
            <input type="file" name="image" >
        </div>

        <div class="form-group">
            <label>Product title</label>
            <input type="text" class="form-control" name="title" >
        </div>

        <div class="form-group">
            <label>Product description</label>
            <textarea class="form-control" name="description" ></textarea>
        </div>

        <div class="form-group">
            <label>Product price</label>
            <input type="number" step=".01" class="form-control" name="price    " >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</body>

</html>