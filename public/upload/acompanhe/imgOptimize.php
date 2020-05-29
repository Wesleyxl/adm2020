<?php


$nome = $_POST['nome'];
$nome2 = $_POST['nome2'];

include 'ImageResize.php';

$img = new \Gumlet\ImageResize($nome);
$img->quality_jpg = 10;

$img->save($nome2);
unlink($nome);

?>