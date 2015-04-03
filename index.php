<?php
require  __DIR__ . '/vendor/autoload.php';
require'arxiv.php';

use Slim\Slim;


$app = new Slim([
	'templates.path' => './templates'
]);

$app->view()->setTemplatesDirectory('./templates');

$app->get('/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeyword($keyword);

	$app->render('getKeyword.php', ['items' => $items]);
});

$app->get('/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByName($name);

	$app->render('getResearcher.php', ['names' => $names]);
});

$app->get('/name_ac/:name', function($name) use ($app) {

	$arxiv = new arxiv();
	$names = $arxiv->autocomplete($name);

	$app->render('getResearcherAc.php', ['names' => $names]);
});

$app->run();
