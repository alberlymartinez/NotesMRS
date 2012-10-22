<h2>Iniciar Sesión</h2>
<?php
echo $this->Form->create('User', array('action'=>'validate_user'));
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Login');
echo $this->Html->link('Olvidó su contraseña?', array('action'=>'send_new_password'));
?>