<?php

namespace Mmatweb\Cumin;


class Politician implements PoliticianInterface
{
    /** @var int */
    private $nature;

    function __construct(int $nature)
    {
        $this->nature = $nature;
    }

    public function getNature(): int
    {
        return $this->nature;
    }

    function voteLaw(int $nature): bool
    {
        return $this->naturesGoTheSameWay($this->getNature(), $nature);
    }

    function canCollaborate(PoliticianInterface $politician): bool
    {
        return $this->naturesGoTheSameWay($this->getNature(), $politician->getNature());
    }

    private function naturesGoTheSameWay(int $firstNature, int $secondNature) :bool
    {
        if ($firstNature === 0 && 0 === $secondNature) {
            return true;
        }

        if ($firstNature < 0 && $secondNature < 0) {
            return true;
        }

        if ($firstNature > 0 && $secondNature > 0) {
            return true;
        }

        return false;
    }
}