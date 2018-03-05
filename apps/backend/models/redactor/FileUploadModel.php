<?php
/**
 * Created by PhpStorm.
 * User: wayhood
 * Date: 16/3/27
 * Time: 下午2:17
 */

namespace backend\models\redactor;

use common\helpers\QiniuHelper;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\Inflector;

class FileUploadModel extends \yii\base\Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    private $_fileName;

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => null]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $ret = QiniuHelper::putImageFile($this->file->tempName);
            $this->_fileName = $ret['key'];
            return true;
        }
        return false;
    }

    public function getResponse()
    {
        return [
            'filelink' => QiniuHelper::getImageUrl($this->_fileName),
            'filename' => QiniuHelper::getImageUrl($this->_fileName)
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstanceByName('file');
            return true;
        }
        return false;
    }
}