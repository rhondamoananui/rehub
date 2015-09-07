<?php

namespace Keywordrush\AffiliateEgg;
/*
 Name: Amazon.in
 URI: http://www.amazon.in
 Icon: http://www.google.com/s2/favicons?domain=amazon.in
 CPA: 
 */

/**
 * AmazoninParser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class AmazoninParser extends ShopParser {

    protected $charset = 'utf-8';
    protected $currency = 'INR';

    public function parseCatalog($max) {
        $urls = array_slice($this->xpathArray(".//h3[@class='newaps']/a/@href"), 0, $max);
        if (!$urls) {
            $urls = array_slice($this->xpathArray(".//a[contains(@class,'s-access-detail-page')]/@href"), 0, $max);
        }
        if (!$urls) {
            $urls = array_slice($this->xpathArray(".//div[@class='zg_title']/a/@href"), 0, $max);
        }

        return $urls;
    }

    public function parseTitle() {
        return $this->xpathScalar(".//h1[@id='title']/span");
    }

    public function parseDescription() {
        $descr = '';
        $results = $this->xpathScalar(".//script[contains(.,'iframeContent')]");
        preg_match('/iframeContent\s=\s"(.+?)"/msi', $results, $match);
        if (isset($match[1])) {
            $res = urldecode($match[1]);
            preg_match('/class="productDescriptionWrapper">(.+?)</msi', $res, $match);
            if (isset($match[1]))
                $descr = trim($match[1]);
        }
        if (!$descr) {
           $results = $this->xpathArray(".//div[@id='featurebullets_feature_div']//span[@class='a-list-item']"); 
           $descr = implode(";\n", $results);
        }  
        if (!$descr) {
           $results = $this->xpathArray(".//div[@id='featurebullets_feature_div']//li"); 
           $descr = implode(";\n", $results);
        }               
        return $descr;
    }

    public function parsePrice() {
        return (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//span[@id='priceblock_ourprice']|.//span[@id='priceblock_dealprice']|.//span[@id='priceblock_saleprice']"));
    }

    public function parseOldPrice() {
        return (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//div[@id='price']//td[contains(@class,'a-text-strike')]"));
    }

    public function parseManufacturer() {
        return $this->xpathScalar(".//a[@id='brand']");
    }

    public function parseImg() {
        return $this->xpathScalar(".//img[@id='landingImage']/@src");
    }

    public function parseImgLarge() {
        return $this->xpathScalar(".//img[@id='landingImage']/@data-old-hires");
    }

    public function parseExtra() {
        $extra = array();

        $extra['comments'] = array();
        $users = $this->xpathArray(".//div[@id='revMHRL']//span[@class='a-size-normal']/a[@class='noTextDecoration']");
        $dates = $this->xpathArray(".//div[@id='revMHRL']//span[@class='a-color-secondary']/span[@class='a-color-secondary']");
        $comments = $this->xpathArray(".//div[@id='revMHRL']//div[@class='a-section']");

        for ($i = 0; $i < count($comments); $i++) {
            if (!empty($comments[$i])) {

                $comment['name'] = sanitize_text_field($users[$i]);
                $date = str_replace("on ","",$dates[$i]);
                $comment['date'] = strtotime($date);

                $comment['comment'] = sanitize_text_field($comments[$i]);
                $extra['comments'][] = $comment;
            }
        }

        preg_match("/\/dp\/(.+?)\//msi", $this->getUrl(), $match);
        $extra['item_id'] = isset($match[1]) ? $match[1] : '';

        $extra['features'] = array();

        $names = $this->xpathArray(".//div[@id='prodDetails']//div[contains(@class,'col1')]//td[@class='label']");
        $values = $this->xpathArray(".//div[@id='prodDetails']//div[contains(@class,'col1')]//td[@class='value']");
        $feature = array();
        for ($i = 0; $i < count($names); $i++) {
            if (!empty($values[$i]) && $names[$i] != 'Condition:' && $names[$i] != 'Brand:') {
                $feature['name'] = str_replace(":", "", $names[$i]);
                $feature['value'] = $values[$i];
                $extra['features'][] = $feature;
            }
        }

        $names2 = $this->xpathArray(".//div[@id='technical-details_feature_div']//div[@class='a-row']//th");
        $values2 = $this->xpathArray(".//div[@id='technical-details_feature_div']//div[@class='a-row']//td");
        $feature2 = array();
        for ($i = 0; $i < count($names2); $i++) {
            if (!empty($values2[$i]) && $name2[$i] != 'Condition:' && $names2[$i] != 'Brand:') {
                $feature2['name'] = str_replace(":", "", $names2[$i]);
                $feature2['value'] = $values2[$i];
                $extra['features'][] = $feature2;
            }
        }        

        if (!$extra['features']) {
            $results = $this->xpathArray(".//div[@id='technical-data']//li");
            if ($results) {
                foreach ($results as $res) {
                    $expl = explode(":", $res, 2);
                    if (count($expl) == 2) {
                        $feature['name'] = sanitize_text_field($expl[0]);
                        $feature['value'] = sanitize_text_field($expl[1]);
                        $extra['features'][] = $feature;
                    }
                }
            }
        }
               
        
        $extra['images'] = array();
        $results = $this->xpathArray(".//div[@id='altImages']//ul/li//span[contains(@data-thumb-action, 'image')]//img/@src");

        foreach ($results as $i => $res) {
            if ($i == 0)
                continue;
            if ($res) {
                $res = str_replace('._SS40_', '', $res);
                $res = str_replace('._US40_', '', $res);
                $extra['images'][] = $res;
            }
        }
        return $extra;
    }

    public function isInStock() {

        return $this->xpath->evaluate("boolean(.//div[@id='availability']/span[contains(@class,'a-color-success')])");
        //return $this->xpath->evaluate("boolean(.//div[@id='availability'][contains(.,'In Stock')])");
    }

}
