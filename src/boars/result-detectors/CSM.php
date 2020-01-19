<?php
namespace Boards\ResultDetectors;

use Contracts\Boards\ResultDetector;

class CSM implements ResultDetector
{
    function detect(array $grades): string
    {
        return array_sum($grades) / count($grades) >= 7 ? 'PASS' : 'FAIL';
    }
}
