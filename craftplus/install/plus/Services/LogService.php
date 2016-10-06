<?php 
namespace CraftPlus\Services;

use Craft;
use function Craft\craft;

class LogService
{
    public function write($key, $data)
    {
        $requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        if (gettype($data) != 'string') {
            $data = print_r($data, true);
        }

        $logRecord                        = new Craft\CraftPlus_LogRecord();
        $logRecord->key                   = $key;
        $logRecord->data                  = $data;
        $logRecord->request_uri           = $requestUri;
        $logRecord->referer               = $referer;
        $logRecord->ip_address            = $ipAddress;
        $logRecord->user_agent            = $userAgent;

        return $logRecord->save();
    }
}