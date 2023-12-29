@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.categories')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories') <small>{{ $categories->total() }}</small></h3>

                    <!-- search form -->
                    <form action="{{ URL::current() }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="@lang('site.search')" value="{{ request()->name }}">
                            </div>

                            <div class="col-md-4">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                    @lang('site.search')
                                </button>

                                @hasPermission('categories_create')
                                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> @lang('site.add')
                                    </a>
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
                                <th>@lang('site.name')</th>
                                <th>@lang('site.products_count')</th>
                                <th>@lang('site.related_products')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{$category->products()->count()}}</td>
                                <td>
                                    <a href="{{ route('dashboard.products.index', ['category_id' => $category->id]) }}" class="btn btn-info btn-sm">
                                        @lang('site.related_products')
                                    </a>
                                </td>
                                <td>
                                    {{--Edit--}}
                                    @hasPermission ('categories_update')
                                        <a href="{{ route('dashboard.categories.edit', ['category' => $category->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                    @else
                                        <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                    @endhasPermission
                                    {{--Delete--}}
                                    @hasPermission('categories_delete')
                                        <form action="{{ route('dashboard.categories.destroy', ['category' => $category->id]) }}" method="post" style="display: inline-block">
                                            @csrf()
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        </form><!-- end of form -->
                                    @else
                                        <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                    @endhasPermission
                                </td>
                    @empty
                             <td colspan="5"> <div class="alert alert-warning font-weight-bold text-center" style="padding:20px;">@lang('site.no_data_found')</div></td>
                    @endforelse
                        </tr>
                        </tbody>

                    </table><!-- end of table -->

                    {{ $categories->withQueryString()->links() }}

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
