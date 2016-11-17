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
              if($flag =='notNull')
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
                $this->form_validation->set_rules('email',"Email",'required|valid_email');


                if($this->form_validation->run() === FALSE)//invalid
                {
                    $data['title']='Register';
                    //go to the 'creat' view again
                    $this->load->view('templates/header', $data);
                    $this->load->view('user/create');

                }
                else
                {

                  //check email and phonenum are unique,if not redirect to create again
                  if($this->user_model->check_unique()==false)//not unique
                  {
                    $data['title']='Register';
                    //go to the 'creat' view again
                    $this->load->view('templates/header', $data);
                    echo'the email or phonenum has been used,please enter another one';
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
          }

          public function index()
          {
              $data['title']='All Registered users:';
              $data['table']= $this->user_model->get('0');//'0' means to get the whole tabel
              $this->load->view('templates/header', $data);
              $this->load->view('user/index',$data);
          }



          public function verify()
          {

              $this->form_validation->set_rules('email', 'Email', 'trim|required');
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
                  $data['email'] = $session_data['email'];
                  $data['id'] = $session_data['id'];
                  $user_id = $session_data['id'];
                  $location="SFU";
                  redirect("activity/index/$location/$user_id");
                  if($data['id']==1)//if logged in as admin
                  {
                    //redirect('user/index');
                    $data['title']='All Registered users:';
                    $data['table']= $this->user_model->get('0');//'0' means to get the whole tabel
                    $this->load->view('templates/header', $data);
                    $this->load->view('user/index',$data);
                  }
                }
                else
                {
                  //If no session, redirect to login page
                  redirect('user/login', 'refresh');
                }

          }





          public function view_a_user($id = '0')
          {

            if($this->session->userdata('logged_in') and $this->session->userdata('logged_in')['id']==1)
            {

              $data['contacts_item']=$this->user_model->get($id);

              //concatenate 'Contact List' ,first name and last name
              $temp_string='User: '.$data['contacts_item']['firstname'].' '.$data['contacts_item']['lastname'];
              //show item title information
              echo "<h1>".$temp_string."</h1>" ;

              //load item view page
              $this->load->view('user/view_a_user',$data);
            }

            else
            {
              redirect('user/a_user', 'refresh');
            }

          }


              function delete($id)
              {
                  if($this->session->userdata('logged_in'))
                  {
                    $this->user_model->delete($id);
                    redirect('user/a_user');
                  }
                  else
                  {
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
              $email = $this->input->post('email');

              //query the database
              $result = $this->user_model->login($email, $password);

              if($result)
              {
                $sess_array = array();
                foreach($result as $row)
                {
                  $sess_array = array(
                    'id' => $row->id,
                    'email' => $row->email
                  );
                  //session is automatically created here
                  $this->session->set_userdata('logged_in', $sess_array);
                }
                return TRUE;
              }
              else
              {
                $this->form_validation->set_message('check_database', 'Invalid email or password');
                return false;
              }
            }


            //show user information
            public function information($user_id, $view_user_id)
            {
                $data['result']=$this->user_model->get($user_id);
                $data['title']=$data['result']['firstname'].",".$data['result']['lastname'];
                $data['user_id']=$user_id;
                $data['view_user_id']=$view_user_id;
                $data['check']=$this->check_friend($user_id, $view_user_id);

                $this->load->view("templates/header",$data);
                $this->load->view("user/information",$data);
            }

            //add friend. make relationship.
            public function friend($user_id, $view_user_id)
            {
                $this->user_model->set_user_relation($user_id, $view_user_id);
                redirect("activity/index/friend/$view_user_id");
            }

            //check friend. relationship
            public function check_friend($user_id, $view_user_id)
            {
                $result=$this->user_model->check_user_relation($user_id, $view_user_id);
                return $result;
            }

            //friend List
            public function friendlist($view_user_id)
            {
                  $data['result']=$this->user_model->get_user_by_view($view_user_id);
                  $data['view_user_id']=$view_user_id;
                  $data['title']="Friend List";

                  $this->load->view("templates/header",$data);
                  $this->load->view("user/friendlist",$data);

            }
            //delete friend
            public function deletefriend($user_id,$view_user_id)
            {
                $this->user_model->delete_friend($user_id,$view_user_id);
                redirect("activity/index/deletefriend/$view_user_id");
            }

            //user account information
            public function check_information($user_id)
            {
                $data['result']=$this->user_model->get($user_id);
                $data['title']=$data['result']['firstname'].",".$data['result']['lastname'];
                $data['user_id']=$user_id;
                $this->load->view("templates/header",$data);
                $this->load->view("user/user_information",$data);

            }
            
            //edit user_information
            public function edit($user_id)
            {
                $this->user_model->edit_account($user_id);
                $this->load->view("user/edit",$data);
            }





}


?>
