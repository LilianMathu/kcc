<?php
//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Utility classes
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Authentication\AuthenticationManager;

//Set page title
$sPageTitle = gettext('Asset Editor');

require 'Include/Header.php';


//DB fields
if (isset($_POST['saveAsset']) || isset($_POST['updateAsset'])) {
    //Get all the variables from the request object and assign them locally
    $sassetName = InputUtils::LegacyFilterInput($_POST['assetName']);
    $sserialNumber = InputUtils::LegacyFilterInput($_POST['serialNumber']);
    $squantity = InputUtils::LegacyFilterInput($_POST['quantity']);
    $sassetCondition = InputUtils::LegacyFilterInput($_POST['assetCondition']);
    $sassetDescription = InputUtils::LegacyFilterInput($_POST['assetDescription']);
    $sassetCategory = InputUtils::LegacyFilterInput($_POST['assetCategory']);
    $bassetImage = InputUtils::LegacyFilterInput($_POST['assetImage']);
    $spurchaseDate = InputUtils::LegacyFilterInput($_POST['purchaseDate']);
    $spurchaseDate= str_replace('/', '-', $spurchaseDate);
    $spurchaseDate = date('Y-m-d', strtotime($spurchaseDate));

    //New asset add
    if ($assetID < 1) {
    $sSQL = "INSERT INTO assets(assetName, serialNumber, quantity, assetCondition, assetDescription, assetCategory, assetImage, purchaseDate)
            VALUES('" . $sassetName . "', '" . $sserialNumber . "', '" . $squantity . "', '" . $sassetCondition . "', '" . $sassetDescription . "', '" . $sassetCategory . "', '" . $bassetImage . "', '" . $spurchaseDate . "')";
    } else{
        $sSQL = "UPDATE assets SET assetName = '" . $sassetName . "', serialNumber = '" . $sserialNumber . "', quantity = '" . $squantity . "',  assetCondition = '" . $sassetCondition . "', assetCategory = '" . $sassetCategory . "' , assetDescription = '" . $sassetDescription . "', purchaseDate = '" . $spurchaseDate . "'  
                WHERE assetID = '$assetID'";
    }

    //Execute the SQL
    RunQuery($sSQL);
}


// (edit) an asset
if(isset($_GET['update'])){
    $assetID = $_GET['id'];

    $sSQL = "SELECT * FROM assets where assetID='$assetID'";
    $result = RunQuery($sSQL);
    $resultCheck = mysqli_num_rows($result);

    if (count($result)==1) {
      $row = $result->fetch_array();
      $sassetName = $row['assetName'];
      $sserialNumber =  $row['serialNumber'];
      $squantity = $row['quantity'];
      $sassetCondition = $row['assetCondition'];
      $sassetCategory =  $row['assetCategory'];
      $sassetDescription = $row['assetDescription'];
      $spurchaseDate = $row['spurchaseDate'];
    }

}


?>

<form method="post" action="AssetEditor.php" name="AssetEditor" enctype="multipart/form-data">
<input type="hidden" name="assetID" value="<?php $assetID ?>">
    <div class="box box-info clearfix">
        <div class="box-header">
            <h3 class="box-title"><?= gettext('Add Assets') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group">
            <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Name"><?= gettext('Asset Name') ?>:</label>
                        <input type="text" name="assetName" id="assetName" value="<?php echo $row['assetName']; ?>" placeholder="<?= htmlentities(stripslashes($sassetName), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Serial Number"><?= gettext('Serial Number') ?>:</label>
                        <input type="text" name="serialNumber" id="serialNumber" value="<?php echo $row['serialNumber'] ?>"  placeholder="<?= htmlentities(stripslashes($sserialNumber), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Quantity"><?= gettext('Quantity') ?>:</label>
                        <input type="text" name="quantity" id="quantity" value="<?php echo $row['quantity'] ?>" placeholder="<?= htmlentities(stripslashes($iquantity), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Condition"><?= gettext('Asset Condition') ?>:</label>
                        <input type="text" name="assetCondition" id="assetCondition" value="<?php echo $row['assetCondition'] ?>" placeholder="<?= htmlentities(stripslashes($iassetCondition), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Description"><?= gettext('Asset Description') ?>:</label>
                        <input type="text" name="assetDescription" id="assetDescription" value="<?php echo $row['assetDescription'] ?>" placeholder="<?= htmlentities(stripslashes($sassetDescription), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Asset Category"><?= gettext('Asset Category') ?>:</label>
                        <input type="text" name="assetCategory" id="assetCategory" value="<?php echo $row['assetCategory'] ?>" placeholder="<?= htmlentities(stripslashes($sassetCategory), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
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
                        <input type="date" name="purchaseDate" id="purchaseDate" value="<?php echo $row['purchaseDate'] ?>" placeholder="<?= htmlentities(stripslashes($spurchaseDate), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

            </div>
    
            <input type="submit" class="btn btn-primary" id="save" value="save" name="saveAsset">
            <?php if (AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
                echo '<input type="submit" class="btn btn-primary" value="' . gettext('Update') . '" name="updateAsset">';
            } ?>
            <input type="button" class="btn btn-danger" value="<?= gettext('Cancel') ?>" name="AssetCancel">
        </div>

</form>

<?php require 'Include/Footer.php' ?>