<?php

namespace common\helpers;


use backend\controllers\CollectBillPeopleController;
use backend\models\Admin;
use common\components\laychat\Lib\GatewayClient\Gateway;
use common\components\YtxRestSdk;
use common\models\Activity;
use common\models\Area;
use common\models\Bills;
use common\models\Book;
use common\models\CarType;
use common\models\Chapter;
use common\models\City;
use common\models\CollectBillPeople;
use common\models\Count;
use common\models\Course;
use common\models\Department;
use common\models\Discount;
use common\models\Expert;
use common\models\InsuranceItem;
use common\models\Offer;
use common\models\PayType;
use common\models\Province;
use common\models\Reply;
use common\models\Saler;
use common\models\Student;
use common\models\StudentInof;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use Yii;
use common\models\Company;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * Class CommonHelper
 * @package common\helpers
 * @author
 * @date 15-5-22
 */
class CommonHelper
{
    private static $_citys = null;

    private static $_bangbang_service = null;

    public static function fixTimestamp($timestamp)
    {
        if (is_numeric($timestamp)) {
            $timestamp = intval($timestamp);
            if (strlen(strval($timestamp)) == 13) { //有微秒 去掉微秒
                $timestamp = intval($timestamp / 1000);
            }
        }
        return $timestamp;
    }

    public static function showSex($sex)
    {
        $sex = intval($sex);
        switch ($sex) {
            case 1:
                return '男';
                break;
            case 0:
                return '女';
                break;
            default:
                return '未知';
        }
    }

    /*
     * 监护人 ID
     * */
    public static function CustodyToNo($id)
    {
        $student = Student::findOne($id);
        if (is_null($student) || empty($student)) {
            return '无';
        } else {
            if (is_null($student->no) || empty($student->no)) {
                return '无';
            } else {
                return $student->no;
            }

        }
    }

    /*
     * 账号类型
     * */
    public static function AdminType($type)
    {
        $type = intval($type);
        switch ($type) {
            case 0:
                return '普通管理员';
                break;
            case 1:
                return '专家';
                break;
            case 2:
                return '教育机构';
                break;
            case 3:
                return '公益机构';
                break;
            default:
                return '未知';
        }
    }

    /*
     * 图片显示
     * */
    public static function showImg($url, $w, $h)
    {
        if (trim($url) == '') {
            return '无';
        } else {
            return Html::img(\common\helpers\QiniuHelper::getImageUrl($url), ['width' => $w, 'height' => $h]);
        }
    }

    /*
     * 课程状态
     * */
    public static function CourseStatus($status)
    {
        $status = intval($status);
        switch ($status) {
            case 0:
                return '正常';
                break;
            case 1:
                return '已满';
                break;
            case 2:
                return '结束';
                break;
            default:
                break;
        }
    }

    /*
     * 字符串截取
     * */
    public static function sub_str($str, $length = 0, $append = true)
    {
        $str = trim($str);
        $strlength = strlen($str);
        if ($length == 0 || $length >= $strlength) {
            return $str; //截取长度等于或大于等于本字符串的长度，返回字符串本身
        } elseif ($length < 0) //如果截取长度为负数
        {
            $length = $strlength + $length;//那么截取长度就等于字符串长度减去截取长度
            if ($length < 0) {
                $length = $strlength;//如果截取长度的绝对值大于字符串本身长度，则截取长度取字符串本身的长度
            }
        }
        if (function_exists('mb_substr')) {
            $newstr = mb_substr($str, 0, $length, EC_CHARSET);
        } elseif (function_exists('iconv_substr')) {
            $newstr = iconv_substr($str, 0, $length, EC_CHARSET);
        } else {
            //$newstr = trim_right(substr($str, , $length));
            $newstr = substr($str, 0, $length);
        }
        if ($append && $str != $newstr) {
            $newstr .= '...';
        }
        return $newstr;
    }

    /*
     * 检测身份是否是监护人
     * */
    public static function StudentToCustody($id)
    {
        $student = Student::findOne($id);
        if ($student->type === 0) {
            return $id;
        } else {
            $id = $student->custody;
            return $id;
        }
    }

    /*
     * id转少年犯的用户信息
     * 有姓名转姓名 无姓名转登录名称
     * */
    public static function StudentIdToName($id)
    {
        $student = StudentInof::find()->where(['user_id' => $id])->one();
        if (!is_null($student)) {
            return $student->name;
        } else {
            $student = Student::findOne($id);
            if (is_null($student)) {
                return '未知';
            } else {
                return $student->username;
            }

        }
    }

    /*
     * 专家预约状态
     * */
    public static function ExpertOrderStatus($status)
    {
        $status = intval($status);
        switch ($status) {
            case 0:
                return '申请';
                break;
            case 1:
                return '同意';
                break;
            case 2:
                return '不同意';
                break;
            case 3:
                return '结束';
                break;
            default:
                break;
        }
    }

    /*
     * 课程名称
     * */
    public static function CourseIdToName($id)
    {
        $course = Course::findOne($id);
        if (!is_null($course)) {
            return $course->name;
        } else {
            return '未知';
        }
    }

    /*
     * 参加课程的状态
     * */
    public static function StudyCourseStatus($type)
    {
        $type = intval($type);
        switch ($type) {
            case 0:
                return '申请';
                break;
            case 1:
                return '成功';
                break;
            case 2:
                return '失败';
                break;
            case 3:
                return '结束';
                break;
            default:
                break;
        }
    }

    /*
     * 活动名称
     * */
    public static function ActivityIdToName($id)
    {
        $activity = Activity::findOne($id);
        return $activity->huoDmc;
    }

    /*
     * 评价类型
     * */
    public static function EvaluateType($type)
    {
        $type = intval($type);
        switch ($type) {
            case 0:
                return '管理员';
                break;
            case 1:
                return '专家咨询评价';
                break;
            case 2:
                return '课程评价';
                break;
            case 3:
                return '公益活动';
                break;
            default:
                break;

        }
    }

    /*
     * 专家姓名
     * */
    public static function ExpertIdToName($id)
    {
        $expert = Expert::findOne($id);
        if (is_null($expert)) {
            return '';
        } else {
            return $expert->name;
        }
    }

    /*
     * 学生报名课程状态
     * */
    public static function StudyCourseZhuangT($type)
    {
        $type = intval($type);
        switch ($type) {
            case 0:
                return '申请';
                break;
            case 1:
                return '成功';
                break;
            case 2:
                return '失败';
                break;
            default:
                return '未知';
                break;

        }
    }

    /*
     * 书籍ID 转换为名称
     * */
    public static function BookIdToName($id)
    {
        $book = Book::findOne($id);
        if (!is_null($book)) {
            return $book->name;
        } else {
            return '无';
        }
    }

    /*
     * 章节ID 转换为名称
     * */
    public static function ChapterIdToName($id)
    {
        $chapter = Chapter::findOne($id);
        if (!is_null($chapter)) {
            return $chapter->title;
        } else {
            return '无';
        }
    }

}


