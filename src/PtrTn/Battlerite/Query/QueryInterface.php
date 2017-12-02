<?php
namespace PtrTn\Battlerite\Query;

interface QueryInterface
{
    public function toQueryString(): ?string;
}
