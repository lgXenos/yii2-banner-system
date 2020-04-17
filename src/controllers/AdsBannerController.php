<?php

namespace lgxenos\yii2\banner\controllers;

use Yii;
use lgxenos\yii2\banner\models\AdsBanner;
use lgxenos\yii2\banner\models\AdsBannerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * AdsBannerController implements the CRUD actions for AdsBanner model.
 */
class AdsBannerController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete'     => ['post'],
					'bulkdelete' => ['post'],
				],
			],
		];
	}
	
	/**
	 * Список всех AdsBanner моделей
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new AdsBannerSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	/**
	 * Отображает одну выбранную AdsBanner модель
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {
		$request = Yii::$app->request;
		if ($request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			
			return [
				'title'   => "AdsBanner #" . $id,
				'content' => $this->renderAjax('view', [
					'model' => $this->findModel($id),
				]),
				'footer'  => Html::button('Закрыть', [
						'class'        => 'btn btn-default pull-left',
						'data-dismiss' => "modal",
					]) .
					Html::a('Правка', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
			];
		}
		else {
			return $this->render('view', [
				'model' => $this->findModel($id),
			]);
		}
	}
	
	/**
	 * Добавляет запись в модельку AdsBanner     * Для аякс-запросов - возвращает ответ в формате json
	 * и для не аяксов, если создание успешно редиректит браузер на страницу просмотра
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$request = Yii::$app->request;
		$model   = new AdsBanner();
		
		if ($request->isAjax) {
			/*
			*   Обработка аякс-запроса
			*/
			Yii::$app->response->format = Response::FORMAT_JSON;
			if ($request->isGet) {
				return [
					'title'   => "Добавить запись AdsBanner",
					'content' => $this->renderAjax('create', [
						'model' => $model,
					]),
					'footer'  => Html::button('Закрыть', [
							'class'        => 'btn btn-default pull-left',
							'data-dismiss' => "modal",
						]) .
						Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"]),
				
				];
			}
			else if ($model->load($request->post()) && $model->save()) {
				return [
					'forceReload' => '#crud-datatable-pjax',
					'title'       => "Добавить запись AdsBanner",
					'content'     => '<span class="text-success">Создание AdsBanner успешно</span>',
					'footer'      => Html::button('Закрыть', [
							'class'        => 'btn btn-default pull-left',
							'data-dismiss' => "modal",
						]) .
						Html::a('Добавить еще', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
				
				];
			}
			else {
				return [
					'title'   => "Добавить запись AdsBanner",
					'content' => $this->renderAjax('create', [
						'model' => $model,
					]),
					'footer'  => Html::button('Закрыть', [
							'class'        => 'btn btn-default pull-left',
							'data-dismiss' => "modal",
						]) .
						Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"]),
				
				];
			}
		}
		else {
			/*
			*   Обработка обычного, не аякс-запроса
			*/
			if ($model->load($request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
		}
		
	}
	
	/**
	 * Редактирует существующую запись модели AdsBanner     * Для аякс-запросов - возвращает ответ в формате json
	 * и для не аяксов, если правка успешна редиректит браузер на страницу просмотра
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$request = Yii::$app->request;
		$model   = $this->findModel($id);
		
		if ($request->isAjax) {
			/*
			*   Обработка аякс-запроса
			*/
			Yii::$app->response->format = Response::FORMAT_JSON;
			if ($request->isGet) {
				return [
					'title'   => "Правка AdsBanner #" . $id,
					'content' => $this->renderAjax('update', [
						'model' => $model,
					]),
					'footer'  => Html::button('Закрыть', [
							'class'        => 'btn btn-default pull-left',
							'data-dismiss' => "modal",
						]) .
						Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"]),
				];
			}
			else if ($model->load($request->post()) && $model->save()) {
				return [
					'forceReload' => '#crud-datatable-pjax',
					'title'       => "AdsBanner #" . $id,
					'content'     => $this->renderAjax('view', [
						'model' => $model,
					]),
					'footer'      => Html::button('Закрыть', [
							'class'        => 'btn btn-default pull-left',
							'data-dismiss' => "modal",
						]) .
						Html::a('Правка', ['update', 'id' => $id], [
							'class' => 'btn btn-primary',
							'role'  => 'modal-remote',
						]),
				];
			}
			else {
				return [
					'title'   => "Правка AdsBanner #" . $id,
					'content' => $this->renderAjax('update', [
						'model' => $model,
					]),
					'footer'  => Html::button('Закрыть', [
							'class'        => 'btn btn-default pull-left',
							'data-dismiss' => "modal",
						]) .
						Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"]),
				];
			}
		}
		else {
			/*
			*   Обработка обычного, не аякс-запроса
			*/
			if ($model->load($request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}
	}
	
	/**
	 * Удаление существующей модели AdsBanner     * Для аякс-запросов - возвращает ответ в формате json
	 * и для не аяксов, если удаление успешно редиректит браузер на index
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		$request = Yii::$app->request;
		$this->findModel($id)->delete();
		
		if ($request->isAjax) {
			/*
			*   Обработка аякс-запроса
			*/
			Yii::$app->response->format = Response::FORMAT_JSON;
			
			return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
		}
		else {
			/*
			*   Обработка обычного, не аякс-запроса
			*/
			return $this->redirect(['index']);
		}
		
	}
	
	/**
	 * Групповое удаление существующих моделей AdsBanner     * Для аякс-запросов - возвращает ответ в формате json
	 * и для не аяксов, если удаление успешно редиректит браузер на index
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function actionBulkdelete() {
		$request = Yii::$app->request;
		$pks     = explode(',', $request->post('pks')); // Array or selected records primary keys
		foreach ($pks as $pk) {
			$model = $this->findModel($pk);
			$model->delete();
		}
		
		if ($request->isAjax) {
			/*
			*   Обработка аякс-запроса
			*/
			Yii::$app->response->format = Response::FORMAT_JSON;
			
			return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
		}
		else {
			/*
			*   Обработка обычного, не аякс-запроса
			*/
			return $this->redirect(['index']);
		}
		
	}
	
	/**
	 * Ищет AdsBanner модель, основываясь на значение ее primary key
	 * Если модель не будет найдена, то выбрасывается исключение NotFoundHttpException
	 *
	 * @param string $id
	 *
	 * @return AdsBanner the loaded model
	 * @throws NotFoundHttpException если модель не будет найдена
	 */
	protected function findModel($id) {
		if (($model = AdsBanner::findOne($id)) !== null) {
			return $model;
		}
		else {
			throw new NotFoundHttpException('Запрошенная страница не существует!');
		}
	}
}
