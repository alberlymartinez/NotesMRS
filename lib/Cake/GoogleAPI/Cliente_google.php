<?php
App::uses('Google_Client', 'GoogleAPI/google-api-php-client/src');
App::uses('Google_DriveService', 'GoogleAPI/google-api-php-client/src/contrib');


class Cliente_google {

    private $client;
    private $token;
    private $codigo_activacion = true;

    function Cliente_google() {    
        $this->client = new Google_Client();
        $this->client->setClientId('1086730025226-p05b6kd1hq365tc6a91g94vskkemfc2n.apps.googleusercontent.com');
        $this->client->setClientSecret('Zpyw97AkHgLTgjMV9C-pWIPs');
        $this->client->setRedirectUri('http://localhost/NotesMRS/notas/permitir_acceso');
        $this->client->setScopes(array('https://www.googleapis.com/auth/drive'));
        
    }
    
    function set_codigo_activacion($valor){
        $this->codigo_activacion = $valor;
    }
    
    function set_token($valor){
        $this->token = $valor;
        $this->set_codigo_activacion(false);
    }
    
    function obtener_datos_cliente(){
        $datos_cliente = array (
            'client_id' => $this->client->getClientId(),
            'client_secret' => $this->client->getClientSecret(),
            'redirect_url' => $this->client->getRedirectUri(),
            'token' => $this->client->getAccessToken(),
          
        );
        return $datos_cliente;
    }

    function generar_servicio() {       

        $service = new Google_DriveService($this->client);

        $authUrl = $this->client->createAuthUrl();
        
        //Request authorization
        print "Please visit:\n$authUrl\n\n";
        print "Please enter the auth code:\n";
        return $authUrl;
        // Exchange authorization code for access token
        //$accessToken = $this->client->authenticate($authCode);
        //$this->client->setAccessToken($accessToken);
    }

}