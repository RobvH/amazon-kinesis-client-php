<?php

namespace Robvh\Kcl\Io;

use Robvh\Kcl\Actions\Action;

class IoHandler
{
    /**
     * @var Readable
     */
    private $input;
    /**
     * @var Writable
     */
    private $output;
    /**
     * @var Writable
     */
    private $error;

    /**
     * IoHandler constructor.
     *
     * @param resource $input
     * @param resource $output
     * @param resource $error
     */
    public function __construct($input = null, $output = null, $error = null)
    {
        $this->assertResource([$input, $output, $error]);

        $this->input = new InputStream($input ?? STDIN);
        $this->output = new OutputStream($output ?? STDOUT);
        $this->error = new OutputStream($error ?? STDERR);
    }

    public function writeAction(Action $action)
    {
        $this->output->writeLine((string) $action);
    }

    public function readAction(): Action
    {
        $message = $this->input->readLine();

        if (is_null($message)) {
            // todo: convert to NullAction
            return null;
        }

        return Action::parse($message);
    }

    public function writeError(string $message, \Exception $e)
    {
        $this->error->writeLine($message);
        $this->error->writeLine($e->getTraceAsString());
    }

    private function assertResource($argument)
    {
        $arguments = is_array($argument) ? $argument : [$argument];

        foreach ($arguments as $argument) {
            if (false === is_resource($argument) && false === is_null($argument)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'If supplied, argument must be a valid resource type. %s given.',
                        gettype($argument)
                    )
                );
            }
        }
    }
}
