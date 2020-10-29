<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', array('inline' => false)); ?>
<?= $this->Html->script('jquery.plugin', array('inline' => false)); ?>
<?= $this->Html->script('jquery.countdown', array('inline' => false)); ?>

<?php
$date = new DateTime();
$today = $date->format('Y-m-d h:i a');
$end = new DateTime(h($biditem->endtime));
$endtime = $end->format('Y-m-d h:i a');
?>

<h2>「<?= $biditem->name ?>」の情報</h2>
<table class="vertical-table">
	<tr>
		<th class="small" scope="row">出品者</th>
		<td><?= $biditem->has('user') ? $biditem->user->username : '' ?></td>
	</tr>
	<tr>
		<th scope="row">商品名</th>
		<td><?= h($biditem->name) ?></td>
	</tr>
	<tr>
		<th scope="row">商品ID</th>
		<td><?= $this->Number->format($biditem->id) ?></td>
	</tr>
	<tr>
		<th scope="row">商品の詳細情報</th>
		<td><?= $this->Text->autoParagraph(h($biditem->detail)) ?></td>
	</tr>
	<tr>
		<th scope="row">商品の画像</th>
		<td><?= $this->Html->image('/img/item_image/' . h($biditem->image_path), array('height' => 200, 'width' => 200)) ?></td>
	</tr>
	<tr>
		<th scope="row">終了時間</th>
		<td><?= h($biditem->endtime) ?></td>
	</tr>
	<tr>
		<th scope="row">投稿時間</th>
		<td><?= h($biditem->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('残り時間') ?></th>
		<?php if ($today < $endtime) : ?>
			<td>
				<div id="defaultCountdown"></div>
			</td>
			<script type="text/javascript">
				$(function() {
					var endtime = new Date('<?= h($biditem->endtime) ?>');;
					$('#defaultCountdown').countdown({
						labels: ['年', '月', '週', '日', '時間', '分', '秒'],
						until: endtime
					});
				});
			</script>
		<?php else : ?>
			<td>
				<? echo "このオークションは終了しました"?>
			</td>
		<?php endif; ?>
	</tr>
</table>
<div class="related">
	<h4><?= __('落札情報') ?></h4>
	<?php if (!empty($biditem->bidinfo)) : ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th scope="col">落札者</th>
				<th scope="col">落札金額</th>
				<th scope="col">落札日時</th>
			</tr>
			<tr>
				<td><?= h($biditem->bidinfo->user->username) ?></td>
				<td><?= h($biditem->bidinfo->price) ?>円</td>
				<td><?= h($biditem->endtime) ?></td>
			</tr>
		</table>
	<?php else : ?>
		<p><?= '※落札情報は、ありません。' ?></p>
	<?php endif; ?>
</div>
<div class="related">
	<h4><?= __('入札情報') ?></h4>
	<?php if (!$biditem->finished) : ?>
		<h6><a href="<?= $this->Url->build(['action' => 'bid', $biditem->id]) ?>">《入札する！》</a></h6>
		<?php if (!empty($bidrequests)) : ?>
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th scope="col">入札者</th>
						<th scope="col">金額</th>
						<th scope="col">入札日時</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bidrequests as $bidrequest) : ?>
						<tr>
							<td><?= h($bidrequest->user->username) ?></td>
							<td><?= h($bidrequest->price) ?>円</td>
							<td><?= $bidrequest->created ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else : ?>
			<p><?= '※入札は、まだありません。' ?></p>
		<?php endif; ?>
	<?php else : ?>
		<p><?= '※入札は、終了しました。' ?></p>
	<?php endif; ?>
</div>
