<?php if (!empty($bidinfo)) : ?>
    <h2>「<?= $bidinfo->biditem->name ?>」の配送情報</h2>
    <?php if (isset($shippingTo) && (int)$shippingTo->is_shipped === 1 && (int)$shippingTo->is_received === 1) : ?>
        <h3>取引完了</h3>
    <?php else : ?>
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
            <?php if ($authuser['id'] === $bidder_id) : ?>
                <?php if ((int)$shippingTo->is_shipped === 1) : ?>
                    <h3>出品者様が商品を発送しました。</h3>
                    <a href="<?= $this->Url->build(['action' => 'itemReceived']); ?>?id=<?= $shippingTo->id; ?>" class="notification">受取完了</a>
                <?php else : ?>
                    <h3>商品の発送をお待ちください。</h3>
                <?php endif; ?>
            <?php elseif ($authuser['id'] === $exhibitor_id) : ?>
                <?php if ((int)$shippingTo->is_shipped === 1) : ?>
                    <h3>受取完了連絡待ち。</h3>
                <?php else : ?>
                    <a href="<?= $this->Url->build(['action' => 'itemShipped']); ?>?id=<?= $shippingTo->id; ?>" class="notification">発送完了</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($authuser['id'] === $bidder_id && !isset($shippingTo)) : ?>
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
        <?php if ($authuser['id'] === $exhibitor_id && !isset($shippingTo)) : ?>
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
<?php else : ?>
    <h2>※落札情報はありません。</h2>
<?php endif; ?>