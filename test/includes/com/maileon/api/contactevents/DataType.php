<?php

/**
 * A type descriptor class for attribute definitions.
 *
 * The supported data types are string, double, float, integer, boolean and timestamp.
 *
 * @author Marcus St&auml;nder | Trusted Mails GmbH | <a href="mailto:marcus.staender@trusted-mails.com">marcus.staender@trusted-mails.com</a>
 */
class com_maileon_api_contactevents_DataType
{
    public static $STRING;
    public static $DOUBLE;
    public static $FLOAT;
    public static $INTEGER;
    public static $BOOLEAN;
    public static $TIMESTAMP;

    private static $initialized = false;

    // TODO use a more sensible name for this concept, e.g. "type descriptor"
    /**
     *
     * @var string $value
     *  A string that describes the datatype. Valid values are "string", "double", "float",
     *  "integer", "boolean" and "timestamp".
     */
    public $value;

    static function init()
    {
        if (self::$initialized == false) {
            self::$STRING = new com_maileon_api_contactevents_DataType("string");
            self::$DOUBLE = new com_maileon_api_contactevents_DataType("double");
            self::$FLOAT = new com_maileon_api_contactevents_DataType("float");
            self::$INTEGER = new com_maileon_api_contactevents_DataType("integer");
            self::$BOOLEAN = new com_maileon_api_contactevents_DataType("boolean");
            self::$TIMESTAMP = new com_maileon_api_contactevents_DataType("timestamp");
            self::$initialized = true;
        }
    }

    /**
     * Creates a new DataType object.
     *
     * @param string $value
     *  a string describing the data type. Valid values are "string", "double", "float",
     *  "integer", "boolean" and "timestamp".
     */
    function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return \em string
     *  the type descriptor string of this DataType. Can be "string", "double", "float",
     *  "integer", "boolean" or "timestamp".
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
     *  "integer", "boolean" or "timestamp".
     * @return \em com_maileon_api_contacts_Permission
     *  the permission object
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

            default:
                return null;
        }
    }
}