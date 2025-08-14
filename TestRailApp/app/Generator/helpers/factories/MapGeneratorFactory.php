<?php
namespace Generator\factories;

class MapGeneratorFactory
{
    const MAP_GENERATORS_LOCATION = '/app/Generator/helpers/MapGenerators';

    protected $arrListGenerators = array();

    /**
     * Runs load Generators.
     */
    public function __construct()
    {
        $this->loadGenerators();
    }

    /**
     * Reads all the files in the MapGenerator and initializes all of them.
     */
    public function loadGenerators()
    {
        if ($handle = opendir(BASEDIR . self::MAP_GENERATORS_LOCATION)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($strEntry = readdir($handle))) {
                if ($strEntry != '.' && $strEntry != '..') {
                    $className = basename($strEntry, '.php');

                    $strClassDeclaration = 'Generator\helpers\MapGenerators\\'.$className;
                    $this->arrListGenerators[$className] = new $strClassDeclaration;
                }
            }
            closedir($handle);
        }
    }

    /**
     * Gets the value of arrListGenerators.
     *
     * @return mixed
     */
    public function getArrListGenerators()
    {
        return $this->arrListGenerators;
    }

    /**
     * Get the Generator.
     *
     * @return mixed
     */
    public function getGenerator($strIndex)
    {
        return $this->arrListGenerators[$strIndex];
    }

    /**
     * Sets the value of arrListGenerators.
     *
     * @param mixed $arrListGenerators the arr list generators
     *
     * @return self
     */
    public function setArrListGenerators($arrListGenerators)
    {
        $this->arrListGenerators = $arrListGenerators;

        return $this;
    }

    /**
     * Check hasStrDropDownDisplayName function before adding to dropdown list.
     *
     * @return array
     */
    public function getSelectArray()
    {
        // Initialize the array were returning
        $arrReturn = array();

        foreach ($this->arrListGenerators as $key => $currGen) {
            if ($currGen->hasStrDropDownDisplayName()) {
                // Array keys will be the class name.
                $arrReturn[$key] = $currGen->getStrDropDownDisplayName();
            }
        }

        return $arrReturn;
    }
}
