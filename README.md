ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

<h2>1/ Installation</h2>

To install the Project, you must clone the repository into your web directory (www/).

Install it with Composer using the "composer install" command.

Configure the database in the "app/config/config.yml" file.

Create the database with the command "php bin/console doctrine:database:create".

Update the database with the command "php bin/console doctrine:schema:update --force".

To install a dataset use the command "php bin/console doctrine:fixtures:load".

<h2>Custom Commands</h2>

"php bin/console database:initialization" => Perform the following doctrine commands in order: Drop, Create, Schema Update, Load Fixtures.
