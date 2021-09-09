# Magento 2 Module - Content Widgets

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

The `Augustash_ContentWidgets` module offers some fairly standard content call-out and promotional widgets for a Magento website.

## Installation

### Via Composer

Install the extension using Composer using our development package repository:

```bash
composer config repositories.augustash composer https://augustash.repo.repman.io
composer require augustash/module-content-widgets:~2.2.1
bin/magento module:enable --clear-static-content Augustash_ContentWidgets
bin/magento setup:upgrade
bin/magento cache:flush
```

## Uninstall

After all dependent modules have also been disabled or uninstalled, you can finally remove this module:

```bash
bin/magento module:disable --clear-static-content Augustash_ContentWidgets
rm -rf app/code/Augustash/ContentWidgets/
composer remove augustash/module-content-widgets
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for a Magento 2 module](http://devdocs.magento.com/guides/v2.4/extension-dev-guide/build/module-file-structure.html).
