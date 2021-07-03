<?php

namespace Eengine\Test\lib;

interface IColumn
{
    /**
     * Zmienia tytuł kolumny, który będzie widoczny jako nagłówek.
     */
    public function withLabel(string $label): Column;

    public function getLabel(): string;

    /**
     * Ustawia typ danych dla kolumny.
     */
    public function withDataType(IDataType $type): Column;

    public function getDataType(): IDataType;

    /**
     * Ustawienie wyrównania treści znajdujących się w kolumnie.
     */
    public function withAlign(string $align): Column;

    public function getAlign(): string;
}
