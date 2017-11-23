<?php

namespace Creatuity\CustomMaintenance\Controller\Adminhtml\Maintenance;

use Magento\Backend\App\Action;
use Magento\Framework\App\MaintenanceMode;

class Disable extends Action
{

    /**
     * @var MaintenanceMode
     */
    protected $maintenanceMode;

    public function __construct(
        Action\Context $context,
        MaintenanceMode $maintenanceMode
    )
    {
        parent::__construct($context);
        $this->maintenanceMode = $maintenanceMode;
    }

    public function execute()
    {
        $this->maintenanceMode->set(false);

        return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
    }
}
