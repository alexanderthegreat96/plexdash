<html>
<head>
 <?php include_once("dash_config.php");?>
<style type="text/css">
body
{
  box-sizing: border-box;
}
.copyright
{
  color: white;
  font-size:12px;
}
body {
  background: #1a1a1a;
  font-family: "Open Sans", arial;
}
table {
  width: 100%;
  max-width: 750px;
  border-collapse: collapse;
  border: 1px solid #ff6600;
  margin: 50px auto;
  background: white;
}
th {
  background:  #252525;
  height: 54px;
  width: 25%;
  font-weight: lighter;
  text-shadow: 0 1px 0 #38678f;
  color: white;
  border: 1px solid #ff6600;

  transition: all 0.2s;
}
tr {
  border-bottom: 1px solid #cccccc;
}
tr:last-child {
  border-bottom: 0px;
}
td {
  border-right: 1px solid #cccccc;
  padding: 10px;
  transition: all 0.2s;
}
td:last-child {
  border-right: 0px;
}
td.selected {
  background: #d7e4ef;
  z-index: ;
}




.heavyTable {
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  animation: float 5s infinite;
}
.main {
  max-width: 750px;;
  padding: 10px;
  margin: auto;
}
.content {
  color: white;
  text-align: center;
}
.content p,
.content pre,
.content h2 {
  text-align: left;
}


h1 {
  text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  text-align: center;
}
  a:link {color:steelblue;}
  a:active {color:steelblue;}
  a:visited {color:steelblue;}
  a:hover {color:#ffcc00;}
</style>
</head>



<?php
if(!isset($_GET["item"]) && !isset($_GET["title"]))
{
  die("You're not allowed to be here :))");
}  

if(!isset($_GET["item"]) && isset($_GET["title"]))
{
include_once("imdb_class.php");
include_once("config.php");
include("tvdb.cls.php");
$show_name = $_GET["title"];
$tvdb = new TvDb("http://thetvdb.com", $tvdb_api);
$data_array = $tvdb->getSeries($show_name);
//grab the necessary information
foreach ($data_array as $data_arr)
{
  $title = $data_arr->Series->SeriesName;
  //grab series_id so we can get posters and actors
  $series_id = $data_arr->Series->seriesid;
  //grab overview
  $overview = $data_arr->Series->Overview;
  //grab air network
  $network = $data_arr->Series->Network;
  //first aired
  $first_aired = $data_arr->Series->FirstAired;
}
$oIMDB = new IMDB($title);
if ($oIMDB->isReady) {
  //grab imdb rating
   $rating = $oIMDB->getRating();  
   $actors = $oIMDB->getCast();  
   $year = $oIMDB->getYear();  
   $genre = $oIMDB->getGenre();  
   $rel_date = $oIMDB->getReleaseDate();  
} 
//grab poster
$poster_grab =  $tvdb->getPoster($series_id);

?>
<title><?php echo "TV Show Information: ".$title;?></title>
<body>
<center><a href="index.php"/>Back Home</a></center>
<center>
<div class='main'>

    <table class="heavyTable" with="750px">
      <thead>
        <tr>
          <th>Poster</th>
          <th>Show Information:</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          

<?php
//start outputing results
echo "<td><center><img src='" . $poster_grab."' widht='300' height='500'></center></td>";
echo "<td>";
echo "<b>Title: </b>". $title . "<br/>";
echo "<b>Year: </b>". $year . "<br/>";
echo "<b>IMDB Rating: </b>" .$rating."<br/>";
echo "<b>Actors: </b>". $actors . "<br/>";
echo "<b>Genres: </b>". $genre . "<br/>";
echo "<b>Overview:</b> ". $overview. "</br>";
echo "
</td>
  </tr>
</table>
</div>
";

}//end first if
else
{

include_once("imdb_class.php");
include_once("config.php");
include("tvdb.cls.php");
$command = "get_metadata"; //command used for parsing json - DO NOT CHANGE OR ELSE THE CODE DIES
$rating_key = base64_decode($_GET["item"]);
$ip = "$plexpy_url/api/v2?apikey=$apikey&cmd=$command&rating_key=$rating_key&media_info=true";
$grab = file_get_contents($ip);
$jay = json_decode($grab);
$jay_array = json_decode($grab,true);

//put everything together
$title = $jay->response->data->metadata->title;
$parent_title = $jay->response->data->metadata->grandparent_title;
$year = $jay->response->data->metadata->year;
$actors = $jay->response->data->metadata->actors;
$codec = $jay->response->data->metadata->video_codec;
$format = $jay->response->data->metadata->container;
$summary = $jay->response->data->metadata->summary;
$director = $jay->response->data->metadata->directors;
$writer = $jay->response->data->metadata->writers;
$studio = $jay->response->data->metadata->studio;
$quality = $jay->response->data->metadata->video_resolution;


$tvdb = new TvDb("http://thetvdb.com", $tvdb_api);
$data_array = $tvdb->getSeries($parent_title);
//grab the necessary information
foreach ($data_array as $data_arr)
{
  $series_id = $data_arr->Series->seriesid;
  $first_aired = $data_arr->Series->FirstAired;
}
//grab poster
$poster_grab =  $tvdb->getPoster($series_id);
?>
<title><?php echo "Episode Information: ".$title;?></title>
<body>
<center><a href="index.php"/>Back Home</a></center>
<center>
<div class='main'>

    <table class="heavyTable" with="750px">
			<thead>
				<tr>
					<th>Poster</th>
					<th>Episode Information:</th>

				</tr>
			</thead>

			<tbody>
				<tr>
					<td>
  <?php
//grab imdb poster
$oIMDB = new IMDB($title);
if ($oIMDB->isReady) {
   $rating = $oIMDB->getRating();  
} 
echo "<center><img src='" . $poster_grab."' widht='300' height='500'></center>";
?></td>
    <td><?php
echo "<b>Title: </b>". $title . "<br/>";
echo "<b>Airdate: </b>". $first_aired . "<br/>";
echo "<b>IMDB Rating: </b>" .$rating."<br/>";
echo "<b>Genre: </b>";
foreach($jay_array['response']['data']['metadata']['genres'] as $genres)
{
$genre_all = $genres;
$genre = $genre_all;
echo $genre ."&nbsp;";
}
echo"<br/>";
echo "<b>Actors:</b>";
foreach($jay_array['response']['data']['metadata']['actors'] as $actors_all)
{
$actors = $actors_all;
echo $actors .",";
}
echo"<br/>";
echo "<b>Summary: </b>". $summary . "<br/>";
echo "<b>Director(s):</b>";
foreach($jay_array['response']['data']['metadata']['directors'] as $director_all)
{
$director = $director_all;
echo $director ."&nbsp;";
}
echo"<br/>";
echo "<b>Writer(s):</b>";
foreach($jay_array['response']['data']['metadata']['writers'] as $writer_all)
{
$writer = $writer_all;
echo $writer ."&nbsp;";
}
echo"<br/>";
echo "";
echo "<b>Network: </b>". $studio . "<br/>";
echo "<b>Quality: </b>". $quality . "<br/>";
echo "<b>Format: </b>". $format . "<br/>";
echo "<b>Codec: </b>". $codec . "<br/>";
}//end else isset
?></td>
  </tr>
</table>
</div>
<p align="center" class="copyright" style="color:blue;"><?php echo $copyright;?></p></center>

</body>
</html>
