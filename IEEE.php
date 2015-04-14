<?php


class IEEE {
    private $baseUrl = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?';

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    function queryByKeyword($keyword) {
        $url = $this->IEEE . 'querytext=' . $keyword . '&sortorder=desc';
    }
    function queryByName($name) {
        $url = $this->IEEE . 'au=' . $name . '&sortorder=desc';
    }

    function queryByTitle($title) {
        $url = $this->IEEE . 'ti=' . $title . 'sortorder=desc';
    }
}