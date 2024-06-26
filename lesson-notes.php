#1 -- Create a WordPress Plugin from Scratch Part 1
<!-- 
MY New adventure begins! May god assist me with whatever I wish to do <3 

The only requirement to create a plugin is we need a unique name for it.
It'll be called itay-plugin

The first file we need to create is the same name of the plugin's name .php that's the main file.

By default WP checks all the folders inside the plugin installation and detects the file with the same plugin folder name of ours and selects all the files inside it and reads them.

View itay-plugin.php

Lets define a global setting:
/*
*
* @package ItayPlugin
*/
This section is identitcal to writing the style in style.css to give WP an ability to recognize the theme.
/*
  xPlugin Name: Itay Plugin
  xPlugin URI: https://github.com/LaNguAx/wp-plugin-course
  xDescription: This is my first attempt on writing a custom Plugin xfor this amazing tutorial series.
  xVersion: 1.0.0
  xAuthor: Itay Aknin
  xAuthor URI: https://www.linkedin.com/in/itay-aknin-aa5691270/
  xLicense: GPLv2
  xText Domain: itay-plugin
*/

Lets create a really important file to have security in the plugin, it's the standard index.php inside the plugin folder.

If someone tries to access directly your plugin folder it will not go into all the available file, incase that happens he'll be redirected to index.php.

In the next video we'll spend time on security precossuion of developing a plugin, without exposing backdoors, etc...
-->


