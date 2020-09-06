<?php
if (!empty($hasRated)) : ?>
    <h2>「<?= $bidinfo->biditem->name ?>」の取引評価</h2>
    <h1>取引完了。ご利用ありがとうございました。</h1>
    <table class="vertical-table">
        <tr>
            <th scope="row">取引相手</th>
            <?php if ($authuser['id'] === $bidder_id) : ?>
                <td><?= $bidinfo->biditem->user->username ?></td>
            <?php elseif ($authuser['id'] === $exhibitor_id) : ?>
                <td><?= $bidinfo->user->username ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <th scope="row">取引評価</th>
            <td><?= $hasRated->rating ?></td>
        </tr>
        <tr>
            <th scope="row">取引評価コメント</th>
            <td><?= $hasRated->comment ?></td>
        </tr>
    </table>
<?php endif; ?>

<?php if (!empty($bidinfo) && empty($hasRated)) : ?>
    <?php if (isset($shippingTo) && (int)$shippingTo->is_shipped === 1 && (int)$shippingTo->is_received === 1) : ?>
        <h2>「<?= $bidinfo->biditem->name ?>」の取引評価</h2>
        <h3>取引完了。取引相手を評価してください。</h3>
        <?= $this->Form->create(
            $rating,
            [
                'type' => 'post',
                'url' => ['controller' => 'Ratings', 'action' => 'add']
            ]
        ); ?>
        <table>
            <tr>
                <th>満足度を５段階で評価してください。1(悪い)~5(良い)</th>
                <td>
                    <?= $this->Form->select(
                        'rating',
                        ['' => '選択してください', '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]
                    )
                    ?>
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td><?= $this->Form->textarea('comment') ?></td>
            </tr>
        </table>
        <?php echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]); ?>
        <!-- ログイン中のユーザが出品者の場合は、落札者を評価 -->
        <?php if ($authuser['id'] === $exhibitor_id) : ?>
            <?php echo $this->Form->hidden('rated_user_id', ['value' => $bidinfo->user_id]); ?>
            <!-- ログイン中のユーザが落札者の場合は、出品者を評価 -->
        <?php elseif ($authuser['id'] === $bidder_id) : ?>
            <?php echo $this->Form->hidden('rated_user_id', ['value' => $bidinfo->biditem->user_id]); ?>
        <?php endif; ?>
        <?php echo $this->Form->hidden('rated_by_user_id', ['value' => $authuser['id']]); ?>
        <?= $this->Form->button('Submit') ?>
        <?= $this->Form->end() ?>
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
<?php endif; ?>