<?php

class question extends Controller{
	public $room_id, $is_presenter = FALSE;

	public function __construct($options){
		parent::__construct($options);

		$this->room_id = isset($options[0]) ? (int) $options[0] : 0;
		if($this-> room_id === 0){
			throw new Exception("Invalid room ID");
		}
	}

	public function get_title(){
		return NULL;
	}

	//load and output view markup
	public function output_view(){
		$questions = $this->get_questions();

		$output = NULL;
		foreach ($questions as $question) {
			$view = new View('question');
			$view->question = $question->question;
			$view->room_id = $this->room_id;
			$view->question_id = $question->question_id;
			$view->vote_count = $question->vote_count;

			if($question -> is_answered == 1){
				$view->answered_class = 'answered';
			}
			else{
				$view->answered_class = NULL;
			}
				

				//check if user has already up-voted a quesion
			$cookie = 'voted_for'.$quesion->question_id;
			if(isset($_COOKIE[$cookie]) && $_COOKIE[$cookie] == 1){
				$view->voted_class = 'voted';
			}
			else{
				$view->voted_class = NULL;
			}

			$view->vote_link = $this->output_vote_forn(
				$this->room_id, $question->question_id, 
				$question->is_answered);

				//load the vote up form for attendees, but not presenters
				$view ->vote_link = '';

				//load the answer form for presenters, but not attendees
				$view->answer_link = '';

				//return output of render() instead of printing it
				$output .= $view->render(FALSE);
			return $output;
		}
	}

	//generate voting form for students
	protected function output_vote_forn($room_id, $question_id, $answered){
		$view = new View('questoin-vote');
		$view->room_id = $room_id;
		$view->question_id = $question_id;
		$view->form_action = APP_URL.'/question/vote';
		$view->nonce = $this->generate_nonce();
		$view->disabled = $answered == 1? 'disabled': NULL;

		return $view->render(FALSE);
	}

}

?>