    @forelse ($user_list as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->username }}</td>
            <td>{{ $item->sitename }}</td>
            <td>********</td>
            <td>
                <div class="d-flex gap-1">


                    <button class="btn btn-secondary btn-sm edit" id="edit" data-id="{{ $item->id }}"
                        data-sitename="{{ $item->sitename }}" data-username="{{ $item->username }}"
                        data-password="{{ $item->password }}">Edit</button>


                    <form action="{{ route('front.delete', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">No results found</td>
        </tr>
    @endforelse


    