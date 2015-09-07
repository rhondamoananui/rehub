<?php

namespace Keywordrush\AffiliateEgg;
/*
 Name: Ebay.com
 URI: http://www.ebay.com
 Icon: http://www.google.com/s2/favicons?domain=ebay.com
 CPA: 
 */
/**
 * EbaycomParser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class EbaycomParser extends ShopParser {

    protected $charset = 'utf-8';
    protected $currency = 'USD';    
    
    public function parseCatalog($max)
    {
 	return array_slice($this->xpathArray(".//ul[@id='ListViewInner']//h3/a/@href"), 0, $max);
    }

    public function parseTitle()
    {
        return $this->xpathScalar(".//h1[@itemprop='name']/text()");
        
    }

    public function parseDescription()
    {
        $res = $this->xpathArray(".//div[@id='desc_div']/node()[normalize-space()][not(contains(., script))]");
        return sanitize_text_field(implode(' ', $res));
    }

    public function parsePrice() {
       $res = (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//span[@itemprop='price']"));
       if(!$res)
        $res = (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//span[@id='mm-saleDscPrc']"));
       return $res;
           
    }

    public function parseOldPrice() {
        return (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//span[@id='mm-saleOrgPrc']"));
    }

    public function parseManufacturer()
    {
        return $this->xpathScalar(".//h2[@itemprop='brand']");
    }

    public function parseImg()
    {
        $res = '';
        $results = $this->xpathScalar(".//script[contains(.,'image.src=')]");
        preg_match("/image\.src=\s'(.+?)'/msi",$results,$match);        
        if(isset($match[1]))
            $res = $match[1];
        return $res;
    }

    public function parseImgLarge()
    {
        $res = '';
        if ($this->item['orig_img'])
            $res = preg_replace('/\/\$_\d+\./', '/$_57.', $this->item['orig_img']);
        return $res;        
    }

    public function parseExtra()
    {
        $extra = array();

        preg_match("/\/(\d{12})/msi",$this->getUrl(),$match);
        $extra['item_id'] = isset($match[1]) ? $match[1] : '';

        $extra['features'] = array();

        $names = $this->xpathArray(".//div[@class='itemAttr']//tr/td[position() mod 2 = 1]");
        $values = $this->xpathArray(".//div[@class='itemAttr']//tr/td[position() mod 2 = 0]");
        $feature = array();
        for ($i = 0; $i < count($names); $i++)
        {
            if (!empty($values[$i]) && $names[$i] != 'Condition:'  && $names[$i] != 'Brand:')
            {
                $feature['name'] = str_replace(":","",$names[$i]);
                $feature['value'] = $values[$i];
                $extra['features'][] = $feature;
            }
        }
        
        $extra['images'] = array();
        $results = $this->xpathArray(".//div[@id='vi_main_img_fs_slider']//img/@src");
        foreach ($results as $i => $res)
        {
            if ($i == 0)
                continue;
	    if ($res)
	    {
                $new_res = preg_replace('/\/\$_\d+\./', '/$_57.', $res);
                if($new_res !== $res)
                {
                    $extra['images'][] = $new_res;
                }
	    }
        }
        return $extra;
    }

    public function isInStock()
    {
        $res = $this->xpath->evaluate("boolean(.//span[@class='msgTextAlign'][contains(.,'This listing has ended')])");
        if(!$res)
            $res = $this->xpath->evaluate("boolean(.//span[@class='msgTextAlign'][contains(.,'This Buy It Now listing has ended')])");
        return ($res) ? false : true;        
    }

}
