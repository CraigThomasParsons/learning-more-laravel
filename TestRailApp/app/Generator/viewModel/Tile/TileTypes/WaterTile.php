<?php
namespace Generator\view\Tile\TileTypes;

/**
 * Represents single square of the 4 squares in each cell.
 */
class WaterTile extends BaseTile
{
   /**
     * Returns this class as a divider.
     * The tiles need to be refractored into a OO way of determining how tiles are
     * printed.
     *
     * @return string
     */
    public function getString()
    {
        $strDiv = ' <div class="tile">';
        switch ($this->getTileDisplayType()) {
            case 'TopLeftConcaveCorner-WaterTile':
                $strDiv = '<div class="tile inner-WaterTile">';
                $strDiv .= '<div class="tile TopLeftConcaveCorner-WaterTile"></div>';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile"></div>';
                break;
            case 'TopRightConcaveCorner-WaterTile':
                $strDiv = '<div class="tile inner-WaterTile">';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile TopRightConcaveCorner-WaterTile"></div>';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile"></div>';
                break;
            case 'bottomLeftConcaveCorner-WaterTile':
                $strDiv = '<div class="tile inner-WaterTile">';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile bottomLeftConcaveCorner-WaterTile"></div>';
                $strDiv .= '<div class="tile"></div>';
                break;
            case 'bottomRightConcaveCorner-WaterTile':
                $strDiv = '<div class="tile inner-WaterTile">';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile"></div>';
                $strDiv .= '<div class="tile bottomRightConcaveCorner-WaterTile"></div>';
                break;
            default:
                if (strlen($this->getTileDisplayType()) > 0) {
                    $strDiv = '<div class="tile ' . $this->getTileDisplayType() . '">';
                }
        }
        $strDiv .= ' </div>';

        return $strDiv;
    }

    /**
     * [getTableData description]
     *
     * @return [type] [description]
     */
    public function getTableData()
    {
        $strTableData = '';
        switch ($this->getTileDisplayType()) {
            case 'TopLeftConcaveCorner-WaterTile':
                $strTableData .= '<td class="tile TopLeftConcaveCorner-WaterTile"';
                break;
            case 'TopRightConcaveCorner-WaterTile':
                $strTableData .= '<td class="tile TopRightConcaveCorner-WaterTile"';
                break;
            case 'bottomLeftConcaveCorner-WaterTile':
                $strTableData .= '<td class="tile bottomLeftConcaveCorner-WaterTile"';
                break;
            case 'bottomRightConcaveCorner-WaterTile':
                $strTableData .= '<td class="tile bottomRightConcaveCorner-WaterTile"';
                break;
            default:
                if (strlen($this->getTileDisplayType()) > 0) {
                    $strTableData = '<td ';
                }
        }
        $strTableData .= 'style="background-color:blue;"> </td>';

        return $strTableData;
    }
}
