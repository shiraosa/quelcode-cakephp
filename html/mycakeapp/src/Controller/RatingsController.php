<?php

namespace App\Controller;

use App\Controller\AppController;

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
    public function add()
    {
        $rating = $this->Ratings->newEntity();
        if ($this->request->is('post')) {
            $rating = $this->Ratings->patchEntity($rating, $this->request->getData());
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

    /**
     * Edit method
     *
     * @param string|null $id Rating id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rating = $this->Ratings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rating = $this->Ratings->patchEntity($rating, $this->request->getData());
            if ($this->Ratings->save($rating)) {
                $this->Flash->success(__('保存されました'));

                return $this->redirect([
                    'controller' => 'auction', 'action' => 'contact',
                    $rating->bidinfo_id
                ]);
            }
            $this->Flash->error(__('保存に失敗しました'));
        }
        $bidinfo = $this->Ratings->Bidinfo->find('list', ['limit' => 200]);
        $this->set(compact('rating', 'bidinfo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rating id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rating = $this->Ratings->get($id);
        if ($this->Ratings->delete($rating)) {
            $this->Flash->success(__('The rating has been deleted.'));
        } else {
            $this->Flash->error(__('The rating could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
