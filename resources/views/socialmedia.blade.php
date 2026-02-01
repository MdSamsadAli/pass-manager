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
                                        <h4 class="m-0">Social Media</h4>
                                    </div>


                                    <div class="d-flex gap-2">
                                        {{-- <a href="javascript:(function(){var s=document.createElement('script');s.src='{{ url('/autofill-helper') }}?t='+(new Date().getTime());document.head.appendChild(s);setTimeout(function(){window.open('{{ url('/bookmarklet') }}?site='+encodeURIComponent(location.hostname),'MyVault','width=450,height=650,scrollbars=yes,resizable=yes');},300);})();"
                                            class="btn btn-dark" title="Drag to bookmarks bar">
                                            🔐 MyVault Autofill
                                        </a> --}}
                                        <div class="search-data">
                                            <input type="search" class="form-control" id="searchInput"
                                                placeholder="Search here...">
                                        </div>
                                    </div>
                                </div>
                                <div class="items table-responsive" id="userTable">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">SNo.</th>
                                                <th scope="col">User Name or Email</th>
                                                <th scope="col">Site Name</th>
                                                <th scope="col">Password</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user_list as $key => $item)
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
                                            @endforeach

                                        </tbody>
                                    </table>
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


    <!-- Hidden form for browser autofill detection (CRITICAL FOR AUTOFILL) -->
    <div style="position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden;">
        <form id="hiddenLoginForm" autocomplete="on">
            <input type="url" id="hiddenSitename" name="sitename" autocomplete="url" tabindex="-1">
            <input type="email" id="hiddenUsername" name="username" autocomplete="username email" tabindex="-1">
            <input type="password" id="hiddenPassword" name="password" autocomplete="current-password" tabindex="-1">
        </form>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Password Generate</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form id="managerForm" action="{{ route('front.store') }}" method="POST" autocomplete="on">

                            @csrf
                            <input type="hidden" name="login" value="true">
                            <div class="form shadow-sm p-4">

                                <div class="mb-3">
                                    <label for="sitename" class="form-label">Site Name</label>
                                    <input type="text" class="form-control" id="sitename"
                                        placeholder="https://example.com" name="sitename"
                                        value="{{ old('sitename', @$single_user->sitename ?? '') }}"
                                        autocomplete="url">
                                    @error('sitename')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="username" class="form-label">User Name or Email</label>
                                    <input type="email" class="form-control" id="username"
                                        placeholder="Enter User Name or Email" name="username"
                                        value="{{ old('username', @$single_user->username ?? '') }}"
                                        autocomplete="username email">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" placeholder="Enter your password" class="form-control"
                                            name="password" id="password" value="{{ old('password', '' ?? '') }}"
                                            autocomplete="current-password new-password">
                                        <span class="password-toggle"
                                            style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                                            <i class="fa fa-eye-slash" id="togglePassword"></i>
                                        </span>

                                        <button type="button" class="btn btn-sm btn-secondary position-absolute"
                                            style="right:50px; top:50%; transform:translateY(-50%)"
                                            id="generatePassword">
                                            Generate
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Password Length: <strong><span id="pwdLengthLabel">12</span></strong>
                                    </label>

                                    <input type="range" class="form-range" id="passwordLength" min="6"
                                        max="32" step="1" value="12">
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


