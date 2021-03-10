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
$sPageTitle = gettext('All Assets');


require 'Include/Header.php';

?>

