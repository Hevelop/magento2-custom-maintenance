<?php
/**
 * @category       Creatuity
 * @package        Magento 2 Custom Maintenance
 * @copyright      Copyright (c) 2008-2017 Creatuity Corp. (http://www.creatuity.com)
 * @license        http://creatuity.com/license/
 */

namespace Creatuity\CustomMaintenance\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ButtonEnable extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $url = $this->getUrl('adminhtml/maintenance/enable');

        $button = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')
            ->setData([
                'id' => 'enable_button',
                'label' => __('Enable'),
                'onclick' => "window.location='{$url}';",
            ]);

        return $button->toHtml();
    }
}
