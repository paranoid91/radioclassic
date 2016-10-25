<div class="block-list" >
    <?php $modules = get_modules() ?>
    @if(count($modules) > 0)
        <ul>
            @foreach($modules as $mod)

                @if($mod->name <> 'modules')
                    @if(is_array(get_role_permissions($mod->name)))
                        <?php $array = (in_array('index',get_role_permissions($mod->name))) ? true : false ?>
                    @else
                        <?php $array = false ?>
                    @endif
                    @if($array == true)
                        <li class="{{ (strpos(Route::getCurrentRoute()->uri(),$mod->name)) ? 'active ' : ''  }}{{$mod->name}}"><a href="{{action($mod->controller)}}" title="{{trans('admin.'.$mod->name)}}"><i class="{{$mod->icon}}"></i> <span>{{trans('admin.'.$mod->name)}}</span></a></li>
                    @endif
                @endif
            @endforeach
            <li class="{{ (strpos(Route::getCurrentRoute()->uri(),'modules')) ? 'active' : ''  }} modules"><a href="{{action('Admin\ModulesController@index')}}" title="{{trans('admin.modules')}}"><i class="glyphicon glyphicon-th"></i> <span>{{trans('admin.modules')}}</span></a></li>
        </ul>
    @endif
    <div class="fix"></div>
    <div class="nav_bars">
        <i onClick='$("input[name=\"active_top_slide\"]").click()' class="glyphicon {{(isset($_COOKIE['nav_bar']) != false) ? 'glyphicon-arrow-up' : 'glyphicon-arrow-left'}}"></i>
        <input type="checkbox" value="1" name="active_top_slide" style="display:none;" {{(isset($_COOKIE['nav_bar']) != false) ? 'checked' : ''}}>
    </div>
</div>