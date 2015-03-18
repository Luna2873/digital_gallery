<!-- File: /app/View/Posts/view.ctp -->
<h1><?php echo h($post['Post']['title']);?></h1>
<p><small>Created: <?php echo $post['Post']['created'];?></small></p>
<hr/>
<br/>
<p><?php echo h($post['Post']['body']);?></p>
<?php
                echo $this->Html->link(
                    'Edit',
                    array('action' => 'edit', $post['Post']['id'])
                );
            ?>
