
        <div class="container">
            <div class="row">
                    <div class="col-12"></div>
                    <h1>Edit Items</h1>
                    
                    <?=isset($error) ? $error : ''?>
                    <?=validation_errors()?>
                    <?=form_open_multipart(base_url('manager/edit_item/' . $item->id)) ?>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" 
                                name="title" value="<?=set_value('title' , $item->title)?>">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" min="0" step="0.01" id="title" 
                                name="price" value="<?=set_value('price' , $item->price )?>">
                        </div>
                        <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control-file" name="image" id="image" >
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <img src="<?=base_url('uploads/' . $item->image)?>" class="img-thumbnail" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" textarea class="form-control" id="description" 
                                name="description" value="<?=set_value('description' , $item->description)?>"> </textarea>
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