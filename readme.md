# Soda

### Overview

**Soda** is a framework for building powerful, object-oriented WordPress themes. 

### Why Soda?

* Create modular, maintainable themes.
* Manage your theme components from a semantic Yaml file.
* Extend base themes cleanly, no more `if(!function_exists())` calls.

### What's in Soda?

* AssetManager, which handles your themes styles and scripts.
* SidebarManager, which handles your theme sidebars.
* Translator, which handles your themes i18n functions.
* SupportManager, which handles theme support definitions.
* Cache, a simple cache wrapper for the `WP_Object_Cache`
* Theme, the class which configures everything.

Future Components:

* Breadcrumbs, simple breadcrumbs.
* Header, implement custom headers. 
* Paginator, handle your post pagination.
* AttributeManager, define groups of attributes (e.g. schema)for different sections of your theme. 
* Regions, a simple way to define re-usable content blocks in your theme.


### Getting Started Guide

##### 1. Setup your functions file

To get started with Soda, open your themes functions.php file and implement the following code:

`exampletheme/functions.php`:

```
use MyTheme\Theme\MyTheme;

add_action('after_setup_theme', function() use (&$theme) {

	if(is_child_theme())
		return false;
	
	include('vendor/autoload.php');

	$theme = new MyTheme();
	
}, 5);
```

##### 2. Setup your theme class

Once your functions.php file has been setup, let's create the `MyTheme` class. Within the theme folder, create a folder structure as follows:

`exampletheme/src/MyTheme/Theme/`

Next, let's create a file in this new folder structure called `MyTheme.php`:

`exampletheme/src/MyTheme/Theme/MyTheme.php`:

```
namespace MyTheme\Theme;

use Soda\Component\Theme\Theme;
use Soda\Component\Theme\ThemeInterface;

class MyTheme extends Theme implements ThemeInterface
{
	public function boot()
	{
		echo "Hello World!";
	}
}
```

##### 3. Configure your theme

Almost there, let's setup our theme configuration file which will load our menus, assets, sidebars and so on. Create a new folder in your theme structure called `config`:

`exampletheme/config`

Next, create a new file called `theme.yml` in this folder:

`exampletheme/config/theme.yml`: 

```
parameters:
    theme.textdomain: My Theme Text Domain
    theme.contentwidth: 650
    theme.supports:
        html5: ['search-form']
        post-formats: ['video', 'aside', 'gallery']
        custom-background: {'default-color': 'fff'}
    theme.sidebars:
        mysidebar:
            name: My Example Sidebar
            description: My Sidebar Description
    theme.menus:
        primary: 'Top Menu'
    theme.styles:
        app: ['css/style.css', null, '1.5.2', 'all']
        php: ['css/test.css', null, '1.5', 'all']
    theme.scripts:
        jquery: ['https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', null, '1.7.2', true]
```
##### 4. Install

Finally, let's bring all our components together and install Soda. In the theme directory, create a file called `composer.json`:

`exampletheme/composer.json`:

```
{
	"name": "myname/mytheme",
    "license": "MIT",
    "type": "project",
    "minimum-stability": "dev",
    "description": "My Example Theme",
    "require": {
        "soda/framework-standard-edition": "@dev"
    }
    "autoload": {
        "psr-0": { "MyTheme\\Theme\\": "src/" }
    }
}
```

Next, run `composer install` from your command line to install Soda and your new theme.

##### 5. Final Steps

Now that your theme (and Soda) have been setup, you can start playing around with some of Soda's features.

### Configuration

Soda uses Yaml configuration files to compose your WordPress theme.

##### 1. Theme Parameters

One of the primary definition files is `theme.yml`, this controls the behaviour of the different components in your theme, such as its assets, sidebars, menus, textdomain and much more:

`exampletheme/config/theme.yml`:

```
parameters:
    theme.textdomain: My Text Domain
    theme.contentwidth: 650
    theme.supports:
        html5: ['search-form']
        post-formats: ['video', 'aside', 'gallery']
        custom-background: {'default-color': 'fff'}
    theme.sidebars:
        mysidebar:
            name: My Sidebar
            description: My Sidebar Description
        mysecondsidebar:
            name: My Second Sidebar
            description: My Sidebar Description
    theme.menus:
        primary: 'Top Menu'
    theme.styles:
        app: ['css/style.css', null, '1.5.2', 'all']
        php: ['css/foundation.css', null, '1.5', 'all']
    theme.scripts:
        jquery: ['https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', null, '1.7.2', true]

```

##### 2. Theme Services

Each theme has access to Soda's Dependency Injection container, this means you can setup your own services to add functionality to your theme (e.g. a pagination service)

`exampletheme/config/theme.yml`:

```
[..]
services:
    mypaginator:
        class: MyTheme\Theme\Components\MyPaginator
```

We will touch more on the Dependency Injection container in the ** Creating Components ** section. 

### Using Components

To get started with Soda's components, you simply need to request them from the themes container. Keep in mind, you will rarely need to explicitily use one of the components in your theme. This is because the components are automatically invoked from the themes configuration file (`theme.yml`).

##### Using the Translator

In your themes `index.php` file, let's grab our Translator component and start echo'ing some strings:

`exampletheme/index.php`:

```
[..]

// Print the string
$theme->get('translator)->t('My Text);

// Return the string
$theme->get('translator)->t('My Text, true);

```

So, what's happening here?

* We're grabbing our translator service from the Soda container.
* We're using the `t` method (translate) on the object.

The astute reader will notice that **we don't need to append the themes textdomain** in the method call, this is because it is handled for you. 

### Creating Components

##### Creating the base component

##### Using the Dependency Injection Container

### Examples

##### Setting up a menu navigation walker

##### 

### Performance

##### Setting up W3 Total Cache

