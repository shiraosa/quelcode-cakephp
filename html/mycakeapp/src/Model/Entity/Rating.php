<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rating Entity
 *
 * @property int $id
 * @property int $rated_user_id
 * @property int $rated_by_user_id
 * @property int $bidinfo_id
 * @property int $rating
 * @property string $comment
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\RatedUser $rated_user
 * @property \App\Model\Entity\RatedByUser $rated_by_user
 * @property \App\Model\Entity\Bidinfo $bidinfo
 */
class Rating extends Entity
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
        'rated_user_id' => true,
        'rated_by_user_id' => true,
        'bidinfo_id' => true,
        'rating' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'rated_user' => true,
        'rated_by_user' => true,
        'bidinfo' => true,
    ];
}
