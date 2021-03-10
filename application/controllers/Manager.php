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
        $limit = $this->config->item('per_page');

        $viewData['items'] = $this->db->limit($limit, $start)->get('users')->result();

        $this->pagination->initialize([
            'base_url'   => base_url('manager/users'),
            'total_rows' => $this->db->count_all_results('users')

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/users',$viewData);

    }

    public function delete_user($id){
        $item = $this->db->select('email')->where('id' , $id)->get('users')->row();
        if(is_object($item)){
            $this->db->delete('ci_users', array('id' => $id));
            $this->add_alert('success' , 'User deleted successfully');
        }
        redirect(base_url('manager/users'));
    }

    public function edit_user($id){
        $viewData = [];

        $user = $this->db->where('id' , $id)->get('users')->row();
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

            $this->db->where('id' , $id)->update('ci_users', $data);
            $this->add_alert('success' , 'User updated successfully');
            redirect(base_url('manager/users'));
		}
        $viewData['user'] = $user;

        $this->render('manager/edit_user',$viewData);

    }

    public function items(){
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $limit = $this->config->item('per_page');

        $viewData['items'] = $this->db->limit($limit, $start)->get('items')->result();

        $this->pagination->initialize([
            'base_url'   => base_url('manager/items'),
            'total_rows' => $this->db->count_all_results('items')

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();

        $this->render('manager/items',$viewData);

    }

    public function categories(){
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $limit = $this->config->item('per_page');

        $viewData['items'] = $this->db->limit($limit, $start)->get('categories')->result();

        $this->pagination->initialize([
            'base_url'   => base_url('manager/categories'),
            'total_rows' => $this->db->count_all_results('categories')

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
                $this->db->insert('categories', $insertData);
                $this->add_alert('success' , 'Category added successfully');
                redirect(base_url('manager/categories'));

		}

       
        $this->render('manager/add_category' , $viewData);
    }

    public function delete_category($id){
        $item = $this->db->select('title')->where('id' , $id)->get('categories')->row();
        if(is_object($item)){
            $this->db->delete('ci_categories', array('id' => $id));
            $this->add_alert('success' , 'Category deleted successfully');
        }
        redirect(base_url('manager/categories'));
    }

    public function edit_category($id){
        $viewData = [];
        $item = $this->db->where('id' , $id)->get('categories')->row();
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
                $this->db->where('id', $id)->update('categories', $data);
                $this->add_alert('success' , 'Category updated successfully');
                redirect(base_url('manager/categories'));

		}

        $viewData['item'] = $item;
        $this->render('manager/edit_category' , $viewData);
    }

    public function edit_item($item_id){
        $viewData = [];

        $item = $this->db->where('id' , $item_id)->get('items')->row();
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
           
            $this->db->where('id' , $item_id)->update('ci_items', $updateData);
            $this->add_alert('success' , 'Item updated successfully');
            redirect(base_url('manager/items'));
		}
        $viewData['item'] = $item;

        $this->render('manager/edit_item',$viewData);

    }

    public function delete_item($item_id){
        $item = $this->db->select('title')->where('id' , $item_id)->get('items')->row();
        if(is_object($item)){
            $this->db->delete('ci_items', array('id' => $item_id));
            $this->add_alert('success' , 'Item deleted successfully');
        }
        redirect(base_url('manager/items'));
    }

    public function add_item(){
        $viewData = [];
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('title', 'Title', 'required|min_length[5]|max_length[30]')
            ->set_rules('description', 'description', 'required')
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
                $this->db->insert('ci_items', $insertData);
                $this->add_alert('success' , 'Item added successfully');
                redirect(base_url('manager/items'));
            }
		}

        $this->render('manager/add_item',$viewData);

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
        
        $categories =$this->db->get('categories')->result();
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