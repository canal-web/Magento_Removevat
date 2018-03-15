<?php
/**
 * DATASOLUTION - djean
 * Date: 2018/03/15
 */
class Canalweb_Removevat_Model_Tax_Calculation extends Mage_Tax_Model_Calculation {

    /**
     * Calculate rated tax amount based on price and tax rate.
     * If you are using price including tax $priceIncludeTax should be true.
     *
     * @param   float $price
     * @param   float $taxRate
     * @param   boolean $priceIncludeTax
     * @param   boolean $round
     * @return  float
     */
    public function calcTaxAmount($price, $taxRate, $priceIncludeTax = false, $round = true)
    {
        if(Mage::helper('canalweb_removevat')->isVatEligible()){
            $taxRate = $taxRate / 100;

            if ($priceIncludeTax) {
                $amount = $price * (1 - 1 / (1 + $taxRate));
            } else {
                $amount = $price * $taxRate;
            }

            if ($round) {
                return $this->round($amount);
            }

            return $amount;
        }

        return 0;
    }

}