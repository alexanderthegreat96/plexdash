<?php
$servername = "[SERVERNAME]"; // server title
$home_www_addr = "http:/SERVER.COM"; //your domain name without  "/"
$server_address = "http://plex.SERVERNAME.COM/"; //plex server address
$plex_requests_addr = "http://pr.SERVERNAME.COM"; // plex requests adress , youj may use ports as well
$plex_recently_addr_movies = "$home_www_addr/plex_dash/plex_db/index.php?item=1&type=library&filter=recentlyAdded";
$plex_recently_addr_music = "$home_www_addr/plex_dash/plex_db/index.php?item=3&type=library&filter=recentlyAdded";
$plexpy_addr = "http://plexpy.servername.com"; //plexpy adress , you mayh use ports as well
$plexdb_addr = "$home_www_addr/plex_dash/plex_db/"; //dont change this
$plex_description = "Over 500 movies, 20 TV Shows and plenty of music(147 artists).";
$user_mail = "mail@gmail.com"; //your mail
$copyright = "<center><span class='copyright'>Powered By <a href='https://forums.plex.tv/discussion/223291/rel-php-plex-dash-v1-7-plex-media-server-landing-page' target='_blank'/>PlexDash v1.7</a> - &copy Alexander D.</span></center>";
//server status 

//if your server is hosted on
//the same machine leave everything as is
//if not replace "document.domain" with 'plex.server.com' or 
//with your server ip
//add '' as well 
$server_ip = "'192.168.1.332'"; //example: "'plex.servername.com'" or "'192.168.2.554'"
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

?>