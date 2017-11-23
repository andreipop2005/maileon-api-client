<?php

/**
 * A type descriptor class for attribute definitions.
 *
 * The supported data types are string, double, float, integer, boolean, timestamp and json.
 *
 * @author Viktor Balogh | Wanadis Kft. |  <a href="balogh.viktor@maileon.hu">balogh.viktor@maileon.hu</a>
 * @author Marcus St&auml;nder | Trusted Technologies GmbH | <a href="mailto:marcus.staender@trusted-technologies.de">marcus.staender@trusted-technologies.de</a>
 */
class com_maileon_api_transactions_DataType
{
    public static $STRING;
    public static $DOUBLE;
    public static $FLOAT;
    public static $INTEGER;
    public static $BOOLEAN;
    public static $TIMESTAMP;
    public static $JSON;

    private static $initialized = false;

    // TODO use a more sensible name for this concept, e.g. "type descriptor"
    /**
     *
     * @var string $value
     *  A string that describes the datatype. Valid values are "string", "double", "float",
     *  "integer", "boolean", "timestamp" and "json".
     */
    public $value;

    static function init()
    {
        if (self::$initialized == false) {
            self::$STRING = new com_maileon_api_transactions_DataType("string");
            self::$DOUBLE = new com_maileon_api_transactions_DataType("double");
            self::$FLOAT = new com_maileon_api_transactions_DataType("float");
            self::$INTEGER = new com_maileon_api_transactions_DataType("integer");
            self::$BOOLEAN = new com_maileon_api_transactions_DataType("boolean");
            self::$TIMESTAMP = new com_maileon_api_transactions_DataType("timestamp");
            self::$JSON = new com_maileon_api_transactions_DataType("json");
            self::$initialized = true;
        }
    }

    /**
     * Creates a new DataType object.
     *
     * @param string $value
     *  a string describing the data type. Valid values are "string", "double", "float",
     *  "integer", "boolean", "timestamp" and "json".
     */
    function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return \em string
     *  the type descriptor string of this DataType. Can be "string", "double", "float",
     *  "integer", "boolean", "timestamp" or "json".
     */
    function getValue()
    {
        return $this->value;
    }

    /**
     * Get the permission object by type descriptor.
     *
     * @param string $value
     *  a type descriptor string. Can be "string", "double", "float",
     *  "integer", "boolean", "timestamp" or "json".
     * @return \em com_maileon_api_transactions_DataType
     *  the DataType object
     */
    static function getDataType($value)
    {
        switch ($value) {
            case "string":
                return self::$STRING;
            case "double":
                return self::$DOUBLE;
            case "float":
                return self::$FLOAT;
            case "integer":
                return self::$INTEGER;
            case "boolean":
                return self::$BOOLEAN;
            case "timestamp":
                return self::$TIMESTAMP;
            case "json":
                return self::$JSON;

            default:
                return null;
        }
    }
}