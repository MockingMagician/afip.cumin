<?php

namespace Mmatweb\Cumin;

class Filter
{
    private $toFilter;
    private $validators;

    public function __construct(array $toFilter, ValidatorCollection $validators)
    {
        $this->toFilter = $toFilter;
        $this->validators = $validators;
    }

    public function validate(): array
    {
        $filtered = [];

        foreach ($this->toFilter as $k => $v) {
            foreach ($this->validators->getValidators($k) as $validators) {
            }
        }
    }
}
