<?php

namespace Eengine\Test\lib;

interface IConfig
{
    /**
     * Dodaje nową kolumną do DataGrid.
     */
    public function addColumn(string $key, Column $column): Config;

    /**
     * Zwraca wszystkie kolumny dla danego DataGrid.
     */
    public function getColumns(): array;
}
