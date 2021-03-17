<!DOCTYPE html>
<html>
    <head>
        <title>home</title>
        <link rel='stylesheet' href="<?=base_url()?>assets/css/bootstrap.min.css"  >
        <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js" ></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                    <div class="col-12"></div>
                    <h1>Edit Pages</h1>
                    <?=validation_errors()?>
                    <?=form_open_multipart(base_url('manager/edit_page/'.$item->id)) ?>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?=set_value('title',$item->title)?>">
                        </div>
                        <div class="mb-3">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" value="<?=set_value('content',$item->content)?>"> </textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Save new</button>
                    <?=form_close()?>
                    </div>
            </div>
        </div>
        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('content');
        </script>