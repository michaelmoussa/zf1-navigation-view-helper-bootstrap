<!DOCTYPE html>
<?php

///////////////////////////////////////////////////////////////////////////////
// Bootstrap the demo
///////////////////////////////////////////////////////////////////////////////

set_include_path(__DIR__ . '/../library' . PATH_SEPARATOR . get_include_path());

require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('ZFBootstrap\\');
$autoloader->setFallbackAutoloader(true);

$dropdownPages = array(array(new Zend_Navigation_Page_Uri(array('label' => 'Subpage 1-1',
                                                                'uri'   => '/subpage1-1')),
                             new Zend_Navigation_Page_Uri(array('label' => 'Subpage 1-2',
                                                                'uri'   => '/subpage1-2'))),
                       array(new Zend_Navigation_Page_Uri(array('label' => 'Subpage 2-1',
                                                                'uri'   => '/subpage2-1'))));

$pages = array(new Zend_Navigation_Page_Uri(array('label' => 'Page 1',
                                                  'uri'   => '/page1')),
               new Zend_Navigation_Page_Uri(array('label' => 'Page 2',
                                                  'uri'   => '/page2')),
               new Zend_Navigation_Page_Uri(array('class' => 'dont-clobber-me',
                                                  'label' => 'Dropdown Trigger 1',
                                                  'pages' => $dropdownPages[0],
                                                  'uri'   => '#dropdown1')),
               new Zend_Navigation_Page_Uri(array('label' => 'Dropdown Trigger 2',
                                                  'pages' => $dropdownPages[1],
                                                  'uri'   => '#dropdown2')),
               new Zend_Navigation_Page_Uri(array('label' => 'I am not a dropdown',
                                                  'uri'   => '#i-am-not-a-dropdown')));

$demoMenu = new Zend_Navigation(array(new Zend_Navigation_Page_Uri(array('label' => 'Root',
                                                                         'pages' => $pages,
                                                                         'uri'   => '/'))));

///////////////////////////////////////////////////////////////////////////////

use ZFBootstrap\View\Helper\Navigation\Menu;

///////////////////////////////////////////////////////////////////////////////
// Get an instance of Zend_View and register the Twitter Bootstrap
// dropdown-compatible menu helper in place of the default.
///////////////////////////////////////////////////////////////////////////////

$view = new Zend_View();
$view->registerHelper(new Menu(), 'menu');

///////////////////////////////////////////////////////////////////////////////

?>

<html>
    <head>
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" />
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <?php echo $view->navigation($demoMenu)
                                    ->menu()
                                    ->setMinDepth(1)
                                    ->setUlClass('nav nav-pills'); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/jquery.js"></script>
        <script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
    </body>
</html>
