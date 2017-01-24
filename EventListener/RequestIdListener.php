<?php

namespace SnowFlake\RequestIdBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class RequestIdListener
{
    /** @var string */
    private $headerName;

    /** @var string */
    private $prefix;

    /** @var bool */
    private $overrideExisting;

    public function __construct($headerName, $prefix, $overrideExisting)
    {
        $this->headerName = $headerName;
        $this->prefix = $prefix;
        $this->overrideExisting = $overrideExisting;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onEarlyKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $existingHeader = $request->headers->get($this->headerName);

        // if we should not override existing header with the same name, then skip the rest
        if(!$this->overrideExisting && !empty($existingHeader)){
            return;
        }

        $session = $request->getSession();

        if($session !== null){
            $userUniqueId = $session->getId();
        }
        else{
            $userUniqueId = "";
        }

        // building parts of the final request ID
        $requestIdParts = [];
        $phpUniqueId = uniqid("", true);

        if(!empty($this->prefix)){
            $requestIdParts[] = $this->prefix;
        }

        if(!empty($userUniqueId)){
            $requestIdParts[] = $userUniqueId;
        }

        if(sizeof($requestIdParts) > 0){
            $requestIdParts[] = $phpUniqueId;
            $requestId = implode("__", $requestIdParts);
        }
        else{
            $requestId = $phpUniqueId;
        }

        $request->headers->set($this->headerName, $requestId);
    }
}
