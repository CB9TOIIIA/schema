<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Magic

class ElementSchema  extends Element
{
    
    public function hasValue($params = array())
    {
        // Magic
        return true;
    }
    
    
    public function edit()
    {
        // Magic
        return true;
    }
    
    
    public function render($params = array())
    {
        
        
        $Photo_mode = $this->config->get('photo_mode');
        $PhotoElList = $this->config->get('photoElList');
        $PhotoElementId = $this->config->get('PhotoElementId');
        $defaultphoto = $this->config->get('defaultphoto');
        $Price_mode = $this->config->get('price_mode');
        $Pricejbpriceplain = $this->config->get('jbpriceplain');
        $Pricejbpricecalc = $this->config->get('jbpricecalc');
        $PriceElementId = $this->config->get('PriceElementId');
        $JBprice_kop_enabled = $this->config->get('jbprice_kop_enabled');
        $JBZooPriceWithDiscount_enabled = $this->config->get('JBZooPriceWithDiscount_enabled');
        $Brand_mode = $this->config->get('brand_mode');
        $BrandListElementId = $this->config->get('brandListElementId');
        $BrandElementId = $this->config->get('brandElementId');
        $Brandsimpletext = $this->config->get('brandsimpletext');
        $Manufacturer_mode = $this->config->get('manufacturer_mode');
        $ManufacturerListElementId = $this->config->get('manufacturerListElementId');
        $ManufacturerElementId = $this->config->get('manufacturerElementId');
        $Manufacturersimpletext = $this->config->get('manufacturersimpletext');
        $Textteaser_mode = $this->config->get('textteaser_mode');
        $TeasertextListElementId = $this->config->get('teasertextListElementId');
        $TeasertextElementId = $this->config->get('teasertextElementId');
        $Teasertextsimpletext = $this->config->get('teasertextsimpletext');
        $ogtype_enabled = $this->config->get('ogtype_enabled');
        $ogtype_image_show = $this->config->get('ogtype_image_show');
        $ogtype_type_show = $this->config->get('ogtype_type_show');
        $ogtype_title_show = $this->config->get('ogtype_title_show');
        $ogtype_site_name_show = $this->config->get('ogtype_site_name_show');
        $ogtype_url_show = $this->config->get('ogtype_url_show');
        $ogtype_description_show = $this->config->get('ogtype_description_show');
        $ogtype_description_mode = $this->config->get('ogtype_description_mode');
        $ogtype_text_def = $this->config->get('ogtype_text_def');
        $razmetka_mode = $this->config->get('razmetka_mode');
        $razmetka_tech_mode = $this->config->get('razmetka_tech_mode');
        $mode_generator_tag_joomla = $this->config->get('mode_generator_tag_joomla');
        $JBZoo_el_debug = $this->config->get('jbzoo_el_debug');
        
        // dump($this->config,0,'$this->config');
        
        // ФОТО
        
        if ($Photo_mode == 0) {
            $JBZooElPhoto = $PhotoElList;
        }
        else {
            $JBZooElPhoto = $PhotoElementId;
        }
        
        // Цена
        
        if ($Price_mode == 0) {
            $JBZooElPrice = $Pricejbpriceplain;
        }
        if ($Price_mode == 1) {
            $JBZooElPrice = $Pricejbpricecalc;
        }
        if ($Price_mode == 2) {
            $JBZooElPrice = $PriceElementId;
        }
        
        $CategoryPrimaryId = $this->_item->getParams()->get('config.primary_category');
        $CategoryPrimaryObj = $this->app->table->category->get($CategoryPrimaryId);
        $CategoryPrimaryName = $CategoryPrimaryObj->name;
        
        // Цена
        
        if ($Brand_mode == 0) {
            $JBZooElBrand = NULL;
        }
        if ($Brand_mode == 1) {
            $JBZooElBrand = $BrandListElementId;
        }
        if ($Brand_mode == 2) {
            $JBZooElBrand = $CategoryPrimaryName;
        }
        if ($Brand_mode == 3) {
            $JBZooElBrand = $BrandElementId;
        }
        if ($Brand_mode == 4) {
            $JBZooElBrand = $Brandsimpletext;
        }
        
        if ($Manufacturer_mode == 0) {
            $JBZooElManufacturer = NULL;
        }
        if ($Manufacturer_mode == 1) {
            $JBZooElManufacturer = $ManufacturerListElementId;
        }
        if ($Manufacturer_mode == 2) {
            $JBZooElManufacturer = $CategoryPrimaryName;
        }
        if ($Manufacturer_mode == 3) {
            $JBZooElManufacturer = $ManufacturerElementId;
        }
        if ($Manufacturer_mode == 4) {
            $JBZooElManufacturer = $Manufacturersimpletext;
        }
        
        // Описание товара
        
        if ($Textteaser_mode == 0) {
            $JBZooElTextteaser = NULL;
        }
        if ($Textteaser_mode == 1) {
            $JBZooElTextteaser = $TeasertextListElementId;
        }
        if ($Textteaser_mode == 2) {
            $JBZooElTextteaser = $TeasertextElementId;
        }
        if ($Textteaser_mode == 3) {
            $JBZooElTextteaser = $Teasertextsimpletext;
        }
        
        // OG разметка товара
        
        $docshema = JFactory::getDocument();
        
        $JBZooPhoto = $this->_item->getElement($JBZooElPhoto)->data();
        $JBZooPhoto = $this->app->data->create($JBZooPhoto);
        $JBZooPhoto = $JBZooPhoto->find('0.file', $defaultphoto);
        $JBZooPhoto = JURI::base().$JBZooPhoto;
        
        $JBZooPrice = $this->_item->getElement($JBZooElPrice)->data()->variations;
        $JBZooElPrice = $this->app->data->create($JBZooPrice);
        $JBZooPrice = $JBZooElPrice->find('0._value.value', 'Уточняйте по телефону');


        if (!empty($JBZooPrice)) {
            $CB_Balance = $JBZooElPrice->find('0._balance.value');
        }
   
        if ($CB_Balance == "-1") { $CB_Balance = "Есть в наличии"; }
        if ($CB_Balance == "-2") { $CB_Balance = "Под заказ"; }
        if ($CB_Balance > 0 || NULL == $CB_Balance) { $CB_Balance = $CB_Balance; }
        if (empty($CB_Balance)) { $CB_Balance = "Под заказ"; }

        $money = JBCart::val($JBZooPrice);
        $Valuta = $money->cur();

        if ($Valuta == "rub") { $Valuta = "RUB"; }
        if ($Valuta == "usd") { $Valuta = "USD"; }
        if ($Valuta == "eur") { $Valuta = "EUR"; }


        if ($JBprice_kop_enabled == 1) {
            $JBZooPrice = round($JBZooPrice,0);
        }


        if ($JBZooPriceWithDiscount_enabled == 1) {

            $JBZooPriceWithDiscount = $JBZooElPrice->find('0._discount.value');
            $pregpercent = preg_match('/%/',$JBZooPriceWithDiscount,$pregpercent);

            if ($pregpercent == 1) {
                $JBZooPriceWithDiscount = str_replace('%','',$JBZooPriceWithDiscount);
                $JBZooPrice =  $JBZooPrice - ($JBZooPrice * ($JBZooPriceWithDiscount / 100));
            }

            else {
                $JBZooPrice = $JBZooPrice - $JBZooPriceWithDiscount;
            }
        
        }

        $JBZooSkuItem = $JBZooElPrice->find('0._sku.value', 'Артикул не найден');
        
        $CategoryPrimaryId = $this->_item->getParams()->get('config.primary_category');
        $CategoryPrimaryObj = $this->app->table->category->get($CategoryPrimaryId);
        $CategoryPrimaryName = $CategoryPrimaryObj->name;
        
        $ItemName = $this->_item->name;
        $ItemName = strip_tags(trim($ItemName));
        $ItemName = str_replace('"','',$ItemName);
        $ItemName = str_replace("'","",$ItemName);
        
        $JBZooTeaserText = NULL;
        if ($Textteaser_mode == 0 || $Textteaser_mode == 1 || $Textteaser_mode == 2) {
            $JBZooTeaserText = $this->_item->getElement($JBZooElTextteaser)->data();
            $JBZooTeaserText = $this->app->data->create($JBZooTeaserText);
            $JBZooTeaserText = $JBZooTeaserText->find('0.value', $CategoryPrimaryName.' '.$ItemName);
            $JBZooTeaserText = trim(strip_tags($JBZooTeaserText));
        }
        else {
             $JBZooTeaserText = $Teasertextsimpletext;
        }
        
        
        if($ogtype_enabled == 1):
        
        if(NULL !== $this->_item->getElement($ogtype_text_def)){
            $OGJBZooTeaserText = $this->_item->getElement($ogtype_text_def)->data();
            $OGJBZooTeaserText = $this->app->data->create($OGJBZooTeaserText);
            $OGJBZooTeaserText = $OGJBZooTeaserText->find('0.value', NULL);
            $OGJBZooTeaserText = trim(strip_tags($OGJBZooTeaserText));
        }
        else {
            $OGJBZooTeaserText = NULL;
        }
        
        endif;
        
        if ($Brand_mode != 2 && $Brand_mode != 4 && NULL !== $JBZooElBrand) {
            
            $JBZooBrand = $this->_item->getElement($JBZooElBrand)->data();
            $JBZooBrand = $this->app->data->create($JBZooBrand);
            $JBZooBrand = $JBZooBrand->find('0.value', $CategoryPrimaryName.' '.$ItemName);
            $JBZooBrand = trim(strip_tags($JBZooBrand));
            if (!empty($JBZooBrand)) {
                 $JBZooBrand = $this->_item->getElement($JBZooElBrand)->render();
            }
            
        }
        else {
            $JBZooBrand = $JBZooElBrand;
        }
        
        if ($Manufacturer_mode != 2 && $Manufacturer_mode != 4 && NULL !== $JBZooElManufacturer) {
            
            $JBZooManufacturer = $this->_item->getElement($JBZooElManufacturer)->data();
            $JBZooManufacturer = $this->app->data->create($JBZooManufacturer);
            $JBZooManufacturer = $JBZooManufacturer->find('0.value', $CategoryPrimaryName.' '.$ItemName);
            $JBZooManufacturer = trim(strip_tags($JBZooManufacturer));
             if (!empty($JBZooManufacturer)) {
                 $JBZooManufacturer = $this->_item->getElement($JBZooElManufacturer)->render();
            }
        }
        else {
            $JBZooManufacturer = $JBZooElManufacturer;
        }
        
        
        if($ogtype_enabled == 1):
        
        if($ogtype_title_show == 1) {     $docshema->setMetaData('og:title', $docshema->title);  }
        if($ogtype_type_show == 1) {      $docshema->setMetaData('og:type', 'website' );  }
        if($ogtype_url_show == 1) {       $docshema->setMetaData('og:url', $this->app->jbrouter->externalItem($this->_item));  }
        if($ogtype_image_show == 1) {     $docshema->setMetaData('og:image', $JBZooPhoto ); }
        if($ogtype_site_name_show == 1) { $docshema->setMetaData('og:site_name', JFactory::getApplication()->getCfg('sitename') ); }
        $JBZooOgTags = $docshema->_metaTags['name'];
        
        // dump($docshema,0,'docshema');
        
        $JBZooOgTags = implode("\n",$JBZooOgTags);
        
        if($ogtype_description_show == 1) {
            
            if($ogtype_description_mode == 1) {
                $docshema->setMetaData('og:description', $OGJBZooTeaserText );
            }
            
            if($ogtype_description_mode == 0) {
                $docshema->setMetaData('og:description', $docshema->description );
            }
        }
        
        if($mode_generator_tag_joomla == 1) {
            $docshema->setGenerator('');
        }
        
        endif;
        
        if($razmetka_mode == 1):
        
        $schemaproduct =
        '<script type="application/ld+json">{
            "@context": "http://schema.org",
            "@type": "Product",
            "name": "'.$ItemName.'",
            "description": "'.$JBZooTeaserText.'",
            "category": "'.$CategoryPrimaryName.'",
            "image": "'.$JBZooPhoto.'",
            "model": "'.$JBZooSkuItem.'",';
            
            if(NULL !== $JBZooElManufacturer) :
            $schemaproduct .= '
            "manufacturer":{
                "@type": "Organization",
                "name": "'.$JBZooManufacturer.'"
            }, ';
            endif;
            
            if(NULL !== $JBZooElBrand) :
            $schemaproduct .= '
            "brand":{
                "@type": "Organization",
                "name": "'.$JBZooBrand.'"
            }, ';
            endif;
            
            $schemaproduct .= '
            "offers": {
                "@type": "Offer",
                "price": "'.$JBZooPrice.'",
                "priceCurrency":  "'.$Valuta.'",
                "availability": "'.$CB_Balance.'"
            }
        }
        </script>';
        
