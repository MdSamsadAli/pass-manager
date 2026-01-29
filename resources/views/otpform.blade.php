<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">OTP Verification</h2>

        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
            @csrf

            <p class="text-gray-600 text-center">Enter the 6-digit OTP sent to your email</p>

            <div class="flex justify-between space-x-2">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                @endfor
            </div>

            <input type="hidden" name="otp" id="otp">

            <!-- Error -->
            @error('otp')
                <p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn btn-primary mt-3 w-full">
                Verify OTP
            </button>
        </form>
    </div>

    {{-- <script>
        const inputs = document.querySelectorAll('input[name^="otp"]');
        inputs.forEach((input, i) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && i < inputs.length - 1) {
                    inputs[i + 1].focus();
                }
            });
        });
    </script> --}}

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenOtp = document.getElementById('otp');

        function updateOtpValue() {
            hiddenOtp.value = Array.from(inputs).map(i => i.value).join('');
        }

        inputs.forEach((input, index) => {

            // When typing
            input.addEventListener('input', (e) => {
                input.value = input.value.replace(/\D/g, ''); // numbers only

                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                updateOtpValue();
            });

            // When pressing backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Paste support
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').replace(/\D/g, '');

                pasteData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });

                updateOtpValue();
                inputs[Math.min(pasteData.length, inputs.length) - 1]?.focus();
            });
        });
    </script>


</x-guest-layout>
