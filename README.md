Prefixed Pimple library for PublishPress
==============

Prefixed version of `pimple/pimple`.

This repository holds all interfaces related to [PSR-11 (Container Interface)][psr-url], prefixed for PublishPress.

Note that this is not a Container implementation of its own. It is merely abstractions that describe the components of a Dependency Injection Container.

The installable [package][package-url] and [implementations][implementation-url] are listed on Packagist.

[psr-url]: https://www.php-fig.org/psr/psr-11/
[package-url]: https://packagist.org/packages/psr/container
[implementation-url]: https://packagist.org/providers/psr/container-implementation

## How to update the prefixed library

This library depends on `psr/container` but that package is prefixed on another repository and is called `publishpress/psr-container`. This will be adjusted by the script `post-update.php`. In order to update this library, you need to:

1. Update the version constraint for the original library on the `composer.json` file;
2. Update the version number for this prefixed library in the `composer.json` file with the new version of the original library and the current iteration (4th digit);
3. Run the command `composer update`. The scripts on the `lib` folder will be auto prefixed and the files `include.php` and `Versions.php` class auto generated;
4. Run the tests `composer test` to run tests and make sure the Version class is working properly;
5. Make a manual check in the prefixed library;
6. Commit the changes;
7. Create a new release on GitHub naming it with the original version number and incrementing the fourth digit with the current iteration;
