# MediaGallery
web based media gallery

# Accessing media on server
On Linux any folder that will have media provided throught the webserver needs to have executable access in ot [[1]](https://askubuntu.com/questions/688538/how-to-allow-apache-to-access-another-directory-ouside-html-www). A way to create that is:
$ sudo chmod +x <target_folder>
where <target_folder> is the folder of interest.
Possibly read-write access to all users in the <target-folder> is recommended too.
$ sudo chmod 777 <target_folder>