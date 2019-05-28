DebugKit Ex
===

**DebugKit Ex** is an extension for the CakePHP DebugKit plugin.  
It provides some additionals panels such as nosql (redis) queries logging and cache logging.

Requirements
--
* [CakePHP 2.2.0 or older](http://http://cakephp.org/)
* [DebugKit Plugin](https://github.com/cakephp/debug_kit)

For older cakephp, download the 1.3.x version


Install
--

###Install the plugin###

#### Download the plugin

Either with `git clone` or by downloading the archive.

##### With Git clone

	cd app/Plugin
	git clone git://github.com/AudiologyHoldings/DebugKitEx.git DebugKitEx
	
##### Download the archive

[Download](https://github.com/AudiologyHoldings/DebugKitEx/zipball/master) the latest release, and uncompress it in `app/Plugin`. Make sure the plugin folder is named *DebugKitEx*.

##### With composer

Add `"audiologyholdings/debug-kit-ex": "2.2.*""` to your composer dependencies, then run

	composer install

#### Load the plugin into CakePHP

```php
CakePlugin::load(array('DebugKit','DebugKitEx'));
```

#### Load the panels

To load the extended panel, edit your debugkit call (in your *AppController.php* probably)

```php	
	var $components = array('DebugKit.Toolbar' => array(
   	 'panels' => array('DebugKitEx.Cache', 'DebugKitEx.Nosql', 'DebugKitEx.Resque') // Load only what you want
	));
```

Enabling **each panels requires some additionals step**, since each panels depends on an external tools/plugin.

## Available panels

###Cache Panel###
![Cache Panel](https://raw.github.com/kamisama/DebugKitEx/gh-pages/img/cache-panel.png)

####Install the custom cache adapter####

Since redefining core class in a plugin is impossible, you have to drop the `app/Plugin/DebugKitEx/Lib/Cache/Cache.php` file in `app/Lib/Cache/` (create the folder if necessary).  
You application will use this Cache class instead of the one in the core, the main benefit is that you don't need to change anything in your calls to the Cache class.  
This class implements additionals method to logs the cache activities, the cache panel will not works without it.

###NoSql Panel###
![NoSql Panel](https://raw.github.com/kamisama/DebugKitEx/gh-pages/img/nosql-panel.png)


####Install the nosql datasource layer####

The NoSql panel will only works with one of my other plugin, see its [page](https://github.com/kamisama/CakePHP-NoSQL-Datasource) on how to install and use it.

###Resque Panel###

![Cache Panel](https://raw.github.com/kamisama/DebugKitEx/gh-pages/img/resque-panel.png)

To use with [CakeResque](http://cakeresque.kamisama.me/)

##Changelog##

####Ver 2.2.9 (2013-09-24)####
* Add plugin to packagist

####Ver 2.2.8 (2012-10-17)####
* Gracefully handle errors when panels dependencies are not found

####Ver 2.2.7 (2012-10-16)####
* Fix Repository file structure

####Ver 2.2.6 (2012-10-01)####
* New UI for Resque Panel

####Ver 2.2.5 (2012-10-01)####
* New UI for NoSql panel
* NoSql panel can display more than one Nosql engine

####Ver 2.2.4 (2012-09-30)####
* New UI for Cache panel, require the latest debugkit plugin

####Ver 2.2.3 (2012-09-10)####
* Add queries time and queries count stats for NoSql panel

####Ver 2.2.2 (2012-09-09)####
* Update Resque Job panel to display query time (require [CakePHP-NoSQL-Datasource](https://github.com/kamisama/CakePHP-NoSQL-Datasource) 0.4)

####Ver 2.2.1 (2012-09-08)####
* Add ResqueJob Panel, to display jobs enqueuing with [CakeResque](http://cakeresque.kamisama.me/)

####Ver 2.2.0 (2012-07-01)####
* Update plugin for DebugKit 2.2 and for CakePHP 2.2 (requires at least cakephp 2.2)
