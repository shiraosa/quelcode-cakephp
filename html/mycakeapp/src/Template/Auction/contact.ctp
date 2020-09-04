<?php if (!empty($bidinfo)) : ?>
    <h2>「<?= $bidinfo->biditem->name ?>」の配送情報</h2>
    <?php if ($authuser['id'] === $bidder_id) : ?>
        <?php if (isset($shippingTo)) : ?>
            <table class="vertical-table">
                <tr>
                    <th scope="row">受取人名前</th>
                    <td><?= $shippingTo->name ?></td>
                </tr>
                <tr>
                    <th scope="row">配送先住所</th>
                    <td><?= $shippingTo->address ?></td>
                </tr>
                <tr>
                    <th scope="row">受取人連絡先</th>
                    <td><?= $shippingTo->phone_number ?></td>
                </tr>
            </table>
        <?php else : ?>
            <?= $this->Form->create($shippingInfo, ['action' => 'shipping']) ?>
            <fieldset>
                <legend>※配送先情報を入力：</legend>
                <?php
                echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]);
                echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
                echo '<p><strong>USER: ' . $authuser['username'] . '</strong></p>';
                echo $this->Form->control('name', ['placeholder' => '受取人の名前を入力してください。']);
                echo $this->Form->control('address', ['placeholder' => '住所を入力してください。']);
                echo $this->Form->control('phone_number', ['placeholder' => '000-0000-0000 のフォーマットで入力してください。']);
                echo $this->Form->hidden('is_shipped', ['value' => 0]);
                echo $this->Form->hidden('is_received', ['value' => 0]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($authuser['id'] === $exhibitor_id) : ?>
        <?php if (isset($shippingTo)) : ?>
            <table class="vertical-table">
                <tr>
                    <th scope="row">受取人名前</th>
                    <td><?= $shippingTo->name ?></td>
                </tr>
                <tr>
                    <th scope="row">配送先住所</th>
                    <td><?= $shippingTo->address ?></td>
                </tr>
                <tr>
                    <th scope="row">受取人連絡先</th>
                    <td><?= $shippingTo->phone_number ?></td>
                </tr>
            </table>
        <?php else : ?>
            <table class="vertical-table">
                <tr>
                    <th scope="row">受取人名前</th>
                </tr>
                <tr>
                    <th scope="row">配送先住所</th>
                </tr>
                <tr>
                    <th scope="row">受取人連絡先</th>
                </tr>
            </table>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>