<table>
    @foreach($content['question'] as $item)
        <tr>
            <td colspan="2">{{$item}}</td>
        </tr>
    @endforeach
</table>
<?php $info = array_slice($content,-9,9,true);?>
<table cellpadding="10">
    @foreach($info as $key=>$value)
        <tr>
            <td style="border-bottom:1px solid #e7e7e7;">{{trans('all.'.$key)}}</td><td style="border-bottom:1px solid #e7e7e7;">{{$value}}</td>
        </tr>
    @endforeach
</table>