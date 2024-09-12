<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat Bot') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto h-full sm:px-6 lg:px-8">
            <div id="chat-container"
                class="relative bg-gray-100 dark:bg-gray-900 p-4 rounded-lg h-[30rem] lg:h-[46rem] overflow-y-scroll mb-4">
            </div>

            <form class="max-w mx-auto" id="chat-form" action="{{ route('chat.chat') }}" method="POST">
                <label for="chat" class="sr-only">Your message</label>
                <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <button type="button"
                        class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 18">
                            <path fill="currentColor"
                                d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
                        </svg>
                        <span class="sr-only">Upload image</span>
                    </button>
                    <button type="button"
                        class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.408 7.5h.01m-6.876 0h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM4.6 11a5.5 5.5 0 0 0 10.81 0H4.6Z" />
                        </svg>
                        <span class="sr-only">Add emoji</span>
                    </button>
                    <textarea id="message" name="message" rows="1"
                        class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none"
                        placeholder="Your message..."></textarea>
                    <button type="submit"
                        class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                        <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                        </svg>
                        <span class="sr-only">Send message</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script type="module">
        $(document).ready(function() {
            const textarea = document.getElementById('message');

            textarea.addEventListener('input', function() {
                const minRows = 1;
                const maxRows = 10;

                if (this.value.trim() === '') {
                    this.rows = minRows;
                } else {
                    // Hitung perkiraan jumlah baris
                    const estimatedRows = Math.ceil(this.value.length / 100);
                    this.rows = Math.min(Math.max(estimatedRows, minRows), maxRows);
                }
            });

            // Fungsi regex HTML
            function processText(text) {
                // Mengganti triple backticks dengan tag <pre><code> untuk blok kode
                text = text.replace(/```([^```]+)```/g, function(match, p1) {
                // Menghindari XSS dengan meloloskan karakter HTML
                const escapedCode = p1.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                return `<pre><code>${escapedCode}</code></pre>`;
            });
            // Menangani simbol * di awal kalimat sebagai list
            text = text.replace(/(?:\n|^)\*\s+/g, '<li>').replace(/<\/li>\s*<li>/g, '');
            // Menangani simbol * untuk bold atau penekanan
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Menghapus <li> tanpa pasangan dan membungkus dengan <ul> jika ada
            if (text.includes('<li>')) {
                text = '<ul>' + text + '</ul>';
            }
            // Mengganti newline dengan <br> dan membersihkan <br> ganda
            text = text.replace(/\n/g, '<br>');
            return text;
        }

        // Disable atau enable form elements
        function toggleFormElements(disable = true) {
            $('#chat-form textarea[id="message"]').prop('disabled',
                disable);
            $('#chat-form button[type="submit"]').prop('disabled',
                disable);
        }

        // Menambahkan event listener untuk Enter
        $('#message').on('keypress', function(e) {
            if (e.which == 13 && !e.shiftKey) { // Mengecek jika tombol Enter ditekan tanpa Shift
                $('#chat-form').submit(); // Men-submit form
                e.preventDefault(); // Mencegah line break
            }
        });

        // Disable Enter key ketika form is processing
        $('#chat-form').on('keypress', function(e) {
            if (e.which == 13 && $('#chat-form button[type="submit"]').prop('disabled')) {
                e.preventDefault(); // Prevent form submit on Enter key
            }
        });

        $('#chat-form').on('submit', function(e) {
            e.preventDefault();

            var message = $('#message').val();

            // Disable form elements
            toggleFormElements(true);

            // Menampilkan animasi loading
            $('#chat-container').append(
                `<div id="loading" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <div role="status">
                                        <svg aria-hidden="true"
                                            class="inline w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill" />
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span class="animate-pulse font-medium text-yellow-400">Loading</span>
                                </div>
                            </div>`
            );

            $.ajax({
                url: "{{ route('chat.chat') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    message: message
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    // Hapus animasi loading
                    $('#loading').remove();
                    textarea.rows = 1;

                    // HTML untuk pesan pengguna
                    var userMessage = `<div class="flex justify-start space-x-2 mb-4">
                                    <div class="h-10 w-10">
                                        <div class="h-full w-full bg-gray-400 rounded-full border"></div>
                                    </div>
                                    <div
                                        class="bg-blue-500 text-white p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg max-w-5xl min-w-3xl break-words">
                                        <strong class="block text-sm">Guest</strong> <span class="text-sm">${message}</span>
                                    </div>
                                </div>
                                `;

                    // Cek apakah response.reply ada dan merupakan string
                    var botReplyText = response && typeof response ===
                        'string' ?
                        processText(response) :
                        'Tidak ada respons dari bot.';

                    // HTML untuk respons bot
                    var botResponse =
                        `
                                    <div class="flex justify-end space-x-2 mb-4">
                                        <div
                                            class="bg-gray-700 text-white p-3 rounded-tl-lg rounded-bl-lg rounded-br-lg max-w-5xl min-w-3xl break-words">
                                            <strong class="block text-sm">GM Setiawan</strong> <span class="text-sm">${botReplyText}</span>
                                        </div>
                                        <div class="h-10 w-10 rounded-full border overflow-hidden">
                                            <img src="https://avatars.githubusercontent.com/u/8079924?v=4"
                                                class="object-fill">
                                        </div>
                                    </div>
                                `;

                    // Append pesan ke chat container
                    $('#chat-container').append(userMessage + botResponse);

                    // Clear input message dan scroll ke bawah
                    $('#message').val('');
                    $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);

                    // Enable form elements after process is complete
                    toggleFormElements(false);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);

                    // Hapus animasi loading
                    $('#loading').remove();

                    // Tampilkan pesan error di chat container
                    var errorMessage =
                        `<div class="flex justify-end mb-4 text-red-500">
                                        <div class="bg-red-700 text-white p-3 rounded-lg max-w-xs break-words">
                                            <strong>Error:</strong> Terjadi kesalahan pada server.
                                        </div>
                                    </div>`;
                        $('#chat-container').append(errorMessage);
                    }
                });
            });
        });
    </script>
</x-app-layout>
