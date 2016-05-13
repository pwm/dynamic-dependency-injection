<?php namespace App\FeedReader\Strategies;

use App\FeedReader\FeedReaderInterface;

/**
 * @author Zsolt Szende <pwmosuito@gmail.com>
 */
class JsonFeedReader implements FeedReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($url)
    {
        return sprintf('reading JSON data from %s ...', $url);
    }
}
