## Description

This Zend Framework View Helper extends the existing **Zend_View_Helper_Navigation_Menu** view helper to render dropdown menus compatible with the format required in [Twitter Bootstrap](http://twitter.github.com/bootstrap/javascript.html#dropdowns). The automatic dropdown functionality requires adding various **class**, **id**, and **data-toggle** attributes, which Zend Framework's menu view helper doesn't natively support.


## Instructions

To use this helper in your Zend Framework project, import the **library/ZFBootstrap/View/Helper/Navigation/Menu.php** file into your project's **library** directory. You can change the ZFBootstrap name if you want - I don't care. =).

Next, simply add the following line of code somewhere in your project (ideally in your [Application Bootstrapping Code](http://framework.zend.com/manual/en/zend.application.examples.html)):

```php
$view->registerHelper(new Menu(), 'menu');
```

This will replace Zend's Menu view helper with this customized one.

**Note:**
1. You'll need to **use ZFBootstrap\View\Helper\Navigation\Menu;** somewhere in that file, or **new Menu()** will fail.
2. **$view** is an instance of your view, and how you obtain it will depend on where you integrate this code. Consult the ZF documentation if you're not sure about how to get an instance of your view.

To activate a dropdown, just set the href of the dropdown trigger to **#dropdownName**. The new helper will automatically find any hrefs beginning with **#** set the **dropdownName** ID on the corresponding **UL** tag.

## Demo

You can open the **index.php** file under the **demo** directory to see a sample.

**Note:** The demo assumes Zend Framework is in your PHP include path.


## Requirements

* Zend Framework
* Twitter Bootstrap
* PHP 5.3


## Questions / Comments?

Send me an e-mail. If my code helps you out in your project, I'd love to hear about it.


## Bugs / Improvements

If you spot any bugs or have an idea for an improvement, please create an issue for it, or feel free to write the fix/improvement yourself and send a pull request. I'd appreciate if any contributions also included tests.
