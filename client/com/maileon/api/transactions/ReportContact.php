<?php
/**
 * A wrapper for a transaction report contact
 *
 * @author Balogh Viktor <balogh.viktor@maileon.hu> | Maileon - Wanadis Kft.
 */
class com_maileon_api_transactions_ReportContact extends com_maileon_api_json_AbstractJSONWrapper {
    /**
     * The id of this contact
     * 
     * @var int 
     */
    public $id;
    /**
     * The extrenal id of this contact
     * 
     * @var string 
     */
    public $external_id;
    /**
     * The email address of this contact
     * 
     * @var string 
     */
    public $email;
    /**
     * The type string of this contact
     * 
     * @var string 
     */
    public $type;
    /**
     * The permission of the contact
     * 
     * @var com_maileon_api_contacts_Permission
     */
    public $permission;
    /**
     * Whether the contact was created
     * 
     * @var boolean 
     */
    public $created;
    
    function fromArray($object_vars) {
        parent::fromArray($object_vars);
        
        if($this->permission !== null) {
            $this->permission = new com_maileon_api_contacts_Permission( $this->permission );
        }
    }
}
