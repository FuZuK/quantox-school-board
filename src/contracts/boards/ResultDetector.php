<?php

namespace Contracts\Boards;

interface ResultDetector
{
    function detect(array $grades): string;
}
