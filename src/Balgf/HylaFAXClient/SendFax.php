<?php namespace Balgf\HylafaxClient;



class SendFax extends HylaFAXClient
{

    var $command = [
        'command' => 'sendfax',
        'maxdials' => 0,
        'coverpage' => FALSE,
        'destination' => [],
        'document_path' => '',
    ];

    public function __construct()
    {
    }

    public function setDocumentPath($document_path)
    {
        
    }

    public function exec()
    {
        $this->executeCommand();
    }

}