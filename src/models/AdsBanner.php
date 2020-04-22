<?php

namespace lgxenos\yii2\banner\models;

use lgxenos\yii2\banner\BannerModule;
use Yii;
use yii\base\ErrorException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ads_banner".
 *
 * @property int               $id                  ID
 * @property string            $title               Название
 * @property string            $url                 Ссылка
 * @property string            $img                 Изображение
 * @property string            $banner_type         Тип баннера
 * @property int               $weigth              Вес
 * @property int               $show_remains        Остаток показов
 * @property int               $cnt_show            Показы
 * @property int               $cnt_click           Переходы
 * @property int               $user_id             ID пользователя
 * @property int               $area_id             ID баннерной зоны
 * @property string|null       $notice              Заметка для себя
 * @property int               $is_enabled          Включен
 * @property int               $hash                Служебный хэш
 * @property int               $created_at          Дата создания
 *
 * @property AdsArea           $area                Зона установки банера
 * @property UploadedFile|null $uploadedImg         Изображение
 */
class AdsBanner extends \yii\db\ActiveRecord {
	const ADS_AREA_TYPE_IMAGE = 'image';
	public $uploadedImg;
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'ads_banner';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['title', 'img', 'user_id', 'area_id'], 'required'],
			[['weigth', 'show_remains', 'cnt_show', 'cnt_click', 'user_id', 'area_id', 'is_enabled'], 'integer'],
			[['title'], 'string', 'max' => 250],
			[['hash'], 'string', 'max' => 32],
			[['img'], 'string', 'max' => 512],
			[['notice', 'url'], 'string', 'max' => 1024],
			[['created_at'], 'safe'],
			[['banner_type'], 'in', 'range' => array_keys(self::getTypesArray())],
			[['uploadedImg'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'           => 'ID',
			'title'        => 'Название',
			'img'          => 'Изображение',
			'uploadedImg'  => 'Изображение',
			'url'          => 'Ссылка',
			'banner_type'  => 'Тип баннера',
			'weigth'       => 'Вес',
			'show_remains' => 'Остаток показов',
			'cnt_show'     => 'Показы',
			'cnt_click'    => 'Переходы',
			'user_id'      => 'ID пользователя',
			'area_id'      => 'ID баннерной зоны',
			'notice'       => 'Заметка для себя',
			'is_enabled'   => 'Включен',
			'hash'         => 'Служебный хэш',
			'created_at'   => 'Дата создания',
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function beforeSave($insert) {
		if (empty($this->hash)) {
			$this->hash = md5(time() . $this->title);
		}
		
		/**
		 * нельзя иметь включенный баннер без остатка показов
		 */
		if (!$this->show_remains) {
			$this->is_enabled = 0;
		}
		
		return parent::beforeSave($insert);
	}
	
	public function save($runValidation = true, $attributeNames = null) {
		$moduleInstance    = BannerModule::getModuleInstance();
		$this->uploadedImg = UploadedFile::getInstance($this, 'uploadedImg');
		// 
		if ($this->uploadedImg) {
			$userId           = Yii::$app->user->identity->getId();
			$targetFileFolder = str_replace('%USER_ID%', "user_{$userId}", Yii::getAlias($moduleInstance->uploadPath));
			\yii\helpers\FileHelper::createDirectory($targetFileFolder, $mode = 0775, $recursive = true);
			
			$fileName = date("Y-d-m_H-i-s") . '.' . $this->uploadedImg->extension;
			if (!$this->uploadedImg->saveAs($targetFileFolder . $fileName)) {
				throw new ErrorException('Ошибка загрузки файла: ' . $targetFileFolder . $fileName);
			}
			
			$this->uploadedImg = null;
			$this->deleteImg();
			$targetWebFolder = str_replace('%USER_ID%', "user_{$userId}", $moduleInstance->uploadWebPath);
			$this->img       = $targetWebFolder . $fileName;
		}
		
		return parent::save($runValidation, $attributeNames);
	}
	
	/**
	 * предовтращаем удаление активных баннеров
	 *
	 * @return false|int
	 * @throws ErrorException
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function delete() {
		if ($this->show_remains) {
			throw new ErrorException('Нельзя удалять активные баннера');
		}
		$this->deleteImg();
		
		return parent::delete();
	}
	
	public function deleteImg() {
		if (empty($this->img)) {
			return;
		}
		preg_match("|/(user_\d+/.+)|", $this->img, $matches);
		$fileName = $matches[1];
		$filePath = str_replace('%USER_ID%', $fileName, (BannerModule::getModuleInstance())->uploadPath);
		$filePath = Yii::getAlias(rtrim($filePath, ' /'));
		
		if (file_exists($filePath)) {
			unlink($filePath);
		}
	}
	
	/**
	 * Реляция на банеры
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getArea() {
		//                             <--------------->
		return $this->hasOne(AdsArea::class, ['id' => 'area_id']);
		//                                              selfModel  -> ^
	}
	
	/**
	 * Реляция на статистику
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getStat() {
		//                             <--------------->
		return $this->hasMany(AdsStat::class, ['banner_id' => 'id']);
		//                                              selfModel  -> ^
	}
	
	/**
	 * типы банеров: статичная катинка, видео, html и т.д.
	 *
	 * @return array
	 */
	public static function getTypesArray() {
		return [
			self::ADS_AREA_TYPE_IMAGE => 'Картинка',
		];
	}
	
	/**
	 * список для выпадашек
	 *
	 * @return array
	 */
	public static function getDropdownListByArea($areaId) {
		return self::find()
			->select(["title"])
			->indexBy('id')
			->orderBy('title ASC')
			->andWhere(['area_id' => $areaId])
			->asArray()
			->column();
	}
	
	/**
	 * добавляем показ, снижаем счетчик
	 */
	public function addShow() {
		$this->show_remains = $this->show_remains - 1;
		$this->cnt_show     = $this->cnt_show + 1;
		if ($this->show_remains <= 0) {
			$this->is_enabled = 0;
		}
		$this->save(false);
		AdsStat::insertStatRow($this->id, 1, 0);
		
		// TODO: добавляем показ, снижаем счетчик
	}
	
	/**
	 * добавляем переход по ссылке
	 */
	public function addClick() {
		$this->cnt_click = $this->cnt_click + 1;
		$this->save(false);
		
		AdsStat::insertStatRow($this->id, 0, 1);
		// добавляем переход по ссылке
	}
	
	/**
	 * отдает массив статистики для генерации таблицы статистики по банеру
	 *
	 * @return array
	 */
	public function getAdsDailyStatArray() {
		static $ret;
		if (!$ret) {
			$ret = [
				'min_date' => self::getStat()->min('show_date'),
				'max_date' => self::getStat()->max('show_date'),
				'stat'     => self::getStat()
					->select([
						'CONCAT (' . AdsStat::tableName() . '.show_date, " 00:00:00") AS show_date',
						AdsStat::tableName() . '.cnt_show',
						AdsStat::tableName() . '.cnt_click',
					])
					->asArray()
					->orderBy(AdsStat::tableName() . '.show_date DESC')
					->all(),
			];
		}
		
		return $ret;
	}
}
