
<style type="text/css">
.movie_table {
  background-color: #252525;
  margin: 50px auto;
  text-align: center;
  width: 900px;
  font-family: 'Lato', sans-serif;
}
.table_main {
  width: 100%;
  max-width: 750px;
  margin: 50px auto;
  background: #252525;
  text-align: center;
}
.table_shows {
  width: 100%;
  max-width: 750px;
  border: 1px solid black;
  border-collapse: collapse;
  background: #252525;
  text-align: center;
}
.main_th_show {
  background:  #252525;
  border: 1px solid steelblue;
  border-collapse: collapse-all;
  padding: 4px;
  font-weight: lighter;
  text-shadow: 0 1px 0 #38678f;
  color: white;
  text-align:center;
  transition: all 0.2s;
}
.main_tr_show {

}
.main_td_show {

  padding: 4px;
  transition: all 0.2s;
  font-size: 14px;
  border: 1px solid black;
  border-collapse: collapse-all;
}
.main_tr_show:hover {
  background: #ccc;
  z-index: ;
}




.heavyTable {
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  animation: float 5s infinite;
}
.main {
  max-width: 600px;;
  padding: 10px;
  margin: auto;
}
.content {
  color: white;
  text-align: center;
}
.content pre,
.content h2 {
  text-align: left;
}
h1 {
  text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  text-align: center;
}
  a.one:link {color:steelblue;}
  a.one:visited {color:steelblue;}
  a.one:hover {color:#ffcc00;}
hr.dash {
  border-top: 1px dashed #8c8b8b;
}
</style>

<center><h4>Latest TV Shows & Episodes</h4>
<hr class="dash" width="800"/>
<tr>
<?php
include_once("config.php");
include_once("tvdb.cls.php");
include_once("imdb_class.php");
$command = "get_recently_added"; //command used for parsing json - DO NOT CHANGE OR ELSE THE CODE DIES
$count = "5"; //ammount of recenly added results  - YOU DONT HAVE TO CHANGE THIS

$ip = "$plexpy_url/api/v2?apikey=$apikey&cmd=$command&section_id=$section_id_shows&count=$count";
include_once("imdb_class.php");
$grab = file_get_contents($ip);
$jay = json_decode($grab,true);
$i = 0;
?>
<center>
<table align="center" class="table_shows" border="1px">

  <tr class="main_tr_show">
  <th class="main_th_show">Poster
  </th>


  <th class="main_th_show">TV Show
  </th>



  <th class="main_th_show">Episode
  </th>
    <th class="main_th_show">IMDB Rating
  </th>
  </tr>
  <?php
foreach($jay["response"]["data"]["recently_added"] as $items)
{
  $output_year = $items['year'] ; //grab year
  $output_tlt = $items['grandparent_title']; //grab title(ussually for music)
  $rating_key = $items['rating_key'];
  $output_title = $items["title"];
  $enc_key =  base64_encode($rating_key);
  //grab imdb rationg
  //grab imdb poster
   $oIMDB = new IMDB($output_title);
   if ($oIMDB->isReady) {
   $rating = $oIMDB->getRating();//grab imdb rating
  }
  //initiate tvdb parser class
$tvdb = new TvDb("http://thetvdb.com", $tvdb_api);
$data_array = $tvdb->getSeries($output_tlt);

//grab the necessary information
foreach ($data_array as $data_arr)
{
  //grab series_id so we can get posters and actors
  $series_id = $data_arr->Series->seriesid;
  $title = $data_arr->Series->SeriesName;
}
//grab poster
$poster_grab = $tvdb->getPoster($series_id);
?>
<td class='main_td_show'><a href="show_info.php?title=<?php echo $title; ?>"/><img src="<?php echo $poster_grab;?>" width="40" height="70"/></a></td>
<td class='main_td_show'><a href="show_info.php?title=<?php echo $title; ?>"/><?php echo $title;?></a></td>
<?php
echo "<td class='main_td_show'><a href='show_info.php?item=".$enc_key."'>".$output_title."</td>";
echo "<td class='main_td_show'>";
if ($rating == "n/A")
{
  echo "Not available";
}
else {
echo $rating;
}
echo "</center></td></tr>";

//end check

}

?>

</table>
</center>
