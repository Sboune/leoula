<?php

try{
    $pdo = new PDO('sqlite:'.dirname(__FILE__).'/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    
    $pdo->query("CREATE TABLE IF NOT EXISTS mot ( 
    mot            VARCHAR(100)    PRIMARY KEY,
    voteLe         INTEGER,
    voteLa         INTEGER
);");

} catch(Exception $e) {}


function ajouterMot($pdo, $mot) {
    try{
        $stmt = $pdo->prepare("INSERT INTO mot (mot, voteLe, voteLa) VALUES (:mot, 50, 50)");
        $result = $stmt->execute(array(
            'mot'         => $mot
        ));
    }catch(Exception $e){}
}

function voteLe($pdo, $mot){
    try{
        $stmt = $pdo->prepare("UPDATE mot set voteLe=voteLe+1 where mot=:mot");
        $result = $stmt->execute(array(
            'mot'         => $mot
        ));
    }catch(Exception $e){
        ajouterMot($pdo, $mot);
        voteLe($pdo, $mot);
    }
}

function voteLa($pdo, $mot){
    try{
        $stmt = $pdo->prepare("UPDATE mot set voteLa=voteLa+1 where mot=:mot");
        $result = $stmt->execute(array(
            'mot'         => $mot
        ));
    }catch(Exception $e){
        ajouterMot($pdo, $mot);
        voteLa($pdo, $mot);
    }
}

function get_mot($pdo, $mot){
    $stmt = $pdo->prepare("SELECT * FROM mot WHERE mot = :mot");
    $stmt->execute(array('mot' => $mot));
    $res = $stmt->fetchAll();
    if($res==Array()){
        ajouterMot($pdo, $mot);
        return get_mot($pdo,$mot);
    }
    return $res;
}