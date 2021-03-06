</div> <!-- END CONTAINER -->
<div class="footer">
    <div class="footer-space container-fluid">
        <div class="row no-margin">
            <div class="col-sm-8 col-md-8 col-lg-8 footer-menu-left">
                @if(!empty($menu))
                    @foreach($menu as $k => $item)
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 footer-menu-item">
                            <div class="block">
                                @if(isset($item['children']))
                                    <h4>{{ $item['title'] }}</h4>
                                    <ul>
                                        @for($i = 0; $i < count($item["children"]); $i++)
                                            <li>
                                                <a href="{{ url($item["children"][$i]["superselect"]) }}"
                                                   onClick="return ajaxRoute($(this).attr('href'), '{{ $item["children"][$i]["superselect"] }}');">{{ $item['children'][$i]["title"] }}</a>
                                            </li>
                                        @endfor
                                    </ul>
                                @else
                                    <h4><a href="{{ url($item["superselect"]) }}" onClick="return ajaxRoute($(this).attr('href'), '{{ url($item["superselect"]) }}');">{{ $item['title'] }}</a></h4>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 footer-menu-right">
                <div class="block last-block">
                    <div class="bot-logos">
                        <div class="radioclassic"><a href="javascript:void('')" onClick="ajaxRoute('{{action("WelcomeController@ajaxIndex")}}','/')"></a></div>
                        <div class="gbtimes"><a href="http://company.gbtimes.com/about-us" target="_blank"></a></div>
                        <div class="bottom-social">
                            <ul>
                                <li class="rodot-icon"><a href="http://www.radiot.fi/#!/kanava/classic" target="_blank"></a></li>
                                <li class="facebook-icon"><a href="https://www.facebook.com/radioclassicfi/" target="_blank" ></a></li>
                                <li class="twitter-icon"><a href="https://twitter.com/radioclassicfi" target="_blank"></a></li>
                                <li class="soundcloud-icon"><a href="https://soundcloud.com/radioclassicfi"  target="_blank"></a></li>
                                <li class="youtube-icon"><a href="http://www.youtube.com/user/radioclassicfi" target="_blank"></a></li>
                            </ul>
                        </div>
                        <div class="bottom-contact">
                            <span>CLASSIC</span><br>
                            <span>PINNINKATU 55 A</span><br>
                            <span>33100 TAMPERE</span><br><br>
                            <a href="mailto:TOIMITUS@RADIOCLASSIC.FI"><span>toimitus@radioclassic.fi</span></a><br>
                            <a href="mailto:MYYNTI@RADIOCLASSIC.FI"><span>myynti@radioclassic.fi</span></a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fix"></div>
    </div>
</div>

</div> <!-- END WRAPPER -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type='text/javascript'>var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', '1010lbMz']);(function(){var autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src= ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();</script>
@if(permitSortNews() && isset($admin) && $admin === true)
<script>
    $(function() {
        $('#sortable-news').sortable();
        $('#sortable-news').disableSelection();

        $("#form-sort-news").submit(function(e){
            e.preventDefault();
            var orders = {};
            $('#sortable-news').children().each(function(i){
                orders[i] = $(this).attr("data-id");
            });
            orders = JSON.stringify(orders);

            $.ajax({
                headers: {'X-CSRF-Token': $("#form-sort-news input[name=_token]").val()},
                url: "sort-news",
                data : { orders: orders},
                method: "post"
            }).done(function() {
                window.location.href = "{{ url("is-admin/articles") }}";
            });

        });
    });
</script>
@endif
</body>
</html>
