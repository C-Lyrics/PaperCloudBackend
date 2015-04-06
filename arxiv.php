<?php 

require_once('/php/autoloader.php');

class arxiv {
	private $baseUrl = 'http://export.arxiv.org/api/query?search_query=';
	private $pie;

	function __construct() {
		$this->pie = new SimplePie();	
	}

	public function getBaseUrl() {
		return $this->baseUrl;
	}

	public function getPie() {
		return $this->pie;
	}

	//returns research paper data based on a given keyword
	function queryByKeyword($word) {
		//initializes the simple pie parser
		$url = $this->baseUrl . 'all:' . $word . '&max_results=200';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		//content array will contain a key-value mapping of a research paper title and summary
		$contentArray = [];

		//adds each item from that API result to content array
		foreach ($items as $item) {
			$contentArray[$item->get_title()] = $item->get_content();
		}

		//if there is no data for that keyword, throw an error
		if(count($contentArray) == 0) {
			return ["error" => "1"];
		}
		return $contentArray;
	}

	//returns research paper data based on a given researcher name
	function queryByName($name) {
		//initializes the simple pie parser
		$url = $this->baseUrl . 'au:' . $name .'&max_results=200';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		//content array will contain  a key-value mapping of a research paper title and summary
		$contentArray = [];

		//scans through each API result and checks to make sure the author's name is in fact in that result
		//necessary because sometimes the api will return a false result (perhaps because the name is mentioned in the paper elsewhere)
		foreach($items as $item) {
			foreach($item->get_authors() as $author) {
				if(strpos(strtolower($author->get_name()), strtolower($name)) !== false){
					$contentArray[$item->get_title()] = $item->get_content();
				}
			}
		}

		if(count($contentArray) == 0) {
			return ["error" => "1"];
		}

		return $contentArray;
	}

	//still needs work, will finish in sprint 2
	function autocomplete($name) {
		$characters = [
			'a',
			'b','c','d','e',
			'f','g','h','i',
			'j','k','l','m',
			'n','o','p','q',
			'r','s','t','u',
			'v','w','x','y',
			'z'
		];

		$url = $this->baseUrl . 'au:' . $name  .'&max_results=200';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		$nameArray = [];

		foreach($items as $item) {
			foreach($item->get_authors() as $author) {
				if(strpos(strtolower($author->get_name()), strtolower($name)) !== false){
					if(!array_key_exists($author->get_name(), $nameArray))
						$nameArray[$author->get_name()] = $author->get_name();
				}
			}
		}

		/* optional, will add much more auto complete results but take longer
		foreach($characters as $letter)	 {
			$newName = $name . $letter;
			$tempPie = new SimplePie();

			$tempUrl = $this->baseUrl . 'au:' . $newName;
			$tempPie->set_feed_url($tempUrl);
			$tempPie->init();

			$tempItems = $tempPie->get_items();

			foreach($tempItems as $item) {
				foreach($item->get_authors() as $author) {

					$authorName = $author->get_name();

					if(strpos(strtolower($authorName), strtolower($newName)) !== false){
						if(!array_key_exists($authorName, $nameArray))
							$nameArray[$authorName] = $authorName;
					}
				}
			}
		}
		*/

		$returnArray = [];
		foreach($nameArray as $value) {
			array_push($returnArray, $value);
		}

		return $returnArray;
	}
}