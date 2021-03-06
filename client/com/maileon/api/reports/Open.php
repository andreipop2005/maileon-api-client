<?php

/**
 * This class represents an opener containing the timestamp, the contact, and the ID of the mailing the open.
 *
 * @author Marcus St&auml;nder | Trusted Mails GmbH | <a href="mailto:marcus.staender@trusted-mails.com">marcus.staender@trusted-mails.com</a>
 */
class com_maileon_api_reports_Open extends com_maileon_api_xml_AbstractXMLWrapper
{
    /**
     * @var long
     */
    public $timestamp;

    /**
     * @var com_maileon_api_reports_ReportContact
     */
    public $contact;

    /**
     * @var long
     */
    public $mailingId;

    /**
     * @return \em string
     *  containing a human-readable representation of this open
     */
    function toString()
    {
        return "Open [timestamp=" . $this->timestamp .
        ", contact=" . $this->contact->toString() .
        ", mailingId=" . $this->mailingId . "]";
    }

    /**
     * @return \em csv string
     *  containing a csv pepresentation of this open
     */
    function toCsvString()
    {
        return $this->timestamp .
        ";" . $this->contact->toCsvString() .
        ";" . $this->mailingId;
    }

    /**
     * Initializes this open from an XML representation.
     *
     * @param SimpleXMLElement $xmlElement
     *  the XML representation to use
     */
    function fromXML($xmlElement)
    {
        $this->contact = new com_maileon_api_reports_ReportContact();
        $this->contact->fromXML($xmlElement->contact);

        if (isset($xmlElement->mailing_id)) $this->mailingId = $xmlElement->mailing_id;
        if (isset($xmlElement->timestamp)) $this->timestamp = $xmlElement->timestamp;
    }

    /**
     * For future use, not implemented yet.
     *
     * @return \em SimpleXMLElement
     *  containing the XML serialization of this object
     */
    function toXML()
    {
        // Not implemented yet.
    }
}
