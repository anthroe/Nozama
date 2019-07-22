<?php

// Prevents caching making changes to database reflect onto the UI immediately
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// TEMPORARY: Allows User to click the back button without constant prompts
session_cache_limiter('private_no_expire');

session_start();

class Controller 
{
	public function model($model)
	{
		require_once '../app/models/' . $model . '.php';
		return new $model();
	}

	public function view($view, $data = [])
	{
		require '../app/views/' . $view . '.php';
	}
}

?>