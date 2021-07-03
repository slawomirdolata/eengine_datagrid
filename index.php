<?php
require 'vendor/autoload.php';

use Eengine\Test\lib\HtmlDataGrid;
use Eengine\Test\lib\DefaultConfig;
use Eengine\Test\lib\HttpState;

$rows = json_decode(file_get_contents("data/data.json"), true);

$state = HttpState::create(); // instanceof State, dane powinny zostać pobrane z $_GET

$config = (new DefaultConfig)
    ->addIntColumn('id', '', '', 0)
    ->addTextColumn('name')
    ->addIntColumn('age')
    ->addTextColumn('company')
    ->addCurrencyColumn('balance', 'USD')
    ->addTextColumn('phone')
    ->addTextColumn('email');

$datagrid = new HtmlDataGrid();
$datagrid->withConfig($config)->render($rows, $state);
