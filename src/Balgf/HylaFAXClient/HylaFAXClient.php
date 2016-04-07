<?php namespace Balgf\HylafaxClient;

use Symfony\Component\Process\Process;


class HylaFAXClient
{

    var $host;
    var $response;

    public function executeCommand($command)
    {
        $process = new Process($this->buildCommand($command));
        $process->run();
        if ($process->isSuccessful()) {
            $this->response = trim($process->getOutput());
            return $this;
        } else {
            throw new Exception($process->getErrorOutput());
        }
    }


    public function buildCommand($command)
    {
        if (!empty($this->host)) {
            $command[0] = $command[0] . " -h '{$this->host}'";
        }
        return implode(' ', $command);
    }


    public function toArray()
    {
        $output = preg_split("/\r\n|\n|\r/", $this->response);
        return $output;
    }


    public function getJobID()
    {
        if (preg_match("/\d{1,}/", $this->response, $output_array)) {
            return $output_array[0];
        } else {
            return false;
        }
    }


    public function getJobIDs()
    {
        $job_ids = [];
        foreach (explode(PHP_EOL, $this->response) as $line) {
            if (preg_match("/\d{1,}/", $line, $output_array)) {
                $job_ids[] = $output_array[0];
            }
        }
        return $job_ids;
    }


    public function getJobStatus()
    {
        $response_arr = preg_split("/ \d{1,}\:\d{1,}/", $this->response);
        return end($response_arr);
    }


}