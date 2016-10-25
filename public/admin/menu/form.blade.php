
<table width="100%">
    <tr>
        <td valign="top">
            <input type="text" name="name" value="{{$name}}" id="menu_title" placeholder="Menu Title" class="form-control" style="width:400px;margin-bottom:20px;"/>
            <input type="hidden" name="menu_token" id="menu_token" value="{{csrf_token()}}"/>
            <input type="hidden" name="submit_url" id="submit_url" value="{{$route}}"/>
            <?php $cats = get_cat_by_parent([2,55,76,66]); ?>
            <?php $pages = get_pages(1);?>
            <?php $articles = menu_builder_articles();?>

            <section class="mod mod-flat-glass">
                <div class="dd" id="domenu-1">

                    <button id="domenu-add-item-btn" class="dd-new-item">+</button>
                    <!-- .dd-item-blueprint is a template for all .dd-item's -->
                    <li class="dd-item-blueprint">
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content">
                            <span>[item_name]</span>
                            <!-- @migrating-from 0.13.29 button container-->
                            <div class="button-container">
                                <!-- @migrating-from 0.13.29 add button-->
                                <button class="item-add">+</button>
                                <button class="item-remove" data-confirm-class="item-remove-confirm">&times;</button>
                            </div>
                            <div class="dd-edit-box" style="display: none;">
                                <!-- data-placeholder has a higher priority than placeholder -->
                                <!-- data-placeholder can use token-values; when not present will be set to "" -->
                                <!-- data-default-value specifies a default value for the input; when not present will be set to "" -->
                                <input type="text" name="title" autocomplete="off" placeholder="Item" data-placeholder="Any nice idea for the title?" data-default-value="doMenu List Item. {?numeric.increment}">
                                <select name="superselect">
                                    <option value="">select something...</option>
                                    <optgroup label="Categories">
                                        @if(count($cats) > 0)
                                            @foreach($cats as $key=>$cat)
                                                <option value="{{$cat['slug']}}">{{$cat['name']}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                    <optgroup label="Pages">
                                        @if(count($pages) > 0)
                                            <option value="/">Home Page</option>
                                            @foreach($pages as $page)
                                                <option value="{{$page->slug}}">{{$page->title}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                    <optgroup label="Articles">
                                        @if(count($articles) > 0)
                                            @foreach($articles as $article)
                                                <option value="news/{{$article->slug}}">{{$article->title}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                    <optgroup label="Custom URL">
                                        @if(count($custom_urls) > 0)
                                            @foreach($custom_urls as $curl)
                                                <option value="{{$curl->value}}">{{$curl->name}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                                <!-- @migrating-from 0.13.29 an element ".end-edit" within ".dd-edit-box" exists the edit mode on click -->
                                <i class="end-edit">&#x270e;</i>
                            </div>
                        </div>
                    </li>

                    <ol class="dd-list"></ol>
                </div>

            </section>
            <br>
            <button onClick="saveMenu($('#domenu-1'))" class="btn btn-success">Save</button>
            <script>

                $(document).ready(function(){
                    $('#domenu-1').domenu({
                        slideAnimationDuration: 0,
                        data: '{!! $data !!}'
                    }).parseJson();
                });

                function saveMenu(id){
                    var token = $("#menu_token").val();
                    var name = $("#menu_title").val();
                    var url = $("#submit_url").val();

                    if(token && name && url){
                        $.ajax({
                            url:url,
                            type:'{{$method}}',
                            data:{_method:'{{$method}}',_token:token,name:name,value:id.domenu().toJson(),lang:'{{\App::getLocale()}}',type:'menu'},
                            success:function(response){
                                window.location.href = response;
                            }
                        });
                        console.log(id.domenu().toJson());
                    }else{
                        $("#menu_title").css('border','1px solid red','!important');
                    }
                    //console.log(id.domenu().toJson());
                }
            </script>
        </td>
        @if(count($item) > 0)
            <td valign="top" align="center" width="50%">
                <b>Add Custom URL</b>
                <div id="custom_url">
                    {!! Form::open(['action'=>['Admin\MenuBuilderController@custom',$item->id]]) !!}
                    <div class="row">
                        <div class="col-xs-14">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::hidden('type','menu_url') !!}
                                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>trans('all.title')]) !!}
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        {!! Form::text('value',null,['class'=>'form-control','placeholder'=>'URL']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        {!! Form::submit(trans('all.add'),['class'=>'btn btn-primary']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <br>
                @include('errors.list')
                <br>
                @if(count($custom_urls) > 0)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <th>{{trans('all.title')}}</th><th>{{trans('all.url')}}</th><th>{{trans('all.delete')}}</th>
                                </thead>
                                <tbody>
                                @foreach($custom_urls as $c)
                                    <tr>
                                        <td>{{$c->name}}</td>
                                        <td>{{\Illuminate\Support\Str::substr($c->value,0,30)}}...</td>
                                        <td>
                                            <a class="remove-modal btn btn-danger" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\MenuBuilderController@destroy',$item->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {{trans('all.remove')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
        @endif
        @endif
    </tr>
</table>