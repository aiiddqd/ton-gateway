<?php
namespace TelePay;

/**
 * This  exception represent a exception of TelePay.
 */
class TelePayException extends \Exception
{
    /**
     * @var int HTTP status code, such as 403, 404, 500, etc.
     */
    private $statusCode;

    /**
     * @var int HTTP status code, such as 403, 404, 500, etc.
     */
    private $error;

    /**
     * Constructor.
     * @param string $message error message
     * @param int $status HTTP status code, such as 404, 500, etc.
     * @param string $error type error
     */
    public function __construct($message, $status = 500, $error = 'unexpected-error')
    {
        $this->statusCode = $status;
        $this->error = $error;
        parent::__construct($message);
    }

    public function getName()
    {
        return 'TelePay Exception';
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getError()
    {
        return $this->error;
    }
}