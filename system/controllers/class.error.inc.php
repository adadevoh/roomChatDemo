<?
class Error extends Controller{
	private $message = NULL;


	//intialize the view
	public function __construct($options){
		if(isset($options[1])){
			$this->message = $options[1];
		}
	}

	//generate title for the page
	public function get_title(){
		return "Error Page";
	}

	//output the view
	public function output_view(){
		$view = new View('error');
		$view->message = $this->message;
		$view->home_link = APP_URL;
		$view->render();
	}
	
}

?>