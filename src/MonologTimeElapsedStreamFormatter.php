<?php

namespace LongTailVentures;

class MonologTimeElapsedStreamFormatter implements \Monolog\Formatter\FormatterInterface
{
    private $_startTime;


    public function format(array $record)
    {
        if (is_null($this->_startTime))
            $this->_startTime = microtime(true);

        $difference = microtime(true) - $this->_startTime;
        $runningTime = $this->_formatMilliseconds($difference * 1000);

        $message = null;
        if (isset($record['message']))
            $message = $record['message'];

        return "[" . $record['datetime']->format('Y-m-d H:i:s') . " - $runningTime] $message" . PHP_EOL;
    }


    public function formatBatch(array $records)
    {
        $formatted = [];

        foreach ($records as $record) {
            $formatted[] = $this->format($record);
        }

        return $formatted;
    }


    private function _formatMilliseconds($milliseconds)
    {
        // re: https://bytes.com/topic/php/answers/600455-milliseconds-hh-mm-ss
        $sec = '00';
        $seconds= $milliseconds/1000;
        //for seconds
        if( $seconds> 0)
        {
            $sec= "" . ($seconds%60);

            if ($seconds % 60 <10)
            {
                $sec= "0" . ($seconds%60);
            }
        }

        //for mins
        if ($seconds > 60)
        {
            $mins= "". ($seconds/60%60);
            if (($seconds/60%60)<10)
            {
                $mins= "0" . ($seconds/60%60);
            }
        }
        else
        {
            $mins= "00";
        }

        //for hours
        if($seconds/60 > 60)
        {
            $hours= "". round($seconds/60/60);
            if(($seconds/60/60) < 10)
            {
                $hours= "0" . round($seconds/60/60);
            }
        }
        else
        {
            $hours= "00";
        }

        return $time_format= "" . $hours . ":" . $mins . ":" . $sec; //00:15:00
    }
}
