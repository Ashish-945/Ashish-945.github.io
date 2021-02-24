<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
	public function index()
	{ 
        $viewData = [];
        $viewData['items'] = $this->db->get('items')->result();
        $this->load->view('display/header');
        $this->load->view('home',$viewData);
        $this->load->view('display/footer');
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

        $this->load->view('display/header');
        $this->load->view('add_item',$viewData);
        $this->load->view('display/footer');

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
}
?>