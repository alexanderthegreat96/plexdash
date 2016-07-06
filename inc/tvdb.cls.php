<?php

/*

Built from the official TvDb class. Simpler, faster and
easier to use. Cache is enabled by default. Make sure there's a
writable cache directory.

Example
require_once("tvdb.cls.php");
$tvdb = new TvDb("http://thetvdb.com", "APIKEY");

// Search for a show
$data = $tvdb->getSeries('Doctor Who (2005)');

// Use the first show found and get the S01E01 episode
$episode = $tvdb->getEpisode($data[0]->Series->seriesid, 1, 1, 'en');
var_dump($episode);

*/


class TvDb{
	private $baseUrl = '';
	private $apiKey = '';
	private $mirrors = array();
	private $languages = array();
	private $defaultLanguage = 'en';
	private $cacheExpires = '';

	public function __construct($baseUrl, $apiKey, $ttl=600)
	{
		$this->baseUrl = $baseUrl;
		$this->apiKey = $apiKey;
		$this->cacheExpires = $ttl;
	}

	private function fetch($url, array $params = array()){
		$url = $this->baseUrl . '/api/' . $url;
		$hash = md5($url);
		$filename = dirname(__FILE__).'/cache/' . $hash . '.cache';
		$changed = file_exists($filename) ? filemtime($filename) : 0;
		$now = time();
		$diff = $now - $changed;

		if ( !$changed || ($diff > $this->cacheExpires) ) {
			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			if ($params!=array()) {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			}

			$response = curl_exec($ch);

			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$data = substr($response, $headerSize);
			curl_close($ch);

			if ($httpCode != 200) {
				throw new Exception(sprintf('Cannot fetch %s. HTTP Code: %s', $url, (string)$httpCode));
			}

			$cache = fopen($filename, 'wb');
			$write = fwrite($cache, serialize($data));
			fclose($cache);
			return $data;
		}
		$cache = unserialize(file_get_contents($filename));
		return $cache;
	}

	public function getServerTime()
	{
		return (string)$this->fetch('Updates.php?type=none')->Time;
	}

	public function getSeries($seriesName, $language = null)
	{
		$language = $language ? : $this->defaultLanguage;

		$data = $this->fetchXml('GetSeries.php?seriesname=' . urlencode($seriesName) . '&language=' . $language);
		$series = array();
		foreach ($data->Series as $serie) {
			$series[] = $data;
		}
		return $series;
	}

	public function getSerie($serieId, $language = null)
	{
		$language = $language ? : $this->defaultLanguage;

		$data = $this->fetchXml($this->apiKey . '/series/' . $serieId . '/' . $language . '.xml');

		return $data->Series;
	}

	public function getBanners($serieId)
	{
		$data = $this->fetchXml($this->apiKey . '/series/' . $serieId . '/banners.xml');
		echo $this->apiKey . '/series/' . $serieId . '/banners.xml';
		$banners = array();
		foreach ($data->Banners as $banner) {
			$banners[] = $banner;
		}

		return $banners;
	}

	public function getBanner($url){
		return $this->baseUrl . '/banners/' . $url;
	}

	public function getPoster($serieId){
		$data = $this->fetchXml($this->apiKey . '/series/' . $serieId . '/banners.xml');
		$posters = array();
		foreach($data as $banner){
			if($banner->BannerType == "poster"){
				$posters[] = $banner->BannerPath;
			}
		}
		return $this->getBanner($posters[0]);
	}

	public function getActors($serieId)
	{
		$data = $this->fetchXml('series/'. $serieId . '/actors.xml');
		$actors = array();
		foreach ($data->Actor as $actor) {
			$actors [] = $actor;
		}

		return $actors;
	}

	public function getSerieEpisodes($serieId, $language = null)
	{
		$language = $language ? : $this->defaultLanguage;

		$data = $this->fetchXml('series/' . $serieId . '/all/' . $language . '.' . $format);

		$serie = new Serie($data->Series);
		$episodes = array();
		foreach ($data->Episode as $episode) {
			$episodes[(int)$episode->id] = $episode;
		}
		return array('serie' => $serie, 'episodes' => $episodes);
	}

	public function getEpisode($serieId, $season, $episode, $language = null)
	{
		$language = $language ? : $this->defaultLanguage;

		$data = $this->fetchXml($this->apiKey . '/series/' . $serieId . '/default/' . $season . '/' . $episode . '/' . $language . '.xml');

		return $data->Episode;
	}

	public function getEpisodeById($episodeId, $language = null)
	{
		$language = $language ? : $this->defaultLanguage;

		$data = $this->fetchXml($this->fetch('episodes/' . $episodeId . '/' . $language . '.xml'));

		return $data->Episode;
	}

	public function getUpdates($previousTime)
	{
		$data = $this->fetchXml('Updates.php?type=all&time=' . $previousTime);

		$series = array();
		foreach ($data->Series as $serieId) {
			$series[] = (int)$serieId;
		}
		$episodes = array();
		foreach ($data->Episode as $episodeId) {
			$episodes[] = (int)$episodeId;
		}
		return array('series' => $series, 'episodes' => $episodes);
	}

	protected function getXml($data)
	{
		if (extension_loaded('libxml')) {
			libxml_use_internal_errors(true);
		}

		$simpleXml = simplexml_load_string($data);
		if (!$simpleXml) {
			if (extension_loaded('libxml')) {
				$xmlErrors = libxml_get_errors();
				$errors = array();
				foreach ($xmlErrors as $error) {
					$errors[] = sprintf('Error in file %s on line %d with message : %s', $error->file, $error->line, $error->message);
				}
				if (count($errors) > 0) {

					throw new XmlException(implode("\n", $errors));
				}
			}
			throw new XmlException('Xml file cound not be loaded');
		}

		return $simpleXml;
	}

	protected function getLanguages()
	{
		$languages = $this->fetchXml('languages.xml');

		foreach ($languages->Language as $language) {
			$this->languages[(string)$language->abbreviation] = array(
				'name' => (string)$language->name,
				'abbreviation' => (string)$language->abbreviation,
				'id' => (int)$language->id,
			);
		}
	}

	protected function fetchXml($data){
		if(preg_match('/\s/',$data)){
			return simplexml_load_string($data);
		} else {
			$ddata = $this->fetch($data);
			return simplexml_load_string($ddata);
		}
	}
}
