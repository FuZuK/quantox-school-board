<?php
namespace Boards\Renderers;

use Contracts\Boards\Renderer;

class CSMB implements Renderer
{

    function getContentType(): string
    {
        return 'application/xml';
    }

    function renderStudent(array $student): string
    {
        $xml = new \SimpleXMLElement('<student/>');

        foreach ($student as $key => $value) {
            if ($key === 'grades') {
                $grades = $xml->addChild('grades');

                foreach ($value as $grade) {
                    $grades->addChild('grade', $grade);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }
}
