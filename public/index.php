<?php
require_once __DIR__.'/initApp.php';
require_once __DIR__.'/bdd.php';

$app->get('/', function (Symfony\Component\HttpFoundation\Request $request) use($app, $pdo){
	$word = $request->get("word");
	if(isset($word)){
		return $app->redirect('/'.$word);
	}
	return $app['twig']->render('index.html', array());
});

$app->get('/{mot}', function ($mot, Symfony\Component\HttpFoundation\Request $request) use($app, $pdo){
	$mots_deja_votes = $app["session"]->get("votes");
	if(!isset($mots_deja_votes)){
		$mots_deja_votes = array();
	}
	$word = $request->get("word");
	if(isset($word)){
		return $app->redirect('/'.$word);
	}
	$motBD = get_mot($pdo, $mot)[0];
	return $app['twig']->render('index.html', array(
		"mot" => $mot,
		"voteLe" => $motBD["voteLe"],
		"voteLa" => $motBD["voteLa"],
		"dejaVote" => in_array($mot, $mots_deja_votes)
	));
});


// route vote
$app->get('/voteLe/{mot}', function ($mot) use($app, $pdo){
	$mots_deja_votes = $app["session"]->get("votes");
	if(!isset($mots_deja_votes)){
		$mots_deja_votes = array();
	}
	if(! in_array($mot, $mots_deja_votes)){
		voteLe($pdo,$mot);
		$mots_deja_votes[] = $mot;
		$app["session"]->set("votes", $mots_deja_votes);
	}
	return $app->redirect('/'.$mot);
})->bind("vote_le");

$app->get('/voteLa/{mot}', function ($mot) use($app, $pdo){
	$mots_deja_votes = $app["session"]->get("votes");
	if(!isset($mots_deja_votes)){
		$mots_deja_votes = array();
	}
	if(! in_array($mot, $mots_deja_votes)){
		voteLa($pdo,$mot);
		$mots_deja_votes[] = $mot;
		$app["session"]->set("votes", $mots_deja_votes);
	}
	return $app->redirect('/'.$mot);
})->bind("vote_la");

$app->run();