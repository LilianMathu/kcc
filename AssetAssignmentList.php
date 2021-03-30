<?php

//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Classes


//Set page title
$sPageTitle = gettext('Asset Assignment list');

require 'Include/Header.php';

// sql
$sSQL = "SELECT * from assignassets";
$result = RunQuery($sSQL);
$resultCheck = mysqli_num_rows($result);

?>

<!-- HTML TABLE -->
<div class="box box-warning">
  <div class="box-body">
    <table id="members" class="table table-striped table-bordered data-table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Asset Name</th>
          <th scope="col">Assigned To</th>
          <th scope="col">Assigned By</th>
          <th scope="col">Serial</th>
          <th scope="col">Condition</th>
          <th scope="col">Category</th>
          <th scope="col">Assign Date</th>
          <th scope="col">Action</th>

        </tr>
      </thead>
      <tbody>
        <!--Populate the table with asset details -->
        <?php       
        while($row = mysqli_fetch_assoc($result)){
       ?>
        <tr>
          <td><?php echo $row['assignID'] ?></td>
          <td><?php echo $row['assetName'] ?></td>
          <td><?php echo $row['assignedTo'] ?></td>
          <td><?php echo $row['assignedBy'] ?></td>
          <td><?php echo $row['serialNumber'] ?></td>
          <td><?php echo $row['assetCondition'] ?></td>
          <td><?php echo $row['assetCategory'] ?></td>
          <td><?php echo $row['assignDate'] ?></td>
          <td>
            <button type="button" class="btn btn-sm btn-outline-primary">Reasign</button>
            <button type="button" class="btn btn-sm  btn-outline-danger">History</button>
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