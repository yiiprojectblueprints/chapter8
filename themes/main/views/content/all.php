<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataprovider,
    'itemView'=>'//content/list',
    'summaryText' => '',
    'pager' => array(
    	'htmlOptions' => array(
    		'class' => 'pager'
    	),
    	'header' => '',
    	'firstPageCssClass'=>'hide',
    	'lastPageCssClass'=>'hide',
    	'maxButtonCount' => 0
    )
));