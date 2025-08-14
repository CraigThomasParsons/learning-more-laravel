<?php
namespace Generator\model\MongoDatabase;

/**
 * This class should make it easier to save a record into a Mongo database from an object.
 * Mongo should of been easy enough to use before having to use this class.
 * However I'm still getting used to Eloquent.
 *
 * @todo Need to get around to cleaning up all this commented out code and finish off this class.
 */
class MongoModel
{
    protected $data;
    protected $error;

    /**
     * constructor of MongoModel.
     */
    public function __construct()
    {
        $this->data = array();
        $this->error = array();
    }

    /**
     * Given an array, populate data in this class.
     *
     * @param array $post
     *
     * @return self
     */
    public function populateFromPost($post)
    {
        // Set field values based on values in post.
        foreach ($post as $field => $value) {
            $this->set($field, $value);
        }

        return $this;
    }

    /**
     * Given an array, populate data in this class.
     *
     * @param array $data
     *
     * @return self
     */
    public function populateFromArray($data)
    {
        // Set field values based on values passed in by parameters.
        foreach ($data as $field => $value) {
            $this->set($field, $value);
        }

        return $this;
    }

    /**
     * Function used to change protected variable data.
     *
     * @param mixed $indexName The index of the member variable data that were setting.
     * @param mixed $value     The value were changing it to.
     *
     * @return self
     */
    public function set($indexName, $value)
    {
        $this->data[$indexName] = $value;

        return $this;
    }

    /**
     * unsets $fieldName
     *
     * @param string $fieldName
     *
     * @return self
     */
    public function unsetField($fieldName)
    {
        unset($this->data[$fieldName]);

        return $this;
    }

    /**
     * Getter for anything
     *
     * @param string $fieldName
     *
     * @return mixed
     */
    public function get($fieldName)
    {
        return ($this->data[$fieldName]);
    }

    /**
     * get All Data stored in this class.
     *
     * @return array
     */
    public function getAllData()
    {
        return $this->data;
    }

    /**
     * Get values of the names of the field names passed in as array.
     *
     * @param array $fields The names of the fields whose values you need.
     *
     * @return array
     */
    public function getValues($fields)
    {
        $fieldValues = array();
        foreach ($fields as $field) {
            $fieldValues[] = $this->data[$field];
        }
        return $fieldValues;
    }

    /**
     * Gets the value of data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the value of data.
     *
     * @param mixed $data the data
     *
     * @return self
     */
    protected function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Sets the value of error.
     *
     * @param mixed $error the error
     *
     * @return self
     */
    protected function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * If a member variable isn't found it will try to get it from data.
     */
    public function __get($name)
    {
        // If were looking for a possible getter function then remove underscores.
        // Don't worry about case because function calls are not case sensitive.
        $strFieldNameNoUnderscore = str_replace('_', '', $name);
        $strGetFunctionName       = 'get' . $strFieldNameNoUnderscore;

        // Use getters if they exist.
        if (method_exists($this, $strGetFunctionName)) {
            return $this->$strGetFunctionName($name);

            // Use the get function if a that field were looking for is in data.
        } else if (array_key_exists($name, $this->data)) {
            return $this->get($name);
        }
    }

    /**
     * Magical
     * If a member variable isn't found then use data array.
     */
    public function __set($variableName, $value)
    {
        if (array_key_exists($variableName, $this->data)) {

            // Function set exists in parent class db_record.
            return $this->set($variableName, $value);
        } else {

            return $this->$variableName = $value;
        }
    }

    /**
     * Static method to insert a new row into the database using class str_class
     * and using the values in properties
     * eg:
     * <code>
     * Mongo::Insert( 'Car', array('make'=>'Citroen', 'model'=>'C4', 'colour'=>'Silver') );
     * </code>
     *
     * @static
     * @param  string  str_class  the name of the class/table
     * @param  array properties  array/hash of properties for object/row
     * @return boolean true or false depending upon whether insert is successful
     */
    public function insert($str_class, $properties)
    {
        //$object = Mongo::create($str_class, $properties);
        //return $object->save;
    }

    /**
     * Static method to update a row in the database using class str_class
     * and using the values in properties
     * eg:
     * <code>
     * Mongo::Update( 'Car', 1, array('make'=>'Citroen', 'model'=>'C4', 'colour'=>'Silver') );
     * </code>
     *
     * @static
     * @param  string  str_class  the name of the class/table
     * @param  int   id      the id of the row be updated.
     * @param  arrray  properties  array/hash of properties for object/row
     * @param  boolean true or false depending upon whether update is sucessful
     */
    public function update($str_class, $id, $properties)
    {
    	//todo
        //$object = Mongo::FindById($str_class, $id);
        //$object->populate($properties);
        //return $object->save();
    }

