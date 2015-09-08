<?php

/**
 * Класс для действий Superadmin
 *
 */

namespace app\controllers;

use app\models\Request;
use app\models\Stock;
use app\models\User;
use cs\Application;
use cs\services\VarDumper;
use cs\web\Exception;
use YandexMoney\API;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Response;

class Cabinet_walletController extends CabinetBaseController
{
    /**
     * Форма покупки месяцев
     *
     * @param int $id идентификатор акции
     *
     * @return string|\yii\web\Response
     *
     * @throws \cs\web\Exception
     */
    public function actionAdd($id)
    {
        $model = new \app\models\Form\CabinetWalletAdd();
        $stock = Stock::find($id);
        if (is_null($stock)) {
            throw new Exception('Нет такой катировки');
        }

        return $this->render([
            'model' => $model,
            'stock' => $stock,
        ]);
    }

    /**
     * Форма покупки месяцев Национальный рынок
     *
     * @param int $id идентификатор акции
     *
     * @return string|\yii\web\Response
     */
    public function actionAdd1()
    {
        $model = new \app\models\Form\CabinetWalletAdd1();

        return $this->render([
            'model' => $model,
        ]);
    }

    /**
     * Форма покупки месяцев Зарубежный рынок
     *
     * @param int $id идентификатор акции
     *
     * @return string|\yii\web\Response
     */
    public function actionAdd2()
    {
        $model = new \app\models\Form\CabinetWalletAdd1();

        return $this->render([
            'model' => $model,
        ]);
    }

    /**
     * AJAX
     *
     * REQUEST:
     * - monthcounter - int - количество покупамых месяцев
     * - stock_id - int - идентификатор акции
     */
    public function actionAdd_step1()
    {
        $monthCounter = self::getParam('monthcounter');
        $stockId = self::getParam('stock_id');

        $request = Request::insert([
            'stock_id' => $stockId,
            'month'    => $monthCounter,
        ]);
        Application::mail(User::find(Yii::$app->params['chat']['consultant_id'])->getEmail(), 'Запрос на добавление услуги', 'request', [
            'stock'    => Stock::find($stockId),
            'user'     => \Yii::$app->user->identity,
            'request'  => $request,
        ]);

        return self::jsonSuccess([
            'user'    => [
                'email' => Yii::$app->user->identity->getEmail(),
                'fio'   => Yii::$app->user->identity->getNameFull(),
            ],
            'request' => [
                'id'  => $request->getId(),
                'sum' => $monthCounter * 100 * 65,
            ],
        ]);
    }

}
