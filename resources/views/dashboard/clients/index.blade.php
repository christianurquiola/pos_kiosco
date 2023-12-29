@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.clients') <small>{{ $clients->count() }}</small></h3>
                    <form action="{{ URL::current() }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="@lang('site.search')" value="{{ request('name') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @hasPermission('clients_create')
                                    <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> @lang('site.add')
                                    </a>
                                @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @endhasPermission
                            </div>
                        </div>
                    </form><!-- end of form -->
                </div><!-- end of box header -->

                <div class="box-body">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.add_order')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($clients as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ is_array($client->phone) ? implode(' - ', array_filter($client->phone)) : $client->phone }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td style="max-width: 140px !important; overflow-wrap: break-word" >
                                        {{ $client->address }}
                                    </td>
                                    <td>
                                        @hasPermission('clients_create')
                                            <a href="{{route('dashboard.clients.orders.create',['client' => $client->id])}}" class="btn btn-primary btn-sm">@lang('site.add_order')</a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-sm disabled">@lang('site.add_order')</a>
                                        @endhasPermission
                                    </td>
                                    <td>
                                        @hasPermission('clients_update')
                                            <a href="{{ route('dashboard.clients.edit', ['client' => $client->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endhasPermission
                                        @hasPermission('clients_delete')
                                            <form action="{{ route('dashboard.clients.destroy', ['client' => $client->id]) }}" method="post" style="display: inline-block">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form><!-- end of form -->
                                        @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                       @endhasPermission
                                    </td>

                                    @empty
                                        <td colspan="7">
                                            <div class="alert alert-warning font-weight-bold text-center" style="padding:20px;">
                                                @lang('site.no_data_found')
                                            </div>
                                        </td>
                                    @endforelse
                                </tr>
                            </tbody>
                        </table><!-- end of table -->

                        {{ $clients->withQueryString()->links() }}

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
