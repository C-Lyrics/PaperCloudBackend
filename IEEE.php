<?php


class IEEE {
    private $baseUrl = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?';

    /**
     * @return string           [returns the base URL]
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }
    /**
     * @return array           [returns the contentArray]
     */
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
        $url = $this->baseUrl . 'querytext=' . $keyword . '&hc=100&sortorder=desc';

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
        $url = $this->baseUrl . 'au=' . $name . '&hc=100&sortorder=desc';

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

        if($title == "" && $abstract == "") {
            return '{"error":"1"}';
        }

        array_push($contentArray, [
            "title" => $title,
            "abstract" => $abstract,
            "publisher" => $publisher,
            "date" => $date
        ]);

        return $contentArray;
    }

    /**
     * [queryByKeywordV2 description]
     * @param  [type] $keyword [description]
     * @return [type]          [description]
     */
    function queryByKeywordV2($keyword) {
        $url = $this->baseUrl . 'querytext=' . $keyword . '&hc=100&sortorder=desc';
        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);

        $documents = $doc->getElementsByTagName("document");

        foreach ($documents as $document) {
            $title = "";
            $content = "";
            $author = "";
            $publisher = "";
            $date = "";
            $pdf = "";

            foreach($document->childNodes as $child) {
                if(strpos($child->nodeName, "title") !== false && strlen($child->nodeName) == 5) {
                    $title = $child->textContent;
                } else if(strpos($child->nodeName, "abstract") !== false ) {
                    $content = $child->textContent;
                } else if (strpos($child->nodeName, "authors") !== false){
                    $author = str_replace(';', ',', $child->textContent);
                } else if(strpos($child->nodeName, "pubtitle") !== false) {
                    $publisher = $child->textContent;
                } else if(strpos($child->nodeName, "py") !== false) {
                    $date = $child->textContent;
                } else if(strpos($child->nodeName, "pdf") !== false) {
                    $pdf = $child->textContent;
                }
            }
            array_push($contentArray, [
                "title" => $title,
                "content" => $content,
                "author" => $author,
                "publisher" => $publisher,
                "date" => $date,
                "link" => $pdf
            ]);
        }

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }

    /**
     * [queryByNameV2 description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    function queryByNameV2($name) {
        $url = $this->baseUrl . 'au=' . $name . '&hc=100&sortorder=desc';
        $contentArray = [];

        $doc = new DOMDocument();
        $doc->load($url);

        $documents = $doc->getElementsByTagName("document");

        foreach ($documents as $document) {
            $title = "";
            $content = "";
            $author = "";
            $publisher = "";
            $date = "";
            $pdf = "";


            foreach($document->childNodes as $child) {
                if(strpos($child->nodeName, "title") !== false && strlen($child->nodeName) == 5) {
                    $title = $child->textContent;
                } else if(strpos($child->nodeName, "abstract") !== false ) {
                    $content = $child->textContent;
                } else if (strpos($child->nodeName, "authors") !== false){
                //    $author = $child->textContent;
                    $author = str_replace(';', ',', $child->textContent);
                }else if(strpos($child->nodeName, "pubtitle") !== false) {
                    $publisher = $child->textContent;
                } else if(strpos($child->nodeName, "py") !== false) {
                    $date = $child->textContent;
                } else if(strpos($child->nodeName, "pdf") !== false) {
                    $pdf = $child->textContent;
                }
            }
            array_push($contentArray, [
                "title" => $title,
                "content" => $content,
                "author" => $author,
                "publisher" => $publisher,
                "date" => $date,
                "link" => $pdf
            ]);
        }

        if(count($contentArray) == 0) {
            return '{"error":"1"}';
        }

        return $contentArray;
    }
}
