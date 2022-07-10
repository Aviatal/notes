
The repo contains website using MySql database. The site allows to menage our notes (add new notes, browser our notes, delete our notes etc.). The website was developed with instructor on PHP course.

# Website instalation
To run our application on our PC, we have to install WWW server (because site is using php and database, which require this). Exemplary and free webserver is xampp. When we will install it, we can start our app. We download xampp from official webpage (https://www.apachefriends.org/pl/download.html). We should dowland appropriate version for our operating system. Installation process is very simple. Installer bringing us through the whole process. After installation, we have to drop files of our webpage (all files from repo, except for notes.sql) to "htdocs" directory (in xampp directory), which is responsible for run our websites. We can to configure v-host of xampp(after xampp instalation, we can see torturial on HOW-TO guides on the our webserver site: localhost) to run our site in another directory. Now, we need to run xampp control panel and start apache and MySql modules.

# Database instalation
Our application has already worked. Now we have to import our database, to enable ourselfs menaging our notes. To do this, we should click on "admin" in MySql module in xampp control panel. It show our database server. On side menu we choose "new" and write our database ("notes"). Now we choose "import", upload our file in right place and on the bottom of site, click execute. 

# User adding
To menage our database we need to add right-name user. We can choose it in the file config.php. We need to change value in array of "user" index. We can also use default user, to do that we have to add user of name "user_notes". To add user we need to open our database server and go to "user account" (in top menu) and "add user account". We choose user name (if we haven't change config.php file, name have to be "user_notes") and chose host name to localhost. If we've decide to add user with our name, we can choose any password, and then copy it to confi.php file. If we've decide to use "user_notes" we have to choose password:  _ASgg4pQpW]!dXN. We have to also bring our user under privileges. (required is all file from Data section)
# Technologies
PHP 8.1.6 
HTML and CSS
