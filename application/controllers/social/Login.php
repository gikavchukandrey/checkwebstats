<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login  extends MY_Controller {
	

	function __construct()
    {    
         
        parent::__construct();     
    
    }   

    public function local()
    {   
       
          
            if(validateCaptcha($this->input->post("g-recaptcha-response")))
            {                 
                $this->load->helper('email');
                $email      = trim($this->input->post("email"));
                if(valid_email($email))
                {
                    $password   = $this->input->post("password");
                    $user       = $this->Admin->getTable("users",array("email" => $email,"password" => sha1($password)));
                    if($user->num_rows() == 1)
                    {
                        $data_user = $user->row_array();
                        if($data_user['validation'])
                        {
                            $this->sendValidation($data_user['email'],$data_user['validation']);
                            $this->session->set_flashdata('login_error', __("Your account requires a verification, please check your email inbox and follow the steps"));
                            redirect(base_url().config_item("slug_login"),'location');
                            exit;   
                        }
                        else
                        {
                            $this->session->set_userdata("user",$data_user);
                            //redirect(base_url(),'location');
                            setLoggedUserCookie();
                            redirect2refer();
                            exit;    
                        }
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('login_error', __("Incorrect Email or Password"));
                        redirect(base_url().config_item("slug_login"),'location');
                        exit;  
                    }
                }
                else
                {
                    $this->session->set_flashdata('login_error', __("Incorrect Email or Password"));
                    redirect(base_url().config_item("slug_login"),'location');
                    exit;
                }
            }
            else
            {

                $this->session->set_flashdata('login_error', __("Captcha Error"));
                redirect(base_url().config_item("slug_login"),'location');
                exit;       
            }       


    }

    public function register()
    {
        if(validateCaptcha($this->input->post("g-recaptcha-response")))
        {   
            $this->load->helper('email');
            $names      = $this->input->post("names",TRUE);
            $password   = $this->input->post("password",TRUE);
            $password2  = $this->input->post("password-r",TRUE);
            $email      = $this->input->post("email",TRUE);
            if(valid_email($email))
            {
                if($password == $password2)
                {
                    if(strlen($password) >=5)
                    {
                        $user       = $this->Admin->getTable("users",array("email" => $email));
                        if($user->num_rows() == 0)
                        {
                            $this->load->helper('string');
                            $save               = array();
                            $save['names']      = $names;
                            $save['email']      = $email;
                            $save['username']   = $email;
                            $save['password']   = sha1($password);
                            $save['validation'] = random_string('alnum',32);
                            $this->Admin->setTable("users",$save);

                            $this->sendValidation($save['email'],$save['validation']);
                            sendNotificationNewUser($save['names'],$save['email']);
                            
                            if(config_item("validate_email") == '1')
                            {
                                $this->session->set_flashdata('register_message', __("Your account requires a verification, please check your email inbox and follow the steps"));
                                redirect(base_url().config_item("slug_register"),'location');
                                
                            }
                            else
                            {
                                $this->session->set_flashdata('register_message', __("Your account requires a verification, please check your email inbox and follow the steps"));                                
                                $link = base_url().config_item("slug_register")."?v=".$save['validation'];
                                redirect($link,'location');
                            }                            
                            
                            exit;   
                        }
                        else
                        {
                            $this->session->set_flashdata('register_error', __("The email already taken"));
                            redirect(base_url().config_item("slug_register"),'location');
                            exit;  
                        }

                    }
                    else
                    {
                        $this->session->set_flashdata('register_error', __("The password length is very short, please add more than 5 characters"));
                        redirect(base_url().config_item("slug_register"),'location');
                        exit;  

                    }

                }
                else
                {
                    $this->session->set_flashdata('register_error', __("Password doesn't match"));
                    redirect(base_url().config_item("slug_register"),'location');
                    exit;  

                }

            }
            else
            {
                $this->session->set_flashdata('register_error', __("The Email is not valid"));
                redirect(base_url().config_item("slug_register"),'location');
                exit;  
            }

        }
        else
        {
            $this->session->set_flashdata('register_error', __("Captcha Error"));
            redirect(base_url().config_item("slug_register"),'location');
            exit;   

        }

    }

    public function recovery()
    {

        if($this->input->get("v"))
        {
            $code =  trim(_clean_special($this->input->get("v")));

            if(strlen($code) == 40)
            {
                $user       = $this->Admin->getTable("users",array("recovery" => $code));
                if($user->num_rows() == 1)
                {
                    $data_user = $user->row_array();
                    $this->Admin->updateTable("users",array("password" => $data_user['recovery'],"recovery" => ''),array("email" => $data_user['email']));
                    $this->session->set_flashdata('login_message', __("Your new password has been activated successfully"));
                    redirect(base_url().config_item("slug_login"),'location');
                    exit;   
                }
                else
                {
                    $this->session->set_flashdata('recovery_error', __("The link is not valid or has expired"));
                    redirect(base_url().config_item("slug_login")."?r=1",'location');
                    exit;  
                }
            }
            else
            {
                $this->session->set_flashdata('recovery_error', __("The link is not valid or has expired"));
                redirect(base_url().config_item("slug_login")."?r=1",'location');
                exit;  
            }

        }

        if(validateCaptcha($this->input->post("g-recaptcha-response")))
        {   
            $this->load->helper('email');        
            $email      = $this->input->post("email",TRUE);
            if(valid_email($email))
            {
                $user       = $this->Admin->getTable("users",array("email" => $email));
                if($user->num_rows() == 1)
                {
                    $this->load->helper('string');
                    $new_password       = random_string('alnum',8);
                    $save['recovery']   = sha1($new_password);

                    $this->Admin->updateTable("users",array("recovery" => $save['recovery']),array("email" => $email));


                    $link = base_url()."auth/login/recovery?v=".$save['recovery'];
                    $message    = __("Hello");
                    $message    .= "<br>";
                    $message    .= "<br>";        
                    $message    .= __("Your new password is: ");
                    $message    .= "<strong>$new_password</strong>";        
                    $message    .= "<br>";        
                    $message    .= "<br>";        
                    $message    .= __("Please click the link below to activate the new password.");
                    $message    .= "<br>";
                    $message    .= "<br>";
                    $message    .= "<a href='$link'>$link</a>";
                    $message    .= "<br>";
                    $message    .= "<br>";
                    $message    .= __("Note: If you didn't initiate this request, please ignore this email.");
                    $message    .= "<br>";
                    $message    .= "<br>";
                    $message    .= config_item("site_title");
                    email($email,__("Recovery Password"),$message);

                    $this->session->set_flashdata('recovery_message', __("The new password has been sent to your email, please check and follow the steps"));
                    redirect(base_url().config_item("slug_login")."?r=1",'location');


                }
                else
                {
                    $this->session->set_flashdata('recovery_error', __("The user was not found"));
                    redirect(base_url().config_item("slug_login")."?r=1",'location');
                    exit;
                    
                }
            }
            else
            {
                $this->session->set_flashdata('recovery_error', __("The Email is not valid"));
                redirect(base_url().config_item("slug_login")."?r=1",'location');
                exit;  
            }
        } 
        else
        {
            $this->session->set_flashdata('recovery_error', __("Captcha Error"));
            redirect(base_url().config_item("slug_login")."?r=1",'location');
            exit;   

        }
    }

    protected function sendValidation($email,$code)
    {
        $link = base_url().config_item("slug_register")."?v=$code";
        $message    = __("Hello");
        $message    .= "<br>";
        $message    .= "<br>";        
        $message    .= __("Please click the link below to verify your email address for your account.");
        $message    .= "<br>";
        $message    .= "<br>";
        $message    .= "<a href='$link'>$link</a>";
        $message    .= "<br>";
        $message    .= "<br>";
        $message    .= __("Note: If you didn't initiate this request, please ignore this email.");
        $message    .= "<br>";
        $message    .= "<br>";
        $message    .= config_item("site_title");
        email($email,__("Account Verification"),$message);
    }
}