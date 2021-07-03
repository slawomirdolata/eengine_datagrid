<?php

use \Eengine\Test\IntType;

namespace Eengine\Test\lib;

class MoneyType extends IntType implements IDataType {

    private $currency = '';

    public function setCurrency(string $currency) : MoneyType
    {
        $this->currency = $currency;
        return $this;
    }

    /**
    * Formatuje dane dla danego typu.
    */
    public function format($value): string
    {
        //return number_format($value, $this->precision, $this->decimalPoint, $this->thousandSeparator);
        return parent::format($value) . ' ' . $this->currency;
    }
}
