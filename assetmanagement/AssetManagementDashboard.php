<?php
require '../Include/Config.php';
require '../Include/Functions.php';

use ChurchCRM\Service\DashboardService;
use ChurchCRM\Service\SundaySchoolService;
use ChurchCRM\dto\SystemURLs;
use ChurchCRM\Utils\MiscUtils;
use ChurchCRM\Authentication\AuthenticationManager;

$dashboardService = new DashboardService();
$sundaySchoolService = new SundaySchoolService();

$groupStats = $dashboardService->getGroupStats();

$kidsWithoutClasses = $sundaySchoolService->getKidsWithoutClasses();
$classStats = $sundaySchoolService->getClassStats();
$classes = $groupStats['sundaySchoolClasses'];
$teachers = 0;
$kids = 0;
$families = 0;
$maleKids = 0;
$femaleKids = 0;
$familyIds = [];
foreach ($classStats as $class) {
    $kids = $kids + $class['kids'];
    $teachers = $teachers + $class['teachers'];
    $classKids = $sundaySchoolService->getKidsFullDetails($class['id']);
    foreach ($classKids as $kid) {
        array_push($familyIds, $kid['fam_id']);
        if ($kid['kidGender'] == '1') {
            $maleKids++;
        } elseif ($kid['kidGender'] == '2') {
            $femaleKids++;
        }
    }
}

// Set the page title and include HTML header
$sPageTitle = gettext('Assets Management Dashboard');
require '../Include/Header.php';

?>
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-barcode"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= gettext('Total Assets') ?></span>
        <span class="info-box-number"> <?= $classes ?> <br/></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-olive"><i class="fa fa-keyboard-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= gettext('Total Accessories') ?></span>
        <span class="info-box-number"> <?= $teachers ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="fa fa-tint"></i></span>
      <div class="info-box-content">
        <span class="info-box-text"><?= gettext('Total Consumables') ?></span>
        <span class="info-box-number"> <?= $kids ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div><!-- /.row -->
<!-- on continue -->
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title"><?= gettext('Recent Activities') ?></h3>
      <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
          </button>
      </div>
  </div>
  <div class="box-body">
    <table id="sundayschoolMissing" class="table table-striped table-bordered data-table" cellspacing="0" width="100%">
      <thead>
      <tr>
        <th><?= gettext('Date') ?></th>
        <th><?= gettext('Item') ?></th>
        <th><?= gettext('User') ?></th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($classStats as $class) {
        ?>
        <tr>
          <td style="width:80px">
          	<a href='SundaySchoolClassView.php?groupId=<?= $class['id'] ?>'>
            <span class="fa-stack">
							<i class="fa fa-square fa-stack-2x"></i>
							<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
            </span>
            </a>
          	<a href='<?= SystemURLs::getRootPath() ?>/GroupEditor.php?GroupID=<?= $class['id'] ?>'>
            <span class="fa-stack">
							<i class="fa fa-square fa-stack-2x"></i>
							<i class="fa fa fa-pencil fa-stack-1x fa-inverse"></i>
            </span>
            </a>
          </td>
          <td><?= $class['name'] ?></td>
          <td><?= $class['teachers'] ?></td>
          <td><?= $class['kids'] ?></td>
        </tr>
      <?php
    } ?>
      </tbody>
    </table>
  </div>
</div>
<?php if (AuthenticationManager::GetCurrentUser()->isManageGroupsEnabled()) {
          ?>
  <script nonce="<?= SystemURLs::getCSPNonce() ?>">
    $(document).ready(function () {
      $('.data-table').DataTable(window.CRM.plugin.dataTable);

      $("#addNewClassBtn").click(function (e) {
        var groupName = $("#new-class-name").val(); // get the name of the from the textbox
        if (groupName) // ensure that the user entered a name
        {
          $.ajax({
            method: "POST",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            url: window.CRM.root + "/api/groups/",
            data: JSON.stringify({
              'groupName': groupName,
              'isSundaySchool': true
            })
          }).done(function (data) {                               //yippie, we got something good back from the server
            window.location.href = window.CRM.root + "/sundayschool/SundaySchoolClassView.php?groupId=" + data.Id;
          });
        }
        else {

        }
      });

    });
  </script>

<?php
      }
require '../Include/Footer.php' ?>
