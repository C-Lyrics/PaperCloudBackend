<?php
header("Access-Control-Allow-Origin: *");
require  __DIR__ . '/vendor/autoload.php';
require'arxiv.php';
require 'IEEE.php';

use Slim\Slim;

/**
*creates the appp
*/
$app = new Slim([
	'templates.path' => './templates'
]);

/**
*sets the template directory to find the html files
*/
$app->view()->setTemplatesDirectory('./templates');

/**
*implements the search by keyword functionality
*/
$app->get('/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeyword($keyword);

	$app->render('display.php', ['data' => $items]);
});

/**
*implements the search by name functionality
*/
$app->get('/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByName($name);

	$app->render('display.php', ['data' => $names]);
});
/**
*implements the autocomplete functionality
*not finished
*/
$app->get('/name_ac/:name', function($name) use ($app) {

	$arxiv = new arxiv();
	$names = $arxiv->autocomplete($name);

	$app->render('getResearcherAc.php', ['names' => $names]);
});

/**
 *IEEE: recieves the keyword and finds the papers that contain the keyword
 */
$app->get('/IEEE/keyword/:keyword', function($keyword) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByKeyword($keyword);

	$app->render('display.php', ['data' => $items]);
});
/**
 *IEEE: recieves the researchers name and finds the papers published by that researcher
 */
$app->get('/IEEE/name/:name', function($name) use ($app){

	$IEEE = new IEEE();
	$names = $IEEE->queryByName($name);

	$app->render('display.php', ['data' => $names]);
});

/**
 *IEEE: recieves the ID and finds the papers that connect to the ID used
 */
$app->get('/IEEE/id/:id', function($id) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByID($id);

	$app->render('display.php', ['data' => $items]);
});

//IEEE v2
$app->get('/IEEE/v2/keyword/:keyword', function($keyword) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByKeywordV2($keyword);

	$app->render('display.php', ['data' => $items]);
});

$app->get('/IEEE/v2/name/:name', function($name) use ($app){

	$IEEE = new IEEE();
	$names = $IEEE->queryByNameV2($name);

	$app->render('display.php', ['data' => $names]);
});

//V2
/**
* gets the keyword from the search and gets the research paper from arxiv
*/
$app->get('/v2/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeywordV2($keyword);

	$app->render('display.php', ['data' => $items]);
});

/**
* gets the name of the research paper from arxiv
*/
$app->get('/v2/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByNameV2($name);

	$app->render('display.php', ['data' => $names]);
});

/**
* gets the title of the research paper from arxiv
*/
$app->get('/v2/title/:title', function($title) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByTitle($title);

	$app->render('display.php', ['data' => $names]);
});

$app->run();
