<?php
namespace Contracts\Boards;

interface Renderer
{
    function getContentType(): string;
    function renderStudent(array $student): string;
}
