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
  
-->