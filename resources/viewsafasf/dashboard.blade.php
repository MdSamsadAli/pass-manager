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
                    <div class="row g-2">
                        @php
                            $categories = [
                                'Bank Details' => ['count' => 5, 'color' => 'primary', 'icon' => 'bank'],
                                'Education Info' => ['count' => 3, 'color' => 'success', 'icon' => 'book'],
                                'Notes' => ['count' => 10, 'color' => 'warning', 'icon' => 'file-text'],
                                'Blogs' => ['count' => 7, 'color' => 'info', 'icon' => 'file-earmark-text'],
                                'Driving Licence' => ['count' => 2, 'color' => 'danger', 'icon' => 'car-front'],
                                'Social Media' => ['count' => 8, 'color' => 'secondary', 'icon' => 'share'],
                            ];
                        @endphp

                        @foreach ($categories as $name => $data)
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card text-white bg-white shadow-sm border-0" style="">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-{{ $data['icon'] }} fs-3 me-3"></i>
                                            <!-- Category Name -->
                                            <h3 class="mb-0 text-black fs-5">{{ $name }}</h3>
                                        </div>
                                        <!-- Count Badge -->
                                        <span
                                            class="badge bg-light text-dark rounded-pill px-3 py-2 fs-2">{{ $data['count'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>


<script>
    function generateStrongPassword(length = 12) {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-={}[]<>?";
        let password = "";
        for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return password;
    }

    // slider change → label update
    $('#passwordLength').on('input', function() {
        $('#pwdLengthLabel').text($(this).val());
    });

    // generate password
    $('#generatePassword').on('click', function() {
        const length = $('#passwordLength').val();
        $('#password').val(generateStrongPassword(length));
    });


    // document.getElementById('generatePassword').addEventListener('click', function() {
    //     const passwordInput = document.getElementById('password');
    //     passwordInput.value = generateStrongPassword(12);
    // });


    $('.edit').on('click', function() {
        const id = $(this).data('id');
        const sitename = $(this).data('sitename');
        const username = $(this).data('username');
        const password = $(this).data('password');

        $('#sitename').val(sitename);
        $('#username').val(username);
        $('#password').val(password);

        // route('front.update', $single_user - > id)

        $('#managerForm').attr('action', '/update/' + id);

        $('#submitBtn').text('Update');

        $('#staticBackdrop').modal('show');
    });
</script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('front.ajaxSearch') }}",
                type: "GET",
                data: {
                    search: query
                },
                success: function(data) {
                    // replace table tbody with new data
                    $('#userTable table tbody').html(data);
                }
            });
        });
    });
</script>
