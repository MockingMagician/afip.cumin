<?php

namespace Mmatweb\Cumin;

class ValidatorCollection
{
    /**
     * @var ValidatorInterface[][]
     */
    private $validators = [];

    public function addValidator(string $key, ValidatorInterface $validator): self
    {
        if (!isset($this->validators[$key])) {
            $this->validators[$key] = [];
        }

        $this->validators[$key][] = $validator;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return ValidatorInterface[];
     */
    public function getValidators(string $key): array
    {
        return $this->validators[$key] ?? [];
    }
}
