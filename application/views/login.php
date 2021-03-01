<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="container">
            <div class="row">
                    <div class="col-6 offset-md-3 text-center">
                    <h1 class="mb-3">Login</h1>
                    <?=validation_errors()?>
                    <?=form_open(base_url('home/login')) ?>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required name="email" value="<?=set_value('email')?>">
                        </div>  
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" required name="password" value="<?=set_value('password')?>">
                        </div>                       
                        <button type="submit" class="btn btn-block btn-primary">Enter</button>
                    <?=form_close()?>
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-info mt-4 " href="<?=base_url('home/register')?>">Register</a>                        
                        </div>
                    </div>
                    
                    </div>
            </div>
        </div>