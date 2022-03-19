#!/bin/bash

#xterm -e "echo \"input: $1\" && read -p 'press enter to close' user";

command="echo \"$1\" | sed \"s/subform('//g\"";
url=$(eval $command);
command="echo \"$url\" | sed \"s/')//g\"";
url=$(eval $command);

/usr/bin/firefox -private http://localhost/general/mediagallery/tags.php?url="$url"