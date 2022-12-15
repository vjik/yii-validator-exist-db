<?php

declare(strict_types=1);

namespace Vjik\Yii\ValidatorExistDb;

use Yiisoft\Db\Query\QueryInterface;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class ExistHandler implements RuleHandlerInterface
{
    public function __construct(
        private QueryInterface $query,
    ) {
    }

    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof Exist) {
            throw new UnexpectedRuleException(Exist::class, $rule);
        }

        $exist = $this->query
            ->from($rule->getTableName())
            ->where([$rule->getAttribute() => $value])
            ->exists();

        $result = new Result();

        if (!$exist) {
            $result->addError(
                $rule->getMessage(),
                [
                    'attribute' => $context->getTranslatedAttribute(),
                ]
            );
        }

        return $result;
    }
}
