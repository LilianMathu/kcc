<?php
//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Set page title
// $sPageTitle = gettext('Today\'s Sermon');

require 'Include/Header.php';

if (isset($_GET['view'])) {
    $sermonID = $_GET['view'];
    $sSQL = "SELECT * from sermons WHERE sermonID=$sermonID";
    $blogresult = RunQuery($sSQL);

    if (count($blogresult == 1)) {
        $row = $blogresult->fetch_array();
        $sermonTitle = $row['sermonTitle'];
        $categoryType = $row['categoryType'];
        $preacherName =  $row['preacherName'];
        $bibleVerses = $row['bibleVerses'];
        $sermonContent = $row['sermonContent'];
        $sermonImage =  $row['sermonImage'];
        $youtubeLink =  $row['youtubeLink'];
        $uploadedBy =  $row['uploadedBy'];
        $serviceDate = $row['serviceDate'];
    }
}

?>


<section class="banner_area">
    <div class="container">
        <div class="row banner_inner">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="banner_content text-center">
                    <h2>Sermon Post Details</h2>
                    <div class="page_link">
                        <a href="SermonList.php">All Sermons</a>
                        <a href="SermonVideo.php">Sermon Videos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="main_blog_details">
    <img class="img-fluid" src="img/blog/news-blog.jpg" alt="">
    <a href="#">
        <h4><?= $sermonTitle; ?></h4>
    </a>
    <div class="user_details ">
        <div class="float-left">
            <a href="#"><?= $categoryType; ?></a>
        </div>
        <div class="float-right ">
            <div class="media">
                <div class="media-body">
                    <h5><?= $preacherName; ?></h5>
                    <p><?= $serviceDate; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div>    
    <p><?= $sermonContent; ?></p>
    </div>

    <div class="user_details ">
        <div class="float-center">
            <a href="<?= $youtubeLink; ?>" class="btn btn-info">Youtube Link</a>
        </div>
    </div>

</div>

<?php
require 'Include/Footer.php'
?>