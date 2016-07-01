
<?php
//PHP PlexPY Api Parser - grab_recently_added
//Author : Alexander D
//Year: 2016
include_once("config.php");
$command = "get_recently_added"; //command used for parsing json - DO NOT CHANGE OR ELSE THE CODE DIES
$count = "10"; //ammount of recenly added results
$ip = "$plexpy_url/api/v2?apikey=$apikey&cmd=$command&count=$count";
include_once("imdb_class.php");
$grab = file_get_contents($ip);
$jay = json_decode($grab,true);
?>
<style type="text/css">
.table_main {
	width: 100%;
	max-width: 750px;
	margin: 50px auto;
	background: #252525;
	text-align: center;
}
.main_th {
	background:  #252525;
	height: 54px;
	width: 25%;
	font-weight: lighter;
	text-shadow: 0 1px 0 #38678f;
	color: white;
	text-align:center;

	transition: all 0.2s;
}
.main_tr {
	
}
tr:last-child {
	border-bottom: 0px;
}
.main_td {
	
	padding: 10px;
	transition: all 0.2s;
}
td:last-child {
	border-right: 0px;
}
.main_tr:hover {
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
<center>
<h4>Most Recent Content</h4>
<hr class="dash" width="700"/>
<table align="center" class="table_main">

  <tr class="main_tr">
  <th class="main_th">Library
  </th>


  <th class="main_th">Item
  </th>



  <th class="main_th">Year
  </th>
    <th class="main_th">IMDB Rating
  </th>
  </tr>
 


<?php

// echo $jay["response"]["data"]["recently_added"][0]['parent_title'];
foreach($jay["response"]["data"]["recently_added"] as $items)
{
	$output_lib =$items['library_name']; //grab library name
	$output_title = "<i>" .$items['parent_title']. "</i>"; //grab parent title
	$output_year = $items['year'] ; //grab year
	$output_tlt = $items['title']; //grab title(ussually for music)
  $output_type = $items['media_type'];
  $rating_key = $items['rating_key'];
  //encrypt rating key for secuityh purposes


  $enc_key =  base64_encode($rating_key);
  echo ' <tr class="main_tr">';
echo  "<td class='main_td'>". $output_lib ."</td>";
echo "<td class='main_td'>";
if ($output_type == "movie")
{
echo '<a href="grab_info.php?item='.$enc_key.'" class="one"/>'.$output_tlt.'</a>';
}
else
{
  echo $output_title, $output_tlt;
}

echo "</td>";
if(!empty($output_year))
{
	echo "<td class='main_td'>".$output_year ."</td>";
}
else
{
	echo "<td class='main_td'>Not available</td>";
}
if($output_type =="movie")//check for the output media type
{
  $oIMDB = new IMDB($output_tlt);
  if ($oIMDB->isReady) {
   $rating = $oIMDB->getRating();//grab imdb rating
   echo "<td class='main_td'>".$rating."</td>";
} else {
     echo '<td class="main_td">-</td>';
}
}
else
{
   echo '<td class="main_td">Not available</td>';
}


echo "</tr>";

}//end foreach


?>

</table>
<hr class="dash" width="700"/>

</center>
