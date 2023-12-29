@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.add_order')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.clients.index') }}">@lang('site.clients')</a></li>
                <li class="active">@lang('site.add_order')</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">

                <div class="col-md-6">

                    <div class="box box-primary">

                        <div class="box-header">

                            <h3 class="box-title" style="margin-bottom: 10px">@lang('site.categories')</h3>

                        </div><!-- end of box header -->

                        <div class="box-body">

                            @foreach ($categories as $category)
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#{{ str_replace(' ','-',$category->name) }}">{{ $category->name }}</a>
                                            </h4>
                                        </div>
                                        <div id="{{ str_replace(' ','-',$category->name) }}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th>@lang('site.name')</th>
                                                        <th>@lang('site.stock')</th>
                                                        <th>@lang('site.price')</th>
                                                        <th>@lang('site.add')</th>
                                                    </tr>
                                                    @forelse ($category->products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $product->stock }}</td>
                                                            <td>{{ number_format($product->sale_price, 2) }}</td>
                                                            <td>
                                                                <a href=""
                                                                   id="product-{{ $product->id }}"
                                                                   data-name="{{ $product->name }}"
                                                                   data-id="{{ $product->id }}"
                                                                   data-price="{{ number_format($product->sale_price, 2)  }}"
                                                                   class="btn btn-success btn-sm add-product-btn">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                    @empty
                                                            <td colspan="4">
                                                                <div class="alert alert-warning font-weight-bold text-center" style="padding:20px;">
                                                                    @lang('site.no_data_found')
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </table><!-- end of table -->
                                            </div><!-- end of panel body -->
                                        </div><!-- end of panel collapse -->
                                    </div><!-- end of panel primary -->
                                </div><!-- end of panel group -->
                            @endforeach

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                </div><!-- end of col -->

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">@lang('site.orders')</h3>
                        </div><!-- end of box header -->
                        <div class="box-body">
                            <form action="{{ route('dashboard.clients.orders.store', ['client' => $client->id]) }}" method="post">
                                @csrf()

                                <x-form.error />

                                {{--@if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        <p>{{ session()->get('error') }}</p>
                                    </div>
                                @endif--}}

                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('site.product')</th>
                                        <th>@lang('site.quantity')</th>
                                        <th>@lang('site.price')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="order-list">


                                    </tbody>

                                </table><!-- end of table -->

                                <h4>@lang('site.total') : <span class="total-price">0</span></h4>

                                <button class="btn btn-primary btn-block disabled" id="add-order-form-btn"><i class="fa fa-plus"></i> @lang('site.add_order')</button>

                            </form>

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                    @if ($orders->count() > 0)

                        <div class="box box-primary">

                            <div class="box-header">

                                <h3 class="box-title" style="margin-bottom: 10px">@lang('site.previous_orders')
                                    <small>{{ $orders->total() }}</small>
                                </h3>

                            </div><!-- end of box header -->

                            <div class="box-body">

                                @foreach ($orders as $order)

                                    <div class="panel-group">

                                        <div class="panel panel-success">

                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#{{ $order->created_at->format('d-m-Y-s') }}">{{ $order->created_at->toFormattedDateString() }}</a>
                                                </h4>
                                            </div>

                                            <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">

                                                <div class="panel-body">

                                                    <ul class="list-group">
                                                        @foreach ($order->products as $product)
                                                            <li class="list-group-item">{{ __('site.name') . ': '. $product->name }}  - {{ __('site.quantity') . ': '. $product->pivot->quantity }} </li>

                                                        @endforeach
                                                    </ul>
                                                    <h4>@lang('site.total') : <span >{{$order->total_price}}</span></h4>


                                                </div><!-- end of panel body -->

                                            </div><!-- end of panel collapse -->

                                        </div><!-- end of panel primary -->

                                    </div><!-- end of panel group -->

                                @endforeach

                                {{ $orders->links() }}

                            </div><!-- end of box body -->

                        </div><!-- end of box -->

                    @endif

                </div><!-- end of col -->

            </div><!-- end of row -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
