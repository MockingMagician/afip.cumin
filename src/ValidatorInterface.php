<?php

namespace Mmatweb\Cumin;

interface ValidatorInterface
{
    public function isValid($value): bool;
}
