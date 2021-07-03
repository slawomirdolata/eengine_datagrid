<?php

namespace Eengine\Test\lib;

class IntType implements IDataType {

    private $thousandSeparator = ' ';
    private $decimalPoint = ',';
    private $precision = 2;

    public function setThousandSeparator(string $separator) : IntType
    {
        $this->thousandSeparator = $separator;
        return $this;
    }

    public function setDecimalPoint(string $point) : IntType
    {
        $this->decimalPoint = $point;
        return $this;
    }

    public function setPrecision(int $precision) : IntType
    {
        $this->precision = $precision;
        return $this;
    }

    /**
    * Formatuje dane dla danego typu.
    */
    public function format($value): string
    {
        if (is_numeric($value)) {
            $value = (float)$value;
        }
        return number_format($value, $this->precision, $this->decimalPoint, $this->thousandSeparator);
    }
}
