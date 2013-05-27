<?php
	session_start();
        
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
    
	$_GET['page'] = (isset($_GET['page']))?$_GET['page']:'main';
	$page = explode('/', $_GET['page']);
	
	include('config.php');
	include('controllers/db.php');
	include('controllers/'.$page[0].'.php');
	
	$content = new $page[0]($page);
        
	preg_match('/\<style\>(.*?)\<\/style\>/is', $content->contents, $content->style);
	preg_match_all('/\<link href=\"(.*?)\"(.*?)\>/is', $content->contents, $content->styleIncludes);
	
	preg_replace('/\<link href=\"(.*?)\"(.*?)\>/is', '', $content->contents);
	preg_replace('/\<style\>(.*?)\<\/style\>/is', '', $content->contents);
	
	$content->contents = preg_replace('/\<style\>(.*?)\<\/style\>/is', '', $content->contents);
    if(!isset($_GET['ajax'])){
        include('views/'.$content->display.'.php');
    } else {
        if($content->display != 'content'){
        include('views/'.$content->display.'.php');
        } else {
            include('views/ajax.php');
        }
    }
?>