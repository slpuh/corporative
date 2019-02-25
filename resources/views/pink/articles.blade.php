@extends(config('settings.theme').'.layouts.site')

@section('navigation')
        {!! $navigation !!}
@endsection

@section('content')
        {!! $content !!}
@endsection

@section('bar')
        {!! $rightBar !!}
@endsection

@section('footer')
        {!! $footer !!}
@endsection

