<?php
App::uses('Google_Client', 'GoogleAPI/google-api-php-client/src');
App::uses('Google_DriveService', 'GoogleAPI/google-api-php-client/src/contrib');
const REDIRECT_URL = 'http://localhost/NotesMRS/notas/permitir_acceso';
const CLIENT_ID = '1086730025226-p05b6kd1hq365tc6a91g94vskkemfc2n.apps.googleusercontent.com';
const CLIENT_SECRET = 'Zpyw97AkHgLTgjMV9C-pWIPs';

class NotasController extends AppController {
    var $name = 'Notas';
    private $client;
    private $service;
    
    function index() {
        $this->Session->write('client_id', CLIENT_ID);
        $this->Session->write('client_secret', CLIENT_SECRET);
        $this->Session->write('redirect_url', REDIRECT_URL);
    }
    
    function inicializar_cliente(){
        $this->client = new Google_Client();
        // Get your credentials from the APIs Console
        $this->client->setClientId(CLIENT_ID);
        $this->client->setClientSecret(CLIENT_SECRET);
        $this->client->setRedirectUri(REDIRECT_URL);
        $this->client->setScopes(array('https://www.googleapis.com/auth/drive'));
        
    }
    
    function generar_servicio(){
        
        $this->inicializar_cliente();

        $this->service = new Google_DriveService($this->client);

        $authUrl = $this->client->createAuthUrl();
        
        $this->redirect($authUrl);
    }
    
    function permitir_acceso(){
        $authCode = $_GET['code'];
        
        $this->inicializar_cliente();
        $this->service = new Google_DriveService($this->client);
        
       // Exchange authorization code for access token
        $accessToken = $this->client->authenticate($authCode);
        $this->client->setAccessToken($accessToken);
        $this->Session->write('token', $accessToken);
        $this->subir_archivo();
    }
    
    function subir_archivo(){
        
        //Insert a file
        $file = new Google_DriveFile();
        $file->setTitle('My document');
        $file->setDescription('A test document');
        $file->setMimeType('text/plain');

        $data = file_get_contents('http://localhost/NotesMRS/files/document.txt');

        $createdFile = $this->service->files->insert($file, array(
            'data' => $data,
            'mimeType' => 'text/plain',
        ));
        
    }
    
    function acceso_permitido(){
        
    }
}