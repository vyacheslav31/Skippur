<?php

    class HomeController extends Controller
    {
        public function index($name = '')
        {
            $user = $this->model('User');
            $users = $user->All();
            $this->view('home/index', ['users' => $users]);
        }

        public function login()
        {
            $errorMessage = '';
            $user = '';
            if(isset($_POST['action'])){
                //login logic
                $username = $_POST['username'];
                $password = $_POST['password'];
                if(isset($_POST['user_type'])){
                    $user_type = $_POST['user_type'];
                    $user = $this->model('User')->getUser($username);
                    if($user!=null && $user_type == $user->user_type && password_verify($password, $user->password_hash)){
                        $_SESSION['user_id'] = $user->user_id;
                        if($user_type == 'Site')
                            header('location:/Site/calender');
                        //if user is a site :- 
                        //if user is a customer :- header('location:/Home/Customer')
                        //header('location:/Home/Secure');
                    }
                    else{
                        $errorMessage = 'INVALID USERNAME AND/OR PASSWORD ';
                
                         $this->view('home/login', ['errorMessage' => $errorMessage]);
                }
                }
                else{
                    $errorMessage = 'ARE YOU A BUSINESS OWNER OR A CUSTOMER?';
                    $this->view('home/login', ['errorMessage' => $errorMessage]);
                }
                
                
               
            }else{
                $this->view('home/login', ['errorMessage'=> $errorMessage]);
            }
        }

        public function Secure(){
            if(!isset($_SESSION['user_id']) || $_SESSION['user_id']==null)
                return header('location:/Home/Login');
            echo "This is secure!<a href='/Home/Logout'>Logout!!</a>";
        }

        public function Logout(){
            session_destroy();
            header('location:/Home/Login');
        }

        public function register()
        {

            if(isset($_POST['action'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $user_type = $_POST['user_type'];
                $password_confirmation = $_POST['password_confirmation'];


                if($password == $password_confirmation & isset($_POST['user_type'])){
                    $user = $this->model('User');
                    $user->username = $username;
                    $user->password_hash = password_hash($password, PASSWORD_DEFAULT);//
                    $user->user_type = $user_type;
                    $user->insert();//

                    $user = $this->model('User')->getUser($username);

                    $_SESSION['user_id'] = $user->user_id;
                    //RedirectToAction
                    if($user_type == 'Customer')
                        header('location:/Customer/Register');
                    elseif ($user_type == 'Site')
                        header('location:/Site/Register');
                        # code...
                    
                    //header('location:/Home/Login');
                }else{
                    //provide an error message

                }
            }else{
                $this->view('home/register');
            }
        }


        public function output($name = '')
        {
           $user = $this->model('User');
           $user->name = $name;
           $this->view('home/indexJSON', ['name' => $user->name]);
        }

        public function employeeLogin(){
            $errorMessage = '';
            $sites = $this->model('Site')->getAllBusinessNames();
            if(isset($_POST['action'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                if($_POST['Site'] != 'CHOOSE YOUR EMPLOYER'){
                    $site_name = $_POST['Site'];
                    $employee = $this->model('Employee')->getUser($username);
                    $site_id = $this->model('Site')->getSiteId($site_name)->site_id;
                    if($employee != null){
                        if(password_verify($password, $employee->employee_password) && $employee->site_id == $site_id){
                            $image= $this->model('Picture')->getPicture($employee->picture_id);
                            $_SESSION['employee_id'] = $employee->employee_id;
                            $this->view('employee/employeeProfile', ['employee'=>$employee, 'image'=>$image, 'site_name'=>$site_name]);
                        }
                    } 
                    else{
                        $errorMessage = 'ENTER A VALID USERNAME AND/OR PASSWORD COMBINATION';
                        $this->view('home/employee_login', ['sites'=>$sites, 'errorMessage' => $errorMessage]);
                    }
                }
                
                else{
                    $errorMessage =  'YOU HAVE NOT SELECTED AN EMPLOYER';
                    $this->view('home/employee_login', ['sites'=>$sites, 'errorMessage' => $errorMessage]);
                }
            }
            else
                $this->view('home/employee_login', ['sites'=>$sites, 'errorMessage' => $errorMessage]);
        }
        
    }

?>