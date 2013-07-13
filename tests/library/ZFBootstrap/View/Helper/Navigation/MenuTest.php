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
    public function testCaretElementIsAddedAsChildOfTheFirstDropdownTrigger()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]/b[@class="caret"]');

        $this->assertSame(1, $result->length, '<b class="caret"> for first dropdown trigger not found!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testCaretElementIsAddedAsChildOfTheSecondDropdownTrigger()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown2"]/b[@class="caret"]');

        $this->assertSame(1, $result->length, '<b class="caret"> for second dropdown trigger not found!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testCharactersAreEncodedProperly()
    {
        $menu = $this->getTestMenu();
        $menu->findOneBy('label', 'Root')->setLabel('áéíóú');

        $xpath  = $this->getAsDomXpath($this->helper->render($menu));
        $result = $xpath->query('//a[@href="/"]');

        $this->assertSame('áéíóú', $result->item(0)->textContent, 'Characters were not properly encoded!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownClassIsAppliedToFirstDropdownTriggerParentLiElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]/..');

        $this->assertContains('dropdown', $result->item(0)->getAttribute('class'),
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

    public function testExistingDropdownClassesAreNotClobberedOnParentLiElement()
    {
        $xpath   = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result  = $xpath->query('//a[@href="#dropdown1"]/..');
        $classes = explode(' ', $result->item(0)->getAttribute('class'));

        $this->assertSame('active', $classes[0],
                          'Existing dropdown trigger class was clobbered!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownClassesAreNotAppliedIfNoUlElementForDropdownMenuIsFound()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#i-am-not-a-dropdown"]');

        $this->assertSame('', $result->item(0)->getAttribute('data-toggle'),
                          '#i-am-not-a-dropdown should not have a "data-toggle"');

        $result = $xpath->query('..', $result->item(0));
        $this->assertSame('', $result->item(0)->getAttribute('class'),
                          '#i-am-not-a-dropdown parent <LI> element should not have a class applied!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownDataToggleIsAppliedToFirstDropdownTrigger()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]');

        $this->assertSame('dropdown', $result->item(0)->getAttribute('data-toggle'),
                          '#dropdown1 trigger is missing the "dropdown" data-toggle attribute!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownDataToggleIsAppliedToSecondDropdownTrigger()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown2"]');

        $this->assertSame('dropdown', $result->item(0)->getAttribute('data-toggle'),
                          '#dropdown2 trigger is missing the "dropdown" data-toggle attribute!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownMenuClassIsAppliedToFirstDropdownMenuUlElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]/../ul');

        $this->assertSame('dropdown-menu', $result->item(0)->getAttribute('class'),
                          '#dropdown1 dropdown menu is missing the "dropdown-menu" class!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownMenuClassIsAppliedToSecondDropdownMenuUlElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]/../ul');

        $this->assertSame('dropdown-menu', $result->item(0)->getAttribute('class'),
                          '#dropdown2 dropdown menu is missing the "dropdown-menu" class!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownToggleClassIsAppliedToTheFirstDropdownTrigger()
    {
        $xpath   = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result  = $xpath->query('//a[@href="#dropdown1"]');
        $classes = explode(' ', $result->item(0)->getAttribute('class'));

        $this->assertSame('dropdown-toggle', $classes[1],
                          '#dropdown1 trigger is missing the "dropdown-toggle" class!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testDropdownToggleClassIsAppliedToTheSecondDropdownTrigger()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown2"]');

        $this->assertSame('dropdown-toggle', $result->item(0)->getAttribute('class'),
                          '#dropdown2 trigger is missing the "dropdown-toggle" class!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testExistingDropdownToggleClassesAreNotClobbered()
    {
        $xpath   = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result  = $xpath->query('//a[@href="#dropdown1"]');
        $classes = explode(' ', $result->item(0)->getAttribute('class'));

        $this->assertSame('dont-clobber-me', $classes[0],
                          'Existing dropdown trigger class was clobbered!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testHtmlIsReturnedWithTheUlElementAsTheRootNode()
    {
        $html = $this->helper->render($this->getTestMenu());

        $this->assertRegExp('/^<ul/', $html, '<ul> should be the root node!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testIdAttributeMatchingHrefValueIsAppliedToFirstDropdownTriggerParentLiElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown1"]/..');

        $this->assertSame('dropdown1', $result->item(0)->getAttribute('id'),
                          '#dropdown1 trigger parent <li> element is missing the "dropdown1" id!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testIdAttributeMatchingHrefValueIsAppliedToSecondDropdownTriggerParentLiElement()
    {
        $xpath  = $this->getAsDomXpath($this->helper->render($this->getTestMenu()));
        $result = $xpath->query('//a[@href="#dropdown2"]/..');

        $this->assertSame('dropdown2', $result->item(0)->getAttribute('id'),
                          '#dropdown2 trigger parent <li> element is missing the "dropdown2" id!');
    }

    ///////////////////////////////////////////////////////////////////////////

    public function testMenuHelperExtendsZendMenuViewHelperClass()
    {
        $this->assertInstanceOf('Zend_View_Helper_Navigation_Menu', $this->helper,
                                'Menu helper should extend Zend_View_Helper_Navigation_Menu!');
    }

    ///////////////////////////////////////////////////////////////////////////
    // protected:
    ///////////////////////////////////////////////////////////////////////////

    /**
     * Returns the supplied HTML as a DOMXPath object.
     *
     * @param  string $html The HTML
     * @return DOMDocument
     */
    protected function getAsDomXpath($html)
    {
        $domDoc = new DOMDocument('1.0', 'utf-8');
        $domDoc->loadHTML('<?xml version="1.0" encoding="utf-8"?>' . $html);

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
        $dropdownPages = array(array(new Zend_Navigation_Page_Uri(array('active' => true,
                                                                        'label'  => 'Subpage 1-1',
                                                                        'uri'    => '/subpage1-1')),
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
