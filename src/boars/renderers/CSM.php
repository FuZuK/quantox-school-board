<?php
namespace Boards\Renderers;

use Contracts\Boards\Renderer;

class CSM implements Renderer
{

    function getContentType(): string
    {
        return 'application/json';
    }

    function renderStudent(array $student): string
    {
        return json_encode($student);
    }
}
