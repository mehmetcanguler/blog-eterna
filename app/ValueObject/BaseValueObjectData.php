<?php

namespace App\ValueObject;

abstract class BaseValueObjectData
{
    abstract public function toArray(): array;
}
