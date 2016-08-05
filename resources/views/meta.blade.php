{!! $open !!}
/**
* PhpStorm Meta file, to provide autocomplete information for PhpStorm
* Generated on {!! date("Y-m-d") !!}.
*/

namespace PHPSTORM_META {

$STATIC_METHOD_TYPES = [
@foreach($metas as $meta)
    {!! $meta !!}
@endforeach
];
}
