<?php

namespace Eengine\Test\lib;

interface IHtmlDataGrid
{
    /**
     * Zmienia aktualną konfigurację DataGrid.
     */
    public function withConfig(Config $config): HtmlDataGrid;

    /**
     * Renderuje na ekran kod, który ma za zadanie wyświetlić przygotowany DataGrid.
     * Jako parametr przyjmuje: wszystkie dostępne dane, oraz aktualny stan DataGrid w formie obiektu - State.
     * Na podstawie State, metoda ma za zadanie posortować wiersze oraz podzielić je na strony.
     */
    public function render(array $rows, HttpState $state): void;
}
