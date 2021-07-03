<?php

namespace Eengine\Test\lib;

class Config implements IConfig
{

    protected $columns = [];

    /**
     * Dodaje nową kolumnę do DataGrid.
     */
    public function addColumn(string $key, Column $column): Config
    {
        $this->columns[$key] = $column;
        return $this;
    }

    /**
     * Zwraca wszystkie kolumny dla danego DataGrid.
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}
