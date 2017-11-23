<?php
/**
 * A wrapper class for a single transaction processing report
 *
 * @author Balogh Viktor <balogh.viktor@maileon.hu> | Maileon - Wanadis Kft.
 */
class com_maileon_api_transactions_ProcessingReport extends com_maileon_api_json_AbstractJSONWrapper {
    /**
     * The contact this transaction was sent to
     * 
     * @var com_maileon_api_transactions_ReportContact 
     */
    public $contact;
    
    /**
     * Whether this transaction was succesfully queued
     * 
     * @var boolean
     */
    public $queued;
    
    /**
     * The error message (if there was any)
     * 
     * @var string 
     */
    public $message;
    
    function __construct() {
        $this->contact = new com_maileon_api_transactions_ReportContact();
    }
}
