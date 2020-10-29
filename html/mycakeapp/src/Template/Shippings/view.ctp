<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shipping $shipping
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Shipping'), ['action' => 'edit', $shipping->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Shipping'), ['action' => 'delete', $shipping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipping->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shippings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shipping'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="shippings view large-9 medium-8 columns content">
    <h3><?= h($shipping->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($shipping->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($shipping->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone Number') ?></th>
            <td><?= h($shipping->phone_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($shipping->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bidinfo Id') ?></th>
            <td><?= $this->Number->format($shipping->bidinfo_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($shipping->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($shipping->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Shipped') ?></th>
            <td><?= $shipping->is_shipped ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Received') ?></th>
            <td><?= $shipping->is_received ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
