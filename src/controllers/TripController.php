<?php

namespace app\controllers;

use app\models\Service;
use app\models\ServiceUser;
use app\models\Trip;
use app\models\TripSearch;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TripController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Trip models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TripSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trip model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Trip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Trip();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // Сохраняем связи с пользователями
                if (!empty($model->user_ids)) {
                    foreach ($model->user_ids as $userId) {
                        Yii::$app->db->createCommand()->insert('trip_user', [
                            'trip_id' => $model->id,
                            'user_id' => $userId,
                        ])->execute();
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Trip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException|Exception if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->user_ids = $model->getUsers()->select('id')->column();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $userIds = $model->user_ids ?: [];

                Yii::$app->db->createCommand()
                    ->delete('trip_user', ['trip_id' => $model->id])
                    ->execute();

                foreach ($userIds as $userId) {
                    Yii::$app->db->createCommand()
                        ->insert('trip_user', ['trip_id' => $model->id, 'user_id' => $userId])
                        ->execute();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAddService()
    {
        $model = new ServiceUser();

        if ($model->load(Yii::$app->request->post())) {
            $userIds = Yii::$app->request->post('ServiceUser')['user_ids'] ?? [];

            foreach ($userIds as $userId) {
                $serviceUser = new ServiceUser();
                $serviceUser->trip_id = $model->trip_id;
                $serviceUser->service_id = $model->service_id;
                $serviceUser->start_date = $model->start_date;
                $serviceUser->end_date = $model->end_date;
                $serviceUser->user_id = $userId;
                $serviceUser->save();
            }

            Yii::$app->session->setFlash('success', 'Услуга добавлена участникам.');
            return $this->redirect(['trip/view', 'id' => $model->trip_id]);
        }

        Yii::$app->session->setFlash('error', 'Ошибка при добавлении услуги.');
        return $this->redirect(Yii::$app->request->referrer ?: ['trip/index']);
    }


    /**
     * Deletes an existing Trip model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Trip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Trip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trip::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
