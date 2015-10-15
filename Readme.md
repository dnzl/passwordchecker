# Description
The script in the file **check.php** checks if the passwords in the table "passwords" are valid according to the rules in the file **config.yml** and marks them as valid in the db. It can be run in terminal or browser.

### Setup
The **config.yml** contains the database conection data as well as the rules to be used to validate the passwords. It includes the rules required by the task.
Afer setting your database configuration, you can run the script **check.php**

### Verbose mode
Is possible to run the script in verbose mode passing v=true by GET or using the option -v
* `http://localhost/test/check.php?v=true`
* `php check.php -v`