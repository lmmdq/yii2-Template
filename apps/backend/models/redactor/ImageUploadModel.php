<?php

namespace backend\models\redactor;

use Yii;

class ImageUploadModel extends FileUploadModel
{
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => ['jpg','png','gif']]
        ];
    }
}