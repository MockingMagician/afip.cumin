<?php

namespace Mmatweb\Cumin;


interface PoliticianInterface
{
    function voteLaw(int $nature): bool;
    function canCollaborate(PoliticianInterface $politician): bool;
    function getNature(): int;
}