# plexdash
Hello. A while ago I was searching for a perfect plex landing page. I hardly found one ,but it was plain HTML so I decided to improve it. And I added scripts from users and even wrote three of my own and now I have decided to release it to the public.
This work is based on:
PlexRedirect : https://github.com/ITRav4/PlexRedirect
PLPP - Plex Library Presenter https://forums.plex.tv/discussion/218740/beta-release-php-library-presenter-for-plex-plpp-v0-8-beta
PlexPY (mostly the API): https://github.com/drzoidberg33/plexpy
PlexFeed v1.4 forums.plex.tv/discussion/221995/rel-plexfeed-whats-most-recent-php-script-v1-4#latest
Features:
-Beautiful Interface
-Easy Customization
-Easy Installation
[UPDATE]: Future release will not be based on plexpy api ,but rather on the plex.tv api. This way it will be more acurate and easier for people without a plexpy installation to use it . 
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
open the following :
inc/config.php and provide the info
$apikey = "YOUR_PLEXPY_API_KEY";
$plexpy_url = "YOUR_PLEX_PY_URL"; //you may use ports as well ex: 192.168.1.33:8181 or whatever port you have it running on
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
index.php
search for:
function checkServer() {
var p = new Ping();
var server = document.domain // plex url 
var timeout = 2000; //Milliseconds (set this to 3-4000 in case you get wrong statuses)
var body = document.getElementsByTagName("body")[0];
p.ping(server+":32400", function(data) { //plex port
var serverMsg = document.getElementById( "server-status-msg" );
var serverImg = document.getElementById( "server-status-img" );
if (data < 1000){
serverMsg.innerHTML ='Up and reachable';
serverImg.src = "assets/img/ipad-hand-on.png";
body.addClass('online').removeClass("offline");
}else{
serverMsg.innerHTML = 'Down and unreachable';
serverImg.src = "assets/img/ipad-hand-off.png";
}
}, timeout);
}
-in case you have plex mapped eternaly under a domain replace document.domain with "plex.mysite.com" (add the quotes as well),scroll down to plex port,there is a comment in front of it,
and replace 32400 with 80 
-in case plex is eternaly mapped under a port,replace document.domain with "mysite.com"(add the quotes as well),scroll down to plex port,there is a comment in front of it,
and replace 32400 with your own custom port set for external access
-in case your place is on the same machine as the site , leave everything as it is.
that's it. enjoy!
alexander d.
Big kudos to :
drzoidberg33
mlocher75
ITRay4
