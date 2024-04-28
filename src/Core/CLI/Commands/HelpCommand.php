<?php


namespace App\Core\CLI\Commands;

use App\Core\CLI\Interfaces\ICliCommand;

class HelpCommand extends AbstractCommand
{
    /**
     * @var ICliCommand[]
     */
    protected array $allowedCommands = [];

    /**
     * HelpCommand constructor.
     * @param array $allowedCommands
     */
    public function __construct(array $allowedCommands = [])
    {
        $this->allowedCommands[] = $this;
        $this->allowedCommands = array_merge($this->allowedCommands, $allowedCommands);
    }

    /**
     * @return string
     */
    public static function getCommandDesc(): string
    {
        return 'Print help message';
    }

    /**
     * @return string
     */
    protected function runAction(): string
    {
        $this->writer->writeLn("Allowed commands:");
        $res = [];
        /**
         * @var ICliCommand $command
         */
        foreach ($this->allowedCommands as $command) {
            $res[] = $command::getCommandName() . ' - ' . $command::getCommandDesc();
        }
        return implode(PHP_EOL, $res);
    }
}
