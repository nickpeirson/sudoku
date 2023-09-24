<?php
spl_autoload_register(function ($class) {
    include $class . '.php';
});

$grid = (new GridFactory(
    null, null, null, null, 8, 1, 6, null, null,
    3,null,null,null,null,null,null,2,null,
    6,null,null,9,null,null,null,7,5,
    7,null,null,null,null,null,3,4,null,
    8,null,null,5,4,7,null,null,9,
    null,4,9,null,null,null,null,null,7,
    9,3,null,null,null,4,null,null,8,
    null,6,null,null,null,null,null,null,2,
    null,null,8,3,1,null,null,null,null)
)
    ->newGrid();
echo $grid->dumpRows();
$grid->solve();


$grid = (new GridFactory(
    null, 3, null, null,
1, null, null, null,
null, null, null, 4,
null, 4, 2, null)
)
    ->newGrid();
echo $grid->dumpRows();
$grid->solve();
//$grid->solveOnce();
//echo $grid->dumpRows();
//$grid->solveOnce();
//echo $grid->dumpRows();
//$grid->solveOnce();
//echo $grid->dumpRows();
//$grid->solveOnce();
//echo $grid->dumpRows();