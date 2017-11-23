<?php

/**
 * A class for wrapping import references.
 *
 * @author Marcus Staender
 */
class com_maileon_api_transactions_ImportReference
{
    /**
     *
     * @var com_maileon_api_transactions_ImportContactReference
     *  an array identifying the contact that contains at least one of the following attributes: id/external_id/email and permission
     */
    public $contact;
    /**
     * @return \em string
     *    a human-readable representation of this ContactReference
     */
    function toString()
    {

        if (!empty($this->contact)) {
            return "ImportReference [" . $this->contact->toString() . "]";
        } else {
            return "ImportReference []";
        }
    }
}