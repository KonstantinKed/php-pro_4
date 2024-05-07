<?php


namespace App\Core\CLI;

use App\Core\CLI\Interfaces\IWriter;
use App\Core\Interfaces\ISingleton;
use App\Core\Traits\Singletonable;
use UfoCms\ColoredCli\CliColor;

class CLIWriter implements IWriter, ISingleton
{
    use Singletonable;

    protected CliColor $color;

    public function setColor(CliColor $color): self
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function writeBorder(int $length = self::BORDER_LENGTH): self
    {
        return $this->writeLn(str_repeat('*', $length));
    }

    /**
     * @inheritDoc
     */
    public function writeLn(string $msg): self
    {
        return $this->write($msg, true);
    }

    /**
     * @inheritDoc
     */
    public function write(string $msg, bool $endLine = false): self
    {
        echo $this->color->value . $msg . ($endLine ? PHP_EOL : '') . CliColor::RESET->value;
        return $this;
    }
}
