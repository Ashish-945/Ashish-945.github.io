<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends MY_Model{
    
    public function __construct(){
        parent::__construct();

        $this->setTable('order');
    }

    public function get_items($order_id){
        return $this->db
            ->select('o.item_id,o.title,o.price,i.image')
            ->from('order_items o')
            ->join('items i','i.id=o.items_id')
            ->where('o.order_id', $order_id)
            ->get()->result();
    }

}