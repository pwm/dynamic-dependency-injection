<?php namespace App\FeedReader;

/**
 * @author Zsolt Szende <szendezs@gmail.com>
 */
interface FeedReaderInterface
{
    /**
     * @param string $url
     */
    public function read($url);
}
