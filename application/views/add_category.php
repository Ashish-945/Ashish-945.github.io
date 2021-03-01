<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--<!DOCTYPE html>
<html>
    <head>
        <title>home</title>
        <link rel='stylesheet' href="<?=base_url()?>assets/css/bootstrap.min.css"  >
        <script src="assets/js/bootstrap.bundle.min.js" ></script>

    </head>
    <body>

    -->

        <div class="container">
            <div class="row">
                    <div class="col-6">
                    <h1>Add category</h1>
                    <?=validation_errors()?>
                    <?=form_open(base_url('home/add_category')) ?>
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?=set_value('title')?>">
                        </div>                        
                        <button type="submit" class="btn btn-success">Add new</button>
                    <?=form_close()?>
                    </div>
            </div>
        </div>

        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"  ></script>

    </body>
</html>

-->