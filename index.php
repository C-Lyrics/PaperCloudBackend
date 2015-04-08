<?php
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

$app->run();
