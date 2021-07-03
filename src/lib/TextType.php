<?php

namespace Eengine\Test\lib;

class TextType implements IDataType {

    /**
    * Formatuje dane dla danego typu.
    */
    public function format(?string $value): string
    {
        return strip_tags($value);
    }
}
