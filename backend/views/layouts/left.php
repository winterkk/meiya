<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>meiya</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
         /.search form -->
<?php
use mdm\admin\components\MenuHelper;
    // 菜单过滤
    $callback = function($menu){
        $items = $menu['children']; 
        $return = [ 
            'label' => $menu['name'], 
            'url' => [$menu['route']], 
        ];
        if(isset($menu['icon'])){
            $return['icon'] = $menu['icon']; 
        }else{
            $return['icon'] = 'fa fa-circle-o'; 
        }
        $items && $return['items'] = $items;
        return $return; 
    };
    $menu = MenuHelper::getAssignedMenu(\Yii::$app->user->id, null, $callback);

?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menu
            ]
        ) ?>

    </section>

</aside>
