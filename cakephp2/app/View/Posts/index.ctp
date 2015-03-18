<!-- File: /app/View/Posts/index.ctp -->
<?php
if (AuthComponent::user()):
  // The user is logged in, show the logout link
  echo $this->Html->link('Log out', array('controller' => 'users', 'action' => 'logout'));
else:
  // The user is not logged in, show login link
  echo $this->Html->link('Log in', array('controller' => 'users', 'action' => 'login'));
endif;
?>
<h1>All The Posts</h1>
<?php echo $this -> Html -> link('Add Post', array('cotroller' => 'posts', 'action' => 'add'));?> 
<table>
	<tr></tr>
		<th>ID</th>
		<th>Title</th>
		<th>Actions</th>
        <th>Created</th>
    </tr>

<!-- Here is where we loop through our $posts array, printing out post info -->

<?php foreach ($posts as $post):?>
	<tr>
		<td>
			<?php echo $post['Post']['id'];?>
		</td>
		<td>
			<?php echo $this -> Html -> link($post['Post']['title'], array('controller' => 'posts','action' => 'view',$post['Post']['id'])); 
			//通过$this->Html实例化了Html助手类（HtmlHelper）
			//通过link()方法生成一个HTML链接，参数1:链接显示文字，参数2:链接地址
			?>
		</td>
		<td>
            <?php
                echo $this->Html->link(
                    'Edit',
                    array('action' => 'edit', $post['Post']['id'])
                );
            ?>
            <?php
            	echo $this -> Form -> postLink(
            		'Delete',
            		array('action' => 'delete', $post['Post']['id']),
            		array('confirm' => 'Are you sure?')
            		);
            ?>
        </td>
		<td>
			<?php echo $post['Post']['created'];?>
		</td>
	</tr>
<?php endforeach;?>
<?php unset($post);?>
</table>
