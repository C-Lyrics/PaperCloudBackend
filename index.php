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
* [sets the template directory to find the html files]
*/
$app->view()->setTemplatesDirectory('./templates');

/**
*@param $keyword 	[implements the search by keyword functionality]
*/
$app->get('/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeyword($keyword);

	$app->render('display.php', ['data' => $items]);
});

/**
*@param $name    	[implements the search by name functionality]
*/
$app->get('/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByName($name);

	$app->render('display.php', ['data' => $names]);
});
/**
*@param $name    	[implements the autocomplete functionality]
*/
$app->get('/name_ac/:name', function($name) use ($app) {

	$arxiv = new arxiv();
	$names = $arxiv->autocomplete($name);

	$app->render('getResearcherAc.php', ['names' => $names]);
});

/**
 *@param $keyword    [IEEE: recieves the keyword and grabs information from IEEE to have it be displayed in the html]
 */
$app->get('/IEEE/keyword/:keyword', function($keyword) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByKeyword($keyword);

	$app->render('display.php', ['data' => $items]);
});
/**
 *@param $name    [IEEE: recieves the researchers name and grabs info. from IEEE to have it be displayed in the html]
 */
$app->get('/IEEE/name/:name', function($name) use ($app){

	$IEEE = new IEEE();
	$names = $IEEE->queryByName($name);

	$app->render('display.php', ['data' => $names]);
});

/**
 *@param $id    [IEEE: recieves the ID and finds the papers that connect to the ID used to be displayed in the html]
 */
$app->get('/IEEE/id/:id', function($id) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByID($id);

	$app->render('display.php', ['data' => $items]);
});

//IEEE v2
/**
 *@param $keyword    [gets the keyword from the search and gets the research paper from IEEE to be displayed in the html]
 */
$app->get('/IEEE/v2/keyword/:keyword', function($keyword) use ($app){

	$IEEE = new IEEE();
	$items = $IEEE->queryByKeywordV2($keyword);

	$app->render('display.php', ['data' => $items]);
});

/**
 *@param $name    [gets the name of the research paper from IEEE to be displayed in the html]
 */
$app->get('/IEEE/v2/name/:name', function($name) use ($app){

	$IEEE = new IEEE();
	$names = $IEEE->queryByNameV2($name);

	$app->render('display.php', ['data' => $names]);
});

//V2
/**
 *@param $keyword    [gets the keyword from the search and gets the research paper from arxiv, and display in the html]
 */
$app->get('/v2/keyword/:keyword', function($keyword) use ($app){

	$arxiv = new arxiv();
	$items = $arxiv->queryByKeywordV2($keyword);

	$app->render('display.php', ['data' => $items]);
});

//V2
/**
 *@param $name    [gets the name of the research paper from arxiv, and display in the html]
 */
$app->get('/v2/name/:name', function($name) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByNameV2($name);

	$app->render('display.php', ['data' => $names]);
});

//V2
/**
 *@param $title    [gets the title of the research paper from arxiv, and display in the html]
 */
$app->get('/v2/title/:title', function($title) use ($app){

	$arxiv = new arxiv();
	$names = $arxiv->queryByTitle($title);

	$app->render('display.php', ['data' => $names]);
});

$app->run();
