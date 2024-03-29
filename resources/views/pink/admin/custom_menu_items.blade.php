@foreach($items as $item)

    <tr>
        <td style="text-align: left;">{{ $paddingLeft }} {!! Html::link(route('menus.edit',['menus' => $item->id]),$item->title) !!}</td>
        <td>{{ $item->url() }}</td>

        <td>
            {!! Form::open(['url' => route('menus.destroy',['menus'=> $item->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
            {{ method_field('DELETE') }}
            {!! Form::button('Удалить', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
            {!! Form::close() !!}

        </td>
    </tr>
    @if($item->hasChildren())

        @include(config('settings.theme').'.admin.custom_menu_items', array('items' => $item->children(),'paddingLeft' => $paddingLeft.'--'))

    @endif

@endforeach

