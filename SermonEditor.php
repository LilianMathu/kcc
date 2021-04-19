<?php
//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Utility classes
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\dto\SystemURLs;
use ChurchCRM\Authentication\AuthenticationManager;

//Set page title
$sPageTitle = gettext('Sermon Editor');

require 'Include/Header.php';

$iSermonID = InputUtils::LegacyFilterInput($_GET['SermonID'], 'int');

//DB fields
if (isset($_POST['saveSermon']) || isset($_POST['updateSermon'])) {
    $ssermonTitle = InputUtils::LegacyFilterInput($_POST['sermonTitle']);
    $scategoryType = InputUtils::LegacyFilterInput($_POST['categoryType']);
    $sserviceType = InputUtils::LegacyFilterInput($_POST['serviceType']);
    $spreacherName = InputUtils::LegacyFilterInput($_POST['preacherName']);
    $sbibleVerses = InputUtils::LegacyFilterInput($_POST['bibleVerses']);
    $ssermonContent = InputUtils::FilterHTML($_POST['sermonContent']);
    $bsermonImage = InputUtils::LegacyFilterInput($_POST['sermonImage']);
    $syoutubeLink = InputUtils::LegacyFilterInput($_POST['youtubeLink']);
    $suploadedBy = InputUtils::LegacyFilterInput($_POST['uploadedBy']);
    $sserviceDate = InputUtils::LegacyFilterInput($_POST['serviceDate']);
    $sserviceDate = str_replace('/', '-', $sserviceDate);
    $sserviceDate = date('Y-m-d', strtotime($sserviceDate));

    //New sermon add
    if ($sermonID < 1) {
        $sSQL = "INSERT INTO sermons(sermonTitle, categoryType, serviceType, preacherName, bibleVerses, sermonContent, sermonImage, youtubeLink, uploadedBy, serviceDate)
            VALUES('" . $ssermonTitle . "', '" . $scategoryType . "', '" . $sserviceType . "',  '" . $spreacherName . "', '" . $sbibleVerses . "', '" . $ssermonContent . "', '" . $bsermonImage . "', '" . $syoutubeLink . "', '" . $suploadedBy . "', '" . $sserviceDate . "')";
    } else {
        $sSQL = "UPDATE sermons SET sermonTitle = '" . $ssermonTitle . "', categoryType = '" . $scategoryType . "', serviceType = '" . $sserviceType . "', preacherName = '" . $spreacherName . "', bibleVerses = '" . $sbibleVerses . "', sermonContent = '" . $bsermonContent . "', sermonImage = '" . $bsermonImage . "', youtubeLink = '" . $syoutubeLink . "', serviceDate = '" . $sserviceDate . "'
                WHERE sermonID = '$sermonID'";
    }

    //Execute the SQL
    RunQuery($sSQL);
}


// (edit) an sermon
if (isset($_GET['update'])) {
    $sermonID = $_GET['update'];

    $sSQL = "SELECT * FROM sermons where sermonID='$sermonID'";
    $result = RunQuery($sSQL);
    $resultCheck = mysqli_num_rows($result);

    if (count($result) == 1) {
        $row = $result->fetch_array();
        $ssermonTitle = $row['sermonTitle'];
        $scategoryType = $row['categoryType'];
        $sserviceType = $row['serviceType'];
        $spreacherName =  $row['preacherName'];
        $sbibleVerses = $row['bibleVerses'];
        $ssermonContent = $row['sermonContent'];
        $bsermonImage =  $row['sermonImage'];
        $syoutubeLink =  $row['youtubeLink'];
        $suploadedBy =  $row['uploadedBy'];
        $sserviceDate = $row['serviceDate'];
    }
}

?>

