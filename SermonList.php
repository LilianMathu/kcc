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
$sPageTitle = gettext('All Sermons');

require 'Include/Header.php';

// display all sermons
$sSQL = "SELECT * from sermons ";
$result = RunQuery($sSQL);
$resultCheck = mysqli_num_rows($result);

// delete an sermon
if(isset($_GET['delete'])){
  $sermonID = $_GET['delete'];
  $sSQL = "DELETE from sermons WHERE sermonID='$sermonID'";
}


//Execute the SQL
RunQuery($sSQL);
?>


<!-- HTML TABLE -->
<div class="box box-warning">
  <div class="box-body">
    <table id="members" class="table table-striped table-bordered data-table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th scope="col">Preacher Name</th>
          <th scope="col">Sermon Title</th>
          <th scope="col">Category</th>
          <th scope="col">Youtube Link</th>
          <th scope="col">Date</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <!--Populate the table with sermon details -->
        <?php       
        while($row = mysqli_fetch_assoc($result)){
       ?>
        <tr>
          <td><?php echo $row['preacherName'] ?></td>
          <td><?php echo $row['sermonTitle'] ?></td>
          <td><?php echo $row['categoryType'] ?></td> 
          <td><?php echo $row['youtubeLink'] ?></td>
          <td><?php echo $row['serviceDate'] ?></td>
          <td>
          <a href="SermonPage1.php?view=<?php echo $row['sermonID']; ?>" class="btn btn-info" name="view"><span class="fa fa-eye"></span></a>
          <a href="SermonEditor.php?update=<?php echo $row['sermonID']; ?>" class="btn btn-info" name="edit"><span class="fa fa-pencil"></span></a>
          <a href="SermonList.php?delete=<?php echo $row['sermonID']; ?>" class="btn btn-danger" name="delete"><span class="fa fa-trash"></span></a>

          <!-- <?php if (AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
         echo  '<a href="SermonList.php?delete=<?php echo $row["sermonID"]; ?>" class="btn btn-danger">Edit</a>';
         echo  '<a href="SermonEditor.php?update=id=<?php echo $row["sermonID"]; ?>" class="btn btn-info">Download</a>
         ';
          } ?> -->
          
          </td>
        </tr>
        <?php } ?>
      </tbody> 
    </table>
  </div>
</div>


<?php
require 'Include/Footer.php'
?>