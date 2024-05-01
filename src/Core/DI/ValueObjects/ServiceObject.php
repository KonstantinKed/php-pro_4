<?php


namespace App\Core\DI\ValueObjects;

use Closure;
use App\Core\DI\Enums\ServiceConfigArrayKeys as S;
use InvalidArgumentException;

/**
 * @property $arguments AbstractCommand[]
 */
class ServiceObject
{
    /**
     * @var bool Status service instance is created
     */
    protected bool $lock = false;

    /**
     * @var CallMethodsServiceObject[]
     */
    protected array $calls;

    /**
     * @param string $name
     * @param string $class
     * @param array $arguments
     * @param array $tags
     * @param array $calls
     * @param array $composition
     * @param Closure $compiler
     */
    public function __construct(
        protected string  $name,
        protected string  $class,
        protected array   $arguments,
        protected array   $tags,
        array             $calls,
        protected array   $composition,
        protected Closure $compiler
    )
    {
        foreach ($calls as $call) {
            $this->calls[] = new CallMethodsServiceObject(
                $this,
                $call[S::METHOD],
                $call[S::ARGUMENTS]
            );
        }
    }

    /**
     * @param string $name
     * @param array{class: string, arguments: array, tags: array, calls: array} $serviceParameters
     * @return ServiceObject
     */
    public static function createFromArray(string $name, array $serviceParameters): self
    {
        if (!isset($serviceParameters[S::CLASSNAME])) {
            throw new InvalidArgumentException("Service '{$name}' entry must be an array containing a '" . S::CLASSNAME . "' key");
        }
        return new static(
            $name,
            $serviceParameters[S::CLASSNAME],
            $serviceParameters[S::ARGUMENTS] ?? [],
            $serviceParameters[S::TAGS] ?? [],
            $serviceParameters[S::CALLS] ?? [],
            $serviceParameters[S::COMPOSITION] ?? [],
            $serviceParameters[S::COMPILER] ?? function () {
        }
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function hasTags(): bool
    {
        return !empty($this->tags);
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function isLock(): bool
    {
        return $this->lock;
    }

    /**
     * @return void
     */
    public function lockService(): void
    {
        $this->lock = true;
    }

    /**
     * @return bool
     */
    public function hasCalls(): bool
    {
        return !empty($this->calls);
    }

    /**
     * @return CallMethodsServiceObject[]
     */
    public function getCalls(): array
    {
        return $this->calls;
    }

    /**
     * @return Closure
     */
    public function getCompiler(): Closure
    {
        return $this->compiler;
    }

    /**
     * @return bool
     */
    public function hasComposition(): bool
    {
        return !empty($this->composition);
    }

    /**
     * @return string
     */
    public function getCompositionParentClass(): string
    {
        return array_key_first($this->composition);
    }

    /**
     * @return string
     */
    public function getCompositionParentMethod(): string
    {
        return current($this->composition);
    }
}
