<?php namespace App\FeedReader;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Console\Exception\LogicException;

/**
 * @author Zsolt Szende <pwmosquito@gmail.com>
 */
class FeedReaderProvider implements ServiceProviderInterface
{
    /**
     * A map of keys and corresponding reader strategy classes
     *
     * @var array
     */
    private static $readerStrategyMap = [
        'json' => Strategies\JsonFeedReader::class,
        'xml'  => Strategies\XmlFeedReader::class,
        'csv'  => Strategies\CsvFeedReader::class,
    ];


    /**
     * This is the crux of dynamic dependency injection. We are registering
     * FeedReaderCommand in the container, but we cannot inject its dependency
     * as it is only decided at runtime via a user supplied parameter. This
     * parameter is a key from $readerStrategyMap. Instead we inject a lambda function
     * which expects the key. This will then be executed from FeedReaderCommand
     * once the key is supplied and it resolves the corresponding reader strategy.
     * Note that the lambda function could be extracted into its own factory class,
     * which could then be injected, however this way arguably creates less clutter.
     *
     * @param Container $container
     * @throws \RuntimeException
     * @throws LogicException
     */
    public function register(Container $container)
    {
        $container[FeedReaderCommand::class] = function () {
            return new FeedReaderCommand(function ($readerStrategy) {
                if (! array_key_exists($readerStrategy, self::$readerStrategyMap)) {
                    throw new \RuntimeException(sprintf(
                        '%s is not a valid reader. Available readers are: %s',
                        $readerStrategy,
                        implode(', ', array_keys(self::$readerStrategyMap))
                    ));
                }
                return new self::$readerStrategyMap[$readerStrategy]();
            });
        };
    }
}
