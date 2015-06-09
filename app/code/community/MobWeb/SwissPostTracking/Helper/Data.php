<?php

class MobWeb_SwissPostTracking_Helper_Data extends Mage_Shipping_Helper_Data
{
    protected function _getTrackingUrl($key, $model, $method = 'getId')
    {
        // Try and get a reference to the tracking code
        if($model INSTANCEOF Mage_Sales_Model_Order || $model INSTANCEOF Mage_Sales_Model_Order_Shipment) {

            // We can only link directly if there is just one tracking code
            $trackingCodes = $model->getTracksCollection();
            if($trackingCodes && $trackingCodes->count() === 1) {
                $trackingCode = $trackingCodes->getFirstItem();
            }
        }

        if($model INSTANCEOF Mage_Sales_Model_Order_Shipment_Track) {
            $trackingCode = $model;
        }

        // Check if the required tracking code values for the link have been set
        if(isset($trackingCode['title']) && isset($trackingCode['number']) && $trackingCode['number']) {
            $title = $trackingCode['title'];
            $number = $trackingCode['number'];

            // If the parcel was sent using Swiss Post, link directly to the Track & Trace website
            if(strpos($title, 'Swiss Post') !== false || strpos($title, 'Schweizerische Post') !== false || strpos($title, 'Poste Suisse') !== false || strpos($title, 'Posta Svizzera') !== false) {
                return sprintf('https://service.post.ch/EasyTrack/submitParcelData.do?formattedParcelCodes=%s', $number);
            }
        }

         if (empty($model)) {
             $param = array($key => ''); // @deprecated after 1.4.0.0-alpha3
         } else if (!is_object($model)) {
             $param = array($key => $model); // @deprecated after 1.4.0.0-alpha3
         } else {
             $param = array(
                 'hash' => Mage::helper('core')->urlEncode("{$key}:{$model->$method()}:{$model->getProtectCode()}")
             );
         }

         $storeId = is_object($model) ? $model->getStoreId() : null;
         $storeModel = Mage::app()->getStore($storeId);
         return $storeModel->getUrl('shipping/tracking/popup', $param);
    }
}
