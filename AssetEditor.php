<?php
require 'Include/Config.php';
require 'Include/Functions.php';


//Populate Database fields
$id = (isset($_POST['id']) ? $_POST['id'] : '');
$assetName = (isset($_POST['assetName']) ? $_POST['assetName'] : '');
$serialNumber = (isset($_POST['serialNumber']) ? $_POST['serialNumber'] : '');
$assetCondition = (isset($_POST['assetCondition']) ? $_POST['assetCondition'] : '');
$assetDescription = (isset($_POST['assetDescription']) ? $_POST['assetDescription'] : '');
$assetImage = (isset($_POST['assetImage']) ? $_POST['assetImage'] : '');
$purchaseDate = date("Y-m-d H:i:s");


//Database setup
$conn = new mysqli('localhost', 'root', '', 'churchcrm');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO assets (assetName, serialNumber, assetCondition, assetDescription, assetImage, purchaseDate)
        VALUES(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sss", $assetName, $serialNumber, $assetCondition, $assetDescription, $assetImage, $purchaseDate);
    $stmt->execute();

    echo "New records created successfully";

    $stmt->close();
    $conn->close();
}






//Set the page title
require 'Include/Header.php';




?>

<div class="container">
    <div class="row col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h1>Add assets</h1>
            </div>
            <div class="panel-body">
                <form action="AssetEditor.php" method="post">

                    <div class="form-group">
                        <label for="assetName">Asset Name</label>
                        <input type="text" class="form-control" id="assetName" name="assetName" />
                    </div>

                    <div class="form-group">
                        <label for="serialNumber">Serial Number</label>
                        <input type="number" class="form-control" id="serialNumber" name="serialNumber" />
                    </div>

                    <div class="form-group mb-3">
                        <label for="assetCondition">Asset Condition</label>
                        <input type="radio" name="assetCondition" value="New"> New
                        <input type="radio" name="assetCondition" value="Used"> Used
                    </div>
                    <br>

                    <div class="form-group">
                        <label for="assetDescription">Asset Descritpion</label>
                        <input type="text" class="form-control" id="assetDescription" name="assetDescription" />
                    </div>

                    <div class="form-group">
                        <label for="assetImage">Asset Image</label>
                        <input type="file" class="form-control" id="assetImage" name="assetImage" />
                    </div>

                    <div class="form-group">
                        <label for="purchaseDate">Purchase Date</label>
                        <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" />
                    </div>

                    <input type="submit" class="btn btn-primary" />
                </form>
            </div>

        </div>
    </div>
</div>

<?php require 'Include/Footer.php' ?>