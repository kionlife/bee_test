<div class="container todoBackground">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bold">Edit Todo</h5>
            </div>
                <form method="post" action="/index.php?controller=todo&function=update">
            <div style="text-align: center;" class="modal-body">
			
                    <input name="id" value="<?=$data['id'];?>" class="form-control" type="hidden">
                    <input placeholder="todo" name="todo" class="form-control" value="<?=$data['todo'];?>" type="text">
					<label for="status">Status</label>
                    <input id="status" <?php if ($data['status'] == 1) { $status = 'checked'; echo $status; }  ?> name="status" value="1" class="form-control" type="checkbox">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Update</button>
            </div>
                </form>
            </div>
        </div>

</div>