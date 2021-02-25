# MediaGallery
web based media gallery

# Accessing media on server
On Linux, if Apache2 webserver is used (and potentially other webservers), any folder that will have media provided throught the webserver needs to have executable access in it [[1]](https://askubuntu.com/questions/688538/how-to-allow-apache-to-access-another-directory-ouside-html-www). This allows access through the web browser not to be blocked.

A way to create that is:

`$ sudo chmod +x <target_folder>`

where \<target_folder\> is the folder of interest.

Possibly read-write access to all users in the \<target-folder\> is recommended too.

For example:

`$ sudo chmod 777 <target_folder>`