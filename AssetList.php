<?php
//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Classes


//Set page title
$sPageTitle = gettext('All Assets');

require 'Include/Header.php';

// display all assets
$sSQL = "SELECT * from assets";
$result = RunQuery($sSQL);
$resultCheck = mysqli_num_rows($result);

// delete an asset
if(isset($_GET['delete'])){
  $assetID = $_GET['delete'];
  $sSQL = "DELETE from assets WHERE assetID='$assetID'";
}

// //update an asset
// if(isset($_GET['edit'])){
//   $assetID = $_GET['edit'];
//   $sSQL = "SELECT * FROM assets where assetID='$assetID'";
  
//   if (count($result)==1) {
//     $row = $result->fetch_array();
//     $assetName = $row['assetName'];
//     $serialNumber =  $row['serialNumber'];
//     $assetCondition = $row['assetCondition'];
//     $assetCategory =  $row['assetCategory'];
//   }
// }

//Execute the SQL
RunQuery($sSQL);
?>


<!-- HTML TABLE -->
<div class="box box-warning">
  <div class="box-body">
    <table id="members" class="table table-striped table-bordered data-table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Serial</th>
          <th scope="col">Quantity</th>
          <th scope="col">Condition</th>
          <th scope="col">Category</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <!--Populate the table with asset details -->
        <?php       
        while($row = mysqli_fetch_assoc($result)){
       ?>
        <tr>
          <td><?php echo $row['assetID'] ?></td>
          <td><?php echo $row['assetName'] ?></td>
          <td><?php echo $row['serialNumber'] ?></td>
          <td><?php echo $row['quantity'] ?></td> 
          <td><?php echo $row['assetCondition'] ?></td>
          <td><?php echo $row['assetCategory'] ?></td>
          <td>
          <a href="AssetEditor.php?update=1&id=<?php echo $row['assetID']; ?>" class="btn btn-info">Update</a>
          <a href="AssetList.php?delete=<?php echo $row['assetID']; ?>" class="btn btn-danger">Delete</a>
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