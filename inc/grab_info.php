<html>
<head>

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
if(!isset($_GET["item"]))
{
	echo "No rating key set or raing key is incorect!";
}
else
{

include_once("imdb_class.php");
include_once("config.php");
$command = "get_metadata"; //command used for parsing json - DO NOT CHANGE OR ELSE THE CODE DIES
$rating_key = base64_decode($_GET["item"]);
$ip = "$plexpy_url/api/v2?apikey=$apikey&cmd=$command&rating_key=$rating_key&media_info=true";
$grab = file_get_contents($ip);
$jay = json_decode($grab);
$jay_array = json_decode($grab,true);
//
$title = $jay->response->data->metadata->title;
$year = $jay->response->data->metadata->year;
$actors = $jay->response->data->metadata->actors;
$codec = $jay->response->data->metadata->video_codec;
$format = $jay->response->data->metadata->container;
$summary = $jay->response->data->metadata->summary;
$director = $jay->response->data->metadata->directors;
$writer = $jay->response->data->metadata->writers;
$studio = $jay->response->data->metadata->studio;
$quality = $jay->response->data->metadata->video_resolution;
$tagline = $jay->response->data->metadata->tagline;
?>
<title><?php echo "Movie Information: ".$title;?></title>
<body>
<center><a href="index.php"/>Back Home</a></center>
<center>
<div class='main'>

    <table class="heavyTable" with="750px">
			<thead>
				<tr>
					<th>Poster</th>
					<th>Movie Information</th>

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
    echo "<center><img src='inc/" . $oIMDB->getPoster('big', true)."' widht='300' height='500'></center>";
} else {
    echo '<p>Movie not found!</p>';
}
?></td>
    <td><?php
echo "<b>Title: </b>". $title . "<br/>";
echo "<b>Year: </b>". $year . "<br/>";
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
echo '<b>Tagline: </b><i>"'. $tagline . '"</i><br/>';
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
echo "<b>Studio: </b>". $studio . "<br/>";
echo "<b>Quality: </b>". $quality . "<br/>";
echo "<b>Format: </b>". $format . "<br/>";
echo "<b>Codec: </b>". $codec . "<br/>";
}
?></td>
  </tr>
</table>
</div>
<p align="center" class="copyright" style="color:blue;"><?php echo $copyright;?></p></center>

</body>
</html>
