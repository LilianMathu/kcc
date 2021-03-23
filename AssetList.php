<?php

//Include the function library
require 'Include/Config.php';
require 'Include/Functions.php';
require 'Include/CanvassUtilities.php';

//Classes


//Set page title
$sPageTitle = gettext('All Assets');

require 'Include/Header.php';

//sql
$sSQL = "SELECT * from assets";
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
          <th scope="col">Name</th>
          <th scope="col">Serial</th>
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
          <td><?php echo $row['assetCondition'] ?></td>
          <td><?php echo $row['assetCategory'] ?></td>
          <td>
            <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
            <button type="button" class="btn btn-sm  btn-outline-danger">Delete</button>
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