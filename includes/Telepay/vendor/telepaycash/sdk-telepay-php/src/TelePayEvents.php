<?php
namespace TelePay;

/**
 * This class is a enumeration of the events that can be subscribed to.
 */
class TelePayEvents
{
    const ALL = "all";

    const INVOICE_COMPLETED = "invoice.completed";
    const INVOICE_CANCELLED = "invoice.cancelled";
    const INVOICE_EXPIRED = "invoice.expired";

    const WITHDRAWAL_CREATED = "withdrawal.created";
    const WITHDRAWAL_APPROVED = "withdrawal.approved";
    const WITHDRAWAL_AUDITING = "withdrawal.auditing";
    const WITHDRAWAL_PERFORMING = "withdrawal.performing";
    const WITHDRAWAL_CONFIRMING = "withdrawal.confirming";
    const WITHDRAWAL_FAILED = "withdrawal.failed";
    const WITHDRAWAL_COMPLETED = "withdrawal.completed";

    static protected $events = [
        self::ALL,
        self::INVOICE_COMPLETED,
        self::INVOICE_CANCELLED,
        self::INVOICE_EXPIRED,
        self::WITHDRAWAL_CREATED,
        self::WITHDRAWAL_APPROVED,
        self::WITHDRAWAL_AUDITING,
        self::WITHDRAWAL_PERFORMING,
        self::WITHDRAWAL_CONFIRMING,
        self::WITHDRAWAL_FAILED,
        self::WITHDRAWAL_COMPLETED
    ];

    static function validate($event)
    {
        if (!in_array($event, self::$events)) {
            throw new TelePayException("Invalid TelePay event: " . $event);
        }
    }
}
