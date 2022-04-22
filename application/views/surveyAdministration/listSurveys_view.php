<?php
/**
* This file render the list of surveys
* It use the Survey model search method to build the data provider.
*
* @var $model  Survey
*/

// DO NOT REMOVE This is for automated testing to validate we see that page
echo viewHelper::getViewTestTag('listSurveys');

?>
<div class="container-fluid ls-space row list-surveys">
    <ul class="nav nav-tabs" id="surveysystem" role="tablist">
        <li class="nav-item"><a class="nav-link active" href="#surveys" aria-controls="surveys" role="tab" data-bs-toggle="tab"><?php eT('Survey list'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#surveygroups" aria-controls="surveygroups" role="tab" data-bs-toggle="tab"><?php eT('Survey groups'); ?></a></li>
    </ul>
    <div class="tab-content">
        <div id="surveys" class="tab-pane show active">
            <!-- Survey List widget -->
            <?php $this->widget('ext.admin.survey.ListSurveysWidget.ListSurveysWidget', array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
                        'model' => $model,
                ));
            ?>
        </div>

        <div id="surveygroups" class="tab-pane">
            <div class="pagetitle h3 ls-space margin top-25"><?php eT('Survey groups'); ?></div>
            <div class="row">
                <div class="col-sm-12 content-right">
                    <?php
                    $this->widget('application.extensions.admin.grid.CLSGridView', array(
                        'id'           => 'surveygroups--gridview',
                        'dataProvider' => $groupModel->search(),
                        'columns'      => $groupModel->columns,
                        'summaryText'  => gT('Displaying {start}-{end} of {count} result(s).') . ' '
                            . sprintf(
                                gT('%s rows per page'),
                                CHtml::dropDownList(
                                    'surveygroups--pageSize',
                                    Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
                                    App()->params['pageSizeOptions'],
                                    array('class' => 'changePageSize form-control', 'style' => 'display: inline; width: auto')
                                )
                            ),
                        'selectionChanged' => "function(id){window.location='" . Yii::app()->urlManager->createUrl("admin/surveysgroups/sa/update/id") . '/' . "' + $.fn.yiiGridView.getSelection(id.split(',', 1));}",

                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#surveysystem a').on('shown.bs.tab', function () {
        var tabId = $(this).attr('href');
        $('.tab-dependent-button:not([data-tab="' + tabId + '"])').hide();
        $('.tab-dependent-button[data-tab="' + tabId + '"]').show();
    });
    $(document).on('ready pjax:scriptcomplete', function(){
        if(window.location.hash){
            $('#surveysystem').find('a[href='+window.location.hash+']').trigger('click');
        }
    })
</script>
<!-- To update rows per page via ajax -->
<script type="text/javascript">
    jQuery(function($) {
        jQuery(document).on("change", '#surveygroups--pageSize', function(){
            $.fn.yiiGridView.update('surveygroups--gridview',{ data:{ pageSize: $(this).val() }});
        });
    });
    //show tooltip for gridview icons
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
