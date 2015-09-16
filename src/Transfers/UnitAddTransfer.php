<?php
namespace Hitmeister\Component\Api\Transfers;

/**
 * This class was auto generated. Please, do not modify it!
 *
 * @codeCoverageIgnore
 *
 * @property int $id_item
 * @property string $ean
 * @property string $condition
 * @property int $listing_price
 * @property int $minimum_price
 * @property int $amount
 * @property string $id_offer
 * @property string $note
 * @property string $delivery_time
 * @property string $location
 *
 *
 */
class UnitAddTransfer extends AbstractTransfer
{
    /**
     * @return array
     */
    public function getProperties()
    {
        static $properties = array (
  'id_item' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'ean' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'condition' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'listing_price' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'minimum_price' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'amount' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'id_offer' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'note' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'delivery_time' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
  'location' => 
  array (
    'embedded' => false,
    'is_multiple' => false,
  ),
);
        return $properties;
    }
}