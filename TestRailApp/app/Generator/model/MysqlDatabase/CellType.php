<?php

namespace Generator\model\MysqlDatabase;

require_once BASEDIR . '/includes/autoload.php';
require_once BASEDIR . '/includes/MoreActiveRecord.php';

class CellType extends \MoreActiveRecord
{
    const LAND_ID     = 1;
    const WATER_ID    = 3;
    const MOUNTAIN_ID = 2;
    const TREE_ID     = 4;

    const CELL_TYPE_TABLE_NAME  = 'cellType';
}
