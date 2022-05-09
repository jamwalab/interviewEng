@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4" id="univData">
        @if (count($universityData))
            <table class="table-fixed w100 text-left">
                <thead>
                    <tr class="">
                        <th class="w30">Name</th>
                        <th class="w10">State / Province</th>
                        <th class="w10">Country</th>
                        <th class="w10">Alpha 2 Code</th>
                        <th class="w20">Domain</th>
                        <th class="w20">Web Pages</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($universityData as $data)
                        <tr class="{{count($data -> domains) > 1 ? 'multiDomain' : ''}}">
                            <td class="w30">{{$data -> name}}</td>
                            <td class="w10">{{$data->{'state-province'} === null ? "" : ($data->{'state-province'}) }}</td>
                            <td class="w10">{{$data -> country}}</td>
                            <td class="w10">{{$data -> alpha_two_code}}</td>
                            <td class="w20">
                                @foreach ($data -> domains as $domain)
                                    <p>{{$domain->domain_name}}</p>
                                @endforeach
                            </td>
                            <td class="w20">
                                @foreach ($data -> web_page as $webPage)
                                    <p>{{$webPage->url}}</p>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {!! $universityData->links() !!}
            </div>
        @else
            No University data to display!!
        @endif
    </div>
@endsection
