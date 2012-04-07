<?php

namespace ZFBootstrap\View\Helper\Navigation;

use DOMDocument,
    DOMXPath,
    Zend_Navigation_Container,
    Zend_View_Helper_Navigation_Menu;

/**
 * Adds support for the Twitter Bootstrap dropdown menus Javascript plugin
 * to the Zend_View_Helper_Navigation_Menu class.
 *
 * @author Michael Moussa <michael.moussa@gmail.com>
 */
class Menu extends Zend_View_Helper_Navigation_Menu
{
    /**
     * Intercept render() call and apply custom Twitter Bootstrap class/id
     * attributes.
     *
     * @see   Zend_View_Helper_Navigation_Menu::render()
     * @param Zend_Navigation_Container $container (Optional) The navigation container.
     *
     * @return string
     */
    public function render(Zend_Navigation_Container $container = null)
    {
        return $this->applyBootstrapClassesAndIds(parent::render($container));
    }

    ///////////////////////////////////////////////////////////////////////////

    /**
     * Applies the custom Twitter Bootstrap dropdown class/id attributes where
     * necessary.
     *
     * @param  string $html The HTML
     * @return string
     */
    protected function applyBootstrapClassesAndIds($html)
    {
        $domDoc = new DOMDocument();
        $domDoc->loadHTML($html);

        $xpath = new DOMXPath($domDoc);

        foreach ($xpath->query('//a[starts-with(@href, "#")]/..') as $item)
        {
            $item->setAttribute('class', 'dropdown');
        }

        return $domDoc->saveHTML();
    }
}
