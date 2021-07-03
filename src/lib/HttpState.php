<?php

use Eengine\Test\lib\HttpGetParameter;

namespace Eengine\Test\lib;

class HttpState implements IState
{
    const DEFAULT_ROWS_MENGE = 9;

    private static $instance = null;
    //private $requestUri = '';
    private $currentPage;
    private $orderBy = '';
    private $orderDir = self::SORTING_UP_KEYWORD;
    private $rowsPerPage = 0;

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
        $this->currentPage = new HttpGetParameter(self::PAGE_NUMBER_PARAMETER, self::INTEGER_TYPE, 1000, 0);
        $this->rowsPerPage = new HttpGetParameter(self::ROWS_NUMBER_PARAMETER, self::INTEGER_TYPE, 200, self::DEFAULT_ROWS_MENGE);
        $this->orderBy = new HttpGetParameter(self::ORDERBY_PARAMETER, self::STRING_TYPE, 20);
        $this->orderDir = new HttpGetParameter(self::ORDER_DIR_PARAMETER, self::STRING_TYPE, 4);
        $this->orderDir->setAcceptedValues([self::SORTING_UP_KEYWORD, self::SORTING_DOWN_KEYWORD]);
    }

    /**
     * Zwraca aktualna strone DataGrid do wyświetlenia
     */
    public function getCurrentPage() : int
    {
        return $this->currentPage->getValue();
    }

    /**
     * Klucz kolumny, po której będzie sortowany DataGrid.
     */
    public function getOrderBy(): string
    {
        return $this->orderBy->getValue();
    }

    /**
     * Czy dane mają zostać posortowane malejąco?
     */
    public function isOrderDesc(): bool
    {
        return $this->orderDir->getValue() === self::SORTING_DOWN_KEYWORD;
    }

    /**
     * Czy dane mają zostać posortowane rosnąco?
     */
    public function isOrderAsc(): bool
    {
        return $this->orderDir->getValue() === self::SORTING_UP_KEYWORD;
    }

    /**
     * Zwraca ilośc wierszy które mają zostać wyświetlone na jednej stronie.
     */
    public function getRowsPerPage() : int
    {
        return $this->rowsPerPage->getValue();
    }

    public function generateControlForm() : string
    {
        return '
        <form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get" id="controlForm">
            <input type="hidden" name="' . self::PAGE_NUMBER_PARAMETER . '" id="h' . self::PAGE_NUMBER_PARAMETER . '" value="' . $this->getCurrentPage() . '" />
            <input type="hidden" name="' . self::ORDERBY_PARAMETER . '" id="h' . self::ORDERBY_PARAMETER . '" value="' . $this->getOrderBy() . '" />
            <input type="hidden" name="' . self::ORDER_DIR_PARAMETER . '" id="h' . self::ORDER_DIR_PARAMETER . '" value="' . $this->orderDir->getValue() . '" />
            <input type="text" name="' . self::ROWS_NUMBER_PARAMETER . '" value="' . $this->rowsPerPage->getValue() . '"/>
        </form>';
    }
}
