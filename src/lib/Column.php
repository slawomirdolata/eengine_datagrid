<?php

namespace Eengine\Test\lib;

class Column implements IColumn
{
    private $label = '';
    private $dataType;
    private $align = '';

    /**
     * Zmienia tytuł kolumny, który będzie widoczny jako nagłówek.
     */
    public function withLabel(string $label): Column
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Ustawia typ danych dla kolumny.
     */
    public function withDataType(IDataType $type): Column
    {
        $this->dataType = $type;
        return $this;
    }

    public function getDataType(): IDataType
    {
        return $this->dataType;
    }

    /**
     * Ustawienie wyrównania treści znajdujących się w kolumnie.
     */
    public function withAlign(string $align): Column
    {
        $this->align = $align;
        return $this;
    }

    public function getAlign(): string
    {
        return $this->align;
    }
}
