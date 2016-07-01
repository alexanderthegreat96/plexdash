<?php
//configuration
include("inc/dash_config.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="plexlanding.ico" />`
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        body.offline #link-bar {
            display:none;
        }

        body.online  #link-bar{
            display:block;
        }
    </style>
    <script src="assets/js/ping.js"></script>
    <script type='text/javascript'>
        HTMLElement.prototype.hasClass = function (className) {
            if (this.classList) {
                return this.classList.contains(className);
            } else {
                return (-1 < this.className.indexOf(className));
            }
        };

        HTMLElement.prototype.addClass = function (className) {
            if (this.classList) {
                this.classList.add(className);
            } else if (!this.hasClass(className)) {
                var classes = this.className.split(" ");
                classes.push(className);
                this.className = classes.join(" ");
            }
            return this;
        };

        HTMLElement.prototype.removeClass = function (className) {
            if (this.classList) {
                this.classList.remove(className);
            } else {
                var classes = this.className.split(" ");
                classes.splice(classes.indexOf(className), 1);
                this.className = classes.join(" ");
            }
            return this;
        };

        function checkServer() {
            var p = new Ping();
            var server = document.domain //plex server 
            var timeout = 4000; //Milliseconds
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
		
    </script>


    <title><?php echo $servername;?> - Dashboard</title>
    <style type="text/css">
.copyright
{
  color: white;
  font-size:13px;
}
    </style>	

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Fonts from Google Fonts -->
	<link href='//fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
    
  
  </head>

  <body onload="checkServer()" class="offline">
		<div id="headerwrap">
        <div class="container">
        
            <div class="row">
                <div class="col-lg-6">
                    <h1><br/>
                    <center><?php echo $servername;?> Status:</h1></center>
                    <center><h4 id="server-status-msg"><img src="assets/img/puff.svg">   Checking...</h4></center><br/>
                    <br/>
                    <br/>
                    <form class="form-inline" role="form">
                      <div class="form-group">
                        
                      </div>
                                    
                </div><!-- /col-lg-6 -->
                <div class="col-lg-6">
                    <img id="server-status-img" class="img-responsive" src="assets/img/ipad-hand.png" alt="">
                </div><!-- /col-lg-6 -->
                
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /headerwrap -->
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          
          </button>
          <a href="<?php echo $server_address;?>"/>
          <a class="navbar-brand" href="<?php echo $home_www_addr;?>"><b><?php echo $servername;?></b></a>
        </div>
        
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container" id="link-bar">
		<div class="row mt centered">
			<div class="col-lg-6 col-lg-offset-3">
				
				
			</div>
		</div><!-- /row -->
		
		<div class="row mt centered">
        <?php include "inc/recent_movies.php";?>
			<?php include("inc/get_recently_added.php");?> <br/>
			<div class="col-lg-4">
				<a href="<?php echo $server_address;?>" target="_blank">
				<img src="assets/img/s01.png" width="180" alt="">
				<h4>Access <?php echo $servername;?> here.</h4>
				<p><?php echo $plex_description;?><p>
					</a>
			</div><!--/col-lg-4 -->

			<div class="col-lg-4">
				<a href="<?php echo $plex_requests_addr;?>" target="_blank">
				<img src="assets/img/s02.png" width="180" alt="">
				<h4>Request</h4>
				<p>Want to watch a Movie or TV Show but it's not currently on <?php echo $servername;?>? Request it here!</p>
</a>
			</div><!--/col-lg-4 -->

			<div class="col-lg-4">
				
				<img src="assets/img/s03.png" width="180" alt="">
				<h4>New - <a href="<?php echo $plex_recently_addr_music;?>" target="_blank">Music</a> | <a href="<?php echo $plex_recently_addr_movies;?>" target="_blank">Movies</a></h4>
				<p>See what has been recently added to <?php echo $servername;?> without having to log in.</p>
</a>
			</div><!--/col-lg-4 -->
						<div class="col-lg-4">
				<a href="<?php echo $plexpy_addr;?>" target="_blank">
				<img src="assets/img/s04.png" width="180" alt="">
				<h4>Monitoring</h4>
				<p>Monitor all ongoing and outgoing traffic on <?php echo $servername;?> using this tool.</p>
</a>
			</div><!--/col-lg-4 -->
			<div class="col-lg-4">
				<a href="<?php echo $plexdb_addr;?>" target="_blank">
				<img src="assets/img/s05.png" width="180" alt="">
				<h4>Media Library</h4>
				<p>Check all the available media on <?php echo $servername;?> without having to login.</p>
</a>
			</div><!--/col-lg-4 -->
			<div class="col-lg-4">
				<a href="mailto:<?php echo $user_mail;?>" target="_top">
				<img src="assets/img/s06.png" width="180" alt="">
				<h4>Request Access</h4>
				<p>Send me an email with your plex username and daily use at <a href="mailto:<?php echo $user_mail;?>"/><?php echo $user_mail;?></a></p>
</a>
			</div><!--/col-lg-4 -->
				
		</div><!-- /row -->
		
	</div><!-- /container -->
	
	<p>
	<p align="center" class="copyright"><?php echo $copyright;?></p>
	
  </body>
</html>
