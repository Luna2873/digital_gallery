<?php class PostsController extends AppController{
	//public $name = 'Posts';
	public $helpers = array('Html','Form');
	public $components = array('Session');
	
	/*方法控制器方法，用于显示所有的文章列表*/
	
	public function index(){
		if($this -> Auth -> user('role') === 'admin'){
			$post = $this -> Post -> find('all');
		}else{
			$post = $this -> Post -> find('all', array('conditions'=>array('Post.user_id' => $this -> Auth -> user('id'))));
		}
		$this -> set('posts', $post);
		//在视图中创建一个posts变量，该变量被赋予二个参数，
		//$this->Post用于在PostsController控制器中获取Post模型实例
		//再通过find()方法，获取Posts模型中所有的记录，并以数组形式返回。
	}

	/*view Posts*/
	public function view($id = null){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));	//ErrorHandler
		}
		$post = $this -> Post -> findById($id);	//a single post’s information.
		if(!$post){
			throw new NotFoundException(__('Invalid post'));
		}
		$this -> set('post',$post);	//获取Post模型
	}

	/*Adding Posts*/
	public function add() {
		//$this->request->is() takes a single argument, 
		//只适用于METHOD (get, put, post, delete) or some request identifier (ajax).

		if($this -> request -> is('post')){	//如果是当前的请求是POST
			
			//$this -> Post -> create();	//则使用Post model进行创建

			$this ->request->data['Post']['user_id'] = $this -> Auth -> user('id');	//新增的文章中要把当前登录的用户作为 引用保存

			 if ($this->Post->save($this->request->data)) {	//如果可以正常存储
				$this->Session->setFlash(__('Your post has been saved.'));	//通讯＝》快速显示状态
				//it displays the message and clears the corresponding session variable
				return $this -> redirect(array('action' => 'index'));	//返回index页面
			}
			$this -> Session -> setFlash(__('Unable to add your post.'));	//非正常存储就会报错
		}
	}

	/*Editing posts*/
	public function edit($id = null){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}
		$post = $this -> Post -> findById($id);
		if(!$post){
			throw new NotFoundException(__('Invalid post'));
		}
		if($this -> request -> is(array('post','put'))){
			$this -> Post -> id = $id;
			if($this -> Post -> save($this -> request -> data)){
				$this -> Session -> setFlash(__('Your post has been updated.'));
				return $this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Unable to update your post.'));
		}
		if(!$this -> request ->data){
			$this -> request -> data = $post;
		}
	}

	/*Delete a post*/
	public function delete($id){
		if($this -> request -> is('Get')){
			throw new MethodNotAllowedException();
		}
		if($this -> Post -> delete($id)){
			$this -> Session -> setFlash(__('The post with id: %s has been deleted.', h($id)));
		}else{
			$this -> Session -> setFlash(__('The post with id: %s has not been deleted.', h($id)));
		}
		return $this -> redirect(array('action' => 'index'));
	}

public function isAuthorized($user) {
    // 所有注册的用户都能够添加文章
    if ($this->action === 'add') {
        return true;
    }

    // 文章的所有者能够编辑和删除它
    if (in_array($this->action, array('edit', 'delete'))) {
        $postId = (int) $this->request->params['pass'][0];
        if ($this->Post->isOwnedBy($postId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
}
}

?>