<?php
require 'Include/Config.php';
require 'Include/Functions.php';

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Note;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Emails\NewPersonOrFamilyEmail;
use ChurchCRM\PersonQuery;
use ChurchCRM\dto\Photo;
use ChurchCRM\dto\SystemURLs;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Utils\LoggerUtils;
use ChurchCRM\Authentication\AuthenticationManager;


//Set the page title
$sPageTitle = gettext('Register staff');


?>