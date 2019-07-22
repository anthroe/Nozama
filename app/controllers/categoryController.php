<?php

class categoryController extends Controller
{
	// Fills a select tag with options from the category database table
	public function fillSearchOptions($selectedCategory)
	{
		// Get the categories 
		$categories = new Category();
		$categories = $categories->orderby('Category_Name', 'ASC')->get();

		// Displays a categoryOptions view for each category
		for($index = 0; $index < $categories->count(); $index++) 
		{
			$category = $categories->get($index);
			self::view('category/categoryOptions', [
				'categoryID' => $category->Category_Id, 
				'categoryName' => $category->Category_Name, 
				'selectedCategory' => $selectedCategory]);
		}
	}

	// Fills a select tag with options from the category database table
	public function fillOptions()
	{
		// Get the categories 
		$categories = new Category();
		$categories = $categories->orderby('Category_Name', 'ASC')->get();

		// Gets the last selected category to maintain the selection on self submit
		$selectedCategory;
		if(isset($_POST['category']))
			$selectedCategory = $_POST['category'];

		// Displays a categoryOptions view for each category
		for($index = 0; $index < $categories->count(); $index++) 
		{
			$category = $categories->get($index);
			self::view('category/categoryOptions', [
				'categoryID' => $category->Category_Id, 
				'categoryName' => $category->Category_Name, 
				'selectedCategory' => $selectedCategory]);
		}
	}
}

?>