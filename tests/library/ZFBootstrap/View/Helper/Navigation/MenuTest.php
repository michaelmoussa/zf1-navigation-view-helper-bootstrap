<?php

namespace ZFBootstrap\View\Helper\Navigation;

use PHPUnit_Framework_TestCase,
    ZFBootstrap\View\Helper\Navigation\Menu;

/**
 * ZFBootstrap\View\Helper\Navigation\Menu tester
 *
 * @author Michael Moussa <michael.moussa@gmail.com>
 */
class MenuTest extends PHPUnit_Framework_TestCase
{
    public function testMenuHelperExtendsZendMenuViewHelperClass()
    {
        $this->assertInstanceOf('Zend_View_Helper_Navigation_Menu', new Menu(),
                                'Menu helper should extend Zend_View_Helper_Navigation_Menu!');
    }
}
