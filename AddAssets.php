<?php

//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Add classes

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Note;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\dto\SystemURLs;
use ChurchCRM\Emails\NewPersonOrFamilyEmail;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Bootstrapper;
use ChurchCRM\Authentication\AuthenticationManager;

//Set page title
$sPageTitle = gettext('Assets Editor');

//Get the PersonID out of the querystring
if (array_key_exists('PersonID', $_GET)) {
    $iPersonID = InputUtils::LegacyFilterInput($_GET['PersonID'], 'int');
} else {
    $iPersonID = 0;
}

$sPreviousPage = '';
if (array_key_exists('previousPage', $_GET)) {
    $sPreviousPage = InputUtils::LegacyFilterInput($_GET['previousPage']);
}

// Security: User must have Add or Edit Records permission to use this form in those manners
// Clean error handling: (such as somebody typing an incorrect URL ?PersonID= manually)
if ($iPersonID > 0) {
    $sSQL = 'SELECT per_fam_ID FROM person_per WHERE per_ID = ' . $iPersonID;
    $rsPerson = RunQuery($sSQL);
    extract(mysqli_fetch_array($rsPerson));

    if (mysqli_num_rows($rsPerson) == 0) {
        RedirectUtils::Redirect('Menu.php');
        exit;
    }

    if (!(AuthenticationManager::GetCurrentUser()->isEditRecordsEnabled() ||
        (AuthenticationManager::GetCurrentUser()->isEditSelfEnabled() && $iPersonID == AuthenticationManager::GetCurrentUser()->getId()) ||
        (AuthenticationManager::GetCurrentUser()->isEditSelfEnabled() && $per_fam_ID > 0 && $per_fam_ID == AuthenticationManager::GetCurrentUser()->getPerson()->getFamId()))) {
        RedirectUtils::Redirect('Menu.php');
        exit;
    }
} elseif (!AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
    RedirectUtils::Redirect('Menu.php');
    exit;
}

// Get Field Security List Matrix
$sSQL = 'SELECT * FROM list_lst WHERE lst_ID = 5 ORDER BY lst_OptionSequence';
$rsSecurityGrp = RunQuery($sSQL);

while ($aRow = mysqli_fetch_array($rsSecurityGrp)) {
    extract($aRow);
    $aSecurityType[$lst_OptionID] = $lst_OptionName;
}


//push data from a form
if (isset($_POST['AssetSubmit']) || isset($_POST['AssetSubmitAndAdd'])) {
    //Get all the variables from the request object and assign them locally
    $sassetName = InputUtils::LegacyFilterInput($_POST['assetName']);
    $sserialNumber = InputUtils::LegacyFilterInput($_POST['serialNumber']);
    $sassetCondition = InputUtils::LegacyFilterInput($_POST['assetCondition']);
    $sassetDescription = InputUtils::LegacyFilterInput($_POST['assetDescription']);
    $bassetImage = InputUtils::LegacyFilterInput($_POST['assetImage']);
    $dpurchaseDate = InputUtils::LegacyFilterInput($_POST['purchaseDate']);

    //Add new asset
    if ($iAssetId < 0) {
        $sSQL = "INSERT INTO assets (assetName, serialNumber, assetCondition, assetDescription, assetImage, purchaseDate)
                    VALUES ('" . $sassetName . "','" . $iserialNumber . "', '" . $iassetCondition . "',  '" . $sassetDescription . "',  '" . $bassetImage . "', '" . $dpurchaseDate . "')";
    } else {
        //update fields
    }

    //Execute the SQL
    RunQuery($sSQL);

     // Check for redirection to another page after saving information: (ie. PersonEditor.php?previousPage=prev.php?a=1;b=2;c=3)
     if ($sPreviousPage != '') {
        $sPreviousPage = str_replace(';', '&', $sPreviousPage);
        RedirectUtils::Redirect($sPreviousPage.$iPersonID);
    } elseif (isset($_POST[''])) {
        //Send to the view of this person
        RedirectUtils::Redirect('AssetList.php?PersonID='.$iPersonID);
    } else {
        //Reload to editor to add another record
        RedirectUtils::Redirect('AddAssets.php');
    }
}


require 'Include/Header.php';

?>

<form method="post" action="AddAssets.php?PersonID=<?= $iPersonID ?>" name="AddAssets">
    <div class="box box-info clearfix">
        <div class="box-header">
            <h3 class="box-title"><?= gettext('Assets Info') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><?= gettext('Asset Name') ?>:</label>
                        <input type="text" Name="Asset_name" placeholder="Name" id="AssetName" value="<?= htmlentities(stripslashes($sassetName), ENT_NOQUOTES, 'UTF-8') ?>" maxlength="48" class="form-control">
                        <?php if ($sAssetNameError) {
                        ?><font color="red"><?= $sAssetNameError ?></font><?php
                                                                        }                       ?>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><?= gettext('Serial Number') ?>:</label>
                        <textarea 
                        name="Serial_Number)" 
                        placeholder="serial number" 
                        class="form-control" 
                        value="<?= htmlentities(stripslashes($sserialNumber), ENT_NOQUOTES, 'UTF-8') ?>"
                        >
                        </textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><?= gettext('Asset Condition') ?>: </label>
                        <div>
                            <label for="New" class="radio-inline">
                                <input type="radio" name="AssetCondition" value="<?= htmlentities(stripslashes($sassetCondition), ENT_NOQUOTES, 'UTF-8') ?>" id="new">New</label>
                            </label>
                            <label for="Used" class="radio-inline">
                                <input type="radio" name="AssetCondition" value="<?= htmlentities(stripslashes($sassetCondition), ENT_NOQUOTES, 'UTF-8') ?>" id="used">Used</label>
                            </label>

                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label> <?= gettext('Asset Description') ?>:</label>
                        <textarea 
                        name="Asset_description" 
                        class="form-control" 
                        placeholder="Description" 
                        value="<?= htmlentities(stripslashes($sassetDescription), ENT_NOQUOTES, 'UTF-8') ?>">
                        </textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><?= gettext('Asset Image') ?>: </label>
                        <input type="file" 
                        value="<?= htmlentities(stripslashes($bassetImage), ENT_NOQUOTES, 'UTF-8') ?>" 
                        class="form-control" 
                        name="asset_img" 
                        id="up_img">
                    </div>
                </div>
                <br>



                <div class="row">
                    <div class=" col-md-6 form-group">
                        <label> <?= gettext('Purchase Date') ?>: </label>
                        <input 
                        type="date" 
                        min="0" 
                        class="form-control" 
                        value="<?= htmlentities(stripslashes($dpurchaseDate), ENT_NOQUOTES, 'UTF-8') ?>" 
                        name="assigned_date">
                    </div>
                </div>
                <br>

                <div class="row">
                    <input type="submit" class="btn btn-primary" id="AssetSaveButton" value="<?= gettext('Save') ?>" name="AssetSubmit">
                    <?php if (AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
                        echo '<input type="submit" class="btn btn-primary" value="' . gettext('Save and Add') . '" name="AssetSubmitAndAdd">';
                    } ?>
                    <input type="button" class="btn btn-primary" value="<?= gettext('Cancel') ?>" name="AssetCancel" onclick="javascript:document.location='v2/people';">
                </div>
            </div>
        </div>
</form>

<?php require 'Include/Footer.php' ?>