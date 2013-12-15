<?
/*-------------------------------------------------------------
---Parses template files with loaded data to output html markup 
----------------------------------------------------------------*/

class View{
	protected $view, $vars = array();


	//Initialize the view
	public function __construct($view = NULL){
		if(!$view){
			throw new Exception("No view slug was applied");
		}
		$this->view = $view;
		echo "echoed construct bitch ". $this->view = $view. "<br>";
	}


	//load data for view into an array
	public function __set($key, $var){
		$this->vars[$key] = $var;
	}

	//loads and parses selected template
	public function render($print = TRUE){
		extract($this->vars);

		//check to make sure requested view exists
		$view_filepath = SYS_PATH. '/views/'.$this->view.'inc.php';
		if(!file_exists($view_filepath)){
			throw new Exception("This view file does not exist");
		}

		//turn on output buffering if markup should be returned, not printed
		if(!$print){
			return ob_start();
		}

		require $view_filepath;

		//return markup if requested
		if(!$sprint){
			return ob_get_clean();
		}

	}
}

//class test
$obj = new view("mssage");
//$obj->test("message");
?>