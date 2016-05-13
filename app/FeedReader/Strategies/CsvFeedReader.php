<?php namespace App\FeedReader\Strategies;

use App\FeedReader\FeedReaderInterface;

/**
 * @author Zsolt Szende <pwmosuito@gmail.com>
 */
class CsvFeedReader implements FeedReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($url)
    {
        return sprintf('reading CSV data from %s ...', $url);
    }
}
