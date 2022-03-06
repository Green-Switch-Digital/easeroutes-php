# easeroutes-php
Simplified PHP - Routing Library

#installation
1.  clone the repository (Download it) to your php project folder
2.  Place the htaccess on your root directory for your php project
3.  You're done and ready for implementation

#Implementation
1.  The .htaccess automatically points your project to index.php where all your routing logic will be place
2.  require the Routes.php file located in easeroutes/src/Routes.php
3.  If you are using composer, make sure to add the project in your composer.json file as shown below
    {
    "autoload": {
        "psr-4": {
            "EaseRoutes\\": "location-to-this-folder/easeroutes/src"
        }
    }
}
4.  run dump-autoload
5.  You are ready to Code

#Code
"In the index.php"
---------------------------------------------------
---------------WHEN USING COMPOSER ----------------
    require "vendor/autoload.php";

    use EaseRoutes\Routes;

    $router         = new Routes();
    
    
    $router->levels = 2;//start trimming url from level 2
    $router->rootDir="";/*when deploying to production server, make sure to comment this section above*/
    
    $router->get("","views/homepage.php");
    $router->get("/admin","views/homepage.php");
    $router->get("/products","views/products.php");
    $router->get("/products/:productID/delete","views/product.php");
    
    //dont forget to include this page incase the above routes did not work
    $router->load404("views/404.php");
    
    
    -------------------------------------------------------------
    ----------------------- PURE PHP-----------------------------
    require "easeroutes/src/Routes.php";
    $router         = new Routes();
    
    $router->levels = 2;//start trimming url from level 2
    $router->rootDir="";/*when deploying to production server, make sure to comment this section above*/
    
    $router->get("","views/homepage.php");
    $router->get("/admin","views/homepage.php");
    $router->get("/products","views/products.php");
    $router->get("/products/:productID/delete","views/product.php");
    
    //dont forget to include this page incase the above routes did not work
    $router->load404("views/404.php");
    
    
    #METHODS DEFINITION
    Routes::get(route, pagetoload) => bool
    - a route definition with get properties. 
    a. route : a given url can be /products, /login, /admin. Always make sure this url begins with a forward slash
    b. pagetoload : a physical file to be loaded relative to the root directory
    
    Routes::post(route,pagetoload) => bool
    - same as get but with post
    
    Routes::load404("path/to/404page")
    - if either of the given routes are not suplied in the url, then this page will help you relocate the user to this 
    default not found route. can be an html or php. To access the right error, use $errorCode and $message to display 
    the message on the UI
    
    Routes::levels (default = 0)
    - number of directories to skip to reach the real root directory. For example, you might have your project
      located 3 or 5 levels from the root directory in your development folder eg. localhost/projects/socialmedia/
      this example has 2 levels to the root directory, projects and socialmedia, so for this library to work properly
      in such scenarios, declare the levels property to the number of levels to skip in your directory
      
    Routes::rootDir  (default = "")
    - Given the example in levels, you also need to tell the library where your project is located if you have a multi
      level project. eg the above will be Routes::rootDir = "projects/socialmedia/". This will help in identifying 
      proper directories to render your php files.
    
    
    
