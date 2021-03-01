<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $userData;

    public function __construct(){
        parent::__construct();
        $this->userData = $this->session->userdata();

    }

	
	public function index($category_id = 0)
	{ 
        $viewData = [];
        $search = $this->input->get('search');
        $start = (int)$this->input->get('per_page');
        $limit = $this->config->item('per_page');
        $where = [];

        if($search){
            $where['title LIKE'] = '%' . $search . '%'; 
        }
        if($category_id){
            $where['category_id'] = (int)$category_id;
        }

        $viewData['items'] = $this->db->where($where)->limit($limit, $start)->get('items')->result();
        $this->pagination->initialize([
            'base_url'   => base_url() . ($category_id ? 'category/'.$category_id : '') . ($search ? '?search='.$search : '') ,
            'total_rows' => $this->db->where($where)->count_all_results('items'),

        ]);
        
        $viewData['pagination'] =  $this->pagination->create_links();
        
        $this->render('home',$viewData);
    	}

    public function logout(){
        
    }

    
    public function login(){
        $viewData = [];
        $this->load->helper('form');
        $this->load->library('form_validation');
    
        $this->form_validation
            ->set_rules('email', 'Email', 'required|trim|valid_email')
            ->set_rules('password', 'Password', 'required|trim');

        $this->render('login',$viewData);
        }


    public function register(){
        $viewData = [];
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]')
            ->set_rules('first_name', 'First name', 'required|trim|min_length[2]|max_length[15]')
            ->set_rules('last_name', 'Last name', 'required|trim|min_length[2]|max_length[15]')
            ->set_rules('password', 'Password', 'required|trim|min_length[5]|max_length[15]')
            ->set_rules('passconf', 'Password Confirm', 'required|trim|matches[password]');

        if ($this->form_validation->run()){
            $data = [
                'email' => $this->input->post('email'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'password' => md5(sha1($this->input->post('password')))
            ];
            $insert = $this->db->insert('users',$data);
            if($insert){
                $newdata = [
                    'logged'  => true,
                    'user_id' => $this->db->insert_id(),
                    'email'   => $data['email'],
                    'first_name'=>$data['first_name'],
                    'last_name'=>$data['last_name']
                ];
                $this->session->set_userdata($newdata);
                $viewData['success'] = true;
            }
        }


        $this->render('register',$viewData);

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
		}

       
        $this->render('add_category' , $viewData);
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
            }
		}

        $this->render('add_item',$viewData);

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

    private function render($page , $data = []){
        
        $categories =$this->db->get('categories')->result();
        $headerData = [
            'categories'  => $categories,
            'user'        => $this->userData
        ];
        
        $this->load->view('display/header', $headerData );
        $this->load->view($page,$data);
        $this->load->view('display/footer');
    }
}
?>