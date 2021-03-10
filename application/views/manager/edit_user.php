
        <div class="container">
            <div class="row">
                    <div class="col-12"></div>
                    <h1>Edit User</h1>
                    
                    <?=validation_errors()?>
                    <?=form_open(base_url('manager/edit_user/' . $user->id)) ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" 
                                name="email" value="<?=set_value('email' , $user->email)?>">
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <input type="number" min="0" step="1" class="form-control" id="level" 
                                name="level" value="<?=set_value('level' , $user->level)?>">
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First name</label>
                            <input type="text" class="form-control" id="first_name" 
                                name="first_name" value="<?=set_value('first_name' , $user->first_name)?>">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="last_name" 
                                name="last_name" value="<?=set_value('last_name' , $user->last_name)?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" 
                                name="password" value="<?=set_value('password')?>">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Save change</button>
                    <?=form_close()?>
                    </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"  ></script>

    </body>
</html>