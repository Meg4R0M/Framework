##Follow these instructions to deploy a new project with this framework

You will get a fresh install of this framework with a demo bundle installed. 
This demo bundle contain a simple blog with an administration interface. 
This is a very basic usage but you can start your dev with  it. Have fun =)

* git clone git@github.com:psykoterro/Framework.git Your-Project
* cd Your-Project
* composer install
* create a database
* edit config/config.php to according with your database credentials
* ./vendor/bin/phinx migrate #Inject the schema in your DB
* if you want inject fake data to see blog and administration function launch:
* ./vendor/bin/phinx seed:run
* Enjoy =)

##Links

Administration => YourSite.local/admin

Blog => YourSite.local/blog

--

**NB: You need install php-apcu-bc for production site.**