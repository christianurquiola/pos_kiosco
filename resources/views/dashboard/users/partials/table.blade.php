
<tr>
    <td>{{ $key +1 }} </td>
    <td>{{ $user->first_name }}</td>
    <td>{{ $user->last_name }}</td>
    <td>{{ $user->email }}</td>
    <td><img src="{{ $user->image_path }}" style="width: 80px; height: 50px" class="img-thumbnail" alt=""></td>
    <td>
        @hasPermission('users_update')
        <a href="{{ route('dashboard.users.edit',[ 'user' => $user->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
        @else
            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
            @endhasPermission

            @hasPermission('users_delete')
            <form action="{{ route('dashboard.users.destroy', [ 'user' => $user->id] ) }}" method="post" style="display: inline-block">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
            </form><!-- end of form -->
            @else
                <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                @endhasPermission

    </td>

<!-- end of table -->