        $shemamicrodata = "
        
        <div style='display:none'>
        
        <!--Указывается схема Product.-->
        <div itemscope itemtype='http://schema.org/Product'>
        
        <!--В поле name указывается наименование товара.-->
        <span itemprop='name'>{$ItemName}</span>
        
        <!--В поле description дается описание товара.-->
        <span itemprop='description'>{$JBZooTeaserText}</span>
        
        <!--В поле image указывается ссылка на картинку товара.-->
        <img src='{$JBZooPhoto}' itemprop='image'>
        
        <!--Указывается схема Offer.-->
        <div itemprop='offers' itemscope itemtype='http://schema.org/Offer'>
        
        <!--В поле price указывается цена товара.-->
        <span itemprop='price'>{$JBZooPrice}</span>
        
        <!--В поле priceCurrency указывается валюта.-->
        <span itemprop='priceCurrency'>{$Valuta}</span>
        
        <div>{$CB_Balance}</div>
        <link itemprop='availability' href='http://schema.org/InStock'>
        
        </div>
        
        </div>
        
        </div>
        
        ";
        
        if($razmetka_tech_mode == 0) {
            
            $docshema->addCustomTag($schemaproduct);
            
        }
        if($razmetka_tech_mode == 1) {
            
            echo $shemamicrodata;
            
        }
        if($razmetka_tech_mode == 2) {
            
            $docshema->addCustomTag($schemaproduct);
            
            echo $shemamicrodata;
        }
        
        
        endif;
        
        if ($JBZoo_el_debug == 1) {
            
            echo '<h2>Debug ON JBZooOgTags</h2>';
            echo '<pre>';
            echo '<textarea style="width: 90%; height: 550px;" rows="100" cols="150">';
            echo  @$JBZooOgTags;
            echo '</textarea>';
            echo '</pre>';
            echo '<h2>Debug ON schemaproduct</h2>';
            echo '<pre>';
            echo '<textarea style="width: 90%; height: 550px;" rows="100" cols="150">';
            echo  @$schemaproduct;
            echo '</textarea>';
            echo '</pre>';
            echo '<h2>Debug ON shemamicrodata</h2>';
            echo '<pre>';
            echo '<textarea style="width: 90%; height: 550px;" rows="100" cols="150">';
            echo  @$shemamicrodata;
            echo '</textarea>';
            echo '</pre>';
            
        }
        
        
    }
    
}