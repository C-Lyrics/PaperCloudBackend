<?php
header("Access-Control-Allow-Origin: *");
require  __DIR__ . '/vendor/autoload.php';
require'arxiv.php';

use Slim\Slim;

//creates the app
$app = new Slim([
	'templates.path' => './templates'
]);

//sets the template directory to find the html files
$app->view()->setTemplatesDirectory('./templates');

//implements the search by keyword functionality
$app->get('/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeyword($keyword);

	$app->render('getKeyword.php', ['items' => $items]);
});

//implements the search by name functionality
$app->get('/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByName($name);

	$app->render('getResearcher.php', ['names' => $names]);
});

//implements the autocomplete functionality
//not finished
$app->get('/name_ac/:name', function($name) use ($app) {

	$arxiv = new arxiv();
	$names = $arxiv->autocomplete($name);

	$app->render('getResearcherAc.php', ['names' => $names]);
});

//IEEE

$app->get('/IEEE/keyword/:keyword', function($keyword) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByKeyword($keyword);

	$app->render('getKeyword.php', ['items' => $items]);
});

$app->get('/IEEE/name/:name', function($name) use ($app){

	$IEEE = new IEEE();
	$names = $IEEE->queryByName($name);

	$app->render('getKeyword.php', ['names' => $names]);
});

$app->get('/IEEE/title/:title', function($title) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByTitle($title);

	$app->render('getKeyword.php', ['items' => $items]);
});

//v2
$app->get('/v2/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeywordV2($keyword);

	$app->render('getKeyword.php', ['items' => $items]);
});

$app->get('/v2/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByNameV2($name);

	$app->render('getResearcher.php', ['names' => $names]);
});

$app->get('/v2/title/:title', function($title) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByTitle($title);

	$app->render('getResearcher.php', ['names' => $names]);
});

$app->run();
