<?php

class MobWeb_SwissPostTracking_Block_Sales_Order_Shipment_Create_Tracking extends Mage_Adminhtml_Block_Sales_Order_Shipment_Create_Tracking
{
    public function getCarriers()
    {
        // Get the carriers from the original method. Remove the following
        // line if you don't need Magento's default carriers listed here
        $carriers = parent::getCarriers();

        // Add the custom "Swiss Post" carrier to the list
        $carriers['Swiss_Post'] = $this->__('Swiss Post');
        return $carriers;
    }
}
