<?php 

require_once('./php/autoloader.php');

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

	function queryByKeyword($word) {
		$url = $this->baseUrl . 'all:' . $word . '&max_results=10';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		$contentArray = [];

		foreach ($items as $item) {
		//	$contentArray[$item->get_title()] = $item->get_content();
			array_push($contentArray, [
				"title" => $item->get_title(),
				"content" => $item->get_content()
			]);
		}

		if(count($contentArray) == 0) {
			return ["error" => "1"];
		}
		return $contentArray;
	}

	function queryByName($name) {
		$url = $this->baseUrl . 'au:' . $name .'&max_results=200';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		$contentArray = [];

		/*
		foreach($items as $item) {
			$contentArray[$item->get_title()] = $item->get_content();
		}
		*/

		foreach($items as $item) {
			foreach($item->get_authors() as $author) {
				if(strpos(strtolower($author->get_name()), strtolower($name)) !== false){
			//		$contentArray[$item->get_title()] = $item->get_content();
					array_push($contentArray, [
						"title" => $item->get_title(),
						"content" => $item->get_content()
					]);
				}
			}
		}

		if(count($contentArray) == 0) {
			return ["error" => "1"];
		}

		return $contentArray;
	}

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

		if(count($nameArray) == 0) {
			return ["error" => "1"];
		}

		$returnArray = [];
		foreach($nameArray as $value) {
			array_push($returnArray, $value);
		}

		return $returnArray;
	}


	/**********************************************************************
	 *
	 * V2
	 *
	 ***********************************************************************/
	function queryByKeywordV2($word) {
		$url = $this->baseUrl . 'all:' . $word . '&max_results=10';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		$contentArray = [];

		foreach ($items as $item) {
			//	$contentArray[$item->get_title()] = $item->get_content();
			array_push($contentArray, [
				"title" => $item->get_title()
			]);
		}

		if(count($contentArray) == 0) {
			return ["error" => "1"];
		}
		return $contentArray;
	}

	function queryByNameV2($name) {
		$url = $this->baseUrl . 'au:' . $name .'&max_results=200';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		$contentArray = [];

		foreach($items as $item) {
			foreach($item->get_authors() as $author) {
				if(strpos(strtolower($author->get_name()), strtolower($name)) !== false){
					array_push($contentArray, [
						"title" => $item->get_title()
					]);
				}
			}
		}

		if(count($contentArray) == 0) {
			return ["error" => "1"];
		}

		return $contentArray;
	}

	function queryByTitle($title) {
		$url = $this->baseUrl . 'all:' . $title . '&max_results=10';
		$this->pie->set_feed_url($url);
		$this->pie->init();

		$items = $this->pie->get_items();

		$contentArray = [];

		foreach ($items as $item) {

			array_push($contentArray, [
				"title" => $item->get_title(),
				"summary" => $item->get_content(),
				"publisher" => $item->get_item_tags('http://arxiv.org/schemas/atom', 'journal_ref')[0]['data'],
				"date" => $item->get_date()
					//http://simplepie.org/api/class-SimplePie.html
			]);
			break;
		}

		return $contentArray;
	}

}