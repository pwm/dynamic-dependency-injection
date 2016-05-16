<?php namespace App\FeedReader;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Zsolt Szende <pwmosquito@gmail.com>
 */
class FeedReaderCommand extends Command
{
    /**
     * Stores the closure that, when executed, returns the reader strategy
     *
     * @var \Closure
     */
    private $readerStrategyResolver;

    /**
     * The resolved reader strategy. Assigned by setter injection, because
     * we will only have access to the requested strategy in execute()
     *
     * @var FeedReaderInterface
     */
    private $feedReader;


    /**
     * @param \Closure $readerStrategyResolver
     * @throws LogicException
     */
    public function __construct(\Closure $readerStrategyResolver)
    {
        parent::__construct();
        $this->readerStrategyResolver = $readerStrategyResolver;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('feed-reader')
            ->setDescription('This command processes 3rd party data feeds. Well, it simulates it anyway :).')
            ->addArgument('feedType', InputArgument::REQUIRED, 'The type of the feed.')
            ->addArgument('feedUrl', InputArgument::REQUIRED, 'The url of the feed.');
    }

    /**
     * Resolve the requested feed reader by executing readerStrategyResolver()
     * and passing its return value into setFeedReader(). This also enables us
     * type checking in the setter.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setFeedReader(call_user_func(
            $this->readerStrategyResolver,
            $input->getArgument('feedType')
        ));

        $output->writeln($this->feedReader->read($input->getArgument('feedUrl')));
    }

    /**
     * @param FeedReaderInterface $feedReader
     */
    private function setFeedReader(FeedReaderInterface $feedReader)
    {
        $this->feedReader = $feedReader;
    }
}
