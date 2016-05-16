<?php namespace App\FeedReader;

/**
 * @author Zsolt Szende <pwmosquito@gmail.com>
 */
interface FeedReaderInterface
{
    /**
     * @param string $url
     */
    public function read($url);
}
