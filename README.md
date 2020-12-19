# Adds a theme system to your laravel project

This package allows you build your own theme system inside any laravel project.

**THIS IS ALPHA VERSION AND IS STILL ONGOING DEVELOPMENT**

## Installation

You can install the package via composer:

```bash
composer require webdevhayes/laravel-theme-system
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Webdevhayes\LaravelThemeSystem\LaravelThemeSystemServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the views with:

```bash
php artisan vendor:publish --provider="Webdevhayes\LaravelThemeSystem\LaravelThemeSystemServiceProvider" --tag="views"
```

## Usage

Instantiate the class 

```php
$themeSystem = new LaravelThemeSystem();
```

Get all themes

```php
$themes = $themeSystem->getThemes();
```

Activate a theme

```php
$themes = $themeSystem->activateTheme('themeNameHere');
```


## Theme folder structure needs to be as follows in order to add custom themes

```bash
resources -> views -> vendor -> laravel-theme-system -> themes -> theme name
```

## Theme is identified by a theme.php file

```php
/*
Theme Name: My Theme Name
Theme URI: https://google.com
Author: the WordPress team
Author URI: https://google.com
Description: This is my theme
Version: 1.3
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
```

## Theme image

Add a preview.png or preview.jpg to the theme folder.

## TODO/POSSIBLE FEATURES
* Add tests
* Allow custom theme path ability
* Complete theme info functionality
* Add exception handlers
* Add theme upload/delete views
* Add more usable default theme

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
