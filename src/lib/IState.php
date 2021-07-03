<?php

namespace Eengine\Test\lib;

interface IState {

    const PAGE_NUMBER_PARAMETER = 'p';
    const ROWS_NUMBER_PARAMETER = 'rows';
    const ORDERBY_PARAMETER = 'order';
    const ORDER_DIR_PARAMETER = 'dir';

    /**
     * Zwraca aktualna strone DataGrid do wyświetlenia
     */
    public function getCurrentPage(): int;

    /**
     * Klucz kolumny, po której będzie sortowany DataGrid.
     */
    public function getOrderBy(): string;

    /**
     * Czy dane mają zostać posortowane malejąco?
     */
    public function isOrderDesc(): bool;

    /**
     * Czy dane mają zostać posortowane rosnąco?
     */
    public function isOrderAsc(): bool;

    /**
     * Zwraca ilośc wierszy które mają zostać wyświetlone na jednej stronie.
     */
    public function getRowsPerPage(): int;

}
