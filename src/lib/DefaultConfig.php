<?php

use Eengine\Test\lib\Config;
use Eengine\Test\lib\Column;
use Eengine\Test\lib\TextType;
use Eengine\Test\lib\IntType;
use Eengine\Test\lib\MoneyType;

namespace Eengine\Test\lib;

class DefaultConfig extends Config
{
    private function addColumnOfSpecifiedType(string $key, string $align, $type) : void
    {
        $column = (new Column)
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign($align);
        $this->addColumn($key, $column);
    }

    public function addTextColumn(string $key) : DefaultConfig
    {
        $columnType = new TextType();
        $this->addColumnOfSpecifiedType($key, 'left', $columnType);
        return $this;
    }

    public function addIntColumn(
        string $key,
        string $thousandSeparator = ' ',
        string $decimalPoint = ',',
        int $precision = 2
    ) : DefaultConfig
    {
        $columnType = new IntType();
        $columnType
            ->setThousandSeparator($thousandSeparator)
            ->setDecimalPoint($decimalPoint)
            ->setPrecision($precision);
        $this->addColumnOfSpecifiedType($key, 'right', $columnType);
        return $this;
    }

    public function addCurrencyColumn(
        string $key,
        string $currency,
        string $thousandSeparator = ' ',
        string $decimalPoint = ',',
        int $precision = 2
    ) : DefaultConfig
    {
        $columnType = new MoneyType();
        $columnType
            ->setCurrency($currency)
            ->setThousandSeparator($thousandSeparator)
            ->setDecimalPoint($decimalPoint)
            ->setPrecision($precision);
        $this->addColumnOfSpecifiedType($key, 'right', $columnType);
        return $this;
    }
}
