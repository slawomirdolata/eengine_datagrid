<?php

use \Eengine\Test\lib\Config;
use \Eengine\Test\lib\TemplateFileException;
use \Eengine\Test\lib\HttpState;

namespace Eengine\Test\lib;

class HtmlDataGrid implements IHtmlDataGrid
{
    const TEMPLATES_DIRECTORY = 'src/view/';

    private $templateFile = 'main.html';
    private $config;
    private $rows = [];
    private $state;

    public function __construct(array $rows, HttpState $state)
    {
        $this->rows = $rows;
        $this->state = $state;
    }

    private function generateHeaders() : string
    {
        $columns = $this->config->getColumns();
        $output = '';

        foreach ($columns As $key => $column) {
            $output .= '<th data-url="' . $this->state->createHrefWithParameterVariant(HttpState::ORDERBY_PARAMETER, $key) . '">' . $column->getLabel() . '</th>';
        }

        return $output;
    }

    private function convertRowsToHtmlTableRows() : string
    {
        $columns = $this->config->getColumns();
        $output = '';

        $recordsNumber = count($this->rows);
        $rowNumberMin = $this->state->getCurrentPage() * $this->state->getRowsPerPage();
        $rowNumberMax = min($recordsNumber, ($this->state->getCurrentPage() + 1) * $this->state->getRowsPerPage());

        if ($rowNumberMin > $recordsNumber) {
            throw new \Exception ('Nieprawidłowy numer strony');
        }

        for ($n = $rowNumberMin; $n < $rowNumberMax; $n++) {
            $output .= '<tr>';

            foreach ($columns As $key => $column) {
                $output .=
                    '<td style="text-align: '
                    . $column->getAlign()
                    . '">'
                    . $column->getDataType()->format($this->rows[$n][$key])
                    . '</td>';
            }

            $output .= '</tr>';
        }

        return $output;
    }

    private function generatePagination() : string
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        $output = '';
        $numberOfPages = ceil(count($this->rows) / $this->state->getRowsPerPage());

        for ($n = 0; $n < $numberOfPages; $n++) {
            $output .=
                '<li class="page-item"><a class="page-link" href="'
                . $this->state->createHrefWithParameterVariant(HttpState::PAGE_NUMBER_PARAMETER, $n)
                . '">' . (string)($n + 1) . '</a></li>';
        }

        return $output;
    }

    public function withConfig(Config $config) : HtmlDataGrid
    {
        $this->config = $config;
        return $this;
    }

    private function sort() : void
    {
        $orderBy = $this->state->getOrderBy();

        if ($orderBy === '') {
            return;
        }

        $arrayColumn = array_column($this->rows, $orderBy);
        array_multisort(
            $arrayColumn,
            ($this->state->isOrderDesc() ? SORT_DESC : SORT_ASC),
            $this->rows
        ); //php-owy array_multisort to zły pomysł, ale na razie niech będzie
    }


    public function render(): void
    {
        $templateFilePath = self::TEMPLATES_DIRECTORY . $this->templateFile;
        if (!file_exists($templateFilePath)) {
            throw new TemplateFileException();
        }

        $viewTempate = file_get_contents($templateFilePath);
        $this->sort();

        echo str_replace(
            ['{{table_headers}}', '{{table_rows}}', '{{pagination}}'],
            [
                $this->generateHeaders(),
                $this->convertRowsToHtmlTableRows(),
                $this->generatePagination()
            ],
            $viewTempate
        );
    }
}
