<?php

class Canalweb_Removevat_Helper_Data extends Mage_Customer_Helper_Data {

    const CUSTOMER_HAS_TO_PAY_VAT = 1;
    const CUSTOMER_HASNT_TO_PAY_VAT = 0;

    /**
     * Returns 0 if VAT number is valid AND shipping country is different than origin country
     */
    public function isVatEligible()
    {
        if($shippingAddress = Mage::helper('checkout')->getQuote()->getShippingAddress()){

            $core_helper = Mage::helper('core');

            $merchantCountryCode = $core_helper->getMerchantCountryCode();
            $customerCountryCode = $shippingAddress->getCountryId();

            $vatId = $shippingAddress->getVatId();
            $countryId = $shippingAddress->getCountryId();

            if($merchantCountryCode == $customerCountryCode){
                return self::CUSTOMER_HAS_TO_PAY_VAT;
            }

            $cacheId = 'vat_check_number_'. $vatId .'_incountry_'. $countryId;
            $cacheTag = 'vat_check_number';
            if ($data_to_be_cached = Mage::app()->getCache()->load($cacheId)) {
                $isValidVat = unserialize($data_to_be_cached);
            } else {
                $isValidVat = $this->checkVatNumber($countryId, $vatId)->getIsValid();
                $data_to_be_cached = $isValidVat;
                Mage::app()->getCache()->save(serialize($data_to_be_cached), $cacheId, array($cacheTag));
            }

            if ($isValidVat) {
                return self::CUSTOMER_HASNT_TO_PAY_VAT;
            }
        }

        return self::CUSTOMER_HAS_TO_PAY_VAT;
    }
}