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
    $this->load->model('user_model');
  }
  public function login($flag = null)
  {
    if($flag =='notNull')
    {
      echo 'Successfully registered!';
    }
    $this->load->view('user/login');
  }

  public function create()
  {
    $this->load->helper('form');
    //firstly make sure the just got form is valid or not,initial empty form is invalid
    $this->form_validation->set_rules('firstname','First Name ','required');
    $this->form_validation->set_rules('lastname','Last Name ','required');
    $this->form_validation->set_rules('password',"Password",'required');
    $this->form_validation->set_rules('email',"Email",'required|valid_email');
    $this->form_validation->set_rules('phonenum',"phonenum",'trim|callback_check_phone_number');

    if($this->form_validation->run() === FALSE)//invalid
    {
      $data['title']='Register';
      //go to the 'creat' view again
      $this->load->view('user/create',array('error' => ' ' ));
    }
    else
    {
      //check email and phonenum are unique,if not redirect to create again
      if($this->user_model->check_unique()==false)//not unique
      {
        $data['title']='Register';
        //go to the 'creat' view again
        echo'the email has been used,please enter another one';
        $this->load->view('user/create',array('error' => ' ' ));
      }
      else
      {
        $this->load->library('upload', $this->upload_config());
        if ((isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) && ! $this->upload->do_upload('userfile'))
        {
          $data['title']='Register';
          //go to the 'creat' view again
          $error = array('error' => $this->upload->display_errors());
          $this->load->view('templates/header', $data);
          $this->load->view('user/create',$error);
        }else{
          $data = array('upload_data' => $this->upload->data());
          $this->user_model->set($data['upload_data']);
          $flag='notNull';
          //go to the home page with flag!=null, to show success message
          redirect("user/login/$flag");
        }
      }
    }
  }
/*
  public function index()
  {
    $data['title']='All Registered users:';
    $data['table']= $this->user_model->get('0');//'0' means to get the whole tabel
    $this->load->view('templates/header', $data);
    $this->load->view('user/index',$data);
  }
*/
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
      if($data['id']==1)//if logged in as admin
      {
        $data['title']='All Registered users:';
        $data['table']= $this->user_model->get('0');//'0' means to get the whole tabel
        $this->load->view('templates/header', $data);
        $this->load->view('user/index',$data);
      }else{
        redirect("activity/index/$location/$user_id");
      }
    }
    else
    {
      //If no session, redirect to login page
      redirect('user/login', 'refresh');
    }
  }

  //check phone NumberFormatter
  public function check_phone_number()
  {
    $phonenum = $this->input->post('phonenum');
    if($phonenum == null)
    {
      return  true;
    }
    else
    {
      $result=preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phonenum);
      if($result)
      {
        return true;
      }
      else
      {
        $this->form_validation->set_message('check_phone_number', 'Invalid phone number');
        return false;
      }
    }
  }
/*
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
*/
  public function delete($id)
  {
    if($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['id'] == 1)
    {
      $this->user_model->delete($id);
      redirect('user/a_user');
    }
    else
    {
      redirect('user/login', 'refresh');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('logged_in');
    session_destroy();
    redirect('user/a_user', 'refresh');
  }

  //helper function for verify function
  public function check_database($password)
  {
    $encrypted_pw = md5($password);

    //Field validation succeeded.  Validate against database
    $email = $this->input->post('email');

    //query the database
    $result = $this->user_model->login($email, $encrypted_pw);

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
  public function information($user_id)
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $view_user_id = $session_data['id'];
      $data['result']=$this->user_model->get($user_id);
      $data['title']=$data['result']['firstname'].",".$data['result']['lastname'];
      $data['user_id']=$user_id;
      $data['view_user_id']=$view_user_id;
      $data['check']=$this->check_friend($user_id);
      $this->load->view("templates/header",$data);
      $this->load->view("user/information",$data);
    }else{
      redirect('user/login', 'refresh');
    }
  }

  //add friend. make relationship.
  public function friend($user_id)
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $view_user_id = $session_data['id'];
      $this->user_model->set_user_relation($user_id,$view_user_id);
      redirect("activity/index/friend/");
    }else{
      redirect('user/login', 'refresh');
    }
  }

  //check friend. relationship
  public function check_friend($user_id)
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $view_user_id = $session_data['id'];
      $result=$this->user_model->check_user_relation($user_id,$view_user_id);
      return $result;
    }else{
      redirect('user/login', 'refresh');
    }
  }

  //friend List
  public function friendlist()
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $view_user_id = $session_data['id'];
      $data['result']=$this->user_model->get_user_by_view($view_user_id);
      $data['view_user_id']=$view_user_id;
      $data['title']="Friend List";
      $this->load->view("templates/header",$data);
      $this->load->view("user/friendlist",$data);
    }else{
      redirect('user/login', 'refresh');
    }
  }

  //delete friend
  public function deletefriend($user_id)
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $view_user_id = $session_data['id'];
      $this->user_model->delete_friend($user_id,$view_user_id);
      redirect("activity/index/deletefriend/");
    }else{
      redirect('user/login', 'refresh');
    }
  }

  //user account information
  public function check_information()
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $user_id = $session_data['id'];
      $data['result']=$this->user_model->get($user_id);
      $data['title']=$data['result']['firstname'].",".$data['result']['lastname'];
      $data['user_id']=$user_id;
      $this->load->view("templates/header",$data);
      $this->load->view("user/user_information",$data);
    }else{
      redirect('user/login', 'refresh');
    }
  }

  //edit user_information
  public function edit()
  {
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $user_id = $session_data['id'];
      $data['result']=$this->user_model->get($user_id);
      $data['user_id']=$user_id;
      $this->load->helper('form',$user_id);
      //firstly make sure the just got form is valid or not,initial empty form is invalid
      $this->form_validation->set_rules('firstname','First Name ','required');
      $this->form_validation->set_rules('lastname','Last Name ','required');
      $this->form_validation->set_rules('password',"Password",'required');
      $this->form_validation->set_rules('email',"Email",'required|valid_email');
      $this->form_validation->set_rules('phonenum',"phonenum",'trim|callback_check_phone_number');

      if($this->form_validation->run() === FALSE)//invalid
      {
        $data['title']='Edit your Account';
        //go to the 'creat' view again
        $this->load->view('templates/header', $data);
        $this->load->view('user/edit',array('error' => ' ' ));
      }
      else
      {
        if($this->user_model->check_unique($user_id)==false)
        {
          $data['title']='Edit your Account';
          $this->load->view('templates/header', $data);
          echo'the email has been used,please enter another one';
          $this->load->view('user/edit',array('error' => ' ' ));
        }
        else
        {
          $this->load->library('upload', $this->upload_config());
          if ((isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) && ! $this->upload->do_upload('userfile'))
          {
            $data['title']='Edit your Account';
            //go to the 'creat' view again
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('templates/header', $data);
            $this->load->view('user/edit',$error);
          }else{
            $data = array('upload_data' => $this->upload->data());
            $this->user_model->edit_account($user_id, $data['upload_data']);
            redirect("user/checkinfor/");
          }
        }
      }
    }else{
      redirect('user/login', 'refresh');
    }
  }

  public function upload_config()
  {
    $config['upload_path']          = '/home/ubuntu/static';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 100;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;
    return $config;
  }
}
?>
