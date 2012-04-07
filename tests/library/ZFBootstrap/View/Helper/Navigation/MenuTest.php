<?php

namespace ZFBootstrap\View\Helper\Navigation;

use DOMDocument,
    DOMXPath,
    PHPUnit_Framework_TestCase,
    Zend_Navigation,
    Zend_Navigation_Page_Uri,
    Zend_View,
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
        $this->assertInstanceOf('Zend_View_Helper_Navigation_Menu', $this->helper,
                                'Menu helper should extend Zend_View_Helper_Navigation_Menu!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownClassIsAppliedToFirstDropdownTriggerParentLiElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]/..');

        $this->assertSame('dropdown', $result->item(0)->getAttribute('class'),
                          '#dropdown1 trigger parent <LI> element is missing the "dropdown" class!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownClassIsAppliedToSecondDropdownTriggerParentLiElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown2"]/..');

        $this->assertSame('dropdown', $result->item(0)->getAttribute('class'),
                          '#dropdown2 trigger parent <LI> element is missing the "dropdown" class!');
    }

    ///////////////////////////////////////////////////////////////////////////
    // protected:
    ///////////////////////////////////////////////////////////////////////////

    /**
     * Returns the supplied HTML as a DOMXPath object.
     *
     * @return DOMDOcument
     */
    protected function getAsDomXpath($html)
    {
        $domDoc = new DOMDocument();
        $domDoc->loadHTML($html);

        return new DOMXPath($domDoc);
    }

    ///////////////////////////////////////////////////////////////////////////

    /**
     * Generates and returns a test menu.
     *
     * @return array
     */
    protected function getTestMenu()
    {
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
                       new Zend_Navigation_Page_Uri(array('label' => 'Dropdown Trigger 1',
                                                          'pages' => $dropdownPages[0],
                                                          'uri'   => '#dropdown1')),
                       new Zend_Navigation_Page_Uri(array('label' => 'Dropdown Trigger 2',
                                                          'pages' => $dropdownPages[1],
                                                          'uri'   => '#dropdown2')));
        return new Zend_Navigation(array(new Zend_Navigation_Page_Uri(array('label' => 'Root',
                                                                            'pages' => $pages,
                                                                            'uri'   => '/'))));

    }

    ///////////////////////////////////////////////////////////////////////////

    protected function setUp()
    {
        $this->helper = new Menu();
        $this->helper->setView(new Zend_View());
    }

    ///////////////////////////////////////////////////////////////////////////

    protected function tearDown()
    {
        $this->helper = null;
    }

    ///////////////////////////////////////////////////////////////////////////

    /**
     * The helper being tested.
     *
     * @var ZFBootstrap\View\Helper\Navigation\Menu
     */
    protected $helper = null;
}
