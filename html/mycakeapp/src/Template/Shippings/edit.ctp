<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shipping $shipping
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shipping->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shipping->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shippings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="shippings form large-9 medium-8 columns content">
    <?= $this->Form->create($shipping) ?>
    <fieldset>
        <legend><?= __('Edit Shipping') ?></legend>
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
