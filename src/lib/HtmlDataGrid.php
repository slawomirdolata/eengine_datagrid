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

    private function generateHeaders() : string
    {
        $columns = $this->config->getColumns();
        $output = '';

        foreach ($columns As $key => $column) {
            $output .= '<th data-sort="' . $key . '">' . $column->getLabel() . '</th>';
        }

        return $output;
    }

    private function convertRowsToHtmlTableRows(array $rows, HttpState $state) : string
    {
        $columns = $this->config->getColumns();
        $output = '';

        $recordsNumber = count($rows);
        $rowNumberMin = $state->getCurrentPage() * $state->getRowsPerPage();
        $rowNumberMax = min($recordsNumber, ($state->getCurrentPage() + 1) * $state->getRowsPerPage());

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
                    . $column->getDataType()->format($rows[$n][$key])
                    . '</td>';
            }

            $output .= '</tr>';
        }

        return $output;
    }

    private function generatePagination($rows, $state) : string
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if ($requestUri === '/') {
            $requestUri .= '?' . HttpState::PAGE_NUMBER_PARAMETER . '=0';
        }

        if (strpos($requestUri, HttpState::PAGE_NUMBER_PARAMETER . '=') === false) {
            $requestUri .= '&' . HttpState::PAGE_NUMBER_PARAMETER . '=0';
        }

        $output = '';
        $numberOfPages = ceil(count($rows) / $state->getRowsPerPage());

        for ($n = 0; $n < $numberOfPages; $n++) {
            $output .=
                '<li class="page-item"><a class="page-link" href="'
                . preg_replace('/([?&])' . HttpState::PAGE_NUMBER_PARAMETER . '=[0-9]{1,10}/', '$1' . HttpState::PAGE_NUMBER_PARAMETER . '=' . $n, $requestUri)
                . '">' . (string)($n + 1) . '</a></li>';
        }

        return $output;
    }

    public function withConfig(Config $config) : HtmlDataGrid
    {
        $this->config = $config;
        return $this;
    }

    /*
    sortowanie:
        $a - tablica z danymi z json
    $ac = array_column ($a, 'imie');
    array_multisort ($ac, SORT_ASC, $a);
    print_r ($a);

    */



    public function render(array $rows, HttpState $state): void
    {
        $templateFilePath = self::TEMPLATES_DIRECTORY . $this->templateFile;
        if (!file_exists($templateFilePath)) {
            throw new TemplateFileException();
        }

        $viewTempate = file_get_contents($templateFilePath);
        echo str_replace(
            ['{{table_headers}}', '{{table_rows}}', '{{pagination}}'],
            [
                $this->generateHeaders(),
                $this->convertRowsToHtmlTableRows($rows, $state),
                $this->generatePagination($rows, $state)
            ],
            $viewTempate
        );
    }
}
