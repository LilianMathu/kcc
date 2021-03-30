<?php
//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Utility classes
use ChurchCRM\Utils\InputUtils;

//Set page title
$sPageTitle = gettext('Asset Editor');

//DB fields
if (isset($_POST['save'])) {
    //Get all the variables from the request object and assign them locally
    $sassetName = InputUtils::LegacyFilterInput($_POST['assetName']);
    $sserialNumber = InputUtils::LegacyFilterInput($_POST['serialNumber']);
    $squantity = InputUtils::LegacyFilterInput($_POST['quantity']);
    $sassetCondition = InputUtils::LegacyFilterInput($_POST['assetCondition']);
    $sassetDescription = InputUtils::LegacyFilterInput($_POST['assetDescription']);
    $sassetCategory= InputUtils::LegacyFilterInput($_POST['assetCategory']);
    $bassetImage = InputUtils::LegacyFilterInput($_POST['assetImage']);
//     $dpurchaseDate = InputUtils::LegacyFilterInput($_POST['purchaseDate']);
//    $dpurchaseDate2 = date('Y-m-d h:i:s', strtotime($dpurchaseDate));

    // $dpurchaseDate = date('Y-m-d H:i:s');

}

//New asset add
if($iassetID < 1){
    $sSQL = "INSERT INTO assets(assetName, serialNumber, quantity, assetCondition, assetDescription, assetCategory, assetImage)
            VALUES('".$sassetName."', '".$sserialNumber."', '".$squantity."', '".$sassetCondition."', '".$sassetDescription."', '".$sassetCategory."', '".$bassetImage."')";
} else {
    $sSQL = "UPDATE assets SET assetName = '".$sassetName."', serialNumber = '".$sserialNumber."', quantity = '".$squantity."',  assetCondition = '".$iassetCondition."', assetDescription = '".$sassetDescription."', assetCategory = '".$sassetCategory."', assetImage = '".$bassetImage."'  ";
}
//Photo

//fetch all assets
$sSQL = "SELECT * from assets";
$result = RunQuery($sSQL);
$resultCheck = mysqli_num_rows($result);


// (edit) an asset
if(isset($_GET['edit'])){
    $assetID = $_GET['edit'];
    $sSQL = "SELECT * FROM assets where assetID='$assetID'";
    
    if (count($result)==1) {
      $row = $result->fetch_array();
      $assetName = $row['assetName'];
      $serialNumber =  $row['serialNumber'];
      $assetCondition = $row['quantity'];
      $assetCondition = $row['assetCondition'];
      $assetCategory =  $row['assetCategory'];
    }
    
}

//Update an asset
if(isset($_POST['update'])){

}

//Execute the SQL
 RunQuery($sSQL);

require 'Include/Header.php';

?>

<form method="post" action="AssetEditor.php" name="AssetEditor" enctype="multipart/form-data">
    <!-- <input type="hidden" name="id" value="<?php echo $id ?>" > -->

    <div class="box box-info clearfix">
        <div class="box-header">
            <h3 class="box-title"><?= gettext('Add Assets') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Name"><?= gettext('Asset Name') ?>:</label>
                        <input type="text" name="assetName" required="true" value="<?php echo $assetName ?>" id="assetName"  placeholder="<?= htmlentities(stripslashes($sassetName), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Serial Number"><?= gettext('Serial Number') ?>:</label>
                        <input type="text" name="serialNumber" required="true" id="serialNumber"  value="<?php echo $serialNumber; ?>" placeholder="<?= htmlentities(stripslashes($sserialNumber), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Quantity"><?= gettext('Quantity') ?>:</label>
                        <input type="text" name="quantity" required="true" id="quantity" value="<?php echo $quantity; ?>"  placeholder="<?= htmlentities(stripslashes($iquantity), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Condition"><?= gettext('Asset Condition') ?>:</label>
                        <input type="text" name="assetCondition" required="true" id="assetCondition" value="<?php echo $assetCondition; ?>"  placeholder="<?= htmlentities(stripslashes($iassetCondition), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Description"><?= gettext('Asset Description') ?>:</label>
                        <input type="text" name="assetDescription" required="true" id="assetDescription" value="<?php echo $assetDescription; ?>"  placeholder="<?= htmlentities(stripslashes($sassetDescription), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Category"><?= gettext('Asset Category') ?>:</label>
                        <input type="text" name="assetCategory" required="true" id="assetCategory" value="<?php echo $assetCategory; ?>" placeholder="<?= htmlentities(stripslashes($sassetCategory), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Image"><?= gettext('Asset Image') ?>:</label>
                        <input type="file" name="assetImage" id="assetImage" placeholder="<?= htmlentities(stripslashes($bassetImage), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Purchase Date"><?= gettext('Purchase Date') ?>:</label>
                        <input type="date" name="purchaseDate" id="purchaseDate" placeholder="<?= htmlentities(stripslashes($dpurchaseDate), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

            </div>

            <input type="submit" class="btn btn-primary" id="save" value="<?= gettext('Save') ?>" name="save">
        </div>


</form>

<?php require 'Include/Footer.php' ?>