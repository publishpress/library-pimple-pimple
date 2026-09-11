Prefixed Pimple library for PublishPress
==============

Prefixed version of [`pimple/pimple`](https://github.com/silexphp/Pimple). Namespace `Pimple` becomes `PublishPress\Pimple`.

This package depends on the already-prefixed [`publishpress/psr-container`](https://packagist.org/packages/publishpress/psr-container) for PSR-11 types. Strauss still rewrites `Psr\Container` references inside Pimple, then `scripts/post-update.php` removes the nested `lib/psr` copy so runtime uses the shared package.

## How to update the prefixed library

1. Change the pinned upstream version in `require-dev` (`pimple/pimple`) to the target (still a fixed constraint). Keep `publishpress/psr-container` in `require`.
2. Set `version` to that upstream version plus the next fourth digit (`3.5.0` → `3.5.0.1` for a first prefixed build, or increment the fourth digit for another prefixing pass of the same upstream).
3. Run `composer update`. Strauss prefixes into `lib/`; `post-update.php` strips nested PSR-11 from `lib/` and `lib/composer/`; the generator refreshes `include.php` and `VersionLoader.php`.
4. Copy `.env.example` to `.env` (fill `WP_TESTS_*`). Run `composer test:unit`, then `composer test:integration`. Version-loader tests are Integration. Without `.env`, Codeception exits immediately.
5. Review the prefixed code in `lib/` by hand. On Strauss 0.29, extra package files and `lib/composer/` are normal. For this PSR-0 library, live classes are under `lib/pimple/pimple/src/PublishPress/Pimple/` — delete any leftover unprefixed `src/Pimple/` tree. Confirm `lib/psr` is gone and Composer maps no longer reference `PublishPress\Psr\Container`.
6. Commit.
7. Create a GitHub release named with the four-digit version (for example `3.5.0.11`) so Packagist sees the tag.

Then run `composer update` in the plugins that consume the package.
