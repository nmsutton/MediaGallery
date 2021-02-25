# MediaGallery
web based media gallery

# Accessing media on server
On Linux any folder that will have media provided throught the webserver needs to be in the "www-data" group [1](https://askubuntu.com/questions/688538/how-to-allow-apache-to-access-another-directory-ouside-html-www). A way to put the folder in that group is:
$ sudo chgrp -R www-data <target_folder>
where <target_folder> is the folder of interest.