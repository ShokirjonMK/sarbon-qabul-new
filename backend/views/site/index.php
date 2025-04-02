<?php
use yii\helpers\Url;
use common\models\EduYearType;
use common\models\User;
use common\models\Student;
use yii\db\Expression;
use common\models\Flayer;
use Da\QrCode\QrCode;
use common\models\Target;

/** @var yii\web\View $this */
/** @var EduYearType $eduYearTypes */
/** @var User $currentUser */

$this->title = 'ZARMED UNIVERSITETI';
$baseQuery = Student::find()
    ->alias('s')
    ->innerJoin('user u', 's.user_id = u.id')
//    ->where(['u.cons_id' => $currentUser->cons_id, 'u.user_role' => 'student'])
    ->andWhere(['in' , 'u.status' , [9, 10]]);
?>

<div class="ik_title_h5 mt-2 mb-4">
    <h5>Statistika</h5>
</div>
<div class="ik_page">

</div>
