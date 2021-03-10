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
    $sSQL = 'SELECT per_fam_ID FROM person_per WHERE per_ID = '.$iPersonID;
    $rsPerson = RunQuery($sSQL);
    extract(mysqli_fetch_array($rsPerson));

    if (mysqli_num_rows($rsPerson) == 0) {
        RedirectUtils::Redirect('Menu.php');
        exit;
    }

    if (!(
        AuthenticationManager::GetCurrentUser()->isEditRecordsEnabled() ||
        (AuthenticationManager::GetCurrentUser()->isEditSelfEnabled() && $iPersonID == AuthenticationManager::GetCurrentUser()->getId()) ||
        (AuthenticationManager::GetCurrentUser()->isEditSelfEnabled() && $per_fam_ID > 0 && $per_fam_ID == AuthenticationManager::GetCurrentUser()->getPerson()->getFamId())
    )
    ) {
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


if (isset($_POST['AssetSubmit']) || isset($_POST['AssetSubmitAndAdd'])) {
    //Get all the variables from the request object and assign them locally
    $sasset_name = InputUtils::LegacyFilterInput($_POST['AssetName']);
    $serial_number = InputUtils::LegacyFilterInput($_POST['SerialNumber']);
    $asset_condition = InputUtils::LegacyFilterInput($_POST['AssetCondition']);
    $asset_description = InputUtils::LegacyFilterInput($_POST['AssetDescription']);
    $asset_image = InputUtils::LegacyFilterInput($_POST['AssetImage']);
    $assigned_to = InputUtils::LegacyFilterInput($_POST['AssignedTo']);
    $assign_date = InputUtils::LegacyFilterInput($_POST['AssignDate']);





}
require 'Include/Header.php';

?>

<form method="post" action="AddAssets.php">
    <div class="box box-info clearfix">
        <div class="box-header">
            <h3 class="box-title"><?= gettext('Assets Info') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><?= gettext('Asset Name') ?>:</label>
                        <input type="text" Name="Name" placeholder="Name" id="AssetName" value="<?= htmlentities(stripslashes($sAssetName), ENT_NOQUOTES, 'UTF-8') ?>" maxlength="48" class="form-control">
                        <?php if ($sAssetNameError) {
                        ?><font color="red"><?= $sAssetNameError ?></font><?php
                                                                        }                       ?>
                    </div>
                </div>
                <br>



                <div class="row">
                    <div class="col-md-6 form-group">
                        <label> Serial Number</label>
                        <textarea name="description" placeholder="serial number" class="form-control" required value=""></textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><?= gettext('Asset Condition') ?>: </label>
                        <select name="Condition" class="form-control">
                            <option value="0"><?= gettext('Unassigned') ?></option>
                            <option value="0" disabled>-----------------------</option>
                            <?php while ($aRow = mysqli_fetch_array($rsClassifications)) {
                                extract($aRow);
                                echo '<option value="' . $lst_OptionID . '"';
                                if ($iClassification == $lst_OptionID) {
                                    echo ' selected';
                                }
                                echo '>' . $lst_OptionName . '&nbsp;';
                            } ?>
                        </select>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label> Assets Description</label>
                        <textarea name="description" class="form-control" placeholder="Description" required value=""></textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Asset Image </label>
                        <input type="file" value="" class="form-control" name="asset_img" id="up_img">
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class=" col-md-6 form-group">
                        <label> Assign to </label>
                        <input type="number" min="0" class="form-control" value="" name="a_num" placeholder="Assign to">
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class=" col-md-6 form-group">
                        <label> Assign Date </label>
                        <input type="date" min="0" class="form-control" value="" name="a_num" >
                    </div>
                </div>
                <br>

                <div class="pull-right"><br />
                    <input type="submit" class="btn btn-primary" value="<?= gettext('Save') ?>" name="FamilySubmit">
                </div>

            </div>
        </div>
</form>