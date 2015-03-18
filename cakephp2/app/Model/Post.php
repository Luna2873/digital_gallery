<?php 
/*重命名模型为Post*/
class Post extends AppModel {
	/*
		Validation rules are defined in the model.
	*/
	public $validate = array(
				'title' => array('rule' => 'notEmpty'),
				'body' => array('rule' => 'notEmpty')
				);

	public function isOwnedBy($post, $user) {
		return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	}
}
?>
