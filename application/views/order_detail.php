<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php foreach ($items as $id => $item) :?>
                <div class="row mb-3">
                    <div class="col-2">
                        <img src="<?=base_url('uploads/' . $item->image)?>" alt="" class="img-thumbnail">
                    </div>
                    <div class="col-6"><h4><?=$item->title?></h4></div>
                    <div class="col-4"><h4><?=number_format($item->price,2)?></h4></div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>