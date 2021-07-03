<?php

namespace Eengine\Test\lib;

interface IDataType {

    /**
    * Formatuje dane dla danego typu.
    */
    public function format(string $value): string;
}