    /**
     * Sets all object properties via an array
     *
     * @param   array $arrVals  array of named values
     * @return  boolean true if $arrVals is valid array, false if not
     */
    public function populate($arrValues)
    {
        if (is_array($arrValues)) {
            foreach ($arrValues as $key => $val) {
                // This should work.
                // Since we do have __set making sure data will be populated.
                $this->$key = $val;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes the object from the database
     * Very simple way of doing it.
     * If you want something more complex use Mongo::destroy
     * eg:
     * <code>
     * $car = Mongo::FindById('Car', 1);
     * $car->destroy();
     * </code>
     *
     * @return  boolean True on success, False on failure
     */
    public function delete()
    {
    }

    /**
     * Adds an error to the object. The existence of errors
     * ensures that $object->save() will return false and
     * will not attempt to persist the object to the database
     * This can be used for validation of the object.
     * e.g.
     * <code>
     * if( empty( $user->first_name ) ) $user->addError('first_name', 'First Name may not be blank!');
     * $user->save or print_r($user->getErrors)
     * </code>
     *
     * @param string strKey     The name of the invalid key/property/attribute
     * @param string strMessage a message, which you may want to report back to the user in due course
     *
     * @return  void
     */
    public function addError($strKey, $strMessage)
    {
        if (!isset($this->error)) {
            $this->error = array();
        }
        $this->error[$strKey] = $strMessage;
    }

    /**
     * Gets an error on a specified attribute.
     *
     * @param string str_key Name of field/attribute/key
     *
     * @return string Error Message. False if no error
     */
    public function getError($strKey)
    {
        if (isset($this->error[$strKey])) {
            return $this->error[$strKey];
        } else {
            return false;
        }
    }

    /**
     * Returns all errors.
     *
     * @return  array Array of errors, keyed by attribute.
     *          False if there are no errors.
     */
    public function getErrors()
    {
        if (isset($this->error) && is_array($this->error)) {
            return $this->error;
        } else {
            return false;
        }
    }

    /**
     * Returns a database connection to be used by the class.
     *
     * @static
     * @return  resource  mysql connection
     */
    static public function connection()
    {
        /*
        spl_autoload_unregister(array('Doctrine', 'autoload'));
        // Conserve connection resource
        static $rscMongo;

        if (!$rscMongo) {
            $rscMongo = new MongoClient();
        }

        return $rscMongo;
        */
    }

    /**
     * Declares and object and then populates it
     * Very usefull to use in a loop when you mysql fetched from associative
     *
     * @param string  str_class The class name of the objects were going to declare
     */
    public function declareAndPopulate($str_class, $arr_values = null)
    {/*
        $obj_database_relational_mapping = new $str_class();
        $str_table                       = Mongo::classNameToTableName($str_class);

        // Expecting arr_values to come from a "$arr_values = mysql_fetch_assoc($result)" call.
        foreach (Mongo::columns($str_table) as $key => $field) {

            if ($field['Default']) {
                $obj_database_relational_mapping->$key = $field['Default'];
            }
        }

        $obj_database_relational_mapping->populate($arr_values);

        return $obj_database_relational_mapping;*/
    }

    /**
     * Compares fields in memory with those in the database
     * returns true if any are different, false if not.
     * Populates $fieldNames with names of fields that have changed.
     * NOTE: must be populated
     *
     * @param array $fieldNames This is just another way of returning more information besides the boolean.
     *
     * @return boolean
     */
    public function hasChanged($fieldNames)
    {
    	/*
        $table_name = $this->table_name;
        $id_field   = $this->id_field;
        $id         = $this->getID();

        if (!$table_name) {
            $this->error = "hasChange(): No table name set";
            return false;
        }

        if (!$id) {
            $this->error = "hasChanged(): id not set";
            return false;
        }

        $query  = "SELECT * FROM `$table_name` WHERE $id_field='$id'";
        $result = sycle_query($query);
        if (!$result) {
            $this->error = "HasChanged(): " . sycle_query_error();
            return false;
        }

        $has_changed = false;
        $field_names = array();
        $row         = mysql_fetch_array($result, MYSQL_ASSOC);
        foreach ($row as $field_name => $val) {
            if ($val == 'NULL') {
                $val = '';
            }

            $obj_val = $this->get($field_name);
            if ($obj_val == 'NULL') {
                $obj_val = '';
            }


            // for date and decimal fields, coerce an empty value to an appropriate 0 value
            if (!$obj_val && ($val == '0000-00-00' || $val == '0000-00-00 00:00:00' || $val == '0.00')) {
                $obj_val = $val;
            }

            if (is_array($obj_val)) {

                // Arrays break trim.
                // So just try to grab the first value out of the array.
                $obj_val = current($obj_val);

            }

            if (($obj_val || $val) && (trim($obj_val) != trim($val))) {

                $has_changed   = true;
                $field_names[] = $field_name;
            }
        }

        return $has_changed;*/
    }
}
