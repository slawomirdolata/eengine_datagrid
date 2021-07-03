<?php

namespace Eengine\Test\lib;

class HttpState implements IState
{
    private static $instance = null;
    private $currentPage = 0;
    private $orderBy = '';
    private $orderDir = 'ASC';
    private $rowsPerPage = 5;

    public static function create() : HttpState
    {
        if (self::$instance === null) {
            self::$instance = new HttpState();
        }

        self::$instance->setParameters();
        return self::$instance;
    }

    private function setParameters() : void
    {
        if (isset($_GET[self::PAGE_NUMBER_PARAMETER]) && is_numeric($_GET[self::PAGE_NUMBER_PARAMETER])) {
            $this->currentPage = (int)$_GET[self::PAGE_NUMBER_PARAMETER];
        }

        if (isset($_GET[self::ROWS_NUMBER_PARAMETER]) && is_numeric($_GET[self::ROWS_NUMBER_PARAMETER])) {
            $rowsPerPage = (int)$_GET[self::ROWS_NUMBER_PARAMETER];

            if ($rowsPerPage > 100) {
                throw new \Exception('Podano zbyt dużą liczbę wierszy');
            }

            $this->rowsPerPage = $rowsPerPage;
        }

        if (isset($_GET[self::ORDERBY_PARAMETER])) {
            $this->orderBy = $_GET[self::ORDERBY_PARAMETER];
        }

        if (isset($_GET[self::ORDER_DIR_PARAMETER])) {
            $this->orderDir = $_GET[self::ORDER_DIR_PARAMETER];
        }
    }

    /**
     * Zwraca aktualna strone DataGrid do wyświetlenia
     */
    public function getCurrentPage() : int
    {
        return $this->currentPage;
    }

    /**
     * Klucz kolumny, po której będzie sortowany DataGrid.
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * Czy dane mają zostać posortowane malejąco?
     */
    public function isOrderDesc(): bool
    {
        return $this->orderDir === 'DESC';
    }

    /**
     * Czy dane mają zostać posortowane rosnąco?
     */
    public function isOrderAsc(): bool
    {
        return $this->orderDir === 'ASC';
    }

    /**
     * Zwraca ilośc wierszy które mają zostać wyświetlone na jednej stronie.
     */
    public function getRowsPerPage() : int
    {
        return $this->rowsPerPage;
    }
}
