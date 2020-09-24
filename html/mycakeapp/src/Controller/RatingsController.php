<?php

namespace App\Controller;

use App\Controller\AppController;
use Exception; // added.

/**
 * Ratings Controller
 *
 * @property \App\Model\Table\RatingsTable $Ratings
 *
 * @method \App\Model\Entity\Rating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RatingsController extends AuctionBaseController
{

    // デフォルトテーブルを使わない
    public $useTable = false;

    // 初期化処理
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        // 必要なモデルをすべてロード
        $this->loadModel('Users');
        $this->loadModel('Biditems');
        $this->loadModel('Bidrequests');
        $this->loadModel('Bidinfo');
        $this->loadModel('Bidmessages');
        $this->loadModel('Ratings');
        $this->loadModel('Shippings');
        // ログインしているユーザー情報をauthuserに設定
        $this->set('authuser', $this->Auth->user());
        // レイアウトをauctionに変更
        $this->viewBuilder()->setLayout('auction');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bidinfo'],
        ];
        $ratings = $this->paginate($this->Ratings);

        $this->set(compact('ratings'));
    }

    /**
     * View method
     *
     * @param string|null $id Rating id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rating = $this->Ratings->get($id, [
            'contain' => ['Bidinfo'],
        ]);

        $this->set('rating', $rating);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($bidinfo_id = null)
    {
        // idが$bidinfo_idのBidinfoを変数$bidinfoに格納
        $bidinfo = $this->Bidinfo->get($bidinfo_id, [
            'contain' => ['Biditems', 'Biditems.Users', 'Users']
        ]);

        // 出品者ID、落札者IDをそれぞれ定義
        $exhibitor_id = $bidinfo->biditem->user_id;
        $bidder_id = $bidinfo->user_id;

        // 上の二つをアクセスを許可するユーザのIDに設定し配列$permitted_idに格納
        $permitted_id = array($exhibitor_id, $bidder_id);

        // ログイン中のユーザIDが$permitted_idに含まれない場合は、アクセスを許可せずindexにリダイレクト
        if (!in_array($this->Auth->user('id'), $permitted_id)) {
            $this->Flash->error('アクセス権限がありません。');
            return $this->redirect(['action' => 'index']);
        }
        // POST送信時の処理
        if ($this->request->is('post')) {
            //インスタンスを用意
            $rating = $this->Ratings->newEntity();
            $rating = $this->Ratings->patchEntity($rating, $this->request->getData());

            $rating['bidinfo_id'] = $bidinfo_id;
            //ログイン中のユーザが出品者の場合は、落札者を評価,ログイン中のユーザが落札者の場合は、出品者を評価
            if ($this->Auth->user('id') === $exhibitor_id) {
                $rating['rated_user_id'] = $bidinfo->user_id;
            } elseif ($this->Auth->user('id') === $bidder_id) {
                $rating['rated_user_id'] = $bidinfo->biditem->user_id;
            }

            $rating['rated_by_user_id'] = $this->Auth->user('id');

            if ($this->Ratings->save($rating)) {
                $this->Flash->success(__('取引評価の保存をしました'));

                return $this->redirect([
                    'controller' => 'auction', 'action' => 'contact',
                    $rating->bidinfo_id
                ]);
            }
            $this->Flash->error(__('保存に失敗しましたもう一度やり直してください'));
        }
        $bidinfo = $this->Ratings->Bidinfo->find('list', ['limit' => 200]);
        $this->set(compact('rating', 'bidinfo'));
    }

    public function ratings()
    {
        // 評価一覧への表示内容を設定
        $authuser_id = $this->Auth->user()['id'];
        $reviews = $this->Ratings->find('all')
            ->where(['rated_user_id' => $authuser_id])
            ->contain(['Users'])
            ->order(['Ratings.id' => 'desc']);

        $this->paginate = ['limit' => 10];
        $reviews = $this->paginate($reviews);
        $this->set(compact('reviews', 'authuser_id'));

        //平均評価を設定
        $avg = round(collection($reviews)->avg('rating'), 1);
        $this->set(compact('avg'));
    }
}
