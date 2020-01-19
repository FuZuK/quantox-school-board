<?php
namespace Boards\ResultDetectors;

use Contracts\Boards\ResultDetector;

class CSMB implements ResultDetector
{
    function detect(array $grades): string
    {
        if (count($grades) > 2) {
            sort($grades);
            array_shift($grades);
        }

        return max($grades) > 8 ? 'PASS' : 'FAIL';
    }
}
