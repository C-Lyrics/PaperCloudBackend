<?php


class IEEE {
    private $baseUrl = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?';

    /**
     * @return string
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
     * @param $keyword
     * @return array|string
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
     * @param $name
     * @return array|string
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
     * @param $id
     * @return array|string
     */
    function queryByID($id) {
        $url = $this->baseUrl . 'an=' . $id;
        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);
        /*
        $abstracts = $doc->getElementsByTagName("abstract");
        foreach ($abstracts as $abstract) {
            foreach($abstract->childNodes as $child) {
                if ($child->nodeType == XML_CDATA_SECTION_NODE) {
                    array_push($contentArray, $child->textContent);
                }
            }
        }*/
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
}