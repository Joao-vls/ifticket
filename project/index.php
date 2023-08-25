<?php

//var_dump(filter_input(INPUT_GET,'url',FILTER_DEFAULT));
$url=(!empty(filter_input(INPUT_GET,'url',FILTER_DEFAULT)) ? filter_input(INPUT_GET,'url',FILTER_DEFAULT) : 'login');


//var_dump($url);

$url=array_filter(explode('/',$url));
//var_dump($url);

$pagina='pages/'. $url[0] .".php";
//var_dump($pagina);

if(is_file($pagina)){
  include $pagina;
}else{
  include 'pages/404.php';
}