<?php


namespace App\Core\CLI\Commands;

use App\Core\CLI\CLIWriter;
use App\Core\CLI\Helpers\CliParamAnalyzer;
use App\Core\CLI\Interfaces\ICliCommand;
use App\Core\CLI\Interfaces\IWriter;
use UfoCms\ColoredCli\CliColor;

abstract class AbstractCommand implements ICliCommand
{
    const NAME = 'undefined';

    protected array $params = [];

    protected IWriter $writer;

    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        $name = static::NAME;
        if (static::NAME === self::NAME) {
            $path = explode('\\', static::class);
            $classCommandName = str_replace('Command', '', array_pop($path));
            $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $classCommandName));
        }
        return $name;
    }

    /**
     * @inheritDoc
     */
    public static function getCommandDesc(): string
    {
        return '';
    }

    protected function printVerboseInfo(): void
    {
        $this->writer = CLIWriter::getInstance();
        if (CliParamAnalyzer::isVerbose()) {
            $this->writer->setColor(CliColor::YELLOW)->writeBorder()
                ->writeLn(static::getCommandName())
                ->writeLn(static::getCommandDesc())
                ->writeBorder();
        }
    }

    protected function getParam(string|int $name): string
    {
        if (!isset($this->params[$name])) {
            throw new \InvalidArgumentException('Params ' . $name . ' is not found');
        }
        return $this->params[$name];
    }

    /**
     * @return string
     */
    abstract protected function runAction(): string;

    /**
     * @inheritDoc
     */
    public function run(array $params = []): void
    {
        $this->params = $params;
        $this->printVerboseInfo();
        $this->writer->setColor(CliColor::CYAN);
        $this->writer->writeLn($this->runAction());
    }
}
