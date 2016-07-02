
<style type="text/css">
.movie_table {
  background-color: #252525;
  margin: 50px auto;
  text-align: center;
  width: 900px;
  font-family: 'Lato', sans-serif;
}
</style>
<center><h4>Latest 5 Movies</h4>
<hr class="dash" width="800"/>
<table class = "movie_table" style="font-size: 14px;color: white;" border="0">
<tr>
<?php
include_once("config.php");
$command = "get_recently_added"; //command used for parsing json - DO NOT CHANGE OR ELSE THE CODE DIES
$count = "10"; //ammount of recenly added results  - YOU DONT HAVE TO CHANGE THIS

$ip = "$plexpy_url/api/v2?apikey=$apikey&cmd=$command&section_id=$section_id_movies&count=$count";
include_once("imdb_class.php");
$grab = file_get_contents($ip);
$jay = json_decode($grab,true);
$i = 0;
foreach($jay["response"]["data"]["recently_added"] as $items)
{
  $output_year = $items['year'] ; //grab year
  $output_tlt = $items['title']; //grab title(ussually for music)
  $output_type = $items['media_type']; //grab media type so we can display only movies
  $rating_key = $items['rating_key'];
 

  $enc_key =  base64_encode($rating_key);
  if($output_type == "movie")
  {
    //grab imdb poster
   $oIMDB = new IMDB($output_tlt);
  if ($oIMDB->isReady) {
   $poster = $oIMDB->getPoster("big",true);//grab imdb poster
  
  }//end imdb if


//end check
?>
<th><a href="grab_info.php?item=<?php echo $enc_key;?>"/><img src="inc/<?php echo $poster;?>" width="200" height="300"/></a></th>
<?php

 if (++$i == 5) break;
}
}//end foreach
?>
</tr>
<tr>
<?php
$i = 0;
foreach($jay["response"]["data"]["recently_added"] as $items)
{
  $output_year = $items['year'] ; //grab year
  $output_tlt = $items['title']; //grab title(ussually for music)
  $output_type = $items['media_type']; //grab media type so we can display only movies
  $rating_key = $items['rating_key'];
  $enc_key =  base64_encode($rating_key);
   $oIMDB = new IMDB($output_tlt);
  if ($oIMDB->isReady) {
$rating = $oIMDB->getRating();//grab rating from imdb
  }
  if($output_type == "movie")
  {
    //grab imdb poster
  
echo "<td><center><a href='grab_info.php?item=".$enc_key."'>". $output_tlt. "</a>(".$output_year.")<br/><span style='color: green; font-size:14px;'>".$rating."</span></center></td>";

//end check
 if (++$i == 5) break;
}
}
?>
</table>
