<?php namespace App\FeedReader;

/**
 * @author Zsolt Szende <pwmosuito@gmail.com>
 */
interface FeedReaderInterface
{
    /**
     * @param string $url
     */
    public function read($url);
}
