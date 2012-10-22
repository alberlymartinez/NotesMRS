<?php

class UsersController extends AppController {
    
    var $name = 'Users';
    function validate_user(){
        $user_data = array (
            'username' => $this->request->data('User.username'),
            'password' => md5($this->request->data('User.password'))
        );
        if($this->request->is('post')) {
            if($this->User->save($user_data)) {             
                $this->Session->write('username', $this->request->data('User.username'));
                $this->redirect(array('action'=>'members_area'));
            } else {
                $this->Session->setFlash('The post was not saved, please try again');
            }
        }
    }
    
    function members_area(){
    }
    
    function send_new_password () {        
        App::uses('CakeEmail', 'Network/Email');
        $newpass = substr( str_shuffle( 
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$') 
             , 0 , 10 ); 
        $email = new CakeEmail('gmail');
        $email->from('danieluchin@gmail.com');
        $email->to('danieluchin@gmail.com');
        $email->subject('About');
        $email->send($newpass);
    }
} 
