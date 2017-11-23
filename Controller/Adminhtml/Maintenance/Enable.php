<?php

namespace Creatuity\CustomMaintenance\Controller\Adminhtml\Maintenance;

use Creatuity\CustomMaintenance\Model\Adminhtml\Error\Handler;
use Magento\Backend\App\Action;
use Magento\Framework\App\MaintenanceMode;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Setup\Validator\IpValidator;

class Enable extends Action
{

    /**
     * @var MaintenanceMode
     */
    protected $maintenanceMode;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var IpValidator
     */
    protected $ipValidator;
    /**
     * @var Handler
     */
    protected $errorHandler;
    /**
     * @var RemoteAddress
     */
    protected $remoteAddress;

    public function __construct(
        Action\Context $context,
        MaintenanceMode $maintenanceMode,
        ScopeConfigInterface $scopeConfig,
        IpValidator $ipValidator,
        Handler $errorHandler,
        RemoteAddress $remoteAddress
    )
    {
        parent::__construct($context);
        $this->maintenanceMode = $maintenanceMode;
        $this->scopeConfig = $scopeConfig;
        $this->ipValidator = $ipValidator;
        $this->errorHandler = $errorHandler;
        $this->remoteAddress = $remoteAddress;
    }

    public function execute()
    {
        $this->maintenanceMode->set(true);

        //Check list of ip address
        $addresses = $this->scopeConfig->getValue("creatuity_custommaintenance/enable_disable/addresses");
        if (!empty($addresses)) {
            $addresses = explode(',', $addresses);
            //validate
            $messages = $this->ipValidator->validateIps($addresses, false);
            if (!empty($messages)) {
                $e = new \Exception(implode("\n", $messages));
                $this->errorHandler->handle($e, implode("\n", $messages));
                return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
            }
        } else {
            $addresses = [];
        }

        //Set addresses to maintencanceMode
        $addresses[] = $this->remoteAddress->getRemoteAddress(); //Add current user ip address
        $addresses = array_unique($addresses);
        $addresses = implode(',', $addresses);
        $this->maintenanceMode->setAddresses($addresses);

        return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
    }
}
