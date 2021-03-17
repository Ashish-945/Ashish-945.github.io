<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Orders</h1>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Country</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item):?>
                        <tr>
                        <th scope="row"><?=$item->id?></th>
                        <td><?=$item->first_name?> <?=$item->last_name?></td>
                        <td><?=number_format($item->price , 2)?></td>
                        <td>
                            <form method="post" action="<?=base_url('manager/edit_order/' . $item->id)?>"class="form-inline">
                                <input type="text" name="status" required class="form-control" value="<?=$item->status?>">
                                <button class="btn btn-success" type="submit">Save</button>
                            </form>
                        </td>
                        <td><?=$item->created?></td>
                        <td><?=$item->country?></td>
                        <td><?=$item->payment=='on'?'Cash':'Other'?></td>
                        <td>
                            <a class="btn btn-danger delete" href="<?=base_url('manager/delete_order/' . $item->id)?>">
                                <span class="oi oi-trash"></span>
                            </a>
                            <button class="btn btn-primary order-detail" data-id="<?=$item->id?>" data-toggle="modal" data-target="#orderModal">
                                <span class="oi oi-eye"></span>
                            </button>
                        </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-12 m-auto">
                <?=$pagination?>
            </div>  
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>