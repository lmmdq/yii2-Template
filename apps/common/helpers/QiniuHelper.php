<?php

namespace common\helpers;

use backend\models\searcCustomerArticleCategorySearch;
use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class QiniuHelper
{
    /*
     * 获取上传权限
     */
    public static function getUploadToken($key = 'wav-private')
    {
        $auth = new Auth(
            Yii::$app->params['qiniu'][$key]['access_key'],
            Yii::$app->params['qiniu'][$key]['secret_key']
        );

        $bucket = Yii::$app->params['qiniu'][$key]['bucket'];  //空间名称

        $policy = array(
            'persistentOps' => Yii::$app->params['qiniu'][$key]['pfop'],
            'persistentNotifyUrl' => Yii::$app->params['qiniu'][$key]['notify_url'],
            'persistentPipeline' => Yii::$app->params['qiniu'][$key]['pipeline'],
            'callbackBody' => 'key=$(key)'
        );

        $token = $auth->uploadToken($bucket, null, 3600, $policy);

        return $token;
    }

    /*
     * 获取私有空间语音
     * */
    public static function getVoiceUrl($filename)
    {
        $auth = new Auth(
            Yii::$app->params['qiniu']['wav-private']['access_key'],
            Yii::$app->params['qiniu']['wav-private']['secret_key']
        );
        $url = Yii::$app->params['qiniu']['wav-private']['url'] . '/' . $filename;
        return $auth->privateDownloadUrl($url, 3600);
    }

    public static function getIdCardUrl($filename)
    {
        return self::getUrl('idcard', $filename);
    }

    public static function getImageUrl($filename)
    {
        return self::getUrl('image', $filename);
    }

    public static function getVideoUrl($filename)
    {
        return self::getUrl('video', $filename);
    }

    public static function getZipUrl($filename)
    {
        return self::getUrl('zip', $filename);
    }

    public static function deleteImageFile($filename)
    {
        return self::deleteFile('image', $filename);
    }

    public static function deleteIdCardFile($filename)
    {
        self::deleteFile('idcard', $filename);
    }

    public static function deleteVideoFile($filename)
    {
        self::deleteFile('video', $filename);
    }

    protected static function deleteFile($key, $filename)
    {
        $auth = new Auth(
            Yii::$app->params['qiniu'][$key]['access_key'],
            Yii::$app->params['qiniu'][$key]['secret_key']
        );
        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);
        $bucket = Yii::$app->params['qiniu'][$key]['bucket'];  //空间名称
        $err = $bucketMgr->delete($bucket, $filename);
        return $err;
    }

    protected static function getUrl($key, $filename)
    {
        return Yii::$app->params['qiniu'][$key]['url'] . $filename;
    }


    /**
     * 上传身份证图片, 传一个文件,带路径
     */
    public static function putIdCardFile($filename)
    {
        return self::putFile('idcard', $filename);
    }

    /**
     * 上传图片, 传一个文件,带路径
     */
    public static function putImageFile($filename)
    {
        return self::putFile('image', $filename);
    }

    /**
     * 上传视频, 传一个文件,带路径
     */
    public static function putVideoFile($filename)
    {
        return self::putFile('video', $filename);
    }

    /**
     * 上传音频, 传一个文件,带路径
     */
    public static function putWavFile($filename)
    {
        return self::putFile('wav', $filename);
    }

    /**
     * 上传身份证内容,
     * @param $content
     * @return mixed
     */
    public static function putIdCardContent($content)
    {
        return self::putFileContent('idcard', $content);
    }

    /**
     * 上传zip文件
     * @param $content
     * @return mixed
     */
    public static function putZipFile($filename)
    {
        return self::putFile('zip', $filename);
    }


    /**
     * 上传图片
     * @param $content
     * @return mixed
     */
    public static function putImageContent($content)
    {
        return self::putFileContent('image', $content);
    }

    /**
     * 上传视频
     * @param $content
     * @return mixed
     */
    public static function putVideoContent($content)
    {
        return self::putFileContent('video', $content);
    }

    protected static function putFile($key, $filename)
    {
        return self::put($key, $filename);
    }

    protected static function putFileContent($key, $content)
    {
        return self::put($key, $content, "content");
    }

    protected static function put($key, $param, $type = "file")
    {
        $auth = new Auth(
            Yii::$app->params['qiniu'][$key]['access_key'],
            Yii::$app->params['qiniu'][$key]['secret_key']
        );

        $bucket = Yii::$app->params['qiniu'][$key]['bucket'];  //空间名称
        $newFileName = md5(microtime(true));

        $token = $auth->uploadToken($bucket, null, 3600, ['saveKey' => $newFileName]);
        $uploadMgr = new UploadManager();

        if ($type == "file") {
            list($ret, $err) = $uploadMgr->putFile($token, null, $param);
        } else {
            list($ret, $err) = $uploadMgr->put($token, null, $param);
        }

        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }


    public static function getUpToken($key)
    {
        $auth = new Auth(
            Yii::$app->params['qiniu'][$key]['access_key'],
            Yii::$app->params['qiniu'][$key]['secret_key']
        );

        $bucket = Yii::$app->params['qiniu'][$key]['bucket'];  //空间名称
        $newFileName = md5(microtime(true));

        $token = $auth->uploadToken($bucket, null, 3600, ['saveKey' => $newFileName]);

        return $token;
    }

    /*
        * 上传文件,传一个json数据文件
        * */

    public static function putJsonFile($file, $newFilename)
    {
        return self::putJson('json', $file, $newFilename);
    }

    /*
     * JSON文件特定名称
     * */
    protected static function putJson($key, $param, $newFilename)
    {
        $auth = new Auth(
            Yii::$app->params['qiniu'][$key]['access_key'],
            Yii::$app->params['qiniu'][$key]['secret_key']
        );

        $bucket = Yii::$app->params['qiniu'][$key]['bucket'];  //空间名称

        $token = $auth->uploadToken($bucket, $newFilename, 3600, ['saveKey' => $newFilename]);
        $uploadMgr = new UploadManager();


        list($ret, $err) = $uploadMgr->put($token, $newFilename, $param);


        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }

    /*
       * 上传语音文件
       * */

    public static function putVoiceFile($file)
    {
        return self::putVoice('wav-private', $file);
    }

    /*
     * 删除语音文件
   * */
    public static function deleteVoiceFile($file)
    {
        return self::deleteFile('wav-private', $file);
    }

    /*
     * 上传voice文件 转码
     * */
    protected static function putVoice($key, $param)
    {

        $auth = new Auth(
            Yii::$app->params['qiniu'][$key]['access_key'],
            Yii::$app->params['qiniu'][$key]['secret_key']
        );

        $bucket = Yii::$app->params['qiniu'][$key]['bucket'];  //空间名称


        $policy = array(
            'persistentOps' => Yii::$app->params['qiniu'][$key]['pfop'],
            'persistentNotifyUrl' => Yii::$app->params['qiniu'][$key]['notify_url'],
            'persistentPipeline' => Yii::$app->params['qiniu'][$key]['pipeline'],
            'callbackBody' => 'key=$(key)'
        );

        $token = $auth->uploadToken($bucket, null, 3600, $policy);

        $uploadMgr = new UploadManager();

        $newFileName = md5(microtime(true));


        list($ret, $err) = $uploadMgr->putFile($token, $newFileName, $param);

        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }
}