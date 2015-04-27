<?php

class ACM {
	private $baseURL = 'http://dl.acm.org.libproxy.usc.edu/'

	 /**
     * @return string           [returns the base URL]
     */

    public function getBaseUrl() {
        return $this->baseURL;
    }

    function getArticleId($nodeList) {

    }

    function queryByKeyword($keyword) {
    	$url = $this->$baseURL . 'query=' . $keyword;

    	$contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);
        
    }
}