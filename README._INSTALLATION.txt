Installation:
chmod 777 /inc
chmod 777 /plex_db/config
chmod 777 /plex_db/cache

open the following : inc/config.php and provide the info
		     inc/dash_config.php and provide the info
		     plex_db/config/usersettings.json and provide info
		     plex_db/config/plexserver.json and provide info
                     plex_db/config/general.json and provide the info
open up index.php

search for 
 function checkServer() {
            var p = new Ping();
            var server = document.domain // plex url 
            var timeout = 2000; //Milliseconds
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
