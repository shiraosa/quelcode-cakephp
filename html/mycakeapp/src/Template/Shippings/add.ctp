<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shipping $shipping
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Shippings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="shippings form large-9 medium-8 columns content">
    <?= $this->Form->create($shipping) ?>
    <fieldset>
        <legend><?= __('Add Shipping') ?></legend>
        <?php
            echo $this->Form->control('bidinfo_id');
            echo $this->Form->control('name');
            echo $this->Form->control('address');
            echo $this->Form->control('phone_number');
            echo $this->Form->control('is_shipped');
            echo $this->Form->control('is_received');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
