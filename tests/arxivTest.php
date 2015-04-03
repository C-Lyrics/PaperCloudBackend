<?php

class arxivTest extends PHPUnit_Framework_TestCase {
    public function testGetBaseUrl() {
        $arxiv = new arxiv();
        $url = $arxiv->getBaseUrl();

        $this->assertNotEmpty($url);
        $this->assertNotNull($url);
        $this->assertEquals($url, 'http://export.arxiv.org/api/query?search_query=');
    }

    public function testGetPie() {
        $arxiv = new arxiv();
        $pie = $arxiv->getBaseUrl();

        $this->assertNotEmpty($pie);
        $this->assertNotNull($pie);
    }

    public function testQueryByKeyword() {
        $arxiv = new arxiv();
        $content = $arxiv->queryByKeyword('electron');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 200);

        $arxivBadInput = new arxiv();
        $badInputContent = $arxivBadInput->queryByKeyword('badinput');

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
        $this->assertEquals($badInputContent['error'], 1);
    }

    public function testQueryByName() {
        $arxiv = new arxiv();
        $content = $arxiv->queryByName('david');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 200);

        $arxivBadInput = new arxiv();
        $badInputContent = $arxivBadInput->queryByName('badinput');

        $this->assertNotEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
        $this->assertEquals($badInputContent['error'], 1);
    }

    public function testAutocomplete() {
        $arxiv = new arxiv();
        $content = $arxiv->autocomplete('david');

        $this->assertNotEmpty($content);
        $this->assertNotNull($content);
        $this->assertEquals(count($content), 81);

        $arxivBadInput = new arxiv();
        $badInputContent = $arxivBadInput->autocomplete('badinput');

        $this->assertEmpty($badInputContent);
        $this->assertNotNull($badInputContent);
    }
}