<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiBaseController;

/**
 * Default controller for the `v1` module
 */
class ArtController extends ApiBaseController
{

	// close restful api
    public $modelClass = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionShow()
    {
        return $this->success('success');
    }
}
