This work is based on:

PlexRedirect : https://github.com/ITRav4/PlexRedirect

PLPP - Plex Library Presenter https://forums.plex.tv/discussion/218740/beta-release-php-library-presenter-for-plex-plpp-v0-8-beta

PlexPY (mostly the API): https://github.com/drzoidberg33/plexpy

PlexFeed v1.4 forums.plex.tv/discussion/221995/rel-plexfeed-whats-most-recent-php-script-v1-4#latest

Features:

-Beautiful Interface

-Easy Customization

-Easy Installation

Requirements:

-webserver to run php

-plexpy - https://github.com/drzoidberg33/plexpy

-phpgd and curl enabled on your PHP.ini

Installation:

Grab PlexPY and install it(link above)

chmod 777 /inc

chmod 777 /plex_db/config

chmod 777 /plex_db/cache

grab a plexpy api . Go to Settings > Access Control > check "enable API" and click "Generate". Copy The API to clipboard.

grab a tvdb api

open the following :

inc/config.php and provide the info
$apikey = "YOUR_PLEXPY_API_KEY";

$plexpy_url = "YOUR_PLEX_PY_URL"; //you may use ports as well ex: 192.168.1.33:8181 or whatever port you have it running on

$section_id_movies = ""; //section id. open up a movie in plex>get info>view xml find librarySectionID

$section_id_shows = "2"; //plex section id for tv shows may be 1.2.3.4.5.6 tec

$tvdb_api = "TV DB API";

inc/dash_config.php and provide the info

$servername = "[SERVERNAME]"; // server title

$home_www_addr = "http:/SERVER.COM"; //your domain name without "/"

$server_address = "http://plex.SERVERNAME.COM/"; //plex server address

$plex_requests_addr = "http://pr.SERVERNAME.COM"; // plex requests adress , youj may use ports as well

$plex_recently_addr_movies = "$home_www_addr/plex_dash/plex_db/index.php?item=1&type=library&filter=recentlyAdded";

$plex_recently_addr_music = "$home_www_addr/plex_dash/plex_db/index.php?item=3&type=library&filter=recentlyAdded";

$plexpy_addr = "http://plexpy.servername.com"; //plexpy adress , you mayh use ports as well

$plexdb_addr = "$home_www_addr/plex_dash/plex_db/"; //dont change this

$plex_description = "Over 500 movies, 20 TV Shows and plenty of music(147 artists).";

$user_mail = "mail@gmail.com"; //your mail

$server_ip = "'192.168.1.58'"; //example: "'plex.servername.com'" or "'192.168.2.554'" 

//if plex is mapped to a specific domain ,user port 80

//if not, just specify your port set up for external access

$server_port = "32400"; //default plex port: 32400

//enable recent movies? - 5 Recent Movies

//SET TO TRUE OR FALSE

$enable_movies = TRUE;

//enable recent tv shows? - 5 Recent TV Shows

//SET TO TRUE OR FALSE

$enable_tvshows = TRUE;

//enable recently added? - Most Recent Content

//SET TO TRUE OR FALSE

$enable_added = TRUE;

plex_db/config/usersettings.json and provide info

"title": "[servername] - Media Library", //replace [servernname] with your servername

"admin_password": "yourpasswordhere", //just pick a password or leave it this way. in case you decide to edit the password,it will be required by plex_db/settings_deny.php. just in case you are too lazy to manually edit settings yourself 

plex_db/config/plexserver.json and provide info

"useSSL": 0,

"server": "SERVERIP", //plex server IP 

"scheme": "http",

"domain": "SERVERIP",// plex server ip OR domain

"port": 32400, //plex server port 

"username": "plexuser", //plex.tv username

"password": "plexpass" //plex.tv password

plex_db/config/general.json and provide the info

"script_name": "[SERVERNAME] - Media Library", //replace [] with your servername