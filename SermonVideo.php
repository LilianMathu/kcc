<?php
//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Set page title
// $sPageTitle = gettext('Today\'s Sermon');

require 'Include/Header.php';

$sSQL = "SELECT * from sermons";
$videoresult = RunQuery($sSQL);

?>

<div class="sermon-main">
    <?php
    if ($videoresult->num_rows > 0) {
        while ($videourl = $videoresult->fetch_assoc()) {
    ?>
            <div>
                <iframe src="<?= $videourl['youtubeLink']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <p><?= $videourl['categoryType']; ?></p>
            </div>
    <?php
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    ?>

</div>