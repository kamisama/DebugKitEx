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

Drop the *DebugKitEx* folder in you *app/Plugin* directory, and load the extended panel, by editing your debugkit call (in your *AppController.php* probably)
	
	var $components = array('DebugKit.Toolbar' => array(
   	 'panels' => array('DebugKit.Cache', 'DebugKitEx.Nosql) // Load only what you want
	));

Enabling each panels requires some additionals step, since logging functions are not available in the core.

Available panels
--

###Cache###
![Cache Panel](https://github.com/kamisama/DebugKitEx/blob/master/screens/cache_panel.jpg?raw=true)

####Install the custom cache adapter####

Since redefining core class in a plugin is impossible, you have to drop the *Lib/Cache/Cache.php* file in you *Lib/Cache/* directory (create it if necessary). You application will use this Cache class instead of the one in the core, the main benefit is that you don't need to change anything in your calls to the Cache class.  
This class implements additionals method to logs the cache activities, the cache panel will not works without it.

###NoSql###
![NoSql Panel](https://github.com/kamisama/DebugKitEx/blob/master/screens/nosql_panel.jpg?raw=true)

####Install the nosql datasource layer####

The NoSql panel will only works with one of my other plugin, see its [page](https://github.com/kamisama/CakePHP-NoSQL-Datasource) on how to install and use it.

##Changelog##

####Ver 2.2.0 (2012-07-01)####
* Update plugin for DebugKit 2.2 and for CakePHP 2.2 (requires at least cakephp 2.2)