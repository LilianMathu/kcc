<?php

//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Add classes
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Authentication\AuthenticationManager;

//Set page title
$sPageTitle = gettext('Assign Assets');

require 'Include/Header.php';

//Add fields
//DB fields
if (isset($_POST['AssignSubmit']) || isset($_POST['AssignSubmitAndAdd'])) {
    //Get all the variables from the request object and assign them locally
    $sassetName = InputUtils::LegacyFilterInput($_POST['assetName']);
    $sassignedTo = InputUtils::LegacyFilterInput($_POST['assignedTo']);
    $sassignedBy = InputUtils::LegacyFilterInput($_POST['assignedBy']);
    $sserialNumber = InputUtils::LegacyFilterInput($_POST['serialNumber']);
    $sassetCondition = InputUtils::LegacyFilterInput($_POST['assetCondition']);
    $sassetCategory= InputUtils::LegacyFilterInput($_POST['assetCategory']);
    $sassignDate = InputUtils::LegacyFilterInput($_POST['assignDate']);
    $sassignDate= str_replace('/', '-', $sassignDate);
    $sassignDate = date('Y-m-d', strtotime($sassignDate));

    $sreturnDate = InputUtils::LegacyFilterInput($_POST['returnDate']);
    $sreturnDate= str_replace('/', '-', $sreturnDate);
    $sreturnDate = date('Y-m-d', strtotime($sreturnDate));

}


//New asset assign
if($iassetID < 1){
    $sSQL = "INSERT INTO assignassets(assetName, assignedTo, assignedBy, serialNumber, assetCondition, assetCategory, assignDate, returnDate)
            VALUES('".$sassetName."', '".$sassignedTo."', '".$sassignedBy."', '".$sserialNumber."', '".$sassetCondition."', '".$sassetCategory."', '".$sassignDate."', '".$sreturnDate."')";
} else {
    $sSQL = "UPDATE assignassets SET assetName = '".$sassetName."', assignedTo = '".$sassignedTo."',  assignedBy = '".$sassignedBy."', serialNumber = '".$sserialNumber."',  assetCondition = '".$sassetCondition."', assetCategory = '".$sassetCategory."',  assignDate = '".$sassignDate."', returnDate = '".$sreturnDate."' ";
}

 //Execute the SQL
 RunQuery($sSQL);
// echo RunQuery($sSQL);

// Reasign an asset
if(isset($_GET['reasign'])){
    $assetID = $_GET['id'];

    $sSQL = "SELECT * FROM assignassets where assetID='$assetID'";
    $result = RunQuery($sSQL);
    $resultCheck = mysqli_num_rows($result);

    if (count($result)==1) {
      $row = $result->fetch_array();
      $assetName = $row['assetName'];
      $sassignedTo = $row['assignedTo'];
      $serialNumber =  $row['serialNumber'];
      $squantity = $row['quantity'];
      $assetCondition = $row['assetCondition'];
      $assetCategory =  $row['assetCategory'];
    }

}
?>

<form method="post" action="AssignAssets.php">
<div class="box box-info clearfix">
        <div class="box-header">
            <h3 class="box-title"><?= gettext('Assign Assets') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Name"><?= gettext('Asset Name') ?>:</label>
                        <input type="text" name="assetName" id="assetName" value="<?= htmlentities(stripslashes($sassetName), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="assignedTo"><?= gettext('Assigned To') ?>:</label>
                        <input type="text" name="assignedTo" id="assignedTo" value="<?= htmlentities(stripslashes($assignedTo), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="assignedBy"><?= gettext('Assigned By') ?>:</label>
                        <input type="text" name="assignedBy" id="assignedBy" value="<?= htmlentities(stripslashes($assignedBy), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Serial Number"><?= gettext('Serial Number') ?>:</label>
                        <input type="text" name="serialNumber" id="serialNumber" value="<?= htmlentities(stripslashes($sserialNumber), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Condition"><?= gettext('Asset Condition') ?>:</label>
                        <input type="text" name="assetCondition" id="assetCondition" value="<?= htmlentities(stripslashes($sassetCondition), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />


                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Category"><?= gettext('Asset Category') ?>:</label>
                        <input type="text" name="assetCategory" id="assetCategory" value="<?= htmlentities(stripslashes($sassetCategory), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Assign Date"><?= gettext('Assign Date') ?>:</label>
                        <input type="date" name="assignDate" id="assignDate" value="<?= htmlentities(stripslashes($sassignDate), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Return Date"><?= gettext('Return Date') ?>:</label>
                        <input type="date" name="returnDate" id="returnDate" value="<?= htmlentities(stripslashes($sreturnDate), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

            </div>
            <input type="submit" class="btn btn-primary" id="AssignSaveButton" value="<?= gettext('Save') ?>" name="AssignSubmit">
            <?php if (AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
                    echo '<input type="submit" class="btn btn-primary" value="' . gettext('Save and Add') . '" name="AssignSubmitAndAdd">';
                } ?>
            <input type="button" class="btn btn-danger" value="<?= gettext('Cancel') ?>" name="AssignCancel">

        </div>
</form>

<?php require 'Include/Footer.php' ?>