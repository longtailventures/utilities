<?php

namespace LongTailVentures;

class GraphiteClient
{
    private $_host, $_post;

    /**
     * constructor
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port)
    {
        $this->_host = $host;
        $this->_port = $port;
    }


    /**
     * Log timer value to graphite
     * @param string $metric The metric to log the time value for
     * @param float $time Time value (in ms)
     * @param float|1 $sampleRate The rate data is being sampled (0-1)
     */
    public function timing($metric, $time, $sampleRate = 1)
    {
        $this->_send(array($metric => "$time|ms"), $sampleRate);
    }

    /**
     * Log microtime timer value to graphite
     * @param string $metric The metric to log the time value for
     * @param float $startTime Value obtained using microtime(true)
     * @param float $endTime Value obtained using microtime(true)
     * @param float|1 $sampleRate The rate data is being sampled (0-1)
     */
    public function timingMicro($metric, $startTime, $endTime, $sampleRate = 1)
    {
        $convertedTime = sprintf('%.5f', $endTime - $startTime);
        $this->timing($metric, $convertedTime*1000, $sampleRate);
    }

    /**
     * Update one or more stats counters by an arbitray amount
     * @param string|array $metric The metric(s) to update; either a string or array of strings
     * @param int|1 $change The amount to increment/decrement each metric by
     * @param float|1 $sampleRate The rate data is being sampled (0-1)
     */
    public function counter($metric, $change, $sampleRate = 1)
    {
        if (!is_array($metric))
            $metric = array($metric);

        $data = array();
        foreach ($metric as $item)
        {
            $data[$item] = "$change|c";
        }

        $this->_send($data, $sampleRate);
    }

    public function sendTiming($metric, $value, $notes = '', $function = '', $sampleRate = 1)
    {
        if ($sampleRate < 1)
        {
            if ((mt_rand() / mt_getrandmax()) > $sampleRate)
                return;
        }

        try
        {
            $fp = fsockopen("udp://" . self::$_host, self::$_port, $errno, $errstr);
            if (!$fp)
                return;
            $notes = base64_encode($notes);
            if (strlen($notes) > 7900)
                $notes = substr($notes, 0, 7900);
            fwrite($fp, "t|" . time() . "|" . $metric . "|" . $value . "|" . $notes . "|" . $function . "\n");
            fclose($fp);
        }
        catch (Exception $e)
        {
        }
    }

    public static function sendCounter($metric, $value, $sampleRate = 1)
    {
        if ($sampleRate < 1)
        {
            if ((mt_rand() / mt_getrandmax()) > $sampleRate)
                return;
        }

        try
        {
            $fp = fsockopen("udp://" . self::$_host, self::$_port, $errno, $errstr);
            if (!$fp)
                return;

            fwrite($fp, "c|" . time() . "|" . $metric . "|" . $value . "\n");
            fclose($fp);
        }
        catch (Exception $e)
        {
        }
    }

    /**
     * Send the metrics over UDP to graphite/statsd server
     * @param array $data array of timers/counters to send
     * @param float $sampleRate The rate data is being sampled
     */
    private static function _send($data, $sampleRate)
    {
        $sampledData = array();

        if ($sampleRate < 1)
        {
            foreach ($data as $stat => $value)
            {
                if ((mt_rand() / mt_getrandmax()) <= $sampleRate)
                    $sampledData[$stat] = "$value|@$sampleRate";
            }
        }
        else
        {
            $sampledData = $data;
        }

        if (empty($sampledData))
            return;

        try
        {
            $fp = fsockopen("udp://" . self::$_host, self::$_port, $errno, $errstr);
            if (!$fp)
                return;
            foreach ($sampledData as $stat => $value)
                fwrite($fp, "$stat:$value");
            fclose($fp);
        }
        catch (Exception $e)
        {
        }
    }
}
