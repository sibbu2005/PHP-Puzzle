<?php
require_once 'StringExtractor.php';

$fileName = "input.txt";
$regexTemplate = "/\[(.*?)\]/";
$strangeIdStrigns = new StringExtractor('', $regexTemplate, $fileName);
echo $strangeIdStrigns->count();
