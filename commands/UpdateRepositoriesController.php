<?php

namespace app\commands;

use app\models\Account;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;

/**
 *
 */
class UpdateRepositoriesController extends Controller
{
    public function actionIndex(): int
    {
        $accounts = Account::find()->all();
        if (count($accounts) == 0) {
            echo 'there is no accounts';
            return ExitCode::OK;
        }
        
        /** @var Account $account */
        foreach ($accounts as $account) {
            try {
                $account->addRepos();
            } catch (Exception $e) {
                echo $e->getMessage();
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }
        
        return ExitCode::OK;
    }
}
