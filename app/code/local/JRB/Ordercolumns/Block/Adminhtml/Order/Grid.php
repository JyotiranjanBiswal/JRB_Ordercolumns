<?php
/**
* JRB_Ordercolumns_Block_Adminhtml_Order_Grid
* 
* @category   JRB
* @package    JRB_Ordercolumns
* @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
*/
class JRB_Ordercolumns_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    /**
    * @category   JRB
    * @package    JRB_Ordercolumns
    * @method     addNewColumnToOrderGrid
    * @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
    * 
    * @return     will set the collection with join query to the recent collection
    */
    public function setCollection($collection)
    {
        $collection->getSelect()->joinInner(
            array(
                'order_address' => 'sales_flat_order_address'
            ),
            'order_address.parent_id = main_table.entity_id'
        )->group(array('main_table.entity_id', 'order_address.parent_id'));
        
        parent::setCollection($collection);
    }
    /**
    * @category   JRB
    * @package    JRB_Ordercolumns
    * @method     addNewColumnToOrderGrid
    * @author     Jyotiranjan Biswal <biswal@jyotiranjan.in>
    * 
    * @return     will add column to ordergrid through recent block object
    */
    protected function _prepareColumns()
    {
        $this->addColumnAfter('postcode',
            array(
                'header'=> Mage::helper('catalog')->__('Postcode'),
                'index' => 'postcode'
            ),
            'shipping_name'
        );
        
        $this->addColumnAfter('company',
            array(
                'header'=> Mage::helper('catalog')->__('Company'),
                'index' => 'company'
            ),
            'postcode'
        );
        
        return parent::_prepareColumns();
    }
    
}