<?php

class IEEETest extends PHPUnit_Framework_TestCase {
    public function testGetBaseUrl() {
        $ieee = new IEEE();
        $url = $ieee->getBaseUrl();

        $this->assertNotEmpty($url);
        $this->assertNotNull($url);
        $this->assertEquals($url, 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?');
    }

    public function testQueryByKeyword() {
        $ieee = new IEEE();
        $content = $ieee->queryByKeyword('java');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 100);

        $ieeeBadInput = new IEEE();
        $badInputContent = $ieeeBadInput->queryByKeyword('someSortOfBadInput');

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
    }

    public function testQueryByName() {
        $ieee = new IEEE();
        $content = $ieee->queryByName('david');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 100);

        $ieeeBadInput = new IEEE();
        $badInputContent = $ieeeBadInput->queryByName('badinput');

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
    }

    public function testQueryByID() {
        $ieee = new IEEE();

        $id = '6405359';
        $content = $ieee->queryByID($id);

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 1);

        $badID = '0';
        $ieeeBadInput = new IEEE();
        $badInputContent = $ieeeBadInput->queryByID($badID);

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
    }

    public function testQueryByKeywordV2() {
        $ieee = new IEEE();
        $content = $ieee->queryByKeywordV2('java');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 100);

        $ieeeBadInput = new IEEE();
        $badInputContent = $ieeeBadInput->queryByKeyword('someSortOfBadInput');

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
    }

    public function testQueryByNameV2() {
        $ieee = new IEEE();
        $content = $ieee->queryByName('david');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 100);

        $ieeeBadInput = new IEEE();
        $badInputContent = $ieeeBadInput->queryByName('badinput');

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
    }
}