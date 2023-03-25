<?php
namespace app\core;

class View
{
	public string $title = '';

	public function renderView($viewName, $params=[]){

		$viewContent = $this->renderOnlyView($viewName, $params);
		$layoutContent = $this->layoutContent();
		return str_replace('{{content}}',$viewContent, $layoutContent);
	}

	public function renderContent($viewContent){
		$layoutContent = $this->layoutContent();
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent(){
		$layout = Application::$app->layout;
		if(Application::$app->controller)
		{
			$layout = Application::$app->getController()->layout;
		}
		ob_start();
		include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
		return ob_get_clean();
	}

	protected function renderOnlyView($viewName, $params){
		//echo '<pre>';
		//var_dump($params);
		//echo '</pre>';

		// tricky part to transform the name of the hashmap into a variable name
		foreach($params as $key => $value){
			$$key = $value;
		}
		ob_start();
		include_once Application::$ROOT_DIR."/views/$viewName.php";
		return ob_get_clean();
	}
}
?>