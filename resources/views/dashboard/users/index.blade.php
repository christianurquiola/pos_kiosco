@extends('layouts.dashboard.app')
@section('title', __('site.users'))
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1> {{ __('site.users') }} </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.welcome') }}">
                    <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active">@lang('site.users')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">
                        @lang('site.users') <small> {{ $users->count() }}</small>
                    </h3>
                    <!--search form -->
                    <form action="{{ URL::current() }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="@lang('site.search')" value="{{ request()->name }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>@lang('site.search')
                                </button>
                            @hasPermission('users_create')
                                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                                <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endhasPermission
                            </div>
                        </div>
                    </form>
                </div><!-- end of box header -->

                <div class="box-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.first_name')</th>
                            <th>@lang('site.last_name')</th>
                            <th>@lang('site.email')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                        </thead>
                        <tbody>

                            @each('dashboard.users.partials.table', $users, 'user', 'dashboard.users.partials.empty')

                        </tbody>

                    </table>
                    {{ $users->withQueryString()->links() }}
                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->



    </div><!-- end of content wrapper -->


@endsection
