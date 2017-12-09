<?php
namespace PtrTn\Battlerite\Query\Criterion;

interface CriterionInterface
{
    public function toArray(): array;

    public function checkCollisionWithCriteria(array $critera): void;
}
