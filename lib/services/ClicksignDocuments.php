<?php
require_once(__DIR__ . '/../ClicksignClient.php');
require_once(__DIR__ . '/../ClicksignService.php');
require_once(__DIR__ . '/../models/ClicksignDocument.php');
    
class ClicksignDocuments extends ClicksignService
{

    public function all()
    {
        return $this->client->request("/documents", "GET", array(), 200, "ClicksignDocument");
    }

    public function find($documentKey)
    {
        return $this->client->request("/documents/$documentKey", "GET", array(), 200, "ClicksignDocument");
    }

    public function upload($filePath)
	{
        $data = array("document[archive][original]" => "@$filePath");
        return $this->client->request("/documents", "FILE", $data, 201, "", "multipart/mixed; boundary=frontier");
	}

    public function createList($documentKey, $signers, $message = "", $skipEmail = false)
    {
        $data = array("signers" => $signers, "message" => $message, "skip_email" => $skipEmail);
        $json = json_encode($data);
        return $this->client->request("/documents/$documentKey/list", "POST", $json, 200, "", "application/json");
    }
    
}