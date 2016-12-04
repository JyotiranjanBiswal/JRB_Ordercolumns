<?php
/**
* JRB_Ordercolumns_Model_Observer
* 
* @category   JRB
* @package    JRB_Ordercolumns
* @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
*/
class JRB_Ordercolumns_Model_Observer
{
    /**
    * @category   JRB
    * @package    JRB_Ordercolumns
    * @method     addNewColumnToOrderGrid
    * @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
    * 
    * @return     will add column to ordergrid through recent block object
    */
    public function addNewColumnToOrderGrid(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
       
        if( ($block instanceof Mage_Adminhtml_Block_Sales_Order_Grid)  ) {
            
            $block->addColumnAfter('postcode',
                array(
                    'header'=> Mage::helper('catalog')->__('Postcode'),
                    'index' => 'postcode'
                ),
                'shipping_name'
            );
            
            $block->addColumnAfter('company',
                array(
                    'header'=> Mage::helper('catalog')->__('Company'),
                    'index' => 'company'
                ),
                'postcode'
            );
        }
    }
    /**
    * @category   JRB
    * @package    JRB_Ordercolumns
    * @method     addNewColumnToOrderGrid
    * @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
    * 
    * @return     will set the collection with join query to the recent collection
    */
    public function beforeCollectionLoad(Varien_Event_Observer $observer)
    {
        $collection = $observer->getCollection();
        if (!isset($collection)) {
            return;
        }
        /**
        * Mage_Sales_Model_Resource_Order_Grid_Collection
        */
        if ($collection instanceof Mage_Sales_Model_Resource_Order_Grid_Collection) {
            /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
            $collection->getSelect()->joinInner(
                 array(
                     'order_address' => 'sales_flat_order_address'
                 ),
                 'order_address.parent_id = main_table.entity_id'
             )->group(array('main_table.entity_id', 'order_address.parent_id'));
        }
    }
    /**
    * @category   JRB
    * @package    JRB_Ordercolumns
    * @method     addNewColumnToOrderGrid
    * @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
    * 
    * @return     will set the collection with join query to the recent collection
    */
    public function beforeGridCollectionLoad(Varien_Event_Observer $observer){
        $collection = $observer->getOrderGridCollection();
        if (!isset($collection)) {
            return;
        }
        if ($collection instanceof Mage_Sales_Model_Resource_Order_Grid_Collection) {
           /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
           $collection->getSelect()->joinInner(
                array(
                    'order_address' => 'sales_flat_order_address'
                ),
                'order_address.parent_id = main_table.entity_id'
            )->group(array('main_table.entity_id', 'order_address.parent_id'));
        }
    }
}