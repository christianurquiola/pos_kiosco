@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.products')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products') <small>{{ $products->total() }}</small></h3>
                    <form action="{{ URL::current() }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="@lang('site.search')" value="{{ request('name') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="category_id" class="form-control">
                                    <option value="">@lang('site.all_categories')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                                @hasPermission('products_create')
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
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
                                <th>@lang('site.description')</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.profit_percent') %</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.code')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td style="max-width: 120px !important; overflow-wrap: break-word;">
                                        {{--{{ strip_tags($product->description) }}--}}
                                        {!! ($product->description) !!}
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>
                                        <img src="{{ $product->image_path }}" style="width: 80px; height: 50px;"  class="img-thumbnail" alt="@lang('site.image')">
                                    </td>
                                    <td>{{ number_format($product->purchase_price, 2)  }}</td>
                                    <td>{{ number_format($product->sale_price, 2) }}</td>
                                    <td>{{ $product->profit_percent }} %</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>
                                        @hasPermission('products_update')
                                            <a href="{{ route('dashboard.products.edit',['product' => $product->id] ) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-edit"></i> @lang('site.edit')
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endhasPermission
                                        @hasPermission('products_delete')
                                            <form action="{{ route('dashboard.products.destroy', ['product' => $product->id] ) }}" method="post" style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form><!-- end of form -->
                                        @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        @endhasPermission
                                    </td>
                            @empty
                                    <td colspan="10">
                                        <div class="alert alert-warning font-weight-bold text-center" style="padding:20px;">
                                            @lang('site.no_data_found')
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- end of table -->
                        {{ $products->withQueryString()->links() }}
                </div><!-- end of box body -->
            </div><!-- end of box -->
        </section><!-- end of content -->
    </div><!-- end of content wrapper -->

@endsection
