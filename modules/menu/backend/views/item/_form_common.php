<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use app\modules\menu\common\models\Menu;
use app\modules\menu\common\models\Item;

/* @var $this yii\web\View */
/* @var $model app\modules\menu\common\models\Item */
/* @var $form yii\widgets\ActiveForm */

$url = \yii\helpers\Url::to(['/menu/item/get-list']);

echo Html::beginTag('p');

echo $form->field($model, 'menu_id')->widget(Select2::classname(), [
    'data' => Menu::getDropdown(),
    'options' => ['placeholder' => 'Выберите ...'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    'pluginEvents' => [
        "change" => "function() { $('#item-parent_id').select2('val', ''); }",
    ]
]);

echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
    'data'          => Item::getDropdown([(int)$model->id]),
    'options' => ['placeholder' => 'Выберите ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 0,
        'ajax' => [
            'url' => \yii\helpers\Url::to(['/menu/item/get-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(term) { var menu_id = $(\'#item-menu_id\').val(); return {search:term, menu_id: menu_id, id: ' . (int)$model->id . '}; }'),
            'results' => new JsExpression('function(data) { return {results:data.results}; }'),
        ],
    ],
]);

echo $form->field($model, 'sort')->textInput();
echo $form->field($model, 'module_id')->widget(Select2::classname(), [
    'data' => Menu::getModules(),
//    'data'          => Menu::getControllers('Модуль2'),
    'options' => ['placeholder' => 'Выберите ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 0,
        /*'ajax' => [
            'url' => \yii\helpers\Url::to(['/menu/item/get-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(term) { var module_id = $(\'#item-module\').val(); return {search:term, module: module, id: ' . (int)$model->id . '}; }'),
            'results' => new JsExpression('function(data) { return {results:data.results}; }'),
        ],*/

    ],
    'pluginEvents' => [
        "change" => "function() { $('#item-controller_id').select2('val', 'val'); $('#item-action_id').select2('val', '');}",
    ]
]);

$controllerUrl = \yii\helpers\Url::to(['/menu/item/get-controller']);

$controllerInitScript = <<< SCRIPT
function (element, callback) {
    var controller_id=\$(element).val();
    var module_id = $('#item-module_id').val();
    if (controller_id !== "") {
    \$.ajax("{$controllerUrl}", {
        dataType: "json",
        data: {module_id: module_id, controller_id: controller_id}
        }).done(function(data) { callback(data.results);});
    }
}
SCRIPT;

echo $form->field($model, 'controller_id')->widget(Select2::classname(), [
    'options' => ['placeholder' => 'Выберите ...'],
    //'data' => ['page' => 'asdasd'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 0,
        'ajax' => [
            'url' => $controllerUrl,
            'dataType' => 'json',
            'data' => new JsExpression('function(term) { var module_id = $(\'#item-module_id\').val(); return {search:term, module_id: module_id, id: ' . (int)$model->id . '}; }'),
            'results' => new JsExpression('function(data) { console.log(data); return {results:data.results}; }'),
        ],
        'value' => 'aaa',
        'initSelection' => new JsExpression($controllerInitScript)
    ],
    'pluginEvents' => [
        "change" => "function() { $('#item-action_id').select2('val', ''); update_params();}",
    ]
]);


//echo $form->field($model, 'controller_id')->widget(Select2::classname(), [
//    'options' => ['placeholder' => 'Выберите ...'],
//    'data' => Menu::getModuleControllers(),
//    'pluginOptions' => [
//        'allowClear' => true,
//        'minimumInputLength' => 0,
////        'ajax' => [
////            'url' => $controllerUrl,
////            'dataType' => 'json',
////            'data' => new JsExpression('function(term) { var module_id = $(\'#item-module_id\').val(); return {search:term, module_id: module_id, id: ' . (int)$model->id . '}; }'),
////            'results' => new JsExpression('function(data) { console.log(data); return {results:data.results}; }'),
////        ],
//        'initSelection' => new JsExpression($controllerInitScript)
//    ],
//    'pluginEvents' => [
//        "change" => "function() { $('#item-action_id').select2('val', ''); update_params();}",
//    ]
//]);

$actionUrl = \yii\helpers\Url::to(['/menu/item/get-action']);

$actionInitScript = <<< SCRIPT
function (element, callback) {
    var action_id=\$(element).val();
    var controller_id = $('#item-module_id').val();
    var module_id = $('#item-module_id').val();
    if (action_id !== "") {
    \$.ajax("{$actionUrl}", {
        dataType: "json",
        data: {module_id: module_id, controller_id: module_id, action_id : action_id}
        }).done(function(data) { callback(data.results);});
    }
}
SCRIPT;

echo $form->field($model, 'action_id')->widget(Select2::classname(), [
    'options' => ['placeholder' => 'Выберите ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 0,
        'ajax' => [
            'url' => $actionUrl,
            'dataType' => 'json',
            'data' => new JsExpression('function(term) { var module_id = $(\'#item-module_id\').val(); var controller_id = $(\'#item-module_id\').val();  return {search:term, module_id: module_id, controller_id: controller_id, id: ' . (int)$model->id . '}; }'),
            'results' => new JsExpression('function(data) { return {results:data.results}; }'),
        ],
        'initSelection' => new JsExpression($actionInitScript)
    ],
    'pluginEvents' => [
        "change" => "function() { update_params();  }",
    ],
]);

?>
    <div id="params">

        <?php

        $items = Menu::getModuleControllers();
        if ($model->module_id != null
            && $model->controller_id != null && $model->action_id != null
            && !empty($items[$model->module_id]['controllers'][$model->controller_id]['actions'][$model->action_id]['params'])
        ) {
            $result = '';
            foreach ($items[$model->module_id]['controllers'][$model->controller_id]['actions'][$model->action_id]['params'] as $key => $param) {
                $htmlOptions = ['empty' => '---Выберите ' . $param['title'] . '---', 'class' => 'form-control'];
                $result .= Html::beginTag('div', ['class' => 'form-group']);
                $result .= Html::label($param['title'], 'Item_' . 'params[' . $param['name'] . ']',
                    ['class' => 'control-label']);
                $result .= Html::activeDropDownList($model, 'params[' . $param['name'] . ']', $param['items'],
                    $htmlOptions);
                $result .= Html::endTag('div');
            }
            echo $result;
        } ?>

    </div>
<?php

$paramsUrl = \yii\helpers\Url::to(['/menu/item/get-params']);

$this->registerJs('
function update_params() {
    $.ajax({
        url: \'' . $paramsUrl . '\',
        data: { module_id : $(\'#item-module_id\').val(), controller_id : $(\'#item-module_id\').val(), action_id : $(\'#item-action_id\').val() }
    }).done(function(data) { $(\'#params\').html(data)});
}

',
    \yii\web\View::POS_END);

echo Html::endTag('p');