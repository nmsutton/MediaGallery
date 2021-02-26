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

# Password security
On your local system rename dbaccess_example.php to dbaccess.php and enter your username and password for database access used to access the mediagallery database. Note: dbaccess.php is in the gitignore file to avoid password credentials being uploaded to the source control website.

Individual folders can be password protected using the method described [here](https://electrictoolbox.com/apache-password-protect-directory/). In breif:

apache2.conf

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