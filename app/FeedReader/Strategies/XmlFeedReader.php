<?php namespace App\FeedReader\Strategies;

use App\FeedReader\FeedReaderInterface;

/**
 * @author Zsolt Szende <pwmosuito@gmail.com>
 */
class XmlFeedReader implements FeedReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($url)
    {
        return sprintf('reading XML data from %s ...', $url);
    }
}
