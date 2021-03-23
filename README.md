# MediaGallery
web based media gallery

# Accessing media on server
On Linux, if Apache2 webserver is used (and potentially other webservers), any folder that will have media provided throught the webserver needs to have executable access in it [[1]](https://askubuntu.com/questions/688538/how-to-allow-apache-to-access-another-directory-ouside-html-www). This allows access through the web browser not to be blocked. Possibly these access settings need to be applied to a few levels of parent directories of the folder of interest, based on the author's personal experience of testing the settings.

A way to create that is:

`$ sudo chmod +x <target_folder>`

where \<target_folder\> is the folder of interest.

Possibly read-write access to all users in the \<target-folder\> is recommended too.

For example:

`$ sudo chmod 777 <target_folder>`

If the \<target_folder\> is outside of the webserver directory, a softlink should be made to it in the webserver directory. This site can then set $origdir = '\<target_folder\>' to access the external folders.

In practice, it has been found that some parent directories to the \<target_folder\> need to be made executable and have read and write access given to them for the web server to allow permission to access the \<target_folder\> through a web browser. This may not be needed on some systems.

# Enabling semi-automated icon generation

At least with the Apache2 webserver on Linux, for php to create an icon, based on first-hand experience it was found that a folder must be in the "www-data" group owned by the "www-data" user [reference](https://stackoverflow.com/questions/5246114/php-mkdir-permission-denied-problem). This allows the webserver access to create a icon folder. Also it was found the the permissions set as 777 in both the target directory and its 1st or 2cnd level parent directories enabled the created directory to be at an access level that allowed php to copy the image into the icon directory. Perhaps less access then 777 could be used, but 777 was found to work.

Example of changing the user and group:

`chown -R www-data:www-data /path/to/webserver/www`

# Password security
On your local system rename dbaccess_example.php to dbaccess.php and enter your username and password for database access used to access the mediagallery database. Note: dbaccess.php is in the gitignore file to avoid password credentials being uploaded to the source control website.

Individual folders can be password protected using the method described [here](https://electrictoolbox.com/apache-password-protect-directory/). In breif:

apache2.conf (which may be located in /etc/apache2/apache2.conf)

`<Directory [target_folder]>`

`    AuthUserFile [/path/to/.htpasswd]`

`    AuthName "Restricted Access"`

`    AuthType Basic`

`    require user [username]`

`</Directory>`

create password file:

Navigate to folder where file should be located. 

`htpasswd -c .htpasswd [username]`

This will create a file named .htpasswd that stores the password.

Then run `sudo service apache2 restart` to apply the changes.

# Setting up database

This creates a password for using the mediagallery site stored in mysql for security.

run the mysql script db.sql to create the mediagallery database in mysql.
Then edit create_pass.sql to add the password you want.
Run create_pass.sql to enter the password into the database.