
<img src="/umami-api.png" height="200px" align="right"/>

# umami-api
REST API for cooks made with API Platform 


## Install

Api running with PHP 8, Symfony 5.3.

    Clone the project
    
    $ git clone
    $ cd umami-api
    
    Install all dependencies
    
    $ composer install
    $ npm install
    
    Create and migrate database
    
    $ php bin/console d:d:c
    $ php bin/console d:m:m
    
    Load fixtures :
    $ php app/console doctrine:fixtures:load
    
    Start server : 
    $ symfony serve
    
    Run test with this command :
    $ php bin/phpunit

You can now go to your https://localhost
If you want to see the API and try it got to the /api route.
You can register a user, navigate through the admin panel and load fixtures. 
