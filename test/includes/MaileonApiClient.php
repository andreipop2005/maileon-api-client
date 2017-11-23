<?php
/**
 * This serves as the main include file for the Maileon PHP API client. To use the API
 * client, include this file into your script. For example, if you place the API into your
 * webservers PHP include folder (recommended) you can use it like this
 * <code>
 * require_once($_SERVER['DOCUMENT_ROOT'].'/includes/MaileonApiClient.php');
 * </code>
 *
 * @author Felix Heinrichs | Trusted Mails GmbH | <a href="mailto:felix.heinrichs@trusted-mails.com">felix.heinrichs@trusted-mails.com</a>
 * @author Marcus St&auml;nder | Trusted Mails GmbH | <a href="mailto:marcus.staender@trusted-mails.com">marcus.staender@trusted-mails.com</a>
 */

// Set our classloader for com_maileon_... classes
spl_autoload_register('classloader', true, true);

function test_classloader($className)
{
    if (strpos($className, "com_maileon") === 0) {
        return classloader($className);
    }
}

if (defined('RUNNING_IN_PHPUNIT') && RUNNING_IN_PHPUNIT) {
    spl_autoload_register('test_classloader');
}

$debug = false;

initializeStaticClasses();

/**
 * This method must be called as static variables as used for contacts_SynchronizationMode
 * cannot automatically be initialized
 */
function initializeStaticClasses()
{
    com_maileon_api_contacts_SynchronizationMode::init();
    com_maileon_api_contacts_Permission::init();
    com_maileon_api_contacts_StandardContactField::init();
    com_maileon_api_contactevents_DataType::init();
    com_maileon_api_transactions_DataType::init();
}

/**
 * Sets up the logging framework, e.g. KLogger. Currently no logger framework is provided anymore to avoid incompatibilities.
 * This method has to be used if other
 * log levels or log directories shall be used than the defaults. The defaults
 * are
 * <ul>
 * <li><strong>logDirectory</strong>: ./log</li>
 * <li><strong>logLevel</strong>: KLogger::DEBUG</li>
 * </ul>
 *
 * @param String $logDirectory
 * @param unknown $logLevel
 */
function setupLogging($logDirectory, $logLevel)
{

}

/**
 * Convenience method for logging and raising an error state (exception).
 *
 * @param String $message
 * @throws Exception
 */
function apiError($message)
{

}

/**
 * Returns true if the general debug mode is enabled
 *
 * @return boolean
 */
function isDebug()
{
    return XQDebug::isDebug();
}

/**
 * General debug settings
 *
 * @author Marcus St&auml;nder | Trusted Mails GmbH | <a href="mailto:marcus.staender@trusted-mails.com">marcus.staender@trusted-mails.com</a>
 */
class XQDebug
{

    private static $debug = false;

    /**
     *
     * @param boolean $isDebug
     */
    public static function setDebug($isDebug)
    {
        XQDebug::$debug = $isDebug;
    }

    public static function isDebug()
    {
        return XQDebug::$debug;
    }
}

/**
 * Classloader for api project setup.
 *
 * @param unknown $className
 * @throws Exception
 */
function classloader($className)
{
    $base = dirname(__FILE__);
    $path = explode('_', $className);
    $last = array_pop($path);

    $class = strtolower(implode('/', $path)) . "/" . $last;
    $file = $base . "/" . $class . ".php";

    // The namespace uses \ as separators. As the namespace itself is part of the directory structure, replace those by /
    $file = str_replace('\\', '/', $file);

    if (XQDebug::isDebug() == true) echo '[Classloader] Loading class <b>' . $className . '</b> from file: ' . $file . '<br />';

    if (file_exists($file)) {
        require_once $file;
    } else {
        apiError('Class "' . $className . '" could not be loaded from: "' . $file . '". Make sure the file exists in the given path.');
    }
}
