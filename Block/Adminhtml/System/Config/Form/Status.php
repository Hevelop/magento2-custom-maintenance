<?php
/**
 * @category       Creatuity
 * @package        Magento 2 Custom Maintenance
 * @copyright      Copyright (c) 2008-2017 Creatuity Corp. (http://www.creatuity.com)
 * @license        http://creatuity.com/license/
 */

namespace Creatuity\CustomMaintenance\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\MaintenanceMode;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template;

class Status extends Field
{
    /**
     * @var MaintenanceMode
     */
    protected $maintenanceMode;

    public function __construct(
        MaintenanceMode $maintenanceMode,
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->maintenanceMode = $maintenanceMode;
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $html = 'Status: maintenance mode is <strong>' . ($this->maintenanceMode->isOn() ? 'active' : 'not active') . '</strong><br/>';
        $addressInfo = $this->maintenanceMode->getAddressInfo();
        $addresses = implode(', ', $addressInfo);
        $html .= 'List of exempt IP-addresses: ' . ($addresses ? $addresses : 'none');


        return $html;
    }
}
