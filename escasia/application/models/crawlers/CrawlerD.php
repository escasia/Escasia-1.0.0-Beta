<?php
class Application_Model_Crawlers_CrawlerD {
	private $site;
	private $links;
	private $entries;
	private $sql;
	
	public function __construct(){
		$this->site = "http://hannover.prinz.de/restaurants/top-ten-restaurants/asiatische-restaurants";
		$this->links = array();
	}
		
	public function extractArticle($link){	
		$html = $this->loadPage($link);	
		$xml=new DOMDocument();
		$xml->loadHtml($html);
		$xpath = new DOMXPath($xml);
		//$this->getArticleType($xml, $xpath);
//		$this->getArticleContact($xml, $xpath);
//		$this->getArticleDescription($xml, $xpath);
//		$this->getArticleImage($xml, $xpath);
//		$this->getArticleName($xml, $xpath);
	}
	
	private function getLinksByXML($html){
		$xml=new DOMDocument();
		$xml->loadHtml($html);
		$xpath = new DOMXPath($xml);
		$result = '';
		$prefNode = $xpath->query('//div[@class="teaserContent_w61"]/a',$xml);
		for($i = 0; $i<$prefNode->length; $i++){
			$link = $prefNode->item($i)->attributes->item(0)->nodeValue;			
			$this->links[] = $link;			
		}		
	}
	
	public function getArticleType($xml,$xpath){
		$result = '';
		$prefNode = $xpath->query('//div[@class="divHeaderFb"]/h2',$xml);
		for($i = 0; $i<$prefNode->length; $i++){
			$link = $prefNode->item($i)->attributes->item(0)->nodeValue;
			echo "--------type: ".$i.$prefNode->item(0)->nodeValue." <br/>";
			
		}
	}
	
	/**
	 * get restaurant's name from html code	 
	 * @param unknown_type $artText
	 */
	private function getArticleName($xml,$xpath){
		$startPos = strpos($artText, '<h1 class="special_ff" property="v:name">');
		$endPos = strpos($artText, '</h1>');
		$name = substr($artText, $start,$endPos);
		return $name;
	}
	
	/**
	 * 
	 * get contact from html code
	 * @param unknown_type $artText
	 */
	private function getArticleContact($xml,$xpath){
		$startPos = strpos($artText, '<span typeof="v:Address">');
		$endPos = strpos($artText, '</span>');
		$address = substr($artText, $start,$endPos,3);
		return $address;
	}
	
	/**
	 * 
	 * get image from html code
	 * @param unknown_type $artText
	 */
	private function getArticleImage($xml,$xpath){
		$startPos = strpos($artText, '<h1 class="special_ff" property="v:name">');
		$endPos = strpos($artText, '</h1>');
		$div = substr($artText, $start,$endPos);
		//renew startPos and endpos
		$startPos = strpos($div, '<img src="');
		$endPos = strpos($artText, '">');
		$imgLink = substr($div, $start,$endPos);
		return $imgLink;
	}
	
	/**
	 * get description from html code	 
	 * @param unknown_type $artText
	 */
	private function getArticleDescription($xml,$xpath){
		$startPos = strpos($artText, '<div class="bodyText>"');
		$endPos = strpos($artText, '</div>');
		$des = substr($artText, $start,$endPos);
		return $des;
	}
	
	
	
	public function extractHTML($link){
		$content = $this->loadPage($link);
		$this->getLinksByXML($content);
		$i = 0;
		foreach ($this->links as $link) {
			echo "link ".$i. "<br/>";
			$this->extractArticle($link);
			$i++;
		}
	}
	
	/**
	 * load a page into html form	 
	 * @param unknown_type $link
	 */
	public function loadPage($link){
		// to specify http headers like `User-Agent`,
		 // you could create a context like so:
		 $options = array(
		   'http' => array(
		      'method' => "GET",
		      'header' => "User-Agent: PHP\r\n"
		   )
		 );
		 // create context
	 $context = stream_context_create($options);
		 // open file with the above http headers
	 $content = file_get_contents($link, false, $context);
		 	
	 return $content;
	}
	
	public function prepareSQl(){
		
	}
	
	public function execute(){
		$this->extractHTML($this->site);	
	}
}