<script>
    function generateStrongPassword(length = 12) {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-={}[]<>?";
        let password = "";
        for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return password;
    }

    $(document).ready(function() {
        // ============================================
        // AUTOFILL FUNCTIONALITY - START
        // ============================================

        // Sync hidden form values to modal when browser autofills them
        setInterval(function() {
            var hiddenUsername = $('#hiddenUsername').val();
            var hiddenPassword = $('#hiddenPassword').val();
            var hiddenSitename = $('#hiddenSitename').val();

            // Only update if modal fields are empty
            if (hiddenUsername && !$('#username').val()) {
                $('#username').val(hiddenUsername);
            }
            if (hiddenPassword && !$('#password').val()) {
                $('#password').val(hiddenPassword);
            }
            if (hiddenSitename && !$('#sitename').val()) {
                $('#sitename').val(hiddenSitename);
            }
        }, 500);

        // Sync modal values back to hidden form (so browser can save them)
        $('#username, #password, #sitename').on('input change', function() {
            var id = $(this).attr('id');
            $('#hidden' + id.charAt(0).toUpperCase() + id.slice(1)).val($(this).val());
        });

        // Trigger autofill when modal opens
        $('#staticBackdrop').on('shown.bs.modal', function() {
            setTimeout(function() {
                // Focus and blur to trigger browser autofill
                $('#username').focus();
                setTimeout(function() {
                    $('#password').focus();
                    setTimeout(function() {
                        $('#sitename').focus().blur();
                    }, 50);
                }, 50);
            }, 100);
        });

        // Use Credential Management API if available (modern browsers)
        if (window.PasswordCredential) {
            $('#staticBackdrop').on('shown.bs.modal', function() {
                navigator.credentials.get({
                    password: true,
                    mediation: 'optional'
                }).then(function(credential) {
                    if (credential) {
                        $('#username').val(credential.id);
                        $('#password').val(credential.password);
                        if (credential.name) {
                            $('#sitename').val(credential.name);
                        }

                        // Also update hidden form
                        $('#hiddenUsername').val(credential.id);
                        $('#hiddenPassword').val(credential.password);
                        if (credential.name) {
                            $('#hiddenSitename').val(credential.name);
                        }
                    }
                }).catch(function(error) {
                    console.log('Credential API not available or user declined');
                });
            });

            // Store credentials after successful save
            $('#managerForm').on('submit', function(e) {
                var username = $('#username').val();
                var password = $('#password').val();
                var sitename = $('#sitename').val();

                if (username && password) {
                    var credential = new PasswordCredential({
                        id: username,
                        password: password,
                        name: sitename
                    });

                    navigator.credentials.store(credential).catch(function(err) {
                        console.log('Could not store credential');
                    });
                }
            });
        }

        // ============================================
        // AUTOFILL FUNCTIONALITY - END
        // ============================================

        // Slider change → label update
        $('#passwordLength').on('input', function() {
            $('#pwdLengthLabel').text($(this).val());
        });

        // Generate password
        $('#generatePassword').on('click', function() {
            const length = $('#passwordLength').val();
            const generatedPassword = generateStrongPassword(length);
            $('#password').val(generatedPassword);

            // Also update hidden form
            $('#hiddenPassword').val(generatedPassword);
        });

        // Reset form for new entry
        $('.fix-addbutton button').on('click', function() {
            $('#managerForm')[0].reset();
            $('#managerForm').attr('action', '{{ route('front.store') }}');
            $('#submitBtn').text('Submit');
            $('#passwordLength').val(12);
            $('#pwdLengthLabel').text('12');

            // Clear hidden form too
            $('#hiddenLoginForm')[0].reset();
        });

        // Edit button handler
        $(document).on('click', '.edit', function() {
            const id = $(this).data('id');
            const sitename = $(this).data('sitename');
            const username = $(this).data('username');
            const password = $(this).data('password');

            $('#sitename').val(sitename);
            $('#username').val(username);
            $('#password').val(password);

            // Also update hidden form
            $('#hiddenSitename').val(sitename);
            $('#hiddenUsername').val(username);
            $('#hiddenPassword').val(password);

            $('#managerForm').attr('action', '/update/' + id);
            $('#submitBtn').text('Update');

            $('#staticBackdrop').modal('show');
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('front.ajaxSearch') }}",
                type: "GET",
                data: {
                    search: query
                },
                success: function(data) {
                    $('#userTable table tbody').html(data);
                }
            });
        });

        // Toggle password visibility in table
        $(document).on('click', '.toggle-table-password', function() {
            var $this = $(this);
            var $pwdText = $this.siblings('.pwd-text');
            var actualPwd = $pwdText.data('pwd');

            if ($this.hasClass('fa-eye')) {
                $pwdText.text('********');
                $this.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $pwdText.text(actualPwd);
                $this.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Toggle password visibility in modal
        $('#togglePassword').on('click', function() {
            var passwordField = $('#password');
            var type = passwordField.attr('type');

            if (type === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    });
</script>
