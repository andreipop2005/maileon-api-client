<?php

class com_maileon_api_xml_XMLDeserializer
{

    public static function deserialize($xmlElement)
    {
        if (isset($xmlElement)) {
            $result = null;
            switch (strtolower($xmlElement->getName())) {
                case "count":
                case "id":
                case "targetgroupid":
                case "count_attachments":
                    return (int)$xmlElement;
                    // __toString() caused error (not found) on several servers
                    // return (int)$xmlElement->__toString();
                case "doi_key":
                    return $xmlElement;
                case "tags":
                    return explode("#", $xmlElement);
                case "name":
                    return $xmlElement;
                case "locale":
                    return $xmlElement;
                case "event":
                    return false; // deserialization not yet supported.

                case "events":
                    return false; // deserialization not yet supported.

                case "result":
                    $result = array();
                    if (!empty($xmlElement->contact_filter_id)) $result['contact_filter_id'] = $xmlElement->contact_filter_id;
                    if (!empty($xmlElement->target_group_id) && ($xmlElement->target_group_id!=-1)) $result['target_group_id'] = $xmlElement->target_group_id;
                    return $result;

                case "contacteventtype":
                    $result = new com_maileon_api_contactevents_ContactEventType();
                    break;

                case "schedule":
                    $result = new com_maileon_api_mailings_Schedule();
                    break;

                case "contacteventtypes":
                    $result = array();
                    foreach ($xmlElement as $contactEventTypeElement) {
                        $result[] = self::deserialize($contactEventTypeElement);
                    }
                    return $result;

                case "targetgroup":
                    $result = new com_maileon_api_targetgroups_TargetGroup();
                    break;

                case "targetgroups":
                    $result = array();
                    foreach ($xmlElement as $element) {
                        $result[] = self::deserialize($element);
                    }
                    return $result;

                case "contactfilter":
                    $result = new com_maileon_api_contactfilters_ContactFilter();
                    break;

                case "contactfilters":
                    $result = array();
                    foreach ($xmlElement as $contactFilterElement) {
                        $result[] = self::deserialize($contactFilterElement);
                    }
                    return $result;

                case "contact":
                    $result = new com_maileon_api_contacts_Contact();
                    break;

                case "contacts":
                    $result = new com_maileon_api_contacts_Contacts();
                    break;
                
                case "attachment":
                    $result = new com_maileon_api_mailings_Attachment();
                    break;
                
                case "attachments":
                    $result = array();
                    foreach ($xmlElement as $attachmentElement) {
                        $result[] = self::deserialize($attachmentElement);
                    }
                    return $result;

                case "custom_fields":
                    $result = new com_maileon_api_contacts_CustomFields();
                    break;

                case "custom_fields":
                    $result = new com_maileon_api_contacts_CustomFields();
                    break;

                case "unsubscription":
                    $result = new com_maileon_api_reports_Unsubscriber();
                    break;

                case "unsubscriptions":
                    $result = array();
                    foreach ($xmlElement as $unsubscriptionElement) {
                        $result[] = self::deserialize($unsubscriptionElement);
                    }
                    return $result;

                case "subscriber":
                    $result = new com_maileon_api_reports_Subscriber();
                    break;

                case "subscribers":
                    $result = array();
                    foreach ($xmlElement as $subscriberElement) {
                        $result[] = self::deserialize($subscriberElement);
                    }
                    return $result;

                case "field_backup":
                    $result = new com_maileon_api_reports_FieldBackup();
                    break;

                case "field_backups":
                    $result = array();
                    foreach ($xmlElement as $fieldBackupElement) {
                        $result[] = self::deserialize($fieldBackupElement);
                    }
                    return $result;

                case "transaction_type":
                    $result = new com_maileon_api_transactions_TransactionType();
                    break;

                case "transaction_types":
                    $result = array();
                    foreach ($xmlElement as $transactionTypeElement) {
                        $result[] = self::deserialize($transactionTypeElement);
                    }
                    return $result;

                case "transaction_type_id":
                    return (int)$xmlElement;

                case "recipient":
                    $result = new com_maileon_api_reports_Recipient();
                    break;

                case "recipients":
                    $result = array();
                    foreach ($xmlElement as $recipientElement) {
                        $result[] = self::deserialize($recipientElement);
                    }
                    return $result;

                case "open":
                    $result = new com_maileon_api_reports_Open();
                    break;

                case "opens":
                    $result = array();
                    foreach ($xmlElement as $openElement) {
                        $result[] = self::deserialize($openElement);
                    }
                    return $result;

                case "click":
                    $result = new com_maileon_api_reports_Click();
                    break;

                case "clicks":
                    $result = array();
                    foreach ($xmlElement as $clickElement) {
                        $result[] = self::deserialize($clickElement);
                    }
                    return $result;

                case "bounce":
                    $result = new com_maileon_api_reports_Bounce();
                    break;

                case "bounces":
                    $result = array();
                    foreach ($xmlElement as $bounceElement) {
                        $result[] = self::deserialize($bounceElement);
                    }
                    return $result;

                case "unique_bounce":
                    $result = new com_maileon_api_reports_UniqueBounce();
                    break;

                case "unique_bounces":
                    $result = array();
                    foreach ($xmlElement as $bounceElement) {
                        $result[] = self::deserialize($bounceElement);
                    }
                    return $result;

                case "block":
                    $result = new com_maileon_api_reports_Block();
                    break;

                case "blocks":
                    $result = array();
                    foreach ($xmlElement as $blockElement) {
                        $result[] = self::deserialize($blockElement);
                    }
                    return $result;

                case "mailing":
                    $result = new com_maileon_api_mailings_Mailing();
                    break;

                case "mailings":
                    $result = array();
                    foreach ($xmlElement as $mailingElement) {
                        $result[] = self::deserialize($mailingElement);
                    }
                    return $result;

                case "blacklist":
                    $result = new com_maileon_api_blacklists_Blacklist();
                    break;

                case "blacklists":
                    $result = array();
                    foreach ($xmlElement as $blacklistElement) {
                        $result[] = self::deserialize($blacklistElement);
                    }
                    return $result;


                case "property":
                    $result = new com_maileon_api_mailings_CustomProperty();
                    break;

                case "properties":
                    $result = array();
                    foreach ($xmlElement as $element) {
                        $result[] = self::deserialize($element);
                    }
                    return $result;

                default:
                    $result = null;
                    break;
            }
            if ($result) {
                $result->fromXML($xmlElement);
                return $result;
            }
        }
        return false;
    }
}

?>