<?php

namespace Eengine\Test\lib;

class HttpState implements IState
{
    private static $instance = null;
    private $requestUri = '';
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

        $this->requestUri = $_SERVER['REQUEST_URI'];
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

    /**
     * Generuje href dla znacznika (np. <a>), z odpowiednim wariantem parametru w GET. Jeśli tego parametru nie ma, to zostanie dodany
     * @param $parameterName string nazwa parametru w GET
     * @param $variant liczbowy lub tekstowy wariant
     * @return string
     */
    public function createHrefWithParameterVariant(string $parameterName, string $variant) : string
    {
        $requestUri = $this->requestUri;

        if (preg_match('/\/.*$/', $requestUri)) {
            $requestUri .= '?' . $parameterName . '=0';
        }

        if (strpos($requestUri, $parameterName . '=') === false) {
            $requestUri .= '&' . $parameterName . '=0';
        }

        return preg_replace('/([?&])' . $parameterName . '=[^&]*/', '$1' . $parameterName . '=' . $variant, $requestUri);
    }

    public function generateControlForm() : string
    {
        return '
        <form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get" id="controlForm">
            <input type="hidden" name="' . self::PAGE_NUMBER_PARAMETER . '" id="h' . self::PAGE_NUMBER_PARAMETER . '" value="' . $this->currentPage . '" />
            <input type="hidden" name="' . self::ORDERBY_PARAMETER . '" id="h' . self::ORDERBY_PARAMETER . '" value="' . $this->orderBy . '" />
            <input type="hidden" name="' . self::ORDER_DIR_PARAMETER . '" id="h' . self::ORDER_DIR_PARAMETER . '" value="' . $this->orderDir . '" />
            <input type="text" name="' . self::ROWS_NUMBER_PARAMETER . '" value="' . $this->rowsPerPage . '"/>
        </form>';
    }
}
