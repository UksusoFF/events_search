@if (isset($params['raw']) && (empty($params['raw']) || !$params['raw']))
    @foreach ($params as $key => $value)
        @php
            $params[$key] = htmlspecialchars($value);
        @endphp
    @endforeach
@endif

@if (in_array($params['value'], request()->input('f.'.$params['key'], [])))
    <a href="/?{{ http_build_query(array_merge(
        request()->except('page', 'f.'.$params['key']),
        [
            'f['.$params['key'].']' => array_filter(request()->input('f.'.$params['key'], []), function($item) use ($params) {
                return $item != $params['value'];
            }),
        ]
    )) }}" class="badge badge-primary">
        {!! $params['title'] !!}
    </a>
@else
    <a href="/?{{ http_build_query(array_merge(
        request()->except('page'),
        [
            'f['.$params['key'].'][]' => $params['value']
        ]
    )) }}" class="badge {{ isset($params['danger']) && $params['danger'] ? 'badge-danger' : 'badge-secondary' }}">
        {!! $params['title'] !!}
    </a>
@endif