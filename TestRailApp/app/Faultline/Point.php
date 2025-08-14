<?php
namespace App\Faultline;

/**
* @author Craig Parsons
*/
Class Point
{

    public $x;
    public $y;
    public $z;

    /**
     * Create and initialize a point.
     *
     * @param integer $x
     * @param integer $y
     * @param integer $z
     */
    public function __construct($x = 0, $y = 0, $z = 0) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * Used to subtract one point by another.
     *
     * @param  Point $point
     *
     * @return Vector
     */
    public function subtract(Point $point)
    {
        return new Vector(
            $this->x - $point->x,
            $this->y - $point->y,
            $this->z - $point->z
        );
    }
}