<form method="post" action="SermonEditor.php" name="SermonEditor" enctype="multipart/form-data">
    <input type="hidden" name="sermonID" value="<?php $sermonID ?>">
    <div class="box box-info clearfix">
        <div class="box-header">
            <h3 class="box-title"><?= gettext('Add Sermons') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="Sermon Title"><?= gettext('Sermon Title') ?>:</label>
                        <input type="text" name="sermonTitle" id="sermonTitle" value="<?php echo $row['sermonTitle']; ?>" placeholder="<?= htmlentities(stripslashes($ssermonTitle), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Category"><?= gettext('Category') ?>:</label>
                        <input type="text" name="categoryType" id="categoryType" value="<?php echo $row['categoryType'] ?>" placeholder="<?= htmlentities(stripslashes($scategoryType), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row pt-5 ">
                    <div class="col-md-6">
                        <label for="Service Type"><?= gettext('Service Type') ?>:</label>
                        <select name='serviceType' id="serviceType" value="<?php echo $row['serviceType'] ?>" class='form-control'>
                            <option><?= gettext('Select your service type'); ?></option>
                            <?php
                            $sSQL = 'SELECT * FROM event_types';
                            $rsEventTypes = RunQuery($sSQL);
                            while ($aRow = mysqli_fetch_array($rsEventTypes)) {
                                extract($aRow);
                                echo "<option value='" . $type_id . "' >" . $type_name . '</option>';
                            } ?>
                        </select>

                    </div>
                </div>
                <p />

                <div class="row pt-5">
                    <div class="col-md-6">
                        <label for="Preacher Name"><?= gettext('Preacher Name') ?>:</label>
                        <input type="text" name="preacherName" id="preacherName" value="<?php echo $row['preacherName'] ?>" placeholder="<?= htmlentities(stripslashes($spreacherName), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Bible Verses"><?= gettext('Bible Verses') ?>:</label>
                        <input type="text" name="bibleVerses" id="bibleVerses" value="<?php echo $row['bibleVerses'] ?>" placeholder="<?= htmlentities(stripslashes($sbibleVerses), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Sermon Content"><?= gettext('Sermon Content') ?>:</label>
                        <!-- <textArea name="sermonContent" id="sermonContent" value="<?php echo $row['sermonContent'] ?>" placeholder="<?= htmlentities(stripslashes($ssermonContent), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control" style="width:520px;height:300px;"></textArea> -->
                        <textarea id="sermonContent" name="sermonContent" rows="5" cols="70" class='form-control'><?= ($ssermonContent) ?></textarea>

                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Sermon Image"><?= gettext('Sermon Image') ?>:</label>
                        <input type="file" name="sermonImage" id="sermonImage" value="<?php echo $row['sermonImage'] ?>" placeholder="<?= htmlentities(stripslashes($bsermonImage), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="YouTube Links"><?= gettext('YouTube Links') ?>:</label>
                        <input type="url" name="youtubeLink" id="youtubeLink" placeholder="<?= htmlentities(stripslashes($syoutubeLink), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Uploaded by"><?= gettext('Uploaded by') ?>:</label>
                        <input type="text" name="uploadedBy" id="uploadedBy" value="<?php echo $row['uploadedBy'] ?>" placeholder="<?= htmlentities(stripslashes($suploadedBy), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

                <div class="row">
                    <div class="col-md-6">
                        <label for="Service Date"><?= gettext('Service Date') ?>:</label>
                        <input type="date" name="serviceDate" id="serviceDate" value="<?php echo $row['serviceDate'] ?>" placeholder="<?= htmlentities(stripslashes($sserviceDate), ENT_NOQUOTES, 'UTF-8') ?>" class="form-control">
                    </div>
                </div>
                <p />

            </div>

            <input type="submit" class="btn btn-primary" id="save" value="save" name="saveSermon">
            <?php if (AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
                echo '<input type="submit" class="btn btn-primary" value="' . gettext('Update') . '" name="updateSermon">';
            } ?>
            <input type="button" class="btn btn-danger" value="<?= gettext('Cancel') ?>" name="sermonCancel">
        </div>

</form>


<?php require 'Include/Footer.php' ?>

<script src="<?= SystemURLs::getRootPath() ?>/skin/external/ckeditor/ckeditor.js"></script>

<script nonce="<?= SystemURLs::getCSPNonce() ?>">
    CKEDITOR.replace('sermonContent', {
        customConfig: '<?= SystemURLs::getRootPath() ?>/skin/js/ckeditor/event_editor_config.js',
        language: window.CRM.lang,
        width: '100%'
    });
</script>