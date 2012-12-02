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
	
	public function getLinks($html){
		$div = explode('<div class="teaserContent_w61">', $html);
		for($i = 0; $i<count($div); $i++){
			if($i > 0){
				$link = substr($div[$i],strpos($div[$i], "http://"),strpos($div[$i],".html")-9);
				$this->links[] = $link;
				//echo $link." <br/>";
				//get content of second link
				$this->extractArticle($link);		
			} 
		}
		echo $this->sql;
	}
	
	public function extractArticle($link){		
		 $content = $this->loadPage($link);
		 		 
		 //get artilce
		 $article = explode('<div class="artikel"', $content);
		 var_dump($article);
		
//		for($i = 0; $i<count($article); $i++){
//			if($i > 1){
////				$this->sql .= "article number: ".$i." : <br/>";
////				$this->sql .= "type : ".$this->getArticleType($article[$i])."<br/>";
////				echo "name: ".$this->getArticleType($article[$i])." <br/>";
//////				echo "contact: ".$this->getArticleContact($article[$i])." <br/>";
//////				echo "imglinks : ".$this->getArticleImage($article[$i])." <br/>";
//////				echo "Description: ".$this->getArticleDescription($article[$i])." <br/>";
////				echo "next article ..................................................<br/>";		
//			} 
//		}
	}
	
	private function getLinksByXML($html){
		$xml=new DOMDocument();
		$xml->loadHtml($html);
		$xpath = new DOMXPath($xml);
		$result = '';
		foreach($xpath->query('//div[@class="teaser_img_text_w61"]/*') as $node) {
			while($node->hasChildNodes()){
				$child = $node->removeChild();
				
			}
		    $result .= $xml->saveXML($node);
		}
		var_dump($result);
		
	}
	
	public function getArticleType($artText){
		$startPos = strpos($artText, '<div <h2 class="schwarz">');
		$endPos = strpos($artText, '</h2>');
		$name = substr($artText, $start+20,$endPos-5);
		return $name;
	}
	
	/**
	 * get restaurant's name from html code	 
	 * @param unknown_type $artText
	 */
	private function getArticleName($artText){
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
	private function getArticleContact($artText){
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
	private function getArticleImage($artText){
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
	private function getArticleDescription($artText){
		$startPos = strpos($artText, '<div class="bodyText>"');
		$endPos = strpos($artText, '</div>');
		$des = substr($artText, $start,$endPos);
		return $des;
	}
	
	
	
	public function extractHTML($link){
		$content = $this->loadPage($link);	
//		$this->getLinks($content
		$this->getLinksByXML($content);
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