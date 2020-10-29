<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shipping Entity
 *
 * @property int $id
 * @property int $bidinfo_id
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property bool $is_shipped
 * @property bool $is_received
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Bidinfo $bidinfo
 */
class Shipping extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'bidinfo_id' => true,
        'name' => true,
        'address' => true,
        'phone_number' => true,
        'is_shipped' => true,
        'is_received' => true,
        'created' => true,
        'modified' => true,
        'bidinfo' => true,
    ];
}
