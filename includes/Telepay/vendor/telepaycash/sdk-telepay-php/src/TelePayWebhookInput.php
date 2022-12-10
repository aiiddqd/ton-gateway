<?php

namespace TelePay;

/**
 * This class is a input of the webhook endpoint.
 */
class TelePayWebhookInput
{
    /** @var string $url*/
    protected $url;

    /** @var string $secret */
    protected $secret;

    /** @var array events */
    protected $events = [];

    /** @var bool $active */
    protected $active;

    /**
     * Constructor.
     * 
     * @param string $url
     * @param string $secret
     * @param array $events is an array of events to subscribe to.
     * @see TelePayEvents::validate()
     */
    public function __construct($url, $secret, $events, $active = true)
    {
        $this->setUrl($url);
        $this->setSecret($secret);
        $this->setEvents($events);
        $this->setActive($active);
    }
    public function getBodyPrepared()
    {
        $body = [
            "url" => $this->url,
            "secret" => $this->secret,
            "events" => $this->events,
        ];
        if ($this->active !== null) {
            $body["active"] = $this->active;
        }
        return $body;
    }

    /**
     * Set and get the url.
     */
    public function getUrl()
    {
        return $this->url;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Set and get the secret.
     */
    public function getSecret()
    {
        return $this->secret;
    }
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Set and get the events.
     */
    public function getEvents()
    {
        return $this->events;
    }
    public function setEvents($events)
    {
        if (!is_array($events)) {
            $events = [$events];
        }
        foreach ($events as $event) {
            TelePayEvents::validate($event);
        }
        $this->events = $events;
    }

    /**
     * Set and get the active.
     */
    public function getActive()
    {
        return $this->active;
    }
    public function setActive($active)
    {
        $this->active = $active;
    }
}