#2 -- Create a WordPress Plugin from Scratch Part 2
<!-- 
  In this lesson, we're going to tackle the important aspect of securing our WP plugin.

  There are many ways to tackle this, lets learn them.
  
  The first and regular security measure is an IF statement for checking if the file is being accessed directly.

  3 ways to check if the WP plugin is being accessed externally: 
    if (!defined('ABSPATH'))
    die;

    defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!');

    if(!function_exists('add_action)) {
      die('Hey, you can\t access this file, you silly human!');
    }

  This Absolute Path is WP Constant that defines the absolute path for the WP website, this constant variable carries itself throughout the installation if and only the software itself is the CMS or PHP code other INTERNAL files are accessing our php file.
  If something else external from our website is accessing those files this ABSPATH is not defined, so if ABSPATH is NOT defined, kill the execution. That means the that if someone is looking at the file without permission granted by WP so we don't want to trigger and functionality and grant access to external people.

  We can also check if add_action is defined, if it's defined that means we're inside the WP installation so it's also a way to check if someone external is trying to access our website.
  If it doesnt exist WP didn't load anything, didn't generate anything.

  Always remember the first 2 things of creating a plugin:
  1. Index.php completely empty with a comment.
  2. Create the plugin file and a safety valve for the plugin(View one of the 3 stated above).
-->

#3 -- Basic PHP OOP
<!-- 
  In this lesson, we're going to look at the basic of PHP OOP.
  In this seris we'll use PHP OOP.

  First thing we have to do is create a class:
  To create a php class: class $nameOfClass {}
  Lets assign a unique name to our class, it's a must.
  class ItayPlugin {}

  Inside the class we'll write all of our methods.

  In PHP a class doesn't initialize by itself.
  If we want to use the class, we need to create a new instance of the class and store it in a variable!
  $itayPlugin = new ItayPlugin();
  (if you don't need to use the new instance of the class you can do it without storing it in a variable, usually doesn't happen)

  Before creating the class we MUST check if the class is exists, it's a safety precossuin.
  Lets wrap the initialization of the class inside an if check.
 
  if(class_exists('ItayPlugin')) {
  $itayPlugin = new ItayPlugin();
  }


  Now what happens?
  If we have a function called customFunction for e.g. and we need to pass some variable and all it does it echos the arg, in order to call it in procedural PHP is just calling the custom function and passing whatever argument(Procedural PHP).

  To do the same for the class, that whenever we initialize the class, meaning upon initialization a method will fire, we can use a constructor function and give it the params we want.
  Use __construct method.
  Basically that method that gets called by default when initializing a class is called the __construct, it's the method that accepts the parameter we pass when initializing the new class. 
  $itayPlugin = new ItayPlugin('Itay Plugin initialized!');
  function __construct($string) {
    echo $name; // Will output 'Itay Plugin initialized'.
  }

  We can use the type functionality of php.
  function __construct(string $string) {
    echo $string;
  }
  If we pass a different type, we'll get an error, by passing a type we're forcing accepting only a string for the method to fire.
  However we won't use it in this course.

  Now let's use the built-in methods of WP, to actually activate unique methods of our plugin. WP automatically triggers 3 default actions:
  The moments where they are triggered:
  1. Activation
  2. DeActivation
  3.Uninstall

  Lets create default methods that'll happen when the moments are triggered.
  Lets use the default hooks that WP gives for activation, deactivation and uninstall.

  __FILE__ is the proper way of writing the hook, the global var of __FILE__ we're saying the register activation hook needs to work ONLY in this current file(itay-plugin.php)!

  // In order to tap the activation method inside the class we need to pass an array, 2 params, 1st is the class instance and the 2nd parmam is what we want to activate.
  // Activation
  register_activation_hook(__FILE__, array($itayPlugin, 'activate'));

  register_activation_hook === add_action('init', 'function_name');

  // DeActivation
  register_deactivation_hook(__FILE__, array($itayPlugin, 'deactivate'));

  In PHP if you are using a function that is called after the header was sent it'll trigger an error, most likely it'll trigger header already sent.

  Why does it happen?
  To understand why headers must be sent before output it's necessary to look at a typical HTTP response. PHP scripts mainly generate HTML content, but also pass a set of HTTP/CGI headers to the webserver:

  <Code>
    HTTP/1.1 200 OK
    Powered-By: PHP/5.3.7
    Vary: Accept-Encoding
    Content-Type: text/html; charset=utf-8

    <html><head><title>PHP page output page</title></head>
    <body><h1>Content</h1> <p>Some more output follows...</p>
    and <a href="/"> <img src=internal-icon-delayed> </a>
  </Code>  

  The page/output always follows the headers. PHP has to pass the headers to the webserver first. It can only do that once. After the double linebreak it can nevermore amend them.

  When PHP receives the first output (print, echo, <html>) it will flush all collected headers. Afterward it can send all the output it wants. But sending further HTTP headers is impossible then.

  
  The plugin returns an error because we are trying to echo this onactivation, this means that onactivation called that unique method. If we leave the plugin active and refresh, we won't have that error message anymore, why is that?
  Because : The onActivation was triggered already, the plugin is already active so there's no errors because we are not triggering the activation hook, we're just refreshing the page. 

  Why the 2 methods (onactivation, deactivation) are useful?
  They are really useful when you need to edit, update DB of user when they activate/deactivate the plugin, the easiest example we can do, is generate a custom post type and flush the rewrite rules.

  On DeActivation, we can simply flush-rewrite rules instead of deleting the post type, because after de-activation the post-type won't be avaiable.

  And on uninstall we will want to delete the post-type created for example.
-->

#4 -- Custom Post Type
<!-- 
  In this lesson, we'll generate a CPT and flush the re-write.
  Flush re-write rules is make WP be aware of something that happened in the database so WP can properly read the new data we wrote in the DB, basically refreshing the DB.

  In deActivation we want to simply refresh the DB again because after the post type was deleted we don't want WP to accidently generate content for that data.
  
  function custom_post_type() {
   register_post_type('book', array('public' => true));
  }

  After activating the plugin, you'll see that nothing happens, why is that? Because we didn't attach a hook to the custom_post_type registration method.

  Lets attach it to the onactivation method so upon activation, $itayPlugin->custom_post_type() will run and generate our custom post type!

  To do that we'll need to use the construct function that'll execute upon class initialization, therefore when class is created we can use some hooks to start manipulation our plugin's data needs.
  
  <Code>
    function __construct() {
      add_action('init', array($this, 'custom_post_type'));
    }
  </Code>
  array($this, 'custom_post_type') is used to reference the method inside the current calling class.


  <Code>
    function __construct() {
      add_action('init', array($this, 'custom_post_type'));
    }
    function custom_post_type() {
      register_post_type('book', array('public' => true, 'label' => 'Books'));
    }
  </Code> 

  Now the post type is created because the register_post_type function is properly hooked to the add_action init hook, which is being called using the __construct method which is being called by the initialization of the class.

  Now we need to flush-rewrite rules, when we create something new in DB we need to tell WP to refresh the DB.
  It's a really easy snippet, flush_rewrite_rules();

  Because we add it inside the onactivation, everything related to the custom_post_type properly works, because the DB is refreshed.
  It's a must when upon initialization of the class your plugin is generating many many things in the DB it's a must to call this so it'll make sure the data is loaded properly for the plugin.
  Basically really important when upon activating we add something to the db, and it interacts with the db.

  It is a bad practice to call the 'init' hook on __construct method, because the 'init' could potentially fail.
  It could happen when you activate the plugin, the init action doesn't actually trigger itself because it's inside a WP installation that already initialized, in order to avoid that, lets called the custom_post_type function directly inside the activate function, when the plugin is really activated.

  To call class methods in other class methods, we can do:
  <Code>
    function activate() {
    // Generate CPT
    $this->custom_post_type();
    // Flush re-write rules
    flush_rewrite_rules();
  }
  </Code>

  When deactivating the data is still saved in the DB.
  But when uninstalling we must delete everything from th DB.
-->

#5 -- Uninstall Hook
<!-- 
  In this lesson, we'll learn how to use the uninstall hook that WP automatically applies to every plugin.

  <Code>
    // Uninstall
    register_uninstall_hook(__FILE__, array($itayPlugin, 'uninstall'));
  </Code>

  This returns an error:
  <Code>
    Function register_uninstall_hook was called incorrectly. Only a static class method or function can be used in an uninstall hook.
  </Code>
  This means that to call the uninstall method we need to make it a static method. So we need to set uninstall to be a static method.

  The other way Aless says is better is to instead of having a uninstall hook and method, we can do:
  Create a unique PHP file that gets triggered when the user uninstalls the plugin, this file has to be inside the plugin folder and has to be called uninstall.php.

  Before writing anything in this file, we need to do our security check, so people won't have access to this file and do DB manipulation when uninstalling.
  if(!defined('WP_UNINSTALL_PLUGIN)) die;
  If this global var is not defined, that means someone accessed the file externally.

  The uninstall.php is used for important thing, clear DB data. So it has db access, that's why security measures for it is important.

  If a malicious user accesses uninstall.php he can destory the DB, so we need to becarful with it.

  Now lets use the uninstall.php file to delete the custom post file generated upon uninstallation.

  <Code>
    // Clear database stored data
    $books = get_posts(array('post_type' => 'book', 'numberposts' => -1));

    foreach ($books as $book) {
      wp_delete_post($book->ID, false);
    }
  </Code>

  The above code is good if we have one custom post type or one custom taxonomy.

  However if we have multiple options, and we want to delete everything at once, without doing that.
  We can use the almighty, $wpdb.

  <Code>
    // Access the database via SQL.
    global $wpdb;
  </Code>

  <Code>
    $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
    // Here we are deleting everything from wp_posts where post_id is NOT found in the wp_posts. Because we already deleted the post_type posts of book, so their ID will not be found, beautiful.
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
  </Code>

  It checks if a post meta is related to a post that doesn't exist anymore, great logic.
-->

#6 -- Enqueue Admin Scripts
<!-- 
  In this lesson we'll learn how to create js scripts for admin dashboard.
  <Code>
    function enqueue() {
    //enqueue all of our scripts.
    }
  </Code>

  Now we need to create the assets folder and inside of it there'll be css and js files.

  Now we need to dynamically call this enqueue() method, we could use the usual action, or we could create a unique method to trigger/register our enqueue script at a specific time.

  <Code>
    function register() {
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }
    function enqueue() {
      //enqueue all of our scripts.
     wp_enqueue_style('mypluginstyle', plugin_dir_url(__FILE__) . '/assets/mystyle.css');
    }
    $itayPlugin->register();
  </Code>

  We didn't want to put the register method inside the construct because we didn't want to enqueue the method upon class initializing, we want to handle this with the register method.

  wp_enqueue_scripts -- for frontend
  admin_enqueue_scripts -- for backend
-->

#7 -- PHP Visibility Methods
<!-- 
  This lesson will be focused on PHP OOP and understand different visibility of variables of methods inside a PHP class.

  We'll learn how to propery use a different visiblity option.
  Differentiate between public, private and protected variable and method.
  Aswell as use static methods.

  In OOP we need to define a class that wraps all different methods, in order to access a method of the class we need to create a new instance of the class and store it inside the variable and from that variable call the method with -> .
  This works because all methods inside class in PHP are public methods.

  Lets start by checking the visibility of a method and what does it mean?
  We have 3 options of defining visiblity for a method/variable:
  
  public
  protected
  private

  These declarations are a part of PHP, what it does it defines the vsibility of a specific method. It's saying to PHP:

    Public method/variable: Can be accessed everywhere, from the class itself, outside, by declaring instance.. In the example we access the method from outside the class using the instance.
    If we don't declare a visibility, the methods/variables are automatically public.
    
    Protected: Can be accessed only within the class itself or from a class that extends the current class.
    For example if we want to declare custom post type is protected, and we decide to call it from the instance(outside the class) it'll trigger a PHP error. Call to a protected method. 

    Private: Can be accessed only by the class itself.

  Why are we splitting the class?
  It's because in the future it's important to split the class to different method, extending the class and properly protecting your methods with different visibilities.

  The visiblity always needs to be before a function.
  
  The class variables:
  public $var1 = 1;
  private $var2 = 2;
  protected $array1 = array(); 
-->

#8 -- Static Methods and Multiple Files
<!-- 
  In this lesson, we're going to tackle the static method of PHP and how to use them to split our file in multiple files and manage different classes in the better more organized way.

  Lets learn what a static method does, if you implement the static attribute to a function.

  It could be attached to whatever kind of function (private,protected,public).

  Visibility -> STATIC/NOT -> function -> $functionName

  What a static method does is:
  Allows you to use the method without initializing the class.

  <Code>
    // To call a static method without initializing the class.
    ItayPlugin::register();
    // Calling this method, throws an error! Why is that?
    // Beause we are trying to use $this, inside an uninitialized class method, so the $this keyword is not assigned to the class we're trying to call the method of.

    // Because we didn't initialize the class, new ItayPlugin(); the $this keyword is not assigned to an object.

    //However if the register() method was to echo 'some text';
    // Meaning if the register() method was dependant of the $this keyword it won't work because the $this variable is not assigned to any class because the class wasn't initalized.
    // It'd work beautifully!
  </Code>

  In order to call another method inside a class that wasn't initialized we need to make that other method a static one.
  To do it we need to pass the name of the class itself.
  <Code>
    add_action('admin_enqueue_scripts', array('ItayPlugin', 'enqueue'));
  </Code>

  Why are we doing this? Because sometimes it's useful. Lets learn how to split this code into 2 other files and delegate it to handle only activate and deactivate hooks!

  Create a new folder called inc, inside that folder you should have all files and subfolders related to PHP.

  Now lets create the boilerplate for our classes, lets copy it from the package information of the first class.
  <Code>
    class ItayPluginActivate {
      public static function activate() {
        flush_rewrite_rules();
      }
    }
  </Code>

  Now we can delete it from the original class and delegate those activate and deactivate actions to those newly created classes without instantiating them!

  Because we split those methods to different files, we need to require them.
  <Code>
    // Activation
    require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-activate.php';
    register_activation_hook(__FILE__, array('ItayPluginActivate', 'activate'));
  </Code>
    
  This is how we call a static method of a hook without initializing the class itself.

  To call it without using a hook:
  <Code>
    // This activate function is inside the main itay-plugin.php
    function activate() { 
      require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-activate.php';
      ItayPluginActivate::activate();
    }

    register_activation_hook(__FILE__, array($itayPlugin, 'activate'));
  </Code>

  Freaking beautiful, the way static functions work.
  PHP is overall a really beautiful language.

  You can call a method from another file in 2 different ways:
  1. Require the file and call the method inside the main class and call it statically.
  2. Call the method directly inside the register hook, 1st param is name of class and 2nd is method, but before you need to require the class.
-->

#9 -- Settings Link and Admin Pages
<!-- 
  In this lesson, we're going to take a look on how to build the most basic things of a plugin, custom admin sections, custom links, etc..
  We'll learn learn how to have a custom admin section with a custom link and how to link that to our admin area.

  Lets activate the custom admin area first, using the register function.

  <Code>
    public function register() {
      add_action('admin_enqueue_scripts', array($this, 'enqueue'));
      add_action('admin_menu', array($this, 'add_admin_pages'));
    }
  </Code>

  <Code>
    public function add_admin_pages() {
      // Manage options is saying that only an administrator can access this page.
      // Always write slugs with underscores
      add_menu_page('Itay Plugin', 'ItayPL', 'manage_options', 'itay_plugin', array($this, 'admin_index'), 'dashicons-store', 110);
    }
    public function admin_index() {
    }
  </Code>

  Now lets create a template that'll be used to genereate the html for Itay Plugin menu page.

  Create a new file, called admin.php inside a folder named templates.
  Now we need to require that file in the admin_index method that is being used as a callback for the admin_menu_page generation of the HTML.

  Damn, that works beautifully, I swear OOP is simply beautiful..


  Lets implement a settings page in the Plugins menu for our own plugin, we can filter the look of our plugin in the Plugins link in the admin dashboard.

  Everytime we want to hook a method we will not hook it directly.
  We will use the register() method to specify the functions for the hooks.

  Lets create the hook that updates the links for our plugins in the plugins list.

  <Code>
    // add_filter('plugin_action_links_NAME-OF-MY-PLUGIN');
  </Code>
  
  This filter gives our return function a list of the links for each plugin page and we can add/remove and then return the data, so our plugin will have different links.

  We want to use in the filter our plugin's name so we can do:
  plugin_basename(__FILE__) and concatenate it to plugin_action_links_ filter hook.

  However that's pretty bad, so lets store the name of the plugin inside a variable, so we can access it easily.

  <Code>
    class ItayPlugin {
      public $plugin;

      function __construct() {
        $this->plugin = plugin_basename(__FILE__);
      }
    }
  </Code>
  
  Everytime a class will initialize the construct function will set the class variable $plugin to the plugin_basename(__FILE__) return value, we do that when the class instantiates because that means all of our settings are registered and it's the correct time to set the variables data.

  Now lets create the settings field for our plugin:
  <Code>
    public function settings_link($links) {
      // add custom settings link
      $settings_link = '<a href="options-general.php?page=itay_plugin">Settings</a>';
      array_push($links, $settings_link);
      return $links;
    }
  </Code>
-->

#10 -- Namespaces and Composer Autoload
<!-- 
  In this lesson, we're going to take a look on how to implement composer namespaces inside our plugin.
  Composer is a package manager for PHP.

  What it does is give you dynamic access to the libraries you want to use to build better PHP scripts, we'll use autoload which gives us the abitlity to use namespaces instead of using require once and all of those things, etc.
  We can simply specifiy the name of the class to reference a file.

  Download composer and install it.
  
  After we installed it, we need to require it once within all of our script.
  <Code>
    if (file_exists(dirname(__FILE__) . '/vendor/autoload.php'))  {
      require_once dirname(__FILE__) . '/vendor/autoload.php';
    }
  </Code>

  Instead of using require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-activate.php';

  We go into that file that we are requiring and we set the name of it using Namespace Inc;
  And lets rename the file to Activate.php and the class in the file to Activate.php

  To use the file we use:
  use Inc\Activate;

  Then to use it instead of:
  <Code>
    require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-activate.php';
    ItayPluginActivate::activate();
  </Code>

  We simply do: 
  <Code>
    Activate::activate();
  </Code>

  Lets do the same for deactivate:
  <Code>
  // require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-deactivate.php';
  
  register_deactivation_hook(__FILE__, array('Deactivate', 'deactivate'));
  
  </Code>

  The ability of 'use' will give us the ability to use a better way to recognize our files and folders, and have a better structure, without having require_once or other weird names for paths.
-->

#11 -- Classes as Services
<!-- 
  In this lesson, we're going to take a look on how to structure by intitial files in order to build a proper plugin.

  We need to leave the title of the plugin and first file of plugin with same exact name, that cannot be changed.

  Lets create a new file called Init.php inside 'inc' folder
  and then lets create a folder called 'Pages' and 'Base'.

  Now lets move activate/deactivate into Base folder.

  Now we have created the structure.
  We have the 'inc' folder, where all the php methods are inside, we have the init.php that we're going to initialize dynamically all the classes and methods that we need to trigger as soon as plugin is activated.

  <Code>
    if(class_exists('Inc\\Init')) {
      Inc\Init::register_services();
    }
  </Code>
  
  We have created an Init file and a class Init which in there we will use the Init class to trigger and load all the other classes without creating an instance of the class Init so we set the register_services() method to be a static method.

  This class will be to register our services and return those instance of those classes.

  The init class will never get extended, or get re-used by another class we can specify a 'final' before the class, it means PHP will not have ability to extend this class by another class.

  <Code>
    final class Init{}
  </Code>

  Now lets check how to gerenate the admin page dynamically.
  All of the classes will have a register method to register triggers functions.

  Lets define in the Init.php file a function that register all of our list of services.
  It'll return the full list of classes inside an array so we could initialize them.

  to return an entire class without initializing it:
  <Code>
    public static function get_services() {
      return [
        Pages\Admin::class;
      ];
    }
  </Code>

  Lets create a constant variable for the plugin dir path inside the main plugin file itay-plugin.php

  To enqueue scripts we create a new file called enqueue inside Base.

-->

<!-- BOILERPLATE THAT WE DELETED BECAUSE OF NEW STRUCUTRE -->
<!-- 
  <Code><!-- 
use Inc\Activate;
use Inc\Deactivate;
use Inc\Admin\AdminPages;
  
class ItayPlugin {

public $plugin;

function __construct() {
  $this->plugin = plugin_basename(__FILE__);
}

public function register() {
  add_action('admin_enqueue_scripts', array($this, 'enqueue'));

  add_action('admin_menu', array('AdminPages', 'add_admin_pages'));

  add_filter("plugin_action_links_d$this->plugin", array('AdminPages', 'settings_link'));
}

protected function create_post_type() {
  add_action('init', array($this, 'custom_post_type'));
}

function custom_post_type() {
  register_post_type('book', array('public' => true, 'label' => 'Books'));
}

function enqueue() {
  //enqueue all of our scripts.
  wp_enqueue_style('mypluginstyle', plugin_dir_path(__FILE__) . '/assets/mystyle.css');
  wp_enqueue_script('mypluginscript', plugin_dir_path(__FILE__) . '/assets/myscript.js');
}

function activate() {
  // require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-activate.php';
  // ItayPluginActivate::activate();

  // After composer we can simply use
  Activate::activate();
}
}

if (class_exists('ItayPlugin')) {
$itayPlugin = new ItayPlugin('Itay Plugin initialized!');
$itayPlugin->register();
}



// Activation
register_activation_hook(__FILE__, array($itayPlugin, 'activate'));

// DeActivation
// require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-deactivate.php';
register_deactivation_hook(__FILE__, array('Deactivate', 'deactivate'));

// Uninstall
//View uninstall file. 
</Code>
-->


RECAP: Plugin Structure & Classes as Services
<!-- 
  The plugin structure php structure is split into 2 files.
  Base & Pages.
  Base controls the php code for the plugin itself and not specific pages.
  Pages controls the php code for the specific pages we want to manipulate.

  The way Aless teached us to use the structure is by creating a php file called Init inside the 'inc' folder and within that file create a class that'll handle the automation of instantiating the necessary classes for the plugin to work, all we need to do is simply add the classes themselves (not instantiated versions of them) to the array that gets them.

  Basically what he's trying to do is say that Classes are services, meaning we need to get them first, have them saved somewhere in a really top level function (in the Init.php file) and handle all the classes within there. 

  There we can add new classes and control them.

  We are automating the generation of the classes by using a top level Init class that'll loop through the classes we give it and initialize them and execute the register() method within them after their execution.

  Then inside those classes, the $this keyword will be available and we could indeed access the register() method. View the code:

  <Code>
    <Code Inside main file(itay-plugin.php)>
      if (class_exists('Inc\\Init')) {
        Inc\Init::register_services();
      }
    </Code>

    final class Init {
      /**
      * Store all the classes inside an array
      * @return array Full list of classes
      */
      public static function get_services() {
        return [
          //Here we add the new classes themselves, not their instance.
          Pages\Admin::class,
          Base\Enqueue::class,
        ];
      }

      /**
      * Loop through the classes, intialize them.
      * and call the register() method if exists.
      * @return 
      */
      public static function  register_services() {
        foreach (self::get_services() as $class) {
          $service = self::instantiate($class);
          if (method_exists($service, 'register')) {
            $service->register();
          }
        }
      }
      /**
      * Initialize the class
      * @param class $class class from the services array
      * @return class instance new instance of the class
      */
      private static function instantiate($class) {
        $service = new $class();
        return $service;
      }
    }
  </Code>

  Note that the 'self' keyword is used to refer to a class that has not been instantiated.

  IMO this is a really beautiful approach, yes it will take time to set it up but after that it's amazing creating new classes and working with them.

  Also note that we need to save the PLUGIN_PATH and the PLUGIN_URL to a global constant variable because the plugin_dir_path changes the return value according to the current location of the file, so we set those constant variables inside the main itay-plugin.php file for the path to be the original plugin path.

  To summarize, the plugin is split into top level classes that control things for the whole plugin and into lower level class that control specific things in the plugin.

  We then load them automatically when the plugin is generated using a loop and instantiate them and call the register method within them that'll handle the action hooks, etc.
-->

#12 -- Starter Plugin Structure
<!-- 
  In this lesson we are going to continue the implementation of our new plugin architecture by reactivating the methods we had before.

  Right now we are missing the settings and activation/deactivation method.

  WP requires the activation/deactivation hooks needs to be outside of any class so they need to be inside the main plugin file:
  <Code>
    register_activation_hook(__FILE__, 'activate_itay_plugin');
    register_deactivation_hook(__FILE__, 'deactivate_itay_plugin');
  </Code>
-->

#13 -- Visual Deby and Clean Up
<!-- 
  In this lesson, we are going to spend a few minutes of cleaning up the structure we did last time. The main focus is to consider the visual depth of the PHP script.

  What if there's another plugin related constants?
  It could interefere with our constants, lets create a base controller that defines those public constants and extend it to let other classes to use those public variables.
  
  Lets create a new file called 'BaseController.php'.

  That class, the only thing it does is: defines publicly accessable variabl and then intialize them in the construct to set them up properly in our plugin.

  To summarize: Instead of using 'define' to set up constant variables, we use a class that creates public variables that hold the constants' values that we wanted and we extend the other classes so they could make use of the class that creates the variables (baseContrller);
-->

#14 -- Modular Administration Page
<!-- 
  In this lesson, Lets write down what we want to build, view README.md file.

  Lets create the administration area.
  
  Lets create an API class that taps the settings API and gives us the access to a more modular approach.

  Because we are going to create a class that'll handle the Settings API lets create a folder called API, and we're going to create in it our files that'll handle the api calls within wordpress.

  <Code>
    class SettingsApi {

      public $admin_pages = array();

      public function register() {
        if (!empty($this->admin_pages)) {
          add_action('admin_menu', array($this, 'addAdminMenu'));
        }
      }

      public function addPages(array $pages) {
        $this->admin_pages = $pages;
        // this returning for each method is important for method chaining.
        return $this;
      }


      public  function addAdminMenu() {
        foreach ($this->admin_pages as $page) {
          add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);
        }
      }
    }
  </Code>

  Then the usage inside Admin.php changes:
  <Code>
    class Admin extends BaseController {

      public $settings;

      public $pages = array();

      public function __construct() {

        $this->settings = new SettingsApi();
        $this->pages = array(
          [
            'page_title' => 'Itay Plugin',
            'menu_title' => 'ItayPL',
            'capability' => 'manage_options',
            'menu_slug' => 'itay_plugin',
            'callback' => function () {
              echo '<h1>Itay Plugin</h1>';
            },
            'icon_url' => 'dashicons-store',
            'position' => 110
          ],
          [
            'page_title' => 'Test Plugin',
            'menu_title' => 'TestPL',
            'capability' => 'manage_options',
            'menu_slug' => 'Test_plugin',
            'callback' => function () {
              echo '<h1>Test Plugin</h1>';
            },
            'icon_url' => 'dashicons-external',
            'position' => 9
          ]

        );
      }
      public function register() {
        $this->settings->addPages($this->pages)->register();
      }
    }
  </Code>

  I want to explain this code briefly because I believe this is really important to understand for the continuation of developing plugins.

  Basically, the approach here is to create an external class that'll handle the data manipulation that is needed, and return it to the class that is the first executor of that action.

  Here what happens is that we create a new class called SettingsAPI, and inside it define functions that handle generating our admin pages using variables and arrays with their values being unknown(I'll say that is literally amazing).

  Then we need to use that class inside the Admin.php file so we create a variable for it and after that Admin class is generated, in the __construct function we give a the created variable ($settings) the value of the new instance of the SettingsAPI class so that we could use that class' methods inside our Admin.php class.

  Then after the Admin class is constructed, immediatly after the register() method is being executed, why is that?
  Because of the Init.php class that we created before that handles executing the register() method of each class after it's instantiated.

  And inside that register() method we take advantage of the new instance of SettingsAPI class to generate the menus but with the data that we receive inside Admin class.

  $this->settings->addPages($this->pages)->register();
  This line does all the hard work, basically what's going on here is:
  Admin class accesses the settings variable which was set to be the new instance of the SettingsAPI class, then it reaches inside that new class instance for the method called addPages, addPages method sets the value of the new Settings API instance's variable called admin_pages to the value of class Admin->pages and after that it returns $this, meaning after addPages() function is executed on the settings instance the return value is the new instance itself so we can take advantage of METHOD CHAINING and then access the register() method on the new Settings API instance and that'll take care of adding the menu pages themselves. 
  
  SettingsAPI does all the hardwork, Admin gets all the data and passes SettingsAPI the data to do the work. 
-->

#15 -- Modular Admin SubPages
<!-- 
  In this lesson, we want to generate subpages.
  The first subpage you want to create is the repetition of the main page, for example. Click on WPdashboard->Settings->General. Settings and General are the same, 2 links go to the same direction.

  In PHP whenever you write return whatever is after the return is not going to be executed.

  We use the admin_menu hook's callback to generate the menus using a loop.
  We loop throuigh the pages which is inside the Data class called Admin and we create a new instance of the interaction with the settings api class so we use the data from Admin inside SettingsApi to generate the menus.
  <Code>
    public function register() {
      $this->settings->addPages($this->pages)->withSubPage('Dashboard') ->addSubPages($this->subpages)->register();
    }
  </Code>
-->

#16 -- Dealing with Callbacks
<!-- 
  In this lesson we're going to look at how to properly structure and organize our callbacks because in WP we'll have a lot of callbacks.

  Everytime we created a page WP needs a callback, thats how WP grabs the code for the generation of the menu's page.
  Right now we have an inline function and that is BAD because those callbacks will have a lot of logic behind them (It's called a closure) so we need to properly require a specific file and organize those files in a proper folder structure.

  Instead of calling the callback function we need to require_once the file we want to be used for the callback.

  However right now we have a problem that we override the __construct method and that overrides the class that extends the current class' variables.

  Please note this weird behavior in PHP, that an extending class' variables will get overridden if the class extended has a __construct method because the __construct method of the extended class overrides the variables generated by __consturct of extending class.

  So using $this->plugin_path returns 'null' because the __consturct method overrides the variables of $this.

  So lets use the register method instead of touching the __construct method.


  To take care of the callbacks lets create a class that takes care of all Admin Related Callbacks.

  Inside Api->Callbacks->AdminCallbacks.php

  We don't initialize it in the init because we want to make it work only whenever the admin menus generate, so we initialize it inside Admin.php.

  We split the callbacks into a seperate class so we could manage independantly the data manipulation before the template output.

  <Code>
    //Code inside Admin.php:
    class Admin extends BaseController {
      public $callbacks;

      public function register() {
        $this->callbacks = new AdminCallbacks();
      }
      public function setPages() {
        'callback' => array($this->callbacks, 'adminDashboard'),
      }
    }

    // Code inside AdminCallbacks.php:
    class AdminCallbacks extends BaseController {
      public function adminDashboard() {
        return require_once("$this->plugin_path/templates/admin.php");
      }
    }
  </Code>

  Note how the callback function of the setPages function points towards the new instance of callbacks class inside Admin.php and in there it uses the require_once to print out the template for the admin dashboard. This lets us handle data manipulation before output of content into the page.
-->

#17a -- Admin Custom Fields
<!-- 
  In this lesson, we are going to create custom fields in our admin area.

  Lets create a function inside the SettingsApi class called registerCustomFields(). In that function we can define everything we need for the fields.

  WP handles the field in 3 different actions.
  1. Register Settings -- Basically imagine a group that contains the settings of your specific custom fields.
  2. Add settings section -- This generate the settings section that is going to get print within the register setting in a specific page, this action has a callback in order to handle what we're going to print in that page.
  3. Add settings field -- The actual action that will add the custom field attached to the section and the setting itself.

  <Code>
    public function registerCustomFields() {
      // Register_setting
      register_setting($setting['option_group'], $setting['option_name'], isset($setting['callback']) ? $setting['callback'] : null);

      // Add settings section
      add_settings_section($section['id'], $section['title'], isset($section['callback']) ? $section['callback'] : null, $section['page']);

      // Add settings field
      add_settings_field($field['id'], $field['title'], isset($field['callback']) ? $field['callback'] : null, $field['page'], $field['section'], isset($field['args']) ? $field['args'] : null);
    }
  </Code>

  Basically we'll be using the same logic to loop through all the settings then generate them using the arguments we give registerCustomFields, same logic exactly as the SettingsApi->addAdminMenu();

  Create the settings fields programmatically.

  <Code>
    public function registerCustomFields() {
      foreach ($this->settings as $setting) {
        // Register_setting
        register_setting($setting['option_group'], $setting['option_name'], isset($setting['callback']) ? $setting['callback'] : null);
      }

      foreach ($this->sections as $section) {
        // Add settings section
        add_settings_section($section['id'], $section['title'], isset($section['callback']) ? $section['callback'] : null, $section['page']);
      }

      foreach ($this->fields as $field) {
        // Add settings field
        add_settings_field($field['id'], $field['title'], isset($field['callback']) ? $field['callback'] : null, $field['page'], $field['section'], isset($field['args']) ? $field['args'] : null);
      }
    }
  </Code>

  Before we can create the fields we need to create some Setters methods that populates the currently empty variables $this->settings, $this->sections, $this->fields.

  <Code>
    public function setSettings(array $settings) {
      $this->settings = $settings;
      return $this;
    }
    public function setSections(array $sections) {
      $this->sections = $sections;
      return $this;
    }
    public function setFields(array $fields) {
      $this->fields = $fields;
      return $this;
    }
  </Code>

  Now we need to declare the fields inside our Admin.php. Basically create the data inside Admin.php and then make it work using the SettingsApi.
-->

#17b -- Admin Custom Fields
<!-- 
  In this lesson, we'll continue the how to create more dynamic and modular class to handle generation of custom fields.

-->
#17c -- Admin Custom Fields
<!-- 
  The last part of how to build a custom field in the administration area of WP with our custom plugin.


  Basically the sections are created dynamically from an array, so we created an interface where only updating the array is required in order to generate new fields.

  This approach of allecad is literally amazing.
-->
#18 -- Admin Tabs in Vanilla JS
<!-- 
  In this lesson, we are going to start customizing the admin panel.
  We'll create an admin panel, with 3 tabs.

  Just simple JS and CSS, view those files, you already know this stuff.
-->

#19 -- Modular Callbacks
<!-- 
  In this tutorial we are going to look at how to automatically activate/deactive specific section through checkboxes in UI sections in our administration area.

  I first set up the whole JS automation part using @wordpress/scripts like I learned in Brad's course, this way the whole process is automated and I changed the wp_enqeueu_script location to build/adminscript.js and for the css.

  We're going to list all the settings/features with a checkbox to activate, everytime we activate it should appear in the admin sidebar.

  First lets generate the settings area.

  Go into Inc->Admin, lets generate the names of the fields.
-->

#20 -- iOS toggle in SCSS
<!-- 
  In this lesson, we're going to take a look on how to customize our administration area to make the boring checkboxes looking super good with an iOS toggle look.

  Just some SASS changes.
-->

#21 -- Code Cleanup
<!-- 
  In this lesson, we're going to look at how to optimize our code to make it easy to manage on the long run.

  We moved all of our declarations of managers to our BaseController and creating a globally accessible array called managers which contains all our features.

  We simply looped through that array and then added the settings and fields.

  <Code>
    $this->managers = array(
      'cpt_manager' => 'Activate CPT Manager',
      'taxonomy_manager' => 'Activate Taxonomy Manager',
      'media_widget' => 'Activate Media Widget',
      'gallery_manager' => 'Activate Gallery Manager',
      'testimonial_manager' => 'ActivateTestimonial Manager',
      'templates_manager' => 'Activate Templates Manager',
      'login_manager' => 'Activate Login Manager',
      'membership_manager' => 'Activate Membership Manager',
      'chat_manager' => 'Activate Chat Manager'
    );
  </Code>

  <Code>
    $args = array();
    foreach ($this->managers as $key => $value) {
      $args[] =  array(
        'id' => $key,
        'title' => $value,
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => $key,
          'class' => 'ui-toggle'
        ),
      );
    }
  </Code>
-->

#22 -- Database Optimization
<!-- 
  In this lesson, we're going to look at how to optimize DB when we deal with a lot of custom fields.

  The DB converts TRUE to 1 and FALSE to 0.

  WP saves the data in a serialized way. This is a good approach when you have multiple options just to avoid bloating the DB.

  We need to serialize the data saved, otherwise we RISKING slower db 3x.

  The serialized data works in this way:
  a: Stands for array, then the number of slots in the array.
  Every slot of data is seperated by a semi column, why it says 3 if we have 6 types of datA?

  In this tutorial we'll convert all of our option fields to one single option field in order to not bloat the DB!
  Seems like something quite interesting!
  Serialize the data basically, lets see how we do it.


  First we need to access our definition of the settings, and the fields.

  We are creating one single setting for every field, thats why we have every single setting as a different db entry.

  Lets comment the foreach we created and define just one single option name: View code inside Admin->Settings

  Lets start by updating the checkboxField to work with the serialized way of the settings stored.

  ---- Read from here
  Basically instead of saving each manager as a DB entry we save them all in an array inside a db key called itay_plugin, WP then serializes that data that we store into something like this: a:9:{s:11:"cpt_manager";b:0;s:16:"taxonomy_manager";b:0;s:12:"media_widget";b:0;s:15:"gallery_manager";b:0;s:19:"testimonial_manager";b:0;s:17:"templates_manager";b:0;s:13:"login_manager";b:0;s:18:"membership_manager";b:0;s:12:"chat_manager";b:0;}

  Then we can access that array by using get_option('itay_plugin') and then we can access each value of the array keys using their key name by doing $arr['taxonomy_manager'].
  
  You basically need to save the array keys somewhere(we saved them in the extended class BaseController) and using that we can read the data from the db using the example above.

  Here's the code to make it work:
  <Code>
    public function checkboxField($args) {
      $name = $args['label_for'];
      $classes = $args['class'];
      $checkbox = json_decode(get_option($args['option_name']), true);

      echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $args['option_name'] . '[' . $name . ']" value="1"' . (isset($checkbox[$name]) && $checkbox[$name] ? 'checked' : '') . '/><label for="' . $name . '"><div></div></label></div>';
    }
  </Code>

  This is the code for the db save: Please note how we get the $input array passed by wp, it contains the values for the checkboxes, it does all the logic by itself. Whenever we press 'Save Changes' the data that gets passed into $input is the data saved in the db, so we can manipulate it there.

  <Code>
    public function checkboxSanitize($input) {

      $output = array();
      // In this loop we need to check if the input inside itself has a key that is equal to $key.
      foreach ($this->managers as $key => $value) {
        $output[$key] = (isset($input[$key]) and $input[$key] == 1) ? true : false;
      }
      return $input;
    }
  </Code>
    
  Please note that it's also valid to simply return the $input and it'll work the same.
-->

#23 -- Save Default Options on Activate
<!-- 
  In this lesson we're going to learn WHY it's important to save default options and HOW to do it.

  Whenever we update the DB and there's no default value it could cause issues. So we create that db data in the onActivate() function of the plugin and that fixes it.

  We should always simulate a clean slate when checking our plugin.
  <Code>
    public static function activate() {
      flush_rewrite_rules();
      if (get_option('itay_plugin')) return;

      $default = array();
      update_option('itay_plugin', $default);
    }
  </Code>
-->

#24 -- Create Modular Plugin Sections
<!-- 
  In this lesson we're going to look on how to make our activation/deactivation way more modular and manageable.

  Right now we've just defined an admin dashboard where we can activate/deactivate all the features.

  Currently they're only being saved but not doing anything.
  We're going to create a controller for the CPT manager that'll handle wether we should output the content for cpt manager or not.

  Lets rename Admin class to Dashboard.
  Now lets create a new class called CustomPostTypeController that'll handle the activation of it.


  In summary we create a controller for each feature of the plugin that'll handle it's menu generation using the SettingsApi we created, and it'll handle the code for it, the template of it and all of the other data. Please view the newly created files of the controllers.
-->

#25 -- Modular Custom Post Types
<!-- 
  In this we learned how to create the custom post types in a modular way.

  Meaning we create a public class variable inside the postypeController class that consists of the post types we'd like to create and then we simply loop through them.

  Now I assume in the future we'll have those post types stored in the db by the user and then that variable will be filled with get_option from the db and then we'd create the post types using the already created registerpostytypes method inside the posttypecontroller class.

  Pretty beautiful way to create one code for many many things.
-->

#26a -- Modular Custom Post Types
<!-- 
  In this lesson we're going to take a look on how to generate dynamically our CPT thanks to the settingsApi.
  Basically we're going to code the CPT page to have the ability to add how many CPTs we want, and automatically save them into the db after pressing saveChanges and then generating them automatically in the sidebar.

  So now we need to store the data in the db and populate custom_post_types with the data. 

  We need to create a new callback file so we can manage the callbacks just for the CPTs.

  We also generated the custom post type by themselves all the attributes they need for generation.
-->

#27 -- Store Arrays in WP_Options
<!-- 
  In this lesson we're going to take a look on how to geneerate multiple custom post types with the current functionality we have right now, becausae in the prev lesson we encountered an issue where each time we created a new cpt it over-writes the previous one and not adds to it.

  We need to store the information about the CPT in a multidimensional array in a subarray that has the key as the cpt name and the value as the attributes array.

  This was a really important lesson because we learned that in order to save the settings, we need to intercept their saving in the cptSanitize callback, which is the method that 'filters' the data before it enters the DB. 

  We perform an action there to set the $input array received to a new array which has $input['post_type'] as key and $input arr as value.

  Then we check for wether or not $input['post_type'] already exists in the db by fetching the data using get_options and storing it inside $output array.

  Really simple way of determining wether or not the data should be updated. 

  This is great for the upsell plugin I want because I learned how to store the data of all the categories in one multidimensional array basically which is amazing.

  View code here:
  Sanitization before entering the db:
  <Code>
    public function cptSanitize($input) {
      $output = get_option('itay_plugin_cpt');
      foreach ($output as $type) {
        if ($input['post_type'] !== $type) {
          $output[$input['post_type']] = $input;
        }
      }
      return $output;
    }
  </Code>

  To summarize:
  In order to differentiate between the data we need to manipulate it and store it inside another array which has each cell for each post type and that cell key has to be assigned to a unique value that'll allow us to perform future checks.

  Amazing.
-->

#28 -- Custom Post Types Admin Section
<!-- 
  In this lesson we're going to take a look at extending our CPT manager to list all the post types we created, to edit, delete them.

  Lets have the tab seperation in order to seperate between the functionalities of the cpt manager.
  Lets copy the code from admin.php template to cpt.php template.

  Here we simply fetched the data from the db and printed it in the template file.
-->

#29 -- Bug Fixes
<!-- 
  In this video we're going to take a look on a lot of bugs while developing.

  To do that we need a clean slate, so lets delete the itay_plugin_cpt.
  First bug is the foreach loop, it cannot start because we don't have any data to loop into it.

  It's really important to debug the code and once in a while start debugging it from the start, remove everything and activate the plugin.

  Don't assume that the plugin works out of the box even though it currently works for us because sometimes we can work with existing data.
-->

#30 -- How to Delete a Custom Post Type
<!-- 
  In this lesson we're going to take a look on how to delete our custom post type.

  WP by default doesn't come with an option to delete a record inside an array inside an option entry in the db.

  WP offers us 3 methods to interact in the options api.
  It comes with get_option, update_option, delete_option.
  We don't want delete_option, we want to update_option and delete the specific post type we want.

  Lets go into cpt.php, here for Delete button instead of a simple link, we're going to submit a form that'll be IDENTITCAL to the current options with the settings field.

  Which means it'll send the request to that specific setting.

  So we are going to switch the Delete <a> element we created for a form in that position that is associated with our cpt_settings, that means whenever we press the delete button, the cptSanitize callback method will occur and there we perform a check to see wether or not the button needs to be deleted or not.

  We can do it using multiple different ways, but the best way is to simply use the built-in method of WP and add a hidden input element to the form that contains the data of the about to be deleted element and then in the cptSanitize method we perform the check and the deletion which is just removing from the array and returning a new array.
  Please note that we are accessing the POST request from the cptSanitize method and not the $input because the $input is empty since we're not passing any data that is related to WP settings fields but we are passing data in the post request that reaches the cptSanitize method.
  
  Great solution and easy really.

  Here's the code:
  The form for the delete button:
  <Code>
    echo '<form method="post" action="options.php" class="inline-block">';
    settings_fields('itay_plugin_settings_cpt');
    echo '<input type="hidden" name="remove" value="' . $options['post_type'] . '">';
    submit_button('Delete', 'delete small', 'submit', false, array(
    'onclick' => 'return confirm("Are you sure you want to delete this Custom Post Type? The data associated with it will not be deleted.");'
     ));
    echo '</form></td></tr>';
  </Code>

  The callback sanitization method for the deletion of the CPT:
  <Code>
    public function cptSanitize($input) {
      $output = get_option('itay_plugin_cpt');
      // Remove record from array
      if (isset($_POST['remove'])) {
        unset($output[$_POST['remove']]);

        return $output;
    }
  </Code>
-->

#31 -- How to Edit a Custom Post Type
<!-- 
  In this lesson, we're going to edit a CPT.
  This is a pretty amazing lesson, I'm writing the summary here:
  In order to edit a post we need to create a form button that'll send a $_POST request to the same URL but send some data in $_POST request.
  
  Inside the form we make the Edit button as the save_button() element by changing it's attributes. Then whenever we press the edit button, the form will send a post request and we can access it using the cptSanitize callback method.

  Each time the current url setting refresh (in this case itay_cpt) the cptSanitize method is being run. So when we send a request method to the current page we can check within the cptSanitize method for each if the $_POST object contains a variable called 'edit_post' and then we make the page's first render appear on the Edit Custom Post Type tab. p.s. You send that variable using a hidden input field, view code below for how the data gets passed into $_POST using a hidden input field.

  This is literally amazing, because of the SSR we check wether or not a specific variable exists and if it does then we render the page accordingly, I guess this is the true power of php.

  We send new data about the state of the current user which is that he's trying to edit the post and then we re-render the page accordingly.

  Then inside the cptSanitize method we have a logic that checks wether or not the $input received by the form of adding a custom post type is the same as one of the currently available CPTs in the db, and if so, then that means that it needs to be updated, so the new value is replaced with the old value in $output array and then it's returned.

  View code here:
  <Code>
    Button form element amazing logic:

    echo '<form method="post" action="" class="inline-block">';
    echo '<input type="hidden" name="edit_post" value="' . $options['post_type'] . '">';
    submit_button('Edit', 'primary small', 'submit', false);
    echo '</form> ';
  </Code>

  <Code>
    Editing Logic in cptSanitize:
      
      if ($input['post_type'] == $type) {
        $output['post_type'] = $input;
      }
  </Code>
  Basically all the editing logic does is check wether or not the post_type received by the $input exists inside the $output array which is the data fetched from the db which inside the foreach loop, each element of it referenced as $type.

  It checks if 'post_type'FROM INPUT === 'post_type'FROM DB.
  And if so then it sets the $output that's supposed to be returned where they KEY is the same as the KEY of the $input received ($input['post_type'] == $type) and sets it to the new $input received:
  <Code>
    $output['post_type'] = $input;
  </Code> 

  The foreach loop I stated above isn't really required because the code: $output['post_type'] = $input; handles all the logic for adding a cell in the array or updating it.

  View the full code here that I changed to make it work without loops here:
    public function cptSanitize($input) {
    $output = get_option('itay_plugin_cpt');

    // Remove CPT using POST Request
    if (isset($_POST['remove'])) {
      unset($output[$_POST['remove']]);
      return $output;
    }

    // Add CPT $output is length 0 
    if (!$output) {
      $output  = array($input['post_type'] => $input);
      return $output;
    }

    // Add or Edit a CPT
    $output[$input['post_type']] = $input;
    return $output;
  }
-->

#32 -- Export PHP with Code Prettify
<!-- 
  In this lesson we're going to look at how to automatically generate all the CPTs we generated.

  We want to generate a the code for export and not in excel like I thought, thats what we want to achieve.

  It uses code-prettify npm package.
  We can use it using the CDN by adding the script inside the head.

  But we don't use a CDN just for one JS file, we want everything inside the own plugin.

  We'll use NPM.
  After we downloaded it we need to import it in our js source file, so that it'd work.

  In order to use it we can import it dynamically using es6.
  View how to do it:
  <Code>
    import "code-prettify";
    @import "../../../node_modules/code-prettify/styles/desert.css";
  </Code>
-->

#33 -- Create a Custom Taxonomy Manager
<!-- 
  In this lesson, we're going to take a look on how to build a custom taxonomy manager. ALl the things we have to do are identitical for the CPT manager.

  We'll change some core functionalities but it's really similiar.



-->

#34 -- Create a Custom Taxonomy Manager Part 2
<!-- -->
#35 -- Create a Custom Taxonomy Manager Part 3
<!--  -->

SUMMARIZE:
<!--
  Okay, I want to summarize the whole implementation of the Custom Taxonomy Manager:
  After a day of training and implementing it mostly by myself, I can say I finally understood the architecture a bit better.
  This architecture works by a controller file that controls the data fetching and storing it into local variables and using callback functions from a different folder to handle those many callback functions that WP uses in a nicer way.

  The controller file consists of the data needed to implement the the feature and the callbacks file of that controller handles the manipulation of the data to output the dynamic data of the specific data passed.

  The feature is being displayed on the user using the templates folder and in that folder we have the html and php for each controller.
  Basically when creating the settings for each feature it's request to give 2 callbacks. A callback to render the input elements that wp can accept in order to update the data in the db and another callback which is the template.

  Those 2 callbacks are split into two different functions. The function that accepts the callback to render the input element is usually the register_settings_field function and the callback function that accepts the template page for that specific feature is created using the add_submenu_page, and then the settings api knows that when you are on the same slug as you provided in the add_submenu_page and in the register_setting_section and then it'll enable you to output the settings fields onto the specific page you wish.

  Please note that the add_submenu_page method requires a callback method that'll handle the output of the page, so we use a function that requires the file from the directory of the templates and outputs the php html inside of it.

  Now lets get into the specifics of how the data is being saved in DB when using the settings api.
  
  For each field generated by the callback method of register_setting_field(view code below for the args of it):
  <Code>
    array(
      'id' => 'taxonomy',
      'title' => 'Custom Taxonomy ID',
      'callback' => array($this->tax_callbacks, 'textField'),
      'page' => 'itay_taxonomy',
      'section' => 'itay_tax_index',
      'args' => array(
        'option_name' => 'itay_plugin_tax',
        'label_for' => 'taxonomy',
        'placeholder' => 'e.g. genre',
      )
    ),
  </Code>

  ... gets passed an $args array which is the 'args' passed in the array above.
  That args array allows us to get dynamic data for each instance of setting created when using the callback method of the register_setting_field to generate the html for that specific setting.

  Note it has to be an input element because that's what WP recognizes and gets the data at the end to validate it and store it in the db.

  Each callback of the settings_field has to echo out the input element and in that element it has to have several things.
  The id (for the label that'll be created), the name(explanation below), classes (optional), value(explanation below), and other html attributes that are optional.

  Name: The name attribute is ALWAYS the 'KEY' value that is stored in the db for that specific 'VALUE' attribute passed in the input.
  Meaning if I pass an input
  <Code>
    <input type="hidden" name="itay[wardrobe][gucci_shirt]" value="1" />
  </Code>

  The data that'll be passed to the SETTING SANITIZE method() which is the method controlling the $array of data passed from the input fields in order to go through some manipulation and then passed into the db) will look like this:
  <Code>
    array(
      ['wardwrobe'] => Array('gucci_shirt' => 1);
    );
  </Code>

  After the submit button is pressed, the settings api refers all the data from the input fields into the callback method specific in the register_setting function of the current settings group.

  That function passes as an $arg which is the array of the current data passed in the current form submission.
  If we want to add onto it we can simply get the data from the db and attach the new $arg array passed to it and then return the new data+arg array.


  This sanitiztion function is the function that'll handle every submission of the settings form and all of the data passes through there as a filter before the db insertion.

  Meaning we can manipulate the data, for example if the user wants to edit the specific data passed, create more data in it, do whatever he wishes with the data and then we can simply return the new data and that data is what'll be inserted into the db.

  Please note that the input fields data(as specific above) will ALL be sent into the $arg array inside an unnamed array, that means that the whole data passed from the input fields is inside an array so to get the values from that we need to access the array elements inside so it's good to debug it.

  Whenever we want to store arrays inside arrays, we set the input's name attribute to have multiple arrays, view the example above (itay[wardrdobe][gucci_shirt]).
  If we have simply:
  <Code>
    <input type="hidden" name="itay['wardrode']" value="1" />
  </Code>
  This specific input field data will be passed to the settings sanitization method like this:
  <Code>
    array(
      ['wardrobe'] = 1
    )

    eg. of the 2 inputs above in the array:
    array(
      ['wardrobe'] => array(
        'gucci_shirt' => 1
      ),
      ['wardrobe'] => 1
    );
  </Code>

  If we want to add for example another level of dimension in the array we can simply specify the input name attribute to have another [] and that'll create another dimension in the array.


  If for example we want to edit/delete some values in the db, we need to access the GLOBAL $_POST object that's being passed into the setting sanitization callback.
  The callback method consists of the global $_POST object and the $arg parameter passed to it, and we can simply perform a check if there's a variable called 'delete' for example in the $_POST object and we can perform the deletion using the data passed.
  <Code>
    if (isset($_POST['remove'])) {
      unset($output[$_POST['remove']]);
      return $output;
    }
  </Code>


  Overall, the Settings API is quite beautiful, however, it is very hard to comprehend but once you understand it, the possibilities are endless.
  Because that's how dynamic data is supposed to be stored in WP.
-->


#36 -- Create a Custom Widget
<!-- 
  In this lesson: We'll learn how to generate our first custom widget in the plugin.
  In the current lesson we'll set up a really small widget, to set it up and have a regular widget with just text.
  In the next lesson we'll learn how to properly integrate the media uploader.

  In order to generate a widget we need to extend the WP_Widget class.

  Lets create a widgets folder inside the API folder, because it's an API, create a new file called MediaWidget.php.
  Now lets copy everything from mediawidgetcontroller to mediawidget.php and change the namespace and the class name.

  In order to create a widget, the WP docs say we need to extend our class using the WP_Widget class.
  <Code>
    class MediaWidget extends WP_Widget {
    }
  </Code>

  -->
I Skipped the media widgets because it's irrelevant for 2023, there are gutenberg blocks.
<!-- -->


#38 -- Testimonial Manager Part 1
<!-- 
    Lets access testimonial controller and remove all the methods except the initialization check.

    In this lesson we simply created the custom post type for the testimonials, that it.
-->

#39 -- Testimonial Manager Part 2
<!-- 
  In this lesson, we'll add extra metaboxes to have the option to store the name of the user, the email and add those extra options to manage the testimonials.

  Lets add the options as a metabox.

-->

#40 -- Testimonial Manager Part 3
<!--
-->

Testimonial Summary:
<!-- 
  I want to summarize the creation of the metabox for a CPT.
  We add a metabox using the add_meta_box function and specify all the arguments there, then we create the render method for it and then we have a sanitization filter method that validates all the data passed through the metabox's input elements and stores it in the db.
  It's quite  a simple concept actually.

  View code here:
  <Code>
      public function register() {
    if (!$this->managerActive('testimonial_manager')) return;
    add_action('init', array($this, 'testimonial_cpt'));
    add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    add_action('save_post', array($this, 'save_meta_box'));
  }
  public function testimonial_cpt() {
    $labels = array(
      'name' => 'Testimonials',
      'singular_name' => 'testimonial'
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => false,
      'menu_icon' => 'dashicons-testimonial',
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'supports' => array('title', 'editor'),
    );

    register_post_type('testimonial', $args);
  }

  public function add_meta_boxes() {
    add_meta_box('testimonial_options', 'Testimonial Options', array($this, 'render_features_box'), 'testimonial', 'side', 'default');
  }
  public function render_features_box($post) {
    wp_nonce_field('itay_testimonial_options', 'itay_testimonial_options_nonce');
    $data = get_post_meta($post->ID, 'testimonial_options', true);
?>
    <label for="itay_testimonial_author">Testimonial Author</label>
    <input type="text" name="itay_testimonial_author" id="itay_testimonial_author" value="<? php // echo esc_attr((isset($data['name']) ? $data['name']  : '')) 
                                                                                          ?>">

    <br>

    <label for="itay_testimonial_email">Testimonial Email</label>
    <input type="text" name="itay_testimonial_email" id="itay_testimonial_email" value="<? php // echo esc_attr((isset($data['email']) ? $data['email']  : '')) 
                                                                                        ?>">

    <br>

    <label for="itay_testimonial_approved">Testimonial Approved</label>
    <input type="checkbox" name="itay_testimonial_approved" id="approved" value="1" <? php // echo esc_attr((isset($data['approved'])  && $data['approved'] == 1  ? 'checked'  : '')) 
                                                                                    ?>>

    <br>

    <label for="itay_testimonial_featured">Testimonial Featured</label>
    <input type="checkbox" name="itay_testimonial_featured" id="featured" value="1" <? php // echo esc_attr((isset($data['featured']) && $data['featured'] == 1 ? 'checked'  : '')) 
                                                                                    ?>>
<? php //
// }
//public function save_meta_box($post_id) {
// if (!isset($_POST['itay_testimonial_options_nonce']))
//   return $post_id;

//   $nonce = $_POST['itay_testimonial_options_nonce'];
//   if (!wp_verify_nonce($nonce, 'itay_testimonial_options')) {
//     return $post_id;
//   }

//   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
//     return $post_id;
//   }

//   if (!current_user_can('edit_post', $post_id)) {
//     return $post_id;
//   }


//   $meta_inputs = array(
//     'name' => sanitize_text_field($_POST['itay_testimonial_author']),
//     'email' => sanitize_text_field($_POST['itay_testimonial_email']),
//     'approved' => isset($_POST['itay_testimonial_approved']) ? 1 : 0,
//     'featured' => isset($_POST['itay_testimonial_featured']) ? 1 : 0
//   );
//   update_post_meta($post_id, 'testimonial_options', $meta_inputs);
// }
?>
  </Code>
-->

#41 -- Create Sortable Custom Columns
<!-- 
  In this lesson, we're going to create custom columns that are actually sortable on how to print our custom data in those custom columns.

  Lets access testimonialController.php, we need an action to edit the default columns of the CPT.
  It's called 'manage_{$post_type}_posts_columns', this is a really particular type of hook, it allows us to use this hook multiple type based on the CPT we want it to execute for.

  The callback function for that action accepts a $columns array which they are available in the default CPT(title, description..);

  At the end of the method we return the $columns but with their new names and their position in the array is the position they'll output on the page. View the code for the creation of the columns below:
  <Code>
    public function register() {
      add_action('manage_testimonial_posts_columns', array($this, 'set_custom_columns'));
    }

    public function set_custom_columns($columns) {
      $title = $columns['title'];
      $date = $columns['date'];
      unset($columns['title'], $columns['date']);

      $columns['name'] = 'Author Name';
      $columns['title'] = $title;
      $columns['approved'] = 'Approved';
      $columns['featured'] = 'Featured';
      $columns['date'] = $date;

      return $columns;
    }
  </Code> 
  Please observe how we empty out the $columns array from data (we store the data inside of it beforehand) and then we return it with out ordering and our new columns. Also note that this is connected to a specific hook called:
  <Code>
    manage_{$post_type_NAME}_posts_columns
  </Code>
  
  Then we want to put our data inside those columns so we hook onto another hook called:
  <Code>
    add_action('manage_testimonial_posts_custom_column', array($this, 'set_custom_columns_data'), 10, 2);
  </Code>

  This action hook passes 2 parameters to the callback method:
  $column and $post_id.

  Since this is using the WP_Loop this passes the current post id which is great, with that knowledge we can access the data saved in the DB of that current post type's testimonial metabox and output it where we need, view the code below for the data fetching and outputting it:
  <Code>
    public function set_custom_columns_data($column, $post_id) {
      $data = get_post_meta($post_id, 'testimonial_options', true);

      // Teachers code, more explicit and offers more configuration.
      $name = isset($data['name']) ? $data['name'] : '';
      $email = isset($data['email']) ? $data['email'] : '';
      $approved = isset($data['approved']) && $data['approved'] === 1 ? 'Yes' : 'No';
      $featured = isset($data['featured']) && $data['featured'] === 1 ? 'Yes' : 'No';

      switch ($column) {
        case 'name':
          echo '<strong>' . $name . '</strong><br><a href="mailto:' . $email . '">' . $email . '</a>';
          break;

        case 'approved':
          echo $approved;
          break;

        case 'featured':
          echo $featured;
          break;
      }
    }
  </Code>
  In this code we get the data from the db's post_meta table where the post_meta_id is $post_id (the arg passed from the hook) and then we perform some checking and for each iteration of the WP loop we output the data.

  Each iteration of the WP loop here is each column, so we simply need to perform a check if we're on the column we want and then echo out the data we wish to be output there!
-->


#42 -- Custom Settings in CPT
<!-- 
  In this lesson, we'll learn how to create a small settings page in the testimonial CPT to list the 2 shortcodes that we'll need in order to allow the users to use the testimonial.
  One is related to the custom form.
  2nd form is related to the slideshow with the list of all the featured testimonials the user can pick.

  Lets use the settings api to implement it.
  We create an instance of the settings api and then continue to create the shortcode method inside the testimonialController.php.

  When trying to create the page for the settings inside the shortcode method we need an array of arguments, that array of arguments consists of a parent_slug (because it's a submenu page).

  Whenever we use this method and try to insert a sub page on an existing page that WP already generated we use the slug that WP gives us, for example in this case we use :
    <Code>
      'parent_slug' => 'edit.php?post_type=testimonial'
    </Code>

  This way the settings api knows exactly where we want to output the settings fields but here we want to use the settings api firstly to create the subpage that'll be located under Testimonials dashboard admin page.

  Then we do the regular stuff of creating the callbacks file for the testimonials and referencing the callback method of the generation of the html of the testimonials shortcode subpage to the templates folder and the testimonial.php file.

  We can do some specific settings right inside the CPT because the CPT has an admin page, so we basically add a submenu to it which'll be the settings of it.

-->

#43 -- Custom Settings in CPT
<!-- 
  In this lesson, we'll learn how to generate a shortocde to allow the user to print a form to submit a testimonial.

  Inside the register method we can use another hook from WP to generate the shortcode, it's called add_shortcode();
  The 1st arg is what a user has to write in order to print the shortcode.

  Wow in this lesson I learned a bunch of things!
  Basically a shortcode is a snippet an admin of the website can insert into the post's description wrapped in bracket and that'll trigger the output of html on the front-end that's associated with that specific shortcode.

  Also I learned how to enqueue JS for a specific front-end page.
  It needs to be output in the .php file of that specific page, so it'd be rendered only on that page, it's really simple actually.

  I also learned how to enqeueu specific css files, it's really beautiful.

  <Code>
    public function testimonial_form() {
      // Here instead of writing html here we can create a new file and require it once here and output it in a clean way using ob_Start and ob_clean_End.
      // This'll tell php to read whatever we're gonna write but don't  print it directly in this page, wait for the code to tell you how to handle this page.
      // Whenever we need to print html that needs to contain php execution, it's best to use ob_start and ob_get_clean.
      ob_start();

      require_once("$this->plugin_path/templates/contact-form.php");
      // echo "<script src=\"$this->plugin_url/src/user/js/form.js\"";

      wp_enqueue_script('formJS', $this->plugin_url . '/build/form.js', array(), 1.0, true);
      wp_enqueue_style('formSTYLES', $this->plugin_url . 'build/userstyle.css');

      return ob_get_clean();
    }
  </Code>
-->

#45 -- Quick SCSS and JS form styling
<!-- 
  In this lesson, we're going to style our form and give it js functionalities.
-->

#46 -- JS Form Validation in ES6
<!-- 
  In this lesson, we'll complete the js part of the form submission in the testimonial section.
  Lets firstly reset the form messages and then validate them.
-->

#47 -- JS ES6 Fetch Request to WP_Ajax
<!-- 
  In this lesson we'll send the form submission to the admin-ajax.php file to handle the ajax request.
  

-->