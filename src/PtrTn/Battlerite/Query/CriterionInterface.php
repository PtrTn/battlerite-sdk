<?php
namespace PtrTn\Battlerite\Query;

interface CriterionInterface
{
    public function toArray(): array;

    public function checkCollisionWithCriteria(array $critera): void;
}
