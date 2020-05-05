<div class="container todoBackground">
    <form method="post" action="http://bee.kudin.de/index.php?controller=todo&function=create" class="add text-center my-5">
        <label for="addTodo" class="text-light"> Add a new todo... </label>
        <input required class="form-control todoInput" type="text" placeholder="name" name="name">
        <input required class="form-control todoInput" type="email" placeholder="email" name="email">
        <input required class="form-control todoInput" type="text" placeholder="todo" name="todo">
        <button type="submit" class="btn btn-primary btn-block mt-2">Add</button>
    </form>

<div class="text-center">	
	<a href="/?page=<?=$data['page'];?>&order=name&sort=<?=$data['sort'];?>">Name</a> |
	<a href="/?page=<?=$data['page'];?>&order=email&sort=<?=$data['sort'];?>">Email</a> |
	<a href="/?page=<?=$data['page'];?>&order=status&sort=<?=$data['sort'];?>">Status</a>  |
	<hr>
	<a href="/?page=<?=$data['page'];?>&order=<?=$data['order'];?>&sort=asc">ASC</a> |
	<a href="/?page=<?=$data['page'];?>&order=<?=$data['order'];?>&sort=desc">DESC</a>  |
</div>
    <ul class="list-group todos mx-auto text-light" id="todos-list">
	<?php 


		foreach ($data['todos'] as $todo) {
			if ($todo['status'] == 1) {
				$status = 'text-success';
			} else {
				$status = 'text-danger';
			}
			if ($todo['changed'] == 1) {
				$changed = 'Changed by admin';
			} else {
				$changed = '';
			}
		
	?>
	<li class="list-group-item text-center <?=$status;?> align-items-center">
		<b><?=htmlspecialchars($todo['name']);?></b>
		<br><?=$todo['email'];?>
		<br><?=htmlspecialchars($todo['todo']);?>
		
		<?=$changed;?>
		<br>
		<span>
		<a class="del-todo" href="http://bee.kudin.de/index.php?controller=todo&function=delete&id=<?=$todo['id'];?>">
			<i class="fas fa-trash-alt"></i> 
		</a></span>
		<a class="edit-todo text-success mr-2" href="http://bee.kudin.de/index.php?controller=todo&function=edit&id=<?=$todo['id'];?>"> <i class="fa fa-edit"></i> </a>
		</li>
	<?php
		}
		?>
	
    </ul>
	
	 <ul class="pagination">
        <li><a href="?page=1&order=<?=$data['order'];?>&sort=<?=$data['sort'];?>">First</a></li>
        <li class="<?php if($data['page'] <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($data['page'] <= 1){ echo '/'; } else { echo "?page=".($data['page'] - 1); } ?>&order=<?=$data['order'];?>&sort=<?=$data['sort'];?>">Prev</a>
        </li>
        <li class="<?php if($data['page'] >= $data['total_pages']){ echo 'disabled'; } ?>">
            <a href="<?php if($data['page'] >= $data['total_pages']){ echo '/'; } else { echo "?page=".($data['page'] + 1);  ?>&order=<?=$data['order'];?>&sort=<?=$data['sort']; } ?>">Next</a>
        </li>
        <li><a href="?page=<?php echo $data['total_pages']; ?>&order=<?=$data['order'];?>&sort=<?=$data['sort'];?>">Last</a></li>
    </ul>	
</div>