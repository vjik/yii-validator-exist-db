<?php

declare(strict_types=1);

namespace Vjik\Yii\ValidatorExistDb;

use Closure;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\SkipOnErrorTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleWithOptionsInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\SkipOnErrorInterface;
use Yiisoft\Validator\WhenInterface;

final class Exist implements
    RuleWithOptionsInterface,
    SkipOnErrorInterface,
    WhenInterface,
    SkipOnEmptyInterface
{
    use SkipOnEmptyTrait;
    use SkipOnErrorTrait;
    use WhenTrait;

    /**
     * @var bool|callable|null
     */
    private $skipOnEmpty;

    public function __construct(
        private ?string $tableName = null,
        private ?string $attribute = null,
        private string $message = '{attribute} is invalid.',
        private string $handlerClassName = ExistHandler::class,
        bool|callable|null $skipOnEmpty = null,
        private bool $skipOnError = false,
        private Closure|null $when = null,
    ) {
        $this->skipOnEmpty = $skipOnEmpty;
    }

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getName(): string
    {
        return 'exist';
    }

    public function getHandlerClassName(): string
    {
        return $this->handlerClassName;
    }

    public function getOptions(): array
    {
        return [
            'message' => [
                'template' => $this->message,
                'parameters' => [],
            ],
            'skipOnEmpty' => $this->getSkipOnEmptyOption(),
            'skipOnError' => $this->skipOnError,
        ];
    }
}
