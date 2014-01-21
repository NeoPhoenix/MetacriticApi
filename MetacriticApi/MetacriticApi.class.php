<?php
	
	class MetacriticApi
	{
		public $metascore	= 0;
		public $userscore	= 0;
		public $metascore_d	= array(0=>0,1=>0,2=>0);
		public $userscore_d = array(0=>0,1=>0,2=>0);
		public $meta_reviews= array();
		public $user_reviews= array();
		
		public function __construct($type,array $product)
		{
			if(!in_array($type,array('movie','game','tv','music'))) throw new Exception('Invalid product type');
			$url = 'http://www.metacritic.com/'.$type.'/';
			if($type == 'game' && !in_array($product[0],array('playstation-4','xbox-one','playstation-3','xbox-360','pc','wii-u','3ds','playstation-vita','ios','legacy'))) throw new Exception('Invalid platform');
			if(!in_array($type,array('movie','tv'))) $url .= self::strEncode($product[0]).'/'.self::strEncode($product[1]);
			else $url .= self::strEncode($product[0]);
			if($type == 'tv' && count($product) >= 2) $url .= '/season-'.intval($product[1]);
			
			$dom = new DOMDocument();
			@$dom->loadHTMLFile($url);
			$xpath = new DOMXPath($dom);
			
			//fetch meta- and userscore
			$this->metascore	= $xpath->query("//span[@itemprop='ratingValue']");
			$this->metascore	= $this->metascore->length!=0?intval($this->metascore->item(0)->childNodes->item(0)->nodeValue):0;
			$this->userscore	= $xpath->query("//div[@class='userscore_wrap feature_userscore']");
			$this->userscore	= $this->userscore->length!=0?floatval($this->userscore->item(0)->childNodes->item(3)->nodeValue):0.0;
			
			//fetch metascore distribution
			$distributions		= $xpath->query("(//div[@class='score_distribution'])[1]//span[@class='count']");
			if($distributions->length == 3)
			{
				$this->metascore_d = array();
				foreach($distributions as $distribution) $this->metascore_d[] = intval($distribution->childNodes->item(0)->nodeValue);
			}
			
			//fetch userscore distribution
			$distributions		= $xpath->query("(//div[@class='score_distribution'])[2]//span[@class='count']");
			if($distributions->length == 3)
			{
				$this->userscore_d = array();
				foreach($distributions as $distribution) $this->userscore_d[] = intval($distribution->childNodes->item(0)->nodeValue);
			}
		}
		
		private function strEncode($string)
		{
			$string = str_replace(' ','-',$string);
			$chars = array_diff(range(chr(0),chr(255)),array_merge(range(0,9),array('-'),range(chr(97),chr(122))/*a-z*/,range(chr(65),chr(90))/*A-Z*/));
			$string = str_replace($chars,'',$string);
			return strtolower($string);
		}
	}
	
?>