<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="position-relative">
        <div class="d-flex">
            @include('sidebar')
            <div class="container">
                <div class="py-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="px-6 text-gray-900">



                            <div class="lists">
                                <div class="d-flex align-items-center p-2 border-bottom justify-between">
                                    <div class="title-list">
                                        <h4 class="m-0">Education Info</h4>
                                    </div>
                                </div>
                                <div class="items table-responsive" id="userTable">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">SNo.</th>
                                                <th scope="col">Student Name</th>
                                                <th scope="col">Certificate</th>
                                        
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($user_list as $key => $item)
                                                <tr>
                                                    <th scope="row">{{ $key + 1 }}</th>
                                                    <td>{{ $item->username }}</td>
                                                    <td><a class="" href="{{ $item->sitename }}"
                                                            target="_blank">{{ $item->sitename }}</a></td>
                                                    <td>
                                                        <span class="pwd-text"
                                                            data-pwd="{{ $item->password }}">********</span>
                                                        <i class="fa fa-eye toggle-table-password"
                                                            style="cursor:pointer"></i>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">


                                                            <button class="btn btn-secondary btn-sm edit" id="edit"
                                                                data-id="{{ $item->id }}"
                                                                data-sitename="{{ $item->sitename }}"
                                                                data-username="{{ $item->username }}"
                                                                data-password="{{ $item->password }}">Edit</button>


                                                            <form action="{{ route('front.delete', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach --}}

                                        </tbody>
                                    </table>
                                    <h5 class="text-center">Data Not Added Yet</h5>
                                    <div>
                                        {{ $user_list->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Button trigger modal -->
    <div class="fix-addbutton">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fa fa-plus"></i>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Certificate</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form id="managerForm" action="#" method="POST" autocomplete="on">

                            @csrf
                            <input type="hidden" name="login" value="true">
                            <div class="form shadow-sm p-4">

                                <div class="mb-3">
                                    <label for="sitename" class="form-label">Student Name</label>
                                    <input type="text" class="form-control" id="sitename"
                                        placeholder="Enter Site Name" name="sitename"
                                        value="{{ old('sitename', @$single_user->sitename ?? '') }}" autocomplete="url">
                                    @error('sitename')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="sitename" class="form-label">Certificate</label>
                                    <input type="file" class="form-control" id="sitename"
                                        placeholder="Enter Site Name" name="sitename"
                                        value="{{ old('sitename', @$single_user->sitename ?? '') }}" multiple>
                                    @error('sitename')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                                <div class="">
                                    <div class="submit-button text-end">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            {{ @$single_user->id ? 'Update' : 'Submit' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>



</x-app-layout>



