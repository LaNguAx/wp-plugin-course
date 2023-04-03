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