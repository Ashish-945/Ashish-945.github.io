<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

    private $userData;

    public function __construct(){
        parent::__construct();
        $this->userData = $this->session->userdata();

        //check manager
        if(!isset($this->userData['level']) OR $this->userData['level'] == 0){
            redirect(base_url());
        }

    }

    public function users(){
        // required 2 level for user edit 
        if($this->userData['level'] < 2){
            redirect(base_url());
        }
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('User_model' , 'model');

        $viewData['items'] = $this->model->result('*', [] , $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/users'),
            'total_rows' => $this->model->get_count([])

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/users',$viewData);

    }

    public function delete_user($id){
        $this->load->model('User_model' , 'model');

        $item = $this->model->row($id);
        if(is_object($item)){
            $this->model->delete($id);
            $this->add_alert('success' , 'User deleted successfully');
        }
        redirect(base_url('manager/users'));
    }

    public function edit_user($id){
        $viewData = [];

        $this->load->model('User_model' , 'model');

        $user = $this->model->get($id);
        if(!is_object($user)){
            show_404();

        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('email', 'Email', 'required|trim|valid_email')
            ->set_rules('first_name', 'First name', 'required|trim|min_length[2]|max_length[15]')
            ->set_rules('last_name', 'Last name', 'required|trim|min_length[2]|max_length[15]')
            ->set_rules('level', 'Level', 'required|trim|numeric')
            ->set_rules('password', 'Password', 'trim|min_length[5]|max_length[15]');


        if ($this->form_validation->run())
		{
            $data = [
                'email' => $this->input->post('email'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'level' => $this->input->post('level'),

            ];
           //to change password update this field
            $password = $this->input->post('password');
            if($password){
                $data['password'] = md5(sha1($this->input->post('password')));
            }

            $this->model->update($data , $id);
            $this->add_alert('success' , 'User updated successfully');
            redirect(base_url('manager/users'));
		}
        $viewData['user'] = $user;

        $this->render('manager/edit_user',$viewData);

    }

    public function items(){
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('Item_model' , 'model');

        $viewData['items'] = $this->model->result('*' , [] , $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/items'),
            'total_rows' => $this->model->get_count()

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/items',$viewData);

    }

    public function categories(){
        $viewData = [];

        $start = (int)$this->input->get('per_page');

        $viewData['items'] = $this->Category_model->result('*', [] , $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/categories'),
            'total_rows' => $this->Category_model->get_count()

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/categories',$viewData);

    }

    public function add_category(){
        $viewData = [];
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[30]');

        if ($this->form_validation->run())
		{
            $insertData = [
                'title'      => $this->input->post('title') 
            ];
            $this->Category_model->insert($insertData);
            $this->add_alert('success' , 'Category added successfully');
            redirect(base_url('manager/categories'));

		}

       
        $this->render('manager/add_category' , $viewData);
    }

    public function delete_category($id){
        $item = $this->Category_model->row($id);
        if(is_object($item)){
            $this->Category_model->delete($id);
            $this->add_alert('success' , 'Category deleted successfully');
        }
        redirect(base_url('manager/categories'));
    }

    public function edit_category($id){
        $viewData = [];
        $item = $this->Category_model->row($id);
        if(!is_object($item)){
            show_404();

        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[30]');

        if ($this->form_validation->run())
		{
            $data = [
                'title'      => $this->input->post('title') 
            ];
            $this->Category_model->update($data , $id);
            $this->add_alert('success' , 'Category updated successfully');
            redirect(base_url('manager/categories'));

		}

        $viewData['item'] = $item;
        $this->render('manager/edit_category' , $viewData);
    }

    public function pages(){
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('Page_model' , 'model');

        $viewData['items'] = $this->model->result('*' , [] , $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/pages'),
            'total_rows' => $this->model->get_count()

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/pages',$viewData);

    }


    public function orders(){
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('Order_model' , 'model');

        $viewData['items'] = $this->model->result('*' , [] , $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/orders'),
            'total_rows' => $this->model->get_count()

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/orders',$viewData);

    }

    public function order_detail($order_id){

        $this->load->model('Order_model', 'model');
        
        $items = $this->model->get_items($order_id);

        $data = [
            'items' => $items
        ];

        $this->load->view('order_detail', $data);
    }

    public function delete_order($item_id){
        $this->load->model('Order_model', 'model');

        $item = $this->model->row($item_id);
        if(is_object($item)){
            $this->model->delete($item_id);
            $this->add_alert('success' , 'Order deleted successfully');
        }
        redirect(base_url('manager/orders'));
    }

    public function edit_order($order_id){
        $this->load->model('Order_model', 'model');

        $item = $this->model->row($order_id);
        $status = $this->input->post('status');

        if($status && $item){
            $this->model->update(['status'=>$status], $order_id);
            $this->add_alert('success', 'Order status successfully updated ');
        }
        redirect(base_url('manager/orders'));
    }


    public function edit_item($item_id){
        $viewData = [];
        $this->load->model('Item_model', 'model');
        $item = $this->model->row($item_id);
        if(!is_object($item)){
            show_404();

        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[30]')
            ->set_rules('description', 'description', 'required')
            ->set_rules('price', 'Price', 'required|numeric|greater_than[0]');


        if ($this->form_validation->run())
		{
            $updateData = [
                'title'      => $this->input->post('title'),
                'price'      => $this->input->post('price'),
                'description'=> $this->input->post('description') 
            ];
            
			$upload = $this->do_upload();
            if(isset($upload['error'])){
                $viewData['error'] = $upload['error'];

            }else{
                $updateData['image'] = $upload['data'];
            }
           
            $this->model->update($updateData , $item_id);
            $this->add_alert('success' , 'Item updated successfully');
            redirect(base_url('manager/items'));
		}
        $viewData['item'] = $item;

        $this->render('manager/edit_item',$viewData);

    }

    public function delete_item($item_id){
        $this->load->model('Item_model', 'model');
        $item = $this->model->row($item_id);
        if(is_object($item)){
            $this->model->delete($item_id);
            $this->add_alert('success' , 'Item deleted successfully');
        }
        redirect(base_url('manager/items'));
    }

    public function add_item(){

        $viewData = [];
        $this->load->model('Item_model' , 'model');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[30]')
            ->set_rules('description', 'Description', 'required')
            ->set_rules('price', 'Price', 'required|numeric|greater_than[0]');


        if ($this->form_validation->run())
		{
			$upload = $this->do_upload();
            if(isset($upload['error'])){
                $viewData['error'] = $upload['error'];

            }else{
                $insertData = [
                    'title'      => $this->input->post('title'),
                    'price'      => $this->input->post('price'),
                    'description'=> $this->input->post('description'),
                    'image'      => $upload['data']
                ];
                $this->model->insert($insertData);
                $this->add_alert('success' , 'Item added successfully');
                redirect(base_url('manager/items'));
            }
		}

        $this->render('manager/add_item',$viewData);

    }


    public function edit_page($item_id){
        $viewData = [];
        $this->load->model('Page_model', 'model');
        $item = $this->model->row($item_id);
        if(!is_object($item)){
            show_404();

        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[30]')
            ->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run())
		{
            $updateData = [
                'title'      => $this->input->post('title'),
                'content'      => $this->input->post('content'),
            ];
         
            $this->model->update($updateData , $item_id);
            $this->add_alert('success' , 'Page updated successfully');
            redirect(base_url('manager/pages'));
		}
        $viewData['item'] = $item;

        $this->render('manager/edit_page',$viewData);

    }

    public function delete_page($item_id){
        $this->load->model('Page_model', 'model');
        $item = $this->model->row($item_id);
        if(is_object($item)){
            $this->model->delete($item_id);
            $this->add_alert('success' , 'Page deleted successfully');
        }
        redirect(base_url('manager/pages'));
    }

    public function add_page(){

        $viewData = [];
        $this->load->model('Page_model' , 'model');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[10]')
            ->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run())
		{
            $insertData = [
                'title'      => $this->input->post('title'),
                'content'      => $this->input->post('content')
            ];
            $this->model->insert($insertData);
            $this->add_alert('success' , 'Page added successfully');
            redirect(base_url('manager/pages'));
		}

        $this->render('manager/add_page',$viewData);

    }
    

    private function do_upload()
    {
        $config = [
            'upload_path'   => './uploads/',
            'allowed_types' => 'gif|jpg|png',
            'max_size'      =>  1024,
            'encrypt_name'  =>  true
        ];
            

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('image'))
            {
                    return array('error' => $this->upload->display_errors($this->config->item('error_prefix'),$this->config->item('error_suffix')));

            }
            else
            {
                    return array('data' => $this->upload->data('file_name'));

            }
    }

    private function add_alert($type, $message){
        $alert = ['type' =>$type, 'message' =>$message];
        $this->session->set_flashdata('alert', $alert);
    }

    private function render($page , $data = []){
        
        $categories =$this->Category_model->result('*');
        $headerData = [
            'categories'  => $categories,
            'user'        => $this->userData,
            'alert'       => $this->session->flashdata('alert')
        ];
        
        $this->load->view('display/header', $headerData );
        $this->load->view($page,$data);
        $this->load->view('display/footer');
    }
}
?>