<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
      public function __construct()
      {
                parent::__construct();
                $this->load->library('form_validation');
                $this->load->helper('url_helper');
                $this->load->helper('url');
                $this->load->helper('form');
                $this->load->model('user_model');

      }


      	  function login($flag = null)
      	  {
              if($flag !=null)
              {
                  echo 'Successfully registered!';
              }

      	    $this->load->view('user/login');
      	  }



          public function create()
          {
                //firstly make sure the just got form is valid or not,initial empty form is invalid
                $this->form_validation->set_rules('firstname','First Name ','required');
                $this->form_validation->set_rules('lastname','Last Name ','required');
                $this->form_validation->set_rules('password',"Password",'required'); 
                $this->form_validation->set_rules('email',"Email",'valid_email');
                            

                if($this->form_validation->run() === FALSE)//invalid
                {
                    $data['title']='Register';
                    //go to the 'creat' view again
                    $this->load->view('templates/header', $data);
                    $this->load->view('user/create');

                }
                else
                {
                    $this->user_model->set();
                    $flag='notNull';
                    //go to the home page with flag!=null, to show success message
                    redirect("user/login/$flag");
                }
          }




/*
          public function index($flag = null)
          {
              //$flag is used to know this is just done by a create or not
              if($flag !=null)
              {
                  echo 'A new person has been created !';
              }

              $data['title']='Contact List';
              $data['table']= $this->user_model->get('0');//'0' means to get the whole tabel
              $this->load->view('templates/header', $data);
              $this->load->view('user/index',$data);
          }

*/

          public function verify()
          {

              $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
              $this->form_validation->set_rules('password', 'Password', 'trim|callback_check_database');
            
              if($this->form_validation->run() == FALSE)
              {
                //Field validation failed.  User redirected to login page
                $this->load->view('user/login');
              }
              else
              {
                //Go to private area
                redirect('user/a_user', 'refresh');
              }

          }



          public function a_user()
          {
                if($this->session->userdata('logged_in'))
                {
                  $session_data = $this->session->userdata('logged_in');
                  $data['lastname'] = $session_data['lastname'];
                  $this->load->view('user/a_user', $data);
                }
                else
                {
                  //If no session, redirect to login page
                  redirect('user/login', 'refresh');
                }



          }


              function logout()
              {
                $this->session->unset_userdata('logged_in');
                session_destroy();
                redirect('user/a_user', 'refresh');
              }





            //helper function for verify function
            function check_database($password)
            {
              //Field validation succeeded.  Validate against database
              $lastname = $this->input->post('lastname');
              
              //query the database
              $result = $this->user_model->login($lastname, $password);
              
              if($result)
              {
                $sess_array = array();
                foreach($result as $row)
                {
                  $sess_array = array(
                    'id' => $row->id,
                    'lastname' => $row->lastname
                  );
                  //session is automatically created here
                  $this->session->set_userdata('logged_in', $sess_array);
                }
                return TRUE;
              }
              else
              {
                $this->form_validation->set_message('check_database', 'Invalid lastname or password');
                return false;
              }
            }



}


?>
