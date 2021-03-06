# [useful base page-type](https://github.com/FriendsOfSilverStripe/handypages "HandyPages for building a SilverStripe websites") for building a SilverStripe website. [![Latest Stable Version](https://poser.pugx.org/FriendsOfSilverStripe/HandyPages/version.svg)](https://github.com/FriendsOfSilverStripe/HandyPages/releases) [![Latest Unstable Version](https://poser.pugx.org/FriendsOfSilverStripe/HandyPages/v/unstable.svg)](https://packagist.org/packages/FriendsOfSilverStripe/HandyPages) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FriendsOfSilverStripe/HandyPages/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/FriendsOfSilverStripe/HandyPages/?branch=master) [![Total Downloads](https://poser.pugx.org/FriendsOfSilverStripe/handypages/downloads.svg)](https://packagist.org/packages/FriendsOfSilverStripe/handypages) [![License](https://poser.pugx.org/FriendsOfSilverStripe/HandyPages/license.svg)](https://github.com/FriendsOfSilverStripe/HandyPages/blob/master/license.md)

### A collection of useful PHP classes and SilverStripe modules for SS 3.x to get a new website started quickly.

The [generic page](https://github.com/FriendsOfSilverStripe/HandyPages/blob/master/code/pagetypes/GenericPage.php "View GenericPage.php") type comes with the following *deactivatable* options for inputs:

* alternative title and intro (including min/max-length validation)
* an image per page (including width/height validation)
* brand colors (only adjustable by admins) and a option to choose a color per page
* configuration switch to use the [blocks module](https://github.com/sheadawson/silverstripe-blocks "SilverStripe blocks by Shea Dawson").

and the following modules:

* [Display logic](https://github.com/unclecheese/silverstripe-display-logic "Display logic for the SilverStripe admin section")
* [SortableGridField](https://github.com/UndefinedOffset/SortableGridField "Sortable GridField")
* [heyday' menu manager](https://github.com/heyday/silverstripe-menumanager "Manage multiple SilverStripe menus on one website")
* [ZenValidator to validate inputs of content-editors and website users](https://github.com/sheadawson/silverstripe-zenvalidator "ZenValidator is used for most validation")
* [Inheritage of values from parent page types](https://github.com/FriendsOfSilverStripe/inheritage-by-sitetree "Allows to inherit a value from parent pages in the SiteTree")
* [Backendmessages](https://github.com/FriendsOfSilverStripe/backendmessages#usage "DRY generation of message boxes in the CMS.") for message boxes.

### How to use this?

Simply extend your custom page types of this GenericPage:

```
class MyNewPage extends GenericPage
{
    /**
     * here goes your actual code...
     */
}
```
and then your can configure

```
MyNewPage:
  useBlocksModule: true
  hideCMSOptions:
    - AlternativeTitle
  intro:
    minLength: 100
    maxLength: 1000
  image:
    width: 200
    height: 300
```

### Want it? Installation

Just run:

```
# install the package
composer require friendsofsilverstripe/handypages

# add run dev/build
php ./framework/cli-script.php dev/build
```

## misc: [Future ideas/development, issues](https://github.com/FriendsOfSilverStripe/handypages/issues), [Contributing](https://github.com/FriendsOfSilverStripe/handypages/blob/master/CONTRIBUTING.md), [License](https://github.com/FriendsOfSilverStripe/handypages/blob/master/license.md)
