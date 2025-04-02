<?php
use common\models\EduForm;
use common\models\Direction;
use common\models\Languages;
use yii\helpers\Url;
use common\models\EduDirection;
use common\models\Lang;

$eduYearForms = EduForm::find()
    ->where(['is_deleted' => 0, 'status' => 1])
    ->all();
$lang = Yii::$app->language;
?>



<!--<div class="ik_content" id="ik_direc">-->
<!--    <div class="ik_content_box">-->
<!--        <div class="ik_content_direction">-->
<!--            <div class="root-item">-->
<!--                <div class="ik_main_title">-->
<!--                    <p>--><?php //= Yii::t("app" , "a12") ?><!--</p>-->
<!--                    <h4>--><?php //= Yii::t("app" , "a13") ?><!--</h4>-->
<!--                </div>-->
<!---->
<!--                <div class="ik_nav_pills">-->
<!--                    <div class="ik_nav_pills_item">-->
<!--                        <ul class="nav nav-pills mb-4 view-tabs" id="pills-tab" role="tablist">-->
<!--                            --><?php //$a = 1 ?>
<!--                            --><?php //foreach ($eduYearForms as $eduYearForm) : ?>
<!--                                --><?php
//                                $directionCount = (new \yii\db\Query())
//                                    ->select('direction_id')
//                                    ->from('edu_direction')
//                                    ->where(['status' => 1, 'is_deleted' => 0, 'edu_form_id' => $eduYearForm->id])
//                                    ->andWhere(['in' , 'edu_type_id' , [1,2,3]])
//                                    ->groupBy('direction_id')
//                                    ->count();
//                                ?>
<!--                                <li class="nav-item" role="presentation">-->
<!--                                    <button class="nav-link --><?php //if ($a == 1) { echo "active";} ?><!--" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills_ik--><?php //= $a ?><!--" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">-->
<!--                                        --><?php //= $eduYearForm['name_'.$lang] ?><!-- --><?php //= Yii::t("app" , "a14") ?><!-- &nbsp;&nbsp; <span class="btn-span">--><?php //= $directionCount ?><!--</span>-->
<!--                                    </button>-->
<!--                                </li>-->
<!--                                --><?php //$a++; ?>
<!--                            --><?php //endforeach; ?>
<!--                        </ul>-->
<!--                        <div class="tab-content" id="pills-tabContent">-->
<!--                            --><?php //$a = 1 ?>
<!--                            --><?php //foreach ($eduYearForms as $eduYearForm) : ?>
<!--                                --><?php
//                                $eduForm = $eduYearForm->eduForm;
//                                $subQuery = (new \yii\db\Query())
//                                    ->select(['MAX(id)'])
//                                    ->from('edu_direction')
//                                    ->where([
//                                        'status' => 1,
//                                        'is_deleted' => 0,
//                                        'edu_form_id' => $eduYearForm->id,
//                                    ])
//                                    ->andWhere(['in' , 'edu_type_id' , [1,2,3]])
//                                    ->groupBy('direction_id');
//
//                                $directions = EduDirection::find()
//                                    ->where(['id' => $subQuery])
//                                    ->all();
//                                ?>
<!--                                <div class="tab-pane fade --><?php //if ($a == 1) { echo "show active";} ?><!--" id="pills_ik--><?php //= $a ?><!--" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">-->
<!--                                    --><?php //if (count($directions) > 0) : ?>
<!--                                        <div class="grid-view">-->
<!--                                            <table class="table table-bordered">-->
<!--                                                <thead>-->
<!--                                                <tr>-->
<!--                                                    <th>№</th>-->
<!--                                                    <th>--><?php //= Yii::t("app" , "a15") ?><!--</th>-->
<!--                                                    <th>--><?php //= Yii::t("app" , "a16") ?><!--</th>-->
<!--                                                    <th>--><?php //= Yii::t("app" , "a17") ?><!--</th>-->
<!--                                                    <th>--><?php //= Yii::t("app" , "a18") ?><!--</th>-->
<!--                                                    <th>--><?php //= Yii::t("app" , "a19") ?><!--</th>-->
<!--                                                </tr>-->
<!--                                                </thead>-->
<!--                                                <tbody>-->
<!--                                                    --><?php //$t = 1; ?>
<!--                                                    --><?php //foreach ($directions as $direction) : ?>
<!--                                                        --><?php
//                                                            $languages = Lang::find()
//                                                                ->where(['in' , 'id' , EduDirection::find()
//                                                                    ->select('language_id')
//                                                                    ->where([
//                                                                        'code' => $direction->direction->code,
//                                                                        'edu_form_id' => $eduYearForm->id,
//                                                                        'edu_type_id' => [1,2,3],
//                                                                        'status' => 1,
//                                                                        'is_deleted' => 0
//                                                                    ])
//                                                                ])->all();
//                                                        ?>
<!--                                                        <tr>-->
<!--                                                            <td date-label="№">--><?php //= $t ?><!--</td>-->
<!--                                                            <td date-label="--><?php //= Yii::t("app" , "a15") ?><!--">--><?php //= '<span class="ik_color_red">'.$direction->direction->code.'</span>'.' - '.$direction->direction['name_'.$lang] ?><!--</td>-->
<!--                                                            <td date-label="--><?php //= Yii::t("app" , "a16") ?><!--">--><?php //= $eduForm['name_'.$lang]; ?><!--</td>-->
<!--                                                            <td date-label="--><?php //= Yii::t("app" , "a17") ?><!--">-->
<!--                                                                --><?php //if (count($languages) > 0): ?>
<!--                                                                    <span class="ik_lang_table">-->
<!--                                                                        --><?php //foreach ($languages as $language): ?>
<!--                                                                             <span>--><?php //= $language['name_'.$lang] ?><!--</span>-->
<!--                                                                        --><?php //endforeach; ?>
<!--                                                                    </span>-->
<!--                                                                --><?php //else: ?>
<!--                                                                    ------->
<!--                                                                --><?php //endif; ?>
<!--                                                            </td>-->
<!--                                                            <td date-label="--><?php //= Yii::t("app" , "a18") ?><!--">--><?php //= $direction->duration ?><!-- &nbsp; --><?php //= Yii::t("app" , "a20") ?><!--</td>-->
<!--                                                            <td date-label="--><?php //= Yii::t("app" , "a19") ?><!--">--><?php //= number_format((int)$direction->price, 0, '', ' '); ?><!-- --><?php //= Yii::t("app" , "a21") ?><!--</td>-->
<!--                                                        </tr>-->
<!--                                                        --><?php //$t++; ?>
<!--                                                    --><?php //endforeach; ?>
<!--                                                </tbody>-->
<!--                                            </table>-->
<!--                                        </div>-->
<!--                                    --><?php //else: ?>
<!--                                    --><?php //endif; ?>
<!--                                </div>-->
<!--                                --><?php //$a++; ?>
<!--                            --><?php //endforeach; ?>
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

