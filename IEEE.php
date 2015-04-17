<?php


class IEEE {
    private $baseUrl = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?';

    /**
     * @return string           [returns the base URL]
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    function getArticleId($nodeList) {

        $contentArray = [];
        foreach ($nodeList as $node) {
            foreach($node->childNodes as $child) {
                if ($child->nodeType == XML_CDATA_SECTION_NODE) {
                    array_push($contentArray, $child->textContent);
                }
            }
        }
        return $contentArray;
    }

    /**
     * @param $keyword          [Takes in the keyword for the search and queries it to the API]
     * @return array|string     [Returns an array of ID numbers for articles found by the API]
     */
    function queryByKeyword($keyword) {
        $url = $this->baseUrl . 'querytext=' . $keyword . '&hc=50&sortorder=desc';

        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);
        $destinations = $doc->getElementsByTagName("arnumber");
        $contentArray = $this->getArticleId($destinations);

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }

    /**
     * @param $name             [Takes in the researcher name and queries to the API]
     * @return array|string     [Returns an array of ID numbers for articles found by the API]
     */
    function queryByName($name) {
        $url = $this->baseUrl . 'au=' . $name . '&sortorder=desc';

        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);
        $destinations = $doc->getElementsByTagName("arnumber");
        $contentArray = $this->getArticleId($destinations);

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }

    /**
     * @param $id               [Takes in a single research paper ID number and queries to the API]
     * @return array|string     [Returns research paper title, abstract, publisher title, and year published]
     */
    function queryByID($id) {
        $url = $this->baseUrl . 'an=' . $id;
        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);

        $documents = $doc->getElementsByTagName("document");

        $title = "";
        $abstract = "";
        $publisher = "";
        $date = "";

        foreach ($documents as $document) {
            foreach($document->childNodes as $child) {
                if(strpos($child->nodeName, "title") !== false && strlen($child->nodeName) == 5) {
                    $title = $child->textContent;
                } else if(strpos($child->nodeName, "abstract") !== false) {
                    $abstract = $child->textContent;
                } else if(strpos($child->nodeName, "pubtitle") !== false) {
                    $publisher = $child->textContent;
                } else if(strpos($child->nodeName, "py") !== false) {
                    $date = $child->textContent;
                }
            }
        }

        array_push($contentArray, [
            "title" => $title,
            "abstract" => $abstract,
            "publisher" => $publisher,
            "date" => $date
        ]);

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }

    /**
     * v2
     */
    function queryByKeywordV2($keyword) {
        $url = $this->baseUrl . 'querytext=' . $keyword . '&hc=50&sortorder=desc';
        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);

        $documents = $doc->getElementsByTagName("document");

        foreach ($documents as $document) {
            $title = "";
            $abstract = "";

            foreach($document->childNodes as $child) {
                if(strpos($child->nodeName, "title") !== false && strlen($child->nodeName) == 5) {
                    $title = $child->textContent;
                } else if(strpos($child->nodeName, "abstract") !== false ) {
                    $abstract = $child->textContent;
                }
            }
            array_push($contentArray, [
                "title" => $title,
                "abstract" => $abstract
            ]);
        }

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }

    function queryByNameV2($name) {
        $url = $this->baseUrl . 'au=' . $name . '&hc=50&sortorder=desc';
        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);

        $documents = $doc->getElementsByTagName("document");

        foreach ($documents as $document) {
            $title = "";
            $abstract = "";

            foreach($document->childNodes as $child) {
                if(strpos($child->nodeName, "title") !== false && strlen($child->nodeName) == 5) {
                    $title = $child->textContent;
                } else if(strpos($child->nodeName, "abstract") !== false ) {
                    $abstract = $child->textContent;
                }
            }
            array_push($contentArray, [
                "title" => $title,
                "abstract" => $abstract
            ]);
        }

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }
}